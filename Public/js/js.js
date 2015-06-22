function yongbao(url,bmid){

    // alert('__URL__/yongbao');

    // alert(bmid);

    $.ajax({    

        url:url,// 跳转到 action    

        data:{    

            bmid:bmid,

        },    

        type:'post',    

        cache:false,    

        dataType:'json',    

        success:function(data) { 

            if(data.isSuccess){

                var vote = data.supporter;

                alert('谢谢！我们随后会有工作人员与您联系。');

                // alert(vote);

                if($('#dpnum')){

                    $('#dpnum').text(vote+"票");

                }

                if($('#pnum_'+bmid)){

                    $('#pnum_'+bmid).text(vote+"票");

                }

            }else{

                alert(data.msg);
                if(data.weibaoming){
                    var ur = burl+"info?id="+data.bmid
                    window.location.href = ur;
                }

            }

         },    

         error : function() {      

               alert("异常！");    

         }    

    });

}

function alert(msg){

    swal(msg);

}

// function showid(id){

// 	alert('sfaefwf');

// 	// $('#'+id).show();

// }

// function hideid(id){

// 	$('#'+id).hide();

// }