#!/bin/sh

set -e

echo "init";

composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

composer require laravel/ui -vvv;
exit 0;
