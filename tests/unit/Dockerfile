FROM php:5.6-cli


ENV		APP_PATH /app/
ENV		TESTER_BIN /tester-2.0.0/src/tester
ENV		TEST_DIR  $APP_PATH/tests/unit/
ENV		BUILD_SCRIPT  $APP_PATH/scripts/build.php

VOLUME	$APP_PATH

RUN { \
  echo 'phar.readonly=false'; \
  echo 'date.timezone=Europe/Prague'; \
 } >> /usr/local/etc/php/conf.d/custom.ini

ADD ./tester.tar.gz /

WORKDIR $TEST_DIR

CMD		php $BUILD_SCRIPT \
&&		$TESTER_BIN -C -s -j 8 -p php .
