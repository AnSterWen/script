#!/bin/bash
echo "export JAVA_HOME=/usr/local/jdk" >> /etc/profile
echo "export CLASSPATH=$JAVA_HOME/lib:$JAVA_HOME/jre/lib" >> /etc/profile
echo "export PATH=$PATH:$JAVA_HOME/bin"  >> /etc/profile
source /etc/profile
