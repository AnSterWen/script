<?php
class userController extends BaseController 
{
    public function indexAction()
    {
        $this->loginAction();
    }
    
    /* 用户登录 */
    public function loginAction()
    {
        if($this->user->is_login())
//        if(true)
        {
			$this->response->add_error(array('login'=> '你已经登录，请不要重复登陆！', 'error_file'=> 'User/login.html' )) ;
		}
		else
		{
		    if($this->http->has('inp_login'))
		    {
                echo "inp_login </br>";
		        $user_name = $this->http->get('user_name') ;
				$pwd       = $this->http->get('pwd') ;
				//用户登录
				$res = user_login($user_name, $pwd) ;
//pr($res);
//die();
				//登录失败
				if($res === false)
				{
				    $this->response->add_error(array('login'=>'登录失败:帐号不存在或密码错误!', 'error_file'=> 'User/login.html' )) ;
                }
                //登陆成功
                else
                {
                    Log::write("Login log >> name: {$user_name}, id: {$res['id']}");
                    $a_login = array(
                        'game'  => 'login',
				        'uid'   => $res['id'],
				        'uname' => $user_name,
				        'item'  => 0,
				        'desc'  => '用户登录',
                    );
                    audit($a_login);
                    //将用户基本信息存入session
					$this->user->login($user_name, $res['id']);
					$req_url = $this->user->get_req_url();
					if (!empty($req_url) && $req_url!='')
					{
						$url = $req_url;//用户之前的请求url
					}
					else
					{
                        $auth = $this->user->first_auth();
					    $url = '/platform/product/index.php?m='.$auth;
					}
						//系统默认入口
					redirect($url);
					return true;
                }
			}
		}
		$this->view->display('User/login.html', 1);
    }
    
	/* 用户注销 */
	public function logoutAction()
	{
		$this->user->logout();			
		$this->loginAction();// 返回登录页面
	}


}
?>
