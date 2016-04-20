<?php
//字体样式
define('ACCOUNT_FONT_SIMPLIFIED',   1);//简体
define('ACCOUNT_FONT_COMPLEX',      2);//繁体
define('ACCOUNT_FONT_ENGLISH',      3);//英文

//session有效时长：单位秒
define('ACCOUNT_SESSION_VALID_TIME', 3600);
define('ACCOUNT_ACCESS_TOKE_PRIVATE_KEY','816a22241aa666e029cefdf61fd297c8');

// userid key type
define('ACCOUNT_KEY_TYPE_NAME', 1);
define('ACCOUNT_KEY_TYPE_EMAIL', 2);
define('ACCOUNT_KEY_TYPE_UDID', 3);

// 协议号编码
define('ACCOUNT_PROTO_MIN_VALUE',       10001); //协议号最小值
define('ACCOUNT_PROTO_REGISTER',        10001); //账号注册协议
define('ACCOUNT_PROTO_LOGIN',           10002); //账号验证协议
define('ACCOUNT_PROTO_CHECK_NAME_EMAIL',10003); //验证账号绑定邮箱是否一致
define('ACCOUNT_PROTO_RESET_PASSWORD',  10004); //重置密码协议
define('ACCOUNT_PROTO_CHECK_SESSION',   10005); //session验证协议
define('ACCOUNT_PROTO_MODIFY_PASSWORD_BY_OLD', 10006); // 原密码修改密码
define('ACCOUNT_PROTO_GET_USERINFO_BY_ID', 10007); // 查询用户信息
define('ACCOUNT_PROTO_GET_USERINFO_BY_NAME', 10008); // 查询用户信息
define('ACCOUNT_PROTO_MAX_VALUE',       10008); //协议号最大值


////////////////////////////////错误码部分////////////////////////////////
// 公用错误码
define ('ACCOUNT_ERR_OK',                   0); //处理成功
define ('ACCOUNT_ERR_SYS_ERR',          10001); //系统处理错误
define ('ACCOUNT_ERR_SYS_BUSY',         10002); //系统繁忙
define('ACCOUNT_ERR_FORBIDDEN_IP',      10003); //IP被限制
define ('ACCOUNT_ERR_INVALID_SIGN',     10004); //签名无效
define ('ACCOUNT_ERR_INVALID_PARAMS',   10005); //无效的参数
define ('ACCOUNT_ERR_INVALID_ACTION',   10006); //无效的action值
define ('ACCOUNT_ERR_INVALID_SERVICE',  10007); //无效的service值
define ('ACCOUNT_ERR_INVALID_CHANNEL',  10008); //无效的channel值
define ('ACCOUNT_ERR_INVALID_EMAIL',    10009); //邮箱格式错误
define ('ACCOUNT_ERR_INVALID_NAME',     10010); //账号名格式错误
define ('ACCOUNT_ERR_INVALID_PASSWD',   10011); //账号密码格式错误

// 注册错误码
define('ACCOUNT_ERR_NAME_USED', 11001); //账号名已经使用过
define('ACCOUNT_ERR_EMAIL_USED', 11002);//Email已经被使用过

// 登录错误码
define('ACCOUNT_ERR_WRONG_NAME',    12001); //账号名不存在
define('ACCOUNT_ERR_WRONG_PASSWD',  12002); //密码错误
define('ACCOUNT_ERR_USER_FROZEN',   12003); //账号被冻结
define('ACCOUNT_ERR_NAME_EMAIL',    12004); //账号与绑定email不一致
define('ACCOUNT_ERR_USERID_NOTEXIST', 12005); //账号ID不存在

// session验证错误码
define('ACCOUNT_ERR_SESSION_NOTEXIST',  13001); //session不存在
define('ACCOUNT_ERR_SESSION_EXPIRE',    13002); //session已过期
define('ACCOUNT_ERR_SESSION_WRONG_USER',13003); //session与用户ID不匹配



function get_account_error_description($err_code, $language = 1)
{
    switch ($language) {
    case ACCOUNT_FONT_SIMPLIFIED:
        return get_account_simple_error_description($err_code);
    case ACCOUNT_FONT_COMPLEX:
        return get_account_complex_error_description($err_code);
    case ACCOUNT_FONT_ENGLISH:
        return get_account_english_error_description($err_code);
    default:
        return "UNKOWN ERROR";
    }
}

