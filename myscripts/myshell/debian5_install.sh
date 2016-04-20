COMMAND = '/home/rworldadmin/lush/gateway.sh start'
COMMAND = '/home/rworldadmin/lush/gateway.sh status'
COMMAND = 'sudo apt-get -y install libglib2.0-0'
COMMAND = 'sudo apt-get -y install libcurl3'
COMMAND = 'sudo apt-get -y install libdb4.6++'
sudo apt-get -y install libglib2.0-0 libcurl3 libdb4.6++ rsync

sudo mkdir /opt/new_ahero
sudo chown -R rworldadmin.rworldadmin /opt/new_ahero
sudo mkdir /opt/taomee
sudo chmod 777 /opt/taomee
sudo mkdir /opt/new_ahero && sudo chown -R rworldadmin.rworldadmin /opt/new_ahero && sudo mkdir /opt/taomee && sudo chmod 777 /opt/taomee
sudo echo "rworldadmin soft    nofile   1024" >>/etc/security/limits.conf
sudo echo "rworldadmin hard    nofile   65536" >>/etc/security/limits.conf
echo "ulimit -n 65536" >> .bashrc
echo "export EDITOR=/usr/bin/vim" >> .bashrc
32 07 * * * /home/rworldadmin/lush/RU_delete.sh
