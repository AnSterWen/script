<?php

    class iggModel{
        private $protobuf;
        private $header_name;
        /*
         * 构造函数
         */
        public function __construct($server_id = null)
        {
            require_once (dirname(dirname(__FILE__)) . '/proto/ahero_mail_protobuf.php');
            global $g_proxy_conf;

            global $server_list_switch;

            if(isset($server_list_switch[$server_id])){
                $this->ip = $server_list_switch[$server_id]['ip'];
                $this->port = $server_list_switch[$server_id]['port'];
            }else{
//            $this->ip = "10.10.80.1";
//            $this->port = "50200";
                $result_array['ERROR'] = $server_id." server switch not exist!";
                die(json_encode($result_array));
            }

//            $this->ip = '10.100.25.75';
//            $this->port = '3001';
            $this->channel_id = '1010';
//            $this->ip = '10.1.1.155';
//            $this->port = '5013';
//            $this->channel_id = '93';
        }

        public function reg_server($protobuf) {
            //注册机器号
            $header_name = 'sw_msgheader_t';

            $body_name='reg_server_in';
            $header_param=array($body_name,1,1);
            //服务器ID
//            $server_id = rand(900000000,999999999);
            $server_id = '131';
            $body_param = array(
                'server_id'=>$server_id,
                'listen_port'=>8000
            );
            $return_fmt=array();
            $out = "";
//            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');
            $a_data = $protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);
            unset($header_param,$body_name,$body_param,$return_fmt,$a_data,$server_id,$out);
        }

        public function push_activity($zone_id,$title,$content,$from,$start_time,$end_time,$item_string){

            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');
            $this->reg_server($protobuf);
            $header_name = 'sw_msgheader_t';

            $body_name='sw_loginaward_limittime_in';
            $header_param=array($body_name,0,'');

            if($item_string == ""){
                $items = array();
            }else{
                $item_array = explode(",",$item_string);
                $items = array();
                foreach($item_array as $item){
                    if($item != ""){
                        $item_detail = explode('-',$item);
                        if(!empty($item_detail)){
                            $items[] = array('item_id'=>$item_detail[0],'item_num'=>$item_detail[1]);
                        }
                    }

                }
            }

            $body_param=array(
                'zone_id' => $zone_id,
                'title' => $title ,
                'from' => $from,
                'content' => $content,
                'award_begin' => $start_time,
                'award_end' => $end_time,
                'items' => $items,
                'mail_id' => $end_time + 3600*24,
            );
            $return_fmt=array('bSucc'=>array('type'=>1));
            $out = "sw_loginaward_limittime_out";

            $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);
            return $a_data;
        }

        public function setIOScontol($content){
            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');

            $this->reg_server($protobuf);
            $header_name = 'sw_msgheader_t';
            $header_param=array('sw_ma_vip_control_in',1,1);
            $body_name='sw_ma_vip_control_in';

            $body_param=array(
//                'zone_id'=> $zone_id,
                'content' => $content
            );

            $return_fmt=array( 'content'=>array('type'=>1));

            $out = 'sw_ma_vip_control_out';
            $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);
            return $a_data;
        }

        public function virtual_charge($user_info,$zone_id,$buy_diamond_num,$ext_diamond_num,$buy_time,$buy_channel_id,$cost_money,$order_index,$add_times,$consume_type){
            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');

            $this->reg_server($protobuf);

            $header_name = 'sw_msgheader_t';
            $header_param=array('sw_add_diamond_in',1,1);
            $body_name='sw_add_diamond_in';

            $body_param=array(
                'userid' => $user_info['user_id'],
                'reg_tm' => $user_info['reg_tm'],
                'channel_id' => $this->channel_id,
                'buy_diamond_num' => $buy_diamond_num,
                'ext_diamond_num' => $ext_diamond_num,
                'buy_time' => $buy_time,
                'buy_channel_id' => $buy_channel_id,
                'cost_money' => $cost_money,
                'order_index' => $order_index,
                'add_times' =>$add_times,
                'zone_id'=>$zone_id,
                'consume_type' =>$consume_type,
            );

            $return_fmt=array( 'order_index'=>array('type'=>1));

            $out = 'sw_add_diamond_out';
            $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);
            return $a_data;
        }

        function send_mail($user_info,$server_id,$title,$content,$from,$item_id,$item_number){

            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');
            $this->reg_server($protobuf);
            $header_name = 'sw_msgheader_t';

            $body_name='sw_add_new_mail_in';
            $header_param=array($body_name,0,'');

            if($item_id == ""){
                $items = array();
            }else{
                $goods_item = explode('-',$item_id);
                $goods_nums = explode('-',$item_number);

                $id = "item_id";
                $num = "item_num";

                foreach ($goods_item as $key=>$val) {
                    $tmp = array();
                    if ($val != '' && $goods_item[$key] != 0) {
                        $tmp[$id] = $goods_item[$key];
                        $tmp[$num]= $goods_nums[$key];
                        $items[] = $tmp;
                    }
                }
            }

            if(empty($user_info)){
                $body_param=array(
                    'server_id' => $server_id,
                    'title' => $title ,
                    'from' => $from,
                    'content' => $content,
                    'items' => $items,
                    'is_full_svc_mail' => true,
                    'mail_id' => time(),
                );
                $return_fmt=array( 'mail_id_high'=>array('type'=>1),
                    'mail_id_low'=>array('type'=>1),
                    'server_id' =>array('type'=>1));
                $out = "sw_add_new_mail_out";

                $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);

                return $a_data;
            }else{
                $body_param=array(
                    'server_id' => $server_id,
                    'title' => $title ,
                    'from' => $from,
                    'content' => $content,
                    'items' => $items,
                    'is_full_svc_mail' => false,
                    'mail_id' => time(),
                );
                $return_fmt=array( 'mail_id_high'=>array('type'=>1),
                    'mail_id_low'=>array('type'=>1),
                    'server_id' =>array('type'=>1));
                $out = "sw_add_new_mail_out";

                $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);

                unset($header_param,$body_name,$body_param,$return_fmt);

                $a_data = $a_data['data'];
                $mail_id_high = $a_data['mail_id_high'];
                $mail_id_low = $a_data['mail_id_low'];
                $server_id = $a_data['server_id'];

                $body_name = 'sw_add_new_mail_to_players_in';
                $header_param = array($body_name,0,'');

                $user['userid'] = $user_info['user_id'];
                $user['reg_time'] = $user_info['reg_tm'];
                $user['channel_id'] = $this->channel_id;
                $user_detail[] = $user;
                $body_param = array(
                    'mail_id_high' => $mail_id_high,
                    'mail_id_low' => $mail_id_low,
                    'server_id' => $server_id,
                    'players' => $user_detail,
                    'page_num' => '1'
                );

                $return_fmt=array( 'mail_id_high'=>array('type'=>1),
                    'mail_id_low'=>array('type'=>1),
                    'server_id' =>array('type'=>1),
                    'page_num' => array('type'=>1),
                );
                $out = "sw_add_new_mail_to_players_out";

                $a_data_final = $protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);

                unset($body_param,$return_fmt);
                return $a_data_final;
            }

        }

        function igg_query_online($zone_id,$online_ret)
        {
            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');

            $this->reg_server($protobuf);

            $header_name = 'sw_msgheader_t';
            $header_param=array('sw_get_server_status_in',1,1);
            $body_name='sw_get_server_status_in';

            $body_param=array('zone_id'=>$zone_id);

            $out = 'sw_get_server_status_out';
            $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);
            return $a_data;
        }

        function igg_add_item($add_item){
            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');

            $this->reg_server($protobuf);

            $header_name = 'sw_msgheader_t';
            $header_param=array('sw_user_bag_modify_in',1,1);
            $body_name='sw_user_bag_modify_in';
//
//            $body_param=array(
//                'user_id' => '30109084757110000',
//                'reg_tm' => '1402478675',
//                'zone_id' => '23000',
//                'item_id' => '415002',
//                'item_count' => '10',
//                'modify_type' => '1',
//                'delete_type' => '1',
//                'channel_id' => '701',
//            );
            $add_item['channel_id']  = $this->channel_id;
            $return_fmt=array('user_id'=>array('type'=>1));
//            $return_fmt = array();
            $out = 'sw_user_bag_modify_out';
            $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$add_item,$return_fmt,$out);
            return $a_data;
        }

        function igg_bulletin($zone_id,$content){
            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');

            $this->reg_server($protobuf);

            $header_name = 'sw_msgheader_t';
            $header_param=array('sw_announcement_in',1,1);
            $body_name='sw_announcement_in';

            $body_param=array(
                'zone_id' => $zone_id,
                'note' => $content
            );

            $return_fmt=array();
//            $return_fmt = array();
            $out = '';
            $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);
            return $a_data;
        }

        function igg_disconn($user_info,$time){
            $user_info['channel_id'] = $this->channel_id;
            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');

            $this->reg_server($protobuf);

            $header_name = 'sw_msgheader_t';
            $header_param=array('sw_freeze_player_in',1,1);
            $body_name='sw_freeze_player_in';

            $body_param=array(
                'info'      =>  array($user_info),
                'time'      =>  $time
            );

            $return_fmt=array();
//            $return_fmt = array();
            $out = '';
            $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$return_fmt,$out);
            return $a_data;
        }



        function igg_stop_chat($uid,$user,$value){

            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');

            $this->reg_server($protobuf);

            $header_name = 'sw_msgheader_t';
            $header_param=array('sw_set_attribute_in',1,1);
            $body_name='sw_set_attribute_in';

            $attribute_id = '4000001';

            $body_param=array(
                'userid' => $uid,
                'reg_tm' => $user['reg_tm'],
                'zone_id' => $user['zone_id'],
                'attribute_id'=> $attribute_id,
                'attribute_value' => $value,
                'dead_tm' => '0',
                'channel_id' => $this->channel_id
            );

            $online_ret = array();
            $out = '';
            $a_data1 = $protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);

            $attribute_id = '4000002';
            $body_param['attribute_id'] = $attribute_id;
            $a_data2 = $protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);
            return $a_data2;
        }

        function igg_add_coin_cash_exp($uid,$user,$type,$attribute_value){
            $protobuf=new AheroMailProtobuf($this->ip,$this->port,'switch');

            $this->reg_server($protobuf);

            $header_name = 'sw_msgheader_t';
            $header_param=array('sw_attribute_modify_in',1,1);
            $body_name='sw_attribute_modify_in';

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
                case 'vip_exp':
                    $attribute_id = '61';
                    break;
            }

            $body_param=array(
                'userid' => $uid,
                'reg_tm' => $user['reg_tm'],
                'zone_id' => $user['zone_id'],
                'attribute_id'=> $attribute_id,
                'attribute_value' => $attribute_value,
                'dead_tm' => '0',
                'channel_id' => $this->channel_id,
            );

            $online_ret = array();
            $out = '';
            $a_data=$protobuf->send_msg($header_name,$header_param,$body_name,$body_param,$online_ret,$out);
            return $a_data;
        }

    }


?>
