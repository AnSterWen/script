<?php
require_once (dirname(dirname(__FILE__)) . "/config/common.config.php");
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once (dirname(dirname(__FILE__)) . "/model/common.db.model.php");

class c_account_verify {
    private $m_channel_id;
    private $m_user_id;
    private $m_user_name;
    private $m_user_passwd;
    private $m_client_ip;
    private $m_access_token;

    function __construct($channel_id, $user_name, $user_passwd)
    {
        global $g_logger;
        $g_logger = new Log("account_login_", LOG_DIR);
        $client_ip = get_client_ip();
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[login start]");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "REQUEST_URI:" . urldecode($_SERVER['REQUEST_URI']));
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "_REQUEST: " . print_r($_REQUEST, true));
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "CLIENT_IP:" . $client_ip);

        $this->m_channel_id = $channel_id;
        $this->m_user_id = -1;
        $this->m_user_name = $user_name;
        $this->m_user_passwd = $user_passwd;
        $this->m_client_ip = $client_ip;
        $this->m_access_token = "";
    }

    function __destruct()
    {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[login end]");
        db_finish();
    }

    function get_user_id()
    {
        return $this->m_user_id;
    }

    function get_access_token()
    {
        return $this->m_access_token;
    }
    
    private function check_params()
    {
        if( empty($this->m_user_name) || !check_user_name($this->m_user_name) ) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "check user_name({$this->m_user_name}) failed");
            return ACCOUNT_ERR_INVALID_NAME;
        }
        if (strlen($this->m_user_passwd) != 32) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "wrong passwd({$this->m_user_passwd}) format");
            return ACCOUNT_ERR_INVALID_SERVICE;
        }

        return ACCOUNT_ERR_OK;
    }

    function check_account_password()
    {
        $result = $this->check_params();
        if ($result != ACCOUNT_ERR_OK) {
            return $result;
        }

        global $g_db_config;
        if ( false === db_init($g_db_config) ) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "connect db{$db_config['db_name']} failed.");
            return ACCOUNT_ERR_SYS_BUSY;
        }

        //获取name对应的userid
        $user_id = db_get_key_userid($this->m_user_name, ACCOUNT_KEY_TYPE_NAME, $this->m_channel_id);
        if ($user_id === false || $user_id <= 0) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "user_name({$this->m_user_name}) not exist.");
            return ACCOUNT_ERR_WRONG_NAME;
        }
        $this->m_user_id = $user_id;
        $date = date("YmdHis");
        $token_string = "{$user_id}@{$date}@" . ACCOUNT_ACCESS_TOKE_PRIVATE_KEY;
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "token_string: {$token_string}");
        $this->m_access_token = md5($token_string);

        $result = db_check_user_passwd($this->m_channel_id, $user_id, $this->m_user_name,
                                         $this->m_user_passwd, $this->m_client_ip);
        if ($result != ACCOUNT_ERR_OK) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__,
                "user({$this->m_user_id}) name({$this->m_user_name}) db_check_user_passwd() failed.");
            return $result;
        }

        $result = db_generate_session($this->m_user_id, $this->m_access_token, $this->m_client_ip);
        if ($result === false) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__,
                "user({$this->m_user_id}) name({$this->m_user_name}) client_ip({$this->m_client_ip})".
                "session({$this->m_access_token}) db_generate_session() failed.");
            return ACCOUNT_ERR_SYS_BUSY;
        }

        return ACCOUNT_ERR_OK;
    }
}

?>
