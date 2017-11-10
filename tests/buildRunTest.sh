#!/usr/bin/env bash

# current directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $DIR

#build
echo 'Build...'
php $DIR/../scripts/build.php

#run
echo "Preparing repo..."
. prepareTestRepo.sh > prepareTestRepo.log 2>&1
cd $DIR

echo ' '
echo 'Running with test profile...****************'
php $DIR/../build/mishell.phar /mishell/testProfile.ini sudo
php $DIR/../build/mishell.phar testProfile.ini sudo
