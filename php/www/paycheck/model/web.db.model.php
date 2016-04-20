<?php
require_once (dirname(dirname(__FILE__)) . "/lib/functions.php");

class dbModel
{
    private $protobuf;
    private $header_name;

    public $ip;
    public $port;
    public $channel_id;

    public function __construct()
    {
        require_once (dirname(dirname(__FILE__)) . '/proto/protobuf_db.php');
        // $this->ip = '112.121.92.113';
        // $this->port = '50200';
        // $this->channel_id = '701';
    }

    /////////////////////////////////////////////Common Part/////////////////////////////////////////////
    function get_user_name($uid,$reg_tm,$zone_id){
        $protobuf=new Protobuf_db($this->ip,$this->port,'db');

        $header_name = 'db_msgheader_t';
        $header_param=array('db_get_role_name_by_gm',$uid,0);
        $body_name='db_get_role_name_by_gm_in';

        $body_param=array(
            'user_id' => $uid,
            'reg_tm' => $reg_tm,
            'zone_id'=>$zone_id
        );

        $online_ret = array(
            'name' => array('type'=>1),
        );
        $out = 'db_get_role_name_by_gm_out';
        $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);
        return $a_data;
    }


    function get_user_detail($uid){
        $protobuf = new Protobuf_db($this->ip,$this->port,'db');
        $header_name = 'db_msgheader_t';
        $header_param=array('db_get_role_id_by_gm','',0);
        $body_name='db_get_role_id_by_gm_in';

        $body_param=array(
            'global_id'=>$uid,
            'zone_id' => 0,
        );

        $online_ret = array(
            'user_id'=> array('type'=>1),
            'reg_tm'=> array('type'=>1),
            'zone_id'=> array('type'=>1),
        );
        $out = 'db_get_role_id_by_gm_out';
        $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);
        return $a_data;
    }

    public function get_user_by_nickname($nickname, $server_id)
    {
        $protobuf = new Protobuf_db($this->ip, $this->port, 'db');
        $header_name = 'db_msgheader_t';
        $header_param = array('db_query_id_by_name','',0);
        $req_body_name = 'db_query_id_by_name_in';

        $req_body_param=array(
            'name'      => $nickname,
            'zone_id'   => $server_id,
        );
        write_log("info", __FILE__, __FUNCTION__, __LINE__, "request body: ".json_encode($req_body_param));

        $rsp_body_param = array(
            'userid'=> array('type'=>1),
            'reg_tm'=> array('type'=>1),
        );
        $rsp_body_name = 'db_query_id_by_name_out';
        $return_array = $protobuf->send_msg($header_name, $header_param,
                                    $req_body_name, $req_body_param, $rsp_body_param, $rsp_body_name);
        return $return_array;
    }

    /////////////////////////////////////////////IGG Part/////////////////////////////////////////////
    function igg_get_user($uid,$zone_id)
    {
        $protobuf=new Protobuf_db($this->ip,$this->port,'db');

        $header_name = 'db_msgheader_t';
        $header_param=array('db_get_role_list_by_gm',$uid,0);
        $body_name='db_get_role_list_by_gm_in';

        $body_param=array('zone_id'=>$zone_id);

        $online_ret = array(
            'roles'=>array(
                'param'=>array('userid','reg_time','zone_id'),
                'type'=>2
            )
        );
        $out = 'db_get_role_list_by_gm_out';
        $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);
        return $a_data;
    }

    function igg_user_info($uid,$zone_id){
        $protobuf = new Protobuf_db($this->ip,$this->port,'db');
        $header_name = 'db_msgheader_t';
        $header_param=array('db_get_role_list_by_igggm',$uid,0);
        $body_name='db_get_role_list_by_igggm_in';

        $body_param=array(
            'zone_id' => $zone_id,
            'user_id' => $uid,
            'channel_id' => $this->channel_id
        );

        $online_ret = array(
            'roles'=>array(
                'param'=>array('global_id','name','level','exp','diamond','coin','friend_num','reg_tm','last_login_tm'),
                'type'=>2
            ),
            'zone_id' => array('type'=>1)
        );
        $out = 'db_get_role_list_by_igggm_out';
        $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);
        return $a_data;
    }

    function igg_add_coin_cash_exp($uid,$user,$type,$attribute_value){
        $protobuf = new Protobuf_db($this->ip,$this->port,'db');

        $header_name = 'db_msgheader_t';
        $header_param=array('db_sw_attribute_modify',$uid,0);
        $body_name='db_sw_attribute_modify_in';

        switch($type){
            case 'coin':
                $attribute_id = '416001';
                break;
            case 'cash':
                $attribute_id = '416002';
                break;
            case 'exp':
                $attribute_id = '416003';
                break;
            case 'prestige':
                $attribute_id = '416004';
                break;
            case 'soulstone':
                $attribute_id = '416018';
                break;
            case 'faessence':
                $attribute_id = '416019';
                break;
        }

        $body_param=array(
            'userid' => $user['user_id'],
            'reg_tm' => $user['reg_tm'],
            'zone_id' => $user['zone_id'],
            'attribute_id'=> $attribute_id,
            'attribute_value' => $attribute_value,
            'dead_tm' => '0',
        );

        $online_ret = array();
        $out = '';
        $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);
        return $a_data;
    }

}
