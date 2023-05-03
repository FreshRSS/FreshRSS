# OpenID Connect (OIDC)

## Using docker

OIDC support is provided by [mod_auth_openidc](https://github.com/OpenIDC/mod_auth_openidc). Additional
documentation can be found in that project.

OIDC support in docker is activated by the presence of the `OIDC_PROVIDER_METADATA_URL`
environment variable.

## The config is done with these environment variables:

`OIDC_PROVIDER_METADATA_URL`

The config url. Usually will look like: `<issuer>/.well-known/openid-configuration`

`OIDC_CLIENT_ID`

The OIDC client id from your issuer.

`OIDC_CLIENT_SECRET`

The OIDC client secret issuer.

`OIDC_CLIENT_CRYPTO_KEY`

An opaque key used for internal encryption.
