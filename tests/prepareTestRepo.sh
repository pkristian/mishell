#!/usr/bin/env bash

rm -rf testRepo
mkdir testRepo
cd testRepo

git init

echo "blah blah" > first
git add .
git commit -m 'first'
git checkout -B first

git checkout -B second
echo "blah" > second
git add .
git commit -m 'second'

