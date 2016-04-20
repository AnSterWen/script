#!/bin/bash

Usage()
{
    echo "./lush.sh -l[gateway|online|file.xml] -c[stop|start|restart|update]"

}

online_stop()
{
    SERVERID=$(cat /opt/new_ahero/online_svc/bind.conf | grep -v '^#' |  awk '{print $1}')
    ps -ef | grep -v grep | grep -q online_sea-$SERVERID
    if [ $? -eq 0 ];then
        pkill -SIGTERM online_sea
        sleep 2
        ps -ef | grep -v grep | grep -q  online_sea-$SERVERID
        if [ $? -eq 0 ];then
            pkill -9 online_sea
            sleep 2
            ps -ef | grep -v grep | grep -q online_sea-$SERVERID
            if [ $? -eq 0 ];then
                echo -e "Online Stopping  \033[31m[FAILED]\033[0m"
                exit 1
            else
                echo -e "Online Stopping  \033[31m[OK]\033[0m"
            fi
        else
            echo -e "Online Stopping  \033[31m[OK]\033[0m"
        fi
    else
            echo -e "Online Stopping  \033[31m[OK]\033[0m"
    fi
}

online_start()
{
    SERVERID=$(cat /opt/new_ahero/online_svc/bind.conf | grep -v '^#' |  awk '{print $1}')
    cd /opt/new_ahero/online_svc
    ./bin/online_sea  ./bench.conf >/dev/null
    sleep 2
    ps -ef | grep -v grep | grep  -q online_sea-$SERVERID
    if [ $? -eq 0 ];then
        echo -e "Online Starting  \033[31m[OK]\033[0m"
    else
        echo -e "Online Starting  \033[31m[FAILED]\033[0m"
    fi
}

update()
{
    TIME=$(date "+%F-%T")
    [ -d /tmp/backup/ ] || mkdir /tmp/backup/
    if [ "$1" = "online" ];then
        if [ ! -f /root/lush/libonline.so ];then
            echo -e "$1 \033[31m[doesn't exit]\033[0m"
	    exit 1
	fi
        MD5_NEW1=$(md5sum /root/lush/libonline.so | awk '{print $1}')
        if [ -f /opt/new_ahero/online_svc/libonline.so ];then
	    \cp -a /opt/new_ahero/online_svc/libonline.so /tmp/backup/libonline.so$TIME
	    \cp -a /root/lush/libonline.so /opt/new_ahero/online_svc/
	    MD5_NEW2=$(md5sum /opt/new_ahero/online_svc/libonline.so | awk '{print $1}')
	    if [ "$MD5_NEW1" = "$MD5_NEW2" ];then
	        echo -e "libonline.so updating  \033[31m[OK]\033[0m"
	    else
	        echo -e "libonline.so updating  \033[31m[FAILED]\033[0m"
		exit 2
	    fi
	else
            echo -e "libonline.so \033[31m[doesn't exit]\033[0m"
	fi
    elif [ "$1" = "gateway" ];then
        if [ ! -f /root/lush/libgateway.so ];then
            echo -e "$1 \033[31m[doesn't exit]\033[0m"
	    exit 3
	fi
        MD5_NEW1=$(md5sum /root/lush/libgateway.so | awk '{print $1}')
        if [ -f /opt/new_ahero/gateway_svc/libgateway.so ];then
	    \cp -a /opt/new_ahero/gateway_svc/libgateway.so /tmp/backup/libgateway.so$TIME
	    \cp -a /root/lush/libgateway.so /opt/new_ahero/gateway_svc/
	    MD5_NEW2=$(md5sum /opt/new_ahero/gateway_svc/libgateway.so | awk '{print $1}')
	    if [ "$MD5_NEW1" = "$MD5_NEW2" ];then
	        echo -e "libgateway.so updating  \033[31m[OK]\033[0m"
	    else
	        echo -e "libgateway.so updating  \033[31m[FAILED]\033[0m"
		exit 4
	    fi
	else
	    echo -e "libgateway.so \033[31m[doesn't exit]\033[0m"
	fi
    elif [ -f /opt/new_ahero/online_svc/conf/$1 ];then
        MD5_NEW1=$(md5sum /root/lush/$1 | awk '{print $1}')
        \cp -a /opt/new_ahero/online_svc/conf/$1 /tmp/backup/$1$TIME >/dev/null 2>&1
        \cp -a /root/lush/$1 /opt/new_ahero/online_svc/conf/ >/dev/null 2>&1
        MD5_NEW2=$(md5sum /opt/new_ahero/online_svc/conf/$1 | awk '{print $1}')
        if [ "$MD5_NEW1" = "$MD5_NEW2" ];then
            echo -e "$1 updating  \033[31m[OK]\033[0m"
        else
            echo -e "$1 updating  \033[31m[FAILED]\033[0m"
            exit 5
	fi
     fi


}

gateway_stop()
{
    GATEWAYID=$(cat /opt/new_ahero/gateway_svc/bind.conf | grep -v  '^#' | awk '{print $1}')
    ps -ef | grep -v grep | grep -q GW_Ahero-$GATEWAYID
    if [ $? -eq 0 ];then
        pkill -SIGTERM GW_Ahero
	sleep 2
	ps -ef | grep -v grep | grep -q GW_Ahero-$GATEWAYID
	if [ $? -eq 0 ];then
	    pkill -9 GW_Ahero
            sleep 2
            ps -ef | grep -v grep | grep -q GW_Ahero-$GATEWAYID
            if [ $? -eq 0 ];then
                echo -e "Gateway Stopping  \033[31m[FAILED]\033[0m"	    
            else
                echo -e "Gateway Stopping  \033[31m[OK]\033[0m"
            fi
	else
            echo -e "Gateway Stopping  \033[31m[OK]\033[0m"
 	fi
    else
        echo -e "Gateway Stopping  \033[31m[OK]\033[0m"
    fi
}


gateway_start()
{
    GATEWAYID=$(cat /opt/new_ahero/gateway_svc/bind.conf | grep -v  '^#' | awk '{print $1}')
    cd /opt/new_ahero/gateway_svc/
    ./bin/GW_Ahero ./bench.conf >/dev/null
    sleep 2
    ps -ef | grep -v grep | grep -q GW_Ahero-$GATEWAYID
    if [ $? -eq 0 ];then
        echo -e "Gateway Starting \033[31m[OK]\033[0m"    
    else
	echo -e "Gateway Starting \033[31m[FAILED]\033[0m"
    fi
}


while getopts "l:c:" arg 
do
    case $arg in
        l)
	    name=$OPTARG
	;;
	c)
	    command=$OPTARG
	;;
       ?) 
            Usage
	;;
    esac
done 

if [ "$name" = "gateway" -a "$command" = "stop" ];then
    gateway_stop
elif [ "$name" = "gateway" -a "$command" = "start" ];then    
    gateway_start
elif [ "$name" = "gateway" -a "$command" = "restart" ];then
    gateway_stop
    gateway_start
elif [ "$name" = "gateway" -a "$command" = "update" ];then
    gateway_stop
    update gateway
    gateway_start
elif [ "$name" = "online" -a "$command" = "stop" ];then
    online_stop
elif [ "$name" = "online" -a "$command" = "start" ];then    
    online_start
elif [ "$name" = "online" -a "$command" = "restart" ];then
    online_stop
    online_start
elif [ "$name" = "online" -a "$command" = "update" ];then
    online_stop
    update online
    online_start
elif [ -f  /opt/new_ahero/online_svc/conf/$name -a "$command" = "update" ];then
    online_stop
    update $name
    online_start
else
    Usage    
fi
