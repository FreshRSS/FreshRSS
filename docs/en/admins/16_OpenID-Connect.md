# OpenID Connect (OIDC)

See: [What is OpenID Connect?](https://openid.net/connect/).

This is one of the [access control methods](09_AccessControl.md) supported by FreshRSS.

OIDC support is provided by [mod_auth_openidc](https://github.com/OpenIDC/mod_auth_openidc).
Additional documentation can be found in that project.

The callback URL is `https://<your-domain>/i/oidc/`.

## Using Docker

OIDC support in Docker is activated by the presence of a non-empty non-zero `OIDC_ENABLED` environment variable.

> ℹ️ Only available in our default Debian image (not Alpine) for `x86_64` ([help welcome](https://github.com/FreshRSS/FreshRSS/issues/5722)).

## The config is done with these environment variables

* `OIDC_ENABLED`: Activates OIDC support.
* `OIDC_PROVIDER_METADATA_URL`: The config URL. Usually looks like: `<issuer>/.well-known/openid-configuration`
* `OIDC_CLIENT_ID`: The OIDC client id from your issuer.
* `OIDC_CLIENT_SECRET`: The OIDC client secret issuer.
* `OIDC_CLIENT_CRYPTO_KEY`: An opaque key used for internal encryption.
* `OIDC_REMOTE_USER_CLAIM`: The claim to use as the username within FreshRSS. Defaults to `preferred_username`. Depending on what you choose here, and your identity provider, you’ll need to adjust the scopes you request so that this claim will be accessible. Refer to your identity provider’s documentation.
* `OIDC_SCOPES`: The OIDC scopes to request separated by an empty space. Defaults to `openid`. As mentioned previously, make sure the scopes you pick contain whatever `OIDC_REMOTE_USER_CLAIM` you chose. For example, Authelia would require setting this value to `openid profile` to make `preferred_username` accessible.
* `OIDC_X_FORWARDED_HEADERS`: Optional, but required when running FreshRSS behind a reverse proxy so that the OIDC module can determine what hostname, port and protocol were used to access FreshRSS, in order to generate a return URL for the OIDC authorization flow. Must be one or more of `Forwarded`, `X-Forwarded-Host`, `X-Forwarded-Port` or `X-Forwarded-Proto` (separate multiple values with a space). See [mod_auth_openidc’s documentation for details](https://github.com/OpenIDC/mod_auth_openidc/blob/72c9f479c2d228477ff0a9518964f61879c83fb6/auth_openidc.conf#L1041-L1048).

You may add additional custom configuration in a new `./FreshRSS/p/i/.htaccess` file.

## Using own Apache installation

See our reference [Apache configuration](https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/FreshRSS.Apache.conf) for more information.

## Setup

After being properly configured, OIDC support can be activated in FreshRSS.

During a new FreshRSS install, the **HTTP Authentication Method** must be picked.

After install, the method can be changed in *Administration > Authentication*. Note that this option will be greyed out if Apache is unable to read the `REMOTE_USER` variable.

## Identity Provider

See specific instructions for:

* [authentik](16_OpenID-Connect-Authentik.md)
