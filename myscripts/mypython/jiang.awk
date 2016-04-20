#!/bin/awk -f
BEGIN {
      name="姓名"
      daiyu="待遇"
      time="时间"
      printf("%-8s%-8s%-8s\n",name,daiyu,time)
      } 
/^M.*/ {printf("%-10s%s\t\t%-15d\n",$1,$2,$3)}

