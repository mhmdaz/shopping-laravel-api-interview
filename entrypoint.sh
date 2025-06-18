#!/usr/bin/env bash

if [[ ! -f ".env" && -f ".env.example" ]]; then
    cp .env.example .env
    echo ".env file generated"
fi

export $(grep '^APP_KEY=' .env | xargs)
if [ -z "${APP_KEY}" ]; then
    php artisan key:generate --ansi
fi

while true; do
    php artisan db:monitor
    [ $? -gt 0 ] || break
done

php artisan migrate

php artisan serve --host 0.0.0.0 --port 8000
