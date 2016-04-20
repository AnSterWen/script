--prefix=PATH :'指定nginx的安装目录，默认路径是/usr/local/nginx'
--sbin-path=PATH ：'指定nginx执行文件的路径，默认是 prefix/sbin/nginx'
--conf-path=PATH : '指定nginx配置文件nginx.conf的路径，默认路径是 prefix/conf/nginx.conf'
--error-log-path=PATH'指定nginx主错误日志文件位置，安装后可在配置文件中对其进行修改，默认路径是prefix/logs/error.log'
--pid-path=PATH ：'指定nginx.pid 文件的路径，该文件保存的是nginx启动后的进程ID号，默认路径是prefix/logs/nginx.pid'
--lock-path=PATH ：'指定nginx.lock文件的路径'
--user=USER ：'设置nginx工作进程的用户，默认是nobody'
--group=GROUP ：'设置nginx工作进程的用户组，默认是nobody'
--http-log-path=PATH '设置主访问日志文件路径，默认是prefix/logs/access.log'
--without-select_module 
--with-select_module  ：'启用或禁用一个模块来允许服务器使用select()方法，如果系统不支持kqueue，epoll，rtsig该模块将自动启用'
-with-poll_module
--without-poll_module :'启用或禁用构建一个模块来允许服务器使用poll()方法,如果平台不支持kqueue，epoll，rtsig,该模块自动建立'
--with-http_ssl_module ：'启用支持https协议的模块，默认不支持该模块，'

















