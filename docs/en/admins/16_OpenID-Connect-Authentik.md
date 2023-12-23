# Setting up Authentik for FreshRSS

**[authentik](https://goauthentik.io/)** is an open-source Identity Provider compatible with OpenID Connect (OIDC) (see [FreshRSS’ OpenID Connect documentation](16_OpenID-Connect.md)).

You can find more information in [authentik integrations documentation](https://goauthentik.io/integrations/services/freshrss/).

## 1. Create OAuth2/OpenID Provider

In authentik Web interface:

![authentik-new-provider-type](../img/admins/authentik-01.png)

Select oAuth2/OpenID Provider. Click Next.

Give it a name, and select your desired auth flows (default flows for this example). Select "Confidential" Client Type. 

![authentik-new-provider-create](../img/admins/authentik-02.png)

Copy the ID / secret for later (you can also come back and get it later).

Set the redirect URIs for FreshRSS: If FreshRSS’ root is `https://freshrss.example.net/`, the proper redirect URI would be `https://freshrss.example.net:443/i/oidc`/ Note the port number is required even if you are using standard ports (443 for HTTPS). Without the port number, Authentik will give a `redirect_url` error. 

You will need to choose a signing key.
If you don’t have one, generate one under *System > Certificates*. The defualt `authentik Self-Signed Certificate` will also work. 

Under Advanced Protocol Settings -> Scopes you will see that email, openid and profile are selected by default. These are the scopes you will set later in the docker config file. 

![authentik-new-provider-secrets](../img/admins/authentik-03.png)

After you have created the provider, you will need to create an application for it.

![authentik-create-application](../img/admins/authentik-04.png)

In Authentik, click on Applications, then select the FreshRSS application you just made. Select the `Policy / Group / User Bindings` tab at the top. This is where you define which of your Authentik users are allowed to access this application (FreshRSS). Select `Bind existing policy` then select either the group or the user tab to add a group of users or a specific user. (Note: Suggested to make a group such as `app-users` and `app-admin-users` so that you can simply add entire groups to applications. Then when new users are made, they are just added to the group and all your applications will allow them to authenticate).


Finally, go to *Providers*, and click on the OIDC provider you created for FreshRSS.

You will want to copy the `OpenID Configuration URL` value listed.
You will need this in the next step.

## Step 2. Configure FreshRSS’ environment variables

Note: this is using a Kubernetes ConfigMap.
However, these are just environment variables mapped into the container.

```yaml
apiVersion: v1
kind: ConfigMap
metadata:
  name: freshrss-config
  namespace: freshrss
data:
  PGID: "100"
  PUID: "65534"
  CRON_MIN: "*/15"
  OIDC_ENABLED: "1"
  # Put your "OpenID Configuration URL" here, from the previous step:
  OIDC_PROVIDER_METADATA_URL: https://authentik.example.net/application/o/freshrss/.well-known/openid-configuration
  OIDC_REMOTE_USER_CLAIM: preferred_username
  # Put your ID here, from the previous step:
  OIDC_CLIENT_ID: t48O5c6z2Ia1XXXXXXX
  # Put your secret here, from the previous step:
  OIDC_CLIENT_SECRET: tDUhtfgxY5mCIZ1M1ItauXXXXX
  # TODO: I have no idea what goes here, but a random string seems to work just fine:
  OIDC_CLIENT_CRYPTO_KEY: WnoO3kRzXynag2XXXXXXXXXX
  OIDC_SCOPES: "openid profile"
  # These headers work for Traefik.
  # May need to be adjusted depending on your proxy configuration:
  OIDC_X_FORWARDED_HEADERS: X-Forwarded-Host X-Forwarded-Port X-Forwarded-Proto
```

## Step 3. Enable OIDC

During FreshRSS initial setup, or inside of the authentication settings for FreshRSS, set the authentication method to HTTP.

See [FreshRSS’ OpenID Connect documentation](16_OpenID-Connect.md) for more information.
