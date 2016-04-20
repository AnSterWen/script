#!/bin/bash
'''
apt-get(Advanced Packaging Tool) 是debian系统下软件包管理工具，在命令行下使用，欲使用该命令，需先配置source源

debian源(/etc/apt/sources.list)的配置:
在该文件中配置了拉取软件包的源的地址列表，该文件的配置语法如下：
........................................................................................
deb http://site.example.com/debian distribution component1 component2 component3
deb-src http://site.example.com/debian distribution component1 component2 component3
........................................................................................
该文件中每行代表一个源地址
1. deb 或 deb-src :
               每行的第一部分，代表软件包的类型，deb表示是二进制包，deb-src表示源码包
2. http://site.example.com/debian ：
               表示软件包的url地址，主要的镜像列表有：https://www.debian.org/mirror/list
3. distribution :
               该部分表示debian系统的版本号，可以是版本发布的代号名称(squeeze, wheezy, jessie, sid),也可以是
	       也可以是发布类别(oldstable, stable, testing, unstable)
	       代号与版本的对应如下：
	       lenny   ===========>>  Debian 5.0
	       squeeze ===========>>  Debian 6.0
	       wheezy  ===========>>  Debian 7.0
               jessie  ===========>>  Debian 8.0
               
	       oldstable :是以前的稳定发行版了
	       stable :现在的稳定发行版
	       testing:指目前还暂时处于测试阶段的debian发行版
	       unstable:不稳定版本了
4. component1 component2 component3:
               该部分对应的软件类别(contrib main non-free)
	       main ：表示debian里基本的符合自由软件规范的包
	       contrib ： 表示依赖非自由软件的包
	       non-free ：不属于自由软件的包
常用的源配置如下:
.........................................................................
debian5的
deb http://archive.debian.org/debian lenny contrib main non-free
deb-src http://archive.debian.org/debian lenny contrib main non-free
.........................................................................
debian6的
deb ftp://ftp.debian.org/debian/ squeeze main contrib non-free
deb-src ftp://ftp.debian.org/debian/ squeeze main contrib non-free
.........................................................................
debian7的
deb ftp://ftp.debian.org/debian/ wheezy main contrib non-free
deb-src ftp://ftp.debian.org/debian/ wheezy  main contrib non-free
..........................................................................
deb http://mirror.nus.edu.sg/Debian squeeze main
deb-src http://mirror.nus.edu.sg/Debian/ squeeze main
deb http://mirrors.163.com/debian wheezy main non-free contrib
deb-src http://mirrors.163.com/debian wheezy main non-free contrib
..................................................................................................
apt-get 的使用:
apt-get update :当更新了源sources.list文件后需要执行该指令，同步包的本地索引文件
apt-get upgrade :该命令用来把当前系统上已经安装的包更新到源上的最新版本，该指令一般不用
apt-get install :后跟要安装的软件包的名字
apt-get remove : 卸载指定的包，但是配置文件不会被删除
apt-get purge  : 卸载指定的包并删除配置文件
apt-get download :下载二进制软件包到当前的目录
apt-get clean    :清除/var/cache/apt/archives/目录下的二进制软件包
apt-get autoclean :清除无用的二进制软件包
apt-get autoremove :清除那些为解决依赖关系而被自动安装的现在不再使用的包，该指令一般不用
####################################################################################################
dpkg 的使用
dpkg -i vsftpd_2.3.5-3_i386.deb :安装软件包
dpkg -r vsftpd                  :卸载软件包,但保留配置文件
dpkg -P vsftpd                  :卸载软件包,并删除配置文件
dpkg -l vsftpd                  :查看软件包是否安装，若不跟包名会列出当前已安装的软件包
dpkg -L vsftpd                  :列出与该软件包有关的文件
dpkg -s vsftpd                  :列出软件包的详细信息
dpkg -p vsftpd                  :列出软件包的详细信息
dpkg -S /etc/vsftpd.conf        :查看某个文件所属的软件包的名称
dpkg -c vsftpd_2.3.5-3_i386.deb :列出软件包内的文件列表
#######################################################################################################
aptitude 的使用
aptitude install    :安装软件包,install后面可以跟一个或多个软件包
aptitude  remove    : 卸载软件包,保留配置文件
aptitude  purge     :卸载软件包并删除其配置文件。
aptitude  update    :更新软件包列表。
aptitude  search    :搜索可以安装的软件包
aptitude  show       - 显示一个软件包的详细信息。
aptitude  versions     - Displays the versions of specified packages.
aptitude  clean        - 删除已下载的软件包文件。
aptitude  autoclean    - 删除旧的已下载软件包文件。
aptitude  changelog    - 查看一个软件包的变更日志。
aptitude  download     - 下载软件包的 .deb 文件。
aptitude  reinstall    - 下载并(可能)重新安装一个现在已经安装了的软件包。
aptitude  why          - Show the manually installed packages that require a package, or
aptitude                 why one or more packages would require the given package.
aptitude  why-not     - 显示导致与给定软件包包冲突的手动安装的包，或者为什么
                 如果安装一个或多个软件包会导致与给定软件包冲突。





















