<?php
//
class IndexAction extends CommonAction{
// class IndexAction extends Action{
	public $auth;

	
	public function index(){
		$userinfo = $this->wxuser;
		$open_id = $userinfo['open_id'];
		// var_dump($userinfo);
		// $open_id = "ssssssssss";//====weixin3
		$User = M("User");
		$user_array['open_id'] = $open_id;
		$result = $User->where($user_array)->find();

		$jsskd_all=$this->js_sdk();

        $jsskd = $jsskd_all['signPackage'];
        $ip_list = $jsskd_all['ip_list'];

        $this->assign('jsskd',$jsskd);
        $this->assign('ip_list',$ip_list);
        // var_dump($jsskd);
        // var_dump($ip_list);

        //展示图片数据
        $Baoming = M('Baoming');
    	// $list = $Baoming->select();
    	// $this->assign('list',$list);

        if(!$_GET['p']){
        	$_GET['p'] = 1;
        }
	    // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
	    $list = $Baoming->order('create_time')->page($_GET['p'].',6')->select();
	    $this->assign('list',$list);// 赋值数据集
	    import("ORG.Util.Page");// 导入分页类
	    $count      = $Baoming->count();// 查询满足要求的总记录数

	    $this->assign('bmcount',$count);//参与数量
		$ucount = $User->count();
	    $this->assign('ucount',$ucount);//访问数量
	    $Toupiao = M("Toupiao");
	    $toucount = $Toupiao->count();
	    $this->assign('toucount',$toucount);//投票数量

	    $Page       = new Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数
	    $Page->setConfig('theme',"%totalRow% %header% %nowPage%/%totalPage% 页 <div class='btn2 clearfix'><div class='item'>%upPage%</div><div class='item'>%downPage%</div></div>");
	    $show       = $Page->show();// 分页显示输出
	    $this->assign('page',$show);// 赋值分页输出
	    // $this->display(); // 输出模板






    	//是否存在用户并记录用户数据
		if ($result) {
			$_SESSION['id'] = $result['id'];
			//echo $_SESSION['id'];
			//$this->assign("times",$result['times']);
			$this->assign("jp_id",$result['jp_id']);
                       // $User->where("id={$_SESSION['id']}")->setField('times',$result['times']-1);
                       // $this->doTimes($result['times']-1);
			$this->display();
		}else{
			$result = $User->add($userinfo);
			$_SESSION['id'] = $result;
			if ($result) {
				$this->display();
			}else{
				// echo 'error';
                                //var_dump($userinfo);
			}
		}
		
	}
	public function yongbao(){
		$bmid = $_POST["bmid"];

		$User = M("User");
		$us = $User->find($_SESSION['id']);
		$lastTime = $us['last_vote_time'];

		$dateL=date('Y-m-d',$lastTime);
		$date = date('Y-m-d');

		if($dateL == $date){
			$msg = "一天只能投一次票喔~";
			$data['msg'] = $msg;
			$this->ajaxReturn($data,'JSON');
		}

		$todate['id'] = $_SESSION['id'];
		$todate['last_vote_time'] = time();
		$User->save($todate);


		$Toupiao = D("Toupiao");
      	// $data = array('uid' => $_SESSION['id'],'bmid' => $id );
      	// $re = $Toupiao->add($data);

      	if($Toupiao->create()) {
            $re = $Toupiao->add();
            if(!$re){

            }
        }else{
            $this->error($Toupiao->getError());
        }

      	$Baoming = M("Baoming");
      	// $da = $Baoming->find($id);
      	// $vote = $da['vote'];
      	// $data['id'] = $id;
      	// $data['vote'] = $vote+1;
      	// $data['score'] = array('exp','score+1');
      	$condition['id'] = $bmid;
		$data['vote'] = array('exp','vote+1');
		$ree = $Baoming->where($condition)->save($data);
		// $Baoming->save($data); // 根据条件保存修改的数据
		$vote = $Baoming->where($condition)->getField('vote');



      	if($re&&$ree){
      		$data['isSuccess'] = true;
      		$data['vote'] = $vote;
      	}else{
      		$data['msg'] = $msg;
      	}
      	$this->ajaxReturn($data,'JSON');
	}
	public function upImg(){
      	// var_dump($_SESSION['bmid']);
		$serverId = $_POST["serverId"];
		// var_dump($serverId);

		// $jsskd_all=$this->js_sdk();
        // $access_token = $jsskd_all['access_token'];
		$access_token = json_decode(file_get_contents("access_token.json"))->access_token;
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=$serverId";
		// $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      	$fileinfo = $this->downloadweixinfile($url);
      	// var_dump($fileinfo["header"]["content_type"]);
      	$typeI = $fileinfo["header"]["content_type"];
      	if(strstr($typeI,"jpeg")||strstr($typeI,"jpg")){
      		// var_dump("jpg");
      		$typestr = ".jpg";
      	}else{
      		// var_dump("png");
      		$typestr = ".png";
      	}
      	// $typestr = ".jpg";
      	$filename = "res/".time()."_".rand(100,999).$typestr;
      	$this->saveWeixinFile($filename,$fileinfo["body"]);

    	// $ret['url'] = $filename;
    	// $this->ajaxReturn($ret,'JSON');



      	$Baoming = M("Baoming");
      	$alre = $Baoming->find($_SESSION['bmid']);

      	if(!$alre['thumb']){
      		$data['id'] = $_SESSION['bmid'];
      		$data['thumb'] = $filename;
			$Baoming->save($data); // 根据条件保存修改的数据
			// $Baoming->find($_SESSION['bmid'])->save($data); // 根据条件保存修改的数据
      	}

      	$Pics = M("Pics");
      	$picinfo = array('url' => $filename,'bmid' => $_SESSION['bmid'] );
      	$re = $Pics->add($picinfo);
      	if($re){
      		$data['isSuccess'] = true;
      		$data['tt'] = 'true';
      	}
      	$this->ajaxReturn($data,'JSON');
	}
	public function yibaoming(){
		$Baoming = M('Baoming');

		$condition->uid = $_SESSION['id']; 
		$bmidt = $Baoming->where($condition)->select(); 
		$bmid = $bmidt[0]['id'];
		$this->assign('bmid',$bmid);

		$this->display();
	}
	public function baoming(){
		$userinfo = $this->wxuser;
		$open_id = $userinfo['open_id'];
		// var_dump($userinfo);
		// $open_id = "ssssssssss";//====weixin3
		$User = M("User");
		$user_array['open_id'] = $open_id;
		$result = $User->where($user_array)->find();

		$jsskd_all=$this->js_sdk();

        $jsskd = $jsskd_all['signPackage'];
        $ip_list = $jsskd_all['ip_list'];

        $this->assign('jsskd',$jsskd);
        $this->assign('ip_list',$ip_list);

        //以上是用户数据

		$us = $User->find($_SESSION["id"]);
		$bm = $us["bm"];
		if($bm != 0){
			redirect('yibaoming');
		}


		//是否存在用户并记录用户数据
		if ($result) {
			$_SESSION['id'] = $result['id'];
			//echo $_SESSION['id'];
			//$this->assign("times",$result['times']);
			$this->assign("jp_id",$result['jp_id']);
                       // $User->where("id={$_SESSION['id']}")->setField('times',$result['times']-1);
                       // $this->doTimes($result['times']-1);
			$this->display();
		}else{
			$result = $User->add($userinfo);
			$_SESSION['id'] = $result;
			if ($result) {
				$this->display();
			}else{
				// echo 'error';
                                //var_dump($userinfo);
			}
		}
	}
	public function bmsub(){
		$Form   =   D('Baoming');
        if($Form->create()) {
            $result =   $Form->add();
            if($result) {
            	$User = M("User");
				$todate['id'] = $_SESSION['id'];
				$todate['bm'] = "1";
				$User->save($todate);

            	$_SESSION['bmid'] = $result;
            	$data['status'] = $_SESSION['bmid'];
			    $this->ajaxReturn($data,'JSON');
                // $this->success('操作成功！');
            }else{
                $this->error('写入错误！');
            }
        }else{
            $this->error($Form->getError());
        }

	}
	public function detail(){
		$userinfo = $this->wxuser;
		$open_id = $userinfo['open_id'];
		// var_dump($userinfo);
		// $open_id = "ssssssssss";//====weixin3
		$User = M("User");
		$user_array['open_id'] = $open_id;
		$result = $User->where($user_array)->find();

		$jsskd_all=$this->js_sdk();

        $jsskd = $jsskd_all['signPackage'];
        $ip_list = $jsskd_all['ip_list'];

        $this->assign('jsskd',$jsskd);
        $this->assign('ip_list',$ip_list);

        //以上是用户数据
		$id = $_GET['id'];
		$Baoming = M("Baoming");
		$data = $Baoming->find($id);
		$this->assign('data',$data);

		$Pics = M("Pics");
 		$condition->bmid = $id; 
		$imgs = $Pics->where($condition)->select(); 
		$this->assign('pics',$imgs);
		 
		//是否存在用户并记录用户数据
		if ($result) {
			$_SESSION['id'] = $result['id'];
			//echo $_SESSION['id'];
			//$this->assign("times",$result['times']);
			$this->assign("jp_id",$result['jp_id']);
                       // $User->where("id={$_SESSION['id']}")->setField('times',$result['times']-1);
                       // $this->doTimes($result['times']-1);
			$this->display();
		}else{
			$result = $User->add($userinfo);
			$_SESSION['id'] = $result;
			if ($result) {
				$this->display();
			}else{
				// echo 'error';
                                //var_dump($userinfo);
			}
		}
	}
	public function upScore($score=''){
		if (!empty($score)) {
			$Score = M("Score");
			$data['score'] = $score;
			$data['joindate'] = date("Y-m-d,H:i:s",time());
			$uid = $_SESSION['id'];
			$data['uid'] = $uid;
			$score_array['uid'] = $uid;
			//$score_array= 'uid = '.$uid.' AND date(joindate) = curdate()';
			$issetuid = $Score->where($score_array)->find();
			if (!$issetuid) {
				$result1 = $Score->add($data);
				if (false !== $result1) 
				    $this->success('成绩上传成功!');
			    else
				    $this->error('成绩上传失败！');
			}elseif($issetuid['score'] < $score){
				$result = $Score->where($score_array)->save($data);
			    if (false !== $result) 
				    $this->success('成绩上传成功!');
			    else
				    $this->error('成绩上传失败！');
			}

			
			
		};
	}

