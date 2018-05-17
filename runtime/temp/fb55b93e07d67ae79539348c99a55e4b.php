<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"F:\WWW\tp5\public/../application/admin\view\index\LoginPage.html";i:1519817177;s:50:"F:\WWW\tp5\application\admin\view\base\header.html";i:1522059823;}*/ ?>
<!DOCTYPE html>
<html lang="cn">
<head>
    <!--连接jQuery文件-->
    <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
    <link rel="stylesheet" href="layui/css/layui.css"/>
    <script src="layui/layui.js" merge="true" type="text/javascript"></script>
    <script>
        layui.use('form', function(){
            var form = layui.form;
            //监听提交
            form.on('submit(formDemo)', function(data){
                //$("#content").val(layedit.getContent(index));
                //layer.msg(JSON.stringify(data.field));
            });
        });
        /* 预先加载 */
        layui.use('element', function(){
            var element = layui.element;
        });

        /* 图片上传 */
        layui.use('upload', function(){
            var upload = layui.upload;
            var jq = layui.jquery;
            //多图片上传
            upload.render({
                url: '<?php echo (isset($uolodImgs) && ($uolodImgs !== '')?$uolodImgs:''); ?>'
                ,elem:'#test2'
                ,ext: 'jpg|png|gif'
                ,size:1024 //1mb
                ,area: ['500', '500px']
                ,before: function(input){
                    loading = layer.load(2, {
                        shade: [0.2,'#000']
                    });
                }
                ,done: function(res){
                    layer.close(loading);
                    jq('input[name=img]').val(res.path);
                    //alert(res.path);
                    if(res.error!='full'){
                        /* 添加到预览 */
                        var img =$("<img src='"+res.data.src+"' height='20%' width='20%' alt=''/>");
                        var nbsp = $("<span>               </span>");
                        $("#demo2").append(img);
                        $("#demo2").append(nbsp);
                        img.src = ""+res.data.src;
                    }else{
                        layer.msg(res.alert);
                    }
                    //layer.msg(res.msg, {icon: 1, time: 1000});//弹窗信息
                }
            });

            /* 富文本编辑框 */

            layui.use('layedit', function(){
                var layedit = layui.layedit
                    ,$ = layui.jquery;

                /* 设置图片上传 */
                layedit.set({
                    uploadImage: {
                        url: '<?php echo (isset($textImg) && ($textImg !== '')?$textImg:''); ?>' //接口url
                        ,type: 'post' //默认post
                        ,field:"img"
                    }
                });

                layedit.build('demo'); //建立编辑器


                //构建一个默认的编辑器
                var index = layedit.build('LAY_demo1');

                //编辑器外部操作
                var active = {
                    content: function(){
                        alert(layedit.getContent(index)); //获取编辑器内容
                    }
                    ,text: function(){
                        alert(layedit.getText(index)); //获取编辑器纯文本内容
                    }
                    ,selection: function(){
                        alert(layedit.getSelection(index));
                    }
                };

                $('.site-demo-layedit').on('click', function(){
                    var type = $(this).data('type');
                    active[type] ? active[type].call(this) : '';
                });

                //自定义工具栏
                layedit.build('LAY_demo2', {
                    tool: ['face', 'link', 'unlink', '|', 'left', 'center', 'right']
                    ,height: 100
                })
            });
        });

        layui.use('layer', function(){ //独立版的layer无需执行这一句
        var $ = layui.jquery, layer = layui.layer;
        });//独立版的layer无需执行这一句

    </script>
    <script>
        /* 弹出窗口（提示信息和必应的） */
        layui.use('layer', function(){ //独立版的layer无需执行这一句
            var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
            //触发事件
            var active = {
                setTop: function(){
                    var that = this;
                    //多窗口模式，层叠置顶
                    layer.open({
                        type: 2 //此处以iframe举例
                        ,title: '必应一下'
                        ,area: ['1200px', '700px']
                        ,shade: 0
                        ,maxmin: true
                        ,offset: [ //为了演示，随机坐标
                            Math.random()*($(window).height()-300)
                            ,Math.random()*($(window).width()-390)
                        ]
                        ,content: 'https://cn.bing.com/'
                        ,btn: ['再开必应', '全部关闭'] //只是为了演示
                        ,yes: function(){
                            $(that).click();
                        }
                        ,btn2: function(){
                            layer.closeAll();
                        }

                        ,zIndex: layer.zIndex //重点1
                        ,success: function(layero){
                            layer.setTop(layero); //重点2
                        }
                    });
                }
                ,offset: function(othis){
                    var type = othis.data('type')
                            ,text = othis.text();
                    layer.open({
                        type: 1
                        ,offset: type //具体配置参考：http://www.layui.com/doc/modules/layer.html#offset
                        ,id: 'layerDemo'+type //防止重复弹出
                        ,content: '<div style="padding: 20px 100px;">'+ text +'</div>'
                        ,btn: '关闭'
                        ,btnAlign: 'c' //按钮居中
                        ,shade: 0 //不显示遮罩
                        ,yes: function(){
                            layer.closeAll("");
                        }
                    });
                }
            };

            /* 用于显示必应的 */
            $('#biying').on('click', function(){
                var othis = $(this), method = othis.data('method');
                active[method] ? active[method].call(this, othis) : '';
            });

            /* 用于显示提示信息的,$alertFlag=0才可以弹出,默认不允许弹出 */
            var $alertFlag = <?php echo (isset($alertFlag) && ($alertFlag !== '')?$alertFlag:'1'); ?>;
            if($alertFlag==0){
                var othis = $("#show"), method = othis.data('method');
                active[method] ? active[method].call(this, othis) : '';
                $alertFlag++;
            }

        });
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <button data-method="offset" data-type="auto" id="show" class="layui-btn layui-btn-normal" style="display: none;"><?php echo (isset($alert) && ($alert !== '')?$alert:'欢迎回来'); ?></button> <!—引入header.html-->
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="Flat Dark Web Login Form Responsive Templates, Iphone Widget Template, Smartphone login forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates" />
<link href="css/login.css" rel='stylesheet' type='text/css' />
<!--引入layui和jQuery-->
<!--<link rel="stylesheet" href="layui/css/layui.css"/>-->
<!--<script src="layui/layui.js" merge="true" type="text/javascript"></script>-->
<!--<script type="text/javascript" src="js/jquery-3.2.1.js"></script>-->
</head>
<body>
<script>$(document).ready(function(c) {
	$('.close').on('click', function(c){
		$('.login-form').fadeOut('slow', function(c){
	  		$('.login-form').remove();
		});
	});
});
</script>
 <!--SIGN UP-->
