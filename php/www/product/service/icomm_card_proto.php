<?php
require_once("proto_base.php");

class item_t {
	/*  */
	#类型:uint32
	public $itemid;

	/*  */
	#类型:uint32
	public $count;


	public function item_t(){

	}

	public function read_from_buf($ba ){
		if (!$ba->read_uint32($this->itemid)) return false;
		if (!$ba->read_uint32($this->count)) return false;
		return true;
	}

	public function write_to_buf($ba ){
		if (!$ba->write_uint32($this->itemid)) return false;
		if (!$ba->write_uint32($this->count)) return false;
		return true;
	}

};

	
class iap_noti_online_item_in {
    /*  */
    #类型:uint32
    public $dest_user_id;

    /*  */
    #类型:uint32
    public $transaction_id_low;

    /*  */
    #类型:uint32
    public $transaction_id_high;

    /**/
    #变长数组,最大长度:10, 类型:item_t
    public $itemlist =array();


    public function iap_noti_online_item_in(){

    }


    public function read_from_buf($ba ){
        if (!$ba->read_uint32($this->dest_user_id)) return false;
        if (!$ba->read_uint32($this->transaction_id_low)) return false;
        if (!$ba->read_uint32($this->transaction_id_high)) return false;

        $itemlist_count=0 ;
        if (!$ba->read_uint32( $itemlist_count )) return false;
        if ($itemlist_count>10) return false;
        $this->itemlist=array();
        {for($i=0; $i<$itemlist_count;$i++){
            $this->itemlist[$i]=new item_t();
            if (!$this->itemlist[$i]->read_from_buf($ba)) return false;
        }}
        return true;
    }

    public function write_to_buf($ba ){
        if (!$ba->write_uint32($this->dest_user_id)) return false;
        if (!$ba->write_uint32($this->transaction_id_low)) return false;
        if (!$ba->write_uint32($this->transaction_id_high)) return false;
        $itemlist_count=count($this->itemlist);
        if ($itemlist_count>10 ) return false;
        $ba->write_uint32($itemlist_count);
        {for($i=0; $i<$itemlist_count;$i++){
            if ( ! $this->itemlist[$i] instanceof item_t ) return false;
            if (!$this->itemlist[$i]->write_to_buf($ba)) return false;
        }}
        return true;
    }
};

class Cicomm_card_proto  extends Cproto_base {
    function __construct( $proxyip,$proxyport){
        parent::__construct($proxyip,$proxyport) ;
    }

	/*  */
	/* 调用方式还可以是： 
		$in=new iap_noti_online_item_in();
		$in.xx1="xxxxx1";
		$in.xx2="xxxxx2";
		....
		$in.xx3="xxxxx3";
		$proto->iap_noti_online_item($userid,$in );
	*/

	function iap_noti_online_item($cmd, $userid , $dest_user_id=null, $transaction_id_low=null, $transaction_id_high=null, $itemlist=null){

	    if ( $dest_user_id instanceof iap_noti_online_item_in ){
            $in=$dest_user_id;
        }else{
            $in=new iap_noti_online_item_in();
            $in->dest_user_id=$dest_user_id;
            $in->transaction_id_low=$transaction_id_low;
            $in->transaction_id_high=$transaction_id_high;
            $in->itemlist=$itemlist;

        }	
		return $this->send_cmd_new($cmd,$userid, $in, null, 0x805f9f7a);
	}
	
};

?>
