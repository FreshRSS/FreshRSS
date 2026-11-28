# mcp-freshrss

Servidor MCP remoto, **somente leitura**, sobre o FreshRSS da RMSA.
Permite compartilhar o acervo de feeds com a equipe sem distribuir a senha da
API e sem criar um usuário FreshRSS por pessoa.

Construído e testado em 24/08/2026 contra o FreshRSS de produção.

## Desenho

| Decisão | Motivo |
|---|---|
| Somente leitura | No FreshRSS o estado lido/não lido pertence ao usuário. Se a equipe consultasse pela conta `admin` com permissão de escrita, marcar um item como lido afetaria todos — e quebraria a curadoria da newsletter, que filtra por não lidos. Sem operações de escrita no código, isso é impossível por construção. |
| Sem autenticação própria | Desenhado para rodar atrás do Cloudflare Access, que já provê OAuth gerenciado e política por identidade. Evita implementar OAuth 2.1. |
| Streamable HTTP stateless | O transporte HTTP+SSE foi descontinuado na especificação MCP 2026-07-28. Uma instância de transporte por requisição, sem sessão. |
| Busca varre por categoria | Ver "Limitações" abaixo. |

Verificação de leitura, feita em 24/08/2026: 25.040 itens não lidos antes de
~20 chamadas ao servidor, 25.040 depois. Repita esse teste após qualquer
alteração no código.

## Ferramentas

| Ferramenta | Função |
|---|---|
| `freshrss_listar_categorias` | Categorias disponíveis |
| `freshrss_listar_feeds` | Feeds assinados, com id, URL e categorias |
| `freshrss_buscar_itens` | Itens recentes de todo o acervo |
| `freshrss_itens_por_categoria` | Itens de uma categoria |
| `freshrss_itens_por_feed` | Itens de um feed |
| `freshrss_buscar_texto` | Busca por termo, global ou dirigida a uma categoria |
| `freshrss_estatisticas` | Contagens e distribuição de feeds |

Todas declaram `readOnlyHint: true` e `destructiveHint: false`.

## Instalação

```bash
# na VPS
cd /root/freshrss-stack
# copie a pasta mcp-freshrss para cá, depois:
cd mcp-freshrss
cp .env.example .env
$EDITOR .env          # preencha FRESHRSS_API_PASSWORD
cd /root/freshrss-stack
# acrescente o serviço de compose.snippet.yml ao compose.yml
docker compose up -d --build mcp-freshrss
docker compose logs -f mcp-freshrss
```

Teste interno, sem passar pelo túnel:

```bash
docker exec mcp-freshrss node -e "fetch('http://127.0.0.1:8080/health').then(r=>r.text()).then(console.log)"
```

## Exposição — leia antes de publicar

O servidor **não tem autenticação própria**. Publicar o subdomínio sem uma
camada de identidade na frente equivale a abrir o acervo para quem descobrir
a URL.

Ordem correta:

1. Suba o container. Sem rota no cloudflared. Teste internamente.
2. Configure o provedor de identidade no Cloudflare Zero Trust.
3. Crie o MCP server portal apontando para `http://mcp-freshrss:8080/mcp`,
   com política restrita aos e-mails da equipe.
4. Só então adicione a rota no cloudflared.

Se precisar testar pelo túnel antes do passo 2, defina `MCP_BEARER_TOKEN` no
`.env`. É uma medida provisória: token compartilhado não identifica pessoa e
não permite revogar acesso individual. Esvazie a variável quando o Access
estiver ativo.

## Restringir o acervo

`CATEGORIAS_PERMITIDAS` no `.env` aceita uma lista separada por vírgula. Vazio
significa acervo completo. Os nomes precisam bater exatamente com os do
FreshRSS, emoji incluído — use `freshrss_listar_categorias` para obtê-los.

O filtro é aplicado no servidor e vale para todas as ferramentas: uma categoria
fora da lista não aparece na listagem, não pode ser consultada diretamente e
seus itens não entram nas buscas.

## Limitações

**Busca.** O FreshRSS não implementa busca na API Google Reader — o parâmetro
`q` é aceito e ignorado silenciosamente (verificado em 24/08/2026). A filtragem
acontece no servidor MCP, sobre uma janela de itens recentes, e portanto não
alcança o acervo histórico completo.

A varredura percorre categoria por categoria, não a lista global. Num acervo
com feeds de alto volume — portais de notícia geral — varrer a lista global
gasta todo o orçamento nas últimas horas do feed mais movimentado e nunca
alcança o conteúdo temático. Foi exatamente o que ocorreu na primeira versão:
uma busca por "ANPD" nos últimos 7 dias não retornava nada, embora houvesse
matéria relevante no período. Distribuir a varredura entre categorias resolveu.

Para busca profunda, informe `categoria` — concentra o orçamento num recorte só.

**Datas.** Feeds agregadores como o Google News republicam matérias com data de
publicação antiga. O parâmetro `ot` da API filtra por um carimbo que nem sempre
corresponde à data exibida, então o recorte por dias é reaplicado no servidor
sobre a data de publicação, para que "últimos N dias" signifique o que diz.

## Variáveis de ambiente

| Variável | Obrigatória | Padrão | Descrição |
|---|---|---|---|
| `FRESHRSS_URL` | sim | — | URL base, sem barra final |
| `FRESHRSS_USER` | sim | — | Usuário do FreshRSS |
| `FRESHRSS_API_PASSWORD` | sim | — | Senha de API, não a do painel |
| `PORT` | não | `8080` | Porta interna |
| `ALLOWED_HOSTS` | não | `localhost,127.0.0.1` | Hosts aceitos (anti DNS rebinding) |
| `CATEGORIAS_PERMITIDAS` | não | vazio | Filtro de acervo |
| `MAX_ITENS` | não | `50` | Teto de itens por resposta |
| `VARREDURA_BUSCA` | não | `400` | Itens examinados na busca |
| `MCP_BEARER_TOKEN` | não | vazio | Token provisório, pré-Access |
