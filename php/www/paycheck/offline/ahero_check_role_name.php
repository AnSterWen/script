<?php
/**
 * 检查AHERO角色名是否存在
 * 用于线下充值
 */
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once (dirname(dirname(__FILE__)) . "/config/offline.config.php");
require_once (dirname(dirname(__FILE__)) . "/model/web.db.model.php");
require_once (dirname(dirname(__FILE__)) . "/lib/Log.class.php");

global $logger;
$logger = new Log("offline/ahero_check_role_name_", LOG_DIR);

$client_ip = getClientIp();
write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero check role name start]");
write_log("info", __FILE__, __FUNCTION__, __LINE__, "REQUEST_URI:" . urldecode($_SERVER['REQUEST_URI']));
write_log("info", __FILE__, __FUNCTION__, __LINE__, "_REQUEST: " . print_r($_REQUEST, true));
write_log("info", __FILE__, __FUNCTION__, __LINE__, "CLIENT_IP:" . $client_ip);

// 判断请求IP是否在白名单中
global $g_white_list;
if ( !empty($g_white_list) && !in_array($client_ip, $g_white_list) ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "IP({$client_ip}) forbidden");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero check role name end]");
    json_resp(RESULT_ERR_INVALID_IP);
}

// 获取参数
$request = array();
foreach (array(
            'role_name',
            'server_id',
            'sign'
        ) as $key) {
    if (!isset($_REQUEST[$key])) {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: lack of parameter {$key}");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero check role name end]");
        json_resp(RESULT_ERR_INVALID_PARAMETER);
    }
    $request[$key] = $_REQUEST[$key];
}

// 验证签名
if ( !check_md5_sign($request) ) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: check md5 sign failed");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero check role name end]");
    json_resp(RESULT_ERR_INVALID_SIGN);
}

// 检查游戏服务器
global $g_server_list;
$request['server_id'] = (int)$request['server_id'];
if (!isset($g_server_list[$request['server_id']])) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: invalid server id {$request['server_id']}");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero check role name end]");
    json_resp(RESULT_ERR_INVALID_PARAMETER);
}
$server = $g_server_list[$request['server_id']];

// 验证角色名
$model = new dbModel();
$model->ip = $server['ip'];
$model->port = $server['port'];
$role = $model->get_user_by_nickname($request['role_name'], $request['server_id']);
write_log("info", __FILE__, __FUNCTION__, __LINE__, "ROLE: " . print_r($role, true));
if (!isset($role['result']) || $role['result'] !== 0
        || !isset($role['data']['userid'])) {
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "ERROR: check role name failed");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero check role name end]");
    json_resp(RESULT_ERR_INVALID_ROLE_NAME);
}

write_log("info", __FILE__, __FUNCTION__, __LINE__, "OK");
write_log("info", __FILE__, __FUNCTION__, __LINE__, "[ahero check role name end]");
json_resp(RESULT_OK);
