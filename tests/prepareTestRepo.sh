#!/usr/bin/env bash

mkdir testRepo
cd testRepo
rm -rf ./*

git init

echo "blah blah" > first
git add .
git commit -m 'first'
git checkout -B first

git checkout -B second
echo "blah" > second
git add .
git commit -m 'second'

