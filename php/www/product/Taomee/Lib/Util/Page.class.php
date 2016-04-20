<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2008 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

/**
 +------------------------------------------------------------------------------
 * 分页显示类
 +------------------------------------------------------------------------------
 * @category   ORG
 * @package  ORG
 * @subpackage  Util
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 * @example   $page = new Page(100, 10) ; echo $page->show() ;
 +------------------------------------------------------------------------------
 */
class Page extends Base
{ //类定义开始
    
    /**
     +----------------------------------------------------------
     * 分页起始行数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $first_row;
    
    /**
     +----------------------------------------------------------
     * 列表每页显示行数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $list_rows;
    
    /**
     +----------------------------------------------------------
     * 页数跳转时要带的参数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $parameter;
    
    /**
     +----------------------------------------------------------
     * 分页总页面数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $total_pages;
    
    /**
     +----------------------------------------------------------
     * 总行数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $total_rows;
    
    /**
     +----------------------------------------------------------
     * 当前页数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $now_page;
    
    /**
     +----------------------------------------------------------
     * 分页的栏的总页数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $cool_pages;
    
    /**
     +----------------------------------------------------------
     * 分页栏每页显示的页数
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    protected $roll_page;
    
    /**
     +----------------------------------------------------------
     * 分页记录名称
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
    
    // 分页显示定制
    protected $config = array(
        'header' => '条记录', 'prev' => '上一页', 'next' => '下一页', 'first' => '第一页', 'last' => '最后一页' 
    );

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param int $total_rows  总的记录数
     * @param int $now_page  要的显示的页码
     * @param int $list_rows  每页显示记录数
     * @param string $parameter  分页跳转的参数
     * @return string html
     +----------------------------------------------------------
     */
    public function __construct($total_rows, $now_page=1, $list_rows = '10', $parameter = '')
    {
        $this->total_rows  = $total_rows;
        $this->parameter   = $parameter;
        $this->roll_page   = 5;
        $this->list_rows   = $list_rows;
        $this->total_pages = ceil($this->total_rows / $this->list_rows); //总页数
        $this->cool_pages  = ceil($this->total_pages / $this->roll_page);
        $this->now_page    = !empty($now_page) && ($now_page > 0) ? 
                                ($now_page > $this->total_pages ?  
                                    $this->total_pages : $now_page) : 1;
        
        if (! empty($this->total_pages) && $this->now_page > $this->total_pages) {
            $this->now_page = $this->total_pages;
        }
        $this->first_row = $this->list_rows * ($this->now_page - 1);
    }

    public function set_config($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     +----------------------------------------------------------
     * 分页显示
     * 用于在页面显示的分页栏的输出
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function show($is_array = false)
    {
        
        if (0 == $this->total_rows)
            return;
        $now_cool_page = ceil($this->now_page / $this->roll_page);
        //$url = $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') ? '' : "?") . $this->parameter;
        $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] .'?'. $this->parameter;
        
        //上下翻页字符串
        $up_row = $this->now_page - 1;
        $down_row = $this->now_page + 1;
        if ($up_row > 0) {
            $up_page = "[<a href='" . $url . "&page=$up_row'>" . $this->config['prev'] . "</a>]";
        }
        else {
            $up_page = "";
        }
        
        if ($down_row <= $this->total_pages) {
            $down_page = "[<a href='" . $url . "&page=$down_row'>" . $this->config['next'] . "</a>]";
        }
        else {
            $down_page = "";
        }
        
        // << < > >>
        if ($now_cool_page == 1) {
            $theFirst = "";
            $pre_page = "";
        }
        else {
            $pre_row = $this->now_page - $this->roll_page;
            $pre_page = "[<a href='" . $url . "&page=$pre_row' >上" . $this->roll_page . "页</a>]";
            $theFirst = "[<a href='" . $url . "&page=1' >" . $this->config['first'] . "</a>]";
        }
        
        if ($now_cool_page == $this->cool_pages) {
            $next_page = "";
            $the_end = "";
        }
        else {
            $next_row = $this->now_page + $this->roll_page;
            $the_end_row = $this->total_pages;
            $next_page = "[<a href='" . $url . "&page=$next_row' >下" . $this->roll_page . "页</a>]";
            $the_end = "[<a href='" . $url . "&page=$the_end_row' >" . $this->config['last'] . "</a>]";
        }
        
        // 1 2 3 4 5
        $link_page = "";
        for($i = 1; $i <= $this->roll_page; $i ++) {
            $page = ($now_cool_page - 1) * $this->roll_page + $i;
            if ($page != $this->now_page) {
                if ($page <= $this->total_pages) {
                    $link_page .= "&nbsp;<a href='" . $url . "&page=$page'>&nbsp;" . $page . "&nbsp;</a>";
                }
                else {
                    break;
                }
            }
            else {
                if ($this->total_pages != 1) {
                    $link_page .= " [" . $page . "]";
                }
            }
        }
        
        $page_str = '共' . $this->total_rows . ' ' . $this->config['header'] . '/' . $this->total_pages . '页 ' . $up_page . ' ' . $down_page . ' ' . $theFirst . ' ' . $pre_page . ' ' . $link_page . ' ' . $next_page . ' ' . $the_end;
        
        if ($is_array) {
            $page_array['total_rows'] = $this->total_rows;
            $page_array['up_page'] = $url . "&page=$up_row";
            $page_array['down_page'] = $url . "&page=$down_row";
            $page_array['total_pages'] = $this->total_pages;
            $page_array['first_page'] = $url . "&page=1";
            $page_array['end_page'] = $url . "&page=$the_end_row";
            $page_array['next_pages'] = $url . "&page=$next_row";
            $page_array['pre_pages'] = $url . "&page=$pre_row";
            $page_array['link_pages'] = $link_page;
            $page_array['now_page'] = $this->now_page;
            return $page_array;
        }
        return $page_str;
    }
    
    /**
     * 跳转到第几页
     *
     * @param string $method  form method get or post .
     * @return string
     */
	public  function goto_page($method="get")
    {
    	$url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] .'?'. $this->parameter;
    	
    	if(false !== strpos($this->parameter, '&')) {    	
	    	$temp = explode('&', $this->parameter) ;
	    	$hidden = '' ;
	    	foreach ($temp as $val) {
	    		if(!trim($val))  continue ;
	    		$pos = strpos($val, '=') ;
	    		$hidden .=  (false === strpos($val, '=')) ? '' : '<input type="hidden" name="'.substr($val, 0, $pos).'" value="'.substr($val, $pos + 1).'" />' ;
	    	}
    	}

    	$str = '<form name="frm_page_goto" id="frm_page_goto" method="'.$method.'" action="'.$url.'">' ;
    	$str.= '第&nbsp;<input type="text" name="page" id="page_goto" value="" style="width:30px" />&nbsp;页' ;
    	$str.= $hidden ;
    	$str.= '&nbsp;<input type="submit" name="frm_page_goto_submit" id="frm_page_goto_submit" value="GO" />&nbsp;' ;
    	$str.= '</form>' ;
    	
    	return $str ;
    }

} //类定义结束
?>
