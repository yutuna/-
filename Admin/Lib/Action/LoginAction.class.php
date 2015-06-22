<?php
	class LoginAction extends Action{
		public function login(){
			$this->display();//显示登陆界面
		}
		
		/**
		 * 执行登陆。需要进行用户名，密码，验证码的验证
		 */
		public function doLogin(){
			
			//接受值
			//判断用户在数据库中是否存在
			//存在 允许登录
			//不存在 显示错误信息
			$username=$_POST['username'];
			$password=$_POST['password'];
			
			session('USER_AUTH_KEY',C('USER_AUTH_KEY'));
			$code=$_POST['code'];
			if(md5($code)!=$_SESSION['code']){
				$this->error('验证码不正确');
			}
			
			$user=M('Admin');
			//$where['username']=$username;
			//$where['password']=$password;
			
			
			$arr=$user->where("username='".$username."' and binary password='".$password."'")->find();
			
			if($arr && isset($arr["username"]) && $arr["username"] != ""){
				$_SESSION['username']=$username;
				$_SESSION['id']=$arr['id'];
				$this->success('用户登录成功',U('Index/index'));
			}else{
				$this->error('用户名或密码错误！');
			}
		}
		
		//退出登陆
		public function doLogout(){
			$_SESSION=array();
				if(isset($_COOKIE[session_name()])){
					setcookie(session_name(),'',time()-1,'/');
				}
			session_destroy();
			$this->redirect('Index/index');
		}
		
	}
?>
