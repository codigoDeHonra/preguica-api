#!/bin/sh

set -e

echo "init";

#chmod -R 777 /app/storage;
#composer install -vvv;

composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

composer require laravel/ui -vvv;
exit 0;
