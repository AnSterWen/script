<?php
class user
{
    private $handler;
    function __construct($s_handler=false)
    {
        $this->handler = $s_handler;
    }

    /**
     * 最新第三方验证登录
     *
     * @param $a_params
     *
     * @return
     */
    public function verify($a_params)
    {
        $i_type = (int)$a_params['channel_id'];
        $a_verify = include dirname(dirname(__FILE__)).'/config/verify_login.php';
        if(!isset($a_verify[$i_type])) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        $s_func   = $a_verify[$i_type][0].'Verify';//根据type获取需要验证的前缀
        $s_url = $a_verify[$i_type][1];
        $a_result = $this->{$s_func}($a_params,$s_url);

        return $a_result;
    }

    /**
     ** 游客登录
     * */
    public function visitorVerify($a_params,$s_url)
    {
        if(empty($a_params)) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        $s_token = urldecode($a_params['sess_id']);//access_token

        $s_extra_data = urldecode($a_params['extra_data']);
        if(empty($s_extra_data)) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        $s_uid = $s_extra_data;


        $new_uid = uid_change_to_int($a_params['channel_id'], $s_uid);
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "s_uid({$s_uid}) new_uid: ". $new_uid);
        if ($new_uid <= 0) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__,
                "KAKAO uid_change_to_int failed: return result({$new_uid})".
                " AND REQUEST PARAMS IS channel({$a_params['channel_id']}) uid({$s_uid})");
            return $response;
        }

        return array('status_code' => 0,
            'user_id' => $new_uid,
            'nick_name'=> "",
            'token'=> $s_token);
    }



    /*
     * inner Login Token Check
     */
    public function innerVerify($a_params,$s_url)
    {
        if(empty($a_params) || empty($s_url)) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        $token = urldecode($a_params['sess_id']);//access_token
        if( empty($token) ) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        $user_id = $a_params['user_id'];
        $channel_id = $a_params['channel_id'];
        $pri_key = $a_params['app_key'];

        $a_data = array(
            'service' => 10005,
            'channel' => $channel_id,
            'user_id' => $user_id,
            'session' => $token,
            'sign' => '',
            'sign_type' => 'MD5',
        );
        $sign = make_md5_sign($a_data, $pri_key);
        $a_data['sign'] = $sign;

        $response['status_code'] = ACCOUNT_E_THIRD_CHECK_FIALED;
        write_log("debug", __FILE__, __FUNCTION__, __LINE__,json_encode($a_data),$s_url );
        $a_result = get_url_contents($s_url, $a_data, 'get', 'json');
        write_log("debug", __FILE__, __FUNCTION__, __LINE__,json_encode($a_result) );

       /* if( !isset($a_result['status_code']) || $a_result['status_code'] != 0 ) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__,
                "INNER_ERROR:return result:".print_r($a_result,true).
                " AND REQUEST PARAMS:".print_r($a_data,true));
            return $response;
       }*/

        
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "lush !!!! uid({$user_id})");
        return array('status_code' => 0,
                     'user_id' => $user_id,
                     'nick_name'=> "",
                     'token'=> $token);
    }


    /**
     * kakao Login Token Check
     */
    public function kakaoVerify($a_params,$s_url)
    {
        if(empty($a_params) || empty($s_url)) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        if(count($a_params) < 3) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        $s_token = urldecode($a_params['sess_id']);//access_token
        $s_user_id = urldecode($a_params['user_id']);
        $i_client_id = urldecode($a_params['app_id']);
        $s_extra_data = urldecode($a_params['extra_data']);
        if(empty($s_token) || !isset($s_user_id) || empty($i_client_id) || empty($s_extra_data)) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        if (strncmp($s_extra_data, "1.1.0;", 6) == 0) {//老版本
            $a_extra = explode(";", $s_extra_data);
            $sdkver = $a_extra[0];
            $s_uid = $a_extra[1];
            //取消去kakao服务器验证
            $a_data = array('access_token'=>strval($s_token),
                //'user_id'=> strval($s_user_id),
                'user_id'=> $s_uid,
                'client_id'=> intval($i_client_id),
                'sdkver'=> $sdkver,
            );
            //验证access_token
            $response['status_code'] = ACCOUNT_E_THIRD_CHECK_FIALED;
            $a_result = get_url_contents($s_url, $a_data, 'get', 'json');
            if(!isset($a_result['status']) || $a_result['status'] != 0) {
                write_log("error", __file__, __function__, __line__,
                    "kakao_verify_error:the result=".print_r($a_result,true).
                    " AND the param is ".print_r($a_data,true)." and the url is "
                    .$s_url);
                return $response;
            }
        }
        else {//新版本
            $a_extra = json_decode($s_extra_data, true);
            $app_secret = $a_params['app_secret'];
            if ( !inner_check_sign($a_extra, $app_secret) ) {
                write_log("error", __FILE__, __FUNCTION__, __LINE__, "inner_check_sign() failed");
                $response['status_code'] = ACCOUNT_E_THIRD_CHECK_FIALED;
                return $response;
            }
            $sdkver = $a_extra['sdkversion'];
            $s_uids = $a_extra['userid'];
            $a_uid = explode(":", $s_uids);
            $s_uid = $a_uid[0];
        }



        $new_uid = uid_change_to_int($a_params['channel_id'], $s_uid);
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "s_uid({$s_uid}) new_uid: ". $new_uid);
        if ($new_uid <= 0) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__,
                "KAKAO uid_change_to_int failed: return result({$new_uid})".
                " AND REQUEST PARAMS IS channel({$a_params['channel_id']}) uid({$s_uid})");
            return $response;
        }   

        return array('status_code' => 0,
                     'user_id' => $new_uid,
                     'nick_name'=> "",
                     'token'=> $s_token);
    }



    /**
     * 台湾coco登录
     */
    public function cocoVerify($a_params,$s_url)
    {
        if( empty($a_params)||empty($s_url) ) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }

        $a_data = array(
            'grant_type' => "authorization_code",
            'code' => $a_params['sess_id'],
            'appid' => $a_params['app_id'],
            'app_secret' => $a_params['app_secret'],
        );

        $a_result = get_url_contents($s_url, $a_data, 'get', 'json');
        $response['status_code'] = ACCOUNT_E_THIRD_CHECK_FIALED;
        if( !is_array($a_result) || empty($a_result['refresh_token'])
            || (isset($a_result['error_code']) && $a_result['error_code'] != 0) ) {
                write_log("error", __file__, __function__, __line__,
                    "COCO_verify_error:the result=".print_r($a_result,true).
                    " AND the param is ".print_r($a_data,true)." and the url is "
                    .$s_url);
                return $response;
            }

        return array('status_code'  => 0,
            'user_id'       => $a_result['coco'],
            'nick_name'     => "",
            'token'         => $a_result['access_token'],
        );
    }

    /**
     * igg Login Token Check
     *
     * @param $s_token
     * @param $s_url
     *
     * @return
     */
    public function iggVerify($a_params, $s_url)
    {
        if(empty($a_params) || empty($s_url)) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        $s_token = urldecode($a_params['sess_id']);//access_token
        if( empty($s_token) ) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }

        $a_data = array('signed_key'=>strval($s_token),);

        //验证access_token
        $response['status_code'] = ACCOUNT_E_THIRD_CHECK_FIALED;
        $s_return = get_url_contents($s_url, $a_data, 'get', 'string');

        $json_len = strlen($s_return) - 32;
        if ($json_len <= 0) {
            write_log("error", __file__, __function__, __line__,
                "igg_verify_error:the result=" . $s_return .
                " AND the param is ".print_r($a_data,true)." and the url is " .$s_url);
            return $response;
        }
        $json_str = substr($s_return, 0, $json_len);
        //$md5_str = substr($s_return, $json_len);
        $a_result = json_decode($json_str, true);

        //TODO: 签名认证

        if(!isset($a_result['errCode']) || $a_result['errCode'] != 0) {
            write_log("error", __file__, __function__, __line__,
                "igg_verify_error:the result=" . print_r($a_result,true) .
                " AND the param is ".print_r($a_data,true)." and the url is " .$s_url);
            return $response;
        }
        write_log("debug", __file__, __function__, __line__, "igg check token({$s_token}) igg return({$s_return})");
        $nick_name = empty($a_result['result']['guest']) ? "" : $a_result['result']['guest'];

        $a_extra = json_decode($a_params['extra_data'], true);
        if ( !empty($a_params['login_ip']) ) {
            $a_extra['ip'] = $a_params['login_ip'];
        }
        igg_game_log($a_extra);

        return array('status_code' => 0,
            //'user_id' => $a_result['result']['iggid'],
            'user_id' => $a_params['user_id'],
            'nick_name'=> $nick_name,
            'token'=> $s_token);
    }



    public function facebookVerify($a_params, $s_url)
    {   
        if(empty($a_params)) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }   
        $s_token = urldecode($a_params['sess_id']);//access_token
        if( empty($s_token) ) { 
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }   
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "extra_data:{$a_params['extra_data']}");
        $a_extra = json_decode($a_params['extra_data'], true);
        $app_secret = $a_params['app_secret'];
        if ( !inner_check_sign($a_extra, $app_secret) ) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__, "inner_check_sign() failed");
            $response['status_code'] = ACCOUNT_E_THIRD_CHECK_FIALED;
            return $response;
        }

        //验证access_token
        $response['status_code'] = ACCOUNT_E_THIRD_CHECK_FIALED;
        $s_uid = $a_extra['uid'];
        $new_uid = uid_change_to_int($a_params['channel_id'], $s_uid);
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "s_uid({$s_uid}) new_uid: ". $new_uid);
        if ($new_uid <= 0) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__,
                "FACEBOOK uid_change_to_int failed: return result({$new_uid})".
                " AND REQUEST PARAMS IS channel({$a_params['channel_id']}) uid({$s_uid})");
            return $response;
        }   

        return array('status_code' => 0,
                     'user_id' => $new_uid,
                     'nick_name'=> "", 
                     'token'=> $s_token);
    }   

    /*
     * mface Login Token Check
     */
    public function mfaceVerify($a_params,$s_url)
    {
        if(empty($a_params) || empty($s_url)) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        $s_token = urldecode($a_params['sess_id']);//access_token
        if( empty($s_token) ) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }
        $a_extra = json_decode($a_params['extra_data'], true);
        //$user_id = str_replace("mface_", "", $a_extra['userId']);//mface_1190980
        $time = time();
        $app_secret = $a_params['app_secret'];
        $sign = md5($app_secret . '||' . $time . $s_token);

        $a_data = array(
            'token' => $s_token,
            'time' => $time,
            'key' => $sign,
        );

        //验证access_token
        //{"result":"1","desc":"Success.","orderID":null,"member":{"IDN":"9673","loginid":"mfacekenji","nickname":"kenji2","balancepoint":"1029","email":"mis@gameview.asia","contactno":"0127268539","gender":"Male","profilepicture":"http://profile.mface.me/Profile/Image1/9673/crop_23ba70be-c1d1-4261-bf45-6dffeaabef35.jpg","MemberToken":"9673f28787d8e3","NameSpace":"http://mface.me/mobile/"}}
        $response['status_code'] = ACCOUNT_E_THIRD_CHECK_FIALED;
        $a_result = get_url_contents($s_url, $a_data, 'get', 'json');
        if( !isset($a_result['result']) || $a_result['result'] != 1 ) {
            write_log("error", __FILE__, __FUNCTION__, __LINE__,
                "MFACE_ERROR:the result=".print_r($a_result,true).
                " AND THE PARAMS IS ".print_r($a_data,true));
            return $response;
        }
        $user_id = $a_result['member']['IDN'];
        $nick_name = $a_result['member']['nickname'];
        $member_token = $a_result['member']['MemberToken'];

        return array('status_code' => 0,
                     'user_id' => $user_id,
                     'nick_name'=> $nick_name,
                     'token'=> $member_token);
    }


    /**
     * 泰国goodgames登录
     */
    public function goodgamesVerify($a_params,$s_url)
    {
        if( empty($a_params) ) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }

        return array('status_code'  => 0,
            'user_id'       => $a_params['user_id'],
            'nick_name'     => "",
            'token'         => $a_params['sess_id'],
        );
    }

    /**
     * 韩国猎豹
     */
    public function cheetahmobileVerify($aParams, $sUrl)
    {
        // 检查参数
        foreach (array('channel_id', 'app_id', 'app_secret', 'sess_id') as $key) {
            if (!isset($aParams[$key]) || !$aParams[$key]) {
                return array(
                    'status_code' => ACCOUNT_E_INVALID_PARAMS
                );
            }
        }
        // 验证token
        $res = get_url_contents($sUrl, array('access_token' => $aParams['sess_id']), 'get', 'json');
        if (!is_array($res) || !isset($res['ret'])) {
            write_log('error', __FILE__, __FUNCTION__, __LINE__,
                'response format error, need ret, get ' . print_r($res, true));
            return array(
                'status_code' => ACCOUNT_E_SYS_ERROR
            );
        }
        if ($res['ret'] !== 1) {
            write_log('error', __FILE__, __FUNCTION__, __LINE__,
                'response ret error, get ' . print_r($res, true));
            return array(
                'status_code' => ACCOUNT_E_THIRD_CHECK_FIALED
            );
        }
        if (!isset($res['client_id']) || $res['client_id'] !== (string)$aParams['app_id']) {
            write_log('error', __FILE__, __FUNCTION__, __LINE__,
                'client_id not match, need ' . $aParams['app_id'] . ', get ' . $res['client_id']);
            return array(
                'status_code' => ACCOUNT_E_THIRD_CHECK_FIALED
            );
        }
        if (!isset($res['open_id_str']) || empty($res['open_id_str'])) {
            write_log('error', __FILE__, __FUNCTION__, __LINE__,
                'open_id_str empty, get ' . print_r($res, true));
            return array(
                'status_code' => ACCOUNT_E_THIRD_CHECK_FIALED
            );
        }
        // 映射帐号
        $userId = safe_uid_change_to_int($aParams['channel_id'], $res['open_id_str']);
        write_log('info', __FILE__, __FUNCTION__, __LINE__,
            'map ' . $res['open_id_str'] . '(open_id) to ' . $userId . '(user_id)');
        if ($userId <= 0) {
            write_log('error', __FILE__, __FUNCTION__, __LINE__,
                'map error with channel_id ' . $aParams['channel_id'] . ', open_id ' . $res['open_id_str']);
            return array(
                'status_code' => ACCOUNT_E_SYS_ERROR
            );
        }
        return array(
            'status_code' => 0,
            'user_id' => $userId,
            'nick_name' => '',
            'token' => $aParams['sess_id']
        );
    }

    /**
     * 越南正大娱乐集团 TDPVN
     */
    public function tdpvnVerify($aParams, $sUrl)
    {
        if (empty($aParams)) {
            $response['status_code'] = ACCOUNT_E_INVALID_PARAMS;
            return $response;
        }

        return array(
            'status_code' => 0,
            'user_id'     => $aParams['user_id'],
            'nick_name'   => '',
            'token'       => $aParams['sess_id'],
        );
    }
}
