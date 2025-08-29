#!/usr/bin/env bash
set -o errexit

# PHP MySQL driver install
apt-get update
apt-get install -y php-mysql
