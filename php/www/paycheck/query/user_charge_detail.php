<?php
require_once(dirname(dirname(__FILE__)).'/config/common.config.php');
require_once(dirname(dirname(__FILE__)).'/lib/Log.class.php');
require_once(dirname(dirname(__FILE__)).'/lib/functions.php');
require_once(dirname(dirname(__FILE__)) . '/model/common.db.model.php');
define('MAX_CHANNEL_ID', 10000);

$logger = new Log("query/user_charge_detail_", LOG_DIR);
write_log("info", __FILE__, __FUNCTION__, __LINE__, "CLIENT_IP:".getClientIp());
write_log("info", __FILE__, __FUNCTION__, __LINE__, "REQUEST_URI:".urldecode($_SERVER['REQUEST_URI']));
write_log("info", __FILE__, __FUNCTION__, __LINE__, "_REQUEST: " . print_r($_REQUEST, true));

$fail_string = json_encode( array() );

$req_params = array(
    'game_id'       => array('is_numeric'),
    'channel_id'    => array('is_numeric'),
    'user_id'       => array('is_numeric'),
    'reg_time'      => array('is_numeric'),
    'server_id'     => array('is_numeric'),
    //'start_time'     => array('is_string'),//可选参数
    //'end_time'     => array('is_string'),//可选参数
    'sign'          => array('is_string'),
);

$req_array = array();
foreach ($req_params as $key => $methods) {
    if (!isset($_REQUEST[$key])) {
        write_log("error", __FILE__, __FUNCTION__, __LINE__, "lack of request param({$key})");
        die($fail_string);
    }
    $param = $_REQUEST[$key];
    foreach($methods as $method) {
        if ( !$method($param) ) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "wrong request param({$key}) value({$param})");
            die($fail_string);
        }
    }
    $req_array[$key] = $_REQUEST[$key];
}
$channel_id = intval($_REQUEST['channel_id']);
if ($channel_id > MAX_CHANNEL_ID || $channel_id <= 0) {
    write_log("error", __FILE__, __FUNCTION__, __LINE__, "wrong channel_id({$channel_id})");
    die($fail_string);
}

global $g_db_config;
$db_conn = db_init($g_db_config);
if (false === $db_conn) {
    $log = "db_init failed: " . print_r($g_db_config, true);
    write_log("error", __FILE__, __FUNCTION__, __LINE__, $log);
    die($fail_string);
}

$game_id = $_REQUEST['game_id'];
$channel_id = $_REQUEST['channel_id'];
$user_id = $_REQUEST['user_id'];
$reg_time = $_REQUEST['reg_time'];
$server_id = $_REQUEST['server_id'];
$start_time = empty($_REQUEST['start_time']) ? 0 : $_REQUEST['start_time'];//充值开始时间，可选参数
$end_time = empty($_REQUEST['end_time']) ? 0 : $_REQUEST['end_time'];//充值结束时间，可选参数
$return_array = db_get_user_product_detail($game_id, $channel_id, $user_id, $reg_time, $server_id, $start_time, $end_time);
db_finish();

$log = "product_detail:" . print_r($return_array, true);;
write_log("info", __FILE__, __FUNCTION__, __LINE__, $log);

if ($return_array === false) {
    die($fail_string);
}

echo json_encode($return_array);
exit;

//////////////////////////////////////////common function//////////////////////////////////////////
function ucd_check_sign($params)
{
    $rcv_sign = $params['sign'];
    unset($params['sign']);
    ksort($params);

    $str = '';
    /* 将参数用&连起来 */
    foreach ($params as $key => $val) {
        $str .= $key . '=' . $val . '&';
    }
    $str .= "key=". QUERY_PRIVATE_KEY;

    $cal_sign = md5($str);
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "string({$str})");
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "cal_sign({$cal_sign}) rcv_sign({$rcv_sign})");
    //return ($rcv_sign == $cal_sign);
    return true;
}


?>
