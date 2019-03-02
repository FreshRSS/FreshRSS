FROM ubuntu:18.10

ENV TZ UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt update && \
	apt install --no-install-recommends -y \
	cron \
	apache2 libapache2-mod-php \
	php-curl php-intl php-mbstring php-xml php-zip \
	php-sqlite3 php-mysql php-pgsql && \
	rm -rf /var/lib/apt/lists/

RUN mkdir -p /var/www/FreshRSS /run/apache2/ /run/php/
WORKDIR /var/www/FreshRSS

COPY . /var/www/FreshRSS
COPY ./Docker/*.Apache.conf /etc/apache2/sites-available/

RUN a2dismod -f alias autoindex negotiation status && \
	a2enmod deflate expires headers mime proxy_fcgi setenvif && \
	a2disconf '*' && \
	a2dissite '*' && \
	a2ensite 'FreshRSS*'

RUN sed -r -i "/^\s*(CustomLog|ErrorLog|Listen) /s/^/#/" /etc/apache2/apache2.conf && \
	sed -r -i "/^\s*Listen /s/^/#/" /etc/apache2/ports.conf && \
	echo "17,37 su apache -s /bin/sh -c 'php /var/www/FreshRSS/app/actualize_script.php' 2>> /proc/1/fd/2 > /tmp/FreshRSS.log" >> \
		/var/spool/cron/crontabs/root

ENV COPY_SYSLOG_TO_STDERR On
ENV CRON_MIN ''
ENTRYPOINT ["./Docker/entrypoint.sh"]

EXPOSE 80
CMD ([ -z "$CRON_MIN" ] || cron) && \
	. /etc/apache2/envvars && \
	exec apache2 -D FOREGROUND
