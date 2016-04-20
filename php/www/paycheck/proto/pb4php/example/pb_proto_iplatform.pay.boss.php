<?php
class ipay_err_code_t extends PBEnum
{
  const IPAY_ERR_NO_ERROR  = 0;
  const IPAY_ERR_SYS_BUSY  = 1001;
  const IPAY_ERR_INV_PKGLEN  = 1002;
  const IPAY_ERR_UNSUPPORTED_MSG  = 1003;
  const IPAY_ERR_NOT_ENOUGH_RES  = 1004;
  const IPAY_ERR_UNSUPPORTED_MSG_TYPE  = 1005;
  const IPAY_ERR_NOFOUND_SERVER  = 1006;
  const IPAY_ERR_INV_SIGN  = 1007;
  const IPAY_ERR_HAS_REGISTERED  = 2001;
  const IPAY_ERR_REG_TIMEOUT  = 2002;
  const IPAY_ERR_NO_MATCH_REG_FD  = 2003;
  const IPAY_ERR_NO_REG_GAME  = 3001;
  const IPAY_ERR_NO_SUCH_USER  = 4001;
  const IPAY_ERR_NO_SUCH_ORDER  = 4002;

  public function __construct($reader=null)
  {
   	parent::__construct($reader);
 	$this->names = array(
			0 => "IPAY_ERR_NO_ERROR",
			1001 => "IPAY_ERR_SYS_BUSY",
			1002 => "IPAY_ERR_INV_PKGLEN",
			1003 => "IPAY_ERR_UNSUPPORTED_MSG",
			1004 => "IPAY_ERR_NOT_ENOUGH_RES",
			1005 => "IPAY_ERR_UNSUPPORTED_MSG_TYPE",
			1006 => "IPAY_ERR_NOFOUND_SERVER",
			1007 => "IPAY_ERR_INV_SIGN",
			2001 => "IPAY_ERR_HAS_REGISTERED",
			2002 => "IPAY_ERR_REG_TIMEOUT",
			2003 => "IPAY_ERR_NO_MATCH_REG_FD",
			3001 => "IPAY_ERR_NO_REG_GAME",
			4001 => "IPAY_ERR_NO_SUCH_USER",
			4002 => "IPAY_ERR_NO_SUCH_ORDER");
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
    self::$fields["boss_pay_msg_in_t"]["2"] = "PBString";
    $this->values["2"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["2"] = "user_id";
    self::$fields["boss_pay_msg_in_t"]["3"] = "PBString";
    $this->values["3"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["3"] = "order_id";
    self::$fields["boss_pay_msg_in_t"]["4"] = "PBString";
    $this->values["4"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["4"] = "product_id";
    self::$fields["boss_pay_msg_in_t"]["5"] = "PBInt";
    $this->values["5"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["5"] = "amount";
    self::$fields["boss_pay_msg_in_t"]["6"] = "PBString";
    $this->values["6"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["6"] = "currency_kind";
    self::$fields["boss_pay_msg_in_t"]["7"] = "PBInt";
    $this->values["7"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["7"] = "user_time";
    self::$fields["boss_pay_msg_in_t"]["8"] = "PBString";
    $this->values["8"] = "";
    self::$fieldNames["boss_pay_msg_in_t"]["8"] = "ext_data";
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
  function order_id()
  {
    return $this->_get_value("3");
  }
  function set_order_id($value)
  {
    return $this->_set_value("3", $value);
  }
  function product_id()
  {
    return $this->_get_value("4");
  }
  function set_product_id($value)
  {
    return $this->_set_value("4", $value);
  }
  function amount()
  {
    return $this->_get_value("5");
  }
  function set_amount($value)
  {
    return $this->_set_value("5", $value);
  }
  function currency_kind()
  {
    return $this->_get_value("6");
  }
  function set_currency_kind($value)
  {
    return $this->_set_value("6", $value);
  }
  function user_time()
  {
    return $this->_get_value("7");
  }
  function set_user_time($value)
  {
    return $this->_set_value("7", $value);
  }
  function ext_data()
  {
    return $this->_get_value("8");
  }
  function set_ext_data($value)
  {
    return $this->_set_value("8", $value);
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
    self::$fields["boss_pay_msg_out_t"]["2"] = "PBString";
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
?>