# Deploy FreshRSS with Docker
* See also:
	* https://hub.docker.com/r/freshrss/freshrss/
	* https://cloud.docker.com/app/freshrss/repository/docker/freshrss/freshrss

## Install Docker

```sh
curl -fsSL https://get.docker.com/ -o get-docker.sh
sh get-docker.sh
```

## Optional: Build Docker image of FreshRSS
Optional, as a *less recent* online image can be automatically fetched during the next step (run),
but online images are not available for as many platforms as if you build yourself.

```sh
# First time only
git clone https://github.com/FreshRSS/FreshRSS.git

cd ./FreshRSS/
git pull
sudo docker pull alpine:3.8
sudo docker build --tag freshrss/freshrss -f Docker/Dockerfile .
```

## Run FreshRSS

Example using SQLite, built-in cron, and exposing FreshRSS on port 8080. You may have to adapt the parameters to fit your needs.

```sh
# You can optionally run from the directory containing the FreshRSS source code:
cd ./FreshRSS/

# The data will be saved on the host in `./data/`
mkdir -p ./data/

sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v $(pwd)/data:/var/www/FreshRSS/data \
  -e 'CRON_MIN=5,35' \
  -p 8080:80 \
  --name freshrss freshrss/freshrss
```

### Examples with external databases

You may want to use other link methods such as Docker bridges, and use Docker volumes for the data, but here are some simple examples:

#### MySQL
See https://hub.docker.com/_/mysql/

```sh
sudo docker run -d -v /path/to/mysql-data:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=rootpass -e MYSQL_DATABASE=freshrss -e MYSQL_USER=freshrss -e MYSQL_PASSWORD=pass --name mysql mysql
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v $(pwd)/data:/var/www/FreshRSS/data \
  -e 'CRON_MIN=17,47' \
  --link mysql -p 8080:80 \
  --name freshrss freshrss/freshrss
```

#### PostgreSQL
See https://hub.docker.com/_/postgres/

```sh
sudo docker run -d -v /path/to/pgsql-data:/var/lib/postgresql/data -e POSTGRES_DB=freshrss -e POSTGRES_USER=freshrss -e POSTGRES_PASSWORD=pass --name postgres postgres
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v $(pwd)/data:/var/www/FreshRSS/data \
  -e 'CRON_MIN=23,53' \
  --link postgres -p 8080:80 \
  --name freshrss freshrss/freshrss
```

## Update

```sh
# Rebuild an image (see build section above) or get a new online version:
sudo docker pull freshrss/freshrss
# And then
sudo docker stop freshrss
sudo docker rename freshrss freshrss_old
# See the run section above for the full command
sudo docker run ...
# If everything is working, delete the old container
sudo docker rm freshrss_old
```

## Command line

```sh
sudo docker exec --user apache -it freshrss php ./cli/list-users.php
```

See the [CLI documentation](../cli/) for all the other commands.

## Cron job to automatically refresh feeds
We recommend a refresh rate of about twice per hour (see *WebSub* / *PubSubHubbub* for real-time updates).
There is no less than 3 options. Pick a single one.

### Option 1) Cron inside the FreshRSS Docker image
Easiest, built-in solution, also used in the examples above
(but your Docker instance will have a second process in the background, without monitoring).
Just pass the environment variable `CRON_MIN` to your `docker run` command,
containing a valid cron minute definition such as `'13,43'` (recommended) or `'*/20'`.
Not passing the `CRON_MIN` environment variable – or setting it to empty string – will disable the cron daemon.

```sh
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v $(pwd)/data:/var/www/FreshRSS/data \
  -e 'CRON_MIN=13,43' \
  -p 8080:80 \
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

```sh
sudo docker run -d --restart unless-stopped --log-opt max-size=10m \
  -v $(pwd)/data:/var/www/FreshRSS/data \
  -e 'CRON_MIN=17,37' \
  --name freshrss_cron freshrss/freshrss \
  crond -f -d 6
```


## Debugging

```sh
# See FreshRSS data (it is on the host)
cd ./data/
# See Web server logs
sudo docker logs -f freshrss

# Enter inside FreshRSS docker container
sudo docker exec -it freshrss sh
## See FreshRSS root inside the container
ls /var/www/FreshRSS/
```

## Deployment in production

Use a reverse proxy on your host server, such as [Træfik](https://traefik.io/)
or [nginx](https://docs.nginx.com/nginx/admin-guide/web-server/reverse-proxy/),
with HTTPS, for instance using [Let’s Encrypt](https://letsencrypt.org/).

### Example with [docker-compose](https://docs.docker.com/compose/)

A [docker-compose.yml](docker-compose.yml) file is given as an example, using PostgreSQL. In order to use it, you have to adapt:
- In the `postgresql` service:
	* the `volumes` section. Be careful to keep the path `/var/lib/postgresql/data` for the container. If the path is wrong, you will not get any error but your db will be gone at the next run;
	* the `POSTGRES_PASSWORD` in the `environment` section;
- In the `freshrss` service:
	* the `volumes` section;
	* options under the `labels` section are specific to [Træfik](https://traefik.io/), a reverse proxy. If you are not using it, feel free to delete this section. If you are using it, adapt accordingly to your config, especially the `traefik.frontend.rule` option.
	* the `environment` section to adapt the strategy to update feeds.

You can then launch the stack (postgres + freshrss) with:
```sh
docker-compose up -d
```

### Nginx reverse proxy configuration 

Here is an example of configuration to run FreshRSS behind an Nginx reverse proxy (as subdirectory). In particular, the proxy should be setup to allow cookies via HTTP headers (see `proxy_cookie_path` below) to allow logging in via the Web form method.

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
	}
}
```
