<?php

define ("PAY_E_SUCCESS",			0); 	//handle success
define ("PAY_E_SYSTEM_ERROR",		1001); 	//system error
define ("PAY_E_INVALID_PARAMS", 	1002);
define ("PAY_E_INVALID_ACTION",		1003);
define ("PAY_E_INVALID_CONTROLLER", 1004);
define ("PAY_E_SYSTEM_BUSY",        1005);
define ("PAY_E_BACK_SYSTEM_BUSY",	1006); 	//server busy
define ("PAY_E_INVALID_SIGN",       1007);  //check sign failed
define ("PAY_E_REQUEST_TIMEOUT",    1008);
define ("PAY_E_INVALID_USERID",     1009);

define ("PAY_E_TOO_MUCH_WRONG",     1010);  // 接口错误次数过多或接口尝试次数过多
define ("PAY_E_PASSWD_ALREADY_SET", 1011);  // 无线第一次设置密码时密码已经被设置过了
define ("PAY_E_WRONG_OLD_PASSWD",   1012);  // 用老密码修改新密码时老密码错误
define ("PAY_E_UDID_NOT_REGISTER",  1013);  // 查询设备号对应米米号时设备号未注册过
define ("PAY_E_CHECK_VERIFY_CODE_FAILED",   1014);  // 检测验证码错误
define("PAY_E_CHECK_USERID_ERROR",1015);
define("PAY_E_CHECK_USER_EMAIL_FAILE",1016);
define("PAY_E_CHECK_EMAIL",1017);
define("PAY_E_EMAIL_EXISTED",1019);
define("PAY_E_EMAIL_BIND_ERROR",1020);
define("PAY_E_SYS_ERROR",1018);
define("PAY_E_SEND_ERROR",1021);
define("PAY_E_PWD_ERROR",1103);
define("PAY_E_NOT_EXISTED_ERROR",1105);
define("PAY_E_VERIFY_ERROR",1112);
define("PAY_E_INITIALIZE_ERROR",1113);

define("PAY_SING_KEY",'1313154ADFASDFdfsdf#@k');
?>
