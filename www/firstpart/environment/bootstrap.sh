#!/usr/bin/env bash

apt update
apt install -y apache2
apt install -y php
apt install -y mysql-server
apt install -y vim
apt install -y mc
apt install php-xdebug
cp /var/www/html/environment/xdebug.ini /etc/php/7.2/cli/conf.d/20-xdebug.ini
systemctl reload apache2
