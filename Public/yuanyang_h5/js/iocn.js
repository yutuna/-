var myVideo=document.getElementById("mp3");window.onload=function(){  setTimeout("hide_Show()",500);	$(".iocn").addClass('iocn_1')	 var i=0;     $(".iocn").click(function(){       i++;       if(i%2!=0){         $(".iocn").removeClass("iocn_1");          myVideo.pause();        }else{         $(".iocn").addClass('iocn_1');           myVideo.play();        }     })}function hide_Show(){   $(".load").fadeOut();     $(".in_Show").removeClass("hide");     mp3(); }function mp3(){   myVideo.play(); }