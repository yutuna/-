<?php
/**
 * 定义验证码格式，位数等参数
 * @author Administrator
 *
 */
	class PublicAction extends Action{
		public function code(){
			$w=isset($_GET['w'])?$_GET['w']:30;
			$h=isset($_GET['h'])?$_GET['h']:30;

			import('ORG.Util.Image');
			// ob_end_clean();
    		Image::buildImageVerify();
		}
	}
?>
