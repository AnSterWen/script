#!/bin/bash
#由于在其它机器编译安装过，所以可直接拷贝部署
[ -f /root/mysql.tat.gz ] && tar xf /root/mysql.tat.gz -C /opt/ ||echo "mysql.tat.gz doesn't exit" 
groupadd mysql &&  useradd -r -g mysql mysql
chown -R root.mysql /opt/mysql/
chown -R mysql.mysql /opt/mysql/data/
[ -d mv /etc/mysql/ ] && mv /etc/mysql/ /tmp/mysql
[ -f /etc/my.cnf ] && mv /etc/my.cnf  /tmp/
/opt/mysql/scripts/mysql_install_db --user=mysql --basedir=/opt/mysql/ --datadir=/opt/mysql/data/
cp /opt/mysql/support-files/mysql.server /etc/init.d/mysqld

[ -f /root/my.cnf ] && mv /root/my.cnf /etc/

/etc/init.d/mysqld start

/opt/mysql/bin/mysql -e "grant replication slave,replication client on *.* to 'lush'@'%' identified by 'lush'" 

CHANGE MASTER TO MASTER_HOST='$ip', MASTER_USER='lush', MASTER_PASSWORD='lush', MASTER_PORT=3306, MASTER_LOG_FILE='master2-bin.001', MASTER_LOG_POS=4;

grant select on RU.* to 'platform'@'%' identified by 'pf@gl0ve';

aptitude install chkconfig
chkconfig mysqld on
