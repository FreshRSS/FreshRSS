FROM alpine:3.7

RUN apk add --no-cache \
	apache2 php7-apache2 \
	php7 php7-curl php7-gmp php7-intl php7-mbstring php7-xml php7-zip \
	php7-ctype php7-dom php7-fileinfo php7-json php7-session \
	php7-pdo_sqlite \
	php7-pdo_mysql \
	php7-pdo_pgsql

ENV FRESHRSS_ROOT /var/www/FreshRSS
RUN mkdir -p ${FRESHRSS_ROOT} /run/apache2/
WORKDIR ${FRESHRSS_ROOT}

COPY . ${FRESHRSS_ROOT}
COPY ./Docker/*.Apache.conf /etc/apache2/conf.d/

EXPOSE 80
CMD php -f ./cli/prepare.php > /dev/null && \
	chown -R :apache ${FRESHRSS_ROOT} && \
	chmod -R g+r ${FRESHRSS_ROOT} && chmod -R g+w ${FRESHRSS_ROOT}/data/ && \
	exec httpd -D FOREGROUND
