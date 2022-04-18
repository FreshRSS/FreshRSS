![Docker Cloud Automated build](https://img.shields.io/docker/cloud/automated/freshrss/freshrss.svg)
![Docker Pulls](https://img.shields.io/docker/pulls/freshrss/freshrss.svg)

# Deploy FreshRSS with Docker

Our official images are available on [Docker Hub](https://hub.docker.com/r/freshrss/freshrss/).

## Install Docker

See <https://docs.docker.com/get-docker/>

Example for Linux Debian / Ubuntu:

```sh
# Install default Docker Compose and automatically the corresponding version of Docker
apt install docker-compose
```

## Quick run

Example running FreshRSS (or scroll down to the [Docker Compose](#docker-compose) section instead):

```sh
docker run -d --restart unless-stopped --log-opt max-size=10m \
  -p 8080:80 \
  -e TZ=Europe/Paris \
  -e 'CRON_MIN=1,31' \
  -v freshrss-data:/var/www/FreshRSS/data \
  --name freshrss \
  freshrss/freshrss
```

* Exposing on port 8080
* With a [server timezone](http://php.net/timezones) (default is `UTC`)
* With an automatic cron job to refresh feeds
* Saving FreshRSS data in a Docker volume `freshrss-data`
* Using the default image, which is the latest stable release

### Complete installation

Browse to your server <https://freshrss.example.net/> to complete the installation via the FreshRSS Web interface,
or use the command line described below.

## Command line

See the [CLI documentation](../cli/) for all the commands, which can be applied like:

```sh
docker exec --user www-data freshrss cli/list-users.php
```

Example of installation via command line:

```sh
docker exec --user www-data freshrss cli/do-install.php --default_user freshrss

docker exec --user www-data freshrss cli/create-user.php --user freshrss --password freshrss
```

> ℹ️ You have to replace `--user www-data` by `--user apache` when using our images based on Linux Alpine.

## Our Docker image variants

The [tags](https://hub.docker.com/r/freshrss/freshrss/tags) correspond to FreshRSS branches and versions:

* `:latest` (default) is the [latest stable release](https://github.com/FreshRSS/FreshRSS/releases/latest)
* `:edge` is the rolling release, same than our [git `edge` branch](https://github.com/FreshRSS/FreshRSS/tree/edge)
* `:x.y.z` are [specific FreshRSS releases](https://github.com/FreshRSS/FreshRSS/releases)
* `:arm` or `:*-arm` are the ARM `arm32v7` versions (e.g., for Raspberry Pi).
  * For other platforms, see the [custom build section](#build-custom-docker-image)

### Linux: Debian vs. Alpine

Our default image is based on [Debian](https://www.debian.org/). We offer an alternative based on [Alpine](https://alpinelinux.org/) (with the `:alpine` or `*-alpine` tag suffix).
In [our tests](https://github.com/FreshRSS/FreshRSS/pull/2205) (2019), Alpine was slower,
while Alpine is smaller on disk (and much faster to build),
and with newer packages in general (Apache, PHP).

> ℹ️ For some rare systems, one variant might work but not the other, for instance due to kernel incompatibilities.

## Environment variables

* `TZ`: (default is `UTC`) A [server timezone](http://php.net/timezones) (default is `UTC`)
* `CRON_MIN`: (default is disabled) Define minutes for the built-in cron job to automatically refresh feeds (see below for more advanced options)
* `FRESHRSS_ENV`: (default is `production`) Enables additional development information if set to `development` (increases the level of logging and ensures that errors are displayed) (see below for more development options)
* `COPY_LOG_TO_SYSLOG`: (default is `On`) Copy all the logs to syslog
* `COPY_SYSLOG_TO_STDERR`: (default is `On`) Copy syslog to Standard Error so that it is visible in docker logs
* `LISTEN`: (default is `0.0.0.0:80`) Modifies the internal Apache listening port, e.g. `0.0.0.0:8080` (for advanced users; useful for [Docker host networking](https://docs.docker.com/network/host/))
* `FRESHRSS_INSTALL`: automatically pass arguments to command line `cli/do-install.php` (for advanced users; see example in Docker Compose section). Only executed at the very first run (so far), so if you make any change, you need to delete your `freshrss` service, `freshrss-data` volume, before running again.
* `FRESHRSS_USER`: automatically pass arguments to command line `cli/create-user.php` (for advanced users; see example in Docker Compose section). Only executed at the very first run (so far), so if you make any change, you need to delete your `freshrss` service, `freshrss-data` volume, before running again.

## How to update

```sh
# Rebuild an image (see build section below) or get a new online version:
docker pull freshrss/freshrss
# And then
docker stop freshrss
docker rename freshrss freshrss_old
# See the run section above for the full command
docker run ... --name freshrss freshrss/freshrss
# If everything is working, delete the old container
docker rm freshrss_old
```

## Build custom Docker image

Building your own Docker image is especially relevant for platforms not available on our Docker Hub,
which is currently limited to `x64` (Intel, AMD) and `arm32v7`.

```sh
# First time only
git clone https://github.com/FreshRSS/FreshRSS.git

cd FreshRSS/
git pull --ff-only --prune
docker build --pull --tag freshrss/freshrss:custom -f Docker/Dockerfile .
```

## Development mode

To contribute to FreshRSS development, you can use one of the Docker images to run and serve the PHP code,
while reading the source code from your local (git) directory, like the following example:

```sh
cd ./FreshRSS/
docker run --rm \
  -p 8080:80 \
  -e FRESHRSS_ENV=development \
  -e TZ=Europe/Paris \
  -e 'CRON_MIN=1,31' \
  -v $(pwd):/var/www/FreshRSS \
  -v freshrss-data:/var/www/FreshRSS/data \
  --name freshrss \
  freshrss/freshrss:edge
```

This will start a server on port 8080, based on your local PHP code, which will show the logs directly in your terminal.
Press <kbd>Control</kbd>+<kbd>C</kbd> to exit.

### Special development images

> ℹ️ See the [custom build section](#build-custom-docker-image) for an introduction

Two special Dockerfile are provided to reproduce the oldest and newest supported platforms (based on Alpine Linux).
They need to be compiled manually:

```sh
cd ./FreshRSS/
docker build --pull --tag freshrss/freshrss:oldest -f Docker/Dockerfile-Oldest .
docker build --pull --tag freshrss/freshrss:newest -f Docker/Dockerfile-Newest .
```

## Supported databases

FreshRSS has a built-in [**SQLite** database](https://sqlite.org/) (easiest and good performance), but more powerful databases are also supported:

### Create an isolated network

```sh
docker network create freshrss-network
# Run FreshRSS with a `--net freshrss-network` parameter or use the following command:
docker network connect freshrss-network freshrss
```

### [PostgreSQL](https://hub.docker.com/_/postgres/)

```sh
# If you already have a PostgreSQL instance running, just attach it to the FreshRSS network:
docker network connect freshrss-network postgres

# Otherwise, start a new PostgreSQL instance, remembering to change the passwords:
docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v pgsql-data:/var/lib/postgresql/data \
  -e POSTGRES_DB=freshrss \
  -e POSTGRES_USER=freshrss \
  -e POSTGRES_PASSWORD=freshrss \
  --net freshrss-network \
  --name freshrss-db postgres
```

In the FreshRSS setup, you will then specify the name of the container (`freshrss-db`) as the host for the database.

### [MySQL](https://hub.docker.com/_/mysql/) or [MariaDB](https://hub.docker.com/_/mariadb)

```sh
# If you already have a MySQL or MariaDB instance running, just attach it to the FreshRSS network:
docker network connect freshrss-network mysql

# Otherwise, start a new MySQL instance, remembering to change the passwords:
docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v mysql-data:/var/lib/mysql \
  -e MYSQL_ROOT_PASSWORD=rootpass \
  -e MYSQL_DATABASE=freshrss \
  -e MYSQL_USER=freshrss \
  -e MYSQL_PASSWORD=freshrss \
  --net freshrss-network \
  --name freshrss-db mysql \
  --default-authentication-plugin=mysql_native_password
```

> ℹ️ The parameter `--default-authentication-plugin` is not needed if using PHP 8+ (which is the case for our Alpine images but not yet for our Debian images).

In the FreshRSS setup, you will then specify the name of the container (`freshrss-db`) as the host for the database.

## More deployment options

### Custom Apache configuration (advanced users)

The FreshRSS Docker image uses the [Web server Apache](https://httpd.apache.org/) internally.
Changes in [Apache `.htaccess` files](https://httpd.apache.org/docs/trunk/howto/htaccess.html) are applied when restarting the container.
In particular, if you want FreshRSS to use HTTP-based login (instead of the easier Web form login), you can mount your own `./FreshRSS/p/i/.htaccess`:

```sh
docker run ...
  -v /your/.htaccess:/var/www/FreshRSS/p/i/.htaccess \
  -v /your/.htpasswd:/var/www/FreshRSS/data/.htpasswd \
  ...
  --name freshrss freshrss/freshrss
```

Example of `/your/.htaccess` referring to `/your/.htpasswd`:

```apache
AuthUserFile /var/www/FreshRSS/data/.htpasswd
AuthName "FreshRSS"
AuthType Basic
Require valid-user
```

### Modify the configuration of a running FreshRSS instance

Some FreshRSS configuration parameters are stored in [`./FreshRSS/data/config.php`](../config.default.php)
(e.g. `base_url`, `'environment' => 'development'`, database parameters, etc.)
and the following procedure can be used to modify them:

```sh
# Verify the name of your FreshRSS volume, typically `freshrss-data`
docker volume ls
# Verify the path of your FreshRSS volume, typically `/var/lib/docker/volumes/freshrss-data/`
docker volume inspect freshrss-data
# Then edit your configuration file
sudo nano /var/lib/docker/volumes/freshrss-data/_data/config.php
```

## Docker Compose

First, put variables such as passwords in your `.env` file (see [`example.env`](./freshrss/example.env)):

```ini
ADMIN_EMAIL=admin@example.net
ADMIN_PASSWORD=freshrss
ADMIN_API_PASSWORD=freshrss
# Published port if running locally
PUBLISHED_PORT=8080
# Database credentials (not relevant if using default SQLite database)
DB_HOST=freshrss-db
DB_BASE=freshrss
DB_PASSWORD=freshrss
DB_USER=freshrss
```

See [`docker-compose.yml`](./freshrss/docker-compose.yml)

```sh
cd ./FreshRSS/Docker/freshrss/
# Update
docker-compose pull
# Run
docker-compose -f docker-compose.yml -f docker-compose-local.yml up -d --remove-orphans
# Logs
docker-compose logs -f --timestamps
# Stop
docker-compose down --remove-orphans
```

Detailed (partial) example of Docker Compose for FreshRSS:

```yaml
version: "2.4"

volumes:
  freshrss-data:
  freshrss-extensions:

services:
  freshrss:
    image: freshrss/freshrss:edge
    container_name: freshrss
    restart: unless-stopped
    logging:
      options:
        max-size: 10m
    volumes:
      - freshrss-data:/var/www/FreshRSS/data
      - freshrss-extensions:/var/www/FreshRSS/extensions
    ports:
      # If you want to open a port 8080 on the local machine:
      - "8080:80"
    environment:
      TZ: Europe/Paris
      CRON_MIN: '2,32'
      FRESHRSS_ENV: development
      # Optional auto-install parameters (the Web interface install is recommended instead):
      # ⚠️ Parameters below are only used at the very first run (so far).
      # So if changes are made (or in .env file), first delete the service and volumes.
      # ℹ️ All the --db-* parameters can be omitted if using built-in SQLite database.
      FRESHRSS_INSTALL: |-
        --api_enabled
        --base_url ${BASE_URL}
        --db-base ${DB_BASE}
        --db-host ${DB_HOST}
        --db-password ${DB_PASSWORD}
        --db-type pgsql
        --db-user ${DB_USER}
        --default_user admin
        --language en
      FRESHRSS_USER: |-
        --api_password ${ADMIN_API_PASSWORD}
        --email ${ADMIN_EMAIL}
        --language en
        --password ${ADMIN_PASSWORD}
        --user admin
```

### Docker Compose with PostgreSQL

Example including a [PostgreSQL](https://www.postgresql.org/) database.

See [`docker-compose-db.yml`](./freshrss/docker-compose-db.yml)

```sh
cd ./FreshRSS/Docker/freshrss/
# Update
docker-compose -f docker-compose.yml -f docker-compose-db.yml pull
# Run
docker-compose -f docker-compose.yml -f docker-compose-db.yml -f docker-compose-local.yml up -d --remove-orphans
```

### Docker Compose for development

Use the local (git) FreshRSS source code instead of the one inside the Docker container,
to avoid having to rebuild/restart at each change in the source code.

See [`docker-compose-development.yml`](./freshrss/docker-compose-development.yml)

```sh
cd ./FreshRSS/Docker/freshrss/
# Update
git pull --ff-only --prune
docker-compose pull
# Run
docker-compose -f docker-compose-development.yml -f docker-compose.yml -f docker-compose-local.yml up --remove-orphans
# Stop with [Control]+[C] and purge
docker-compose down --remove-orphans --volumes
```

> ℹ️ You can combine it with `-f docker-compose-db.yml` to spin a PostgreSQL database.

## Run in production

For production, it is a good idea to use a reverse proxy on your host server, providing HTTPS.
A dedicated solution such as [Træfik](https://traefik.io/traefik/) is recommended
(or see [alternative options below](#alternative-reverse-proxy-configurations)).

You must first chose a domain (DNS) or sub-domain, e.g. `freshrss.example.net`, and set it in your `.env` file:

```ini
SERVER_DNS=freshrss.example.net
```

### Use [Træfik](https://traefik.io/traefik/) reverse proxy

Here is the recommended configuration using automatic [Let’s Encrypt](https://letsencrypt.org/) HTTPS certificates and with a redirection from HTTP to HTTPS.

See [`docker-compose-proxy.yml`](./freshrss/docker-compose-proxy.yml)

```sh
cd ./FreshRSS/Docker/freshrss/
# Update
docker-compose -f docker-compose.yml -f docker-compose-proxy.yml pull
# Run
docker-compose -f docker-compose.yml -f docker-compose-proxy.yml up -d --remove-orphans
# Logs
docker-compose -f docker-compose.yml -f docker-compose-proxy.yml logs -f --timestamps
# Stop
docker-compose -f docker-compose.yml -f docker-compose-proxy.yml down --remove-orphans
```

> ℹ️ You can combine it with `-f docker-compose-db.yml` to spin a PostgreSQL database.

See [more information about Docker and Let’s Encrypt in Træfik](https://doc.traefik.io/traefik/https/acme/).

## Alternative reverse proxy configurations

### Alternative reverse proxy using [Apache 2.4](https://httpd.apache.org/docs/2.4/howto/reverse_proxy.html)

Here is an example of a configuration file for running FreshRSS behind an Apache reverse proxy (as a subdirectory).
You need a working SSL configuration and the Apache modules `proxy`, `proxy_http` and `headers` installed (depends on your distribution) and enabled (```a2enmod proxy proxy_http headers```).

```apache
ProxyPreserveHost On

<Location /freshrss/>
	ProxyPass http://127.0.0.1:8080/
	ProxyPassReverse http://127.0.0.1:8080/
	RequestHeader set X-Forwarded-Prefix "/freshrss"
	RequestHeader set X-Forwarded-Proto "https"
	Require all granted
	Options none
</Location>
```

### Alternative reverse proxy using [nginx](https://docs.nginx.com/nginx/admin-guide/web-server/reverse-proxy/)

#### Hosted in a subdirectory

Here is an example of configuration to run FreshRSS behind an Nginx reverse proxy (as subdirectory).

```nginx
upstream freshrss {
	server 127.0.0.1:8080;
	keepalive 64;
}

server {
	listen 80;

	location / {
		return 301 https://$host$request_uri;
	}
}

server {
	server_name mywebsite.example.net;
	listen 443 ssl http2;

	# Other SSL stuff goes here

	location / {
		try_files $uri $uri/ =404;
		index index.htm index.html;
	}

	location /freshrss/ {
		proxy_pass http://freshrss;
		add_header X-Frame-Options SAMEORIGIN;
		add_header X-XSS-Protection "1; mode=block";
		proxy_redirect off;
		proxy_buffering off;
		proxy_set_header Host $host;
		proxy_set_header X-Real-IP $remote_addr;
		proxy_set_header X-Forwarded-Prefix /freshrss/;
		proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header X-Forwarded-Proto $scheme;
		proxy_set_header X-Forwarded-Port $server_port;
		proxy_read_timeout 90;

		# Forward the Authorization header for the Google Reader API.
		proxy_set_header Authorization $http_authorization;
		proxy_pass_header Authorization;
	}
}
```

#### Hosted as domain root

Here is an example of configuration to run FreshRSS behind an Nginx reverse proxy (as domain root).

```nginx
upstream freshrss {
	server 127.0.0.1:8080;
	keepalive 64;
}

server {
	listen 80;

	location / {
		return 301 https://$host$request_uri;
	}
}

server {
	server_name mywebsite.example.net;
	listen 443 ssl http2;

	# Other SSL stuff goes here

	location / {
		# The final `/` is important.
		proxy_pass http://freshrss/;
		add_header X-Frame-Options SAMEORIGIN;
		add_header X-XSS-Protection "1; mode=block";
		proxy_redirect off;
		proxy_buffering off;
		proxy_set_header Host $host;
		proxy_set_header X-Real-IP $remote_addr;
		proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header X-Forwarded-Proto $scheme;
		proxy_set_header X-Forwarded-Port $server_port;
		proxy_read_timeout 90;

		# Forward the Authorization header for the Google Reader API.
		proxy_set_header Authorization $http_authorization;
		proxy_pass_header Authorization;
	}
}
```

## Cron job to automatically refresh feeds

We recommend a refresh rate of about twice per hour (see *WebSub* / *PubSubHubbub* for real-time updates).
There are no less than 3 options. Pick a single one.

### Option 1) Cron inside the FreshRSS Docker image

Easiest, built-in solution, also used already in the examples above
(but your Docker instance will have a second process in the background, without monitoring).
Just pass the environment variable `CRON_MIN` to your `docker run` command,
containing a valid cron minute definition such as `'13,43'` (recommended) or `'*/20'`.
Not passing the `CRON_MIN` environment variable – or setting it to empty string – will disable the cron daemon.

```sh
docker run ... \
  -e 'CRON_MIN=13,43' \
  --name freshrss freshrss/freshrss
```

### Option 2) Cron on the host machine

Traditional solution.
Set a cron job up on your host machine, calling the `actualize_script.php` inside the FreshRSS Docker instance.
Remember not pass the `CRON_MIN` environment variable to your Docker run, to avoid running the built-in cron daemon of option 1.

Example on Debian / Ubuntu: Create `/etc/cron.d/FreshRSS` with:

```text
7,37 * * * * root docker exec --user www-data freshrss php ./app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

### Option 3) Cron as another instance of the same FreshRSS Docker image

For advanced users. Offers good logging and monitoring with auto-restart on failure.
Watch out to use the same run parameters than in your main FreshRSS instance, for database, networking, and file system.
See cron option 1 for customising the cron schedule.

#### For the Debian image (default)

```sh
docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v freshrss-data:/var/www/FreshRSS/data \
  -v freshrss-extensions:/var/www/FreshRSS/extensions \
  -e 'CRON_MIN=17,47' \
  --net freshrss-network \
  --name freshrss_cron freshrss/freshrss \
  cron -f
```

#### For the Debian image (default) using a custom cron.d fragment

This method gives most flexibility to execute various FreshRSS CLI commands.

```sh
docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v freshrss-data:/var/www/FreshRSS/data \
  -v freshrss-extensions:/var/www/FreshRSS/extensions \
  -v ./freshrss_crontab:/etc/cron.d/freshrss \
  --net freshrss-network \
  --name freshrss_cron freshrss/freshrss \
  cron -f
```

#### For the Alpine image

```sh
docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v freshrss-data:/var/www/FreshRSS/data \
  -v freshrss-extensions:/var/www/FreshRSS/extensions \
  -e 'CRON_MIN=27,57' \
  --net freshrss-network \
  --name freshrss_cron freshrss/freshrss:alpine \
  crond -f -d 6
```
