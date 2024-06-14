# Access Control

FreshRSS offers three methods of Access control: Form Authentication using JavaScript, HTTP based Authentication, or an uncontrolled state with no authentication required.

## Form Authentication

Form Authentication requires the use of JavaScript. It will work on any supported version of PHP,
but version 5.5 or newer is recommended (see footnote 1 in [prerequisites](02_Prerequisites.md) for the reason why).

This option requires nothing more than selecting Form Authentication during installation.

## HTTP Authentication

You may also choose to use HTTP Authentication provided by your web server.[^1]

If you choose to use this option, create a `./p/i/.htaccess` file with a matching `.htpasswd` file.

You can also use any authentication backend as long as your web server exposes the authenticated user through the `Remote-User` variable.

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
you will need to configure a [Proxy Provider](https://goauthentik.io/docs/providers/proxy/) with a *Property Mapping* that tells Authentik to inject the `X-WebAuth-User` HTTP header.
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
