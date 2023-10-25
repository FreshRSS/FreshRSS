## Setting up Authentik w/FreshRSS

### Authentik Steps

#### 1. Create OAUth2/OpenID Provider

![image](https://github.com/XtremeOwnageDotCom/FreshRSS/assets/5262735/bea3e50b-9402-40c1-9b79-c026dfd83d53)

Click Next.

Give it a name, and select your desired auth flows. I used default flows for this example.

![image](https://github.com/XtremeOwnageDotCom/FreshRSS/assets/5262735/e2799413-ec5a-4313-8a01-157469808f3e)

Copy the ID / Secret. We will need this for later.

Set the redirect URIs for FreshRSS. For me- I have it listening on `https://freshrss.mydomain.com/`

So, the proper redirect URI would be, `https://freshrss.yourdomain.com/i/oidc`

You will need to choose a signing key. If you don't have one, generate one under System > Certificates

![image](https://github.com/XtremeOwnageDotCom/FreshRSS/assets/5262735/4be86ffe-0bef-430d-aa0d-8d31a33732fc)

After you have created the provider, you will need to create an application for it.

![image](https://github.com/XtremeOwnageDotCom/FreshRSS/assets/5262735/f155fdfe-3a71-45fa-8acf-b41db8f6ffa9)

Finally, goto Providers, and click on the OIDC provider you created for FreshRSS

You will want to copy the `OpenID Configuration URL` value listed. You will need this in the next step.

#### Step 2. Configure FreshRSS's Environment Variables

Note- this is using a Kubernetes ConfigMap. however, these are just environment variables mapped into the container.

``` yaml
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
  OIDC_PROVIDER_METADATA_URL: https://authentik.yourdomain.com/application/o/fresh-rss/.well-known/openid-configuration          # Put your "OpenID Configuration URL" here, from the previous step.
  OIDC_REMOTE_USER_CLAIM: preferred_username
  OIDC_CLIENT_ID: t48O5c6z2Ia1BCpK7BIE6xdnAeFaMsY0quvTXfd9                                                                       # Put your ID here, from the previous step.
  OIDC_CLIENT_SECRET: tDUhtfgxY5mCIZ1M1ItauSQk90n3NMUSwCwDULsMHDJtkFsXFLKC75qVJyFxwOyrcGEGkjkBmlzfznWU0vXZWozS8cuneM1Mo6tIx2zcTQHPNTng04hGUYcO3x7kdJPK   # Put your secret here, from the previous step.
  OIDC_CLIENT_CRYPTO_KEY: randomvalue                # I have no idea what goes here. But, a random string seems to work just fine.
  OIDC_SCOPES: "openid profile"                      
  OIDC_X_FORWARDED_HEADERS: X-Forwarded-Host X-Forwarded-Port X-Forwarded-Proto      # Note, I am using Traefik, and these headers appear to do the trick. May need to be adjusted depending on your proxy configuration.
```

ToDo: I am not sure what `OIDC_CLIENT_CRYPTO_KEY` is. Seems to work with a random value.


#### Step 3. Enable "OIDC".

Inside of the authentication settings for freshrss, set the authentication method to HTTP.

![image](https://github.com/XtremeOwnageDotCom/FreshRSS/assets/5262735/e8d97397-a130-41de-ad99-18c0475edcb7)
