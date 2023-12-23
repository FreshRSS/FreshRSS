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

Set the redirect URIs for FreshRSS: If FreshRSS’ root is `https://freshrss.example.net/`, the proper redirect URI would be `https://freshrss.example.net:443/i/oidc/`. Note the port number is required even if you are using standard ports (443 for HTTPS). Without the port number, Authentik will give a `redirect_url` error. 

You will need to choose a signing key.
If you don’t have one, generate one under *System > Certificates*. The defualt `authentik Self-Signed Certificate` will also work. 

Under Advanced Protocol Settings -> Scopes you will see that email, openid and profile are selected by default. These are the scopes you will set later in the docker config file. 

![authentik-new-provider-secrets](../img/admins/authentik-03.png)

After you have created the provider, you will need to create an application for it.

![authentik-create-application](../img/admins/authentik-04.png)

Once created, go to Applications in Authentik, then select the FreshRSS application you just made. Select the `Policy / Group / User Bindings` tab at the top. This is where you define which of your Authentik users are allowed to access this application (FreshRSS). Select `Bind existing policy` then select either the group or the user tab to add a group of users or a specific user. (Note: Suggested to make a group such as `app-users` and `app-admin-users` so that you can simply add entire groups to applications. Then when new users are made, they are just added to the group and all your applications will allow them to authenticate).

![authentik-create-application](../img/admins/authentik-05.PNG)

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

This is full example docker-compose file. It uses traefik reverse proxy, authentik for oAuth. It uses a separate ENV file to define sensitive variables that would normally go into the `environment` section:
```yaml
# to avoid putting passwords in the compose file directly (and any github backups, they are defined in a separate ENV file)
# ENV File must define:
# OIDC_PROVIDER_METADATA_URL -> taken from authentik oAuth Provider Settings page
# OIDC_CLIENT_ID -> taken from authentik oAuth Provider Settings page
# OIDC_CLIENT_SECRET -> taken from authentik oAuth Provider Settings page
# OIDC_CLIENT_CRYPTO_KEY -> randomly generated password. This is not set in Authentik, it is set only in this docker-compose. 

version: "2.4"

# you will need to define these volumes base on your setup
volumes:
  freshrss-data:
  freshrss-extensions:

networks:
  traefik_proxy:
    name: traefik_proxy
    external: true

services:
  freshrss:
    image: freshrss/freshrss:1.22.1
    container_name: freshrss
    hostname: freshrss
    networks:
      - traefik_proxy
    restart: unless-stopped
    logging:
      options:
        max-size: 10m
    volumes:
      - freshrss-data:/var/www/FreshRSS/data
      - freshrss-extensions:/var/www/FreshRSS/extensions
    env_file:
      # portainer defines the env file as show below, most people put the ENV file in the same folder as the docker-compose.yml file
      - ../stack.env
    environment:
      TZ: America/Chicago
      CRON_MIN: '1,31'
      TRUSTED_PROXY: 172.18.0.30 #internal docker traefik IP address, could try 172.18.0.1/24 instead to allow the entire interal docker network to proxy 
      OIDC_ENABLED: 1
      OIDC_X_FORWARDED_HEADERS: X-Forwarded-Host X-Forwarded-Port X-Forwarded-Proto
      OIDC_SCOPES: openid email profile
      OIDC_REMOTE_USER_CLAIM: preferred_username
    labels:
      - "traefik.enable=true"
      - "traefik.docker.network=traefik_proxy"
      - "traefik.http.routers.fressrss.rule=Host(`rss.domain.com`)"
      - "traefik.http.routers.fressrss.entrypoints=websecure"
      - "traefik.http.routers.fressrss.tls.certresolver=myresolver"
      - "traefik.http.routers.fressrss.service=fressrss"
      - "traefik.http.services.fressrss.loadbalancer.server.port=80"
```

Notes: not sure where `preferred_username` is defined in authentik but using that does work. This does not need to be changed to something else. Note that the authentik documentation states: `By default, every user that has access to an application can request any of the configured scopes.`


## Step 3. Enable OIDC

During FreshRSS initial setup, or inside of the authentication settings for FreshRSS, set the authentication method to HTTP.

Note: Not sure how to setup OIDC into an existing installation because you get stuck in a loop. The last step after everything works, is to login to freshrss and under FreshRss - > Settings -> Authentication, you need to change the user to HTTP. But this setting is only available if you have OIDC enabled. But if you enable OIDC and try to login you have to login with a user that already has HTTP enabled. I got it to work because I was setting up a fresh install and so it brought me to the page to create the user, I made one with the same name as my oAuth admin user and then I was able to immediately set it to HTTP in the settings before logging out. Not sure how to get around this on an existing install

See [FreshRSS’ OpenID Connect documentation](16_OpenID-Connect.md) for more information.
