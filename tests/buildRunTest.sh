#!/usr/bin/env bash

# current directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $DIR

#build
echo 'Build...'
php $DIR/../scripts/build.php

#run
echo "Preparing repo..."
. prepareTestRepo.sh 1> /dev/null 2> /dev/null
cd $DIR

echo 'Running...'

php $DIR/../build/dev/mishell.phar testProfile.ini
