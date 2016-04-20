<?php
error_reporting(0);
date_default_timezone_set('Asia/Taipei');
require_once('common/status_code.php');
require_once('common/logger.class.php');
require_once('common/web_utils.php');
require_once('common/functions.php');
require_once('config/config.php');

function get_channel_params($game, $channel_id)
{
    global $g_game_xml;
    if ( !isset($g_game_xml[$game]) ) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "lack of game({$game}) in g_game_xml");
        return false;
    }
    $file_path = $g_game_xml[$game];
    if ( !file_exists($file_path) ) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "game({$game}) file({$file_path}) not exist");
        return false;
    }

    $param_xml = simplexml_load_file($file_path);

    $channel_param = array();
    foreach ($param_xml->children() as $game_node) {
        if ($game_node['channel_id'] == $channel_id) {
            $channel_param['channel_id'] = $game_node['channel_id'];
            $channel_param['channel_name'] = $game_node['channel_name'];
            $channel_param['app_id'] = $game_node['app_id'];
            $channel_param['app_key'] = $game_node['app_key'];
            $channel_param['app_secret'] = $game_node['app_secret'];
            $channel_param['extra_data'] = $game_node['extra_data'];
            break;
        }
    }
    if ( empty($channel_param) ) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "no game({$game}) channel({$channel_id}) in file({$file_path})");
        return false;
    }

    return $channel_param;
}

function select_action()
{
    write_log("debug", __FILE__, __FUNCTION__, __LINE__, print_r($_REQUEST, true));
    $action = intval(isset($_REQUEST['service'])?$_REQUEST['service']:0);

    // 目前手套只用1016协议
    switch ($action) {
        case '1016':
            $response = verify();
            break;
        default:
            $response = array('status_code' => ACCOUNT_E_INVALID_ACTION);
            break;
    }

    if (isset($_REQUEST['extra_data'])) {
        $response['extra_data'] = $_REQUEST['extra_data'];
    }

    process_response($response, "json");
}

function verify()
{
    $response = array('status_code' => ACCOUNT_E_SYSTEM_ERROR);

    if (!isset($_REQUEST['game']) || empty($_REQUEST['game'])){
        $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
        return $response;
    }
    if (!isset($_REQUEST['channel']) || empty($_REQUEST['channel'])){
        $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
        return $response;
    }
    // if (!check_sign()) {
    //    $response = array('status_code' => ACCOUNT_E_INVALID_SIGN);
    //    return $response;
    // }
    $game_name = $_REQUEST['game'];
    $channel_id = $_REQUEST['channel'];
    $channel_param = get_channel_params($game_name, $channel_id);
    if ($channel_param === false) {
        $response = array('status_code' => ACCOUNT_E_SYSTEM_ERROR);
        return $response;
    }

    require_once 'run/'.'user.class.php';
    $s_controller = new user();
    $a_params['channel_id'] = isset($_REQUEST['channel'])?trim($_REQUEST['channel']):'';
    $a_params['user_id'] = isset($_REQUEST['user_id'])?trim($_REQUEST['user_id']):'';
    $a_params['sess_id'] = isset($_REQUEST['sess_id'])?trim($_REQUEST['sess_id']):'';
    $a_params['extra_data'] = isset($_REQUEST['extra_data'])?trim($_REQUEST['extra_data']):'';
    $a_params['login_ip'] = isset($_REQUEST['login_ip'])?trim($_REQUEST['login_ip']):'';

    $a_params['app_id'] = isset($channel_param['app_id'])?trim($channel_param['app_id']):'';
    $a_params['app_key'] = isset($channel_param['app_key'])?trim($channel_param['app_key']):'';
    $a_params['app_secret'] = isset($channel_param['app_secret'])?trim($channel_param['app_secret']):'';

    return $s_controller->verify($a_params);
}

// ============server start part============
$g_logger = new Logger(LOGGER_DIR);
session_start();
select_action();
?>
