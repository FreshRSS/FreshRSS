## Manifests for deploying FreshRSS

Note-

1. Edit freshrss-config, and freshrss-secrets to add desired configuration.
2. If you use traefik, and prefer IngressRoute, install Traefik-Ingressroute.yaml. Otherwise, use ingress.yaml.

To install, download the manifests to your computer. Run the below script.

```
# Define the namespace
kubectl apply -f namespace.yaml

# Deploy resources in the namespace
kubectl apply -n freshrss -f pvc.yaml
kubectl apply -n freshrss -f freshrss-config.yaml
kubectl apply -n freshrss -f freshrss-secrets.yaml
kubectl apply -n freshrss -f deployment-freshrss.yaml
kubectl apply -n freshrss -f service.yaml
kubectl apply -n freshrss -f ingress.yaml

# Apply Traefik IngressRoute if Traefik is your Ingress Controller
# kubectl apply -n freshrss -f Traefik-IngressRoute.yaml
```
