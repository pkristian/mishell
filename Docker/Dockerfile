FROM	php:5.6-cli

RUN		apt-get update \
&&		apt-get install -y git sudo


VOLUME	 /mishell/

ENV		MISHELL_VERSION 0.1.0
ENV		TIMEZONE Europe/Prague
ENV		KNOWN_HOSTS github.com,gitlab.com,bitbucket.com
ENV		USERS root:0,www-data:33

WORKDIR	/mishell/

RUN		set -x \
&&		curl -fsSL \
		https://github.com/pkristian/mishell/releases/download/$MISHELL_VERSION/mishell-$MISHELL_VERSION.phar \
		-o mishell.phar


RUN		touch general.log


COPY	docker-mishell-entrypoint /

ENTRYPOINT	["/docker-mishell-entrypoint"]
