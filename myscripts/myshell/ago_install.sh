sudo apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0x5a16e7281be7a449
echo "deb http://mirrors.hypo.cn/hhvm/debian wheezy main" >>/etc/apt/sources.list
sudo aptitude update

sudo aptitude -y install expect sshpass rsync redis-server gdb locate hhvm nginx php5 php5-fpm php5-mysql php5-redis
aptitude -y install libglib2.0-0
