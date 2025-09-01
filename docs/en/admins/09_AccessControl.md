# Access Control

FreshRSS offers three methods of Access control: Form Authentication using JavaScript, HTTP based Authentication, or an uncontrolled state with no authentication required.

## Server-side feed fetching & security considerations

FreshRSS fetches RSS feeds using server-side HTTP requests (via the cURL library).
This design allows users to subscribe to feeds hosted not just on the public internet, but also on internal or private networks.
For example, many users connect FreshRSS to tools like RSS-Bridge, cron jobs, or local automation services such as Node-RED — all of which may run on `localhost` or internal IPs.

In self-hosted, single-user setups, this behaviour is expected and usually safe.
However, in **multi-user or public-facing instances**, this same functionality can introduce a potential security risk known as **Server-Side Request Forgery (SSRF)**.

In an SSRF scenario, a malicious user could submit a feed URL that points to internal network services, such as:

* `http://127.0.0.1` (loopback)
* `http://169.254.169.254` (cloud metadata services)
* Other services not meant to be exposed externally

While FreshRSS does not treat these requests as unsafe by default — since many legitimate use cases depend on them — it’s important to understand the implications if your instance is shared, exposed on the internet, or co-hosted with other services.

### Recommended mitigations for shared/public setups

* Run FreshRSS behind a firewall or reverse proxy that blocks access to internal IP ranges
* Use container isolation or a virtual network to prevent access to sensitive endpoints
* Avoid exposing your FreshRSS instance directly to the internet unless you fully trust all users

These steps are not necessary for trusted, single-user deployments, but are strongly advised in shared environments.

> _Note: For Docker-based deployments, `localhost` refers to the container’s internal network._


## Form Authentication

Form Authentication requires the use of JavaScript. It will work on any supported version of PHP.

This option requires nothing more than selecting Form Authentication during installation.

## HTTP Authentication

You may also choose to use HTTP Authentication provided by your web server.[^1]

If you choose to use this option, create a `./p/i/.htaccess` file with a matching `.htpasswd` file.

You can also use any authentication backend as long as your web server exposes the authenticated user through the `REMOTE_USER` variable.

By default, new users allowed by HTTP Basic Auth will automatically be created in FreshRSS the first time they log in.
You can disable auto-registration of new users by setting `http_auth_auto_register` to `false` in the configuration file.
When using auto-registration, you can optionally use the `http_auth_auto_register_email_field` to specify the name of a web server
variable containing the email address of the authenticated user (e.g. `REMOTE_USER_EMAIL`).

## External Authentication

You may also use the `Remote-User` or `X-WebAuth-User` HTTP headers to integrate with a reverse-proxy’s authentication.

To enable this feature, you need to add the IP range (in CIDR notation) of your trusted proxy in the `trusted_sources` configuration option.
To allow only one IPv4, you can use a `/32` like this: `trusted_sources => [ '192.168.1.10/32' ]`.
Likewise to allow only one IPv6, you can use a `/128` like this: `trusted_sources => [ '::1/128' ]`.

You may alternatively pass a `TRUSTED_PROXY` environment variable in a format compatible with [Apache’s `mod_remoteip` `RemoteIPInternalProxy`](https://httpd.apache.org/docs/current/mod/mod_remoteip.html#remoteipinternalproxy).

> ☠️ WARNING: FreshRSS will trust any IP configured in the `trusted_sources` option, if your proxy isn’t properly secured, an attacker could simply attach this header and get admin access.

### Authentik Proxy Provider

If you wish to use external authentication with [Authentik](https://goauthentik.io/),
you will need to configure a [Proxy Provider](https://goauthentik.io/docs/providers/proxy/) with a _Property Mapping_ that tells Authentik to inject the `X-WebAuth-User` HTTP header.
You can do so with the following expression:

```python
return {
    "ak_proxy": {
        "user_attributes": {
            "additionalHeaders": {
                "X-WebAuth-User": request.user.username,
            }
        }
    }
}
```

See also another option for Authentik, [using the OAuth2 Provider with OpenID](16_OpenID-Connect-Authentik.md).

## No Authentication

Not using authentication on your server is dangerous, as anyone with access to your server would be able to make changes as an admin.
It is never advisable to not use any form of authentication, but **never** choose this option on a server that is able to be accessed outside of your home network.

## OpenID Connect

* See [dedicated section](16_OpenID-Connect.md).

## Hints

You can switch your authentication method at any time by editing the `./data/config.php` file, on the line that begins `'auth_type'`.

[^1]: See [the Apache documentation](https://httpd.apache.org/docs/trunk/howto/auth.html)
