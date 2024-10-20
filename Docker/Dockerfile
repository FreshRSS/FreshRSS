FROM debian:12-slim

ENV TZ=UTC
SHELL ["/bin/bash", "-o", "pipefail", "-c"]

ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update && \
	apt-get install --no-install-recommends -y \
	ca-certificates cron \
	apache2 libapache2-mod-php \
	libapache2-mod-auth-openidc \
	php-curl php-gmp php-intl php-mbstring php-xml php-zip \
	php-sqlite3 php-mysql php-pgsql && \
	rm -rf /var/lib/apt/lists/*

RUN mkdir -p /var/www/FreshRSS/ /run/apache2/
WORKDIR /var/www/FreshRSS

COPY . /var/www/FreshRSS
COPY ./Docker/*.Apache.conf /etc/apache2/sites-available/

ARG FRESHRSS_VERSION
ARG SOURCE_COMMIT

LABEL \
	org.opencontainers.image.authors="Alkarex" \
	org.opencontainers.image.description="A self-hosted RSS feed aggregator" \
	org.opencontainers.image.documentation="https://freshrss.github.io/FreshRSS/" \
	org.opencontainers.image.licenses="AGPL-3.0" \
	org.opencontainers.image.revision="${SOURCE_COMMIT}" \
	org.opencontainers.image.source="https://github.com/FreshRSS/FreshRSS" \
	org.opencontainers.image.title="FreshRSS" \
	org.opencontainers.image.url="https://freshrss.org/" \
	org.opencontainers.image.vendor="FreshRSS" \
	org.opencontainers.image.version="$FRESHRSS_VERSION"

RUN a2dismod -q -f alias autoindex negotiation status && \
	a2dismod -q auth_openidc && \
	phpdismod calendar exif ffi ftp gettext mysqli posix readline shmop sockets sysvmsg sysvsem sysvshm xsl && \
	a2enmod -q deflate expires headers mime remoteip setenvif && \
	a2disconf -q '*' && \
	a2dissite -q '*' && \
	a2ensite -q 'FreshRSS*'

RUN sed -r -i "/^\s*(CustomLog|ErrorLog|Listen) /s/^/#/" /etc/apache2/apache2.conf && \
	sed -r -i "/^\s*Listen /s/^/#/" /etc/apache2/ports.conf && \
	# Disable built-in updates when using Docker, as the full image is supposed to be updated instead.
	sed -r -i "\\#disable_update#s#^.*#\t'disable_update' => true,#" ./config.default.php && \
	touch /var/www/FreshRSS/Docker/env.txt && \
	echo "7,37 * * * * . /var/www/FreshRSS/Docker/env.txt; \
		su www-data -s /bin/sh -c 'php /var/www/FreshRSS/app/actualize_script.php' \
		2>> /proc/1/fd/2 > /tmp/FreshRSS.log" > /etc/crontab.freshrss.default

ENV COPY_LOG_TO_SYSLOG=On
ENV COPY_SYSLOG_TO_STDERR=On
ENV CRON_MIN=''
ENV DATA_PATH=''
ENV FRESHRSS_ENV=''
ENV LISTEN=''
ENV OIDC_ENABLED=''
ENV TRUSTED_PROXY=''

ENTRYPOINT ["./Docker/entrypoint.sh"]

EXPOSE 80
# hadolint ignore=DL3025
CMD ([ -z "$CRON_MIN" ] || cron) && \
	. /etc/apache2/envvars && \
	exec apache2 -D FOREGROUND $([ -n "$OIDC_ENABLED" ] && [ "$OIDC_ENABLED" -ne 0 ] && echo '-D OIDC_ENABLED')
