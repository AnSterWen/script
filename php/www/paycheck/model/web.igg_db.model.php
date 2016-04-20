<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 14-6-17
 * Time: 下午5:48
 */

class igg_dbModel{
    private $protobuf;
    private $header_name;
    /*
     * 构造函数
     */
    public function __construct($server_id)
    {
        require_once (dirname(dirname(__FILE__)) . '/proto/protobuf_db.php');
        require_once (dirname(__FILE__) . "/../config/netmarble.config.php");

        global $server_list;

        if(isset($server_list[$server_id])){
            $this->ip = $server_list[$server_id]['ip'];
            $this->port = $server_list[$server_id]['port'];
        }else{
//            $this->ip = "10.10.80.1";
//            $this->port = "50200";
            $result_array['ERROR'] = $server_id." server db not exist!";
            die(json_encode($result_array));
        }
        $this->channel_id = '1010';
    }

    function get_kakao_user_info($user_id,$zone_id,$channel_id){

        $protobuf=new Protobuf_db($this->ip,$this->port,'db');

        $header_name = 'db_msgheader_t';
        $header_param=array('db_get_role_list_by_kakaogm',$user_id,0,0,0,0,0,$this->channel_id,0);
        $body_name='db_get_role_list_by_kakaogm_in';

        $body_param=array(
            'user_id' => $user_id,
            'zone_id'=> $zone_id,
            'channel_id' => $this->channel_id,
        );

        $return_fmt=array(
            'roles'=>array(
                'param'=>array('userid','reg_time','level','name','type','gender','zone_id','vip_lv'),
                'type'=>2
            )
        );
        $out = 'db_get_role_list_by_kakaogm_out';
        $a_data = $protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);

        return $a_data;

    }

    function invite_code($user_id,$zone_id){
        $protobuf=new Protobuf_db($this->ip,$this->port,'db');

        $header_name = 'db_msgheader_t';
        $header_param=array('db_recruit_friend_query',$user_id,0,0,0,0,0,$this->channel_id,0);
        $body_name='db_recruit_friend_query_in';

        $body_param=array(
            'zone_id'=> $zone_id,
            'channel_id' => $this->channel_id,
        );

        $invite_ret = array(
            'friends'=>array(
                'param'=>array('userid','add_tm','reg_tm'),
                'type'=>2
            )
        );
        $out = 'db_recruit_friend_query_out';
        $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$invite_ret,$out);
        return $a_data;
    }

    function change_name($user_info,$zone_id,$name){
        $protobuf=new Protobuf_db($this->ip,$this->port,'db');

        $header_name = 'db_msgheader_t';
        $header_param=array('db_change_name',$user_info['user_id'],0,$user_info['reg_tm'],0,0,0,$this->channel_id);
        $body_name='db_change_name_in';

        $body_param=array(
            'zone_id'=>$zone_id,
            'name' => $name,
            'channel_id' => $this->channel_id,
            'reg_tm' => $user_info['reg_tm']
        );

        $online_ret = array(
            'ret' => array('type'=>1),
            'name' => array('type'=>1),
        );
        $out = 'db_change_name_out';
        $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);
        return $a_data;
    }

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

    function igg_get_user_detail($uid){
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
