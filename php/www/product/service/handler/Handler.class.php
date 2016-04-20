<?php
require_once LIB_PATH . 'wdb_pdo.class.php';
require_once LIB_PATH . 'Log.class.php';
class Handler
{
    protected $wdb_pdo;
    function __construct()
    {
        WDB_PDO::set_error_handler_name('log_write');
    }
    
    public function __call($_name, $_args)
    {
        return array('result' => 2001);
    }
}
