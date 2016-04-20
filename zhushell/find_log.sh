#!/bin/bash
find /opt/new_ahero/*/log/*   -mmin +180 -name "40*-debug-*" -exec rm {} \;
find /opt/new_ahero/db_svc/log/*   -mmin +180 -name "*-debug-*" -exec rm {} \;
find /opt/new_ahero/switch_svc/log/*   -mmin +180 -name "*-debug-*" -exec rm {} \;

