<?php
require_once 'pb4php/message/pb_message.php';
class player_basic_info_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["player_basic_info_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["player_basic_info_t"]["1"] = "userid";
        self::$fields["player_basic_info_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["player_basic_info_t"]["2"] = "reg_time";
        self::$fields["player_basic_info_t"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["player_basic_info_t"]["3"] = "channel_id";
    }
    function userid()
    {
        return $this->_get_value("1");
    }
    function set_userid($value)
    {
        return $this->_set_value("1", $value);
    }
    function reg_time()
    {
        return $this->_get_value("2");
    }
    function set_reg_time($value)
    {
        return $this->_set_value("2", $value);
    }
    function channel_id()
    {
        return $this->_get_value("3");
    }
    function set_channel_id($value)
    {
        return $this->_set_value("3", $value);
    }
}
class sw_attach_item extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_attach_item"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_attach_item"]["1"] = "id";
        self::$fields["sw_attach_item"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_attach_item"]["2"] = "num";
    }
    function id()
    {
        return $this->_get_value("1");
    }
    function set_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function num()
    {
        return $this->_get_value("2");
    }
    function set_num($value)
    {
        return $this->_set_value("2", $value);
    }
}
class userinfo extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["userinfo"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["userinfo"]["1"] = "userid";
        self::$fields["userinfo"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["userinfo"]["2"] = "reg_time";
        self::$fields["userinfo"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["userinfo"]["3"] = "channel_id";
        self::$fields["userinfo"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["userinfo"]["4"] = "zone_id";
        self::$fields["userinfo"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["userinfo"]["5"] = "mail_id";
        self::$fields["userinfo"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["userinfo"]["6"] = "hasattach";
    }
    function userid()
    {
        return $this->_get_value("1");
    }
    function set_userid($value)
    {
        return $this->_set_value("1", $value);
    }
    function reg_time()
    {
        return $this->_get_value("2");
    }
    function set_reg_time($value)
    {
        return $this->_set_value("2", $value);
    }
    function channel_id()
    {
        return $this->_get_value("3");
    }
    function set_channel_id($value)
    {
        return $this->_set_value("3", $value);
    }
    function zone_id()
    {
        return $this->_get_value("4");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("4", $value);
    }
    function mail_id()
    {
        return $this->_get_value("5");
    }
    function set_mail_id($value)
    {
        return $this->_set_value("5", $value);
    }
    function hasattach()
    {
        return $this->_get_value("6");
    }
    function set_hasattach($value)
    {
        return $this->_set_value("6", $value);
    }
}
class sw_style extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_style"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_style"]["1"] = "red";
        self::$fields["sw_style"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_style"]["2"] = "green";
        self::$fields["sw_style"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_style"]["3"] = "blue";
        self::$fields["sw_style"]["4"] = "PBBytes";
        $this->values["4"] = "";
        self::$fieldNames["sw_style"]["4"] = "text";
        self::$fields["sw_style"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["sw_style"]["5"] = "fontsize";
    }
    function red()
    {
        return $this->_get_value("1");
    }
    function set_red($value)
    {
        return $this->_set_value("1", $value);
    }
    function green()
    {
        return $this->_get_value("2");
    }
    function set_green($value)
    {
        return $this->_set_value("2", $value);
    }
    function blue()
    {
        return $this->_get_value("3");
    }
    function set_blue($value)
    {
        return $this->_set_value("3", $value);
    }
    function text()
    {
        return $this->_get_value("4");
    }
    function set_text($value)
    {
        return $this->_set_value("4", $value);
    }
    function fontsize()
    {
        return $this->_get_value("5");
    }
    function set_fontsize($value)
    {
        return $this->_set_value("5", $value);
    }
}
class sw_announcement extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_announcement"]["1"] = "sw_style";
        $this->values["1"] = array();
        self::$fieldNames["sw_announcement"]["1"] = "context";
        self::$fields["sw_announcement"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_announcement"]["2"] = "from";
        self::$fields["sw_announcement"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_announcement"]["3"] = "to";
        self::$fields["sw_announcement"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["sw_announcement"]["4"] = "count";
        self::$fields["sw_announcement"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["sw_announcement"]["5"] = "ann_id";
        self::$fields["sw_announcement"]["6"] = "PBBytes";
        $this->values["6"] = "";
        self::$fieldNames["sw_announcement"]["6"] = "title";
    }
    function context($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_context()
    {
        return $this->_add_arr_value("1");
    }
    function set_context($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_contexts($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_context()
    {
        $this->_remove_last_arr_value("1");
    }
    function contexts_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_contexts()
    {
        return $this->_get_value("1");
    }
    function from()
    {
        return $this->_get_value("2");
    }
    function set_from($value)
    {
        return $this->_set_value("2", $value);
    }
    function to()
    {
        return $this->_get_value("3");
    }
    function set_to($value)
    {
        return $this->_set_value("3", $value);
    }
    function count()
    {
        return $this->_get_value("4");
    }
    function set_count($value)
    {
        return $this->_set_value("4", $value);
    }
    function ann_id()
    {
        return $this->_get_value("5");
    }
    function set_ann_id($value)
    {
        return $this->_set_value("5", $value);
    }
    function title()
    {
        return $this->_get_value("6");
    }
    function set_title($value)
    {
        return $this->_set_value("6", $value);
    }
}
class item_attachment extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["item_attachment"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["item_attachment"]["1"] = "item_id";
        self::$fields["item_attachment"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["item_attachment"]["2"] = "item_num";
    }
    function item_id()
    {
        return $this->_get_value("1");
    }
    function set_item_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function item_num()
    {
        return $this->_get_value("2");
    }
    function set_item_num($value)
    {
        return $this->_set_value("2", $value);
    }
}
class mail_info_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["mail_info_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["mail_info_t"]["1"] = "mail_id";
        self::$fields["mail_info_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["mail_info_t"]["2"] = "mail_status";
    }
    function mail_id()
    {
        return $this->_get_value("1");
    }
    function set_mail_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function mail_status()
    {
        return $this->_get_value("2");
    }
    function set_mail_status($value)
    {
        return $this->_set_value("2", $value);
    }
}
class user_info extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["user_info"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["user_info"]["1"] = "userid";
        self::$fields["user_info"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["user_info"]["2"] = "reg_tm";
        self::$fields["user_info"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["user_info"]["3"] = "zone_id";
        self::$fields["user_info"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["user_info"]["4"] = "channel_id";
    }
    function userid()
    {
        return $this->_get_value("1");
    }
    function set_userid($value)
    {
        return $this->_set_value("1", $value);
    }
    function reg_tm()
    {
        return $this->_get_value("2");
    }
    function set_reg_tm($value)
    {
        return $this->_set_value("2", $value);
    }
    function zone_id()
    {
        return $this->_get_value("3");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("3", $value);
    }
    function channel_id()
    {
        return $this->_get_value("4");
    }
    function set_channel_id($value)
    {
        return $this->_set_value("4", $value);
    }
}
class sw_msgheader_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_msgheader_t"]["1"] = "PBString";
        $this->values["1"] = "";
        self::$fieldNames["sw_msgheader_t"]["1"] = "msg_name";
        self::$fields["sw_msgheader_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_msgheader_t"]["2"] = "ret";
        self::$fields["sw_msgheader_t"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_msgheader_t"]["3"] = "gateway_session";
    }
    function msg_name()
    {
        return $this->_get_value("1");
    }
    function set_msg_name($value)
    {
        return $this->_set_value("1", $value);
    }
    function ret()
    {
        return $this->_get_value("2");
    }
    function set_ret($value)
    {
        return $this->_set_value("2", $value);
    }
    function gateway_session()
    {
        return $this->_get_value("3");
    }
    function set_gateway_session($value)
    {
        return $this->_set_value("3", $value);
    }
}
class reg_server_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["reg_server_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["reg_server_in"]["1"] = "server_id";
        self::$fields["reg_server_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["reg_server_in"]["2"] = "listen_port";
    }
    function server_id()
    {
        return $this->_get_value("1");
    }
    function set_server_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function listen_port()
    {
        return $this->_get_value("2");
    }
    function set_listen_port($value)
    {
        return $this->_set_value("2", $value);
    }
}
class online_notify_sync_player_info_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["online_notify_sync_player_info_in"]["1"] = "player_basic_info_t";
        $this->values["1"] = array();
        self::$fieldNames["online_notify_sync_player_info_in"]["1"] = "player_list";
    }
    function player_list($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_player_list()
    {
        return $this->_add_arr_value("1");
    }
    function set_player_list($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_player_lists($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_player_list()
    {
        $this->_remove_last_arr_value("1");
    }
    function player_lists_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_player_lists()
    {
        return $this->_get_value("1");
    }
}
class online_notify_report_player_onoff_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["online_notify_report_player_onoff_in"]["1"] = "player_basic_info_t";
        $this->values["1"] = "";
        self::$fieldNames["online_notify_report_player_onoff_in"]["1"] = "basic";
        self::$fields["online_notify_report_player_onoff_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["online_notify_report_player_onoff_in"]["2"] = "login_or_logout";
    }
    function basic()
    {
        return $this->_get_value("1");
    }
    function set_basic($value)
    {
        return $this->_set_value("1", $value);
    }
    function login_or_logout()
    {
        return $this->_get_value("2");
    }
    function set_login_or_logout($value)
    {
        return $this->_set_value("2", $value);
    }
}
class sw_notify_kick_player_off_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_notify_kick_player_off_out"]["1"] = "player_basic_info_t";
        $this->values["1"] = "";
        self::$fieldNames["sw_notify_kick_player_off_out"]["1"] = "basic";
    }
    function basic()
    {
        return $this->_get_value("1");
    }
    function set_basic($value)
    {
        return $this->_set_value("1", $value);
    }
}
class add_new_mail_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["add_new_mail_in"]["1"] = "PBBytes";
        $this->values["1"] = "";
        self::$fieldNames["add_new_mail_in"]["1"] = "title";
        self::$fields["add_new_mail_in"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["add_new_mail_in"]["2"] = "from";
        self::$fields["add_new_mail_in"]["3"] = "PBBytes";
        $this->values["3"] = "";
        self::$fieldNames["add_new_mail_in"]["3"] = "content";
        self::$fields["add_new_mail_in"]["4"] = "sw_attach_item";
        $this->values["4"] = array();
        self::$fieldNames["add_new_mail_in"]["4"] = "items";
    }
    function title()
    {
        return $this->_get_value("1");
    }
    function set_title($value)
    {
        return $this->_set_value("1", $value);
    }
    function from()
    {
        return $this->_get_value("2");
    }
    function set_from($value)
    {
        return $this->_set_value("2", $value);
    }
    function content()
    {
        return $this->_get_value("3");
    }
    function set_content($value)
    {
        return $this->_set_value("3", $value);
    }
    function items($offset)
    {
        return $this->_get_arr_value("4", $offset);
    }
    function add_items()
    {
        return $this->_add_arr_value("4");
    }
    function set_items($index, $value)
    {
        $this->_set_arr_value("4", $index, $value);
    }
    function set_all_itemss($values)
    {
        return $this->_set_arr_values("4", $values);
    }
    function remove_last_items()
    {
        $this->_remove_last_arr_value("4");
    }
    function itemss_size()
    {
        return $this->_get_arr_size("4");
    }
    function get_itemss()
    {
        return $this->_get_value("4");
    }
}
class add_new_mail_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["add_new_mail_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["add_new_mail_out"]["1"] = "mail_id";
    }
    function mail_id()
    {
        return $this->_get_value("1");
    }
    function set_mail_id($value)
    {
        return $this->_set_value("1", $value);
    }
}
class add_new_mail_rel_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["add_new_mail_rel_in"]["1"] = "userinfo";
        $this->values["1"] = array();
        self::$fieldNames["add_new_mail_rel_in"]["1"] = "info";
    }
    function info($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_info()
    {
        return $this->_add_arr_value("1");
    }
    function set_info($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_infos($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_info()
    {
        $this->_remove_last_arr_value("1");
    }
    function infos_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_infos()
    {
        return $this->_get_value("1");
    }
}
class serial_online_rsp extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["serial_online_rsp"]["1"] = "player_basic_info_t";
        $this->values["1"] = "";
        self::$fieldNames["serial_online_rsp"]["1"] = "basic";
        self::$fields["serial_online_rsp"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["serial_online_rsp"]["2"] = "zone_id";
        self::$fields["serial_online_rsp"]["3"] = "PBBytes";
        $this->values["3"] = "";
        self::$fieldNames["serial_online_rsp"]["3"] = "msg_name";
        self::$fields["serial_online_rsp"]["4"] = "PBBytes";
        $this->values["4"] = "";
        self::$fieldNames["serial_online_rsp"]["4"] = "msg_body";
    }
    function basic()
    {
        return $this->_get_value("1");
    }
    function set_basic($value)
    {
        return $this->_set_value("1", $value);
    }
    function zone_id()
    {
        return $this->_get_value("2");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("2", $value);
    }
    function msg_name()
    {
        return $this->_get_value("3");
    }
    function set_msg_name($value)
    {
        return $this->_set_value("3", $value);
    }
    function msg_body()
    {
        return $this->_get_value("4");
    }
    function set_msg_body($value)
    {
        return $this->_set_value("4", $value);
    }
}
class sw_login_announcement_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_login_announcement_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_login_announcement_in"]["1"] = "channelid";
        self::$fields["sw_login_announcement_in"]["2"] = "sw_announcement";
        $this->values["2"] = "";
        self::$fieldNames["sw_login_announcement_in"]["2"] = "note";
    }
    function channelid()
    {
        return $this->_get_value("1");
    }
    function set_channelid($value)
    {
        return $this->_set_value("1", $value);
    }
    function note()
    {
        return $this->_get_value("2");
    }
    function set_note($value)
    {
        return $this->_set_value("2", $value);
    }
}
class sw_announcement_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_announcement_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_announcement_in"]["1"] = "zone_id";
        self::$fields["sw_announcement_in"]["2"] = "sw_announcement";
        $this->values["2"] = array();
        self::$fieldNames["sw_announcement_in"]["2"] = "note";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function note($offset)
    {
        return $this->_get_arr_value("2", $offset);
    }
    function add_note()
    {
        return $this->_add_arr_value("2");
    }
    function set_note($index, $value)
    {
        $this->_set_arr_value("2", $index, $value);
    }
    function set_all_notes($values)
    {
        return $this->_set_arr_values("2", $values);
    }
    function remove_last_note()
    {
        $this->_remove_last_arr_value("2");
    }
    function notes_size()
    {
        return $this->_get_arr_size("2");
    }
    function get_notes()
    {
        return $this->_get_value("2");
    }
}
class sw_announcement_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_announcement_out"]["2"] = "sw_announcement";
        $this->values["2"] = array();
        self::$fieldNames["sw_announcement_out"]["2"] = "note";
    }
    function note($offset)
    {
        return $this->_get_arr_value("2", $offset);
    }
    function add_note()
    {
        return $this->_add_arr_value("2");
    }
    function set_note($index, $value)
    {
        $this->_set_arr_value("2", $index, $value);
    }
    function set_all_notes($values)
    {
        return $this->_set_arr_values("2", $values);
    }
    function remove_last_note()
    {
        $this->_remove_last_arr_value("2");
    }
    function notes_size()
    {
        return $this->_get_arr_size("2");
    }
    function get_notes()
    {
        return $this->_get_value("2");
    }
}
class sw_ma_advertising_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_ma_advertising_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_ma_advertising_in"]["1"] = "zone_id";
        self::$fields["sw_ma_advertising_in"]["2"] = "sw_style";
        $this->values["2"] = array();
        self::$fieldNames["sw_ma_advertising_in"]["2"] = "content";
        self::$fields["sw_ma_advertising_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_ma_advertising_in"]["3"] = "opt";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function content($offset)
    {
        return $this->_get_arr_value("2", $offset);
    }
    function add_content()
    {
        return $this->_add_arr_value("2");
    }
    function set_content($index, $value)
    {
        $this->_set_arr_value("2", $index, $value);
    }
    function set_all_contents($values)
    {
        return $this->_set_arr_values("2", $values);
    }
    function remove_last_content()
    {
        $this->_remove_last_arr_value("2");
    }
    function contents_size()
    {
        return $this->_get_arr_size("2");
    }
    function get_contents()
    {
        return $this->_get_value("2");
    }
    function opt()
    {
        return $this->_get_value("3");
    }
    function set_opt($value)
    {
        return $this->_set_value("3", $value);
    }
}
class sw_ma_advertising_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_ma_advertising_out"]["1"] = "sw_style";
        $this->values["1"] = array();
        self::$fieldNames["sw_ma_advertising_out"]["1"] = "content";
        self::$fields["sw_ma_advertising_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_ma_advertising_out"]["2"] = "opt";
    }
    function content($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_content()
    {
        return $this->_add_arr_value("1");
    }
    function set_content($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_contents($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_content()
    {
        $this->_remove_last_arr_value("1");
    }
    function contents_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_contents()
    {
        return $this->_get_value("1");
    }
    function opt()
    {
        return $this->_get_value("2");
    }
    function set_opt($value)
    {
        return $this->_set_value("2", $value);
    }
}

class sw_add_diamond_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_add_diamond_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_add_diamond_in"]["1"] = "userid";
        self::$fields["sw_add_diamond_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_add_diamond_in"]["2"] = "reg_tm";
        self::$fields["sw_add_diamond_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_add_diamond_in"]["3"] = "channel_id";
        self::$fields["sw_add_diamond_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["sw_add_diamond_in"]["4"] = "buy_diamond_num";
        self::$fields["sw_add_diamond_in"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["sw_add_diamond_in"]["5"] = "ext_diamond_num";
        self::$fields["sw_add_diamond_in"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["sw_add_diamond_in"]["6"] = "buy_time";
        self::$fields["sw_add_diamond_in"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["sw_add_diamond_in"]["7"] = "buy_channel_id";
        self::$fields["sw_add_diamond_in"]["8"] = "PBInt";
        $this->values["8"] = "";
        self::$fieldNames["sw_add_diamond_in"]["8"] = "cost_money";
        self::$fields["sw_add_diamond_in"]["9"] = "PBInt";
        $this->values["9"] = "";
        self::$fieldNames["sw_add_diamond_in"]["9"] = "order_index";
        self::$fields["sw_add_diamond_in"]["10"] = "PBInt";
        $this->values["10"] = "";
        self::$fieldNames["sw_add_diamond_in"]["10"] = "add_times";
        self::$fields["sw_add_diamond_in"]["11"] = "PBInt";
        $this->values["11"] = "";
        self::$fieldNames["sw_add_diamond_in"]["11"] = "item_id";
        self::$fields["sw_add_diamond_in"]["12"] = "PBInt";
        $this->values["12"] = "";
        self::$fieldNames["sw_add_diamond_in"]["12"] = "item_count";
        self::$fields["sw_add_diamond_in"]["13"] = "PBInt";
        $this->values["13"] = "";
        self::$fieldNames["sw_add_diamond_in"]["13"] = "gift_id";
        self::$fields["sw_add_diamond_in"]["14"] = "PBInt";
        $this->values["14"] = "";
        self::$fieldNames["sw_add_diamond_in"]["14"] = "gift_count";
        self::$fields["sw_add_diamond_in"]["15"] = "PBInt";
        $this->values["15"] = "";
        self::$fieldNames["sw_add_diamond_in"]["15"] = "consume_type";
        self::$fields["sw_add_diamond_in"]["16"] = "PBInt";
        $this->values["16"] = "";
        self::$fieldNames["sw_add_diamond_in"]["16"] = "zone_id";
    }
    function userid()
    {
        return $this->_get_value("1");
    }
    function set_userid($value)
    {
        return $this->_set_value("1", $value);
    }
    function reg_tm()
    {
        return $this->_get_value("2");
    }
    function set_reg_tm($value)
    {
        return $this->_set_value("2", $value);
    }
    function channel_id()
    {
        return $this->_get_value("3");
    }
    function set_channel_id($value)
    {
        return $this->_set_value("3", $value);
    }
    function buy_diamond_num()
    {
        return $this->_get_value("4");
    }
    function set_buy_diamond_num($value)
    {
        return $this->_set_value("4", $value);
    }
    function ext_diamond_num()
    {
        return $this->_get_value("5");
    }
    function set_ext_diamond_num($value)
    {
        return $this->_set_value("5", $value);
    }
    function buy_time()
    {
        return $this->_get_value("6");
    }
    function set_buy_time($value)
    {
        return $this->_set_value("6", $value);
    }
    function buy_channel_id()
    {
        return $this->_get_value("7");
    }
    function set_buy_channel_id($value)
    {
        return $this->_set_value("7", $value);
    }
    function cost_money()
    {
        return $this->_get_value("8");
    }
    function set_cost_money($value)
    {
        return $this->_set_value("8", $value);
    }
    function order_index()
    {
        return $this->_get_value("9");
    }
    function set_order_index($value)
    {
        return $this->_set_value("9", $value);
    }
    function add_times()
    {
        return $this->_get_value("10");
    }
    function set_add_times($value)
    {
        return $this->_set_value("10", $value);
    }
    function item_id()
    {
        return $this->_get_value("11");
    }
    function set_item_id($value)
    {
        return $this->_set_value("11", $value);
    }
    function item_count()
    {
        return $this->_get_value("12");
    }
    function set_item_count($value)
    {
        return $this->_set_value("12", $value);
    }
    function gift_id()
    {
        return $this->_get_value("13");
    }
    function set_gift_id($value)
    {
        return $this->_set_value("13", $value);
    }
    function gift_count()
    {
        return $this->_get_value("14");
    }
    function set_gift_count($value)
    {
        return $this->_set_value("14", $value);
    }
    function consume_type()
    {
        return $this->_get_value("15");
    }
    function set_consume_type($value)
    {
        return $this->_set_value("15", $value);
    }
    function zone_id()
    {
        return $this->_get_value("16");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("16", $value);
    }
}
class sw_add_diamond_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_add_diamond_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_add_diamond_out"]["1"] = "order_index";
    }
    function order_index()
    {
        return $this->_get_value("1");
    }
    function set_order_index($value)
    {
        return $this->_set_value("1", $value);
    }
}


class mail_all_info_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["mail_all_info_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["mail_all_info_t"]["1"] = "mail_id_high";
        self::$fields["mail_all_info_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["mail_all_info_t"]["2"] = "mail_id_low";
        self::$fields["mail_all_info_t"]["3"] = "PBBytes";
        $this->values["3"] = "";
        self::$fieldNames["mail_all_info_t"]["3"] = "title";
        self::$fields["mail_all_info_t"]["4"] = "PBBytes";
        $this->values["4"] = "";
        self::$fieldNames["mail_all_info_t"]["4"] = "from";
        self::$fields["mail_all_info_t"]["5"] = "PBBytes";
        $this->values["5"] = "";
        self::$fieldNames["mail_all_info_t"]["5"] = "content";
        self::$fields["mail_all_info_t"]["6"] = "item_attachment";
        $this->values["6"] = array();
        self::$fieldNames["mail_all_info_t"]["6"] = "items";
    }
    function mail_id_high()
    {
        return $this->_get_value("1");
    }
    function set_mail_id_high($value)
    {
        return $this->_set_value("1", $value);
    }
    function mail_id_low()
    {
        return $this->_get_value("2");
    }
    function set_mail_id_low($value)
    {
        return $this->_set_value("2", $value);
    }
    function title()
    {
        return $this->_get_value("3");
    }
    function set_title($value)
    {
        return $this->_set_value("3", $value);
    }
    function from()
    {
        return $this->_get_value("4");
    }
    function set_from($value)
    {
        return $this->_set_value("4", $value);
    }
    function content()
    {
        return $this->_get_value("5");
    }
    function set_content($value)
    {
        return $this->_set_value("5", $value);
    }
    function items($offset)
    {
        return $this->_get_arr_value("6", $offset);
    }
    function add_items()
    {
        return $this->_add_arr_value("6");
    }
    function set_items($index, $value)
    {
        $this->_set_arr_value("6", $index, $value);
    }
    function set_all_itemss($values)
    {
        return $this->_set_arr_values("6", $values);
    }
    function remove_last_items()
    {
        $this->_remove_last_arr_value("6");
    }
    function itemss_size()
    {
        return $this->_get_arr_size("6");
    }
    function get_itemss()
    {
        return $this->_get_value("6");
    }
}
class sw_get_player_mail_list_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_get_player_mail_list_in"]["1"] = "player_basic_info_t";
        $this->values["1"] = "";
        self::$fieldNames["sw_get_player_mail_list_in"]["1"] = "player";
    }
    function player()
    {
        return $this->_get_value("1");
    }
    function set_player($value)
    {
        return $this->_set_value("1", $value);
    }
}
class sw_get_player_mail_list_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_get_player_mail_list_out"]["1"] = "player_basic_info_t";
        $this->values["1"] = "";
        self::$fieldNames["sw_get_player_mail_list_out"]["1"] = "player";
        self::$fields["sw_get_player_mail_list_out"]["2"] = "mail_info_t";
        $this->values["2"] = array();
        self::$fieldNames["sw_get_player_mail_list_out"]["2"] = "mails";
    }
    function player()
    {
        return $this->_get_value("1");
    }
    function set_player($value)
    {
        return $this->_set_value("1", $value);
    }
    function mails($offset)
    {
        return $this->_get_arr_value("2", $offset);
    }
    function add_mails()
    {
        return $this->_add_arr_value("2");
    }
    function set_mails($index, $value)
    {
        $this->_set_arr_value("2", $index, $value);
    }
    function set_all_mailss($values)
    {
        return $this->_set_arr_values("2", $values);
    }
    function remove_last_mails()
    {
        $this->_remove_last_arr_value("2");
    }
    function mailss_size()
    {
        return $this->_get_arr_size("2");
    }
    function get_mailss()
    {
        return $this->_get_value("2");
    }
}
class sw_update_player_mail_list_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_update_player_mail_list_in"]["1"] = "player_basic_info_t";
        $this->values["1"] = "";
        self::$fieldNames["sw_update_player_mail_list_in"]["1"] = "player";
        self::$fields["sw_update_player_mail_list_in"]["2"] = "mail_info_t";
        $this->values["2"] = array();
        self::$fieldNames["sw_update_player_mail_list_in"]["2"] = "mails";
    }
    function player()
    {
        return $this->_get_value("1");
    }
    function set_player($value)
    {
        return $this->_set_value("1", $value);
    }
    function mails($offset)
    {
        return $this->_get_arr_value("2", $offset);
    }
    function add_mails()
    {
        return $this->_add_arr_value("2");
    }
    function set_mails($index, $value)
    {
        $this->_set_arr_value("2", $index, $value);
    }
    function set_all_mailss($values)
    {
        return $this->_set_arr_values("2", $values);
    }
    function remove_last_mails()
    {
        $this->_remove_last_arr_value("2");
    }
    function mailss_size()
    {
        return $this->_get_arr_size("2");
    }
    function get_mailss()
    {
        return $this->_get_value("2");
    }
}
class sw_notify_player_new_mail_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_notify_player_new_mail_out"]["1"] = "player_basic_info_t";
        $this->values["1"] = array();
        self::$fieldNames["sw_notify_player_new_mail_out"]["1"] = "players";
        self::$fields["sw_notify_player_new_mail_out"]["2"] = "mail_info_t";
        $this->values["2"] = "";
        self::$fieldNames["sw_notify_player_new_mail_out"]["2"] = "new_mail";
    }
    function players($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_players()
    {
        return $this->_add_arr_value("1");
    }
    function set_players($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_playerss($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_players()
    {
        $this->_remove_last_arr_value("1");
    }
    function playerss_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_playerss()
    {
        return $this->_get_value("1");
    }
    function new_mail()
    {
        return $this->_get_value("2");
    }
    function set_new_mail($value)
    {
        return $this->_set_value("2", $value);
    }
}
class sw_create_new_player_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_create_new_player_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_create_new_player_in"]["1"] = "server_id";
        self::$fields["sw_create_new_player_in"]["2"] = "player_basic_info_t";
        $this->values["2"] = "";
        self::$fieldNames["sw_create_new_player_in"]["2"] = "player";
    }
    function server_id()
    {
        return $this->_get_value("1");
    }
    function set_server_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function player()
    {
        return $this->_get_value("2");
    }
    function set_player($value)
    {
        return $this->_set_value("2", $value);
    }
}
class sw_add_new_mail_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_add_new_mail_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_add_new_mail_in"]["1"] = "server_id";
        self::$fields["sw_add_new_mail_in"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["sw_add_new_mail_in"]["2"] = "title";
        self::$fields["sw_add_new_mail_in"]["3"] = "PBBytes";
        $this->values["3"] = "";
        self::$fieldNames["sw_add_new_mail_in"]["3"] = "from";
        self::$fields["sw_add_new_mail_in"]["4"] = "PBBytes";
        $this->values["4"] = "";
        self::$fieldNames["sw_add_new_mail_in"]["4"] = "content";
        self::$fields["sw_add_new_mail_in"]["5"] = "item_attachment";
        $this->values["5"] = array();
        self::$fieldNames["sw_add_new_mail_in"]["5"] = "items";
        self::$fields["sw_add_new_mail_in"]["6"] = "PBBool";
        $this->values["6"] = "";
        self::$fieldNames["sw_add_new_mail_in"]["6"] = "is_full_svc_mail";
        self::$fields["sw_add_new_mail_in"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["sw_add_new_mail_in"]["7"] = "mail_id";
    }
    function server_id()
    {
        return $this->_get_value("1");
    }
    function set_server_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function title()
    {
        return $this->_get_value("2");
    }
    function set_title($value)
    {
        return $this->_set_value("2", $value);
    }
    function from()
    {
        return $this->_get_value("3");
    }
    function set_from($value)
    {
        return $this->_set_value("3", $value);
    }
    function content()
    {
        return $this->_get_value("4");
    }
    function set_content($value)
    {
        return $this->_set_value("4", $value);
    }
    function items($offset)
    {
        return $this->_get_arr_value("5", $offset);
    }
    function add_items()
    {
        return $this->_add_arr_value("5");
    }
    function set_items($index, $value)
    {
        $this->_set_arr_value("5", $index, $value);
    }
    function set_all_itemss($values)
    {
        return $this->_set_arr_values("5", $values);
    }
    function remove_last_items()
    {
        $this->_remove_last_arr_value("5");
    }
    function itemss_size()
    {
        return $this->_get_arr_size("5");
    }
    function get_itemss()
    {
        return $this->_get_value("5");
    }
    function is_full_svc_mail()
    {
        return $this->_get_value("6");
    }
    function set_is_full_svc_mail($value)
    {
        return $this->_set_value("6", $value);
    }
    function mail_id()
    {
        return $this->_get_value("7");
    }
    function set_mail_id($value)
    {
        return $this->_set_value("7", $value);
    }
}
class sw_add_new_mail_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_add_new_mail_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_add_new_mail_out"]["1"] = "mail_id_high";
        self::$fields["sw_add_new_mail_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_add_new_mail_out"]["2"] = "mail_id_low";
        self::$fields["sw_add_new_mail_out"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_add_new_mail_out"]["3"] = "server_id";
    }
    function mail_id_high()
    {
        return $this->_get_value("1");
    }
    function set_mail_id_high($value)
    {
        return $this->_set_value("1", $value);
    }
    function mail_id_low()
    {
        return $this->_get_value("2");
    }
    function set_mail_id_low($value)
    {
        return $this->_set_value("2", $value);
    }
    function server_id()
    {
        return $this->_get_value("3");
    }
    function set_server_id($value)
    {
        return $this->_set_value("3", $value);
    }
}
class sw_add_new_mail_to_players_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_add_new_mail_to_players_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_add_new_mail_to_players_in"]["1"] = "mail_id_high";
        self::$fields["sw_add_new_mail_to_players_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_add_new_mail_to_players_in"]["2"] = "mail_id_low";
        self::$fields["sw_add_new_mail_to_players_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_add_new_mail_to_players_in"]["3"] = "server_id";
        self::$fields["sw_add_new_mail_to_players_in"]["4"] = "player_basic_info_t";
        $this->values["4"] = array();
        self::$fieldNames["sw_add_new_mail_to_players_in"]["4"] = "players";
        self::$fields["sw_add_new_mail_to_players_in"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["sw_add_new_mail_to_players_in"]["5"] = "page_num";
    }
    function mail_id_high()
    {
        return $this->_get_value("1");
    }
    function set_mail_id_high($value)
    {
        return $this->_set_value("1", $value);
    }
    function mail_id_low()
    {
        return $this->_get_value("2");
    }
    function set_mail_id_low($value)
    {
        return $this->_set_value("2", $value);
    }
    function server_id()
    {
        return $this->_get_value("3");
    }
    function set_server_id($value)
    {
        return $this->_set_value("3", $value);
    }
    function players($offset)
    {
        return $this->_get_arr_value("4", $offset);
    }
    function add_players()
    {
        return $this->_add_arr_value("4");
    }
    function set_players($index, $value)
    {
        $this->_set_arr_value("4", $index, $value);
    }
    function set_all_playerss($values)
    {
        return $this->_set_arr_values("4", $values);
    }
    function remove_last_players()
    {
        $this->_remove_last_arr_value("4");
    }
    function playerss_size()
    {
        return $this->_get_arr_size("4");
    }
    function get_playerss()
    {
        return $this->_get_value("4");
    }
    function page_num()
    {
        return $this->_get_value("5");
    }
    function set_page_num($value)
    {
        return $this->_set_value("5", $value);
    }
}
class sw_add_new_mail_to_players_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_add_new_mail_to_players_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_add_new_mail_to_players_out"]["1"] = "mail_id_high";
        self::$fields["sw_add_new_mail_to_players_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_add_new_mail_to_players_out"]["2"] = "mail_id_low";
        self::$fields["sw_add_new_mail_to_players_out"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_add_new_mail_to_players_out"]["3"] = "server_id";
        self::$fields["sw_add_new_mail_to_players_out"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["sw_add_new_mail_to_players_out"]["4"] = "page_num";
    }
    function mail_id_high()
    {
        return $this->_get_value("1");
    }
    function set_mail_id_high($value)
    {
        return $this->_set_value("1", $value);
    }
    function mail_id_low()
    {
        return $this->_get_value("2");
    }
    function set_mail_id_low($value)
    {
        return $this->_set_value("2", $value);
    }
    function server_id()
    {
        return $this->_get_value("3");
    }
    function set_server_id($value)
    {
        return $this->_set_value("3", $value);
    }
    function page_num()
    {
        return $this->_get_value("4");
    }
    function set_page_num($value)
    {
        return $this->_set_value("4", $value);
    }
}
class sw_notify_reload_conf_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_notify_reload_conf_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_notify_reload_conf_in"]["1"] = "server_id";
        self::$fields["sw_notify_reload_conf_in"]["2"] = "PBBytes";
        $this->values["2"] = array();
        self::$fieldNames["sw_notify_reload_conf_in"]["2"] = "conf_file_names";
    }
    function server_id()
    {
        return $this->_get_value("1");
    }
    function set_server_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function conf_file_names($offset)
    {
        $v = $this->_get_arr_value("2", $offset);
        return $v->get_value();
    }
    function append_conf_file_names($value)
    {
        $v = $this->_add_arr_value("2");
        $v->set_value($value);
    }
    function set_conf_file_names($index, $value)
    {
        $v = new self::$fields["sw_notify_reload_conf_in"]["2"]();
        $v->set_value($value);
        $this->_set_arr_value("2", $index, $v);
    }
    function remove_last_conf_file_names()
    {
        $this->_remove_last_arr_value("2");
    }
    function conf_file_namess_size()
    {
        return $this->_get_arr_size("2");
    }
    function get_conf_file_namess()
    {
        return $this->_get_value("2");
    }
}
class sw_freeze_player_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_freeze_player_in"]["1"] = "user_info";
        $this->values["1"] = array();
        self::$fieldNames["sw_freeze_player_in"]["1"] = "info";
        self::$fields["sw_freeze_player_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_freeze_player_in"]["2"] = "time";
    }
    function info($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_info()
    {
        return $this->_add_arr_value("1");
    }
    function set_info($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_infos($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_info()
    {
        $this->_remove_last_arr_value("1");
    }
    function infos_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_infos()
    {
        return $this->_get_value("1");
    }
    function time()
    {
        return $this->_get_value("2");
    }
    function set_time($value)
    {
        return $this->_set_value("2", $value);
    }
}
class sw_unfreeze_player_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_unfreeze_player_in"]["1"] = "user_info";
        $this->values["1"] = array();
        self::$fieldNames["sw_unfreeze_player_in"]["1"] = "info";
    }
    function info($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_info()
    {
        return $this->_add_arr_value("1");
    }
    function set_info($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_infos($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_info()
    {
        $this->_remove_last_arr_value("1");
    }
    function infos_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_infos()
    {
        return $this->_get_value("1");
    }
}
class sw_set_attribute_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_set_attribute_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_set_attribute_in"]["1"] = "userid";
        self::$fields["sw_set_attribute_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_set_attribute_in"]["2"] = "reg_tm";
        self::$fields["sw_set_attribute_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_set_attribute_in"]["3"] = "zone_id";
        self::$fields["sw_set_attribute_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["sw_set_attribute_in"]["4"] = "attribute_id";
        self::$fields["sw_set_attribute_in"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["sw_set_attribute_in"]["5"] = "attribute_value";
        self::$fields["sw_set_attribute_in"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["sw_set_attribute_in"]["6"] = "dead_tm";
        self::$fields["sw_set_attribute_in"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["sw_set_attribute_in"]["7"] = "channel_id";
    }
    function userid()
    {
        return $this->_get_value("1");
    }
    function set_userid($value)
    {
        return $this->_set_value("1", $value);
    }
    function reg_tm()
    {
        return $this->_get_value("2");
    }
    function set_reg_tm($value)
    {
        return $this->_set_value("2", $value);
    }
    function zone_id()
    {
        return $this->_get_value("3");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("3", $value);
    }
    function attribute_id()
    {
        return $this->_get_value("4");
    }
    function set_attribute_id($value)
    {
        return $this->_set_value("4", $value);
    }
    function attribute_value()
    {
        return $this->_get_value("5");
    }
    function set_attribute_value($value)
    {
        return $this->_set_value("5", $value);
    }
    function dead_tm()
    {
        return $this->_get_value("6");
    }
    function set_dead_tm($value)
    {
        return $this->_set_value("6", $value);
    }
    function channel_id()
    {
        return $this->_get_value("7");
    }
    function set_channel_id($value)
    {
        return $this->_set_value("7", $value);
    }
}
class sw_get_server_status_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_get_server_status_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_get_server_status_in"]["1"] = "zone_id";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
}
class server_data extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["server_data"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["server_data"]["1"] = "zone_id";
        self::$fields["server_data"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["server_data"]["2"] = "ol_player_num";
        self::$fields["server_data"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["server_data"]["3"] = "ip";
        self::$fields["server_data"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["server_data"]["4"] = "port";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function ol_player_num()
    {
        return $this->_get_value("2");
    }
    function set_ol_player_num($value)
    {
        return $this->_set_value("2", $value);
    }
    function ip()
    {
        return $this->_get_value("3");
    }
    function set_ip($value)
    {
        return $this->_set_value("3", $value);
    }
    function port()
    {
        return $this->_get_value("4");
    }
    function set_port($value)
    {
        return $this->_set_value("4", $value);
    }
}
class sw_get_server_status_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_get_server_status_out"]["1"] = "server_data";
        $this->values["1"] = array();
        self::$fieldNames["sw_get_server_status_out"]["1"] = "servers";
    }
    function servers($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_servers()
    {
        return $this->_add_arr_value("1");
    }
    function set_servers($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_serverss($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_servers()
    {
        $this->_remove_last_arr_value("1");
    }
    function servers_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_serverss()
    {
        return $this->_get_value("1");
    }
}
class sw_user_bag_modify_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_user_bag_modify_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_user_bag_modify_in"]["1"] = "user_id";
        self::$fields["sw_user_bag_modify_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_user_bag_modify_in"]["2"] = "reg_tm";
        self::$fields["sw_user_bag_modify_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_user_bag_modify_in"]["3"] = "zone_id";
        self::$fields["sw_user_bag_modify_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["sw_user_bag_modify_in"]["4"] = "item_id";
        self::$fields["sw_user_bag_modify_in"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["sw_user_bag_modify_in"]["5"] = "item_count";
        self::$fields["sw_user_bag_modify_in"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["sw_user_bag_modify_in"]["6"] = "modify_type";
        self::$fields["sw_user_bag_modify_in"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["sw_user_bag_modify_in"]["7"] = "delete_type";
        self::$fields["sw_user_bag_modify_in"]["8"] = "PBInt";
        $this->values["8"] = "";
        self::$fieldNames["sw_user_bag_modify_in"]["8"] = "channel_id";
    }
    function user_id()
    {
        return $this->_get_value("1");
    }
    function set_user_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function reg_tm()
    {
        return $this->_get_value("2");
    }
    function set_reg_tm($value)
    {
        return $this->_set_value("2", $value);
    }
    function zone_id()
    {
        return $this->_get_value("3");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("3", $value);
    }
    function item_id()
    {
        return $this->_get_value("4");
    }
    function set_item_id($value)
    {
        return $this->_set_value("4", $value);
    }
    function item_count()
    {
        return $this->_get_value("5");
    }
    function set_item_count($value)
    {
        return $this->_set_value("5", $value);
    }
    function modify_type()
    {
        return $this->_get_value("6");
    }
    function set_modify_type($value)
    {
        return $this->_set_value("6", $value);
    }
    function delete_type()
    {
        return $this->_get_value("7");
    }
    function set_delete_type($value)
    {
        return $this->_set_value("7", $value);
    }
    function channel_id()
    {
        return $this->_get_value("8");
    }
    function set_channel_id($value)
    {
        return $this->_set_value("8", $value);
    }
}
class sw_user_bag_modify_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_user_bag_modify_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_user_bag_modify_out"]["1"] = "user_id";
        self::$fields["sw_user_bag_modify_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_user_bag_modify_out"]["2"] = "reg_tm";
        self::$fields["sw_user_bag_modify_out"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_user_bag_modify_out"]["3"] = "zone_id";
        self::$fields["sw_user_bag_modify_out"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["sw_user_bag_modify_out"]["4"] = "channel_id";
    }
    function user_id()
    {
        return $this->_get_value("1");
    }
    function set_user_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function reg_tm()
    {
        return $this->_get_value("2");
    }
    function set_reg_tm($value)
    {
        return $this->_set_value("2", $value);
    }
    function zone_id()
    {
        return $this->_get_value("3");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("3", $value);
    }
    function channel_id()
    {
        return $this->_get_value("4");
    }
    function set_channel_id($value)
    {
        return $this->_set_value("4", $value);
    }
}

class sw_attribute_modify_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_attribute_modify_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_attribute_modify_in"]["1"] = "userid";
        self::$fields["sw_attribute_modify_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["sw_attribute_modify_in"]["2"] = "reg_tm";
        self::$fields["sw_attribute_modify_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["sw_attribute_modify_in"]["3"] = "zone_id";
        self::$fields["sw_attribute_modify_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["sw_attribute_modify_in"]["4"] = "attribute_id";
        self::$fields["sw_attribute_modify_in"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["sw_attribute_modify_in"]["5"] = "attribute_value";
        self::$fields["sw_attribute_modify_in"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["sw_attribute_modify_in"]["6"] = "dead_tm";
        self::$fields["sw_attribute_modify_in"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["sw_attribute_modify_in"]["7"] = "channel_id";
    }
    function userid()
    {
        return $this->_get_value("1");
    }
    function set_userid($value)
    {
        return $this->_set_value("1", $value);
    }
    function reg_tm()
    {
        return $this->_get_value("2");
    }
    function set_reg_tm($value)
    {
        return $this->_set_value("2", $value);
    }
    function zone_id()
    {
        return $this->_get_value("3");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("3", $value);
    }
    function attribute_id()
    {
        return $this->_get_value("4");
    }
    function set_attribute_id($value)
    {
        return $this->_set_value("4", $value);
    }
    function attribute_value()
    {
        return $this->_get_value("5");
    }
    function set_attribute_value($value)
    {
        return $this->_set_value("5", $value);
    }
    function dead_tm()
    {
        return $this->_get_value("6");
    }
    function set_dead_tm($value)
    {
        return $this->_set_value("6", $value);
    }
    function channel_id()
    {
        return $this->_get_value("7");
    }
    function set_channel_id($value)
    {
        return $this->_set_value("7", $value);
    }
}

class sw_ma_vip_control_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_ma_vip_control_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_ma_vip_control_in"]["1"] = "content";
    }
    function content()
    {
        return $this->_get_value("1");
    }
    function set_content($value)
    {
        return $this->_set_value("1", $value);
    }
}
class sw_ma_vip_control_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_ma_vip_control_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_ma_vip_control_out"]["1"] = "content";
    }
    function content()
    {
        return $this->_get_value("1");
    }
    function set_content($value)
    {
        return $this->_set_value("1", $value);
    }
}

class sw_loginaward_limittime_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_loginaward_limittime_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["sw_loginaward_limittime_in"]["1"] = "zone_id";
        self::$fields["sw_loginaward_limittime_in"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["sw_loginaward_limittime_in"]["2"] = "title";
        self::$fields["sw_loginaward_limittime_in"]["3"] = "PBBytes";
        $this->values["3"] = "";
        self::$fieldNames["sw_loginaward_limittime_in"]["3"] = "from";
        self::$fields["sw_loginaward_limittime_in"]["4"] = "PBBytes";
        $this->values["4"] = "";
        self::$fieldNames["sw_loginaward_limittime_in"]["4"] = "content";
        self::$fields["sw_loginaward_limittime_in"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["sw_loginaward_limittime_in"]["5"] = "award_begin";
        self::$fields["sw_loginaward_limittime_in"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["sw_loginaward_limittime_in"]["6"] = "award_end";
        self::$fields["sw_loginaward_limittime_in"]["7"] = "item_attachment";
        $this->values["7"] = array();
        self::$fieldNames["sw_loginaward_limittime_in"]["7"] = "items";
        self::$fields["sw_loginaward_limittime_in"]["8"] = "PBInt";
        $this->values["8"] = "";
        self::$fieldNames["sw_loginaward_limittime_in"]["8"] = "mail_id";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function title()
    {
        return $this->_get_value("2");
    }
    function set_title($value)
    {
        return $this->_set_value("2", $value);
    }
    function from()
    {
        return $this->_get_value("3");
    }
    function set_from($value)
    {
        return $this->_set_value("3", $value);
    }
    function content()
    {
        return $this->_get_value("4");
    }
    function set_content($value)
    {
        return $this->_set_value("4", $value);
    }
    function award_begin()
    {
        return $this->_get_value("5");
    }
    function set_award_begin($value)
    {
        return $this->_set_value("5", $value);
    }
    function award_end()
    {
        return $this->_get_value("6");
    }
    function set_award_end($value)
    {
        return $this->_set_value("6", $value);
    }
    function items($offset)
    {
        return $this->_get_arr_value("7", $offset);
    }
    function add_items()
    {
        return $this->_add_arr_value("7");
    }
    function set_items($index, $value)
    {
        $this->_set_arr_value("7", $index, $value);
    }
    function set_all_itemss($values)
    {
        return $this->_set_arr_values("7", $values);
    }
    function remove_last_items()
    {
        $this->_remove_last_arr_value("7");
    }
    function itemss_size()
    {
        return $this->_get_arr_size("7");
    }
    function get_itemss()
    {
        return $this->_get_value("7");
    }
    function mail_id()
    {
        return $this->_get_value("8");
    }
    function set_mail_id($value)
    {
        return $this->_set_value("8", $value);
    }
}
class sw_loginaward_limittime_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["sw_loginaward_limittime_out"]["1"] = "PBBool";
        $this->values["1"] = "";
        self::$fieldNames["sw_loginaward_limittime_out"]["1"] = "bSucc";
    }
    function bSucc()
    {
        return $this->_get_value("1");
    }
    function set_bSucc($value)
    {
        return $this->_set_value("1", $value);
    }
}

?>