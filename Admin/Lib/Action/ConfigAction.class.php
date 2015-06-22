<?php
	/**
	 * 定义配置类，用来控制配置管理的一些功能
	 * @author Administrator
	 *
	 */
	class ConfigAction extends Action{
		
		public function configInfo(){

			$condition['grouptype']=$_GET['grouptype'];//获取前台传入的配置组，目前有【图片配置，活动配置，微信配置】三种

			$ConfigModel = M('Config');
			$data = $ConfigModel->where($condition)->select();
			$this->assign('data',$data);
			
			$configTitle='';
			switch($_GET['grouptype']){
				case 'system':
					$configTitle='图片配置';
					break;  
				case 'game':
					$configTitle='活动配置';
					break;  
				case 'weixin':
					$configTitle='微信配置';
					break;  
				default:
					$configTitle='配置管理';
			}
			
			$this->assign('configTitle',$configTitle);
			
			$this->display();
		}
		
		/**
		 * 更新配置信息
		 */
		public function updateConfig(){
			
			$ConfigModel = M('Config');
			
			foreach($_POST['data'] as $data)
			{	
				$ConfigModel->save($data);

			}
			
			$this->success('修改系统配置成功');
		}
		
		/**
		 * 显示系统配置页面
		 * // 威虎小钟修改：2014-10-16
		 */
		public function systemconfig(){
			$Config=M('Config');
			$this->assign("cfg_survey_banner_1", $Config->where("varname='cfg_survey_banner_1'")->getField('value'));
			$this->assign("cfg_survey_banner_2", $Config->where("varname='cfg_survey_banner_2'")->getField('value'));
			$this->assign("cfg_survey_banner_3", $Config->where("varname='cfg_survey_banner_3'")->getField('value'));
			$this->assign("cfg_survey_banner_4", $Config->where("varname='cfg_survey_banner_4'")->getField('value'));
			$this->assign("cfg_survey_banner_5", $Config->where("varname='cfg_survey_banner_5'")->getField('value'));
			$this->assign("cfg_survey_banner_6", $Config->where("varname='cfg_survey_banner_6'")->getField('value'));
			
			
			$this->display();
		}
		
		/**
		 * 更新系统配置页面
		 */
		public function updateSysConfig(){
			// 威虎小钟注释：2014-10-16
			/* //系统配置页面主要是设置5张banner图片
			
			$Config=M('Config');
				
			import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  './Public/Uploads/';// 设置附件上传目录
			
			if(!$upload->upload()) {// 上传错误提示错误信息
				$this->error($upload->getErrorMsg());
			}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();
			}
			$Config->where("varname='cfg_survey_banner_1'")->setField('value',$info[0]['savename']);
			$Config->where("varname='cfg_survey_banner_2'")->setField('value',$info[1]['savename']);
			$Config->where("varname='cfg_survey_banner_3'")->setField('value',$info[2]['savename']);
			$Config->where("varname='cfg_survey_banner_4'")->setField('value',$info[3]['savename']);
			$Config->where("varname='cfg_survey_banner_5'")->setField('value',$info[4]['savename']);
			
			$this->success('添加顶部banner成功','systemconfig'); */
			// 注释结束
			
			//系统配置页面主要是设置6张banner图片
			$Config=M('Config');
			$Config->where("varname='cfg_survey_banner_1'")->setField('value',$_POST['bannerpic1']);
			$Config->where("varname='cfg_survey_banner_2'")->setField('value',$_POST['bannerpic2']);
			$Config->where("varname='cfg_survey_banner_3'")->setField('value',$_POST['bannerpic3']);
			$Config->where("varname='cfg_survey_banner_4'")->setField('value',$_POST['bannerpic4']);
			$Config->where("varname='cfg_survey_banner_5'")->setField('value',$_POST['bannerpic5']);
			$Config->where("varname='cfg_survey_banner_6'")->setField('value',$_POST['bannerpic6']);
				
			
			$this->success('保存顶部banner成功','systemconfig');
			
			
			
		}
		
	}
?>
