<?php
header("Content-type:text/html;charset=utf-8");
class CommonAction extends Action {
	public $appid ;
	public $secret ;
	public $wxuser;
	

	public function _initialize(){
		$this->appid = "wxacf21161e3c578f1";
                $this->secret = "a9edccfb3018342657334dabd8873357";
		$this->wxoauth();
		session_start();
	}

	public function wxoauth(){

		if(empty($_SESSION['user'])){
	             $code = isset($_GET['code'])?$_GET['code']:'';
	             if(!$code){
	                  $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appid.'&redirect_uri=http://games.hzlianhai.com/xiangqin/index.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
	                  header("Location:".$url);
	             }else{
                         $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->secret.'&code='.$code.'&grant_type=authorization_code';

                         $ch = curl_init();
                         curl_setopt($ch,CURLOPT_URL,$get_token_url);
                         curl_setopt($ch,CURLOPT_HEADER,0);
                         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
                         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                         $res = curl_exec($ch);
                         curl_close($ch);
                         $json_obj = json_decode($res,true);

                         //根据openid和access_token查询用户信息
                         $access_token = $json_obj['access_token'];
                         $openid = $json_obj['openid'];
                         $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

                         $ch = curl_init();
                         curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
                         curl_setopt($ch,CURLOPT_HEADER,0);
                         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
                         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                         $res = curl_exec($ch);
                         curl_close($ch);

                         //解析json
                         $user_obj = json_decode($res,true);
                         $_SESSION['user'] = $user_obj;
			 //print_r($user_obj);
			 $this->wxuser_y = $user_obj;
                         $this->wxuser = array(
                                                                'open_id'=>$this->wxuser_y['openid'],
                                                                'nickname'=>$this->wxuser_y['nickname'],
                                                                'sex'=>$this->wxuser_y['sex'],
                                                                'location'=>$this->wxuser_y['province'].'-'.$this->wxuser_y['city'],
                                                                'avatar'=>$this->wxuser_y['headimgurl']
                                                );

                         }

            }else{
		    //print_r($_SESSION['user']);
		    $this->wxuser_y = $_SESSION['user'];
                    $this->wxuser = array(
								'open_id'=>$this->wxuser_y['openid'],
								'nickname'=>$this->wxuser_y['nickname'],
								'sex'=>$this->wxuser_y['sex'],
								'location'=>$this->wxuser_y['province'].'-'.$this->wxuser_y['city'],
								'avatar'=>$this->wxuser_y['headimgurl']
						);
             }


	}
}
/**
$CommonAction = new CommonAction();
//echo 'abc';
var_dump($CommonAction->wxuser);
 */

?>
