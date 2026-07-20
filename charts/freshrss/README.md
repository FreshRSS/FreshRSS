# FreshRSS Helm Chart

Deploy [FreshRSS](https://freshrss.org) to a Kubernetes cluster.

## Installing

```sh
helm install freshrss ./charts/freshrss \
  --namespace freshrss \
  --create-namespace
```

Or from the published Helm repository:

```sh
helm repo add freshrss https://raw.githubusercontent.com/FreshRSS/FreshRSS/gh-pages
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
| `imagePullSecrets` | `[]` | Secrets for pulling from private registries |
| `nameOverride` | `""` | Override the chart name |
| `fullnameOverride` | `""` | Override the fully qualified resource name |
| `podAnnotations` | `{}` | Extra annotations on the pod |
| `podLabels` | `{}` | Extra labels on the pod |
| `freshrss.CRON_MIN` | `*/15` | Cron schedule for feed refresh |
| `freshrss.ADMIN_EMAIL` | `""` | Admin email address |
| `extraEnv` | `[]` | Additional environment variables |
| `extraEnvFrom` | `[]` | Additional `envFrom` sources (ConfigMap/Secret refs) |
| `oidc.enabled` | `false` | Enable OpenID Connect authentication |
| `oidc.providerMetadataUrl` | `""` | OIDC provider metadata URL |
| `oidc.remoteUserClaim` | `preferred_username` | Claim used as the FreshRSS username |
| `oidc.clientId` | `""` | OIDC client ID |
| `oidc.scopes` | `openid profile` | OIDC scopes |
| `oidc.xForwardedHeaders` | `X-Forwarded-Host X-Forwarded-Port X-Forwarded-Proto` | Trusted forwarded headers |
| `oidc.secrets.clientSecret` | `""` | OIDC client secret |
| `oidc.secrets.clientCryptoKey` | `""` | OIDC client crypto key |
| `existingSecret` | `""` | Use an existing Secret for OIDC credentials instead of generating one |
| `serviceAccount.create` | `true` | Create a ServiceAccount |
| `serviceAccount.name` | `""` | ServiceAccount name (defaults to the release fullname) |
| `serviceAccount.annotations` | `{}` | ServiceAccount annotations |
| `serviceAccount.automountServiceAccountToken` | `false` | Automount the SA token |
| `service.type` | `ClusterIP` | Service type |
| `service.port` | `80` | Service port |
| `ingress.enabled` | `true` | Create an Ingress |
| `ingress.className` | `""` | Ingress class name |
| `ingress.annotations` | `{}` | Ingress annotations |
| `ingress.host` | `freshrsstest.kube.xtremeownage.com` | Ingress host |
| `ingress.path` | `/` | Ingress path |
| `ingress.tls` | `[]` | Ingress TLS configuration |
| `httpRoute.enabled` | `false` | Create a Gateway API `HTTPRoute` instead of/alongside an Ingress |
| `httpRoute.annotations` | `{}` | HTTPRoute annotations |
| `httpRoute.parentRefs` | `[]` | Gateway `parentRefs` the route attaches to |
| `httpRoute.hostnames` | `[]` | Hostnames matched by the route |
| `httpRoute.matches` | path prefix `/` | Route match rules |
| `persistence.enabled` | `true` | Persist FreshRSS data with a PVC |
| `persistence.storageClass` | _unset_ | StorageClass for the PVC (`-` for empty class) |
| `persistence.accessMode` | `ReadWriteOnce` | PVC access mode |
| `persistence.size` | `5Gi` | PVC size |
| `persistence.existingClaim` | `""` | Use a pre-existing PVC instead of generating one |
| `resources` | `{}` | Pod resource requests/limits |
| `podSecurityContext` | `{}` | Pod-level security context |
| `securityContext` | `{}` | Container-level security context |
| `livenessProbe` | see `values.yaml` | Liveness probe configuration |
| `readinessProbe` | see `values.yaml` | Readiness probe configuration |
| `nodeSelector` | `{}` | Node selector |
| `tolerations` | `[]` | Tolerations |
| `affinity` | `{}` | Affinity |

## Testing

```sh
helm test freshrss --namespace freshrss
```

## Argo CD example

```yaml
apiVersion: argoproj.io/v1alpha1
kind: Application
metadata:
  name: freshrss
  namespace: argocd
spec:
  project: default
  source:
    repoURL: https://github.com/FreshRSS/FreshRSS.git
    targetRevision: edge
    path: charts/freshrss
    helm:
      valuesObject:
        ingress:
          host: freshrss.example.com
  destination:
    server: https://kubernetes.default.svc
    namespace: freshrss
  syncPolicy:
    automated:
      prune: true
      selfHeal: true
    syncOptions:
      - CreateNamespace=true
```



