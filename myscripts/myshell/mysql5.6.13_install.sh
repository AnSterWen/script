#!/bin/bash
mv /etc/apt/sources.list /etc/apt/sources.list.bak
echo "deb http://archive.debian.org/debian lenny contrib main non-free" >/etc/apt/sources.list

apt-get update
apt-get install debian-keyring debian-archive-keyring
apt-get install -y build-essential gcc g++ make libncurses5-dev
wget http://www.cmake.org/files/v2.8/cmake-2.8.11.2.tar.gz
tar xf cmake-2.8.11.2.tar.gz
cd cmake-2.8.11.2 && ./bootstrap && make && make install
tar xf mysql-5.6.13.tar.gz
cd mysql-5.6.13 && cmake -DCMAKE_INSTALL_PREFIX=/opt/mysql -DMYSQL_UNIX_ADDR=/tmp/mysql.sock -DDEFAULT_CHARSET=utf8 -DDEFAULT_COLLATION=utf8_general_ci -DWITH_EXTRA_CHARSETS=all -DWITH_INNOBASE_STORAGE_ENGINE=1 -DWITH_ARCHIVE_STORAGE_ENGINE=1 -DWITH_BLACKHOLE_STORAGE_ENGINE=1 -DWITH_PERFSCHEMA_STORAGE_ENGINE=1 -DENABLED_LOCAL_INFILE=1 && make && make install

groupadd mysql &&  useradd -r -g mysql mysql
chown -R root.mysql /opt/mysql/
chown -R mysql.mysql /opt/mysql/data/
mv /etc/mysql/  /tmp/mysql
mv /etc/my.cnf  /tmp/
/opt/mysql/scripts/mysql_install_db --user=mysql --basedir=/opt/mysql/ --datadir=/opt/mysql/data/
cp support-files/mysql.server /etc/init.d/mysqld
aptitude install chkconfig
chkconfig mysqld on
