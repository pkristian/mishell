FROM php:5.6-cli

RUN apt-get update && \
	apt-get install -y git sudo


VOLUME /mishell/

ENV TIMEZONE=Europe/Prague
ENV KNOWN_HOSTS=github.com,gitlab.com,bitbucket.com
ENV USERS=root:0,www-data:33,mishell:2222

WORKDIR /mishell/
COPY mishell.phar /mishell.phar

RUN touch general.log


COPY docker-mishell-entrypoint /

ENTRYPOINT ["/docker-mishell-entrypoint"]

#CMD ["tail","-f","general.log"]
