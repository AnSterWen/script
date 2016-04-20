<?php
/**
 * stat_model.php
 * @package  mode
 * @author   Rooney@taomee.com
 * @version  $ID
 *
 */
class itemModel extends Base 
{
	private $dealer_service  = NULL ;
	private $manager_service = NULL ;

	public $user = NULL ;
	public $http = NULL ;
	public $response = NULL ;
	
	public function __construct()
	{
		parent::__construct(); 
		
		$this->response = Response::get_instance() ;

		if(!defined('ITEM_PRIVATE_KEY')) {
			die('Not found private key.') ;
		}
	}
	
	static function send($data, 
						 $method = "get", 
						 $request_file = NULL, 
						 $host = ITEM_HOST)
	{
		$response = Response::get_instance();
		
		if(empty($data))
		{
			$response->add_error('send_parameter', __FUNCTION__.': data was empty.');
			return false;
		}
			
		$str = '';
				
		// 对字符串进行 url编码
		foreach ($data as $key => $val)
		{
			if($val != NULL)
			{
			    $str .= $key.'='.(is_numeric($val) ? $val : urlencode($val)).'&';
			}
		}		

		$request_file = $request_file ?	$request_file : ITEM_MANAGER_FILE;

		$result = $method == 'get' ? self::send_by_get($host, $request_file, $str) : self::send_by_post($host, $request_file, $str) ;
		return $result;	
	}
	
	/**
	 * 向主机发送post请求
	 * 
	 * @param     string host 请求主机
	 * @param     string file 请求页面
	 * @param     string data post数据内容（格式：用key=value&key=value）
	 * @author    Rooney<rooney.zhang@gmail.com>
	 */
	function send_by_post($host, $file, $data, $timeout='60')
	{			
		$data  = $this->my_endsm($data) ;
	
        // Set url
        $url = 'http://' . $host .'/'. $file ;   
        
		$ch = curl_init(); // Create curl resource	
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout) ;
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string

        $output = curl_exec($ch);
        curl_close($ch);
echo $url;
        $result = json_decode($output,true);
		return $result ;			
	}
	
	/**
	 * 向主机发送get请求
	 * 
	 * @param     string host 请求主机
	 * @param     string file 请求页面
	 * @param     string data 查询字符串
	 * @author    Rooney<rooney.zhang@gmail.com>
	 */
	static function send_by_get($host, $file, $data, $timeout='60')
	{					
		$response = Response::get_instance() ;
		$data  = self::my_endsm($data) ;
		
		$url = 'http://' . $host . '/'. $file . '?'. $data;
        $response->set('get_url', $url) ;
Log::write($url);
		$ch = curl_init(); // Create curl resource	
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string

        $output = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($output,true);
		return $result ;
	}	
	
	/**
	 * 添加数字签名  digital signature missing
	 * 
	 * @author    Rooney<rooney.zhang@gmail.com> 
	 * @param     str    post string
	 */
	static function my_endsm($str)
	{
	    return $str."sign=".md5( $str.'key='.ITEM_PRIVATE_KEY ) ;
	}
		
		
}
?>
