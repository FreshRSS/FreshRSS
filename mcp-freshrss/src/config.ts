/**
 * Configuração do servidor, lida do ambiente.
 * Nenhum segredo deve ser hardcoded neste arquivo.
 */

function required(name: string): string {
  const v = process.env[name];
  if (!v) {
    throw new Error(
      `Variável de ambiente obrigatória ausente: ${name}. ` +
        `Defina-a no .env do container antes de iniciar o servidor.`
    );
  }
  return v;
}

function optionalList(name: string): string[] | null {
  const v = process.env[name];
  if (!v || !v.trim()) return null;
  return v
    .split(',')
    .map((s) => s.trim())
    .filter(Boolean);
}

export const config = {
  /** URL base do FreshRSS, sem barra final. Ex.: https://freshrss.rafaelmaciel.com.br */
  freshrssUrl: required('FRESHRSS_URL').replace(/\/+$/, ''),

  /** Usuário do FreshRSS. */
  freshrssUser: required('FRESHRSS_USER'),

  /**
   * SENHA DE API do FreshRSS (Configurações → Perfil → Gestão da API).
   * Não é a senha de login do painel.
   */
  freshrssApiPassword: required('FRESHRSS_API_PASSWORD'),

  /** Porta HTTP interna do container. */
  port: Number(process.env.PORT ?? 8080),

  /**
   * Hostnames aceitos no cabeçalho Host (proteção contra DNS rebinding).
   * Inclua o hostname público quando estiver atrás do túnel.
   */
  allowedHosts: optionalList('ALLOWED_HOSTS') ?? ['localhost', '127.0.0.1'],

  /**
   * PONTO DE FILTRO DO ACERVO.
   *
   * Vazio  = a equipe enxerga todas as categorias.
   * Lista  = a equipe enxerga apenas as categorias nomeadas.
   *
   * Os nomes devem bater exatamente com os rótulos do FreshRSS,
   * emoji incluído. Ex.:
   *   CATEGORIAS_PERMITIDAS="🔴 Autoridades de Proteção de Dados,🔴 Imprensa Jurídica"
   *
   * O filtro é aplicado no servidor, em TODAS as ferramentas: uma categoria
   * fora da lista não aparece na listagem, não pode ser consultada
   * diretamente e seus itens não entram em buscas.
   */
  categoriasPermitidas: optionalList('CATEGORIAS_PERMITIDAS'),

  /**
   * Token estático opcional (Authorization: Bearer <token>).
   *
   * MEDIDA PROVISÓRIA para o período anterior ao Cloudflare Access.
   * Token compartilhado não identifica pessoa e não permite revogação
   * individual. Remova assim que o Access estiver ativo.
   */
  bearerToken: process.env.MCP_BEARER_TOKEN ?? null,

  /** Teto de itens por chamada, para não estourar o contexto do modelo. */
  maxItens: Number(process.env.MAX_ITENS ?? 50),

  /**
   * Quantos itens a busca textual examina antes de filtrar.
   * Distinto de maxItens: este é o tamanho da varredura, aquele é o teto
   * da resposta. Num acervo movimentado, varrer pouco faz a busca não
   * encontrar nada e parecer que o assunto não existe.
   */
  varreduraBusca: Number(process.env.VARREDURA_BUSCA ?? 400),
};

export type Config = typeof config;
