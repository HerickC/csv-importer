#!/bin/bash

echo "====================================="
echo "==== Iniciando configurações   ======"
echo "====         $1               ===="
echo "====================================="
echo "Atualizando Banco de dados"
php /var/www/html/artisan migrate

echo "Inserindo configurações do Laravel Worker"
echo "" >> /etc/supervisor/conf.d/supervisord.conf
echo "[program:laravel-worker]" >> /etc/supervisor/conf.d/supervisord.conf
echo "process_name=%(program_name)s_%(process_num)02d" >> /etc/supervisor/conf.d/supervisord.conf
echo "command=php /var/www/html/artisan queue:work --daemon --sleep=3 --tries=3" >> /etc/supervisor/conf.d/supervisord.conf
echo "autostart=true" >> /etc/supervisor/conf.d/supervisord.conf
echo "autorestart=true" >> /etc/supervisor/conf.d/supervisord.conf
echo "user=nobody" >> /etc/supervisor/conf.d/supervisord.conf
echo "numprocs=3" >> /etc/supervisor/conf.d/supervisord.conf
echo "redirect_stderr=true" >> /etc/supervisor/conf.d/supervisord.conf

echo "Iniciando WebServer"
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
