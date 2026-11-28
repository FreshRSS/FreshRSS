/**
 * As sete ferramentas read-only expostas pelo servidor.
 *
 * Todas declaram readOnlyHint: true e destructiveHint: false. Nenhuma delas
 * tem caminho de código capaz de alterar estado no FreshRSS.
 */

import { z } from 'zod';
import type { McpServer } from '@modelcontextprotocol/server';
import * as fr from './freshrss.js';
import { config } from './config.js';

const ANOTACOES_LEITURA = {
  readOnlyHint: true,
  destructiveHint: false,
  idempotentHint: true,
  openWorldHint: false,
} as const;

const itemSchema = z.object({
  id: z.string(),
  titulo: z.string(),
  link: z.string(),
  fonte: z.string(),
  categoria: z.string(),
  publicado: z.string(),
  publicado_ts: z.number(),
  resumo: z.string(),
});

const listaItensSchema = z.object({
  total: z.number(),
  itens: z.array(itemSchema),
  observacao: z.string().optional(),
});

const limiteSchema = z
  .number()
  .int()
  .min(1)
  .max(config.maxItens)
  .default(20)
  .describe(`Quantidade de itens a retornar (1 a ${config.maxItens}).`);

const diasSchema = z
  .number()
  .int()
  .min(1)
  .max(90)
  .optional()
  .describe('Janela em dias a partir de hoje. Omitido, retorna os mais recentes sem recorte.');

/** Converte erro em resposta acionável, sem derrubar a conexão. */
async function executar<T>(fn: () => Promise<T>, formatar: (r: T) => { texto: string; dados: unknown }) {
  try {
    const r = await fn();
    const { texto, dados } = formatar(r);
    return { content: [{ type: 'text' as const, text: texto }], structuredContent: dados as never };
  } catch (e) {
    const msg = e instanceof Error ? e.message : String(e);
    return { content: [{ type: 'text' as const, text: `Erro: ${msg}` }], isError: true };
  }
}

function resumirItens(itens: fr.Item[]) {
  const observacao = config.categoriasPermitidas
    ? 'O acervo está restrito a um subconjunto de categorias definido pelo administrador.'
    : undefined;
  const dados = { total: itens.length, itens, ...(observacao ? { observacao } : {}) };
  const texto =
    itens.length === 0
      ? 'Nenhum item encontrado para os critérios informados.'
      : itens.map((i) => `[${i.publicado.slice(0, 16)}] ${i.fonte} — ${i.titulo}\n${i.link}`).join('\n\n');
  return { texto, dados };
}

