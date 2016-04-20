<?php
class ssh2 {
  private $host = 'host';
  private $user = 'user';
  private $port = '22';
  private $password = 'password';
  private $con = null;
  private $log = '';
  function __construct($host='', $port=''  ) {
     if( $host!='' ) $this->host  = $host;
     if( $port!='' ) $this->port  = $port;
     $this->con  = ssh2_connect($this->host, $this->port);
     if( !$this->con ) {
       $this->log .= "Connection failed !";
     }

  }

  function authPassword( $user = '', $password = '' ) {

     if( $user!='' ) $this->user  = $user;
     if( $password!='' ) $this->password  = $password;
     if( !ssh2_auth_password( $this->con, $this->user, $this->password ) ) {
       $this->log .= "Authorization failed !";
     }

  }


  function cmdexec() {
    $argc = func_num_args();
    $argv = func_get_args();
    $cmd = '';
    for( $i=0; $i<$argc ; $i++) {
        if( $i != ($argc-1) ) {
          $cmd .= $argv[$i]." && ";
        }else{
          $cmd .= $argv[$i];
        }
    }
    echo $cmd;
    echo "\n";
    $stream = ssh2_exec( $this->con, $cmd );
    stream_set_blocking( $stream, true );
    $data = '';
    while($buf = fread($stream, 4096))
    {
        $data .= $buf;
    }
    return $data;
  }

  function getLog() {

     return $this->log;

  }

}
$ssh1 = new ssh2('10.1.16.31',22);
$ssh1 -> authPassword('root','123456');
$result = $ssh1 -> cmdexec('ifconfig eth0 && ls -l');
echo $result;
?>
