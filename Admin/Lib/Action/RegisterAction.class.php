<?php
	class RegisterAction extends Action{
		//显示修改密码页面
		public function pswModify(){
			$this->display();
		}
		
		/**
		 * 执行密码修改
		 */
		public function doPswModify(){
			
			$m=M('Admin');
			$pwd = $m->where("id=" + $_SESSION['id'])->getField('password');
			if ($pwd != $_POST['password']) {
				$this->error('旧密码错误！');
				return;
			} else {
				if ($_POST['newpassword'] != $_POST['repassword']) {
					$this->error('确认新密码与新密码不一致！');
					return;
				} else {
					$data['id']=$_SESSION['id'];
					$data['password']=$_POST['newpassword'];
					$data['sex']='1';
					$count=$m->save($data);
					if($count>0){
						$this->success('修改密码成功',U('Login/login'),3);
					}else{
						$this->error('修改密码失败');
					}
				}
				
			}
			
			
			
		}
	}
?>
