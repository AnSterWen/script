#!/bin/bash

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
    ps -ef | grep -v grep | grep -q GW_Ahero-$GATEWAYID
    if [ $? -eq 0 ];then
        echo -e "Gateway Starting \033[31m[FAILED]\033[0m" 
        echo -e "Gateway  \033[31m[Already Running]\033[0m"
    else
        cd /opt/new_ahero/gateway_svc/
        ./bin/GW_Ahero ./bench.conf >/dev/null
        sleep 2
        ps -ef | grep -v grep | grep -q GW_Ahero-$GATEWAYID
        if [ $? -eq 0 ];then
            echo -e "Gateway Starting \033[31m[OK]\033[0m"    
        else
	    echo -e "Gateway Starting \033[31m[FAILED]\033[0m"
        fi
    fi
}

gateway_status()
{
    GATEWAYID=$(cat /opt/new_ahero/gateway_svc/bind.conf | grep -v  '^#' | awk '{print $1}')
    ps -ef | grep -v grep | grep -q GW_Ahero-$GATEWAYID
    if [ $? -eq 0 ];then
        echo -e "Gateway-$GATEWAYID \033[31m[Running]\033[0m"
    else
        echo -e "Gateway-$GATEWAYID \033[31m[Stopped]\033[0m"
    fi
}

gateway_update()
{
    TIME=$(date "+%F-%T")
    [ -d /tmp/backup/ ] || mkdir /tmp/backup/
    if [ "$1" = "libgateway.so" ];then
        if [ ! -f /root/lush/libgateway.so ];then
            echo -e "$1 \033[31m[doesn't exit]\033[0m"
	    exit 1
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
	        exit 2
	    fi
        else
            echo -e "libgateway.so \033[31m[doesn't exit]\033[0m"
        fi
    else
        echo "./gateway.sh update libgateway.so"
	exit 3
    fi
}

if [ "$1" = "stop" ];then
    gateway_stop
elif [ "$1" = "start" ];then
    gateway_start
elif [ "$1" = "restart" ];then
    gateway_stop
    gateway_start
elif [ "$1" = "status" ];then
    gateway_status
elif [ "$1" = "update" ];then
    gateway_stop
    gateway_update $2
    gateway_start
else
    echo "./gateway.sh [stop|start|restart|status|update libgateway.so]"
fi



