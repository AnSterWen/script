<?php
require_once("Log.class.php");


/**
 * MYSQL 操作类
 * @author tonyliu@taomee.com 
 */
class Mysql {   

    private $debug = false;     //true 打开数据库调试模式 false关闭数据库调试模式

    private $version = "";      

    private $log;

    private $link_id = NULL;

    /**
     * 构造函数
     **/
    public function __construct()
    {
        $this->log = new Log("db_");
    }

    /**
     * 连接数据库
     *
     * param  string  $dbhost       数据库主机名
     * param  string  $dbuser       数据库用户名
     * param  string  $dbpwd        数据库密码
     * param  string  $dbname       数据库名称
     * param  string  $dbcharset    数据库字符集
     * param  string  $pconnect     持久链接,1为开启,0为关闭
     * return bool
     **/
    public function connect($dbhost, $dbuser, $dbpwd, $dbname = '', $dbcharset = 'utf8', $pconnect = 0)
    {
        if ($pconnect) {
            if (! $this->link_id = mysql_pconnect ( $dbhost, $dbuser, $dbpwd )) {
                $this->ErrorMsg ();
                return false;
            }
        } else {
            if (! $this->link_id = mysql_connect ( $dbhost, $dbuser, $dbpwd, true )) {
                $this->ErrorMsg ();
                return false;
            }
        }
        $this->version = mysql_get_server_info ( $this->link_id );
        if ($this->getVersion () > '4.1') {
            if ($dbcharset) {
                mysql_query ( "SET character_set_connection=" . $dbcharset . 
                    ", character_set_results=" . $dbcharset . ", character_set_client=binary", $this->link_id );
            }

            if ($this->getVersion () > '5.0.1') {
                mysql_query ( "SET sql_mode=''", $this->link_id );
            }
        }
        if (mysql_select_db ( $dbname, $this->link_id ) === false) {
            $this->ErrorMsg ();
            return false;
        }

        return true;
    }

    /**
     * 插入数据
     *
     * @param string $table         表名
     * @param array $field_values   数据数组
     * @return id                   最后插入ID
     */
    public function insert($table, $field_values)
    {
        $fields = array ();
        $values = array ();
        $field_names = $this->getColumn('DESC '.$table);

        foreach ( $field_names as $value ) {
            if (array_key_exists ( $value, $field_values ) == true) {
                $fields [] = $value;
                $values [] = "'" . mysql_real_escape_string($field_values [$value], $this->link_id) . "'";
            }
        }
        if (!empty($fields)) {
            $sql = 'INSERT INTO '.$table.' ('.implode(',',$fields).') VALUES ('.implode ( ',',$values ).')';
            if($this->query ($sql)){
                return $this->getLastInsertId ();
            }
        }

        return false;
    }

    /**
     * 插入数据
     *
     * @param string $table         表名
     * @param array $insert_fields  待插入字段值
     * @param array $update_fields  插入失败待修改字段值
     * @return id                   最后插入ID
     */
    public function insert_update($table, $insert_fields, $update_fields)
    {
        $ifields = array ();
        $ivalues = array ();
        $a_update = array ();
        $field_names = $this->getColumn('DESC '.$table);

        foreach ( $field_names as $value ) {
            if (array_key_exists ( $value, $insert_fields ) == true) {
                $ifields [] = $value;
                $ivalues [] = "'" . mysql_real_escape_string($insert_fields[$value], $this->link_id) . "'";
            }
            if (array_key_exists ( $value, $update_fields ) == true) {
                $a_update[$value] = "'" . mysql_real_escape_string($update_fields[$value], $this->link_id) . "'";
            }
        }
        if (!empty($ifields)) {
            $sql = 'INSERT INTO '.$table.' ('.implode(',',$ifields).') VALUES ('.implode ( ',',$ivalues ).')';
            if (!empty($a_update)) {
                $sql .= " ON DUPLICATE KEY UPDATE ";
                foreach( $a_update as $key => $value ) {
                    $sql .= " {$key} = '{$value}',";
                }
                $sql = substr($sql, 0, -1);
            }
            if($this->query ($sql)){
                return $this->getLastInsertId ();
            }
        }

        return false;
    }

    /**
     * 插入数据
     *
     * @param string $table         表名
     * @param array $insert_fields  待插入字段值
     * @param array $update_sql     待修改的字段SQL
     * @return id                   最后插入ID
     */
    public function insert_sentence_update($table, $insert_fields, $update_sql)
    {
        $ifields = array ();
        $ivalues = array ();
        $field_names = $this->getColumn('DESC '.$table);

        foreach ( $field_names as $value ) {
            if (array_key_exists ( $value, $insert_fields ) == true) {
                $ifields [] = $value;
                $ivalues [] = "'" . mysql_real_escape_string($insert_fields[$value], $this->link_id) . "'";
            }
        }
        if (!empty($ifields)) {
            $sql = 'INSERT INTO '.$table.' ('.implode(',',$ifields).') VALUES ('.implode ( ',',$ivalues ).')';
            if (!empty($update_sql)) {
                $sql .= " ON DUPLICATE KEY UPDATE {$update_sql}";
            }
            if($this->query ($sql)){
                return $this->getLastInsertId ();
            }
        }

        return false;
    }

