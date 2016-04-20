#!/bin/bash
#install salt on debian7
wget -q -O- "http://debian.saltstack.com/debian-salt-team-joehealy.gpg.key" | apt-key add -
echo "deb http://debian.saltstack.com/debian wheezy-saltstack main">>/etc/apt/source.list
aptitude update
aptitude -y install salt-master 
aptitude -y install salt-minion