function get_account_simple_error_description($err_code)
{
    $err_desc = '';
    switch ($err_code) {
    case ACCOUNT_ERR_OK:
        $err_desc = 'SUCCESS';
        break;
    case ACCOUNT_ERR_SYS_ERR:
        $err_desc = '系统处理错误';
        break;
    case ACCOUNT_ERR_SYS_BUSY:
        $err_desc = '系统繁忙';
        break;
    case ACCOUNT_ERR_FORBIDDEN_IP:
        $err_desc = 'IP被限制';
        break;
    case ACCOUNT_ERR_INVALID_SIGN:
        $err_desc = '签名无效';
        break;
    case ACCOUNT_ERR_INVALID_PARAMS:
        $err_desc = '参数无效';
        break;
    case ACCOUNT_ERR_INVALID_ACTION:
        $err_desc = '无效的action值';
        break;
    case ACCOUNT_ERR_INVALID_SERVICE:
        $err_desc = '无效的service值';
        break;
    case ACCOUNT_ERR_INVALID_CHANNEL:
        $err_desc = '无效的channel值';
        break;
    case ACCOUNT_ERR_INVALID_EMAIL:
        $err_desc = '邮箱格式错误';
        break;
    case ACCOUNT_ERR_INVALID_NAME:
        $err_desc = '账号名格式错误';
        break;
    case ACCOUNT_ERR_INVALID_PASSWD:
        $err_desc = '密码格式错误';
        break;

    //注册错误码
    case ACCOUNT_ERR_NAME_USED:
        $err_desc = '账号名已经使用过';
        break;
    case ACCOUNT_ERR_EMAIL_USED:
        $err_desc = 'Email已经被使用过';
        break;

    //登录验证错误码
    case ACCOUNT_ERR_WRONG_NAME:
        $err_desc = '账号名不存在';
        break;
    case ACCOUNT_ERR_WRONG_PASSWD:
        $err_desc = '密码错误';
        break;
    case ACCOUNT_ERR_USER_FROZEN:
        $err_desc = '账号未激活';
        break;
    case ACCOUNT_ERR_NAME_EMAIL:
        $err_desc = '账号与绑定Email不一致';
        break;
    case ACCOUNT_ERR_USERID_NOTEXIST:
        $err_desc = '账号ID不存在';
        break;
    case ACCOUNT_ERR_SESSION_NOTEXIST:
        $err_desc = 'session不存在';
        break;
    case ACCOUNT_ERR_SESSION_EXPIRE:
        $err_desc = 'session已过期';
        break;
    case ACCOUNT_ERR_SESSION_WRONG_USER:
        $err_desc = 'session与用户ID不匹配';
        break;

    default:
        $err_desc = 'UNKOWN ERROR';
        break;
    }

    return $err_desc;
}

function get_account_complex_error_description($err_code)
{
    $err_desc = '';
    switch ($err_code) {
    case ACCOUNT_ERR_OK:
        $err_desc = 'SUCCESS';
        break;
    case ACCOUNT_ERR_SYS_ERR:
        $err_desc = '系統錯誤';
        break;
    case ACCOUNT_ERR_SYS_BUSY:
        $err_desc = '系統繁忙';
        break;
    case ACCOUNT_ERR_FORBIDDEN_IP:
        $err_desc = 'IP被限制';
        break;
    case ACCOUNT_ERR_INVALID_SIGN:
        $err_desc = '簽名無效';
        break;
    case ACCOUNT_ERR_INVALID_PARAMS:
        $err_desc = '參數無效';
        break;
    case ACCOUNT_ERR_INVALID_ACTION:
        $err_desc = '無效的action值';
        break;
    case ACCOUNT_ERR_INVALID_SERVICE:
        $err_desc = '無效的service值';
        break;
    case ACCOUNT_ERR_INVALID_CHANNEL:
        $err_desc = '無效的channel值';
        break;
    case ACCOUNT_ERR_INVALID_EMAIL:
        $err_desc = '郵箱格式錯誤';
        break;
    case ACCOUNT_ERR_INVALID_NAME:
        $err_desc = '帳號名格式錯誤';
        break;
    case ACCOUNT_ERR_INVALID_PASSWD:
        $err_desc = '密碼格式錯誤';
        break;

    //注册错误码
    case ACCOUNT_ERR_NAME_USED:
        $err_desc = '帳號名已經使用過';
        break;
    case ACCOUNT_ERR_EMAIL_USED:
        $err_desc = 'Email已經被使用過';
        break;

    //登录验证错误码
    case ACCOUNT_ERR_WRONG_NAME:
        $err_desc = '帳號名不存在';
        break;
    case ACCOUNT_ERR_WRONG_PASSWD:
        $err_desc = '密碼錯誤';
        break;
    case ACCOUNT_ERR_USER_FROZEN:
        $err_desc = '帳號未啟動';
        break;
    case ACCOUNT_ERR_NAME_EMAIL:
        $err_desc = '帳號與綁定Email不一致';
        break;
    case ACCOUNT_ERR_USERID_NOTEXIST:
        $err_desc = '帳號ID不存在';
        break;
    case ACCOUNT_ERR_SESSION_NOTEXIST:
        $err_desc = 'session不存在';
        break;
    case ACCOUNT_ERR_SESSION_EXPIRE:
        $err_desc = 'session已過期';
        break;
    case ACCOUNT_ERR_SESSION_WRONG_USER:
        $err_desc = 'session與用戶ID不匹配';
        break;

    default:
        $err_desc = 'UNKOWN ERROR';
        break;
    }

    return $err_desc;
}

