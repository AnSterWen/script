<?php
error_reporting(0);
date_default_timezone_set('Asia/Taipei');
require_once (dirname(__FILE__) . "/config/common.config.php");
require_once (dirname(__FILE__) . "/lib/functions.php");
require_once (dirname(__FILE__) . "/model/common.db.model.php");

function select_action()
{
    $response = array('status_code' => ACCOUNT_ERR_SYS_ERR);
    // if ( !check_sign() ) {
    //     $response = array('status_code' => ACCOUNT_ERR_INVALID_SIGN);
    //     return $response;
    // }

    $service = isset($_REQUEST['service']) ? intval($_REQUEST['service']) : 0;

    switch ($service) {
    case  ACCOUNT_PROTO_REGISTER://账号注册协议
        $response =  account_register();
        break;
    case  ACCOUNT_PROTO_LOGIN://账号验证协议
        $response =  account_login_verify();
        break;
    case  ACCOUNT_PROTO_CHECK_NAME_EMAIL://验证账号绑定邮箱是否一致
        $response =  account_check_name_email();
        break;
    case  ACCOUNT_PROTO_RESET_PASSWORD://重置密码协议
        $response =  account_reset_password();
        break;
    case  ACCOUNT_PROTO_CHECK_SESSION://session验证协议
        $response =  account_check_session();
        break;
    case ACCOUNT_PROTO_MODIFY_PASSWORD_BY_OLD:// 原密码修改密码
        $response =  account_modify_password_by_old();
        break;
    case ACCOUNT_PROTO_GET_USERINFO_BY_ID:// 查询用户信息
        $response =  account_get_userinfo_by_id();
        break;
    case ACCOUNT_PROTO_GET_USERINFO_BY_NAME:// 查询用户信息
        $response =  account_get_userinfo_by_name();
        break;
    default:
        $response = array('status_code' => ACCOUNT_ERR_INVALID_SERVICE);
        break;
    }

    return $response;
}


function account_register()
{
    $response = array('status_code' => ACCOUNT_ERR_SYS_ERR);

    require_once 'model/register.class.php';

    $channel_id = $_REQUEST['channel'];
    $user_name = $_REQUEST['name'];
    $user_passwd = $_REQUEST['passwd'];
    $user_email = trim($_REQUEST['email']);

    $register_handler = new c_account_register($channel_id, $user_name, $user_passwd, $user_email);

    $result = $register_handler->start_register();
    if ($result == ACCOUNT_ERR_OK) {
        $response['user_id'] = $register_handler->get_user_id();
    }
    $response['status_code'] = $result;

    return $response;
}

function account_login_verify()
{
    $response = array('status_code' => ACCOUNT_ERR_SYS_ERR);

    require_once 'model/account_verfiy.class.php';

    $channel_id = $_REQUEST['channel'];
    $user_name = $_REQUEST['name'];
    $user_passwd = $_REQUEST['passwd'];

    $login_handler = new c_account_verify($channel_id, $user_name, $user_passwd);

    $result = $login_handler->check_account_password();
    if ($result == ACCOUNT_ERR_OK) {
        $response['user_id'] = $login_handler->get_user_id();
        $response['access_token'] = $login_handler->get_access_token();
    }
    $response['status_code'] = $result;

    return $response;
}

function account_check_name_email()
{
    $response = array('status_code' => ACCOUNT_ERR_SYS_ERR);

    require_once 'model/account_bind_email.class.php';

    $channel_id = $_REQUEST['channel'];
    $user_name = $_REQUEST['name'];
    $user_email = $_REQUEST['email'];

    $login_handler = new c_account_bind_email($channel_id, $user_name, $user_email);

    $result = $login_handler->check_account_bind_email();
    if ($result == ACCOUNT_ERR_OK) {
        $response['user_id'] = $login_handler->get_user_id();
    }
    $response['status_code'] = $result;

    return $response;
}

