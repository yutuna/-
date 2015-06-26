function valid () {
	if(!$('#bbname').val()||!$('#bbage').val()||!$('#mobile').val()||!$('#selfdesc').val()||!$('#creer').val()||!$('#xingzuo').val()||!$('#study').val()||!$('#salary').val()||!$('#zeoubz').val()){
		alert('报名表单不完整，请填写完整！');
		return false;
	}
	if(isNaN($('#bbage').val())){
    	alert('年龄必须为数字'); 
    	return false;
   	}
	if(!checkMobile($('#mobile').val())){
		alert('手机号码格式错误！');
		return false;
	}
	if(localIds_All.length<3){
		alert('照片数量要求为3-5张！')
		return false;
	}
	if($('#selfdesc').val().length>200){
		alert('自我描述不大于200字！')
		return false;
	}
	if($('#zeoubz').val().length>100){
		alert('择偶标准不大于100字！')
		return false;
	}
	return true;
}
function checkMobile(text){
	// alert(text);
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    if(!myreg.test(text)){
            // alert('请输入有效的手机号码！');
            // document.form1.mobile.focus();
            return false;
    }else{
    	return true;
    }
}