    /**
     * 获取最后插入数据的ID
     */
    public function getLastInsertId()
    {
        return mysql_insert_id ( $this->link_id );
    }


    /**
     * 更新数据
     *
     * @param string $table         要更新的表
     * @param array $field_values   要更新的数据，使用而为数据例:array('列表1'=>'数值1','列表2'=>'数值2')
     * @param string $where         更新条件
     * @return bool 
     */ 
    public function update($table, $field_values, $where = '')
    {
        $field_names = $this->getColumn ( 'DESC ' . $table );
        $sets = array ();
        foreach ( $field_names as $value ) {
            if (array_key_exists ( $value, $field_values ) == true) {
                $sets [] = $value . " = '" . mysql_real_escape_string($field_values [$value], $this->link_id) . "'";
            }
        }
        if (! empty ( $sets )) {
            $sql = 'UPDATE ' . $table . ' SET ' . implode ( ', ', $sets ) . ' WHERE ' . $where;
        }
        if ($sql) {
            return $this->query ( $sql );
        }

        return false;
    }


    /**
     * 删除数据
     *
     * @param string $table 要删除的表
     * @param string $where 删除条件，默认删除整个表
     * @return bool
     */ 
    public function delete($table, $where = '')
    {
        if(empty($where)) {
            $sql = 'DELETE FROM '.$table;
        } else {
            $sql = 'DELETE FROM '.$table.' WHERE '.$where;
        }
        if($this->query ( $sql )){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 获取数据列表
     *
     * @param string $sql   查询语句
     * @return array        二维数组
     */
    public function selectAll($sql)
    {
        $res = $this->query ( $sql );
        if ($res !== false) {
            $arr = array ();
            $row = mysql_fetch_assoc ( $res );
            while ($row) {
                $arr [] = $row;
                $row = mysql_fetch_assoc ( $res );
            }
            return $arr;
        } else {
            return false;
        }
    }


    /**
     * 获取数据列表
     *
     * @param string $sql   查询语句
     * @param int $numrows  返回个数
     * @param int $offset   指定偏移量
     * @return array        二维数组
     */
    public function selectLimit($sql, $numrows=-1, $offset=-1)
    {
        if ($numrows >= 0) {
            if($offset < 0){
                $sql .= ' LIMIT ' . $numrows;
            }else{
                $sql .= ' LIMIT ' . $offset . ', ' . $numrows;
            }
        }

        return $this->selectAll( $sql );
    }

    /**
     * 获取一条记录
     *
     * @param string $sql   查询语句
     * @return array        一维数组
     */ 
    public function selectOne($sql)
    {
        $res = $this->query ( $sql );
        if ($res !== false) {
            return mysql_fetch_assoc ( $res );
        } else {
            return false;
        }
    }

    /**
     * 返回查询记录数
     *
     * @param string $sql   查询语句
     * @return int
     */
    public function getRowsNum($sql)
    {
        $query = $this->query ( $sql );
        return mysql_num_rows ( $query );
    }

    /**
     * 返回查询的结果的第一个数据
     *
     * @return string
     */ 
    public function getOneField($sql)
    {
        $val = mysql_fetch_array($this->query ( $sql ));
        return $val[0];
    }

    /**
     * 获取列 
     *
     * @param string $sql
     * @return array
     */
    public function getColumn($sql)
    {
        $res = $this->query( $sql );
        if ($res !== false) {
            $arr = array ();
            $row = mysql_fetch_row ($res);
            while ($row) {
                $arr [] = $row [0];
                $row = mysql_fetch_row ($res);
            }
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * 发送一条 MySQL指令
     *
     * @param string $sql
     * @return bool
     */
    public function query($sql)
    {
        //$sql = str_replace('xxxx_db_', DB_PREFIX, $sql);//xxxx_db   sql语句中将xxxx_db替换成db_prefix
        if ($this->debug)
            echo "<pre><hr>\n" . $sql . "\n<hr></pre>";//如果设置成调试模式，将打印SQL语句
        if (! ($query = mysql_query ( $sql, $this->link_id ))) {
            $this->ErrorMsg ();
            return false;
        } else {
            return $query;
        }
    }

    /**
     * 获取数据库版本信息
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * 数据库调试
     */
    public function setDebug()
    {
        $this->debug = true;
    }

    /**
     * 数据库报错处理
     */
    public function ErrorMsg($message = '')
    {
        if (empty($message))
            $message = @mysql_error ();
        $this->log->error($message);
        exit ($message);
    }

    /**
     * 开始一个事务
     */
    public function begin()
    {
        mysql_query('begin', $this->link_id);
    }

    /**
     * 提交一个事务
     */
    public function commit()
    {
        mysql_query('commit', $this->link_id);
    }

    /**
     * 回滚一个事务
     */
    public function rollback()
    {
        mysql_query('rollback', $this->link_id);
    }

    /**
     * 关闭数据库连接（通常不需要，非持久连接会在脚本执行完毕后自动关闭）
     */
    public function close()
    {
        return mysql_close ( $this->link_id );
    }
}

?>
