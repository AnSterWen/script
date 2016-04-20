
#!/bin/bash 
# Filename:    sendSMS.sh 
# Revision:    1.0 
# Date:        2014/09/11 
# Author:      Qicheng 
# Email: 
# Website:     http://qicheng0211.blog.51cto.com/ 
# Description: zabbix短信告警脚本 
# Notes:       短信网关使用了中国网建SMS短信通 
  # 脚本的日志文件 
  LOGFILE="/tmp/SMS.log"
  :>"$LOGFILE"
  exec 1>"$LOGFILE"
  exec 2>&1 
    
  # Uid和Key的值需要自行修改，http://www.smschinese.cn/api.shtml 
  # Uid 网站用户名 
    # Key 接口秘钥 
    Uid="xxxxxx"
    Key="xxxxxx"
      
    MOBILE_NUMBER=$1    # 手机号码 
    MESSAGE_UTF8=$3        # 短信内容 
    XXD="/usr/bin/xxd"
    CURL="/usr/bin/curl"
    TIMEOUT=5 
        
# 短信内容要经过URL编码处理，除了下面这种方法，也可以用curl的--data-urlencode选项实现。 
MESSAGE_ENCODE=$(echo "$MESSAGE_UTF8" | ${XXD} -ps | sed 's/\(..\)/%\1/g' | tr -d '\n') 
# SMS API 
URL="http://utf8.sms.webchinese.cn/?Uid=${Uid}&Key=${Key}&smsMob=${MOBILE_NUMBER}&smsText=${MESSAGE_ENCODE}"
# Send it 
set -x 
${CURL} -s --connect-timeout ${TIMEOUT} "${URL}" 

