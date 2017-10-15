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


echo 'Running...'
cd $DIR
php $DIR/../build/mishell.phar testProfile.ini
