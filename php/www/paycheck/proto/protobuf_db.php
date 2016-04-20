<?php
//require_once('parser/pb_parser.php');
require_once(dirname(__FILE__). '/base.php');
//引入解析出来的PHP类
//require_once('message/pb_message.php');
/**
 * @class Protobuf
 *
 **/
class Protobuf_db extends protobuf_socket{
    private $header;
    private $header_buf;
    private $body;
    private $return_body;
    private $body_buf;
    private $total_len;
    private $header_len;
    private $return;
    private $header_name;
    function __construct($ip,$port,$proto_file_prefix) {
        parent::__construct($ip,$port);

        require_once(dirname(__FILE__) . '/pb_proto_ahero_' . $proto_file_prefix. '.php');
        require_once(dirname(__FILE__) . '/pb_proto_ahero_switch.php');
    }
    public function pack_header($header_name,$header_param)
    {
        if(!is_array($header_param))
            die('pack_header function second param must be array');
        $this->header=new $header_name();
        $this->set_header_attr($header_param);
        $this->header_buf= $this->header->SerializeToString();
    }
    public function pack_body($body_name,$body_param)
    {
        if(!is_array($body_param))
            die('pack_body function second param must be array');
        $this->body=new $body_name();
        $this->set_attr($body_param);
        $this->body_buf= $this->body->SerializeToString();
    }
    public function send_msg($header_name,$header_param,$body_name,$body_param,$body_fmt,$out)
    {
        $this->header_name=$header_name;
        $this->pack_header($header_name,$header_param);
        $this->pack_body($body_name,$body_param);
        $this->header_len= 4 + strlen($this->header_buf);//计算header_len
        $this->total_len= 4 + $this->header_len + strlen($this->body_buf);//计算total_len
        $buff=pack('N',$this->total_len) .pack('N',$this->header_len) .$this->header_buf . $this->body_buf;
        socket_write($this->socket, $buff, strlen($buff));
        $this->return= socket_read($this->socket,8192);
        $a_return=$this->unpack($this->return,$body_fmt,$out);
        return $a_return;
    }
    public function unpack($return,$body_fmt,$out)
    {
        $return_header_len=unpack("Nlen",substr($return,4,8));
        $return_header_len=$return_header_len['len'];
        $this->header->parseFromString(substr($return,8,$return_header_len-4));
        $errcode=$this->header->errcode();

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
                for($i=0;$i<$count;$i++)
                {
                    $a_data[$key][]=$this->get_attr($val['param'],$this->return_body->$key($i));
                }
            }
        }
        return $a_data;
    }
    //给header类(统一包头)属性赋值
    function set_header_attr($header_param)
    {
        $this->header->set_msg_name($header_param[0]);
        $this->header->set_target_uid($header_param[1]);
        $this->header->set_errcode($header_param[2]);
//        $this->header->set_reg_time($header_param[3]);
//        $this->header->set_msg_name($header_param[0]);
//        $this->header->set_target_uid($header_param[1]);
//        $this->header->set_errcode($header_param[2]);
//        $this->header->set_reg_time($header_param[3]);
//        $this->header->set_src_uid($header_param[4]);
//        $this->header->set_login_id($header_param[5]);
//        $this->header->set_aux($header_param[6]);
//        $this->header->set_trans_id($header_param[7]);
    }
    function set_attr($param)
    {
        foreach($param as $key=>$val)
        {
            if(!is_array($val))
            {
                $fun = 'set_'.$key;
                $this->body->$fun($val);
            }else
            {
                $add_fun='add_' .$key;
                $sub_class=$this->body->$add_fun();
                foreach($val as $key2=>$val2)
                {
                    $set_fun='set_' .$key2;
                    $sub_class->$set_fun($val2);
                }
            }
        }
    }
    function get_attr($param,$obj)
    {
        $return=array();
        foreach($param as $key=>$val)
        {
            $return[$val]=$obj->$val();
        }
        return $return;
    }
}