	/*微信JS-SDK*/
    public function js_sdk(){
        Vendor('Weixin.jssdk');
        $jssdk = new JSSDK('wxacf21161e3c578f1','a9edccfb3018342657334dabd8873357');
        $signPackage = $jssdk->GetSignPackage();
        $ip_list = $jssdk->get_ip_list();
        // $access_token = $jssdk->getAccessToken();
        // return $signPackage;
        // return $ip_list;
        $result = array(
        	'signPackage' 	=> 	$signPackage, 
        	'ip_list'		=>	$ip_list,
        	'access_token'	=>	$access_token
        	);
        return $result;
//        $this->assign('jsskd',$signPackage);
//        $this->jsskd=$signPackage;
//        $this->display();
//         dump($signPackage);die();
    }

    public function doTimes(){
        $User=M('User');
        
        $starttime = $User->where("id={$_SESSION['id']}")->getField('starttime');
        if (($starttime + 24*3600) > time()) {
        	$jsonout = '{"access":0}';
        	
        }else{
        	$User->where("id={$_SESSION['id']}")->setField('starttime',time());
        	$jsonout = '{"access":1}';
        }
        echo $jsonout;
        
        //echo '{"access":0}';
        
    }

    public function duiJiang($qujianzhi=7){
    	$jp=M('Jp');
    	for ($i=$qujianzhi; $i < 8; $i++) { 
    		$result = $jp->where("jp_id={$i}")->getField('jp_num');
    		if ($result>0) {
    			$jp->where("jp_id={$i}")->setField('jp_num',$result-1);//奖品减一
    			$User=M('User');
    			$User->where("id={$_SESSION['id']}")->setField('jp_id',$i);
    			$out = $i; break;
    		}else $out =flase;
    	}
    	echo $out;
    	//return $out;
    }

	

	private function downloadweixinfile($url) {
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_NOBODY, 0);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	    $res = curl_exec($curl);
	    $httpinfo = curl_getinfo($curl);

	    // var_dump($res."==============".$httpinfo);

	    curl_close($curl);
	    $image_all = array_merge(array('header' => $httpinfo),array('body' => $res));

	    return $image_all;
	}
	private function saveWeixinFile($filename,$filecontent){
		$local_file = fopen($filename,'w');
		if(false !== $local_file){
			if(false !== fwrite($local_file, $filecontent)){
				fclose($local_file);
			}
		}
	}
}