export function registrarFerramentas(server: McpServer): void {
  server.registerTool(
    'freshrss_listar_categorias',
    {
      title: 'Listar categorias',
      description:
        'Lista as categorias (pastas) de feeds disponíveis no acervo. ' +
        'Use antes de consultar por categoria — os nomes incluem emoji e precisam ser usados exatamente como retornados.',
      inputSchema: z.object({}),
      outputSchema: z.object({
        total: z.number(),
        categorias: z.array(z.object({ id: z.string(), nome: z.string() })),
      }),
      annotations: ANOTACOES_LEITURA,
    },
    async () =>
      executar(fr.listarCategorias, (cats) => ({
        texto:
          cats.length === 0
            ? 'Nenhuma categoria disponível.'
            : cats.map((c) => `- ${c.nome}`).join('\n'),
        dados: { total: cats.length, categorias: cats },
      }))
  );

  server.registerTool(
    'freshrss_listar_feeds',
    {
      title: 'Listar feeds',
      description: 'Lista os feeds assinados, com identificador, URL e categorias a que pertencem.',
      inputSchema: z.object({
        categoria: z.string().optional().describe('Filtra os feeds de uma categoria específica.'),
      }),
      outputSchema: z.object({
        total: z.number(),
        feeds: z.array(
          z.object({
            id: z.string(),
            titulo: z.string(),
            url: z.string(),
            categorias: z.array(z.string()),
          })
        ),
      }),
      annotations: ANOTACOES_LEITURA,
    },
    async ({ categoria }) =>
      executar(
        async () => {
          const feeds = await fr.listarFeeds();
          return categoria ? feeds.filter((f) => f.categorias.includes(categoria)) : feeds;
        },
        (feeds) => ({
          texto:
            feeds.length === 0
              ? 'Nenhum feed encontrado.'
              : feeds.map((f) => `- ${f.titulo} (${f.id}) — ${f.categorias.join(', ')}`).join('\n'),
          dados: { total: feeds.length, feeds },
        })
      )
  );

  server.registerTool(
    'freshrss_buscar_itens',
    {
      title: 'Buscar itens recentes',
      description:
        'Retorna os itens mais recentes de todo o acervo, opcionalmente limitados a uma janela de dias. ' +
        'Para recortar por tema, prefira freshrss_itens_por_categoria.',
      inputSchema: z.object({ limite: limiteSchema, dias: diasSchema }),
      outputSchema: listaItensSchema,
      annotations: ANOTACOES_LEITURA,
    },
    async ({ limite, dias }) => executar(() => fr.itensRecentes(limite, dias), resumirItens)
  );

  server.registerTool(
    'freshrss_itens_por_categoria',
    {
      title: 'Itens de uma categoria',
      description:
        'Retorna os itens de uma categoria específica. O nome deve corresponder exatamente ao retornado ' +
        'por freshrss_listar_categorias, emoji incluído.',
      inputSchema: z.object({
        categoria: z.string().describe('Nome exato da categoria, como retornado por freshrss_listar_categorias.'),
        limite: limiteSchema,
        dias: diasSchema,
      }),
      outputSchema: listaItensSchema,
      annotations: ANOTACOES_LEITURA,
    },
    async ({ categoria, limite, dias }) =>
      executar(() => fr.itensPorCategoria(categoria, limite, dias), resumirItens)
  );

  server.registerTool(
    'freshrss_itens_por_feed',
    {
      title: 'Itens de um feed',
      description:
        'Retorna os itens de um feed específico. Obtenha o identificador com freshrss_listar_feeds.',
      inputSchema: z.object({
        feed_id: z.string().describe('Identificador do feed, no formato "feed/123".'),
        limite: limiteSchema,
        dias: diasSchema,
      }),
      outputSchema: listaItensSchema,
      annotations: ANOTACOES_LEITURA,
    },
    async ({ feed_id, limite, dias }) =>
      executar(() => fr.itensPorFeed(feed_id, limite, dias), resumirItens)
  );

  server.registerTool(
    'freshrss_buscar_texto',
    {
      title: 'Busca textual',
      description:
        'Procura um termo no título e no resumo dos itens. ' +
        'Atenção: o FreshRSS não oferece busca via API, então a varredura ocorre sobre uma janela recente — ' +
        'não sobre o acervo histórico completo. Aumente "dias" para ampliar o alcance.',
      inputSchema: z.object({
        termo: z.string().min(2).describe('Termo a procurar. Busca simples por substring, sem operadores.'),
        categoria: z
          .string()
          .optional()
          .describe('Restringe a busca a uma categoria. Torna a varredura mais rápida e mais profunda.'),
        limite: limiteSchema,
        dias: z.number().int().min(1).max(90).default(14).describe('Janela varrida, em dias.'),
      }),
      outputSchema: listaItensSchema.extend({ varridos: z.number(), categorias_varridas: z.number() }),
      annotations: ANOTACOES_LEITURA,
    },
    async ({ termo, categoria, limite, dias }) =>
      executar(
        () => fr.buscarTexto(termo, limite, dias, categoria),
        ({ itens, varridos, categorias_varridas }) => {
          const r = resumirItens(itens);
          const nota = `Varridos ${varridos} itens em ${categorias_varridas} categoria(s), últimos ${dias} dias.`;
          return {
            texto:
              itens.length === 0
                ? `Nenhum item com "${termo}". ${nota} Ampliar "dias" ou indicar "categoria" aumenta o alcance.`
                : `${r.texto}\n\n(${nota})`,
            dados: { ...r.dados, varridos, categorias_varridas },
          };
        }
      )
  );

  server.registerTool(
    'freshrss_estatisticas',
    {
      title: 'Estatísticas do acervo',
      description: 'Contagem de feeds e categorias disponíveis, com distribuição de feeds por categoria.',
      inputSchema: z.object({}),
      outputSchema: z.object({
        total_feeds: z.number(),
        total_categorias: z.number(),
        feeds_por_categoria: z.array(z.object({ categoria: z.string(), feeds: z.number() })),
      }),
      annotations: ANOTACOES_LEITURA,
    },
    async () =>
      executar(fr.estatisticas, (e) => ({
        texto:
          `${e.total_feeds} feeds em ${e.total_categorias} categorias.\n\n` +
          e.feeds_por_categoria.map((c) => `- ${c.categoria}: ${c.feeds}`).join('\n'),
        dados: e,
      }))
  );
}
