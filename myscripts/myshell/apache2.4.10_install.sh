#!/bin/bash
wget http://apache.fayea.com/apache-mirror//httpd/httpd-2.4.10.tar.gz
wget http://mirrors.hust.edu.cn/apache//apr/apr-1.5.1.tar.gz
wget http://mirrors.hust.edu.cn/apache//apr/apr-util-1.5.4.tar.gz
wget ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.34.tar.gz

aptitude install gcc g++ make

tar xf apr-1.5.1.tar.gz
tar xf apr-util-1.5.4.tar.gz
tar xf httpd-2.4.10.tar.gz
mv apr-1.5.1 httpd-2.4.10/srclib/apr
mv apr-util-1.5.4 httpd-2.4.10/srclib/apr-util

cd pcre-8.34 && ./configure && make && make install

cd httpd-2.4.10 && ./configure --prefix=/opt/apache --with-included-apr && make && make install
