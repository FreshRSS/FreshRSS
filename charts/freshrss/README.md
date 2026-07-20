# FreshRSS Helm Chart

Deploy [FreshRSS](https://freshrss.org) to a Kubernetes cluster.

## Installing

```sh
helm install freshrss ./charts/freshrss \
  --namespace freshrss \
  --create-namespace
```

Or from the packaged repository (once published to GitHub Pages):

```sh
helm repo add freshrss https://freshrss.github.io/FreshRSS
helm install freshrss freshrss/freshrss --namespace freshrss --create-namespace
```

## Uninstalling

```sh
helm uninstall freshrss --namespace freshrss
```

## Configuration

| Key | Default | Description |
| --- | --- | --- |
| `image.repository` | `freshrss/freshrss` | Container image repository |
| `image.tag` | `latest` | Container image tag |
| `image.pullPolicy` | `IfNotPresent` | Image pull policy |
| `freshrss.CRON_MIN` | `*/15` | Cron schedule for feed refresh |
| `freshrss.ADMIN_EMAIL` | `""` | Admin email address |
| `oidc.enabled` | `false` | Enable OpenID Connect authentication |
| `oidc.providerMetadataUrl` | `""` | OIDC provider metadata URL |
| `oidc.remoteUserClaim` | `preferred_username` | Claim used as the FreshRSS username |
| `oidc.clientId` | `""` | OIDC client ID |
| `oidc.scopes` | `openid profile` | OIDC scopes |
| `oidc.xForwardedHeaders` | `X-Forwarded-Host X-Forwarded-Port X-Forwarded-Proto` | Trusted forwarded headers |
| `oidc.secrets.clientSecret` | `""` | OIDC client secret |
| `oidc.secrets.clientCryptoKey` | `""` | OIDC client crypto key |
| `service.type` | `ClusterIP` | Service type |
| `service.port` | `80` | Service port |
| `ingress.enabled` | `true` | Create an Ingress |
| `ingress.className` | `""` | Ingress class name |
| `ingress.annotations` | `{}` | Ingress annotations |
| `ingress.host` | `freshrsstest.kube.xtremeownage.com` | Ingress host |
| `ingress.path` | `/` | Ingress path |
| `persistence.enabled` | `true` | Persist FreshRSS data with a PVC |
| `persistence.storageClass` | _unset_ | StorageClass for the PVC (`-` for empty class) |
| `persistence.accessMode` | `ReadWriteOnce` | PVC access mode |
| `persistence.size` | `5Gi` | PVC size |
| `resources` | `{}` | Pod resource requests/limits |
| `livenessProbe` | see `values.yaml` | Liveness probe configuration |
| `readinessProbe` | see `values.yaml` | Readiness probe configuration |
| `nodeSelector` | `{}` | Node selector |
| `tolerations` | `[]` | Tolerations |
| `affinity` | `{}` | Affinity |

## Testing

```sh
helm test freshrss --namespace freshrss
```

See [InstallingWithRancher.md](InstallingWithRancher.md) for Rancher-specific instructions.

