<?php
class pay_msg_head_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["pay_msg_head_t"]["1"] = "PBString";
    $this->values["1"] = "";
    self::$fieldNames["pay_msg_head_t"]["1"] = "msg_type_name";
    self::$fields["pay_msg_head_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["pay_msg_head_t"]["2"] = "game_id";
    self::$fields["pay_msg_head_t"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["pay_msg_head_t"]["3"] = "channel_id";
    self::$fields["pay_msg_head_t"]["4"] = "PBInt";
    $this->values["4"] = "";
    self::$fieldNames["pay_msg_head_t"]["4"] = "ret";
    self::$fields["pay_msg_head_t"]["5"] = "PBInt";
    $this->values["5"] = "";
    self::$fieldNames["pay_msg_head_t"]["5"] = "seq";
    self::$fields["pay_msg_head_t"]["6"] = "PBInt";
    $this->values["6"] = "";
    self::$fieldNames["pay_msg_head_t"]["6"] = "connect_id";
    self::$fields["pay_msg_head_t"]["7"] = "PBString";
    $this->values["7"] = "";
    self::$fieldNames["pay_msg_head_t"]["7"] = "sign";
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
  function connect_id()
  {
    return $this->_get_value("6");
  }
  function set_connect_id($value)
  {
    return $this->_set_value("6", $value);
  }
  function sign()
  {
    return $this->_get_value("7");
  }
  function set_sign($value)
  {
    return $this->_set_value("7", $value);
  }
}
class boss_pay_msg_in_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["boss_pay_msg_in_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["1"] = "server_id";
    self::$fields["boss_pay_msg_in_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["2"] = "user_id";
    self::$fields["boss_pay_msg_in_t"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["3"] = "user_time";
    self::$fields["boss_pay_msg_in_t"]["4"] = "PBInt";
    $this->values["4"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["4"] = "third_user_id";
    self::$fields["boss_pay_msg_in_t"]["5"] = "PBString";
    $this->values["5"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["5"] = "order_id";
    self::$fields["boss_pay_msg_in_t"]["6"] = "PBInt";
    $this->values["6"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["6"] = "item_id";
    self::$fields["boss_pay_msg_in_t"]["7"] = "PBInt";
    $this->values["7"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["7"] = "item_count";
    self::$fields["boss_pay_msg_in_t"]["8"] = "PBInt";
    $this->values["8"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["8"] = "amount";
    self::$fields["boss_pay_msg_in_t"]["9"] = "PBInt";
    $this->values["9"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["9"] = "real_amount";
    self::$fields["boss_pay_msg_in_t"]["10"] = "PBString";
    $this->values["10"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["10"] = "currency_kind";
    self::$fields["boss_pay_msg_in_t"]["11"] = "PBInt";
    $this->values["11"] = "";
    $this->values["11"] = new PBInt();
    $this->values["11"]->value = 0;
    self::$fieldNames["boss_pay_msg_in_t"]["11"] = "gift_id";
    self::$fields["boss_pay_msg_in_t"]["12"] = "PBInt";
    $this->values["12"] = "";
    $this->values["12"] = new PBInt();
    $this->values["12"]->value = 0;
    self::$fieldNames["boss_pay_msg_in_t"]["12"] = "gift_count";
    self::$fields["boss_pay_msg_in_t"]["13"] = "PBInt";
    $this->values["13"] = "";
    $this->values["13"] = new PBInt();
    $this->values["13"]->value = 0;
    self::$fieldNames["boss_pay_msg_in_t"]["13"] = "consume_time";
    self::$fields["boss_pay_msg_in_t"]["14"] = "PBInt";
    $this->values["14"] = "";
    $this->values["14"] = new PBInt();
    $this->values["14"]->value = 0;
    self::$fieldNames["boss_pay_msg_in_t"]["14"] = "consume_ip";
    self::$fields["boss_pay_msg_in_t"]["15"] = "PBInt";
    $this->values["15"] = "";
    $this->values["15"] = new PBInt();
    $this->values["15"]->value = 0;
    self::$fieldNames["boss_pay_msg_in_t"]["15"] = "consume_type";
    self::$fields["boss_pay_msg_in_t"]["16"] = "PBString";
    $this->values["16"] = "";
    $this->values["16"] = new PBString();
    $this->values["16"]->value = "";
    self::$fieldNames["boss_pay_msg_in_t"]["16"] = "ext_data";
    self::$fields["boss_pay_msg_in_t"]["17"] = "PBInt";
    $this->values["17"] = "";
    $this->values["17"] = new PBInt();
    $this->values["17"]->value = 100;
    self::$fieldNames["boss_pay_msg_in_t"]["17"] = "product_add_times";
    self::$fields["boss_pay_msg_in_t"]["18"] = "PBInt";
    $this->values["18"] = "";
    $this->values["18"] = new PBInt();
    $this->values["18"]->value = 0;
    self::$fieldNames["boss_pay_msg_in_t"]["18"] = "product_attr_int";
    self::$fields["boss_pay_msg_in_t"]["19"] = "PBString";
    $this->values["19"] = "";
    $this->values["19"] = new PBString();
    $this->values["19"]->value = "";
    self::$fieldNames["boss_pay_msg_in_t"]["19"] = "product_attr_string";
  }
  function server_id()
  {
    return $this->_get_value("1");
  }
  function set_server_id($value)
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
  function user_time()
  {
    return $this->_get_value("3");
  }
  function set_user_time($value)
  {
    return $this->_set_value("3", $value);
  }
  function third_user_id()
  {
    return $this->_get_value("4");
  }
  function set_third_user_id($value)
  {
    return $this->_set_value("4", $value);
  }
  function order_id()
  {
    return $this->_get_value("5");
  }
  function set_order_id($value)
  {
    return $this->_set_value("5", $value);
  }
  function item_id()
  {
    return $this->_get_value("6");
  }
  function set_item_id($value)
  {
    return $this->_set_value("6", $value);
  }
  function item_count()
  {
    return $this->_get_value("7");
  }
  function set_item_count($value)
  {
    return $this->_set_value("7", $value);
  }
  function amount()
  {
    return $this->_get_value("8");
  }
  function set_amount($value)
  {
    return $this->_set_value("8", $value);
  }
  function real_amount()
  {
    return $this->_get_value("9");
  }
  function set_real_amount($value)
  {
    return $this->_set_value("9", $value);
  }
  function currency_kind()
  {
    return $this->_get_value("10");
  }
  function set_currency_kind($value)
  {
    return $this->_set_value("10", $value);
  }
  function gift_id()
  {
    return $this->_get_value("11");
  }
  function set_gift_id($value)
  {
    return $this->_set_value("11", $value);
  }
  function gift_count()
  {
    return $this->_get_value("12");
  }
  function set_gift_count($value)
  {
    return $this->_set_value("12", $value);
  }
  function consume_time()
  {
    return $this->_get_value("13");
  }
  function set_consume_time($value)
  {
    return $this->_set_value("13", $value);
  }
  function consume_ip()
  {
    return $this->_get_value("14");
  }
  function set_consume_ip($value)
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
  function ext_data()
  {
    return $this->_get_value("16");
  }
  function set_ext_data($value)
  {
    return $this->_set_value("16", $value);
  }
  function product_add_times()
  {
    return $this->_get_value("17");
  }
  function set_product_add_times($value)
  {
    return $this->_set_value("17", $value);
  }
  function product_attr_int()
  {
    return $this->_get_value("18");
  }
  function set_product_attr_int($value)
  {
    return $this->_set_value("18", $value);
  }
  function product_attr_string()
  {
    return $this->_get_value("19");
  }
  function set_product_attr_string($value)
  {
    return $this->_set_value("19", $value);
  }
}
class boss_pay_msg_out_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["boss_pay_msg_out_t"]["1"] = "PBString";
    $this->values["1"] = "";
    self::$fieldNames["boss_pay_msg_out_t"]["1"] = "order_id";
    self::$fields["boss_pay_msg_out_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["boss_pay_msg_out_t"]["2"] = "user_id";
  }
  function order_id()
  {
    return $this->_get_value("1");
  }
  function set_order_id($value)
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
}
class ack_errcode_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["ack_errcode_t"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["ack_errcode_t"]["1"] = "errcode";
    self::$fields["ack_errcode_t"]["2"] = "PBString";
    $this->values["2"] = "";
    $this->values["2"] = new PBString();
    $this->values["2"]->value = "default error";
    self::$fieldNames["ack_errcode_t"]["2"] = "errmsg";
    self::$fields["ack_errcode_t"]["3"] = "PBString";
    $this->values["3"] = "";
    $this->values["3"] = new PBString();
    $this->values["3"]->value = "Unknown";
    self::$fieldNames["ack_errcode_t"]["3"] = "ori_msg_typename";
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