function get_account_english_error_description($err_code)
{
    $err_desc = '';
    switch ($err_code) {
    case ACCOUNT_ERR_OK:
        $err_desc = 'SUCCESS';
        break;
    case ACCOUNT_ERR_SYS_ERR:
        $err_desc = 'SYSTEM ERROR';
        break;
    case ACCOUNT_ERR_SYS_BUSY:
        $err_desc = 'SYSTEM BUSY';
        break;
    case ACCOUNT_ERR_FORBIDDEN_IP:
        $err_desc = 'FORBIDDEN IP';
        break;
    case ACCOUNT_ERR_INVALID_SIGN:
        $err_desc = 'INVALID SIGN';
        break;
    case ACCOUNT_ERR_INVALID_PARAMS:
        $err_desc = 'INVALID PARAMS';
        break;
    case ACCOUNT_ERR_INVALID_ACTION:
        $err_desc = 'INVALID ACTION';
        break;
    case ACCOUNT_ERR_INVALID_SERVICE:
        $err_desc = 'INVALID SERVICE';
        break;
    case ACCOUNT_ERR_INVALID_CHANNEL:
        $err_desc = 'INVALID CHANNEL';
        break;
    case ACCOUNT_ERR_INVALID_EMAIL:
        $err_desc = 'INVALID EMAIL';
        break;
    case ACCOUNT_ERR_INVALID_NAME:
        $err_desc = 'INVALID NAME';
        break;
    case ACCOUNT_ERR_INVALID_PASSWD:
        $err_desc = 'INVALID PASSWD';
        break;

    //注册错误码
    case ACCOUNT_ERR_NAME_USED:
        $err_desc = 'NAME HAS BEEN USED';
        break;
    case ACCOUNT_ERR_EMAIL_USED:
        $err_desc = 'EMAIL HAS BEEN USED';
        break;

    //登录验证错误码
    case ACCOUNT_ERR_WRONG_NAME:
        $err_desc = 'NAME NOT EXIST';
        break;
    case ACCOUNT_ERR_WRONG_PASSWD:
        $err_desc = 'WRONG PASSWORD';
        break;
    case ACCOUNT_ERR_USER_FROZEN:
        $err_desc = 'USER FROZEN';
        break;
    case ACCOUNT_ERR_NAME_EMAIL:
        $err_desc = 'WRONG EMAIL';
        break;
    case ACCOUNT_ERR_USERID_NOTEXIST:
        $err_desc = 'USERID NOT EXIST';
        break;
    case ACCOUNT_ERR_SESSION_NOTEXIST:
        $err_desc = 'SESSION NOT EXIST';
        break;
    case ACCOUNT_ERR_SESSION_EXPIRE:
        $err_desc = 'SESSION EXPIRED';
        break;
    case ACCOUNT_ERR_SESSION_WRONG_USER:
        $err_desc = 'WRONG SESSION';
        break;

    default:
        $err_desc = 'UNKOWN ERROR';
        break;
    }

    return $err_desc;
}

?>
