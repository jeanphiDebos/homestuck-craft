#!/bin/bash
composer install
yarn install
bin/console d:s:c
bin/console d:m:m