<?php
class protobuf_socket{
    //private:
    var $socket; //socket 句柄
    //var $debug = 1;
    function __construct( $payserip,$payserport){
        if(empty($payserip))
        {
            trigger_error('ip cann`t empty');
        }
        if(empty($payserport))
        {
            trigger_error('port cann`t empty');
        }
        $address = gethostbyname($payserip );
        if (($this->socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP))< 0 )
        {
            trigger_error("Couldn't create socket: " . socket_strerror(socket_last_error()) . "\n");
        }
        $result = socket_connect($this->socket,$address,$payserport );

        if (false === $result) {
            trigger_error("connecting socket failuer: address:" . $address . ",payserport" . $payserport . "\n");
        }
        socket_set_option($this->socket,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>60, "usec"=>0 ) );
        socket_set_option($this->socket,SOL_SOCKET,SO_SNDTIMEO,array("sec"=>60, "usec"=>0 ) );
        #socket_connect socketfd, SOL_SOCKET, SO_RCVTIMEO,

    }

    function sendmsg($msg){
        //$this->log_msg($msg);
        socket_write($this->socket,$msg, strlen($msg) );
        $buf= socket_read($this->socket,8192);
        $pkg_arr=@unpack("Lproto_len",$buf);
        $proto_len= $pkg_arr["proto_len"];
        #echo $proto_len;
        while ($proto_len!=strlen($buf) ){
            $buf .=	socket_read($this->socket,4096);
        }
        return $buf;
    }
    function close(){
        socket_close($this->socket);
    }
}
class Cproto{
    var $sock;
    function __construct( $payserip,$payserport){
        $this->sock = new protobuf_socket ($payserip,$payserport);
    }
    function __destruct(){
        if ($this->sock) $this->sock->close();
    }

    function park($cmdid,$userid,$private_msg){
        return $this->pack($cmdid,$userid,$private_msg);
    }
    function pack($cmdid,$userid,$private_msg){
        global $_SESSION;
        //18：报文头部长度
        $pkg_len=18+strlen($private_msg) ;
        $result=0;
        $proto_id=$this->adminid;
        if ($proto_id==0){
            $proto_id=$_SESSION["adminid" ];
        }
        //echo $pkg_len."<br>".$proto_id."<br>".$cmdid."<br>".hexdec($cmdid)."<br>".$userid;
        return pack("L2SL2",$pkg_len,$proto_id,hexdec($cmdid),$result,$userid)
        .$private_msg;
    }

    function unpark($sockpkg, $private_fmt=""){
        return $this->unpack($sockpkg, $private_fmt );
    }

    function unpack($sockpkg, $private_fmt=""){
        //echo bin2hex($sockpkg);
        $pkg_arr=@unpack("Lproto_len/Lproto_id/Scommandid/Lresult/Luserid",$sockpkg);
        //$tmp_len=$pkg_arr["proto_len"];
        if ($private_fmt!="" && $pkg_arr["result"]==0){//成功
            $pkg_arr=@unpack("Lproto_len/Lproto_id/Scommandid/Lresult/Luserid/".$private_fmt,
                $sockpkg);
        }
        if ($pkg_arr){
            return $pkg_arr;
        }else{
            return array("result"=>1010);
        }
    }

    function send_cmd($cmdid ,$userid, $pri_msg , $out_msg ){
        $sendbuf=$this->pack( $cmdid , $userid,  $pri_msg);
        return $this->unpack($this->sock->sendmsg($sendbuf),$out_msg );
    }

};


?>
