#!/bin/bash
mysqld_safe --skip-grant-tables &

update mysql.user set password = password('') where user='root' and host = 'localhost';
flush tables;
killall mysqld


