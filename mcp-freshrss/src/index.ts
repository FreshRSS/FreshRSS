/**
 * mcp-freshrss — servidor MCP remoto, somente leitura, sobre o FreshRSS.
 *
 * Transporte: Streamable HTTP em modo stateless (uma instância de transporte
 * por requisição). O transporte HTTP+SSE foi descontinuado na especificação
 * 2026-07-28 e não é usado aqui.
 *
 * Autenticação: por padrão NENHUMA. Este servidor foi desenhado para rodar
 * atrás do Cloudflare Access, que cuida de identidade e política. Não exponha
 * a porta diretamente na internet.
 *
 * O token bearer opcional (MCP_BEARER_TOKEN) é uma medida provisória para o
 * período anterior à ativação do Access.
 */

import express from 'express';
import { createMcpExpressApp } from '@modelcontextprotocol/express';
import { NodeStreamableHTTPServerTransport } from '@modelcontextprotocol/node';
import { McpServer } from '@modelcontextprotocol/server';
import { config } from './config.js';
import { registrarFerramentas } from './tools.js';

const app = createMcpExpressApp({ allowedHosts: config.allowedHosts });
app.use(express.json({ limit: '1mb' }));

/** Verificação de token, quando configurado. */
app.use('/mcp', (req, res, next) => {
  if (!config.bearerToken) return next();
  const auth = req.header('authorization') ?? '';
  const enviado = auth.startsWith('Bearer ') ? auth.slice(7) : '';
  if (enviado !== config.bearerToken) {
    res.status(401).json({
      jsonrpc: '2.0',
      error: { code: -32001, message: 'Não autorizado.' },
      id: null,
    });
    return;
  }
  next();
});

app.post('/mcp', async (req, res) => {
  const server = new McpServer({ name: 'freshrss', version: '1.0.0' });
  registrarFerramentas(server);

  const transport = new NodeStreamableHTTPServerTransport({ sessionIdGenerator: undefined });
  res.on('close', () => {
    void transport.close();
    void server.close();
  });

  await server.connect(transport);
  await transport.handleRequest(req, res, req.body);
});

/** Health check para o Docker e para o túnel. Não exige autenticação. */
app.get('/health', (_req, res) => {
  res.json({
    ok: true,
    servidor: 'mcp-freshrss',
    somente_leitura: true,
    acervo_filtrado: Boolean(config.categoriasPermitidas),
  });
});

app.listen(config.port, '0.0.0.0', () => {
  const modo = config.bearerToken ? 'token bearer (provisório)' : 'sem auth própria — proteja com Cloudflare Access';
  console.log(`mcp-freshrss ouvindo em 0.0.0.0:${config.port} — ${modo}`);
  if (config.categoriasPermitidas) {
    console.log(`acervo restrito a ${config.categoriasPermitidas.length} categoria(s)`);
  } else {
    console.log('acervo completo visível — defina CATEGORIAS_PERMITIDAS para restringir');
  }
});
