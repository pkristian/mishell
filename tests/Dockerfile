FROM php:5.6-cli

RUN apt-get update && \
	apt-get install -y git

COPY ./id_rsa /root/.ssh/id_rsa
RUN chmod 700 -R ~/.ssh/
RUN ssh-keyscan -t rsa github.com >> ~/.ssh/known_hosts

RUN { \
	  echo 'phar.readonly=false'; \
	  echo 'date.timezone=Europe/Prague'; \
    } >> /usr/local/etc/php/conf.d/custom.ini

VOLUME  /usr/src/myapp/
WORKDIR /usr/src/myapp/

CMD ["bash","tests/innerTest.sh"]
