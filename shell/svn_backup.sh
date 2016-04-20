#!/bin/bash
TIME1=$(date "+%Y%m%d")
TIME2=$(date --date="-2 week" "+%Y%m%d")
ID=$(date +%u)
#REPOS_PATH="/opt/svn/adventure/client/ /opt/svn/adventure/server/ /opt/svn/ago/ /opt/svn/isser/ /opt/svn/platform/client/ /opt/svn/platform/server/ /opt/svn/otc/sdk-tools/"
REPOS_PATH="/opt/svn/sdk"
BACKUP_DIR="/opt/new_svn"

[ -d $BACKUP_DIR/$TIME1 ] || mkdir -p $BACKUP_DIR/$TIME1

full_backup()
{
    for i in $REPOS_PATH
    do
        [ -d $BACKUP_DIR/$TIME1/$i ] || mkdir -p $BACKUP_DIR/$TIME1/$i
        svnadmin hotcopy $i  $BACKUP_DIR/$TIME1/${i}_$TIME1
        lastsvn=$(svnlook youngest $i)
        echo $lastsvn > $BACKUP_DIR/$TIME1/$i/youngest.txt
    done
    
}

increment_backup()
{
    for i in $REPOS_PATH
    do
        [ -d $BACKUP_DIR/$TIME1/$i ] || mkdir -p $BACKUP_DIR/$TIME1/$i
        lower=$(cat $BACKUP_DIR/$TIME1$i/youngest.txt)
        upper=$(svnlook youngest $i)
        svnadmin dump $i -r $lower:$upper --incremental > $BACKUP_DIR/$TIME1/$i.dump$TIME1
        echo $upper > $BACKUP_DIR/$TIME1/$i/youngest.txt
    done
}
keep_log()
{
    for i in $(ls $BACKUP_DIR)
    do
        if [ $i -lt $TIME2 ];then
            rm -rf $BACKUP_DIR/$i
        fi
    done
}

if [ $ID -eq 7 ];then
    full_backup
else
    increment_backup
fi

keep_log





