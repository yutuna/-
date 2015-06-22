<?php
	
	class UserAction extends CommonAction{
		
		public function userInfo(){
			
			$User = M('User'); // 实例化User对象
			import('ORG.Util.Page');// 导入分页类
			$count      = $User->count();// 查询满足要求的总记录数
			$Page       = new Page($count,C('USER_PAGE_COUNT'));// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $User->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('data',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display(); // 输出模板
		}
		
		/**
		 * 搜索用户记录，分页显示
		 */
		public function searchUser(){
			$map=array();
			if(!empty($_GET['username'])){
				$map['nickname'] = array('like','%'.$_GET['username'].'%');
			}
			if(!empty($_GET['userphone'])){
				$map['location'] = array('like','%'.$_GET['userphone'].'%');
			}

			$parameter = 'nickname='.urlencode($_GET['username']).'&location='.urlencode($_GET['userphone']);
			
			$User = M('User'); // 实例化User对象
			import('ORG.Util.Page');// 导入分页类
			$count      = $User->where($map)->count();// 查询满足要求的总记录数
			$Page       = new Page($count,C('USER_PAGE_COUNT'),$parameter);// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $User->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('data',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display('userInfo'); // 输出模板
			
		}
		
		/**
		 *
		 * 导出用户数据到 Excel
		 */
		function exportUserData(){//导出Excel

			$xlsName  = "用户数据表";
			$xlsCell  = array(
					array('index','序号'),
					array('username','姓名'),
					array('sex','性别'),
					array('agerange','年龄'),
					array('sheng','省份'),
					array('shi','城市'),
					array('xian','区县'),
					array('job','职业'),
					array('userphone','手机'),
					array('is_share','是否分享'),
					array('regtime','注册时间')
		
			);
			$xlsModel = M('User');
			
			$map=array();
			if($_GET['username']!='blank'){
				$map['username'] = array('like','%'.$_GET['username'].'%');
			}
			if($_GET['userphone']!='blank'){
				$map['userphone'] = array('like','%'.$_GET['userphone'].'%');
			}
			
			$xlsData  =$xlsModel->where($map)->Field('username,agerange,sex,sheng,shi,xian,job,userphone,is_share,regtime')->order('id desc')->select();
			
			$i=1;
			foreach ($xlsData as $k => $v)
			{	
				$xlsData[$k]['index']=$i;
				$i++;
			}
			
			$this->exportExcel($xlsName,$xlsCell,$xlsData);
		
		}
		
		/**
		 * 显示成绩信息
		 */
		public function scoreInfo(){
			
			$queryStr ="select u.nickname as nickname,u.sex as sex,u.location as location,u.avatar as avatar,s.uid as uid,s.score as score,s.joindate as joindate from hym_user u join hym_score s on u.id=s.uid";
			
			$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
			$queryResult = $Model->query($queryStr);
			
			if($queryResult!=null){
				import('ORG.Util.Page');// 导入分页类
				$count      = count($queryResult);// 查询满足要求的总记录数
				$Page       = new Page($count,C('SCORE_PAGE_COUNT'));// 实例化分页类 传入总记录数和每页显示的记录数
				$show       = $Page->show();// 分页显示输出
				// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
				$queryStr1 ="select u.nickname as nickname,u.sex as sex,u.location as location,u.avatar as avatar,s.uid as uid,s.score as score,s.joindate as joindate from hym_user u join hym_score s on u.id=s.uid order by s.score desc limit ".$Page->firstRow.",".$Page->listRows;
				
				$list = $Model->query($queryStr1);
				$this->assign('data',$list);// 赋值数据集
				$this->assign('page',$show);// 赋值分页输出
						
			}
			
			unset($queryResult);
			$this->display();
			
		}
		
		/**
		 * 搜索成绩信息，分页显示
		 */
		public function searchScore(){
			
			$where=" where 1=1";

			if(!empty($_GET['startdate'])){
			
				$where.=" and DATE_FORMAT( s.joindate,  '%Y-%m-%d' ) >='".date("Y-m-d",strtotime($_GET['startdate']))."'";
			}
				
			if(!empty($_GET['enddate'])){
				$where.=" and DATE_FORMAT( s.joindate,  '%Y-%m-%d' ) <='".date("Y-m-d",strtotime($_GET['enddate']))."'";
			}
			
			if(!empty($_GET['username'])){
				$where.=" and u.nickname like '%".$_GET['username']."%'";
			}
			
			if(!empty($_GET['userphone'])){
				$where.=" and u.location like '%".$_GET['userphone']."%'";
			}
			
			$queryStr ="select u.nickname as nickname,u.sex as sex,u.location as location,u.avatar as avatar,s.uid as uid,s.score as score,s.joindate as joindate from hym_user u join hym_score s on u.id=s.uid".$where;
			
			
			$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
			
			$queryResult = $Model->query($queryStr);
			
			
			if($queryResult!=null){
				
				//带入搜索参数
				$parameter = 'userphone='.urlencode($_GET['userphone']).'&startdate='.urlencode($_GET['startdate']).'&enddate='.urlencode($_GET['enddate']).'&username='.urlencode($_GET['username']).'&userphone='.urlencode($_GET['userphone']);
				
				import('ORG.Util.Page');// 导入分页类
				$count      = count($queryResult);// 查询满足要求的总记录数
				$Page       = new Page($count,C('SCORE_PAGE_COUNT'),$parameter);// 实例化分页类 传入总记录数和每页显示的记录数
				$show       = $Page->show();// 分页显示输出
				// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
				$where.=" order by s.joindate desc limit ".$Page->firstRow.",".$Page->listRows;
				$queryStr1 ="select u.nickname as nickname,u.sex as sex,u.location as location,u.avatar as avatar,s.uid as uid,s.score as score,s.joindate as joindate from hym_user u join hym_score s on u.id=s.uid".$where;

				$list = $Model->query($queryStr1);
				$this->assign('data',$list);// 赋值数据集
				$this->assign('page',$show);// 赋值分页输出
				
			}
			
			unset($queryResult);
			$this->display('scoreInfo'); // 输出模板
		}
		
		/**
		 *
		 * 导出成绩信息到Excel
		 */
		function exportScoreData(){//导出Excel

			$xlsName  = "用户游戏成绩表";
			$xlsCell  = array(
					array('joindate','游戏时间'),
					array('username','姓名'),
					array('agerange','年龄'),
					array('sex','性别'),
					array('sheng','省份'),
					array('shi','城市'),
					array('xian','区县'),
					array('job','职业'),
					array('userphone','手机'),
					array('score','用户分数'),
					array('is_share','是否分享')
		
			);
			$xlsModel = new Model();
				
			$where=" where 1=1";

			if($_GET['startdate']!='blank'){
			
				$where.=" and DATE_FORMAT( s.joindate,  '%Y-%m-%d' ) >='".date("Y-m-d",strtotime($_GET['startdate']))."'";
			}
				
			if($_GET['enddate']!='blank'){
				$where.=" and DATE_FORMAT( s.joindate,  '%Y-%m-%d' ) <='".date("Y-m-d",strtotime($_GET['enddate']))."'";
			}
			
			if($_GET['username']!='blank'){
				$where.=" and u.username like '%".$_GET['username']."%'";
			}
			
			if($_GET['userphone']!='blank'){
				$where.=" and u.userphone like '%".$_GET['userphone']."%'";
			}
				
			$where.=" order by s.joindate desc";
			$queryStr1 ="select u.nickname as nickname,u.sex as sex,u.location as location,u.avatar as avatar,s.uid as uid,s.score as score,s.joindate as joindate from hym_user u join hym_score s on u.id=s.uid".$where;

			$xlsData = $xlsModel->query($queryStr1);

			$this->exportExcel($xlsName,$xlsCell,$xlsData);
		
		}
		
	}
?>
