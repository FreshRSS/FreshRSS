# Rootless image contract test

Run the scheduler's `CRON_MIN` translation unit tests without Docker:

```sh
bash tests/docker/rootless-cron-translation.sh
```

These tests cover supported minute values, lists, ranges, steps, leading zeroes,
combined expressions, and invalid input rejection. They run in the GitHub Actions
test workflow.

The focused contract test verifies the rootless image's runtime identity,
listener, startup, storage, and scheduler behavior. It uses Node.js 20 or later,
the Docker CLI, and a Linux Docker engine.

Build the image from the repository root and run the contract test against a
conventional Docker engine:

```sh
docker build -f Docker/Dockerfile-Rootless -t freshrss:rootless-test .
node tests/docker/rootless-contract.mjs --image freshrss:rootless-test --engine rootful
```

Run it against an actual rootless Docker daemon to verify engine-level
rootlessness. The test checks Docker's reported security options and fails when
the selected engine does not match `--engine`:

```sh
export XDG_RUNTIME_DIR="/run/user/$(id -u)"
export DOCKER_HOST="unix://${XDG_RUNTIME_DIR}/docker.sock"
node tests/docker/rootless-contract.mjs --image freshrss:rootless-test --engine rootless
```

The checks cover the fixed `33:33` identity, rejection of changed UID/GID
overrides, fresh named-volume installation without an ownership helper,
completion of a partially initialized data directory while preserving existing
user data, Apache/PHP/scheduler process identities, data persistence across
container recreation, and the `LISTEN` override. The test intentionally does
not add read-only-root or capability restrictions because those are outside
the rootless contract.

To check a prepared host bind mount, pass an existing empty disposable directory
with ownership mapped to container UID/GID `33:33` for the selected engine:

```sh
node tests/docker/rootless-contract.mjs --image freshrss:rootless-test \
  --engine rootful --bind-data /tmp/freshrss-rootless-bind-test
```

The test writes a sentinel, verifies host-side visibility and persistence across
recreation, then removes the sentinel. It does not change directory ownership.
