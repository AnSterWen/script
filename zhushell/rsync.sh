#!/bin/bash
HOST=10.1.12.51  #rsync服务所在的机器
SRCDIR=/root/awk #监控的目录
MODULE=zhu
inotifywait -mr --timefmt '%y%m%d %H:%M' --format '%T %w %f' -e close_write,modify,delete,create,attrib $SRCDIR |  while read DATE TIME DIR FILE
do
   echo "time:$DATE $TIME"
   echo "file:$DIR$FILE"
   FILECHANGE=${DIR}${FILE}
   echo "rsync -avz --password-file=/etc/rsyncd.passwd $SRCDIR rsync@$HOST::$MODULE"
   rsync -avz --password-file=/etc/rsyncd.passwd $SRCDIR rsync@$HOST::$MODULE
   echo $?
   echo "$DATE $TIME  $FILECHANGE was changed"
   echo "##########################"
done
