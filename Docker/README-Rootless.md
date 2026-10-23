# FreshRSS rootless image

The rootless image runs FreshRSS as the fixed non-root identity `33:33` and
listens on container port `8080`. Do not set a different container user. It
works with conventional and rootless Docker engines.

## Install with Docker

Pull the image or build it from the repository root:

```sh
docker pull freshrss/freshrss:rootless
# Or build the current source:
docker build -f Docker/Dockerfile-Rootless -t freshrss/freshrss:rootless .
```

Create persistent storage and start FreshRSS. A fresh named volume inherits
the image data directory's `33:33` ownership and `0700` mode, so it needs no
separate ownership command. This was verified on both conventional and
rootless Docker engines.

```sh
docker volume create freshrss_data
docker run -d --restart unless-stopped --name freshrss \
  --mount type=volume,source=freshrss_data,target=/var/www/FreshRSS/data \
  -p 8080:8080 \
  -e TZ=Europe/Paris \
  -e CRON_MIN=13,43 \
  freshrss/freshrss:rootless
```

Open <http://localhost:8080> and complete the FreshRSS installer.

## Install with Docker Compose and a host path

Set `FRESHRSS_DATA_DIR` in a `.env` file beside `compose.yaml` to a path that you own. Replace `/path/to/freshrss-data` in these
examples with that path:

```dotenv
FRESHRSS_DATA_DIR=/path/to/freshrss-data
```

Create that directory and save this Compose file:

```yaml
services:
  prepare-data:
    image: alpine:3.24
    profiles: ["init"]
    user: "0:0"
    entrypoint: ["/bin/sh", "-c"]
    command: ["chown 33:33 /data && chmod 0700 /data"]
    volumes:
      - type: bind
        source: ${FRESHRSS_DATA_DIR}
        target: /data
        bind:
          create_host_path: false

  freshrss:
    image: freshrss/freshrss:rootless
    restart: unless-stopped
    ports:
      - "8080:8080"
    environment:
      TZ: Europe/Paris
      CRON_MIN: "13,43"
    volumes:
      - type: bind
        source: ${FRESHRSS_DATA_DIR}
        target: /var/www/FreshRSS/data
        bind:
          create_host_path: false
```

Prepare the directory and start the app:

```sh
mkdir -p /path/to/freshrss-data
docker compose --profile init run --rm prepare-data
docker compose up -d freshrss
```

The preparation service runs as container root only to set host-directory
ownership. FreshRSS itself runs as `33:33`. Use the same Docker engine for both
commands; a rootless engine maps container IDs to subordinate host IDs. For
existing data, back it up and review ownership before changing permissions.

## Install with Kubernetes

This example uses persistent claims for data and extensions, exposes HTTP on
port `8080`, and mounts extensions read-only. The namespace enforces the
Restricted Pod Security Standard. Populate the extensions claim before use if
you need custom extensions; the application cannot install or modify them
through a read-only mount.

This is just a sample (working) manifest. You will likely need to customize it to your target cluster.

The Deployment uses a read-only root filesystem, disables service-account token
mounting, and mounts a 64 MiB memory-backed volume at `/run/freshrss` for
generated configuration, sessions, and temporary runtime files. The example
CPU and memory requests/limits are starting points; the runtime volume uses
part of the memory limit.

Save as `freshrss.yaml` and apply with `kubectl apply -f freshrss.yaml`:

```yaml
apiVersion: v1
kind: Namespace
metadata:
  name: freshrss
  labels:
    pod-security.kubernetes.io/enforce: restricted
---
apiVersion: v1
kind: PersistentVolumeClaim
metadata:
  name: freshrss-data
  namespace: freshrss
spec:
  accessModes: [ReadWriteOnce]
  resources:
    requests:
      storage: 1Gi
---
apiVersion: v1
kind: PersistentVolumeClaim
metadata:
  name: freshrss-extensions
  namespace: freshrss
spec:
  accessModes: [ReadWriteOnce]
  resources:
    requests:
      storage: 1Gi
---
apiVersion: apps/v1
kind: Deployment
metadata:
  name: freshrss
  namespace: freshrss
spec:
  replicas: 1
  selector:
    matchLabels:
      app: freshrss
  template:
    metadata:
      labels:
        app: freshrss
    spec:
      automountServiceAccountToken: false
      securityContext:
        runAsNonRoot: true
        runAsUser: 33
        runAsGroup: 33
        fsGroup: 33
        fsGroupChangePolicy: OnRootMismatch
        seccompProfile:
          type: RuntimeDefault
      containers:
        - name: freshrss
          image: freshrss/freshrss:rootless
          imagePullPolicy: IfNotPresent
          ports:
            - name: http
              containerPort: 8080
          env:
            - name: TZ
              value: UTC
            - name: CRON_MIN
              value: ""
          securityContext:
            allowPrivilegeEscalation: false
            readOnlyRootFilesystem: true
            capabilities:
              drop: [ALL]
          resources:
            requests:
              cpu: 100m
              memory: 128Mi
            limits:
              cpu: 500m
              memory: 512Mi
          volumeMounts:
            - name: runtime
              mountPath: /run/freshrss
            - name: data
              mountPath: /var/www/FreshRSS/data
            - name: extensions
              mountPath: /var/www/FreshRSS/extensions
              readOnly: true
      volumes:
        - name: runtime
          emptyDir:
            medium: Memory
            sizeLimit: 64Mi
        - name: data
          persistentVolumeClaim:
            claimName: freshrss-data
        - name: extensions
          persistentVolumeClaim:
            claimName: freshrss-extensions
---
apiVersion: v1
kind: Service
metadata:
  name: freshrss
  namespace: freshrss
spec:
  selector:
    app: freshrss
  ports:
    - name: http
      port: 8080
      targetPort: http
```

The Service is cluster-internal. Expose it through an Ingress or port-forward
for local access, for example `kubectl -n freshrss port-forward service/freshrss 8080:8080`,
then open <http://localhost:8080> and complete the FreshRSS installer. The
cluster's default StorageClass must support `ReadWriteOnce` claims. Set
`CRON_MIN` to the desired minute field to enable scheduled refreshes. The
resource values are starting points; adjust them for your feed count and
refresh workload. The memory-backed runtime volume is limited to `64Mi` and
uses part of the container's memory limit.

## Optional settings

- OIDC is supported using the environment variables defined by the [Docker README](README.md#environment-variables).
- `CRON_MIN` keeps the default image's minute-field setting, but the rootless
  image translates it for its nonroot scheduler instead of starting Debian
  cron. It validates the expression at startup and rejects unsupported or
  malformed minute fields. Leave it empty to disable scheduled refreshes.
- `LISTEN` defaults to port `8080` in this image (`80` in the default image).
  If you change it, publish the same container-side port; for example,
  `LISTEN=0.0.0.0:8081` with `-p 8081:8081`.

See the main [Docker README](README.md#environment-variables) for other
environment variables, image variants, and general Docker usage.
