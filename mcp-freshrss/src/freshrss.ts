/**
 * Cliente da API Google Reader do FreshRSS.
 *
 * SOMENTE LEITURA. Este módulo não implementa nenhuma operação que altere
 * estado no FreshRSS — nem marcar como lido (edit-tag), nem assinar ou
 * remover feeds. Essa restrição é a garantia de que o uso pela equipe não
 * interfere no estado de lido/não lido da conta, do qual dependem as
 * automações de curadoria.
 */

import { config } from './config.js';

const LABEL_PREFIX = 'user/-/label/';
const READING_LIST = 'user/-/state/com.google/reading-list';

export interface Item {
  id: string;
  titulo: string;
  link: string;
  fonte: string;
  categoria: string;
  publicado: string;
  publicado_ts: number;
  resumo: string;
}

export interface Categoria {
  id: string;
  nome: string;
}

export interface Feed {
  id: string;
  titulo: string;
  url: string;
  categorias: string[];
}

/** Erro com mensagem acionável para o modelo. */
export class FreshRSSError extends Error {
  constructor(message: string) {
    super(message);
    this.name = 'FreshRSSError';
  }
}

let tokenCache: { token: string; obtidoEm: number } | null = null;
const TOKEN_TTL_MS = 20 * 60 * 1000;

async function autenticar(forcar = false): Promise<string> {
  if (!forcar && tokenCache && Date.now() - tokenCache.obtidoEm < TOKEN_TTL_MS) {
    return tokenCache.token;
  }

  const url =
    `${config.freshrssUrl}/api/greader.php/accounts/ClientLogin` +
    `?Email=${encodeURIComponent(config.freshrssUser)}` +
    `&Passwd=${encodeURIComponent(config.freshrssApiPassword)}`;

  const resp = await fetch(url, { method: 'GET' });
  if (!resp.ok) {
    throw new FreshRSSError(
      `Falha ao autenticar no FreshRSS (HTTP ${resp.status}). ` +
        `Verifique FRESHRSS_URL, FRESHRSS_USER e FRESHRSS_API_PASSWORD. ` +
        `Lembre-se: é a senha de API, não a senha do painel.`
    );
  }

  const texto = await resp.text();
  const linha = texto.split('\n').find((l) => l.startsWith('Auth='));
  if (!linha) {
    throw new FreshRSSError(
      'O FreshRSS respondeu à autenticação mas não devolveu token. ' +
        'Confirme que a API está habilitada em Configurações → Autenticação → "Permitir acesso à API".'
    );
  }

  const token = linha.slice(5).trim();
  tokenCache = { token, obtidoEm: Date.now() };
  return token;
}

async function apiGet<T>(caminho: string, params: Record<string, string | number> = {}): Promise<T> {
  const executar = async (token: string) => {
    const url = new URL(`${config.freshrssUrl}/api/greader.php/reader/api/0/${caminho}`);
    url.searchParams.set('output', 'json');
    for (const [k, v] of Object.entries(params)) url.searchParams.set(k, String(v));

    return fetch(url.toString(), {
      headers: { Authorization: `GoogleLogin auth=${token}` },
    });
  };

  let resp = await executar(await autenticar());

  // Token expirado: reautentica uma vez, de forma transparente.
  if (resp.status === 401 || resp.status === 403) {
    resp = await executar(await autenticar(true));
  }

  if (!resp.ok) {
    throw new FreshRSSError(
      `O FreshRSS recusou a consulta a "${caminho}" (HTTP ${resp.status}).`
    );
  }

  return (await resp.json()) as T;
}

/** Aplica o filtro de acervo definido em CATEGORIAS_PERMITIDAS. */
export function categoriaPermitida(nome: string): boolean {
  if (!config.categoriasPermitidas) return true;
  return config.categoriasPermitidas.includes(nome);
}

function nomeDaLabel(id: string): string {
  return id.startsWith(LABEL_PREFIX) ? id.slice(LABEL_PREFIX.length) : id;
}

export async function listarCategorias(): Promise<Categoria[]> {
  const d = await apiGet<{ tags: { id: string }[] }>('tag/list');
  return (d.tags ?? [])
    .filter((t) => t.id.startsWith(LABEL_PREFIX))
    .map((t) => ({ id: t.id, nome: nomeDaLabel(t.id) }))
    .filter((c) => categoriaPermitida(c.nome));
}

