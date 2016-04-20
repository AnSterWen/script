aptitude -y install chkconfig
chkconfig --list | grep mysqld
chkconfig mysqld on
aptitude -y install chkconfig && chkconfig --list | grep mysqld && chkconfig mysqld on && chkconfig --list | grep mysqld
