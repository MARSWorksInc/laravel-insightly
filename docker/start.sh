#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

echo "The Environment is $env"
echo "The role is $role..."

if [ "$role" = "app" ]; then
    ln -sf /etc/supervisor/conf.d-available/app.conf /etc/supervisor/conf.d/app.conf
    service nginx reload
else
    echo "Could not match the container role \"$role\""
    exit 1
fi

exec supervisord -c /etc/supervisor/supervisord.conf
