<?php
require_once (dirname(__FILE__) . '/common.config.php');

global $g_version;

if ($g_version === 'release') { // 正式环境
    // IP白名单，为空表示不限制
    $g_white_list = array(
        '113.196.60.202',
        '113.196.95.62',
        '60.248.110.133',
        '10.1.12.52',
        '10.1.12.53',
    );
    // 签名密钥
    $g_secret = '72088e6aa0e6bbc63e48b9f8a80ed4f7';
    // 游戏服务器列表
    $g_server_list = array(
        1 => array(
            'ip' => '10.1.23.242',
            'port' => 50200
        ),
        2 => array(
            'ip' => '10.1.23.242',
            'port' => 50201
        ),
        3 => array(
            'ip' => '10.1.23.242',
            'port' => 50203
        ),
        4 => array(
            'ip' => '10.1.23.245',
            'port' => 50202
        ),
        5 => array(
            'ip' => '10.1.23.242',
            'port' => 50200
        ),
        6 => array(
            'ip' => '10.1.23.242',
            'port' => 50201
        ),
    );
} else { // 测试环境
    // IP白名单，为空表示不限制
    $g_white_list = array(
        '113.196.60.202',
        '113.196.95.62',
        '60.248.110.133',
    );
    // 签名密钥
    $g_secret = '72088e6aa0e6bbc63e48b9f8a80ed4f7';
    // 游戏服务器列表
    $g_server_list = array(
        1 => array(
            'ip' => '113.196.60.129',
            'port' => 50200
        ),
    );
}

// 月卡
$g_month_card_products = array('80007', '80008', '80009');

// 落统计汇率，例如台湾AHERO，将新台币转换成美元
$g_offline_exchange_rate = 0.03;

// 状态码
define('RESULT_OK', 0);
define('RESULT_ERR_INVALID_IP', 1001);
define('RESULT_ERR_INVALID_SIGN', 1002);
define('RESULT_ERR_INVALID_SERVER_ID', 1003);
define('RESULT_ERR_INTERNAL_ERROR', 1004);
define('RESULT_ERR_INVALID_PARAMETER', 1005);
define('RESULT_ERR_INVALID_ROLE_NAME', 1006);

// 错误描述
$g_err_desc = array(
    RESULT_ERR_INVALID_IP => 'IP限制访问',
    RESULT_ERR_INVALID_SIGN => '签名不合法',
    RESULT_ERR_INVALID_SERVER_ID => '服务器ID不存在',
    RESULT_ERR_INTERNAL_ERROR => '服务器内部错误',
    RESULT_ERR_INVALID_PARAMETER => '参数错误',
    RESULT_ERR_INVALID_ROLE_NAME => '角色名不存在',
);

// 公共方法

/**
 * 返回JSON格式的响应
 *
 * @param  int   $result 状态码
 * @param  mixed $data
 *
 * @return null
 */
function json_resp($result, $data = null)
{
    global $g_err_desc;

    if ($result === RESULT_OK) {
        echo json_encode(array('result' => $result, 'data' => $data));
    } else {
        if (!isset($data) && isset($g_err_desc[$result])) {
            $data = $g_err_desc[$result];
        }
        echo json_encode(array('result' => $result, 'err_desc' => $data));
    }
    exit(0);
}

/**
 * 检查MD5签名
 *
 * @param  array $request
 *
 * @return bool
 */
function check_md5_sign($request)
{
    global $g_secret;

    if (!isset($request['sign']) || empty($request['sign'])) {
        return false;
    }

    ksort($request);
    $str = '';
    foreach ($request as $key => $value) {
        if ($key === 'sign') continue;
        $str .= "{$key}={$value}&";
    }
    $str .= "key={$g_secret}";
    write_log('info', __FILE__, __FUNCTION__, __LINE__,
        "md5 str: {$str}"
    );

    $need = md5($str);
    write_log('info', __FILE__, __FUNCTION__, __LINE__,
        "sign: get {$request['sign']}, need {$need}"
    );
    return $request['sign'] === $need;
}
