<?php

class socket
{
	var $socket;

	//landry:to be removed
	//var $exit_msg = "后台繁忙!暂时无法为您服务!如果您一直看到此信息,请联系客服人员!谢谢!";

	function __construct($payserip,$payserport)
	{
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Unable to create socket\n");

		if(!@socket_connect($this->socket, $payserip, $payserport))
        {
			//todo:throw exception
			//show_exit_msg(1,'fail',$this->exit_msg);
		}
	}

	/**
	 *
	 * 发送并接收返回的数据,接收超时时间timeout = 10 s
	 */

	function sendmsg($msg)
    {
        $return = socket_write($this->socket,$msg, strlen($msg));
        //echo "return:".$return."\nstrlen:".strlen($msg);
		if($return != strlen($msg))
		{
		    return false;
		}

		$buf = socket_read($this->socket,4096,PHP_BINARY_READ);
		if($buf === false || strlen($buf) <= 0)
        {
            return false;
		}
		else
        {
            return $buf;
		}
	}

    /* 发送或接口大的协议 */
    /* $msg 发送的协议 */
    /* $pkg_len_size 包长字段的长度 */
    /* 返回接口的协议内容 */
    function send_big_msg($msg, $pkg_len_size)
    {
        if ($pkg_len_size == 0) {
            return false;
        }

        $want = strlen($msg);
        $write_len = 0;

        while ($write_len < $want)
        {
            $ret = socket_write($this->socket,
                    substr($msg, $write_len),
                    $want - $write_len);

            if ($ret === false)
            {
                return false;
            }

            $write_len += $ret;
        }

        $read_buf = '';
        $read_len = 0;
        $pkg_len = 0;

        while ($pkg_len == 0 || $read_len < $pkg_len)
        {
            $ret = socket_read($this->socket, 4096);

            if ($ret === false) {
                return false;
            }

            $read_buf .= $ret;
            $read_len += strlen($ret);

            /* 未获取到pkg_len */
            if ($pkg_len == 0 && $read_len >= $pkg_len_size) {
                $tmp = unpack('Lpkg_len', substr($read_buf, 0, $pkg_len_size));
                $pkg_len = $tmp['pkg_len'];
            }
        }

        return $read_buf;
    }

	/**
	 *
	 * 发送数据，没有返回数据
	 */

	function sendmsg_without_returnmsg($msg)
	{
		$result = socket_write($this->socket,$msg, strlen($msg) );
		if ($result)
		{
			return array("result" => 0);
		}
		else
		{
		    return array("result" => 1003);
		}
	}

	/**
	 *
	 * 针对摩尔卡系统的报文发送函数
	 *
	 * commandid + pkg_length(pkg_length 中不计算前面8个字节的长度 )
	 * @return	响应报文
	 * @access	public
	 * @see		??
	 */
	function mcard_sendmsg($msg)
	{
		socket_write($this->socket,$msg, strlen($msg));

		$buf = socket_read($this->socket,4096);
		$pkg_arr = @unpack("Lcommandid/Lproto_len",$buf);
		$proto_len = $pkg_arr["proto_len"];

		//设置接收超时
		socket_set_nonblock($this->socket);
		$time = time() ;

		while($proto_len!=(strlen($buf)- 8))
		{
			$buf .=	socket_read($this->socket,4096);

			if(time() - $time >= 10)
			{
				socket_close($this->socket) ;
				show_exit_msg(1,'fail',$this->exit_msg);
			}
			else
			{
				sleep(1) ;
				continue ;
			}
		}

		return $buf;
	}


	function close()
	{
		socket_close($this->socket);
	}

	function __destruct()
	{
	}
}
?>
