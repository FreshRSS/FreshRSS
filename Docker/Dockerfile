FROM alpine:3.7

RUN apk add --no-cache \
	apache2 php7-apache2 \
	php7 php7-curl php7-gmp php7-intl php7-mbstring php7-xml php7-zip \
	php7-ctype php7-dom php7-fileinfo php7-iconv php7-json php7-session php7-simplexml php7-xmlreader php7-zlib \
	php7-pdo_sqlite \
	php7-pdo_mysql \
	php7-pdo_pgsql

ENV FRESHRSS_ROOT /var/www/FreshRSS
RUN mkdir -p ${FRESHRSS_ROOT} /run/apache2/
WORKDIR ${FRESHRSS_ROOT}

COPY . ${FRESHRSS_ROOT}
COPY ./Docker/*.Apache.conf /etc/apache2/conf.d/

RUN echo "17,37 * * * * php ${FRESHRSS_ROOT}/app/actualize_script.php 2>&1 | tee /tmp/FreshRSS.log" >> \
	/var/spool/cron/crontabs/root

EXPOSE 80
ENV CRON_MIN ''
CMD php -f ./cli/prepare.php > /dev/null && \
	chown -R :www-data ${FRESHRSS_ROOT} && \
	chmod -R g+r ${FRESHRSS_ROOT} && chmod -R g+w ${FRESHRSS_ROOT}/data/ && \
	([ -z "$CRON_MIN" ] || ( \
		sed -r -i "/FreshRSS/s/^[^ ]+ /$CRON_MIN /g" /var/spool/cron/crontabs/root && \
		crond -d 6 \
	)) && \
	exec httpd -D FOREGROUND
