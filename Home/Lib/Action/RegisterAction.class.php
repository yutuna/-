<?php
class RegisterAction extends CommonAction{

	public function index(){
		if(isset($_SESSION['id']) && $_SESSION['id'] !=NULL){
			$User = M("User");
			
		    $data['id'] = $_SESSION['id'];
		    $issettel = $User->where($data)->select();
		    if($issettel[0]['tel'] == NULL || $issettel[0]['tel'] == ''){//没有手机记录
			    $this->display();
			    //var_dump($issettel);
			    exit;
		    }
		    //var_dump($issettel);
		    //$this->redirect("Rank/scoreInfo");
		    //$this->error("已经提交过了，不能重复提交");
		    echo "<script>";
		echo "alert('已经提交过了，不能重复提交');window.location.href='http://qiushi.ncnwt.com/images/wumai';";
		echo "</script>";
		    exit;
		}else{
			$this->error('注册失败，请先玩游戏');
			$this->redirect("Index/index");
		}
		
	}

	public function doRegister(){
		$User = M("User");
		$data['id'] = $_SESSION['id'];
	        $data['tel'] = $this->_param('tel');
	        $data['realname'] = $this->_param('realname');
		$result = $User->save($data);
		if(false === $result)
	            $this->error("手机号码写入数据库失败！");
		else
			//$this->success('注册成功!');
		//$this->redirect("Index/index");
		echo "<script>";
		echo "alert('注册成功');window.location.href='http://qiushi.ncnwt.com/images/wumai';";
		echo "</script>";
	}
}
