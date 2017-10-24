#!/usr/bin/env bash

rm -rf testRepo
mkdir testRepo
cd testRepo

git init
git config user.email "you@domain.com"
git config user.name "github_username"

git remote add origin git@github.com:pkristian/mishell.git


git fetch origin testDeploy-one

git checkout -f origin/testDeploy-one
