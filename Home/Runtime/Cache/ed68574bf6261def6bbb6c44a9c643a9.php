<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">

<title>tttt</title>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  wx.config({
	debug: true,//false true
	appId: '<?php echo ($jsskd["appId"]); ?>',
	timestamp:'<?php echo ($jsskd["timestamp"]); ?>',
	nonceStr: '<?php echo ($jsskd["nonceStr"]); ?>',
	signature: '<?php echo ($jsskd["signature"]); ?>',
	jsApiList: [
'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage'
	  ]	  
  });
</script>
<script>
wx.ready(function () {

wx.checkJsApi({
      jsApiList: [
        'getNetworkType',
        'previewImage'
      ],
      success: function (res) {
        alert(JSON.stringify(res));
      }
    });

  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
    wx.onMenuShareTimeline({
      title: '2015，ivvi送你年终奖！',
      link: 'http://www.baidu.com',
      imgUrl: 'http://www.baidu.com',
      trigger: function (res) {
        //alert('用户点击分享到朋友圈');
      }
    }); 
	
	wx.onMenuShareAppMessage({
      title: 'http://www.baidu.com',
      desc: 'http://www.baidu.com',
      link: 'http://www.baidu.com',
      imgUrl: 'http://www.baidu.com',
      trigger: function (res) {
        //alert('用户点击发送给朋友');
      }
    });

  
});
wx.error(function (res) {
  alert(res.errMsg);
});
</script>
</head>
<body>

</body>
</html>