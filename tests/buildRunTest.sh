#!/usr/bin/env bash

# current directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $DIR

#build
echo 'Build...'
php $DIR/../scripts/build.php

#run
echo "Preparing repo..."
. prepareTestRepo.sh 2>&1 1> prepareTestRepo.log
cd $DIR

echo 'Running...'

php $DIR/../build/mishell.phar testProfile.ini
