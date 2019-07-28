#!/usr/bin/env bash
php artisan migrate:fresh
phpunit
php artisan migrate:fresh --seed

