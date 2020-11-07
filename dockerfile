FROM herickc/php-fpm-nginx:latest
USER root
RUN apk --no-cache add php7-iconv
COPY ./docker-compose/postRunScript.sh /entrypoint.sh
COPY ./docker-compose/crontab.txt /crontab.txt
RUN /usr/bin/crontab /crontab.txt
USER nobody

# Let supervisord start nginx & php-fpm
ENTRYPOINT ["sh", "/entrypoint.sh", "CSV Importer"]
# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping

