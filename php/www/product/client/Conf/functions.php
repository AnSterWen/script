<?php

/*
 * 操作审计
 */
function audit($array)
{
    return false;
    $conn = mysql_connect(AUDIT_DB_HOST,AUDIT_DB_USER,AUDIT_DB_PWD);
    if (!$conn){
        Log::write('audit_db_con_error:'.mysql_error());
        return false;
    }else{
        $game  = $array['game'];
        $uid   = $array['uid'];
        $uname = $array['uname'];
        $ip    = $_SERVER['REMOTE_ADDR'];
        $item  = $array['item'];
        $desc  = $array['desc'];
        $sql   = "INSERT INTO ".AUDIT_DB_NAME.".t_item_audit (`game`,`uid`,`uname`,`ip`,`item`,`desc`) VALUES";
        $sql  .= "('$game','$uid','$uname','$ip','$item','$desc')";
        $ret   = mysql_query($sql);
        if(!$ret){
            Log::write('audit_db_insert_sql:'.$sql);
            Log::write('audit_db_insert_error:'.mysql_error());
            mysql_close($conn);
            return false;
        }else {
            mysql_close($conn);
            return true;
        }
    }
}

?>
