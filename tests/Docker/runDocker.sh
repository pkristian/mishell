#!/usr/bin/env bash

# current directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $DIR

# build mishell
echo 'Build...'
php $DIR/../../scripts/build.php

# prepareTestRepo START
mkdir mishell
rm -rf mishell/testRepo
mkdir mishell/testRepo
cd mishell/testRepo && \
git init   && \
git remote add origin git@github.com:pkristian/mishell.git && \
git fetch origin testDeploy-one  && \
git checkout -f origin/testDeploy-one
# prepare test repo END
cd $DIR

#run itself

docker-compose down
docker-compose up --build
