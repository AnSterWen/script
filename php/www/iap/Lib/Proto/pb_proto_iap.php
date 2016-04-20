<?php
class sw_msg_head_t extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["sw_msg_head_t"]["1"] = "PBString";
    $this->values["1"] = "";
    self::$fieldNames["sw_msg_head_t"]["1"] = "msg_type_name";
    self::$fields["sw_msg_head_t"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["sw_msg_head_t"]["2"] = "uid";
    self::$fields["sw_msg_head_t"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["sw_msg_head_t"]["3"] = "role_tm";
    self::$fields["sw_msg_head_t"]["4"] = "PBInt";
    $this->values["4"] = "";
    self::$fieldNames["sw_msg_head_t"]["4"] = "ret";
    self::$fields["sw_msg_head_t"]["5"] = "PBString";
    $this->values["5"] = "";
    self::$fieldNames["sw_msg_head_t"]["5"] = "cli_waiting_msg";
    self::$fields["sw_msg_head_t"]["6"] = "PBInt";
    $this->values["6"] = "";
    $this->values["6"] = new PBInt();
    $this->values["6"]->value = 0;
    self::$fieldNames["sw_msg_head_t"]["6"] = "seqno";
  }
  function msg_type_name()
  {
    return $this->_get_value("1");
  }
  function set_msg_type_name($value)
  {
    return $this->_set_value("1", $value);
  }
  function uid()
  {
    return $this->_get_value("2");
  }
  function set_uid($value)
  {
    return $this->_set_value("2", $value);
  }
  function role_tm()
  {
    return $this->_get_value("3");
  }
  function set_role_tm($value)
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
  function cli_waiting_msg()
  {
    return $this->_get_value("5");
  }
  function set_cli_waiting_msg($value)
  {
    return $this->_set_value("5", $value);
  }
  function seqno()
  {
    return $this->_get_value("6");
  }
  function set_seqno($value)
  {
    return $this->_set_value("6", $value);
  }
}
class sw_tongbu_transaction_in extends PBMessage
{
  var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
  public function __construct($reader=null)
  {
    parent::__construct($reader);
    self::$fields["sw_tongbu_transaction_in"]["1"] = "PBInt";
    $this->values["1"] = "";
    self::$fieldNames["sw_tongbu_transaction_in"]["1"] = "svr_id";
    self::$fields["sw_tongbu_transaction_in"]["2"] = "PBInt";
    $this->values["2"] = "";
    self::$fieldNames["sw_tongbu_transaction_in"]["2"] = "userid";
    self::$fields["sw_tongbu_transaction_in"]["3"] = "PBInt";
    $this->values["3"] = "";
    self::$fieldNames["sw_tongbu_transaction_in"]["3"] = "role_tm";
    self::$fields["sw_tongbu_transaction_in"]["4"] = "PBInt";
    $this->values["4"] = "";
    self::$fieldNames["sw_tongbu_transaction_in"]["4"] = "good_id";
    self::$fields["sw_tongbu_transaction_in"]["5"] = "PBInt";
    $this->values["5"] = "";
    self::$fieldNames["sw_tongbu_transaction_in"]["5"] = "price";
  }
  function svr_id()
  {
    return $this->_get_value("1");
  }
  function set_svr_id($value)
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
  function role_tm()
  {
    return $this->_get_value("3");
  }
  function set_role_tm($value)
  {
    return $this->_set_value("3", $value);
  }
  function good_id()
  {
    return $this->_get_value("4");
  }
  function set_good_id($value)
  {
    return $this->_set_value("4", $value);
  }
  function price()
  {
    return $this->_get_value("5");
  }
  function set_price($value)
  {
    return $this->_set_value("5", $value);
  }
}
?>