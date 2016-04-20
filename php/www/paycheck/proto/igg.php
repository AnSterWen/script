<?php
class pf_msg_head_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_msg_head_t"]["1"] = "PBString";
    $this->values["1"] = "";
    self::$fieldNames["pf_msg_head_t"]["1"] = "msg_type_name";
    self::$fields["pf_msg_head_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["pf_msg_head_t"]["2"] = "game_id";
    self::$fields["pf_msg_head_t"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["pf_msg_head_t"]["3"] = "channel_id";
    self::$fields["pf_msg_head_t"]["4"] = "PBInt";
    $this->values["4"] = "";
    self::$fieldNames["pf_msg_head_t"]["4"] = "ret";
    self::$fields["pf_msg_head_t"]["5"] = "PBInt";
    $this->values["5"] = "";
    self::$fieldNames["pf_msg_head_t"]["5"] = "seq";
    self::$fields["pf_msg_head_t"]["6"] = "PBString";
    $this->values["6"] = "";
    self::$fieldNames["pf_msg_head_t"]["6"] = "sign";
  }
  function msg_type_name()
  {
    return $this->_get_value("1");
  }
  function set_msg_type_name($value)
  {
    return $this->_set_value("1", $value);
  }
  function game_id()
  {
    return $this->_get_value("2");
  }
  function set_game_id($value)
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
  function ret()
  {
    return $this->_get_value("4");
  }
  function set_ret($value)
  {
    return $this->_set_value("4", $value);
  }
  function seq()
  {
    return $this->_get_value("5");
  }
  function set_seq($value)
  {
    return $this->_set_value("5", $value);
  }
  function sign()
  {
    return $this->_get_value("6");
  }
  function set_sign($value)
  {
    return $this->_set_value("6", $value);
  }
}
class pf_online_data_msg_in_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_online_data_msg_in_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_online_data_msg_in_t"]["1"] = "online_time";
  }
  function online_time()
  {
    return $this->_get_value("1");
  }
  function set_online_time($value)
  {
    return $this->_set_value("1", $value);
  }
}
class pf_online_data_msg_out_t_pf_online_data_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_online_data_msg_out_t_pf_online_data_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_online_data_msg_out_t_pf_online_data_t"]["1"] = "online_ip";
    self::$fields["pf_online_data_msg_out_t_pf_online_data_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["pf_online_data_msg_out_t_pf_online_data_t"]["2"] = "online_port";
    self::$fields["pf_online_data_msg_out_t_pf_online_data_t"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["pf_online_data_msg_out_t_pf_online_data_t"]["3"] = "online_time";
    self::$fields["pf_online_data_msg_out_t_pf_online_data_t"]["4"] = "PBInt";
    $this->values["4"] = "";
    self::$fieldNames["pf_online_data_msg_out_t_pf_online_data_t"]["4"] = "online_num";
  }
  function online_ip()
  {
    return $this->_get_value("1");
  }
  function set_online_ip($value)
  {
    return $this->_set_value("1", $value);
  }
  function online_port()
  {
    return $this->_get_value("2");
  }
  function set_online_port($value)
  {
    return $this->_set_value("2", $value);
  }
  function online_time()
  {
    return $this->_get_value("3");
  }
  function set_online_time($value)
  {
    return $this->_set_value("3", $value);
  }
  function online_num()
  {
    return $this->_get_value("4");
  }
  function set_online_num($value)
  {
    return $this->_set_value("4", $value);
  }
}
class pf_online_data_msg_out_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_online_data_msg_out_t"]["1"] = "pf_online_data_t";
    $this->values["1"] = array();
    self::$fieldNames["pf_online_data_msg_out_t"]["1"] = "online_data";
  }
  function online_data($offset)
  {
    return $this->_get_arr_value("1", $offset);
  }
  function add_online_data()
  {
    return $this->_add_arr_value("1");
  }
  function set_online_data($index, $value)
  {
    $this->_set_arr_value("1", $index, $value);
  }
  function set_all_online_datas($values)
  {
    return $this->_set_arr_values("1", $values);
  }
  function remove_last_online_data()
  {
    $this->_remove_last_arr_value("1");
  }
  function online_datas_size()
  {
    return $this->_get_arr_size("1");
  }
  function get_online_datas()
  {
    return $this->_get_value("1");
  }
}
class pf_user_base_info_msg_in_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_user_base_info_msg_in_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_user_base_info_msg_in_t"]["1"] = "user_id";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class pf_user_base_info_msg_out_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_user_base_info_msg_out_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_user_base_info_msg_out_t"]["1"] = "user_id";
    self::$fields["pf_user_base_info_msg_out_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["pf_user_base_info_msg_out_t"]["2"] = "user_level";
    self::$fields["pf_user_base_info_msg_out_t"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["pf_user_base_info_msg_out_t"]["3"] = "user_exp";
    self::$fields["pf_user_base_info_msg_out_t"]["4"] = "PBInt";
    $this->values["4"] = "";
    self::$fieldNames["pf_user_base_info_msg_out_t"]["4"] = "user_cash";
    self::$fields["pf_user_base_info_msg_out_t"]["5"] = "PBInt";
    $this->values["5"] = "";
    self::$fieldNames["pf_user_base_info_msg_out_t"]["5"] = "user_coin";
    self::$fields["pf_user_base_info_msg_out_t"]["6"] = "PBInt";
    $this->values["6"] = "";
    self::$fieldNames["pf_user_base_info_msg_out_t"]["6"] = "friend_num";
    self::$fields["pf_user_base_info_msg_out_t"]["7"] = "PBInt";
    $this->values["7"] = "";
    self::$fieldNames["pf_user_base_info_msg_out_t"]["7"] = "reg_time";
    self::$fields["pf_user_base_info_msg_out_t"]["8"] = "PBInt";
    $this->values["8"] = "";
    self::$fieldNames["pf_user_base_info_msg_out_t"]["8"] = "last_login_time";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function user_level()
  {
    return $this->_get_value("2");
  }
  function set_user_level($value)
  {
    return $this->_set_value("2", $value);
  }
  function user_exp()
  {
    return $this->_get_value("3");
  }
  function set_user_exp($value)
  {
    return $this->_set_value("3", $value);
  }
  function user_cash()
  {
    return $this->_get_value("4");
  }
  function set_user_cash($value)
  {
    return $this->_set_value("4", $value);
  }
  function user_coin()
  {
    return $this->_get_value("5");
  }
  function set_user_coin($value)
  {
    return $this->_set_value("5", $value);
  }
  function friend_num()
  {
    return $this->_get_value("6");
  }
  function set_friend_num($value)
  {
    return $this->_set_value("6", $value);
  }
  function reg_time()
  {
    return $this->_get_value("7");
  }
  function set_reg_time($value)
  {
    return $this->_set_value("7", $value);
  }
  function last_login_time()
  {
    return $this->_get_value("8");
  }
  function set_last_login_time($value)
  {
    return $this->_set_value("8", $value);
  }
}
class pf_user_attr_modify_msg_in_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_user_attr_modify_msg_in_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_user_attr_modify_msg_in_t"]["1"] = "user_id";
    self::$fields["pf_user_attr_modify_msg_in_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["pf_user_attr_modify_msg_in_t"]["2"] = "user_cash";
    self::$fields["pf_user_attr_modify_msg_in_t"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["pf_user_attr_modify_msg_in_t"]["3"] = "user_coin";
    self::$fields["pf_user_attr_modify_msg_in_t"]["4"] = "PBInt";
    $this->values["4"] = "";
    self::$fieldNames["pf_user_attr_modify_msg_in_t"]["4"] = "user_exp";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
  {
    return $this->_set_value("1", $value);
  }
  function user_cash()
  {
    return $this->_get_value("2");
  }
  function set_user_cash($value)
  {
    return $this->_set_value("2", $value);
  }
  function user_coin()
  {
    return $this->_get_value("3");
  }
  function set_user_coin($value)
  {
    return $this->_set_value("3", $value);
  }
  function user_exp()
  {
    return $this->_get_value("4");
  }
  function set_user_exp($value)
  {
    return $this->_set_value("4", $value);
  }
}
class pf_user_attr_modify_msg_out_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_user_attr_modify_msg_out_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_user_attr_modify_msg_out_t"]["1"] = "user_id";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class pf_user_bag_modify_msg_in_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_user_bag_modify_msg_in_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_user_bag_modify_msg_in_t"]["1"] = "user_id";
    self::$fields["pf_user_bag_modify_msg_in_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["pf_user_bag_modify_msg_in_t"]["2"] = "item_id";
    self::$fields["pf_user_bag_modify_msg_in_t"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["pf_user_bag_modify_msg_in_t"]["3"] = "item_count";
    self::$fields["pf_user_bag_modify_msg_in_t"]["4"] = "PBInt";
    $this->values["4"] = "";
    self::$fieldNames["pf_user_bag_modify_msg_in_t"]["4"] = "modify_type";
    self::$fields["pf_user_bag_modify_msg_in_t"]["5"] = "PBInt";
    $this->values["5"] = "";
    self::$fieldNames["pf_user_bag_modify_msg_in_t"]["5"] = "delete_type";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
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
  function item_count()
  {
    return $this->_get_value("3");
  }
  function set_item_count($value)
  {
    return $this->_set_value("3", $value);
  }
  function modify_type()
  {
    return $this->_get_value("4");
  }
  function set_modify_type($value)
  {
    return $this->_set_value("4", $value);
  }
  function delete_type()
  {
    return $this->_get_value("5");
  }
  function set_delete_type($value)
  {
    return $this->_set_value("5", $value);
  }
}
class pf_user_bag_modify_msg_out_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_user_bag_modify_msg_out_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_user_bag_modify_msg_out_t"]["1"] = "user_id";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class pf_forceout_msg_in_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_forceout_msg_in_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_forceout_msg_in_t"]["1"] = "user_id";
    self::$fields["pf_forceout_msg_in_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["pf_forceout_msg_in_t"]["2"] = "type";
    self::$fields["pf_forceout_msg_in_t"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["pf_forceout_msg_in_t"]["3"] = "code";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
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
  function code()
  {
    return $this->_get_value("3");
  }
  function set_code($value)
  {
    return $this->_set_value("3", $value);
  }
}
class pf_forceout_msg_out_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_forceout_msg_out_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_forceout_msg_out_t"]["1"] = "user_id";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class pf_stop_chat_in_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_stop_chat_in_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_stop_chat_in_t"]["1"] = "user_id";
    self::$fields["pf_stop_chat_in_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["pf_stop_chat_in_t"]["2"] = "type";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
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
class pf_stop_chat_out_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_stop_chat_out_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_stop_chat_out_t"]["1"] = "user_id";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class pf_disconn_in_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_disconn_in_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_disconn_in_t"]["1"] = "user_id";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class pf_disconn_out_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_disconn_out_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_disconn_out_t"]["1"] = "user_id";
  }
  function user_id()
  {
    return $this->_get_value("1");
  }
  function set_user_id($value)
  {
    return $this->_set_value("1", $value);
  }
}
class pf_bulletin_in_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_bulletin_in_t"]["1"] = "PBString";
    $this->values["1"] = "";
    self::$fieldNames["pf_bulletin_in_t"]["1"] = "content";
    self::$fields["pf_bulletin_in_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["pf_bulletin_in_t"]["2"] = "mixed";
  }
  function content()
  {
    return $this->_get_value("1");
  }
  function set_content($value)
  {
    return $this->_set_value("1", $value);
  }
  function mixed()
  {
    return $this->_get_value("2");
  }
  function set_mixed($value)
  {
    return $this->_set_value("2", $value);
  }
}
class pf_bulletin_out_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_bulletin_out_t"]["1"] = "PBString";
    $this->values["1"] = "";
    self::$fieldNames["pf_bulletin_out_t"]["1"] = "flag";
  }
  function flag()
  {
    return $this->_get_value("1");
  }
  function set_flag($value)
  {
    return $this->_set_value("1", $value);
  }
}
class pf_ack_errcode_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pf_ack_errcode_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["pf_ack_errcode_t"]["1"] = "errcode";
    self::$fields["pf_ack_errcode_t"]["2"] = "PBString";
    $this->values["2"] = "";
    $this->values["2"] = new PBString();
    $this->values["2"]->value = "default error";
    self::$fieldNames["pf_ack_errcode_t"]["2"] = "errmsg";
    self::$fields["pf_ack_errcode_t"]["3"] = "PBString";
    $this->values["3"] = "";
    $this->values["3"] = new PBString();
    $this->values["3"]->value = "Unknown";
    self::$fieldNames["pf_ack_errcode_t"]["3"] = "ori_msg_typename";
  }
  function errcode()
  {
    return $this->_get_value("1");
  }
  function set_errcode($value)
  {
    return $this->_set_value("1", $value);
  }
  function errmsg()
  {
    return $this->_get_value("2");
  }
  function set_errmsg($value)
  {
    return $this->_set_value("2", $value);
  }
  function ori_msg_typename()
  {
    return $this->_get_value("3");
  }
  function set_ori_msg_typename($value)
  {
    return $this->_set_value("3", $value);
  }
}
?>