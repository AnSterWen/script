<?php
require_once (dirname(dirname(__FILE__)) . "/config/common.config.php");
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once (dirname(dirname(__FILE__)) . "/model/common.db.model.php");

class c_account_register {
    private $m_channel_id;
    private $m_user_id;
    private $m_user_name;
    private $m_user_passwd;
    private $m_user_email;
    private $m_client_ip;

    function __construct($channel_id, $user_name, $user_passwd, $user_email)
    {
        global $g_logger;
        $g_logger = new Log("account_register_", LOG_DIR);
        $client_ip = get_client_ip();
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[register start]");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "REQUEST_URI:" . urldecode($_SERVER['REQUEST_URI']));
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "_REQUEST: " . print_r($_REQUEST, true));
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "CLIENT_IP:" . $client_ip);

        $this->m_channel_id = $channel_id;
        $this->m_user_id = -1;
        $this->m_user_name = $user_name;
        $this->m_user_passwd = $user_passwd;
        $this->m_user_email = $user_email;
        $this->m_client_ip = $client_ip;
    }

    function __destruct()
    {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[register end]");
        db_finish();
    }

    function get_user_id()
    {
        return $this->m_user_id;
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
        if( !empty($this->m_user_email) && !check_email($this->m_user_email) ) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "check email({$this->m_user_email}) failed");
            return ACCOUNT_ERR_INVALID_EMAIL;
        }

        return ACCOUNT_ERR_OK;
    }

    function start_register()
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

        write_log("info", __FILE__, __FUNCTION__, __LINE__,
            "BASE INFO: channel({$this->m_channel_id}) name({$this->m_user_name})".
            " password({$this->m_user_passwd}) email({$this->m_user_email})");

        //检查name是否使用过
        $user_id = db_get_key_userid($this->m_user_name, ACCOUNT_KEY_TYPE_NAME, $this->m_channel_id);
        if ($user_id !== false && $user_id > 0) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__,
                "user_name({$user_name}) has been used ---> user_id({$user_id}).");
            return ACCOUNT_ERR_NAME_USED;
        }

        //检查email是否使用过
        if ( !empty($this->m_user_email) ) {
            $user_id = db_get_key_userid($this->m_user_email, ACCOUNT_KEY_TYPE_EMAIL, $this->m_channel_id);
            if ($user_id !== false && $user_id > 0) {
                write_log("info", __FILE__, __FUNCTION__, __LINE__, "email({$email}) has been used ---> user_id({$user_id}).");
                return ACCOUNT_ERR_EMAIL_USED;
            }
        }

        $user_id = db_register_userid($this->m_channel_id, $this->m_user_name,
            $this->m_user_passwd, $this->m_user_email, $this->m_client_ip);
        if ($user_id === false) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_register_userid() failed.");
            return ACCOUNT_ERR_SYS_BUSY;
        }

        $this->m_user_id = $user_id;
        write_log("info", __FILE__, __FUNCTION__, __LINE__,
            "REGISTER SUCC: channel({$this->m_channel_id}) name({$this->m_user_name})".
            " email({$this->m_user_email}) ----> userid({$user_id})");

        return ACCOUNT_ERR_OK;
    }
}

?>