export async function listarFeeds(): Promise<Feed[]> {
  const d = await apiGet<{
    subscriptions: { id: string; title: string; url: string; categories?: { label?: string }[] }[];
  }>('subscription/list');

  return (d.subscriptions ?? [])
    .map((s) => ({
      id: s.id,
      titulo: s.title,
      url: s.url,
      categorias: (s.categories ?? []).map((c) => c.label ?? '').filter(Boolean),
    }))
    .filter((f) => f.categorias.length === 0 || f.categorias.some(categoriaPermitida));
}

interface StreamItemBruto {
  id?: string;
  title?: string;
  published?: number;
  origin?: { title?: string; streamId?: string };
  alternate?: { href?: string }[];
  canonical?: { href?: string }[];
  categories?: (string | { label?: string })[];
  summary?: { content?: string };
  content?: { content?: string };
}

function limparHtml(s: string): string {
  return s
    .replace(/<[^>]+>/g, ' ')
    .replace(/&nbsp;/g, ' ')
    .replace(/&amp;/g, '&')
    .replace(/&lt;/g, '<')
    .replace(/&gt;/g, '>')
    .replace(/&quot;/g, '"')
    .replace(/&#39;/g, "'")
    .replace(/\s+/g, ' ')
    .trim();
}

function normalizar(it: StreamItemBruto): Item {
  const cats = (it.categories ?? [])
    .map((c) => (typeof c === 'string' ? (c.includes('/label/') ? c.split('/label/').pop()! : '') : c.label ?? ''))
    .filter(Boolean);

  const ts = Number(it.published ?? 0);
  const bruto = it.summary?.content ?? it.content?.content ?? '';

  return {
    id: it.id ?? '',
    titulo: limparHtml(it.title ?? ''),
    link: it.alternate?.[0]?.href ?? it.canonical?.[0]?.href ?? '',
    fonte: it.origin?.title ?? '',
    categoria: cats[0] ?? '',
    publicado: ts ? new Date(ts * 1000).toISOString() : '',
    publicado_ts: ts,
    resumo: limparHtml(bruto).slice(0, 500),
  };
}

/**
 * Lê um stream, paginando até `varrer` itens.
 *
 * O parâmetro `ot` da API filtra pelo tempo que o FreshRSS atribui ao item,
 * que nem sempre corresponde à data de publicação exibida — feeds agregadores
 * (Google News, por exemplo) republicam matérias com `published` antigo. Por
 * isso, quando há recorte temporal, ele é reaplicado aqui sobre `publicado_ts`,
 * para que "últimos N dias" signifique de fato os últimos N dias.
 */
async function buscarStream(
  streamId: string,
  limite: number,
  desdeTs?: number,
  varrer = 0
): Promise<Item[]> {
  const alvoVarredura = Math.max(varrer, Math.min(limite, config.maxItens));
  const coletados: Item[] = [];
  let continuation: string | undefined;

  while (coletados.length < alvoVarredura) {
    const params: Record<string, string | number> = {
      n: Math.min(100, alvoVarredura - coletados.length),
    };
    if (desdeTs) params.ot = desdeTs;
    if (continuation) params.c = continuation;

    const d = await apiGet<{ items?: StreamItemBruto[]; continuation?: string }>(
      `stream/contents/${encodeURIComponent(streamId)}`,
      params
    );

    const lote = (d.items ?? []).map(normalizar);
    coletados.push(...lote);

    if (!d.continuation || lote.length === 0) break;
    continuation = d.continuation;
  }

  const noPeriodo = desdeTs
    ? coletados.filter((i) => i.publicado_ts >= desdeTs)
    : coletados;

  return noPeriodo.slice(0, limite);
}

/**
 * Se houver filtro de acervo, remove itens cuja categoria não está liberada.
 * Itens sem categoria identificada são descartados quando o filtro está ativo,
 * por precaução — é preferível omitir a vazar.
 */
function filtrarItens(itens: Item[]): Item[] {
  if (!config.categoriasPermitidas) return itens;
  return itens.filter((i) => i.categoria && categoriaPermitida(i.categoria));
}

export async function itensRecentes(limite: number, dias?: number): Promise<Item[]> {
  const desde = dias ? Math.floor(Date.now() / 1000) - dias * 86400 : undefined;
  return filtrarItens(await buscarStream(READING_LIST, limite, desde));
}

export async function itensPorCategoria(nome: string, limite: number, dias?: number): Promise<Item[]> {
  // Valida contra a lista REAL do servidor, não apenas contra o filtro de acervo.
  // Sem isso, um nome de categoria errado ou defasado devolveria lista vazia
  // silenciosamente — o modo de falha mais difícil de diagnosticar.
  const disponiveis = await listarCategorias();
  if (!disponiveis.some((c) => c.nome === nome)) {
    throw new FreshRSSError(
      `Categoria "${nome}" não existe ou não está acessível. ` +
        `Categorias disponíveis: ${disponiveis.map((c) => c.nome).join(' | ')}`
    );
  }
  const desde = dias ? Math.floor(Date.now() / 1000) - dias * 86400 : undefined;
  return buscarStream(`${LABEL_PREFIX}${nome}`, limite, desde);
}

export async function itensPorFeed(feedId: string, limite: number, dias?: number): Promise<Item[]> {
  const feeds = await listarFeeds();
  if (!feeds.some((f) => f.id === feedId)) {
    throw new FreshRSSError(
      `Feed "${feedId}" não encontrado ou fora do acervo disponível. ` +
        `Use freshrss_listar_feeds para obter os identificadores válidos.`
    );
  }
  const desde = dias ? Math.floor(Date.now() / 1000) - dias * 86400 : undefined;
  return filtrarItens(await buscarStream(feedId, limite, desde));
}

/**
 * Busca textual.
 *
 * LIMITAÇÃO CONHECIDA: o FreshRSS não expõe endpoint de busca na API Google
 * Reader. A busca é feita aqui, sobre uma janela recente de itens. Ela
 * portanto não alcança o acervo histórico completo — apenas o período
 * varrido. O parâmetro `dias` controla essa janela.
 */
/**
 * Busca textual.
 *
 * LIMITAÇÃO ESTRUTURAL: o FreshRSS não implementa busca na API Google Reader —
 * o parâmetro `q` é aceito e ignorado silenciosamente (verificado em 24/08/2026).
 * A filtragem é feita aqui.
 *
 * A varredura percorre CATEGORIA POR CATEGORIA, não a lista global. Num acervo
 * com feeds de alto volume (portais de notícia geral), varrer a lista global
 * gasta todo o orçamento nas últimas horas do feed mais movimentado e nunca
 * alcança o conteúdo temático. Distribuir a varredura entre categorias dá
 * cobertura muito melhor pelo mesmo custo.
 *
 * Informe `categoria` para uma busca dirigida — é mais rápida e mais profunda.
 */
export async function buscarTexto(
  termo: string,
  limite: number,
  dias: number,
  categoria?: string
): Promise<{ itens: Item[]; varridos: number; categorias_varridas: number }> {
  const desde = Math.floor(Date.now() / 1000) - dias * 86400;
  const alvo = termo.toLowerCase();

  const cats = categoria ? [{ nome: categoria }] : await listarCategorias();
  if (categoria) {
    const existentes = await listarCategorias();
    if (!existentes.some((c) => c.nome === categoria)) {
      throw new FreshRSSError(
        `Categoria "${categoria}" não existe ou não está acessível. ` +
          `Categorias disponíveis: ${existentes.map((c) => c.nome).join(' | ')}`
      );
    }
  }

  const porCategoria = categoria
    ? config.varreduraBusca
    : Math.max(40, Math.ceil(config.varreduraBusca / Math.max(cats.length, 1)));

  const lotes = await Promise.all(
    cats.map(async (c) => {
      try {
        return await buscarStream(`${LABEL_PREFIX}${c.nome}`, porCategoria, desde, porCategoria);
      } catch {
        // Uma categoria que falhe não derruba a busca inteira.
        return [] as Item[];
      }
    })
  );

  const janela = lotes.flat();
  const achados = janela.filter(
    (i) => i.titulo.toLowerCase().includes(alvo) || i.resumo.toLowerCase().includes(alvo)
  );
  achados.sort((a, b) => b.publicado_ts - a.publicado_ts);

  return {
    itens: achados.slice(0, limite),
    varridos: janela.length,
    categorias_varridas: cats.length,
  };
}

export async function estatisticas(): Promise<{
  total_feeds: number;
  total_categorias: number;
  feeds_por_categoria: { categoria: string; feeds: number }[];
}> {
  const [cats, feeds] = await Promise.all([listarCategorias(), listarFeeds()]);
  const contagem = new Map<string, number>();
  for (const f of feeds) {
    for (const c of f.categorias) {
      if (categoriaPermitida(c)) contagem.set(c, (contagem.get(c) ?? 0) + 1);
    }
  }
  return {
    total_feeds: feeds.length,
    total_categorias: cats.length,
    feeds_por_categoria: [...contagem.entries()]
      .map(([categoria, feeds]) => ({ categoria, feeds }))
      .sort((a, b) => b.feeds - a.feeds),
  };
}
