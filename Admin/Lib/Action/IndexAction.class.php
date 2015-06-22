<?php
/**
 * 后台首页的控制类
 * @author Administrator
 *
 */
 //登陆拦截
class IndexAction extends CommonAction {
// class IndexAction extends Action {
    public function index(){
		$this->userlist();
	}
    public function userlist(){
        //显示后台首页
        $User = M("User");
        if(!$_GET['p']){
            $_GET['p'] = 1;
        }
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list = $User->where('bm = 1')->order('bmtime DESC')->page($_GET['p'].',20')->select();
        $this->assign('list',$list);// 赋值数据集
        import("ORG.Util.Page");// 导入分页类
        $count      = $User->where('bm = 1')->count();// 查询满足要求的总记录数

        $Page       = new Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('theme','<li><span>%totalRow%条记录</span></li> <li class="prev">%upPage%</li> <li>%linkPage%</li> <li class="prev">%downPage%</li> %end%');
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->display("userlist");
    }
    public function shenhe(){
        $User = M("User");
        $id = $_POST["id"];
        $which = $_POST["which"];
        $data["shenhe"] = $which;
        $data["id"] = $id;
        $re = $User->save($data);
        if($re){
            $data['isSuccess'] = true;
            if($which == "1"){
                $data['which'] = "已审核";
            }else{
                $data['which'] = "未审核";
            }
            $this->ajaxReturn($data,'JSON');
        }else{
            $data['msg'] = "出错了";
            $this->ajaxReturn($data,'JSON');
        }
    }
    public function photo(){
        $id = $_GET["id"];
        $Pics = M("Pics");
        $map['uid']  = $id;
        $re = $Pics->where($map)->select();
        $this->assign('list',$re);
        $this->display();
    }
    public function wholike(){
        $id = $_GET["id"];
        $Toupiao = M("Toupiao");
        $map['bmid']  = $id;
        $re = $Toupiao->where($map)->select();
        $this->assign('list',$re);
        $this->display();
    }
    public function userdetail(){
        $id = $_GET["id"];
        $User = M("User");
        // $map['id']  = $id;
        $re = $User->find($id);
        $this->assign('data',$re);
        $this->display();
    }
    public function deletebm(){
        $id = $_POST["id"];
        $User = M("User");
        // $map['id']  = $id;
        $data["id"] = $id;
        $data["bm"] = "0";
        $re = $User->save($data);
        if($re){
            $data['isSuccess'] = true;
            $this->ajaxReturn($data,'JSON');
        }else{
            $data['msg'] = "出错了";
            $this->ajaxReturn($data,'JSON');
        }
    }
    public function edit(){
        if($_GET['id']){
            $id = $_GET['id'];
            $Product = M("Product");
            $map['product_model'] = $id;
            $result = $Product->where($map)->select();
            $this->assign('result',$result[0]);
            $this->assign('thumb',$result[0]["thumb"]);
        }else{
           // $this->assign('thumb',"default.jpg");
            $this->redirect('/Index/add');
        }
        $this->display("edit");
    }
    public function edituser(){
        if($_GET['mobile']){
            $mobile = $_GET['mobile'];
            $User = M("User");
            $map['mobile'] = $mobile;
            $result = $User->where($map)->select();
            $this->assign('result',$result[0]);
            // $this->assign('thumb',$result[0]["thumb"]);
        }else{
           // $this->assign('thumb',"default.jpg");
            $this->redirect('/Index/add');
        }
        $this->display("edituser");
    }
    public function orders(){
        $Order = M("Order");
        if(!$_GET['p']){
            $_GET['p'] = 1;
        }
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list = $Order->order('order_time DESC')->page($_GET['p'].',6')->select();
        $this->assign('list',$list);// 赋值数据集
        import("ORG.Util.Page");// 导入分页类
        $count      = $Order->count();// 查询满足要求的总记录数

        $Page       = new Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('theme','<li><span>%totalRow%条记录</span></li> <li class="prev">%upPage%</li> <li>%linkPage%</li> <li class="prev">%downPage%</li> %end%');
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->display("order");
    }
    public function lists(){
        $this->redirect('/Index/index');
    }
	public function search(){
        if(!$_GET['xh']){
            $this->redirect('/Index/index');
        }
        $xinghao = $_GET['xh'];

        $Product=M('Product');
        $where['product_model']=array('like','%'.$xinghao.'%');
        $re = $Product->where($where)->select();
        $this->assign('list',$re);
        $this->display("list");

	}
    public function searchuser(){
        if(!$_GET['mobile']){
            $this->redirect('/Index/userlist');
        }
        $m = $_GET['mobile'];

        $User=M('User');
        $where['mobile']=array('like','%'.$m.'%');
        $re = $User->where($where)->select();
        $this->assign('list',$re);
        $this->display("userlist");

    }
    public function editsub(){
        $Product = M("Product");
        $map['product_model']  = $_POST['product_model'];
        // $data['product_model']  = $_POST['product_model'];
        $data['remarks']  = $_POST['remarks'];
        $data['stocks']         = $_POST['stocks'];
        $data['price']         = $_POST['price'];
        $data['update_time']    = date('Y-m-d H:i:s',NOW_TIME);
        if($_POST["hasthumb"] == 1){
            $data['thumb']    = $_POST["thumb"];
        }
        $list   = $Product->where($map)->save($data);
        if ($list !== false) {
            // $this->success('上传图片成功！');
            $data['isSuccess'] = true;
            $data['id'] = $data['product_model'];
            $this->ajaxReturn($data,'JSON');
        } else {
            // $this->error('上传图片失败!');
            $data['msg'] = "上传失败";
            $this->ajaxReturn($data,'JSON');
        }
    }
	public function addsub(){
		$Product = M("Product");
		$data['product_model']  = $_POST['product_model'];
		$data['remarks']  = $_POST['remarks'];
        $data['stocks']         = $_POST['stocks'];
        $data['price']         = $_POST['price'];
        $data['update_time']    = date('Y-m-d H:i:s',NOW_TIME);
        $data['thumb']    = $_SESSION["image"];
        $list   = $Product->add($data);
        if ($list !== false) {
        	// $this->success('上传图片成功！');
            $data['isSuccess'] = true;
            $data['image'] = $_SESSION["image"];
            $data['id'] = $data['product_model'];
			$this->ajaxReturn($data,'JSON');
        } else {
            // $this->error('上传图片失败!');
            $data['msg'] = "上传失败";
			$this->ajaxReturn($data,'JSON');
        }
	}
    public function addusersub(){
        $User = M("User");
        $data['mobile']  = $_POST['mobile'];
        $data['remarks']  = $_POST['remarks'];
        $data['name']         = $_POST['name'];
        $data['update_time']    = date('Y-m-d H:i:s',NOW_TIME);
        $data['create_time']    = date('Y-m-d H:i:s',NOW_TIME);
        $list   = $User->add($data);
        if ($list !== false) {
            // $this->success('上传图片成功！');
            $data['isSuccess'] = true;
            // $data['image'] = $_SESSION["image"];
            $data['m'] = $data['mobile'];
            $this->ajaxReturn($data,'JSON');
        } else {
            // $this->error('上传图片失败!');
            $data['msg'] = "上传失败";
            $this->ajaxReturn($data,'JSON');
        }
    }
    public function editusersub(){
        $User = M("User");
        $map['mobile']  = $_POST['mobile'];
        // $data['product_model']  = $_POST['product_model'];
        $data['remarks']  = $_POST['remarks'];
        $data['name']         = $_POST['name'];
        $data['update_time']    = date('Y-m-d H:i:s',NOW_TIME);
        $list   = $User->where($map)->save($data);
        if ($list !== false) {
            // $this->success('上传图片成功！');
            $data['isSuccess'] = true;
            $data['m'] = $_POST['mobile'];
            $this->ajaxReturn($data,'JSON');
        } else {
            // $this->error('上传图片失败!');
            $data['msg'] = "上传失败";
            $this->ajaxReturn($data,'JSON');
        }
    }
    public function deletepro(){
        $promodal = $_POST["promodal"];
        $Product = M("Product");
        $map["product_model"] = $promodal;
        $re = $Product->where($map)->delete();
        if ($re !== false) {
            // $this->success('上传图片成功！');
            $data['isSuccess'] = true;
            // $data['id'] = $data['product_model'];
            $this->ajaxReturn($data,'JSON');
        } else {
            // $this->error('上传图片失败!');
            $data['msg'] = "出错了";
            $this->ajaxReturn($data,'JSON');
        }
    }
    public function deleteuser(){
        $mobile = $_POST["mobile"];
        $User = M("User");
        $map["mobile"] = $mobile;
        $re = $User->where($map)->delete();
        if ($re !== false) {
            // $this->success('上传图片成功！');
            $data['isSuccess'] = true;
            // $data['id'] = $data['product_model'];
            $this->ajaxReturn($data,'JSON');
        } else {
            // $this->error('上传图片失败!');
            $data['msg'] = "出错了";
            $this->ajaxReturn($data,'JSON');
        }
    }
    public function checkishave(){
        $product_model = $_POST["product_model"];
        $Product = M("Product");
        $map["product_model"] = $product_model;
        $re = $Product->where($map)->count();
        if($re){
            // $data['isSuccess'] = true;
            // if($re>0){
                $data['has'] = true;
            // }
            // $this->ajaxReturn($data,'JSON');
        }
        $data['isSuccess'] = true;            
        $this->ajaxReturn($data,'JSON');
    }
    public function checkishaveuser(){
        $mobile = $_POST["mobile"];
        $User = M("User");
        $map["mobile"] = $mobile;
        $re = $User->where($map)->count();
        if($re){
            // $data['isSuccess'] = true;
            // if($re>0){
                $data['has'] = true;
            // }
            // $this->ajaxReturn($data,'JSON');
        }
        $data['isSuccess'] = true;            
        $this->ajaxReturn($data,'JSON');
    }
    public function deleteord(){
        $id = $_POST["id"];
        $Order = M("Order");
        $map["id"] = $id;
        $re = $Order->where($map)->delete();
        if ($re !== false) {
            // $this->success('上传图片成功！');
            $data['isSuccess'] = true;
            // $data['id'] = $data['product_model'];
            $this->ajaxReturn($data,'JSON');
        } else {
            // $this->error('上传图片失败!');
            $data['msg'] = "出错了";
            $this->ajaxReturn($data,'JSON');
        }
    }

