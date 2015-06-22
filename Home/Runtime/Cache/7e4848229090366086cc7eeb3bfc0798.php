<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <title>寻找最萌宝贝</title>
  <meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />
<meta http-equiv="Cache-Control" content="no-cache" />
  <link rel="shortcut icon" href="favicon.ico">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="full-screen" content="yes"/>
<meta name="screen-orientation" content="portrait"/>
<meta name="x5-fullscreen" content="true"/>
<meta name="360-fullscreen" content="true"/>
  <meta name="Keywords" content="" />
  <meta name="description" content="" />
  <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/reset.css">
  <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css">
  <script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.3.min.js"></script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

</head>
<body >
  <div class="hometop">
    <img src="__PUBLIC__/images/1.jpg">
    <img src="__PUBLIC__/images/2.jpg">
    <img src="__PUBLIC__/images/3.jpg">
  </div>
  <div class="homemid">
    <a class="btn">我要报名</a>
    <div class="btn2 clearfix">
      <div class="item">
        <a class="btn">活动细则</a>
      </div>
      <div class="item">
        <a class="btn">奖品设置</a>
      </div>
    </div>
    <div class="tongji clearfix">
      <div class="item">参与人数:<span id="cyrs"></span></div>
      <div class="item">投票累计:<span id="tplj"></span></div>
      <div class="item">访问量:<span id="fwl"></span></div>
    </div>
  </div>
  <div class="tiaozhuan clearfix">
      <div class="left">当前第1页，跳到第 <input type="text" /> 页</div>
       <a class="tz">确定</a>
  </div>
  <div class="homebottom">

    <ul class="clearfix">
      <li>
        <div class="img"><img src="__PUBLIC__/images/bb2.jpg"></div>
        <div class="detail clearfix">
          <span id="pid">No.001</span>
          <span id="pname">张珊珊</span>
          <span id="pnum">1000票</span>
        </div>
        <a class="btn_y">拥抱一下</a>
      </li>
      <li>
        <div class="img"><img src="__PUBLIC__/images/bb.jpg"></div>
        <div class="detail clearfix">
          <span id="pid">No.001</span>
          <span id="pname">张珊珊</span>
          <span id="pnum">1000票</span>
        </div>
        <a class="btn_y">拥抱一下</a>
      </li>
      <li>
        <div class="img"><img src="__PUBLIC__/images/bb2.jpg"></div>
        <div class="detail clearfix">
          <span id="pid">No.001</span>
          <span id="pname">张珊珊</span>
          <span id="pnum">1000票</span>
        </div>
        <a class="btn_y">拥抱一下</a>
      </li>
    </ul>
    <div class="btn2 clearfix">
      <div class="item">
        <a class="btn">上一页</a>
      </div>
      <div class="item">
        <a class="btn">下一页</a>
      </div>
    </div>
  </div>
  <!-- <?php echo ($jsskd); ?> -->
  <!-- <?php echo ($tt); ?> -->
  <script type="text/javascript">
    // console.log(<?php echo ($jsskd); ?>);
// alert('1');
    wx.config({
    debug: false,//false true
  appId: '<?php echo ($jsskd["appId"]); ?>',
  timestamp:'<?php echo ($jsskd["timestamp"]); ?>',
  nonceStr: '<?php echo ($jsskd["nonceStr"]); ?>',
  signature: '<?php echo ($jsskd["signature"]); ?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'checkJsApi',
      'onMenuShareTimeline',
      'onMenuShareAppMessage',
      'onMenuShareQQ',
      'onMenuShareWeibo',
      'hideMenuItems',
      'showMenuItems',
      'hideAllNonBaseMenuItem',
      'showAllNonBaseMenuItem',
      'translateVoice',
      'startRecord',
      'stopRecord',
      'onRecordEnd',
      'playVoice',
      'pauseVoice',
      'stopVoice',
      'uploadVoice',
      'downloadVoice',
      'chooseImage',
      'previewImage',
      'uploadImage',
      'downloadImage',
      'getNetworkType',
      'openLocation',
      'getLocation',
      'hideOptionMenu',
      'showOptionMenu',
      'closeWindow',
      'scanQRCode',
      'chooseWXPay',
      'openProductSpecificView',
      'addCard',
      'chooseCard',
      'openCard'
    ]
  });

// alert('2');
  wx.ready(function () {
    // 在这里调用 API
     wx.showOptionMenu();

     var link = 'http://games.hzlianhai.com/haoyangmao/index.php';
     var imgUrl = 'http://games.hzlianhai.com/haoyangmao/share.png';

       wx.onMenuShareAppMessage({
          title: '龙抬头薅羊毛', // 分享标题
          desc: '今天我薅羊毛卷，击败了全国%的网友，求超越！',
          link: link, // 分享链接
          imgUrl: imgUrl, // 分享图标
          success: function () {
          //   $.post('Index/doTimes',{"times":1},function(data){
          //              // alert('jjjj');
          //               },"json");
          // window.times++;
          //     // 用户确认分享后执行的回调函数
          //     //alert("喵喵感谢您！success");
          //     //location.reload();
          //     window.location.href="http://qiushi.ncnwt.com/images/haoyangmao/Rank/scoreInfo/";
          },
          cancel: function () {
              // 用户取消分享后执行的回调函数
              //alert("喵喵感谢您！cancel");
              // location.reload();
          }
      });

       wx.onMenuShareTimeline({
          title: '今天我薅羊毛卷，击败了全国%的网友，求超越！', // 分享标题
          link: link, // 分享链接
          imgUrl: imgUrl, // 分享图标
          success: function () { 
          //   $.post('Index/doTimes',{"times":1},function(data){
          //              // alert('jjjj');
          //               },"json");
          // window.times++;
          //     // 用户确认分享后执行的回调函数
          //     window.location.href="http://games.hzlianhai.com/haoyangmao/Rank/scoreInfo/";
          },
          cancel: function () { 
              // 用户取消分享后执行的回调函数
              // location.reload();
          }
      });


  });

// alert('3');
  </script>  
</body>
</html>