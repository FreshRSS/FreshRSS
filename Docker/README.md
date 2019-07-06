![Docker Cloud Automated build](https://img.shields.io/docker/cloud/automated/freshrss/freshrss.svg)
![Docker Cloud Build Status](https://img.shields.io/docker/cloud/build/freshrss/freshrss.svg)
![MicroBadger Size](https://img.shields.io/microbadger/image-size/freshrss/freshrss.svg)
![Docker Pulls](https://img.shields.io/docker/pulls/freshrss/freshrss.svg)

# Deploy FreshRSS with Docker
* See also https://hub.docker.com/r/freshrss/freshrss/


## Install Docker

```sh
curl -fsSL https://get.docker.com/ -o get-docker.sh
sh get-docker.sh
```


## Create an isolated network
```sh
sudo docker network create freshrss-network
```

## Recommended: use [Træfik](https://traefik.io/) reverse proxy
It is a good idea to use a reverse proxy on your host server, providing HTTPS.
Here is the recommended configuration using automatic [Let’s Encrypt](https://letsencrypt.org/) HTTPS certificates and with a redirection from HTTP to HTTPS. See further below for alternatives.

```sh
sudo docker volume create traefik-letsencrypt
sudo docker volume create traefik-tmp

# Just change your e-mail address in the command below:
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v traefik-letsencrypt:/etc/traefik/acme \
  -v traefik-tmp:/tmp \
  -v /var/run/docker.sock:/var/run/docker.sock:ro \
  --net freshrss-network \
  -p 80:80 \
  -p 443:443 \
  --name traefik traefik --docker \
  --entryPoints='Name:http Address::80 Compress:true Redirect.EntryPoint:https' \
  --entryPoints='Name:https Address::443 Compress:true TLS TLS.MinVersion:VersionTLS12 TLS.SniStrict:true TLS.CipherSuites:TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256,TLS_ECDHE_RSA_WITH_AES_256_GCM_SHA384,TLS_ECDHE_RSA_WITH_AES_128_CBC_SHA' \
  --defaultentrypoints=http,https --keeptrailingslash=true \
  --acme=true --acme.entrypoint=https --acme.onhostrule=true --acme.tlsChallenge \
  --acme.storage=/etc/traefik/acme/acme.json --acme.email=you@example.net
```

See [more information about Docker and Let’s Encrypt in Træfik](https://docs.traefik.io/user-guide/docker-and-lets-encrypt/).


## Run FreshRSS 
Example using the built-in refresh cron job (see further below for alternatives).
You must first chose a domain (DNS) or sub-domain, e.g. `freshrss.example.net`.

> **N.B.:** For platforms other than x64 (Intel, AMD), such as ARM (e.g. Raspberry Pi), see the section *Build Docker image* further below.

```sh
sudo docker volume create freshrss-data

# Remember to replace freshrss.example.net by your server address in the command below:
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v freshrss-data:/var/www/FreshRSS/data \
  -e 'CRON_MIN=4,34' \
  -e TZ=Europe/Paris \
  --net freshrss-network \
  --label traefik.port=80 \
  --label traefik.frontend.rule='Host:freshrss.example.net' \
  --label traefik.frontend.headers.forceSTSHeader=true \
  --label traefik.frontend.headers.STSSeconds=31536000 \
  --name freshrss freshrss/freshrss
```

* Replace `TZ=Europe/Paris` by your [server timezone](http://php.net/timezones), or remove the line to use `UTC`.
* If you cannot have FreshRSS at the root of a dedicated domain, update the command above according to the following model:
	`--label traefik.frontend.rule='Host:freshrss.example.net;PathPrefixStrip:/FreshRSS/' \`
* You may remove the `--label traefik.*` lines if you do not use Træfik.
* Add `-p 8080:80 \` if you want to expose FreshRSS locally, e.g. on port `8080`.

This already works with a built-in **SQLite** database (easiest), but more powerful databases are supported:

### [MySQL](https://hub.docker.com/_/mysql/)
```sh
# If you already have a MySQL instance running, just attach it to the FreshRSS network:
sudo docker network connect freshrss-network mysql

# Otherwise, start a new MySQL instance, remembering to change the passwords:
sudo docker volume create mysql-data
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v mysql-data:/var/lib/mysql \
  -e MYSQL_ROOT_PASSWORD=rootpass
  -e MYSQL_DATABASE=freshrss \
  -e MYSQL_USER=freshrss \
  -e MYSQL_PASSWORD=pass \
  --net freshrss-network \
  --name mysql mysql
```

### [PostgreSQL](https://hub.docker.com/_/postgres/)
```sh
# If you already have a PostgreSQL instance running, just attach it to the FreshRSS network:
sudo docker network connect freshrss-network postgres

# Otherwise, start a new PostgreSQL instance, remembering to change the passwords:
sudo docker volume create pgsql-data
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v pgsql-data:/var/lib/postgresql/data \
  -e POSTGRES_DB=freshrss \
  -e POSTGRES_USER=freshrss \
  -e POSTGRES_PASSWORD=pass \
  --net freshrss-network \
  --name postgres postgres
```

### Complete installation
Browse to your server https://freshrss.example.net/ to complete the installation via the FreshRSS Web interface,
or use the command line described below.


## How to update

```sh
# Rebuild an image (see build section above) or get a new online version:
sudo docker pull freshrss/freshrss
# And then
sudo docker stop freshrss
sudo docker rename freshrss freshrss_old
# See the run section above for the full command
sudo docker run ... --name freshrss freshrss/freshrss
# If everything is working, delete the old container
sudo docker rm freshrss_old
```


## [Docker tags](https://hub.docker.com/r/freshrss/freshrss/tags)
The tags correspond to FreshRSS branches and versions:
* `:latest` (default) is the `master` branch, more stable
* `:dev` is the `dev` branch, rolling release
* `:x.y.z` are specific FreshRSS releases

### Linux: Ubuntu vs. Alpine
Our default image is based on [Ubuntu](https://www.ubuntu.com/server). We offer an alternative based on [Alpine](https://alpinelinux.org/) (with the `-alpine` tag suffix).
In [our tests](https://github.com/FreshRSS/FreshRSS/pull/2205), Ubuntu is ~3 times faster,
while Alpine is ~2.5 times [smaller on disk](https://hub.docker.com/r/freshrss/freshrss/tags) (and much faster to build).


## Optional: Build Docker image of FreshRSS
Building your own Docker image is optional because online images can be fetched automatically.
Note that prebuilt images are less recent and only available for x64 (Intel, AMD) platforms.

```sh
# First time only
git clone https://github.com/FreshRSS/FreshRSS.git

cd ./FreshRSS/
git pull
sudo docker pull ubuntu:18.10
sudo docker build --tag freshrss/freshrss -f Docker/Dockerfile .
```


## Command line

```sh
sudo docker exec --user apache -it freshrss php ./cli/list-users.php
```

See the [CLI documentation](../cli/) for all the other commands.


## Debugging

```sh
# See FreshRSS data if you use Docker volume
sudo docker volume inspect freshrss-data
sudo ls /var/lib/docker/volumes/freshrss-data/_data/

# See Web server logs
sudo docker logs -f freshrss

# Enter inside FreshRSS docker container
sudo docker exec -it freshrss sh
## See FreshRSS root inside the container
ls /var/www/FreshRSS/
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
sudo docker run ... \
  -e 'CRON_MIN=13,43' \
  --name freshrss freshrss/freshrss
```

### Option 2) Cron on the host machine
Traditional solution.
Set a cron job up on your host machine, calling the `actualize_script.php` inside the FreshRSS Docker instance.
Remember not pass the `CRON_MIN` environment variable to your Docker run, to avoid running the built-in cron daemon of option 1.

Example on Debian / Ubuntu: Create `/etc/cron.d/FreshRSS` with:

```
7,37 * * * * root docker exec --user apache -it freshrss php ./app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

### Option 3) Cron as another instance of the same FreshRSS Docker image
For advanced users. Offers good logging and monitoring with auto-restart on failure.
Watch out to use the same run parameters than in your main FreshRSS instance, for database, networking, and file system.
See cron option 1 for customising the cron schedule.

#### For the Ubuntu image (default)
```sh
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v freshrss-data:/var/www/FreshRSS/data \
  -e 'CRON_MIN=17,47' \
  --net freshrss-network \
  --name freshrss_cron freshrss/freshrss \
  cron
```

#### For the Alpine image
```sh
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v freshrss-data:/var/www/FreshRSS/data \
  -e 'CRON_MIN=27,57' \
  --net freshrss-network \
  --name freshrss_cron freshrss/freshrss:alpine \
  crond -f -d 6
```


## More deployment options

### Custom Apache configuration (advanced users)

Changes in Apache `.htaccess` files are applied when restarting the container.
In particular, if you want FreshRSS to use HTTP-based login (instead of the easier Web form login), you can mount your own `./FreshRSS/p/i/.htaccess`:

```
sudo docker run ...
  -v /your/.htaccess:/var/www/FreshRSS/p/i/.htaccess \
  -v /your/.htpasswd:/var/www/FreshRSS/data/.htpasswd \
  ...
  --name freshrss freshrss/freshrss
```

Example of `/your/.htaccess` referring to `/your/.htpasswd`:
```
AuthUserFile /var/www/FreshRSS/data/.htpasswd
AuthName "FreshRSS"
AuthType Basic
Require valid-user
```

### Example with [docker-compose](https://docs.docker.com/compose/)

A [docker-compose.yml](docker-compose.yml) file is given as an example, using PostgreSQL. In order to use it, you have to adapt:
- In the `postgresql` service:
	* the `volumes` section. Be careful to keep the path `/var/lib/postgresql/data` for the container. If the path is wrong, you will not get any error but your db will be gone at the next run;
	* the `POSTGRES_PASSWORD` in the `environment` section;
- In the `freshrss` service:
	* the `volumes` section;
	* options under the `labels` section are specific to [Træfik](https://traefik.io/), a reverse proxy. If you are not using it, feel free to delete this section. If you are using it, adapt accordingly to your config, especially the `traefik.frontend.rule` option.
	* the `environment` section to adapt the strategy to update feeds.

You can then launch the stack (FreshRSS + PostgreSQL) with:
```sh
sudo docker-compose up -d
```

### Alternative reverse proxy using [nginx](https://docs.nginx.com/nginx/admin-guide/web-server/reverse-proxy/)

Here is an example of configuration to run FreshRSS behind an Nginx reverse proxy (as subdirectory).
In particular, the proxy should be setup to allow cookies via HTTP headers (see `proxy_cookie_path` below) to allow logging in via the Web form method.

```
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

	# Needed for Freshrss cookie/session :
	proxy_cookie_path / "/; HTTPOnly; Secure";

	location / {
		try_files $uri $uri/ =404;
		index index.htm index.html;
	}

	location /freshrss/ {
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
