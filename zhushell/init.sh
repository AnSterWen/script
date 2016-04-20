#!/bin/bash

#add user
awardir="/opt/taomee/stat/"
[ -d $awardir ] || mkdir -p $awardir
useradd -d $awardir -m -s /bin/bash awar
chown -R awar.awar $awardir
