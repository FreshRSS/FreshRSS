# MCP server

FreshRSS includes a small read-only MCP endpoint for remote clients such as Claude Web.

## Claude Web connector

Claude Web custom connectors connect from Anthropic's cloud infrastructure, so the FreshRSS URL must be reachable from the public internet over HTTPS.
See Anthropic's [custom connector documentation](https://support.claude.com/en/articles/11175166-get-started-with-custom-connectors-using-remote-mcp)
and the MCP [Streamable HTTP transport](https://modelcontextprotocol.io/specification/2025-11-25/basic/transports) specification.

Configure a long random token for one FreshRSS user. Either set environment variables:

```sh
FRESHRSS_MCP_USER=alice
FRESHRSS_MCP_TOKEN='change-this-long-random-token'
```

or add a `mcp_server` block in `data/config.php`:

```php
'mcp_server' => [
	'tokens' => [
		'alice' => 'change-this-long-random-token',
	],
],
```

Then add a custom connector in Claude Web with this URL:

```text
https://freshrss.example.net/api/mcp.php?token=change-this-long-random-token
```

If FreshRSS is installed with `/p/` visible in the URL, use:

```text
https://freshrss.example.net/p/api/mcp.php?token=change-this-long-random-token
```

The endpoint accepts `Authorization: Bearer ...` too, which is useful for MCP clients that can send custom headers.

## Tools

The MCP endpoint exposes only read-only tools:

* `freshrss.account_summary`
* `freshrss.list_feeds`
* `freshrss.list_articles`
* `freshrss.get_article`

## Security notes

The token grants read access to that user's FreshRSS articles through MCP. Store it like a password and rotate it if it appears in access logs or chat history.

For full per-user OAuth, run FreshRSS behind an OAuth-aware proxy or add an OAuth authorization server in front of the MCP endpoint.
