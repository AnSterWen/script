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
    self::$fields["db_player_info_t"]["14"] = "PBInt";
    $this->values["14"] = "";
    self::$fieldNames["db_player_info_t"]["14"] = "last_login_tm";
    self::$fields["db_player_info_t"]["15"] = "PBInt";
    $this->values["15"] = "";
    self::$fieldNames["db_player_info_t"]["15"] = "acc_consume";
    self::$fields["db_player_info_t"]["16"] = "PBBool";
    $this->values["16"] = "";
    self::$fieldNames["db_player_info_t"]["16"] = "gm";
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
  function last_login_tm()
  {
    return $this->_get_value("14");
  }
  function set_last_login_tm($value)
  {
    return $this->_set_value("14", $value);
  }
  function acc_consume()
  {
    return $this->_get_value("15");
  }
  function set_acc_consume($value)
  {
    return $this->_set_value("15", $value);
  }
  function gm()
  {
    return $this->_get_value("16");
  }
  function set_gm($value)
  {
    return $this->_set_value("16", $value);
  }
}
class db_get_role_list_in extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["db_get_role_list_in"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["db_get_role_list_in"]["1"] = "zone_id";
    self::$fields["db_get_role_list_in"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["db_get_role_list_in"]["2"] = "userid";
    self::$fields["db_get_role_list_in"]["3"] = "PBInt";
    $this->values["3"] = "";
    $this->values["3"] = new PBInt();
    $this->values["3"]->value = 0;
    self::$fieldNames["db_get_role_list_in"]["3"] = "check_freeze";
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
  function check_freeze()
  {
    return $this->_get_value("3");
  }
  function set_check_freeze($value)
  {
    return $this->_set_value("3", $value);
  }
}
class db_get_role_list_out extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["db_get_role_list_out"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["db_get_role_list_out"]["1"] = "zone_id";
    self::$fields["db_get_role_list_out"]["2"] = "db_player_info_t";
    $this->values["2"] = array();
    self::$fieldNames["db_get_role_list_out"]["2"] = "roles";
    self::$fields["db_get_role_list_out"]["3"] = "PBInt";
    $this->values["3"] = "";
    $this->values["3"] = new PBInt();
    $this->values["3"]->value = 0;
    self::$fieldNames["db_get_role_list_out"]["3"] = "freeze_status";
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
  function freeze_status()
  {
    return $this->_get_value("3");
  }
  function set_freeze_status($value)
  {
    return $this->_set_value("3", $value);
  }
}
class db_role_exist_by_gm_in extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["db_role_exist_by_gm_in"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["db_role_exist_by_gm_in"]["1"] = "user_id";
    self::$fields["db_role_exist_by_gm_in"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["db_role_exist_by_gm_in"]["2"] = "reg_tm";
    self::$fields["db_role_exist_by_gm_in"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["db_role_exist_by_gm_in"]["3"] = "zone_id";
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
class db_role_exist_by_gm_out extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["db_role_exist_by_gm_out"]["1"] = "PBBool";
    $this->values["1"] = "";
    $this->values["1"] = new PBBool();
    $this->values["1"]->value = false;
    self::$fieldNames["db_role_exist_by_gm_out"]["1"] = "is_exist";
  }
  function is_exist()
  {
    return $this->_get_value("1");
  }
  function set_is_exist($value)
  {
    return $this->_set_value("1", $value);
  }
}
?>