<?php
require_once (dirname(dirname(__FILE__)) . "/config/common.config.php");
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once (dirname(dirname(__FILE__)) . "/model/common.db.model.php");

class c_account_get_userinfo_by_name
{
    private $m_channel_id;
    private $m_user_name;
    private $m_userinfo;
    private $m_client_ip;

    function __construct($channel_id, $user_name)
    {
        global $g_logger;
        $g_logger = new Log("account_get_userinfo_by_name_", LOG_DIR);
        $client_ip = get_client_ip();
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[modify password by old one start]");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "REQUEST_URI:" . urldecode($_SERVER['REQUEST_URI']));
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "_REQUEST: " . print_r($_REQUEST, true));
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "CLIENT_IP:" . $client_ip);

        $this->m_channel_id = $channel_id;
        $this->m_user_name = $user_name;
        $this->m_userinfo = array();
        $this->m_client_ip = $client_ip;
    }

    function __destruct()
    {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[modify password by old one end]");
        db_finish();
    }

    function get_userinfo()
    {
        return $this->m_userinfo;
    }

    function get_userinfo_by_name()
    {
        global $g_db_config;
        if ( false === db_init($g_db_config) ) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "connect db{$db_config['db_name']} failed.");
            return ACCOUNT_ERR_SYS_BUSY;
        }

        $user_id = db_get_key_userid($this->m_user_name, ACCOUNT_KEY_TYPE_NAME, $this->m_channel_id);
        if ($user_id === false || $user_id <= 0) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "user_name({$this->m_user_name}) not exist.");
            return ACCOUNT_ERR_WRONG_NAME;
        }

        return db_get_userinfo_by_id(
            $this->m_channel_id,
            $user_id,
            $this->m_client_ip
        );
    }
}
