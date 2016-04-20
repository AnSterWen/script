#!/bin/bash
#安装oracle所需的软件包

yum -y install binutils compat-libcap1 compat-libstdc++ gcc gcc-c++ glibc glibc-devel ksh libgcc libstdc++ libstdc++-devel libaio libaio-devel make sysstat unixODBC unixODBC-devel >/dev/null 2>&1

#若没安装图形界面，则用下面指令安装

rpm -qa | grep gnome-desktop > /dev/null 2>&1 || yum -y groupinstall "X Window System" "Desktop" > /dev/null 2>&1

xhost +
export DISPLAY=:0.0  
#查看内存是否满足

if [ $(grep MemTotal /proc/meminfo | awk '{print $2}') -ge 1048576 ];then
    echo "memory OK"
else
    echo "please add the memory"
fi

if [ $(grep SwapTotal /proc/meminfo | awk '{print $2}') -ge 1572864 ];then
    echo "swap OK"
else
    echo "please add the swap"
fi

#创建oracle用户组       
grep dba /etc/group > /dev/null || /usr/sbin/groupadd dba 
grep oinstall /etc/group > /dev/null|| /usr/sbin/groupadd oinstall
id oracle > /dev/null 2>&1 && /usr/sbin/usermod -g oinstall -G dba oracle || /usr/sbin/useradd  -g oinstall -G dba oracle && echo "123456" | /usr/bin/passwd --stdin oracle

#修改内核参数

echo "fs.aio-max-nr = 1048576" >> /etc/sysctl.conf
echo "fs.file-max = 6815744" >> /etc/sysctl.conf
echo "kernel.shmall = 2097152" >> /etc/sysctl.conf
echo "kernel.shmmax = 536870912" >> /etc/sysctl.conf
echo "kernel.shmmni = 4096" >> /etc/sysctl.conf
echo "kernel.sem = 250 32000 100 128" >> /etc/sysctl.conf
echo "net.ipv4.ip_local_port_range = 9000 65500" >> /etc/sysctl.conf
echo "net.core.rmem_default = 262144" >> /etc/sysctl.conf
echo "net.core.rmem_max = 4194304" >> /etc/sysctl.conf
echo "net.core.wmem_default = 262144" >> /etc/sysctl.conf
echo "net.core.wmem_max = 1048576" >> /etc/sysctl.conf
/sbin/sysctl -p > /dev/null 2>&1

#修改oracle用户的资源限制

echo "racle    soft    nproc    2047" >>/etc/security/limits.conf
echo "oracle   hard    nproc    16384" >>/etc/security/limits.conf
echo "oracle   soft    nofile   1024" >>/etc/security/limits.conf
echo "oracle   hard    nofile   65536" >>/etc/security/limits.conf
source /etc/security/limits.conf

#创建安装目录
mkdir -p /opt/oracle
mkdir -p /opt/oracle/product/11.2.0/db_1mkdir -p /opt/oracle/product/11.2.0/db_1
mkdir -p /opt/oracle/oradata
chown -R oracle:oinstall /opt/oracle
chmod -R 775 /opt/oracle
#设置oracle环境变量

echo "export ORACLE_BASE=/opt/oracle" >> /home/oracle/.bash_profile
echo "export ORACLE_HOME=$ORACLE_BASE/product/11.2.0/db_1" >> /home/oracle/.bash_profile
echo "export ORACLE_SID=zabbix" >> /home/oracle/.bash_profile
echo "export PATH=$PATH:/opt/oracle/product/11.2.0/db_1/bin/" >> /home/oracle/.bash_profile

#安装
su - oracle && ./opt/oracle/database/runInstaller

