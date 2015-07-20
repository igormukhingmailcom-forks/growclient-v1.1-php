#!/bin/sh

rm -Rf ../build/api/docs

apigen generate -s src -d ../build/api/docs
cd ../build/api/docs

# Add branch
git init
git remote add origin git@github.com:igormukhingmailcom/growclient-v1.1-php.git
git checkout -B gh-pages

# Push generated files
git add .
git commit -m "Api updated"
git push origin gh-pages -fq > /dev/null
