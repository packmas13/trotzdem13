#!/bin/bash

set -o nounset
set -o errexit

cd /var/www/html/trotzdem13/releases

# backup database
cp ../storage/database.sqlite ../current/database.sqlite.backup

# create release folder
FOLDER=`date +"%Y-%m-%dT%H-%M-%S"`
mkdir $FOLDER
cd $FOLDER
echo $FOLDER

# fetch latest release files
TARFILE=`curl --silent "https://api.github.com/repos/packmas13/trotzdem13/releases?per_page=1" | grep -Po '"browser_download_url": "\K.*?(?=")'`
wget --no-verbose -O vendored.tar.gz $TARFILE
tar xf vendored.tar.gz
rm vendored.tar.gz

# create symlinks
rm -rf storage && ln -s ../../storage ./
ln -s ../../.env ./

# migrate and make it current
php artisan migrate --no-interaction --force

cd ../..
ln -sfn releases/$FOLDER current

# optimize it
php current/artisan route:cache
php current/artisan view:cache
