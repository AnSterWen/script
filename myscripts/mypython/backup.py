#!/usr/bin/python
import os
import time
source = ['/root/test_backup/test_file', '/root/test_backup_dir']
target_dir = '/root/target_dir/' + time.strftime('%Y%m%d') + '/'
target = target_dir + time.strftime('%H%M%S') + '.zip'
zip_command = "zip -qr '%s' %s" % (target, ' '.join(source))
mkdir_command = 'mkdir -p ' + target_dir
if os.system(mkdir_command) != 0:
        print 'mkdir FAILED'
if os.system(zip_command) == 0 :
        print "Successful backup to", target
else :
        print "Backup FAILED"
