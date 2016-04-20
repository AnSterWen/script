#!/usr/bin/awk -f

BEGIN {
    time = strftime("%Y%m%d",systime())
    system("[ -d /root/zhushell/" time " ] || mkdir /root/zhushell/" time)
    print time
}
