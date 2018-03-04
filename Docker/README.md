# Deploy FreshRSS with Docker
* See also https://cloud.docker.com/app/freshrss/repository/docker/freshrss/freshrss

## Install Docker

```sh
curl -fsSL https://get.docker.com/ -o get-docker.sh
sh get-docker.sh
```

## Optional: Build Docker image of FreshRSS
Optional, as a *less recent* [online image](https://cloud.docker.com/app/freshrss/repository/docker/freshrss/freshrss) can be automatically fetched during the next step (run),
but online images are not available for as many platforms as if you build yourself.

```sh
# First time only
git clone https://github.com/FreshRSS/FreshRSS.git

cd ./FreshRSS/
git pull
sudo docker pull alpine:3.7
sudo docker build --tag freshrss/freshrss -f Docker/Dockerfile .
```

## Run FreshRSS

Example exposing FreshRSS on port 8080. You may have to adapt the network parameters to fit your needs.

```sh
# You can optionally run from the directory containing the FreshRSS source code:
cd ./FreshRSS/

# The data will be saved on the host in `./data/`
mkdir -p ./data/

sudo docker run -dit --restart unless-stopped --log-opt max-size=10m \
	-v $(pwd)/data:/var/www/FreshRSS/data \
	-p 8080:80 \
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
sudo docker exec -it freshrss php ./cli/list-users.php
```

See the [CLI documentation](../cli/) for all the other commands.

### Cron job to refresh feeds
Set a cron job up on your host machine, calling the `actualize_script.php` inside the FreshRSS Docker instance.

#### Example on Debian / Ubuntu
Create `/etc/cron.d/FreshRSS` with:

```
7,37 * * * * root docker exec -it freshrss php ./app/actualize_script.php > /tmp/FreshRSS.log 2>&1
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

Use a reverse proxy on your host server, such as [Træfik](https://traefik.io/) or [nginx](https://docs.nginx.com/nginx/admin-guide/web-server/reverse-proxy/),
with HTTPS, for instance using [Let’s Encrypt](https://letsencrypt.org/).
