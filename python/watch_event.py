import salt.config
import salt.utils.event
opts = salt.config.client_config('/etc/salt/master')
sevent = salt.utils.event.get_event(
    'master',
    sock_dir=opts['sock_dir'],
    transport=opts['transport'],
    opts=opts)
while True:
    ret = sevent.get_event(full=True)
    if ret is None:
        continue
    else:
        print ret
