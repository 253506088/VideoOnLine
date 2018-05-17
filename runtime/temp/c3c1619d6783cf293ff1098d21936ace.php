<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"F:\WWW\tp5\public/../application/admin\view\Comic\AdminComic.html";i:1522468089;s:50:"F:\WWW\tp5\application\admin\view\base\header.html";i:1522059823;}*/ ?>
<!-- 管理动画 -->
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
<title>管理动画</title>
</head>

<body id="body">
<!-- 内容主体区域 -->
<blockquote class="layui-elem-quote">管理动画信息&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: #cc0033">注意 :不推荐使用硬删除!!若要禁用某一个动漫推荐使用禁用!</span></blockquote>
<table class="layui-table" lay-filter="demo" lay-data="{
                        width: 1500,
                        height:'full-30',
                        url:'comicData',//数据源
                        page:true,//开启分页
                        id:'idTest',//本表的id
                        limit:17,//一页的数据量
                        done: function(res, curr, count){
                        //如果是异步请求数据方式，res即为你接口返回的信息。
                        //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
                        console.log(res);

                        //得到当前页码
                        console.log(curr);

                        //得到数据总量
                        console.log(count);
                      }
                    }">
    <thead>
    <tr>
        <th lay-data="{field:'Id', width:70, sort: true, fixed: true}">Id</th>
        <th lay-data="{field:'ComicName',edit:'text',width:150}">动漫名称</th>
        <th lay-data="{field:'ComicType', width:150}">所属类型</th>
        <th lay-data="{field:'ImgUrl', width:130}">封面图片</th>
        <th lay-data="{field:'ComicDetailed',edit:'text', width:260}">动漫详情</th>
        <th lay-data="{field:'ComicNumber', width:100}">动漫集数</th>
        <th lay-data="{field:'gmt_create', width:200, sort: true}">创建时间</th>
        <th lay-data="{field:'gmt_modified', width:200, sort: true}">最近修改时间</th>
        <th lay-data="{field:'is_deleted', width:100 ,templet: '#switchTpl', unresize: true}">是否启用</th>
        <th lay-data="{fixed: 'right', width:130, align:'center', toolbar: '#barDemo'}">操作</th>
    </tr>
    </thead>
</table>

<script type="text/html" id="barDemo">
    <!--<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>-->
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/html" id="switchTpl">
    <!-- {{d.TypeId}}用来获取本列的TypeId   {{ d.is_deleted == 0 ? 'checked' : '' }}根据is_deleted来设置单选项的状态 -->
    <input type="checkbox" name="sex" value="{{d.Id}}"  lay-skin="switch" lay-text="禁用|启用" lay-filter="delete" {{ d.is_deleted == 0 ? 'checked' : '' }}>
</script>


<script>
    /* 返回ajax对象 */
    function getAJAX(){
        if (window.XMLHttpRequest) {
            // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
            return new XMLHttpRequest();
        }
        else {
            // IE6, IE5 浏览器执行代码
            return new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    /* 数据表的js */
    layui.use('table', function(){
        var table = layui.table;
        var form = layui.form;
        //监听表格复选框选择
        table.on('checkbox(demo)', function(obj){
            //console.log(obj)//输出选择信息
        });

        //监听单元格编辑，设置了edit属性的行才可以进行单元格编辑
        table.on('edit(demo)', function(obj){
            var value = obj.value;//得到修改后的值
            var data = obj.data;//得到所在行所有键值
            var field = obj.field; //得到被修改的字段名
//            layer.msg('[ID: '+ data.Id +'] ' + field + ' 字段更改为：'+ value);
            var xmlhttp = getAJAX();
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    /* 发送成功之后的提示信息 */
                    if(xmlhttp.responseText=="true"){
                        layer.msg("操作成功!");
                    }else{
                        layer.msg("未知错误!");
                    }
                }
            }
            /* 选择POST模式发送ID */
            xmlhttp.open("POST","unitTableModified",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("value="+value+"&Id="+data.Id+"&field="+field);
        });

        //监听删除操作，需要加载form模块
        form.on('switch(delete)', function(obj){
            /* 根据单选框的值来传改变is_deleted的值 */
            var is_deleted;
            if(obj.elem.checked){
                /* 启用 */
                is_deleted = 0;
            }else{
                /* 停用 */
                is_deleted = 1;
            }
            var Id = obj.value;//获取该列的Id

            var xmlhttp = getAJAX();

            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    /* 发送成功之后的提示信息 */
                    if(xmlhttp.responseText=="true"){
                        layer.msg("操作成功!");
                    }else if(xmlhttp.responseText=="-1"){
                        layer.msg("该动漫的类型已被禁用!本次操作无效!");
                        obj.elem.checked = true;//禁止复选框的操作，但是貌似有点问题，多点几下就知道问题是什么了
                    }else{
                        layer.msg("未知错误!");
                    }
                }
            }
            /* 选择POST模式发送ID */
            xmlhttp.open("POST","setComicIs_deleted",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("is_deleted="+is_deleted+"&Id="+Id);
        });



        //监听工具条
        table.on('tool(demo)', function(obj){
            var data = obj.data;
            if(obj.event === 'detail'){
                layer.msg('ID：'+ data.id + ' 的查看操作');
            } else if(obj.event === 'del'){
                /* 删除游戏信息 */
                layer.confirm('真的删除吗?删除后将无法恢复!', function(index){
                    var xmlhttp = getAJAX();
                    xmlhttp.onreadystatechange=function(){
                        if (xmlhttp.readyState==4 && xmlhttp.status==200)
                        {
                            /* 发送成功之后的提示信息 */
                            if(xmlhttp.responseText=="true"){
                                layer.msg("操作成功!");
                                obj.del();
                            }else{
                                layer.msg("未知错误!");
                            }
                        }
                    }
                    /* 选择POST模式发送ID */
                    xmlhttp.open("POST","deleteComic",true);
                    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    xmlhttp.send("Id="+JSON.stringify(data.Id));
                    layer.close(index);
                });
            } else if(obj.event === 'edit'){
                /* 修改动画内容 */
                window.location.href="modifiedComicPage?Id="+JSON.stringify(data.Id);
            }
        });

        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</div>
</body>
</html>