<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>jQuery图像照片剪裁插件Jcrop</title>
        <link rel="stylesheet" href="/storeshop3/Public/jcrop_zh/css/common.css" type="text/css" />
        <link rel="stylesheet" href="/storeshop3/Public/jcrop_zh/css/jquery.Jcrop.css" type="text/css" />
        <script type="text/javascript" src="/storeshop3/Public/jcrop_zh/js/jquery-1.3.2-min.js"></script>
        <script type="text/javascript" src="/storeshop3/Public/jcrop_zh/js/jquery.Jcrop.js"></script>
        <script type="text/javascript">
            //定义全局变量
            var cx=0,cy=0,cw=0,ch=0,cname="";
            //执行上传后的图片处理
            function doShow(picname){
                //判断图片是否上传成功
                if(picname=="false"){
                    alert("图片上传失败");
                }else{
                    cname=picname;
                    //显示图片
                    $("<img src='/storeshop3/Public/Uploads/"+picname+"'/>").appendTo("#did").Jcrop({onChange:showCoords,onSelect:showCoords});	
                }
            }
            
            //简单的事件处理程序，响应自onChange,onSelect事件，按照上面的Jcrop调用
            function showCoords(obj){
                cx = obj.x;
                cy = obj.y;
                cw = obj.w;
                ch = obj.h;
            }
            
            //确认裁剪
            function doJcrop(){
               $.ajax({
					url:"/storeshop3/index.php/Home/Jcrop/doCrop",
					type:"post",
					data:{picname:cname,cx:cx,cy:cy,cw:cw,ch:ch},
					dataType:'text',
					success:function(){
						$("#did").empty();//清空
						$("<img src='/storeshop3/Public/Uploads/"+cname+"?id="+Math.random()+"'/>").Jcrop({onChange:showCoords,onSelect:showCoords}).appendTo("#did");	//放裁剪后的值到did中
					}
				});
            }
        </script>
    </head>
    <body>
        <h2>图片无刷新上传和在线裁剪</h2>
        <iframe name="myframe" frameborder="0" style="display:none;"></iframe>
        <form action="/storeshop3/index.php/Home/Jcrop/upload" target="myframe" enctype="multipart/form-data" method="post" >
            图片：<input type="file" name="photo" />
            <input type="submit" value="上传" >
        </form>
        <div id="did"></div>
        <button onclick="doJcrop()">确认裁剪</button>
    </body>
</html>