<?php
require_once (dirname(dirname(__FILE__)) . "/config/common.config.php");
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");
require_once (dirname(dirname(__FILE__)) . "/model/common.db.model.php");

class c_userid_generator {
    private $m_channel_id;
    private $m_channel_name;
    private $m_security_code;
    private $m_user_count;
    private $m_start_uid;
    private $m_end_uid;


    function __construct($channel_id, $channel_name, $security_code, $user_count)
    {
        //global $g_logger;
        //$g_logger = new Log("account_userid_gen_", LOG_DIR);
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[userid generate start]");
        write_log("info", __FILE__, __FUNCTION__, __LINE__,
            "BASE INFO: channel_id({$channel_id}) channel_name({$channel_name})".
            " security_code({$security_code}) user_count({$user_count})");

        $this->m_channel_id = $channel_id;
        $this->m_channel_name = $channel_name;
        $this->m_security_code = $security_code;
        $this->m_user_count = $user_count;
    }

    function __destruct()
    {
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "[userid generate end]");
        db_finish();
    }

    function get_userid_range()
    {
        $userid_range = array(
            'start_uid' => $this->m_start_uid,
            'end_uid' => $this->m_end_uid,
            );

        return $userid_range;
    }
    
    private function check_params()
    {
        if( empty($this->m_channel_name) ) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "wrong channel_name({$this->m_channel_name})");
            //return ACCOUNT_ERR_INVALID_PARAMS;
        }
        if( $this->m_user_count <= 0 ) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "wrong user_count({$this->m_user_count})");
            return ACCOUNT_ERR_INVALID_PARAMS;
        }
        if( $this->m_channel_id < 0 ) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "wrong channel_id({$this->m_channel_id})");
            return ACCOUNT_ERR_INVALID_PARAMS;
        }

        return ACCOUNT_ERR_OK;
    }

    function start_generate_userid()
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
        $result = db_generate_userid($this->m_channel_id, $this->m_user_count);
        if ($result === false) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_generate_userid() failed.");
            return ACCOUNT_ERR_SYS_BUSY;
        }
        if ($result === true) {
            write_log("info", __FILE__, __FUNCTION__, __LINE__, "db_generate_userid() succ: enough userid in DB.");
            return ACCOUNT_ERR_OK;
        }
        $this->m_start_uid = $result['start_uid'];
        $this->m_end_uid = $result['end_uid'];
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "start_uid({$this->m_start_uid}) end_uid({$this->m_end_uid})");

        return ACCOUNT_ERR_OK;
    }
}

?>
