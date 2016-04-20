<?php
require_once (dirname(dirname(__FILE__)) . '/proto/protobuf.php');
//require_once('proto/protobuf.php');
/**
 * @class Protobuf
 *
 **/
class AheroMailProtobuf extends Protobuf{
    function __construct($ip,$port,$proto_file_prefix) {
        parent::__construct($ip,$port,$proto_file_prefix);

    }
    public function pack_header($header_name,$header_param)
    {
        if(!is_array($header_param))
            die('pack_header function second param must be array');
        $this->header = null;
        $this->header_buf = null;
        unset($this->header,$this->header_buf);

        $this->header=new $header_name();
        $this->set_header_attr($header_param);
        $this->header_buf= $this->header->SerializeToString();
    }
    public function send_msg($header_name,$header_param,$body_name,$body_param,$body_fmt,$out)
    {
        $this->header_name=$header_name;
        $this->pack_header($header_name,$header_param);
        $this->pack_body($body_name,$body_param);
        $this->header_len= 4 + strlen($this->header_buf);//计算header_len
        $this->total_len= 4 + $this->header_len + strlen($this->body_buf);//计算total_len
        $buff=pack('N',$this->total_len) .pack('N',$this->header_len) .$this->header_buf . $this->body_buf;

        $send_len = socket_write($this->socket, $buff, strlen($buff));
        if ($send_len != strlen($buff)) {
            return array('result'=>-2);//写失败，没有完整写完
        }
        $this->return= socket_read($this->socket,8192);

        $a_return = null;
        $a_return=$this->unpack($this->return,$body_fmt,$out);

        $this->body = null;
        $this->header = null;
        $this->header_buf = null;
        $this->return_body = null;
        $this->body_buf = null;
        $send_len = null;
        $buff = null;
        $this->header_name = null;
        $this->pack_header = null;
        $this->pack_body = null;
        $this->header_len = null;
        $this->total_len = null;
        $this->return = null;
        unset($this->body,$this->header,$this->header_buf,$this->return_body,$this->body_buf,$send_len,$buff,$this->header_name,$this->pack_header,$this->pack_body,$this->header_len,$this->total_len,$this->return);

        return $a_return;
    }
    public function pack_body($body_name,$body_param)
    {
        if(!is_array($body_param))
            die('pack_body function second param must be array');
        if (!empty($body_param)) {
            $this->body = null;
            $this->body_buf = null;
            unset($this->body,$this->body_buf);

            $this->body=new $body_name();
            $this->set_attr($body_param);
            $this->body_buf= $this->body->SerializeToString();
            $body_name = null;
            $body_param = null;
            unset($body_name,$body_param);
        }
    }
    function set_attr($param)
    {
        foreach($param as $key=>$val)
        {
            $fun = null;
            $fun = 'set_' . $key;
            if (is_array($val)) {

                //后面嵌套多层
                $addFun = null;
                $addFun = "add_" . $key ;
                if (!method_exists($this->body,$addFun) && isset($val['pb_type'])) {
                    $setItems = null;
                    $setItems= $this->body->$fun(new $val['pb_type']());
                }
                foreach ($val as $key2=>$val2) {
                    if (method_exists($this->body,$addFun)) {
                        $addItems = null;
                        unset($addItems);
                        $addItems= $this->body->$addFun();
                        foreach ($val2 as $key3=>$val3) {
                            $addFun2 = null;
                            unset($addFun2);
                            $addFun2 = "add_" . $key3 ;
                            if (is_array($val3)) {
                                foreach ($val3 as $key4=>$val4) {
                                    $addItems2 = null;
                                    unset($addItems2);
                                    $addItems2 = $this->body->$key($key2)->$addFun2();
                                    foreach ($val4 as $key5=>$val5) {
                                        $setFun3 = null;
                                        unset($setFun3);
                                        $setFun3 = "set_" . $key5;
                                        $addItems2->$setFun3($val5);
                                    }
                                }
                            }else {
                                $setFun = null;
                                unset($setFun);
                                $setFun = "set_" . $key3;
                                $addItems->$setFun($val3);
                            }
                        }
                   }else {
                        if (is_array($val2)) {
                            foreach ($val2 as $key3=>$val3) {
                                $addFun2 = null;
                                $addFun2 = "add_" . $key2 ;
                                if (is_array($val3)) {
                                    $addItems3 = null;
                                    $addItems3 = $setItems->$addFun2();
                                    foreach ($val3 as $key4=>$val4) {
                                        $setFun2 = null;
                                        $setFun2 = "set_" . $key4;
                                        $addItems3->$setFun2($val4);
                                    }
                                }else {
                                    $setFun = null;
                                    $setFun = "set_" . $key3;
                                    $setItems->$setFun($val3);
                                }
                            }
                        }else {
                            $fun2 = null;
                            $fun2 = "set_" . $key2;
                            $this->body->$key()->$fun2($val2);
                        }
                    }
                }
                //print_r($this->body);
                //Log::write(print_r($this->body,true));
                //print_r($addItems);
            }else {
                $this->body->$fun($val);
            }
        }
        $param = null;$addItems=null;$addItems2=null;$addItems3=null;$addFun=null;$addFun2=null;$setFun2=null;$setFun3=null;$setFun=null;$setItems=null;$fun=null;$fun2=null;$setFun2=null;
        unset($param,$addItems,$addItems2,$addItems3,$addFun,$addFun2,$setFun2,$setFun3,$setFun,$setItems,$fun,$fun2,$setFun2);
        //print_r($this->body);
        //Log::write(print_r($this->body,true));
    }
    public function unpack($return,$body_fmt,$out)
    {
        if (empty($return)) {
            return array('result'=>0);
        }
        $return_header_len=unpack("Nlen",substr($return,4,8));
        $return_header_len=$return_header_len['len'];
        $this->header->parseFromString(substr($return,8,$return_header_len-4));
        $errcode=$this->header->ret();
        if($errcode == 0)
        {
            if ($out == '') {
                return array('result'=>0,'data'=>array());
            }else {
                $msg_name = $out;
                $this->return_body= new $msg_name();
                $this->return_body->parseFromString(substr($return,4+$return_header_len));

                //unset($return_header_len);
                $return_header_len=null;
                return array('result'=>0,'data'=>$this->unpack_body($body_fmt));
            }
        }else
        {
            return array('result'=>$errcode);
        }
    }
    function unpack_body($body_fmt)
    {
        if(!is_array($body_fmt))
        {
            die('return body formate not set');
        }
        $a_data=array();
        foreach($body_fmt as $key=>$val)
        {
            if($val['type'] == 1)//simple type
            {
                $a_data[$key]=$this->return_body->$key();
            }elseif($val['type'] == 2)
            {
                $fun=$key.'_size';
                $count=$this->return_body->$fun();
                //unset($fun);
                $fun=null;
                for($i=0;$i<$count;$i++)
                {
                    $a_data[$key][]=$this->get_attr($val['param'],$this->return_body->$key($i));
                }
            }
        }
        //unset($body_fmt);
        $body_fmt=null;
        return $a_data;
    }
    //给header类(统一包头)属性赋值
    function set_header_attr($header_param)
    {
        $this->header->set_msg_name($header_param[0]);
        $this->header->set_ret($header_param[1]);
        $this->header->set_gateway_session($header_param[2]);
    }
    function get_attr($param,$obj)
    {
        $return=array();
        foreach($param as $key=>$val)
        {
            $return[$val]=$obj->$val();
        }
        $param=null;
        $obj=null;
        return $return;
    }
}
