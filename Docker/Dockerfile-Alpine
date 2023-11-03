FROM alpine:3.18

ENV TZ UTC
SHELL ["/bin/ash", "-eo", "pipefail", "-c"]

RUN apk add --no-cache \
	tzdata \
	apache2 php-apache2 \
	php php-curl php-gmp php-intl php-mbstring php-xml php-zip \
	php-ctype php-dom php-fileinfo php-iconv php-json php-opcache php-openssl php-phar php-session php-simplexml php-xmlreader php-xmlwriter php-xml php-tokenizer php-zlib \
	php-pdo_sqlite php-pdo_mysql php-pdo_pgsql

RUN mkdir -p /var/www/FreshRSS /run/apache2/
WORKDIR /var/www/FreshRSS

COPY . /var/www/FreshRSS
COPY ./Docker/*.Apache.conf /etc/apache2/conf.d/

ARG FRESHRSS_VERSION
ARG SOURCE_BRANCH
ARG SOURCE_COMMIT

LABEL \
	org.opencontainers.image.authors="Alkarex" \
	org.opencontainers.image.description="A self-hosted RSS feed aggregator" \
	org.opencontainers.image.documentation="https://freshrss.github.io/FreshRSS/" \
	org.opencontainers.image.licenses="AGPL-3.0" \
	org.opencontainers.image.revision="${SOURCE_BRANCH}.${SOURCE_COMMIT}" \
	org.opencontainers.image.source="https://github.com/FreshRSS/FreshRSS" \
	org.opencontainers.image.title="FreshRSS" \
	org.opencontainers.image.url="https://freshrss.org/" \
	org.opencontainers.image.vendor="FreshRSS" \
	org.opencontainers.image.version="$FRESHRSS_VERSION"

RUN rm -f /etc/apache2/conf.d/languages.conf /etc/apache2/conf.d/info.conf \
		/etc/apache2/conf.d/status.conf /etc/apache2/conf.d/userdir.conf && \
	sed -r -i "/^\s*LoadModule .*mod_(alias|autoindex|negotiation|status).so$/s/^/#/" \
		/etc/apache2/httpd.conf && \
	sed -r -i "/^\s*#\s*LoadModule .*mod_(deflate|expires|headers|mime|remoteip|setenvif).so$/s/^\s*#//" \
		/etc/apache2/httpd.conf && \
	sed -r -i "/^\s*(CustomLog|ErrorLog|Listen) /s/^/#/" \
		/etc/apache2/httpd.conf && \
	# Disable built-in updates when using Docker, as the full image is supposed to be updated instead.
	sed -r -i "\\#disable_update#s#^.*#\t'disable_update' => true,#" ./config.default.php && \
	touch /var/www/FreshRSS/Docker/env.txt && \
	echo "27,57 * * * * . /var/www/FreshRSS/Docker/env.txt; \
		su apache -s /bin/sh -c 'php /var/www/FreshRSS/app/actualize_script.php' \
		2>> /proc/1/fd/2 > /tmp/FreshRSS.log" > /etc/crontab.freshrss.default

ENV COPY_LOG_TO_SYSLOG On
ENV COPY_SYSLOG_TO_STDERR On
ENV CRON_MIN ''
ENV DATA_PATH ''
ENV FRESHRSS_ENV ''
ENV LISTEN ''
ENV OIDC_ENABLED ''
ENV TRUSTED_PROXY ''

ENTRYPOINT ["./Docker/entrypoint.sh"]

EXPOSE 80
# hadolint ignore=DL3025
CMD ([ -z "$CRON_MIN" ] || crond -d 6) && \
	exec httpd -D FOREGROUND $([ -n "$OIDC_ENABLED" ] && [ "$OIDC_ENABLED" -ne 0 ] && echo '-D OIDC_ENABLED')
