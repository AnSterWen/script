<?php
require_once (dirname(dirname(__FILE__)) . "/config/common.config.php");
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once (dirname(dirname(__FILE__)) . "/model/common.db.model.php");

class c_account_session {
    private $m_user_id;
    private $m_session;

    function __construct($user_id, $session)
    {
        global $g_logger;
        $g_logger = new Log("account_check_session_", LOG_DIR);
        $client_ip = get_client_ip();
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[check session start]");
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "REQUEST_URI:" . urldecode($_SERVER['REQUEST_URI']));
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "_REQUEST: " . print_r($_REQUEST, true));
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "CLIENT_IP:" . $client_ip);

        $this->m_user_id = $user_id;
        $this->m_session = $session;
    }

    function __destruct()
    {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[check session end]");
        db_finish();
    }

    private function check_params()
    {
        if( empty($this->m_user_id) || empty($this->m_session) ) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__,
                "empty user_id({$this->m_user_id}) or session({$this->m_session})");
            return ACCOUNT_ERR_INVALID_PARAMS;
        }

        return ACCOUNT_ERR_OK;
    }

    function check_session()
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

        write_log("info", __FILE__, __FUNCTION__, __LINE__, "user({$this->m_user_id}) session({$this->m_session})");

        $result = db_check_user_session($this->m_user_id, $this->m_session);
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_check_user_session() return: {$result}.");

        return $result;
    }
}

?>
