#!/bin/bash

db_stop()
{
    ps -ef | grep -v grep | grep -q rudbsea
    if [ $? -eq 0 ];then
        ps -ef |grep "rudbsea" | awk '{print "kill -9 " $2}'|sh    
        sleep 2
	ps -ef | grep -v grep | grep -q rudbsea
        if [ $? -eq 0 ];then
            echo -e "DB Stopping  \033[31m[FAILED]\033[0m"
                exit 1
        else
            echo -e "DB Stopping  \033[31m[OK]\033[0m"
        fi
    else
        echo -e "DB Stopping  \033[31m[OK]\033[0m"
    fi
}

db_start()
{
    ps -ef | grep -v grep | grep  -q rudbsea
    if [ $? -eq 0 ];then
        echo -e "DB  \033[31m[Already Running]\033[0m"
	exit 1
    else
        cd /opt/new_ahero/db_svc/bin
        ./rudbsea ../etc/bench.conf ./libru_db.so >/dev/null 2>&1
        sleep 2
        ps -ef | grep -v grep | grep  -q rudbsea
        if [ $? -eq 0 ];then
            echo -e "DB Starting  \033[31m[OK]\033[0m"
        else
            echo -e "DB Starting  \033[31m[FAILED]\033[0m"
        fi
    fi
}

db_status()
{
    ps -ef | grep -v grep | grep  -q rudbsea
    if [ $? -eq 0 ];then
        echo -e "DB  \033[31m[Running]\033[0m"
    else
        echo -e "DB   \033[31m[Stopped]\033[0m"
    fi
}


if [ "$1" = "stop" ];then
    db_stop
elif [ "$1" = "start" ];then
    db_start
elif [ "$1" = "restart" ];then
    db_stop
    db_start
elif [ "$1" = "status" ];then
    db_status
else
    echo "./db.sh [stop|start|restart|status]"
fi
