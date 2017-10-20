FROM php:5.6-cli

RUN apt-get update && \
	apt-get install -y git

RUN { \
	  echo 'phar.readonly=false'; \
	  echo 'date.timezone=Europe/Prague'; \
    } >> /usr/local/etc/php/conf.d/custom.ini

VOLUME  /usr/src/myapp/
WORKDIR /usr/src/myapp/

CMD ["bash","tests/innerTest.sh"]
