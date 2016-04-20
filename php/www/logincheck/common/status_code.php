<?php

define ("ACCOUNT_E_SUCCESS",			0); 	//处理成功
define ("ACCOUNT_E_SYSTEM_ERROR",		1001); 	//系统处理错误
define ("ACCOUNT_E_INVALID_PARAMS", 	1002); 	//无效的参数
define ("ACCOUNT_E_INVALID_ACTION",		1003); 	//无效的action值
define ("ACCOUNT_E_SYSTEM_BUSY",        1004); 	//系统繁忙
define ("ACCOUNT_E_BACK_SYSTEM_BUSY",	1005); 	//后台系统繁忙
define ("ACCOUNT_E_INVALID_SIGN",       1006);  //签名失败
define ("ACCOUNT_E_REQUEST_TIMEOUT",    1007);  //客户端请求时间戳已经过期
define ("ACCOUNT_E_INVALID_USERID",     1008);  //无效的米米号

define ("ACCOUNT_E_TOO_MUCH_WRONG",     1010);  // 接口错误次数过多或接口尝试次数过多
define ("ACCOUNT_E_PASSWD_ALREADY_SET", 1011);  // 无线第一次设置密码时密码已经被设置过了
define ("ACCOUNT_E_WRONG_OLD_PASSWD",   1012);  // 用老密码修改新密码时老密码错误
define ("ACCOUNT_E_UDID_NOT_REGISTER",  1013);  // 查询设备号对应米米号时设备号未注册过
define ("ACCOUNT_E_CHECK_VERIFY_CODE_FAILED",   1014);  // 检测验证码错误
define("ACCOUNT_E_CHECK_USERID_ERROR",1015);
define("ACCOUNT_E_CHECK_USER_EMAIL_FAILE",1016);
define("ACCOUNT_E_CHECK_EMAIL",1017);
define("ACCOUNT_E_EMAIL_EXISTED",1019);
define("ACCOUNT_E_EMAIL_BIND_ERROR",1020);
define("ACCOUNT_E_SYS_ERROR",1018);
define("ACCOUNT_E_SEND_ERROR",1021);
define("ACCOUNT_E_PWD_ERROR",1103);
define("ACCOUNT_E_NOT_EXISTED_ERROR",1105);

define("ACCOUNT_E_THIRD_CHECK_FIALED", 1112);
define("ACCOUNT_E_VERIFY_ERROR", 1113);

define("ACCOUNT_SING_KEY",'1313154ADFASDFdfsdf#@k');
?>
