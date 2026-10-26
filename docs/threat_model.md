# FreshRSS threat model

FreshRSS is a self-hosted RSS/Atom reader. It supports web and API access, multiple users, optional anonymous reading, server-side feed fetching and scraping, sharing, import/export, WebSub, themes, extensions, and scheduled refresh jobs. Assess each issue against the feature involved, the attacker's role, and the instance's configuration. See the [project README](https://github.com/FreshRSS/FreshRSS/blob/edge/README.md) and the [English manual](https://freshrss.github.io/FreshRSS/en/).

## Trust boundaries and assets

| Boundary | Protect |
|---|---|
| Visitor → FreshRSS | Authentication, sessions, API authorization, and share-token checks; public endpoints must expose only intended data. |
| Authenticated user → another user or administrator | Enforce ownership and role checks so an authenticated user cannot access or modify another user's private feeds, articles, account settings, saved queries, tokens, or user-specific state without authorization. |
| Feed or imported file → FreshRSS | Safe parsing, HTML rendering, URL handling, file access, and resource limits. Treat feed content, redirects, response headers, and imports as untrusted. |
| FreshRSS → network, filesystem, and scheduled jobs | SSRF protections, credentials, `data/`, logs, backups, CLI/cron behavior, and file permissions. Report unsafe behavior caused by FreshRSS, not operator misconfiguration alone. |
| Source code → build and release | CI permissions, secrets, dependencies, release artifacts, and published container images. Report exploitable workflow or supply-chain vulnerabilities. |

The `data/` directory contains sensitive state and must not be web-accessible. Configure the web-server document root to FreshRSS's `p/` directory, not the repository root, so `p/` is not part of the public URL. Source files, configuration, logs, backups, and other data must not be downloadable. Installation and permission guidance is in the [installation manual](https://freshrss.github.io/FreshRSS/en/admins/03_Installation.html); backup contents and procedures are in the [backup guide](https://freshrss.github.io/FreshRSS/en/admins/05_Backup.html). The [repository code map](https://github.com/FreshRSS/FreshRSS/blob/edge/AGENTS.md) identifies the main controllers, views, API entry points, configuration files, and database access layers.

## Main attack surfaces

| Area | In scope |
|---|---|
| **Authentication and APIs** | Login or session bypass, weak token checks, missing ownership checks, user-to-admin escalation, and trust in spoofable proxy or OIDC identity headers. Test multi-user and anonymous modes separately, including the GReader API at `p/api/greader.php`. See [access control](https://freshrss.github.io/FreshRSS/en/admins/09_AccessControl.html), [user management](https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html), and [OpenID Connect](https://freshrss.github.io/FreshRSS/en/admins/16_OpenID-Connect.html). |
| **Feed fetching and WebSub** | SSRF through feed URLs, redirects, scraping or callbacks; access to protected destinations; leakage of outbound credentials; unsafe response-header handling; and retry behavior that lets one user disrupt another user's refresh. Include the public WebSub callback at `p/api/pshb.php`. Internal feeds are valid when permitted by the instance configuration. See [access control](https://freshrss.github.io/FreshRSS/en/admins/09_AccessControl.html), [website scraping](https://freshrss.github.io/FreshRSS/en/users/11_website_scraping.html), and [WebSub](https://freshrss.github.io/FreshRSS/en/users/WebSub.html). |
| **Feed content and browser UI** | Stored or reflected XSS, unsafe URL schemes, and **HTML injection**, even without JavaScript, when markup can spoof trusted UI, change links or forms, or mislead another user. Do not assume values are safe because they came from the database: most `VARCHAR`/`TEXT` fields are HTML-encoded, but JSON in `attributes` and its nested values is not. Check contextual escaping at every output. Test clickjacking and double-clickjacking against meaningful actions; safely escaped markup is not a finding. |
| **Shared caches and state** | Cache keys that omit settings affecting the result, such as website or proxy settings; one user's feed or proxy response poisoning shared favicon or presentation state; and untrusted status codes or `Retry-After` values causing unbounded delays or cross-user disruption. |
| **Sharing and import/export** | Private data exposed through share links or APIs; public OPML containing cookies, authorization headers, API keys, secret POST bodies, or credential-bearing proxy settings; import path traversal, unsafe overwrite, or cross-user data access. Public sharing must not disclose upstream credentials. See [user-query sharing](https://freshrss.github.io/FreshRSS/en/users/user_queries.html) and [subscriptions and import/export](https://freshrss.github.io/FreshRSS/en/users/04_Subscriptions.html). |
| **Themes, extensions, and paths** | Unauthorized extension installation or execution, writable code directories, path traversal, unsafe theme-name handling, and **path disclosure** (absolute paths, configuration locations, or clues about protected files). Assess whether the path helps access sensitive data or enables another exploit. See [extensions](https://freshrss.github.io/FreshRSS/en/admins/15_extensions.html) and [themes](https://freshrss.github.io/FreshRSS/en/admins/11_Themes.html). |
| **Parsing, database, and availability** | XML/JSON/HTML parser flaws, unsafe deserialization, oversized or hostile feeds, regex/XPath complexity, recursion, retry loops, and resource exhaustion from modest input. Check SQL injection and authorization-query differences in the DAO implementations for SQLite, PostgreSQL, and MySQL/MariaDB. Include CLI and cron paths as well as web requests. |
| **Docker, web root, and filesystem** | Unsafe shipped defaults or examples, entrypoint/cron environment handling, accidental secrets in build context or images, exposure of files outside the public `p/` tree, writable code/configuration, and proxy/auth settings that trust attacker-controlled values. Check that CLI jobs do not leave sensitive files with unsafe ownership or permissions; prefer running admin CLI tools as the web-server user or restoring permissions with `cli/access-permissions.sh`. A local operator's extra mounts or settings are not automatically FreshRSS vulnerabilities. See the [Docker deployment guide](https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/README.md), [web-server configuration](https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html), [system configuration](https://freshrss.github.io/FreshRSS/en/admins/17_configs_not_ui.html), and [CLI documentation](https://github.com/FreshRSS/FreshRSS/blob/edge/cli/README.md). |
| **CI, dependencies, and releases** | Workflow injection, excessive CI token permissions, secret exposure, untrusted pull-request data reaching privileged jobs, build/cache poisoning, compromised dependencies, and unauthorized changes to release artifacts or images. See [testing](https://freshrss.github.io/FreshRSS/en/developers/03_Running_tests.html), [developer setup with Docker](https://freshrss.github.io/FreshRSS/en/developers/02_First_steps.html), [pull requests](https://freshrss.github.io/FreshRSS/en/developers/04_Pull_requests.html), and [release preparation](https://freshrss.github.io/FreshRSS/en/developers/05_Release_new_version.html). |

## Severity guide

Assume a reachable FreshRSS instance. Rate the demonstrated impact and required privileges, not only the bug type.

| Impact | Severity guidance |
|---|---|
| Attacker-controlled remote code execution (RCE), command injection, or executable-file overwrite | **Critical**, whether authentication is required or not. |
| Admin or whole-instance takeover | **Critical**. |
| Account takeover, cross-user private read/write access, or disclosure of reusable feed/API credentials | **High**; Critical if it leads to admin or instance takeover. |
| SSRF into protected services, SQL injection, or sensitive file read/write | **High** when it crosses a meaningful security boundary; Critical if it enables RCE or takeover. |
| HTML injection, XSS, CSRF, clickjacking, or double-clickjacking | **Medium–High** depending on affected users and action. High for admin or sensitive account actions. HTML injection remains in scope without script execution. |
| Cache poisoning or retry-state abuse | **Medium**; High if a low-privilege user can persistently disrupt shared feeds, affect many users, or alter trusted UI state. |
| Path disclosure or directory enumeration | **Low** by default; raise to Medium or High if it exposes sensitive configuration/data or enables another exploit. Path disclosure is in scope. |
| Request-driven denial of service or parser complexity | **Medium**; High if modest input can broadly stop the service or cause data loss. |
| CI, release, or container compromise | **High**; Critical if trusted releases can be altered or the host/instance can be taken over. |

## Testing and reporting

Use the [test suite](https://freshrss.github.io/FreshRSS/en/developers/03_Running_tests.html), synthetic feeds, local HTTP servers, test accounts, and temporary directories. Test only instances and services you own or have permission to assess. The [logging guide](https://freshrss.github.io/FreshRSS/en/admins/logs_and_errors.html) may help with debugging.

Reports should include a concise summary, a proof of concept (PoC), the attacker's role, required configuration, entry point, reproduction steps, demonstrated impact, and a suggested fix. Where known, optionally include root-cause analysis, such as the commit or PR that introduced the issue. Include a regression test where practical, and group reports caused by the same root bug.

## Non-findings and exclusions

- Fetching public feeds, accessing explicitly permitted internal feeds, and using a valid public share are intended features; report only access beyond the configured permission or intended share.
- An administrator installing an extension, a third-party extension's own bug, or an operator choosing risky local settings is not a core vulnerability by itself. Report unsafe FreshRSS loaders, shipped defaults, or documented examples when they create the weakness. Local file ownership mistakes after an operator runs CLI tools incorrectly are not a product vulnerability unless FreshRSS's scripts or documentation cause an unsafe privilege boundary.
- Missing headers, version banners, generic stack traces, missing tests or rate limits, and a dependency CVE without a reachable vulnerable path and security impact are not findings by themselves.
- Self-XSS that requires the victim to paste code into developer tools, purely volumetric denial of service, and work proportional to normal feed size are out of scope. Modest input that causes disproportionate resource use remains in scope.
- Low-sensitivity path-existence signals, cosmetic changes visible only to the acting user, and inert or safely escaped HTML are usually not security findings. Raise severity when they expose secrets, cross a user boundary, alter a sensitive action, or form part of a demonstrated exploit chain.
- Do not assume every finding must be exploitable by an unauthenticated or ordinary user. A finding that requires a FreshRSS administrator account is in scope if it demonstrates security impact beyond the administrator's intended capabilities; state the required role and impact explicitly. Do not assume the attacker already controls the repository's trusted maintainers, Docker host, or database superuser. Any path that lets a lower-privileged attacker cross into one of these trust domains is also in scope.