<div class="login-form">
	<div class="close"> </div>
		<div class="head-info">
			<label class="lbl-1"> </label>
			<label class="lbl-2"> </label>
			<label class="lbl-3"> </label>
		</div>
	<h1 style="color: #01AAED">欢迎回来，请登录</h1>
			<div class="clear"> </div>
	<div class="avtar">
		<img src="img/avtar.png" />
	</div>
		<script>
			/* 拦截表单并验证 */
			function form(){
				if($("#userName").val()==""){
					layer.msg('账号不能为空!');
					return false;
				}
				if($("#passWord").val()==""){
					layer.msg('密码不能为空!');
					return false;
				}
				return true;
			}
		</script>
		<form action="Login" method="post" id="form" onSubmit="return form();" >
			<input type="text" class="text" name="userName" id="userName"  placeholder="请输入账号">
			<div class="key">
				<input type="password" name="passWord" id="passWord" placeholder="请输入密码">
			</div>
			<div class="signin">
				<input type="submit" value="Login" >
			</div>
		</form>
	</div>
	<!--<div class="copy-rights">-->
		<!--<p>Copyright &copy; 2015.Company name All rights reserved.More Templates <a href="http://www.cssmoban.com/" target="_blank" title="ģ��֮��">ģ��֮��</a> - Collect from <a href="http://www.cssmoban.com/" title="��ҳģ��" target="_blank">��ҳģ��</a></p>-->
	<!--</div>-->
</body>
</html>