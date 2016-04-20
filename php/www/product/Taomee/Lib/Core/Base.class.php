<?php
/**
 * 基类
 * 
 * @category  class
 * @author    Rooney@taomee.com
 * @version   $ID
 * @copyright www.taomee.com 
 */

class Base 
{
    protected $property = array() ;
    
    /**
     * 构造函数
     *
     */
    function __construct() 
    {
        $this->property = array();    
    }
    
    /**
     * 当要取的属性不存在时，会自动调用该方法
     *
     * @param string $key
     * @return mixed 
     */
    function __get($key)
    {
        if(array_key_exists($key, $this->property)) {
            return $this->property[$key] ;
        }
        else {
            echo  'Not found proprety: ', $key, '<br />' ;
            return false ;
        }
    }
    
    /**
     * 当要设置的属性不存在时，会自动调用该方法
     *
     * @param string $key
     * @param string $val
     * @return bool 
     */
    function __set($key, $val)
    {
        if(array_key_exists($key, $this->property)){
            $this->property[$key] = $val ;
        }
        else {
            $this->property[$key] = $val ;            
        }
        return true ;
    }

    /**
     * 当要验证的属性不存在时，会自动调用该方法
     *
     * @param string $key
     * @return mixed 
     */
    function __isset($key)
    {
        return isset($this->property[$key]) ;
    }
    
    /**
     * 当要注销的属性不存在时，会自动调用该方法
     *
     * @param string $key
     * @return mixed 
     */
    function __unset($key)
    {    
        if(isset($this->property[$key])) {
            unset($this->property[$key]); 
            return true ;
        }
        else {
            return false ;
        }
    }    
    
}//类定义结束

?>