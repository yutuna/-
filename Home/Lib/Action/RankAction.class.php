<?php
class RankAction extends CommonAction{

	public function scoreInfo(){
		$queryStr = "select u.nickname as nickname,u.avatar as avatar,s.uid as uid,s.score as score,s.joindate as joindate from hym_user u join hym_score s on u.id=s.uid ORDER BY s.score DESC LIMIT 0,100";
		//$myqueryStr = "select score from 2048_score where uid=".$_SESSION['id'];

		$Model = new Model();
		if ($queryStr != null) {
			$list = $Model->query($queryStr);
		    $this->assign('data',$list);
		}

		if (isset($_SESSION['id']) && $_SESSION['id'] !='') {
			for($i=0;$i<count($list);$i++){
				if ($list[$i]['uid'] == $_SESSION['id']) {
					$mylist['rank'] = $i+1;
					$mylist['score'] = $list[$i]['score'];
					break;
				}
			}
			//$mylist = $Model->query($myqueryStr);
		    $this->assign('mydata',$mylist);
		}
//var_dump($mylist);

                $jsskd=$this->js_sdk();
                $this->assign('jsskd',$jsskd);
 //dump($jsskd);
		unset($queryStr);
		//unset($myqueryStr);
		$this->display();
	//	var_dump($list);
		

	}


/*微信JS-SDK*/
    public function js_sdk(){
        Vendor('Weixin.jssdk');
        $jssdk = new JSSDK('wx14b5eba925ca3407','f45f12d473e37e709c145c4f0e391537');
        $signPackage = $jssdk->GetSignPackage();
        return $signPackage;
//        $this->assign('jsskd',$signPackage);
//        $this->jsskd=$signPackage;
//        $this->display();
//         dump($signPackage);die();
    }
}
