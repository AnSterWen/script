<?php
require_once 'pb4php/message/pb_message.php';

class db_msgheader_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_msgheader_t"]["1"] = "PBBytes";
        $this->values["1"] = "";
        self::$fieldNames["db_msgheader_t"]["1"] = "msg_name";
        self::$fields["db_msgheader_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_msgheader_t"]["2"] = "target_uid";
        self::$fields["db_msgheader_t"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_msgheader_t"]["3"] = "errcode";
        self::$fields["db_msgheader_t"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_msgheader_t"]["4"] = "reg_time";
        self::$fields["db_msgheader_t"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_msgheader_t"]["5"] = "src_uid";
        self::$fields["db_msgheader_t"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["db_msgheader_t"]["6"] = "login_id";
        self::$fields["db_msgheader_t"]["7"] = "PBBytes";
        $this->values["7"] = "";
        self::$fieldNames["db_msgheader_t"]["7"] = "aux";
        self::$fields["db_msgheader_t"]["8"] = "PBInt";
        $this->values["8"] = "";
        self::$fieldNames["db_msgheader_t"]["8"] = "trans_id";
    }
    function msg_name()
    {
        return $this->_get_value("1");
    }
    function set_msg_name($value)
    {
        return $this->_set_value("1", $value);
    }
    function target_uid()
    {
        return $this->_get_value("2");
    }
    function set_target_uid($value)
    {
        return $this->_set_value("2", $value);
    }
    function errcode()
    {
        return $this->_get_value("3");
    }
    function set_errcode($value)
    {
        return $this->_set_value("3", $value);
    }
    function reg_time()
    {
        return $this->_get_value("4");
    }
    function set_reg_time($value)
    {
        return $this->_set_value("4", $value);
    }
    function src_uid()
    {
        return $this->_get_value("5");
    }
    function set_src_uid($value)
    {
        return $this->_set_value("5", $value);
    }
    function login_id()
    {
        return $this->_get_value("6");
    }
    function set_login_id($value)
    {
        return $this->_set_value("6", $value);
    }
    function aux()
    {
        return $this->_get_value("7");
    }
    function set_aux($value)
    {
        return $this->_set_value("7", $value);
    }
    function trans_id()
    {
        return $this->_get_value("8");
    }
    function set_trans_id($value)
    {
        return $this->_set_value("8", $value);
    }
}
class db_player_pvai_info_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_player_pvai_info_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_player_pvai_info_t"]["1"] = "rank";
        self::$fields["db_player_pvai_info_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_player_pvai_info_t"]["2"] = "accu_coin";
        self::$fields["db_player_pvai_info_t"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_player_pvai_info_t"]["3"] = "accu_reputation";
        self::$fields["db_player_pvai_info_t"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_player_pvai_info_t"]["4"] = "accu_times";
        self::$fields["db_player_pvai_info_t"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_player_pvai_info_t"]["5"] = "accu_end_time";
    }
    function rank()
    {
        return $this->_get_value("1");
    }
    function set_rank($value)
    {
        return $this->_set_value("1", $value);
    }
    function accu_coin()
    {
        return $this->_get_value("2");
    }
    function set_accu_coin($value)
    {
        return $this->_set_value("2", $value);
    }
    function accu_reputation()
    {
        return $this->_get_value("3");
    }
    function set_accu_reputation($value)
    {
        return $this->_set_value("3", $value);
    }
    function accu_times()
    {
        return $this->_get_value("4");
    }
    function set_accu_times($value)
    {
        return $this->_set_value("4", $value);
    }
    function accu_end_time()
    {
        return $this->_get_value("5");
    }
    function set_accu_end_time($value)
    {
        return $this->_set_value("5", $value);
    }
}
class db_player_attr_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_player_attr_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_player_attr_t"]["1"] = "key";
        self::$fields["db_player_attr_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_player_attr_t"]["2"] = "value";
        self::$fields["db_player_attr_t"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_player_attr_t"]["3"] = "dead_tm";
    }
    function key()
    {
        return $this->_get_value("1");
    }
    function set_key($value)
    {
        return $this->_set_value("1", $value);
    }
    function value()
    {
        return $this->_get_value("2");
    }
    function set_value($value)
    {
        return $this->_set_value("2", $value);
    }
    function dead_tm()
    {
        return $this->_get_value("3");
    }
    function set_dead_tm($value)
    {
        return $this->_set_value("3", $value);
    }
}
class db_player_info_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_player_info_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_player_info_t"]["1"] = "userid";
        self::$fields["db_player_info_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_player_info_t"]["2"] = "reg_time";
        self::$fields["db_player_info_t"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_player_info_t"]["3"] = "level";
        self::$fields["db_player_info_t"]["4"] = "PBBytes";
        $this->values["4"] = "";
        self::$fieldNames["db_player_info_t"]["4"] = "name";
        self::$fields["db_player_info_t"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_player_info_t"]["5"] = "type";
        self::$fields["db_player_info_t"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["db_player_info_t"]["6"] = "gender";
        self::$fields["db_player_info_t"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["db_player_info_t"]["7"] = "zone_id";
        self::$fields["db_player_info_t"]["8"] = "PBInt";
        $this->values["8"] = "";
        self::$fieldNames["db_player_info_t"]["8"] = "vip_lv";
        self::$fields["db_player_info_t"]["9"] = "db_player_pvai_info_t";
        $this->values["9"] = "";
        self::$fieldNames["db_player_info_t"]["9"] = "pvai_info";
        self::$fields["db_player_info_t"]["10"] = "db_player_attr_t";
        $this->values["10"] = array();
        self::$fieldNames["db_player_info_t"]["10"] = "player_attr";
        self::$fields["db_player_info_t"]["11"] = "PBInt";
        $this->values["11"] = "";
        self::$fieldNames["db_player_info_t"]["11"] = "kill_num";
        self::$fields["db_player_info_t"]["12"] = "PBInt";
        $this->values["12"] = array();
        self::$fieldNames["db_player_info_t"]["12"] = "fairy";
        self::$fields["db_player_info_t"]["13"] = "PBInt";
        $this->values["13"] = "";
        self::$fieldNames["db_player_info_t"]["13"] = "globalid";
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
    function level()
    {
        return $this->_get_value("3");
    }
    function set_level($value)
    {
        return $this->_set_value("3", $value);
    }
    function name()
    {
        return $this->_get_value("4");
    }
    function set_name($value)
    {
        return $this->_set_value("4", $value);
    }
    function type()
    {
        return $this->_get_value("5");
    }
    function set_type($value)
    {
        return $this->_set_value("5", $value);
    }
    function gender()
    {
        return $this->_get_value("6");
    }
    function set_gender($value)
    {
        return $this->_set_value("6", $value);
    }
    function zone_id()
    {
        return $this->_get_value("7");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("7", $value);
    }
    function vip_lv()
    {
        return $this->_get_value("8");
    }
    function set_vip_lv($value)
    {
        return $this->_set_value("8", $value);
    }
    function pvai_info()
    {
        return $this->_get_value("9");
    }
    function set_pvai_info($value)
    {
        return $this->_set_value("9", $value);
    }
    function player_attr($offset)
    {
        return $this->_get_arr_value("10", $offset);
    }
    function add_player_attr()
    {
        return $this->_add_arr_value("10");
    }
    function set_player_attr($index, $value)
    {
        $this->_set_arr_value("10", $index, $value);
    }
    function set_all_player_attrs($values)
    {
        return $this->_set_arr_values("10", $values);
    }
    function remove_last_player_attr()
    {
        $this->_remove_last_arr_value("10");
    }
    function player_attrs_size()
    {
        return $this->_get_arr_size("10");
    }
    function get_player_attrs()
    {
        return $this->_get_value("10");
    }
    function kill_num()
    {
        return $this->_get_value("11");
    }
    function set_kill_num($value)
    {
        return $this->_set_value("11", $value);
    }
    function fairy($offset)
    {
        $v = $this->_get_arr_value("12", $offset);
        return $v->get_value();
    }
    function append_fairy($value)
    {
        $v = $this->_add_arr_value("12");
        $v->set_value($value);
    }
    function set_fairy($index, $value)
    {
        $v = new self::$fields["db_player_info_t"]["12"]();
        $v->set_value($value);
        $this->_set_arr_value("12", $index, $v);
    }
    function remove_last_fairy()
    {
        $this->_remove_last_arr_value("12");
    }
    function fairys_size()
    {
        return $this->_get_arr_size("12");
    }
    function get_fairys()
    {
        return $this->_get_value("12");
    }
    function globalid()
    {
        return $this->_get_value("13");
    }
    function set_globalid($value)
    {
        return $this->_set_value("13", $value);
    }
}
class db_crtrole_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_crtrole_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_crtrole_in"]["1"] = "zone_id";
        self::$fields["db_crtrole_in"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["db_crtrole_in"]["2"] = "name";
        self::$fields["db_crtrole_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_crtrole_in"]["3"] = "type";
        self::$fields["db_crtrole_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_crtrole_in"]["4"] = "gender";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function name()
    {
        return $this->_get_value("2");
    }
    function set_name($value)
    {
        return $this->_set_value("2", $value);
    }
    function type()
    {
        return $this->_get_value("3");
    }
    function set_type($value)
    {
        return $this->_set_value("3", $value);
    }
    function gender()
    {
        return $this->_get_value("4");
    }
    function set_gender($value)
    {
        return $this->_set_value("4", $value);
    }
}
class db_crtrole_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_crtrole_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_crtrole_out"]["1"] = "regtime";
        self::$fields["db_crtrole_out"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["db_crtrole_out"]["2"] = "name";
        self::$fields["db_crtrole_out"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_crtrole_out"]["3"] = "type";
        self::$fields["db_crtrole_out"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_crtrole_out"]["4"] = "gender";
        self::$fields["db_crtrole_out"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_crtrole_out"]["5"] = "zone_id";
    }
    function regtime()
    {
        return $this->_get_value("1");
    }
    function set_regtime($value)
    {
        return $this->_set_value("1", $value);
    }
    function name()
    {
        return $this->_get_value("2");
    }
    function set_name($value)
    {
        return $this->_set_value("2", $value);
    }
    function type()
    {
        return $this->_get_value("3");
    }
    function set_type($value)
    {
        return $this->_set_value("3", $value);
    }
    function gender()
    {
        return $this->_get_value("4");
    }
    function set_gender($value)
    {
        return $this->_set_value("4", $value);
    }
    function zone_id()
    {
        return $this->_get_value("5");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("5", $value);
    }
}
class db_get_role_list_by_gm_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_list_by_gm_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_role_list_by_gm_in"]["1"] = "zone_id";
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
class db_get_role_list_by_gm_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_list_by_gm_out"]["1"] = "db_player_info_t";
        $this->values["1"] = array();
        self::$fieldNames["db_get_role_list_by_gm_out"]["1"] = "roles";
    }
    function roles($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_roles()
    {
        return $this->_add_arr_value("1");
    }
    function set_roles($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_roless($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_roles()
    {
        $this->_remove_last_arr_value("1");
    }
    function roles_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_roless()
    {
        return $this->_get_value("1");
    }
}
class db_backpack_query_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_backpack_query_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_backpack_query_in"]["1"] = "zone_id";
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
class db_equip_hole extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_equip_hole"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_equip_hole"]["1"] = "hole_index";
        self::$fields["db_equip_hole"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_equip_hole"]["2"] = "item_gem_id";
        self::$fields["db_equip_hole"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_equip_hole"]["3"] = "attr_key";
        self::$fields["db_equip_hole"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_equip_hole"]["4"] = "attr_value";
    }
    function hole_index()
    {
        return $this->_get_value("1");
    }
    function set_hole_index($value)
    {
        return $this->_set_value("1", $value);
    }
    function item_gem_id()
    {
        return $this->_get_value("2");
    }
    function set_item_gem_id($value)
    {
        return $this->_set_value("2", $value);
    }
    function attr_key()
    {
        return $this->_get_value("3");
    }
    function set_attr_key($value)
    {
        return $this->_set_value("3", $value);
    }
    function attr_value()
    {
        return $this->_get_value("4");
    }
    function set_attr_value($value)
    {
        return $this->_set_value("4", $value);
    }
}
class db_packpos extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_packpos"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_packpos"]["1"] = "pos";
        self::$fields["db_packpos"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_packpos"]["2"] = "item_id";
        self::$fields["db_packpos"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_packpos"]["3"] = "item_level";
        self::$fields["db_packpos"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_packpos"]["4"] = "item_num";
        self::$fields["db_packpos"]["9"] = "PBInt";
        $this->values["9"] = "";
        self::$fieldNames["db_packpos"]["9"] = "hole1";
        self::$fields["db_packpos"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["db_packpos"]["6"] = "hole2";
        self::$fields["db_packpos"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["db_packpos"]["7"] = "hole3";
        self::$fields["db_packpos"]["8"] = "PBInt";
        $this->values["8"] = "";
        self::$fieldNames["db_packpos"]["8"] = "hole4";
        self::$fields["db_packpos"]["5"] = "db_equip_hole";
        $this->values["5"] = array();
        self::$fieldNames["db_packpos"]["5"] = "equip_holes";
    }
    function pos()
    {
        return $this->_get_value("1");
    }
    function set_pos($value)
    {
        return $this->_set_value("1", $value);
    }
    function item_id()
    {
        return $this->_get_value("2");
    }
    function set_item_id($value)
    {
        return $this->_set_value("2", $value);
    }
    function item_level()
    {
        return $this->_get_value("3");
    }
    function set_item_level($value)
    {
        return $this->_set_value("3", $value);
    }
    function item_num()
    {
        return $this->_get_value("4");
    }
    function set_item_num($value)
    {
        return $this->_set_value("4", $value);
    }
    function hole1()
    {
        return $this->_get_value("9");
    }
    function set_hole1($value)
    {
        return $this->_set_value("9", $value);
    }
    function hole2()
    {
        return $this->_get_value("6");
    }
    function set_hole2($value)
    {
        return $this->_set_value("6", $value);
    }
    function hole3()
    {
        return $this->_get_value("7");
    }
    function set_hole3($value)
    {
        return $this->_set_value("7", $value);
    }
    function hole4()
    {
        return $this->_get_value("8");
    }
    function set_hole4($value)
    {
        return $this->_set_value("8", $value);
    }
    function equip_holes($offset)
    {
        return $this->_get_arr_value("5", $offset);
    }
    function add_equip_holes()
    {
        return $this->_add_arr_value("5");
    }
    function set_equip_holes($index, $value)
    {
        $this->_set_arr_value("5", $index, $value);
    }
    function set_all_equip_holess($values)
    {
        return $this->_set_arr_values("5", $values);
    }
    function remove_last_equip_holes()
    {
        $this->_remove_last_arr_value("5");
    }
    function equip_holess_size()
    {
        return $this->_get_arr_size("5");
    }
    function get_equip_holess()
    {
        return $this->_get_value("5");
    }
}
class db_backpack_query_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_backpack_query_out"]["1"] = "db_packpos";
        $this->values["1"] = array();
        self::$fieldNames["db_backpack_query_out"]["1"] = "items";
    }
    function items($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_items()
    {
        return $this->_add_arr_value("1");
    }
    function set_items($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_itemss($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_items()
    {
        $this->_remove_last_arr_value("1");
    }
    function itemss_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_itemss()
    {
        return $this->_get_value("1");
    }
}
class db_attribute_query_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_attribute_query_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_attribute_query_in"]["1"] = "zone_id";
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
class db_attribute_info extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_attribute_info"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_attribute_info"]["1"] = "attribute_id";
        self::$fields["db_attribute_info"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_attribute_info"]["2"] = "attribute_value";
        self::$fields["db_attribute_info"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_attribute_info"]["3"] = "dead_tm";
    }
    function attribute_id()
    {
        return $this->_get_value("1");
    }
    function set_attribute_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function attribute_value()
    {
        return $this->_get_value("2");
    }
    function set_attribute_value($value)
    {
        return $this->_set_value("2", $value);
    }
    function dead_tm()
    {
        return $this->_get_value("3");
    }
    function set_dead_tm($value)
    {
        return $this->_set_value("3", $value);
    }
}
class db_attribute_query_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_attribute_query_out"]["1"] = "db_attribute_info";
        $this->values["1"] = array();
        self::$fieldNames["db_attribute_query_out"]["1"] = "attributes";
    }
    function attributes($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_attributes()
    {
        return $this->_add_arr_value("1");
    }
    function set_attributes($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_attributess($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_attributes()
    {
        $this->_remove_last_arr_value("1");
    }
    function attributess_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_attributess()
    {
        return $this->_get_value("1");
    }
}
class db_attribute_set_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_attribute_set_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_attribute_set_in"]["1"] = "zone_id";
        self::$fields["db_attribute_set_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_attribute_set_in"]["2"] = "attribute_id";
        self::$fields["db_attribute_set_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_attribute_set_in"]["3"] = "attribute_value";
        self::$fields["db_attribute_set_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_attribute_set_in"]["4"] = "dead_tm";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function attribute_id()
    {
        return $this->_get_value("2");
    }
    function set_attribute_id($value)
    {
        return $this->_set_value("2", $value);
    }
    function attribute_value()
    {
        return $this->_get_value("3");
    }
    function set_attribute_value($value)
    {
        return $this->_set_value("3", $value);
    }
    function dead_tm()
    {
        return $this->_get_value("4");
    }
    function set_dead_tm($value)
    {
        return $this->_set_value("4", $value);
    }
}
class db_server_attr_query_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_server_attr_query_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_server_attr_query_in"]["1"] = "zone_id";
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
class db_server_attr_query_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_server_attr_query_out"]["1"] = "db_attribute_info";
        $this->values["1"] = array();
        self::$fieldNames["db_server_attr_query_out"]["1"] = "server_attributes";
    }
    function server_attributes($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_server_attributes()
    {
        return $this->_add_arr_value("1");
    }
    function set_server_attributes($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_server_attributess($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_server_attributes()
    {
        $this->_remove_last_arr_value("1");
    }
    function server_attributess_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_server_attributess()
    {
        return $this->_get_value("1");
    }
}
class db_server_attr_set_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_server_attr_set_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_server_attr_set_in"]["1"] = "zone_id";
        self::$fields["db_server_attr_set_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_server_attr_set_in"]["2"] = "server_attr_id";
        self::$fields["db_server_attr_set_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_server_attr_set_in"]["3"] = "server_attr_value";
        self::$fields["db_server_attr_set_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_server_attr_set_in"]["4"] = "dead_tm";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function server_attr_id()
    {
        return $this->_get_value("2");
    }
    function set_server_attr_id($value)
    {
        return $this->_set_value("2", $value);
    }
    function server_attr_value()
    {
        return $this->_get_value("3");
    }
    function set_server_attr_value($value)
    {
        return $this->_set_value("3", $value);
    }
    function dead_tm()
    {
        return $this->_get_value("4");
    }
    function set_dead_tm($value)
    {
        return $this->_set_value("4", $value);
    }
}
class db_shared_attribute_query_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_shared_attribute_query_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_shared_attribute_query_in"]["1"] = "zone_id";
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
class db_shared_attribute_query_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_shared_attribute_query_out"]["1"] = "db_attribute_info";
        $this->values["1"] = array();
        self::$fieldNames["db_shared_attribute_query_out"]["1"] = "shared_attributes";
    }
    function shared_attributes($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_shared_attributes()
    {
        return $this->_add_arr_value("1");
    }
    function set_shared_attributes($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_shared_attributess($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_shared_attributes()
    {
        $this->_remove_last_arr_value("1");
    }
    function shared_attributess_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_shared_attributess()
    {
        return $this->_get_value("1");
    }
}
class db_shared_attribute_set_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_shared_attribute_set_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_shared_attribute_set_in"]["1"] = "zone_id";
        self::$fields["db_shared_attribute_set_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_shared_attribute_set_in"]["2"] = "attribute_id";
        self::$fields["db_shared_attribute_set_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_shared_attribute_set_in"]["3"] = "attribute_value";
        self::$fields["db_shared_attribute_set_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_shared_attribute_set_in"]["4"] = "dead_tm";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function attribute_id()
    {
        return $this->_get_value("2");
    }
    function set_attribute_id($value)
    {
        return $this->_set_value("2", $value);
    }
    function attribute_value()
    {
        return $this->_get_value("3");
    }
    function set_attribute_value($value)
    {
        return $this->_set_value("3", $value);
    }
    function dead_tm()
    {
        return $this->_get_value("4");
    }
    function set_dead_tm($value)
    {
        return $this->_set_value("4", $value);
    }
}
class db_friend_query_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_friend_query_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_friend_query_in"]["1"] = "zone_id";
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
class db_query_id_by_name_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_id_by_name_in"]["1"] = "PBBytes";
        $this->values["1"] = "";
        self::$fieldNames["db_query_id_by_name_in"]["1"] = "name";
        self::$fields["db_query_id_by_name_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_query_id_by_name_in"]["2"] = "zone_id";
    }
    function name()
    {
        return $this->_get_value("1");
    }
    function set_name($value)
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
}
class db_query_id_by_name_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_id_by_name_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_query_id_by_name_out"]["1"] = "userid";
        self::$fields["db_query_id_by_name_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_query_id_by_name_out"]["2"] = "reg_tm";
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
}
class db_friend_query_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_friend_query_out"]["1"] = "db_player_info_t";
        $this->values["1"] = array();
        self::$fieldNames["db_friend_query_out"]["1"] = "friends";
    }
    function friends($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_friends()
    {
        return $this->_add_arr_value("1");
    }
    function set_friends($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_friendss($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_friends()
    {
        $this->_remove_last_arr_value("1");
    }
    function friendss_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_friendss()
    {
        return $this->_get_value("1");
    }
}
class mail_item_attachment_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["mail_item_attachment_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["mail_item_attachment_t"]["1"] = "item_id";
        self::$fields["mail_item_attachment_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["mail_item_attachment_t"]["2"] = "item_num";
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
class db_mail_info_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_mail_info_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_mail_info_t"]["1"] = "mail_id";
        self::$fields["db_mail_info_t"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["db_mail_info_t"]["2"] = "title";
        self::$fields["db_mail_info_t"]["3"] = "PBBytes";
        $this->values["3"] = "";
        self::$fieldNames["db_mail_info_t"]["3"] = "come_from";
        self::$fields["db_mail_info_t"]["4"] = "PBBytes";
        $this->values["4"] = "";
        self::$fieldNames["db_mail_info_t"]["4"] = "content";
        self::$fields["db_mail_info_t"]["5"] = "mail_item_attachment_t";
        $this->values["5"] = array();
        self::$fieldNames["db_mail_info_t"]["5"] = "items";
    }
    function mail_id()
    {
        return $this->_get_value("1");
    }
    function set_mail_id($value)
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
    function come_from()
    {
        return $this->_get_value("3");
    }
    function set_come_from($value)
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
}
class db_add_new_mail_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_add_new_mail_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_add_new_mail_in"]["1"] = "zone_id";
        self::$fields["db_add_new_mail_in"]["2"] = "db_mail_info_t";
        $this->values["2"] = "";
        self::$fieldNames["db_add_new_mail_in"]["2"] = "mail_info";
        self::$fields["db_add_new_mail_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_add_new_mail_in"]["3"] = "gm_server_id";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function mail_info()
    {
        return $this->_get_value("2");
    }
    function set_mail_info($value)
    {
        return $this->_set_value("2", $value);
    }
    function gm_server_id()
    {
        return $this->_get_value("3");
    }
    function set_gm_server_id($value)
    {
        return $this->_set_value("3", $value);
    }
}
class db_add_new_mail_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_add_new_mail_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_add_new_mail_out"]["1"] = "zone_id";
        self::$fields["db_add_new_mail_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_add_new_mail_out"]["2"] = "mail_id";
        self::$fields["db_add_new_mail_out"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_add_new_mail_out"]["3"] = "gm_server_id";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function mail_id()
    {
        return $this->_get_value("2");
    }
    function set_mail_id($value)
    {
        return $this->_set_value("2", $value);
    }
    function gm_server_id()
    {
        return $this->_get_value("3");
    }
    function set_gm_server_id($value)
    {
        return $this->_set_value("3", $value);
    }
}
class db_query_mail_infos_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_mail_infos_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_query_mail_infos_in"]["1"] = "zone_id";
        self::$fields["db_query_mail_infos_in"]["2"] = "PBInt";
        $this->values["2"] = array();
        self::$fieldNames["db_query_mail_infos_in"]["2"] = "mail_ids";
        self::$fields["db_query_mail_infos_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_query_mail_infos_in"]["3"] = "query_cmd";
        self::$fields["db_query_mail_infos_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_query_mail_infos_in"]["4"] = "page_num";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function mail_ids($offset)
    {
        $v = $this->_get_arr_value("2", $offset);
        return $v->get_value();
    }
    function append_mail_ids($value)
    {
        $v = $this->_add_arr_value("2");
        $v->set_value($value);
    }
    function set_mail_ids($index, $value)
    {
        $v = new self::$fields["db_query_mail_infos_in"]["2"]();
        $v->set_value($value);
        $this->_set_arr_value("2", $index, $v);
    }
    function remove_last_mail_ids()
    {
        $this->_remove_last_arr_value("2");
    }
    function mail_idss_size()
    {
        return $this->_get_arr_size("2");
    }
    function get_mail_idss()
    {
        return $this->_get_value("2");
    }
    function query_cmd()
    {
        return $this->_get_value("3");
    }
    function set_query_cmd($value)
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
class db_query_mail_infos_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_mail_infos_out"]["1"] = "db_mail_info_t";
        $this->values["1"] = array();
        self::$fieldNames["db_query_mail_infos_out"]["1"] = "mail_infos";
        self::$fields["db_query_mail_infos_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_query_mail_infos_out"]["2"] = "query_cmd";
        self::$fields["db_query_mail_infos_out"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_query_mail_infos_out"]["3"] = "page_num";
    }
    function mail_infos($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_mail_infos()
    {
        return $this->_add_arr_value("1");
    }
    function set_mail_infos($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_mail_infoss($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_mail_infos()
    {
        $this->_remove_last_arr_value("1");
    }
    function mail_infoss_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_mail_infoss()
    {
        return $this->_get_value("1");
    }
    function query_cmd()
    {
        return $this->_get_value("2");
    }
    function set_query_cmd($value)
    {
        return $this->_set_value("2", $value);
    }
    function page_num()
    {
        return $this->_get_value("3");
    }
    function set_page_num($value)
    {
        return $this->_set_value("3", $value);
    }
}
class db_query_players_info_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_players_info_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_query_players_info_in"]["1"] = "zone_id";
        self::$fields["db_query_players_info_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_query_players_info_in"]["2"] = "cmd";
        self::$fields["db_query_players_info_in"]["3"] = "PBBool";
        $this->values["3"] = "";
        self::$fieldNames["db_query_players_info_in"]["3"] = "is_ref_cnt_cmd";
        self::$fields["db_query_players_info_in"]["4"] = "db_player_info_t";
        $this->values["4"] = array();
        self::$fieldNames["db_query_players_info_in"]["4"] = "players";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function cmd()
    {
        return $this->_get_value("2");
    }
    function set_cmd($value)
    {
        return $this->_set_value("2", $value);
    }
    function is_ref_cnt_cmd()
    {
        return $this->_get_value("3");
    }
    function set_is_ref_cnt_cmd($value)
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
}
class db_query_players_info_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_players_info_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_query_players_info_out"]["1"] = "cmd";
        self::$fields["db_query_players_info_out"]["2"] = "PBBool";
        $this->values["2"] = "";
        self::$fieldNames["db_query_players_info_out"]["2"] = "is_ref_cnt_cmd";
        self::$fields["db_query_players_info_out"]["3"] = "db_player_info_t";
        $this->values["3"] = array();
        self::$fieldNames["db_query_players_info_out"]["3"] = "players";
    }
    function cmd()
    {
        return $this->_get_value("1");
    }
    function set_cmd($value)
    {
        return $this->_set_value("1", $value);
    }
    function is_ref_cnt_cmd()
    {
        return $this->_get_value("2");
    }
    function set_is_ref_cnt_cmd($value)
    {
        return $this->_set_value("2", $value);
    }
    function players($offset)
    {
        return $this->_get_arr_value("3", $offset);
    }
    function add_players()
    {
        return $this->_add_arr_value("3");
    }
    function set_players($index, $value)
    {
        $this->_set_arr_value("3", $index, $value);
    }
    function set_all_playerss($values)
    {
        return $this->_set_arr_values("3", $values);
    }
    function remove_last_players()
    {
        $this->_remove_last_arr_value("3");
    }
    function playerss_size()
    {
        return $this->_get_arr_size("3");
    }
    function get_playerss()
    {
        return $this->_get_value("3");
    }
}
class db_get_players_info_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_players_info_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_players_info_in"]["1"] = "zone_id";
        self::$fields["db_get_players_info_in"]["2"] = "db_player_info_t";
        $this->values["2"] = array();
        self::$fieldNames["db_get_players_info_in"]["2"] = "players";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function players($offset)
    {
        return $this->_get_arr_value("2", $offset);
    }
    function add_players()
    {
        return $this->_add_arr_value("2");
    }
    function set_players($index, $value)
    {
        $this->_set_arr_value("2", $index, $value);
    }
    function set_all_playerss($values)
    {
        return $this->_set_arr_values("2", $values);
    }
    function remove_last_players()
    {
        $this->_remove_last_arr_value("2");
    }
    function playerss_size()
    {
        return $this->_get_arr_size("2");
    }
    function get_playerss()
    {
        return $this->_get_value("2");
    }
}
class db_get_players_info_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_players_info_out"]["1"] = "db_player_info_t";
        $this->values["1"] = array();
        self::$fieldNames["db_get_players_info_out"]["1"] = "players";
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
}
class db_query_userinfo_by_name_zone_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_userinfo_by_name_zone_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_query_userinfo_by_name_zone_in"]["1"] = "zone_id";
        self::$fields["db_query_userinfo_by_name_zone_in"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["db_query_userinfo_by_name_zone_in"]["2"] = "name";
        self::$fields["db_query_userinfo_by_name_zone_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_query_userinfo_by_name_zone_in"]["3"] = "channelid";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function name()
    {
        return $this->_get_value("2");
    }
    function set_name($value)
    {
        return $this->_set_value("2", $value);
    }
    function channelid()
    {
        return $this->_get_value("3");
    }
    function set_channelid($value)
    {
        return $this->_set_value("3", $value);
    }
}
class db_query_userinfo_by_name_zone_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_userinfo_by_name_zone_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_query_userinfo_by_name_zone_out"]["1"] = "userid";
        self::$fields["db_query_userinfo_by_name_zone_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_query_userinfo_by_name_zone_out"]["2"] = "reg_tm";
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
}
class db_query_real_userid_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_real_userid_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_query_real_userid_in"]["1"] = "zone_id";
        self::$fields["db_query_real_userid_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_query_real_userid_in"]["2"] = "userid";
        self::$fields["db_query_real_userid_in"]["3"] = "PBBytes";
        $this->values["3"] = "";
        self::$fieldNames["db_query_real_userid_in"]["3"] = "key";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function userid()
    {
        return $this->_get_value("2");
    }
    function set_userid($value)
    {
        return $this->_set_value("2", $value);
    }
    function key()
    {
        return $this->_get_value("3");
    }
    function set_key($value)
    {
        return $this->_set_value("3", $value);
    }
}
class db_query_real_userid_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_real_userid_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_query_real_userid_out"]["1"] = "real_userid";
        self::$fields["db_query_real_userid_out"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["db_query_real_userid_out"]["2"] = "key";
    }
    function real_userid()
    {
        return $this->_get_value("1");
    }
    function set_real_userid($value)
    {
        return $this->_set_value("1", $value);
    }
    function key()
    {
        return $this->_get_value("2");
    }
    function set_key($value)
    {
        return $this->_set_value("2", $value);
    }
}
class db_user_info extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_user_info"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_user_info"]["1"] = "userid";
        self::$fields["db_user_info"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_user_info"]["2"] = "reg_tm";
        self::$fields["db_user_info"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_user_info"]["3"] = "zone_id";
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
}
class db_set_freeze_player_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_set_freeze_player_in"]["1"] = "db_user_info";
        $this->values["1"] = array();
        self::$fieldNames["db_set_freeze_player_in"]["1"] = "info";
        self::$fields["db_set_freeze_player_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_set_freeze_player_in"]["2"] = "time";
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
class db_lookup_freeze_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_lookup_freeze_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_lookup_freeze_in"]["1"] = "zone_id";
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
class db_lookup_freeze_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_lookup_freeze_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_lookup_freeze_out"]["1"] = "time";
    }
    function time()
    {
        return $this->_get_value("1");
    }
    function set_time($value)
    {
        return $this->_set_value("1", $value);
    }
}
class db_sw_attribute_set_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_sw_attribute_set_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_sw_attribute_set_in"]["1"] = "userid";
        self::$fields["db_sw_attribute_set_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_sw_attribute_set_in"]["2"] = "reg_tm";
        self::$fields["db_sw_attribute_set_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_sw_attribute_set_in"]["3"] = "zone_id";
        self::$fields["db_sw_attribute_set_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_sw_attribute_set_in"]["4"] = "attribute_id";
        self::$fields["db_sw_attribute_set_in"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_sw_attribute_set_in"]["5"] = "attribute_value";
        self::$fields["db_sw_attribute_set_in"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["db_sw_attribute_set_in"]["6"] = "dead_tm";
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
}
class db_server_attr_add_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_server_attr_add_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_server_attr_add_in"]["1"] = "zone_id";
        self::$fields["db_server_attr_add_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_server_attr_add_in"]["2"] = "server_attr_id";
        self::$fields["db_server_attr_add_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_server_attr_add_in"]["3"] = "server_attr_value";
        self::$fields["db_server_attr_add_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_server_attr_add_in"]["4"] = "dead_tm";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function server_attr_id()
    {
        return $this->_get_value("2");
    }
    function set_server_attr_id($value)
    {
        return $this->_set_value("2", $value);
    }
    function server_attr_value()
    {
        return $this->_get_value("3");
    }
    function set_server_attr_value($value)
    {
        return $this->_set_value("3", $value);
    }
    function dead_tm()
    {
        return $this->_get_value("4");
    }
    function set_dead_tm($value)
    {
        return $this->_set_value("4", $value);
    }
}
class registers_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["registers_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["registers_t"]["1"] = "zone_id";
        self::$fields["registers_t"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["registers_t"]["2"] = "num";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
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
class db_svr_register_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_svr_register_t"]["1"] = "registers_t";
        $this->values["1"] = array();
        self::$fieldNames["db_svr_register_t"]["1"] = "infos";
    }
    function infos($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_infos()
    {
        return $this->_add_arr_value("1");
    }
    function set_infos($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_infoss($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_infos()
    {
        $this->_remove_last_arr_value("1");
    }
    function infoss_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_infoss()
    {
        return $this->_get_value("1");
    }
}
class db_get_recommend_svr_list_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_recommend_svr_list_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_recommend_svr_list_in"]["1"] = "zone_id";
        self::$fields["db_get_recommend_svr_list_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_get_recommend_svr_list_in"]["2"] = "attribute_id";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function attribute_id()
    {
        return $this->_get_value("2");
    }
    function set_attribute_id($value)
    {
        return $this->_set_value("2", $value);
    }
}
class db_get_recommend_svr_list_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_recommend_svr_list_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_recommend_svr_list_out"]["1"] = "server_id";
    }
    function server_id()
    {
        return $this->_get_value("1");
    }
    function set_server_id($value)
    {
        return $this->_set_value("1", $value);
    }
}
class db_del_user_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_del_user_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_del_user_in"]["1"] = "zone_id";
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
class db_recover_user_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_recover_user_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_recover_user_in"]["1"] = "zone_id";
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
class db_query_del_user_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_del_user_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_query_del_user_in"]["1"] = "zone_id";
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
class db_query_del_user_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_query_del_user_out"]["1"] = "PBBool";
        $this->values["1"] = "";
        self::$fieldNames["db_query_del_user_out"]["1"] = "res";
    }
    function res()
    {
        return $this->_get_value("1");
    }
    function set_res($value)
    {
        return $this->_set_value("1", $value);
    }
}
class type_cd extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["type_cd"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["type_cd"]["1"] = "type";
        self::$fields["type_cd"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["type_cd"]["2"] = "accepter";
        self::$fields["type_cd"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["type_cd"]["3"] = "count";
        self::$fields["type_cd"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["type_cd"]["4"] = "expire_time";
        self::$fields["type_cd"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["type_cd"]["5"] = "start_time";
        self::$fields["type_cd"]["6"] = "PBBytes";
        $this->values["6"] = "";
        $this->values["6"] = new PBBytes();
        $this->values["6"]->value = "";
        self::$fieldNames["type_cd"]["6"] = "name";
    }
    function type()
    {
        return $this->_get_value("1");
    }
    function set_type($value)
    {
        return $this->_set_value("1", $value);
    }
    function accepter()
    {
        return $this->_get_value("2");
    }
    function set_accepter($value)
    {
        return $this->_set_value("2", $value);
    }
    function count()
    {
        return $this->_get_value("3");
    }
    function set_count($value)
    {
        return $this->_set_value("3", $value);
    }
    function expire_time()
    {
        return $this->_get_value("4");
    }
    function set_expire_time($value)
    {
        return $this->_set_value("4", $value);
    }
    function start_time()
    {
        return $this->_get_value("5");
    }
    function set_start_time($value)
    {
        return $this->_set_value("5", $value);
    }
    function name()
    {
        return $this->_get_value("6");
    }
    function set_name($value)
    {
        return $this->_set_value("6", $value);
    }
}
class db_kakao_cd_query_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_kakao_cd_query_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_kakao_cd_query_in"]["1"] = "zone_id";
        self::$fields["db_kakao_cd_query_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_kakao_cd_query_in"]["2"] = "type";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function type()
    {
        return $this->_get_value("2");
    }
    function set_type($value)
    {
        return $this->_set_value("2", $value);
    }
}
class db_kakao_cd_query_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_kakao_cd_query_out"]["1"] = "type_cd";
        $this->values["1"] = array();
        self::$fieldNames["db_kakao_cd_query_out"]["1"] = "cd";
    }
    function cd($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_cd()
    {
        return $this->_add_arr_value("1");
    }
    function set_cd($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_cds($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_cd()
    {
        $this->_remove_last_arr_value("1");
    }
    function cds_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_cds()
    {
        return $this->_get_value("1");
    }
}
class db_kakao_all_query_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_kakao_all_query_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_kakao_all_query_in"]["1"] = "zone_id";
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
class db_kakao_all_query_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_kakao_all_query_out"]["1"] = "type_cd";
        $this->values["1"] = array();
        self::$fieldNames["db_kakao_all_query_out"]["1"] = "cd";
    }
    function cd($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_cd()
    {
        return $this->_add_arr_value("1");
    }
    function set_cd($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_cds($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_cd()
    {
        $this->_remove_last_arr_value("1");
    }
    function cds_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_cds()
    {
        return $this->_get_value("1");
    }
}
class db_kakao_cd_add_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_kakao_cd_add_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_kakao_cd_add_in"]["1"] = "zone_id";
        self::$fields["db_kakao_cd_add_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_kakao_cd_add_in"]["2"] = "userid";
        self::$fields["db_kakao_cd_add_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_kakao_cd_add_in"]["3"] = "type";
        self::$fields["db_kakao_cd_add_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_kakao_cd_add_in"]["4"] = "accepter";
        self::$fields["db_kakao_cd_add_in"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["db_kakao_cd_add_in"]["6"] = "start_time";
        self::$fields["db_kakao_cd_add_in"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["db_kakao_cd_add_in"]["7"] = "expire_time";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function userid()
    {
        return $this->_get_value("2");
    }
    function set_userid($value)
    {
        return $this->_set_value("2", $value);
    }
    function type()
    {
        return $this->_get_value("3");
    }
    function set_type($value)
    {
        return $this->_set_value("3", $value);
    }
    function accepter()
    {
        return $this->_get_value("4");
    }
    function set_accepter($value)
    {
        return $this->_set_value("4", $value);
    }
    function start_time()
    {
        return $this->_get_value("6");
    }
    function set_start_time($value)
    {
        return $this->_set_value("6", $value);
    }
    function expire_time()
    {
        return $this->_get_value("7");
    }
    function set_expire_time($value)
    {
        return $this->_set_value("7", $value);
    }
}
class db_kakao_cd_dec_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_kakao_cd_dec_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_kakao_cd_dec_in"]["1"] = "zone_id";
        self::$fields["db_kakao_cd_dec_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_kakao_cd_dec_in"]["2"] = "userid";
        self::$fields["db_kakao_cd_dec_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_kakao_cd_dec_in"]["3"] = "type";
        self::$fields["db_kakao_cd_dec_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_kakao_cd_dec_in"]["4"] = "accepter";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function userid()
    {
        return $this->_get_value("2");
    }
    function set_userid($value)
    {
        return $this->_set_value("2", $value);
    }
    function type()
    {
        return $this->_get_value("3");
    }
    function set_type($value)
    {
        return $this->_set_value("3", $value);
    }
    function accepter()
    {
        return $this->_get_value("4");
    }
    function set_accepter($value)
    {
        return $this->_set_value("4", $value);
    }
}
class db_kakao_cd_mod_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_kakao_cd_mod_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_kakao_cd_mod_in"]["1"] = "zone_id";
        self::$fields["db_kakao_cd_mod_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_kakao_cd_mod_in"]["2"] = "userid";
        self::$fields["db_kakao_cd_mod_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_kakao_cd_mod_in"]["3"] = "type";
        self::$fields["db_kakao_cd_mod_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_kakao_cd_mod_in"]["4"] = "accepter";
        self::$fields["db_kakao_cd_mod_in"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_kakao_cd_mod_in"]["5"] = "count";
        self::$fields["db_kakao_cd_mod_in"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["db_kakao_cd_mod_in"]["6"] = "start_time";
        self::$fields["db_kakao_cd_mod_in"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["db_kakao_cd_mod_in"]["7"] = "expire_time";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function userid()
    {
        return $this->_get_value("2");
    }
    function set_userid($value)
    {
        return $this->_set_value("2", $value);
    }
    function type()
    {
        return $this->_get_value("3");
    }
    function set_type($value)
    {
        return $this->_set_value("3", $value);
    }
    function accepter()
    {
        return $this->_get_value("4");
    }
    function set_accepter($value)
    {
        return $this->_set_value("4", $value);
    }
    function count()
    {
        return $this->_get_value("5");
    }
    function set_count($value)
    {
        return $this->_set_value("5", $value);
    }
    function start_time()
    {
        return $this->_get_value("6");
    }
    function set_start_time($value)
    {
        return $this->_set_value("6", $value);
    }
    function expire_time()
    {
        return $this->_get_value("7");
    }
    function set_expire_time($value)
    {
        return $this->_set_value("7", $value);
    }
}
class db_kakao_cd_mod_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_kakao_cd_mod_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_kakao_cd_mod_out"]["1"] = "zone_id";
        self::$fields["db_kakao_cd_mod_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_kakao_cd_mod_out"]["2"] = "userid";
        self::$fields["db_kakao_cd_mod_out"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_kakao_cd_mod_out"]["3"] = "type";
        self::$fields["db_kakao_cd_mod_out"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_kakao_cd_mod_out"]["4"] = "accepter";
        self::$fields["db_kakao_cd_mod_out"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_kakao_cd_mod_out"]["5"] = "status";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function userid()
    {
        return $this->_get_value("2");
    }
    function set_userid($value)
    {
        return $this->_set_value("2", $value);
    }
    function type()
    {
        return $this->_get_value("3");
    }
    function set_type($value)
    {
        return $this->_set_value("3", $value);
    }
    function accepter()
    {
        return $this->_get_value("4");
    }
    function set_accepter($value)
    {
        return $this->_set_value("4", $value);
    }
    function status()
    {
        return $this->_get_value("5");
    }
    function set_status($value)
    {
        return $this->_set_value("5", $value);
    }
}
class db_get_role_id_by_gm_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_id_by_gm_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_role_id_by_gm_in"]["1"] = "zone_id";
        self::$fields["db_get_role_id_by_gm_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_get_role_id_by_gm_in"]["2"] = "global_id";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function global_id()
    {
        return $this->_get_value("2");
    }
    function set_global_id($value)
    {
        return $this->_set_value("2", $value);
    }
}
class db_get_role_id_by_gm_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_id_by_gm_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_role_id_by_gm_out"]["1"] = "user_id";
        self::$fields["db_get_role_id_by_gm_out"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_get_role_id_by_gm_out"]["2"] = "reg_tm";
        self::$fields["db_get_role_id_by_gm_out"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_get_role_id_by_gm_out"]["3"] = "zone_id";
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
}
class db_player_info_igg_t extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_player_info_igg_t"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_player_info_igg_t"]["1"] = "global_id";
        self::$fields["db_player_info_igg_t"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["db_player_info_igg_t"]["2"] = "name";
        self::$fields["db_player_info_igg_t"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_player_info_igg_t"]["3"] = "level";
        self::$fields["db_player_info_igg_t"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_player_info_igg_t"]["4"] = "exp";
        self::$fields["db_player_info_igg_t"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_player_info_igg_t"]["5"] = "diamond";
        self::$fields["db_player_info_igg_t"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["db_player_info_igg_t"]["6"] = "coin";
        self::$fields["db_player_info_igg_t"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["db_player_info_igg_t"]["7"] = "friend_num";
        self::$fields["db_player_info_igg_t"]["8"] = "PBInt";
        $this->values["8"] = "";
        self::$fieldNames["db_player_info_igg_t"]["8"] = "reg_tm";
        self::$fields["db_player_info_igg_t"]["9"] = "PBInt";
        $this->values["9"] = "";
        self::$fieldNames["db_player_info_igg_t"]["9"] = "last_login_tm";
    }
    function global_id()
    {
        return $this->_get_value("1");
    }
    function set_global_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function name()
    {
        return $this->_get_value("2");
    }
    function set_name($value)
    {
        return $this->_set_value("2", $value);
    }
    function level()
    {
        return $this->_get_value("3");
    }
    function set_level($value)
    {
        return $this->_set_value("3", $value);
    }
    function exp()
    {
        return $this->_get_value("4");
    }
    function set_exp($value)
    {
        return $this->_set_value("4", $value);
    }
    function diamond()
    {
        return $this->_get_value("5");
    }
    function set_diamond($value)
    {
        return $this->_set_value("5", $value);
    }
    function coin()
    {
        return $this->_get_value("6");
    }
    function set_coin($value)
    {
        return $this->_set_value("6", $value);
    }
    function friend_num()
    {
        return $this->_get_value("7");
    }
    function set_friend_num($value)
    {
        return $this->_set_value("7", $value);
    }
    function reg_tm()
    {
        return $this->_get_value("8");
    }
    function set_reg_tm($value)
    {
        return $this->_set_value("8", $value);
    }
    function last_login_tm()
    {
        return $this->_get_value("9");
    }
    function set_last_login_tm($value)
    {
        return $this->_set_value("9", $value);
    }
}
class db_get_role_list_by_igggm_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_list_by_igggm_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_role_list_by_igggm_in"]["1"] = "zone_id";
        self::$fields["db_get_role_list_by_igggm_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_get_role_list_by_igggm_in"]["2"] = "user_id";
        self::$fields["db_get_role_list_by_igggm_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_get_role_list_by_igggm_in"]["3"] = "channel_id";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function user_id()
    {
        return $this->_get_value("2");
    }
    function set_user_id($value)
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
class db_get_role_list_by_igggm_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_list_by_igggm_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_role_list_by_igggm_out"]["1"] = "zone_id";
        self::$fields["db_get_role_list_by_igggm_out"]["2"] = "db_player_info_igg_t";
        $this->values["2"] = array();
        self::$fieldNames["db_get_role_list_by_igggm_out"]["2"] = "roles";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function roles($offset)
    {
        return $this->_get_arr_value("2", $offset);
    }
    function add_roles()
    {
        return $this->_add_arr_value("2");
    }
    function set_roles($index, $value)
    {
        $this->_set_arr_value("2", $index, $value);
    }
    function set_all_roless($values)
    {
        return $this->_set_arr_values("2", $values);
    }
    function remove_last_roles()
    {
        $this->_remove_last_arr_value("2");
    }
    function roles_size()
    {
        return $this->_get_arr_size("2");
    }
    function get_roless()
    {
        return $this->_get_value("2");
    }
}

class db_sw_attribute_modify_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_sw_attribute_modify_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_sw_attribute_modify_in"]["1"] = "userid";
        self::$fields["db_sw_attribute_modify_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_sw_attribute_modify_in"]["2"] = "reg_tm";
        self::$fields["db_sw_attribute_modify_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_sw_attribute_modify_in"]["3"] = "zone_id";
        self::$fields["db_sw_attribute_modify_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        self::$fieldNames["db_sw_attribute_modify_in"]["4"] = "attribute_id";
        self::$fields["db_sw_attribute_modify_in"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_sw_attribute_modify_in"]["5"] = "attribute_value";
        self::$fields["db_sw_attribute_modify_in"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["db_sw_attribute_modify_in"]["6"] = "dead_tm";
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
}

class db_get_role_name_by_gm_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_name_by_gm_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_role_name_by_gm_in"]["1"] = "user_id";
        self::$fields["db_get_role_name_by_gm_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_get_role_name_by_gm_in"]["2"] = "reg_tm";
        self::$fields["db_get_role_name_by_gm_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_get_role_name_by_gm_in"]["3"] = "zone_id";
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
}
class db_get_role_name_by_gm_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_name_by_gm_out"]["1"] = "PBBytes";
        $this->values["1"] = "";
        self::$fieldNames["db_get_role_name_by_gm_out"]["1"] = "name";
    }
    function name()
    {
        return $this->_get_value("1");
    }
    function set_name($value)
    {
        return $this->_set_value("1", $value);
    }
}

class db_recruit_basic_info extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_recruit_basic_info"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_recruit_basic_info"]["1"] = "userid";
        self::$fields["db_recruit_basic_info"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_recruit_basic_info"]["2"] = "reg_tm";
        self::$fields["db_recruit_basic_info"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_recruit_basic_info"]["3"] = "zone_id";
        self::$fields["db_recruit_basic_info"]["4"] = "PBBytes";
        $this->values["4"] = "";
        self::$fieldNames["db_recruit_basic_info"]["4"] = "name";
        self::$fields["db_recruit_basic_info"]["5"] = "PBInt";
        $this->values["5"] = "";
        self::$fieldNames["db_recruit_basic_info"]["5"] = "lv";
        self::$fields["db_recruit_basic_info"]["6"] = "PBInt";
        $this->values["6"] = "";
        self::$fieldNames["db_recruit_basic_info"]["6"] = "type";
        self::$fields["db_recruit_basic_info"]["7"] = "PBInt";
        $this->values["7"] = "";
        self::$fieldNames["db_recruit_basic_info"]["7"] = "prestige";
        self::$fields["db_recruit_basic_info"]["8"] = "PBInt";
        $this->values["8"] = "";
        self::$fieldNames["db_recruit_basic_info"]["8"] = "pvai_rank";
        self::$fields["db_recruit_basic_info"]["9"] = "PBInt";
        $this->values["9"] = "";
        self::$fieldNames["db_recruit_basic_info"]["9"] = "add_tm";
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
    function name()
    {
        return $this->_get_value("4");
    }
    function set_name($value)
    {
        return $this->_set_value("4", $value);
    }
    function lv()
    {
        return $this->_get_value("5");
    }
    function set_lv($value)
    {
        return $this->_set_value("5", $value);
    }
    function type()
    {
        return $this->_get_value("6");
    }
    function set_type($value)
    {
        return $this->_set_value("6", $value);
    }
    function prestige()
    {
        return $this->_get_value("7");
    }
    function set_prestige($value)
    {
        return $this->_set_value("7", $value);
    }
    function pvai_rank()
    {
        return $this->_get_value("8");
    }
    function set_pvai_rank($value)
    {
        return $this->_set_value("8", $value);
    }
    function add_tm()
    {
        return $this->_get_value("9");
    }
    function set_add_tm($value)
    {
        return $this->_set_value("9", $value);
    }
}
class db_recruit_friend_query_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_recruit_friend_query_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        $this->values["1"] = new PBInt();
        $this->values["1"]->value = 0;
        self::$fieldNames["db_recruit_friend_query_in"]["1"] = "zone_id";
        self::$fields["db_recruit_friend_query_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        $this->values["2"] = new PBInt();
        $this->values["2"]->value = 0;
        self::$fieldNames["db_recruit_friend_query_in"]["2"] = "channel_id";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function channel_id()
    {
        return $this->_get_value("2");
    }
    function set_channel_id($value)
    {
        return $this->_set_value("2", $value);
    }
}

class db_recruit_friend_query_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_recruit_friend_query_out"]["1"] = "db_recruit_basic_info";
        $this->values["1"] = array();
        self::$fieldNames["db_recruit_friend_query_out"]["1"] = "friends";
    }
    function friends($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_friends()
    {
        return $this->_add_arr_value("1");
    }
    function set_friends($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_friendss($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_friends()
    {
        $this->_remove_last_arr_value("1");
    }
    function friends_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_friendss()
    {
        return $this->_get_value("1");
    }
}

class db_change_name_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_change_name_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_change_name_in"]["1"] = "zone_id";
        self::$fields["db_change_name_in"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["db_change_name_in"]["2"] = "name";
        self::$fields["db_change_name_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        $this->values["3"] = new PBInt();
        $this->values["3"]->value = 0;
        self::$fieldNames["db_change_name_in"]["3"] = "channel_id";
        self::$fields["db_change_name_in"]["4"] = "PBInt";
        $this->values["4"] = "";
        $this->values["4"] = new PBInt();
        $this->values["4"]->value = 0;
        self::$fieldNames["db_change_name_in"]["4"] = "reg_tm";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function name()
    {
        return $this->_get_value("2");
    }
    function set_name($value)
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
    function reg_tm()
    {
        return $this->_get_value("4");
    }
    function set_reg_tm($value)
    {
        return $this->_set_value("4", $value);
    }
}
class db_change_name_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_change_name_out"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_change_name_out"]["1"] = "ret";
        self::$fields["db_change_name_out"]["2"] = "PBBytes";
        $this->values["2"] = "";
        self::$fieldNames["db_change_name_out"]["2"] = "name";
    }
    function ret()
    {
        return $this->_get_value("1");
    }
    function set_ret($value)
    {
        return $this->_set_value("1", $value);
    }
    function name()
    {
        return $this->_get_value("2");
    }
    function set_name($value)
    {
        return $this->_set_value("2", $value);
    }
}
class db_get_role_list_by_kakaogm_in extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_list_by_kakaogm_in"]["1"] = "PBInt";
        $this->values["1"] = "";
        self::$fieldNames["db_get_role_list_by_kakaogm_in"]["1"] = "zone_id";
        self::$fields["db_get_role_list_by_kakaogm_in"]["2"] = "PBInt";
        $this->values["2"] = "";
        self::$fieldNames["db_get_role_list_by_kakaogm_in"]["2"] = "user_id";
        self::$fields["db_get_role_list_by_kakaogm_in"]["3"] = "PBInt";
        $this->values["3"] = "";
        self::$fieldNames["db_get_role_list_by_kakaogm_in"]["3"] = "channel_id";
    }
    function zone_id()
    {
        return $this->_get_value("1");
    }
    function set_zone_id($value)
    {
        return $this->_set_value("1", $value);
    }
    function user_id()
    {
        return $this->_get_value("2");
    }
    function set_user_id($value)
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
class db_get_role_list_by_kakaogm_out extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        self::$fields["db_get_role_list_by_kakaogm_out"]["1"] = "db_player_info_t";
        $this->values["1"] = array();
        self::$fieldNames["db_get_role_list_by_kakaogm_out"]["1"] = "roles";
    }
    function roles($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_roles()
    {
        return $this->_add_arr_value("1");
    }
    function set_roles($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function set_all_roless($values)
    {
        return $this->_set_arr_values("1", $values);
    }
    function remove_last_roles()
    {
        $this->_remove_last_arr_value("1");
    }
    function roles_size()
    {
        return $this->_get_arr_size("1");
    }
    function get_roles()
    {
        return $this->_get_value("1");
    }
}
?>