<?php
require_once("proto_base.php");

class card_pay_with_card_in {
	/* 渠道ID */
	#类型:uint16
	public $channel_id;

	/* 验证码（32位MD5 小写） */
	#定长数组,长度:32, 类型:char 
	public $verify_code ;

	/* 卡用途 */
	#类型:uint8
	public $card_usage;

	/* 交易号 */
	#类型:uint32
	public $low_buy_id;

	/*  */
	#类型:uint32
	public $high_buy_id;

	/* 卡号 */
	#类型:uint32
	public $card_id;

	/* MD5加密后的卡密码 */
	#定长数组,长度:32, 类型:char 
	public $password ;

	/* 消费数额（单位：分） */
	#类型:uint32
	public $consume_val;


	public function card_pay_with_card_in(){

	}

	public function read_from_buf($ba ){
		if (!$ba->read_uint16($this->channel_id)) return false;
		if(!$ba->read_buf($this->verify_code,32)) return false;
		if (!$ba->read_uint8($this->card_usage)) return false;
		if (!$ba->read_uint32($this->low_buy_id)) return false;
		if (!$ba->read_uint32($this->high_buy_id)) return false;
		if (!$ba->read_uint32($this->card_id)) return false;
		if(!$ba->read_buf($this->password,32)) return false;
		if (!$ba->read_uint32($this->consume_val)) return false;
		return true;
	}

	public function write_to_buf($ba ){
		if (!$ba->write_uint16($this->channel_id)) return false;
		$ba->write_buf($this->verify_code,32);
		if (!$ba->write_uint8($this->card_usage)) return false;
		if (!$ba->write_uint32($this->low_buy_id)) return false;
		if (!$ba->write_uint32($this->high_buy_id)) return false;
		if (!$ba->write_uint32($this->card_id)) return false;
		$ba->write_buf($this->password,32);
		if (!$ba->write_uint32($this->consume_val)) return false;
		return true;
	}

};

	
class card_pay_with_card_out {
	/* 消费网关交易号 */
	#类型:uint32
	public $consume_id;

	/* 卡内余额 */
	#类型:uint32
	public $balance;


	public function card_pay_with_card_out(){

	}

	public function read_from_buf($ba ){
		if (!$ba->read_uint32($this->consume_id)) return false;
		if (!$ba->read_uint32($this->balance)) return false;
		return true;
	}

	public function write_to_buf($ba ){
		if (!$ba->write_uint32($this->consume_id)) return false;
		if (!$ba->write_uint32($this->balance)) return false;
		return true;
	}

};

	
class fbmsg_t {
	/*  */
	#类型:uint32
	public $timestamp;

	/* 回复者的用户ID（0未知，1管理员） */
	#类型:uint32
	public $setuid;

	/*问题具体描述*/
	#变长数组,最大长度:2048, 类型:char
	public $msg ;


	public function fbmsg_t(){

	}

	public function read_from_buf($ba ){
		if (!$ba->read_uint32($this->timestamp)) return false;
		if (!$ba->read_uint32($this->setuid)) return false;

		$msg_count=0 ;
		if (!$ba->read_uint32( $msg_count )) return false;
		if ($msg_count>2048) return false;
		if(!$ba->read_buf($this->msg,$msg_count))return false;
		return true;
	}

	public function write_to_buf($ba ){
		if (!$ba->write_uint32($this->timestamp)) return false;
		if (!$ba->write_uint32($this->setuid)) return false;
		$msg_count=strlen($this->msg);
		if ($msg_count>2048 ) return false; 
		$ba->write_uint32($msg_count);
		$ba->write_buf($this->msg,$msg_count);
		return true;
	}

};

	
class fbuser_t {
	/* 反馈唯一标识 */
	#类型:uint32
	public $id;

	/*  */
	#类型:uint32
	public $timestamp;

	/* 主题 */
	#定长数组,长度:64, 类型:char 
	public $title ;

	/* 处理状态 */
	#类型:uint32
	public $state;

	/*问题具体描述*/
	#变长数组,最大长度:2048, 类型:char
	public $msg ;


	public function fbuser_t(){

	}

	public function read_from_buf($ba ){
		if (!$ba->read_uint32($this->id)) return false;
		if (!$ba->read_uint32($this->timestamp)) return false;
		if(!$ba->read_buf($this->title,64)) return false;
		if (!$ba->read_uint32($this->state)) return false;

		$msg_count=0 ;
		if (!$ba->read_uint32( $msg_count )) return false;
		if ($msg_count>2048) return false;
		if(!$ba->read_buf($this->msg,$msg_count))return false;
		return true;
	}

	public function write_to_buf($ba ){
		if (!$ba->write_uint32($this->id)) return false;
		if (!$ba->write_uint32($this->timestamp)) return false;
		$ba->write_buf($this->title,64);
		if (!$ba->write_uint32($this->state)) return false;
		$msg_count=strlen($this->msg);
		if ($msg_count>2048 ) return false; 
		$ba->write_uint32($msg_count);
		$ba->write_buf($this->msg,$msg_count);
		return true;
	}

};

	
class pic_t {
	/*  */
	#类型:uint32
	public $hostid;

	/* 截图url */
	#定长数组,长度:64, 类型:char 
	public $picurl ;


	public function pic_t(){

	}

	public function read_from_buf($ba ){
		if (!$ba->read_uint32($this->hostid)) return false;
		if(!$ba->read_buf($this->picurl,64)) return false;
		return true;
	}

	public function write_to_buf($ba ){
		if (!$ba->write_uint32($this->hostid)) return false;
		$ba->write_buf($this->picurl,64);
		return true;
	}

};

	
class qa_class_t {
	/*  */
	#类型:uint32
	public $clsid;

	/* 主题 */
	#定长数组,长度:64, 类型:char 
	public $title ;

	/* 展示类型 */
	#类型:uint32
	public $classtype;


	public function qa_class_t(){

	}

	public function read_from_buf($ba ){
		if (!$ba->read_uint32($this->clsid)) return false;
		if(!$ba->read_buf($this->title,64)) return false;
		if (!$ba->read_uint32($this->classtype)) return false;
		return true;
	}

	public function write_to_buf($ba ){
		if (!$ba->write_uint32($this->clsid)) return false;
		$ba->write_buf($this->title,64);
		if (!$ba->write_uint32($this->classtype)) return false;
		return true;
	}

};

	
class Cicomm_card_proto  extends Cproto_base {
    function __construct( $proxyip,$proxyport){
        parent::__construct($proxyip,$proxyport) ;
    }

	/*  */
	/* 调用方式还可以是： 
		$in=new card_pay_with_card_in();
		$in.xx1="xxxxx1";
		$in.xx2="xxxxx2";
		....
		$in.xx3="xxxxx3";
		$proto->card_pay_with_card($userid,$in );
	*/

	function card_pay_with_card($userid , $channel_id=null, $verify_code=null, $card_usage=null, $low_buy_id=null, $high_buy_id=null, $card_id=null, $password=null, $consume_val=null){

		if ( $channel_id instanceof card_pay_with_card_in ){
			$in=$channel_id;
		}else{
			$in=new card_pay_with_card_in();
			$in->channel_id=$channel_id;
			$in->verify_code=$verify_code;
			$in->card_usage=$card_usage;
			$in->low_buy_id=$low_buy_id;
			$in->high_buy_id=$high_buy_id;
			$in->card_id=$card_id;
			$in->password=$password;
			$in->consume_val=$consume_val;

		}
		
		return $this->send_cmd_new(18705,$userid, $in, new card_pay_with_card_out(), 0x0143e9ac);
	}
	
};
