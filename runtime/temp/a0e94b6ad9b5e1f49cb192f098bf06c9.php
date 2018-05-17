<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"F:\WWW\tp5\public/../application/admin\view\Comic\Comic.html";i:1522466432;s:50:"F:\WWW\tp5\application\admin\view\base\header.html";i:1522059823;}*/ ?>
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
    <button data-method="offset" data-type="auto" id="show" class="layui-btn layui-btn-normal" style="display: none;"><?php echo (isset($alert) && ($alert !== '')?$alert:'欢迎回来'); ?></button><!--引入网站头部-->
<title>新增动漫</title>
</head>

<body id="body">
<div class="layui-layout layui-layout-admin">
    <blockquote class="layui-elem-quote">设置动画</blockquote>
    <div class="site-demo-button" id="layerDemo" style="margin-bottom: 0;">
        <form action="<?php echo (isset($form) && ($form !== '')?$form:''); ?>" enctype="multipart/form-data" method="post" id="form1" class="layui-form">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend>请输入动画名称</legend>
            </fieldset>
            <div class="layui-form-item layui-form-pane">
                <label class="layui-form-label ">信息名称:</label>
                <div class="layui-input-block">
                    <input type="text" id="Name" value="<?php echo (isset($Comic['ComicName']) && ($Comic['ComicName'] !== '')?$Comic['ComicName']:''); ?>" name="ComicName" required  lay-verify="required" placeholder="请输动画名称" autocomplete="off" class="layui-input">
                </div>
            </div>

            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend>请选择动画类型</legend>
            </fieldset>
            <div class="layui-inline layui-form-pane">
                <label class="layui-form-label">动画类型:</label>
                <div class="layui-input-inline">
                    <select name="ComicType" lay-verify="required" lay-search="">
                        <?php if(is_array($ComicTypeList) || $ComicTypeList instanceof \think\Collection || $ComicTypeList instanceof \think\Paginator): $i = 0; $__LIST__ = $ComicTypeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['TypeId']; ?>"><?php echo $vo['TypeName']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>

            <!--图片上传,上传的js脚本在本页面最下面-->
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend>请上传封面图,最大2Mb</legend>
            </fieldset>
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="test1">上传图片</button>
                <div class="layui-upload-list">
                    <img class="layui-upload-img" <?php echo (isset($img) && ($img !== '')?$img:''); ?> id="demo1" style="width: 480px;height: 270px">
                    <p id="demoText"></p>
                </div>
            </div>


            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend>上传动画，只支持MP4</legend>
            </fieldset>

            <div class="layui-upload">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>大小</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="demoList"></tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn layui-btn-normal" id="testList">选择动画</button>
                <button type="button" class="layui-btn" id="testListAction">开始上传</button>
            </div>

            <!-- 普通文本域 -->
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend>请输入动画详情:</legend>
            </fieldset>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label ">信息详情:</label>
                <div class="layui-input-block">
                    <textarea name="ComicDescribe" placeholder="请输入动画详情" class="layui-textarea"><?php echo (isset($Comic['ComicDescribe']) && ($Comic['ComicDescribe'] !== '')?$Comic['ComicDescribe']:''); ?></textarea>
                </div>
            </div>


            <!--id-->
            <input type="hidden" name="id" value="<?php echo (isset($Comic['Id']) && ($Comic['Id'] !== '')?$Comic['Id']:''); ?>">

            <!--提交按钮-->
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
</body>
<script>
    layui.use('upload', function(){
        var $ = layui.jquery
                ,upload = layui.upload;

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            ,url: 'getCoverImg'
            ,accept: 'images'
            ,exts:'jpg|png|gif|bmp|jpeg'
            ,size:2*1024 //2mb
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                //如果上传失败
                if(res.code > 0){
                    return layer.msg('上传失败');
                }
                //上传成功
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });
    });
</script>
<script>
    layui.use('upload', function(){
        var $ = layui.jquery
                ,upload = layui.upload;
        //多文件列表示例
        var demoListView = $('#demoList')
                ,uploadListIns = upload.render({
            elem: '#testList'
            ,url: 'getCoverVideo'
           ,accept: 'video'//只允许上传视频
            ,accept: 'file'//只允许上传视频
           ,exts:'mp4'
            ,multiple: true
            ,auto: false
            ,bindAction: '#testListAction'
            ,choose: function(obj){
                var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function(index, file, result){
                    var tr = $(['<tr id="upload-'+ index +'">'
                        ,'<td>'+ file.name +'</td>'
                        ,'<td>'+ (file.size/1024).toFixed(1) +'kb</td>'
                        ,'<td>等待上传</td>'
                        ,'<td>'
                        ,'<button class="layui-btn layui-btn-mini demo-reload layui-hide">重传</button>'
                        ,'<button class="layui-btn layui-btn-mini layui-btn-danger demo-delete">删除</button>'
                        ,'</td>'
                        ,'</tr>'].join(''));

                    //单个重传
                    tr.find('.demo-reload').on('click', function(){
                        obj.upload(index, file);
                    });

                    //删除
                    tr.find('.demo-delete').on('click', function(){
                        delete files[index]; //删除对应的文件
                        tr.remove();
                        uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });

                    demoListView.append(tr);
                });
            }
            ,done: function(res, index, upload){
                if(res.code == 0){ //上传成功
                    var tr = demoListView.find('tr#upload-'+ index)
                            ,tds = tr.children();
                    tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(3).html(''); //清空操作
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView.find('tr#upload-'+ index)
                        ,tds = tr.children();
                tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });
    });
</script>
</html>