    public function upload() {
        if (!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload();
        }
    }

    // 文件上传
    protected function _upload() {
        import('@.ORG.UploadFile');
        //导入上传类
        $upload = new UploadFile();
        //设置上传文件大小
        $upload->maxSize            = 3292200;
        //设置上传文件类型
        $upload->allowExts          = explode(',', 'jpg,gif,png,jpeg');
        //设置附件上传目录
        $upload->savePath           = './Uploads/';
        //设置需要生成缩略图，仅对图像文件有效
        $upload->thumb              = true;
        // 设置引用图片类库包路径
        $upload->imageClassPath     = '@.ORG.Image';
        //设置需要生成缩略图的文件后缀
        $upload->thumbPrefix        = 'm_,s_';  //生产2张缩略图
        //设置缩略图最大宽度
        $upload->thumbMaxWidth      = '400,100';
        //设置缩略图最大高度
        $upload->thumbMaxHeight     = '400,100';
        //设置上传文件规则
        $upload->saveRule           = 'uniqid';
        //删除原图
        $upload->thumbRemoveOrigin  = false;
        if (!$upload->upload()) {
            //捕获上传异常
            $this->error($upload->getErrorMsg());
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            import('@.ORG.Image');
            //给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
            // Image::water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], __ROOT__.'/App/Tpl/Public/Images/logo.png');
            $_POST['image'] = $uploadList[0]['savename'];
        }
        $model  = M('Img');
        //保存当前数据对象
        $data['photo']          = $_POST['image'];
        $_SESSION['image'] = $_POST['image'];
        // $data['product_model']  = $_POST['product_model'];
        // $data['stocks']         = $_POST['stocks'];
        // $data['update_time']    = date('Y-m-d H:i:s',NOW_TIME);
        $list   = $model->add($data);
        if ($list !== false) {
            // $this->success('上传图片成功！');
            // echo("ss");
            echo("<script type=\"text/javascript\">parent.callback('".$_POST['image']."');</script>");
        } else {
            $this->error('上传图片失败!');
        }
    }
}

