# OpenID Connect (OIDC)

See: [What is OpenID Connect?](https://openid.net/connect/).

OIDC support is provided by [mod_auth_openidc](https://github.com/OpenIDC/mod_auth_openidc).
Additional documentation can be found in that project.

## Using Docker

OIDC support in Docker is activated by the presence of a non-empty non-zero `OIDC_ENABLED` environment variable.

> ℹ️ Only available in our Debian image.

## The config is done with these environment variables

* `OIDC_ENABLED`: Activates OIDC support.
* `OIDC_PROVIDER_METADATA_URL`: The config URL. Usually looks like: `<issuer>/.well-known/openid-configuration`
* `OIDC_CLIENT_ID`: The OIDC client id from your issuer.
* `OIDC_CLIENT_SECRET`: The OIDC client secret issuer.
* `OIDC_CLIENT_CRYPTO_KEY`: An opaque key used for internal encryption.

## Setup

After being properly configured, OIDC support can be activated in the FreshRSS UI.

During install, admins should be able to select the 'HTTP' Authentication Method. After install this option can
be changed in the 'Administration > Authentication' section.