function account_reset_password()
{
    $response = array('status_code' => ACCOUNT_ERR_SYS_ERR);

    require_once 'model/account_reset_passwd.class.php';

    $channel_id = $_REQUEST['channel'];
    $user_name = $_REQUEST['name'];
    $user_email = $_REQUEST['email'];
    $new_passwd = md5($_REQUEST['newpwd']);

    $login_handler = new c_account_reset_passwd($channel_id, $user_name, $user_email, $new_passwd);

    $result = $login_handler->reset_account_password();
    if ($result == ACCOUNT_ERR_OK) {
        $response['user_id'] = $login_handler->get_user_id();
    }
    $response['status_code'] = $result;

    return $response;
}

function account_check_session()
{
    $response = array('status_code' => ACCOUNT_ERR_SYS_ERR);

    require_once 'model/account_session.class.php';

    $user_id = $_REQUEST['user_id'];
    $session = $_REQUEST['session'];

    $session_handler = new c_account_session($user_id, $session);

    $response['status_code'] = $session_handler->check_session();

    return $response;
}

function account_modify_password_by_old()
{
    $response = array('status_code' => ACCOUNT_ERR_SYS_ERR);

    require_once 'model/account_modify_password_by_old.class.php';

    $channel_id = $_REQUEST['channel'];
    $user_name = $_REQUEST['name'];
    $old_passwd = $_REQUEST['oldpwd'];
    $new_passwd = $_REQUEST['newpwd'];

    $handler = new c_account_modify_password_by_old($channel_id, $user_name, $old_passwd, $new_passwd);

    $result = $handler->modify_password_by_old();
    if ($result == ACCOUNT_ERR_OK) {
        $response['user_id'] = $handler->get_user_id();
    }
    $response['status_code'] = $result;

    return $response;
}

function account_get_userinfo_by_id()
{
    $response = array('status_code' => ACCOUNT_ERR_SYS_ERR);

    require_once 'model/account_get_userinfo_by_id.class.php';

    $channel_id = $_REQUEST['channel'];
    $user_id = $_REQUEST['user_id'] & 0xFFFFFFFF;

    $handler = new c_account_get_userinfo_by_id($channel_id, $user_id);

    $result = $handler->get_userinfo_by_id();
    if (is_array($result)) {
        $response['status_code'] = ACCOUNT_ERR_OK;
        $response['userinfo'] = $result;
    } else {
        $response['status_code'] = $result;
    }

    return $response;
}

function account_get_userinfo_by_name()
{
    $response = array('status_code' => ACCOUNT_ERR_SYS_ERR);

    require_once 'model/account_get_userinfo_by_name.class.php';

    $channel_id = $_REQUEST['channel'];
    $user_name = $_REQUEST['user_name'];

    $handler = new c_account_get_userinfo_by_name($channel_id, $user_name);

    $result = $handler->get_userinfo_by_name();
    if (is_array($result)) {
        $response['status_code'] = ACCOUNT_ERR_OK;
        $response['userinfo'] = $result;
    } else {
        $response['status_code'] = $result;
    }

    return $response;
}

global $g_logger;
$g_logger = new Log("account_service_", LOG_DIR);
session_start();
$client_ip = get_client_ip();
write_log("info", __FILE__, __FUNCTION__, __LINE__, "[register start]");
write_log("info", __FILE__, __FUNCTION__, __LINE__, "REQUEST_URI:" . urldecode($_SERVER['REQUEST_URI']));
write_log("info", __FILE__, __FUNCTION__, __LINE__, "_REQUEST: " . print_r($_REQUEST, true));
write_log("info", __FILE__, __FUNCTION__, __LINE__, "CLIENT_IP:" . $client_ip);
$response = select_action();
$result = $response['status_code'];
if ($result != ACCOUNT_ERR_OK) {
    $response['message'] = get_account_error_description($result, ACCOUNT_FONT_COMPLEX);//繁体
}

$response_string = json_encode($response);
$g_logger = new Log("account_service_", LOG_DIR);
write_log("info", __FILE__, __FUNCTION__, __LINE__, "response string: {$response_string}");

echo $response_string;

?>
