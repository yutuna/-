var start = false;
var score = 0;
$(function(){
	// $('#gamelayer').click(function(){
	// 	gameStart();
	// });
	$('#share').click(function(){
		$(this).hide();
	});
	$('#tip').click(function(){
		$(this).hide();
		gameStart();
	});
	$('#gamelayer').on('touchmove', function (event) {
	    event.preventDefault();
	});
	document.getElementById('tree').addEventListener('touchstart',touchstart,false);
	document.getElementById('tree').addEventListener('touchmove',touchmove,false);
	document.getElementById('tree').addEventListener('touchend',touchend,false);
});
var sx,sy;
function touchstart(event){
	// console.log('start');
	if(!start) gameStart();
	// console.log(event.touches[0].clientX);
	sx = event.touches[0].clientX;
	sy = event.touches[0].clientY;

	
	toface(faceid);
	faceid++;
	if(faceid>3) faceid = 0;
	
}
function touchmove(event){
	$('#score_text').text(score);
	event.preventDefault();
	// console.log(event.touches[0].clientX);
	var x = event.touches[0].clientX;
	var y = event.touches[0].clientY;
	var rand = parseInt(Math.random()*5);
	if(rand == 1){
		var rand2 = parseInt(Math.random()*5);
		score += rand+rand2;
		fid+=1;
		$('#gamelayer').append("<div class=\"flo1 tran_f\" style=\"left:"+x+"px;top:"+y+"px;\" id=\"flo_"+fid+"\"></div>");
		var obj = $('#flo_'+fid);
		// setTimeout(function(){
		// 	obj.removeClass('flo1');
		// 	obj.addClass('flo2');
		// 	obj.css('opacity','0.5');
		// 	randGo(obj);
		// },100);
		// setTimeout(function(){
		// 	obj.removeClass('flo2');
		// 	obj.addClass('flo3');
		// 	obj.css('opacity','0');
		// 	randGo(obj);
		// },1100);
		// setTimeout(function(){
		// 	obj.remove();
		// },2100);
		setTimeout(function(){
			obj.css('opacity','0.5');
			randGo(obj);
		},100);
		setTimeout(function(){
			obj.css('opacity','0');
			randGo(obj);
		},1500);
		setTimeout(function(){
			obj.remove();
		},3000);
	}
		
}
var fid = 0;
var winWidth = window.innerWidth;
function touchend(event){
	console.log('end');
	// console.log(event.changedTouches[0].clientX);
	// fid ++;
	// var x = event.changedTouches[0].clientX;
	// var y = event.changedTouches[0].clientY;

	// if(x/winWidth>0.8)
	// 	x -= winWidth/3;
	// if(x/winWidth<0.2)
	// 	x += winWidth/3;
	// var abs = Math.abs(x-sx)+Math.abs(y-sy);
	// if(abs<20) return;
	// if(abs>40) abs = 60;
	// var rand = parseInt(Math.random()*3+1);

	// score += parseInt(rand*abs/15);

	// $('#gamelayer').append("<div class=\"flo1 tran_f\" style=\"left:"+x+"px;top:"+y+"px;\" id=\"flo_"+fid+"\"></div>");

	// var objs = [];
	// // objs[0] = $('#gamelayer');
	// for(var j = 0;j<rand;j++){
	// 	$('#gamelayer').append("<div class=\"flo2 tran_f\" style=\"left:"+x+"px;top:"+y+"px;\" id=\"flo_"+fid+"_"+j+"\"></div>");

	// 	objs[j] =  $('#flo_'+fid+'_'+j);
	// }
	
	// // $('#flo_'+fid).css('opacity','1');
	// var obj = $('#flo_'+fid);
	// // var obj2 = $('#flo_'+fid+'_2');
	// // var obj3 = $('#flo_'+fid+'_3');


	// setTimeout(function(){
	// 	obj.removeClass('flo1');
	// 	obj.addClass('flo2');
	// 	obj.css('opacity','0.5');
	// 	randGo(obj);
	// 	// randGo(obj2);
	// 	// randGo(obj3);
	// 	for(var j = 0;j<objs.length;j++){
	// 		randGo(objs[j]);
	// 	}
	// },100);
	// setTimeout(function(){
	// 	obj.removeClass('flo2');
	// 	obj.addClass('flo3');
	// 	obj.css('opacity','0');
	// 	randGo(obj);
	// 	for(var j = 0;j<objs.length;j++){
	// 		randGo(objs[j]);
	// 	}
	// },1100);
	// setTimeout(function(){
	// 	obj.remove();
	// 	for(var j = 0;j<objs.length;j++){
	// 		objs[j].remove();
	// 	}
	// },2100);	
}
function randGo(obj){
	var Randx = parseInt(Math.random()*50)-25;
	var Randy = parseInt(Math.random()*30)+35;
	var left = obj.position().left+Randx;
	var top = obj.position().top+Randy;
	// console.log(Randx);
	obj.css('left',left);
	obj.css('top',top);
	// console.log(left);
}
var faceid = 0;
var flowerid = 0;
var boxid = 0;
function setInG(){
	$('#score_text').text('0');
	$('#time_text').text('10');
	$('#tip').show();
	$('#gamelayer').css('top','0px');
	start = false;
	score = 0;

	document.getElementById('tree').addEventListener('touchstart',touchstart,false);
	document.getElementById('tree').addEventListener('touchmove',touchmove,false);
	document.getElementById('tree').addEventListener('touchend',touchend,false);
}
function gameStart(){
	$('#tip').hide();
	start = true;
	timer();

	// setInterval(function(){
	// 	toface(faceid);
	// 	faceid++;
	// 	if(faceid>3) faceid = 0;

	// 	toflower(flowerid);
	// 	flowerid++;
	// 	if(flowerid>4) flowerid = 0;

	// 	tobox(boxid);
	// 	boxid++;
	// 	if(boxid>4) boxid = 0;
	// },1000);
}
function timer(){
	var time = setInterval(function(){
		var now = parseInt($('#time_text').text());
		now --;
		if(now<1) {
			clearInterval(time);
			gameEnd();
		}
		$('#time_text').text(now);
		if(score>370){
			toflower(4);
			tobox(4);
		}
			
		else if(score>270){
			toflower(3);
			tobox(3);
		}
			
		else if(score>170){
			toflower(2);
			tobox(2);
		}
			
		else if(score>70){
			toflower(1);
			tobox(1);
		}

			
	},1000);
}
function gameEnd(){
	$('#score_all').text(score);
	var perc = '0%';
	var gobi = 0;
	if(score > 370){
		perc = '90%';
		gobi = 51;
	}
	else if(score > 270){
		perc = '64%';
		gobi = 17;
	}
		
	else if(score > 170){
		perc = '32%';
		gobi = 7;
	}
		
	else if(score > 70){
		perc = '10%';
		gobi = 2;
	}
	$('#perc').text(perc);
	$('#gobi').text(gobi);

	setTimeout(function(){
		tolayer(3);
	},2000);
	document.getElementById('tree').removeEventListener('touchstart',touchstart,false);
	document.getElementById('tree').removeEventListener('touchmove',touchmove,false);
	document.getElementById('tree').removeEventListener('touchend',touchend,false);
}
function startClick() {
	tolayer(2);
}
function tolayer(id){
	var leave1,leave2,stay;
	switch(id){
		case 1:
		leave1 = $('#gamelayer');
		leave2 = $('#end');
		stay = $('#before');
		break;
		case 2:
		leave1 = $('#before');
		leave2 = $('#end');
		stay = $('#gamelayer');
		break;
		case 3:
		leave1 = $('#gamelayer');
		leave2 = $('#before');
		stay = $('#end');
		break;
	}
	stay.show();
	leave2.hide();
	leave1.hide();
}
var face = [0,31,62,93];
var flower = [0,25,50,75,100];
var box = [0,23,46,69,92];
function toface(num){
	$('.game_mid .face').css('background-position','center '+face[num]+'%');
}
function toflower(num){
	$('.game_mid .flowers').css('background-position','center '+flower[num]+'%');
}
function tobox(num){
	$('.game_below .box').css('background-position','center '+box[num]+'%');
}
function showShare(){
	$('#share').show();
}












