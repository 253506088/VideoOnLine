<?php
/**
 * 用于处理有关番剧请求的类
 * User: java
 * Date: 2018/3/24
 * Time: 11:33
 */
    namespace app\admin\controller;
    use think\Session;
    use think\Controller;
    use app\admin\module;
    class Comic extends Controller{
        /**
         * 用于判断用户是否是正常访问
         * @param Request $request
         */
        protected $beforeActionList = [
            'befor' => '',//为空代表befor是当前类里全部方法的前置操作
        ];

        function befor(){
            /* 用于检测是否是正常访问 */
            $session = new Session();
            if ($session->get("userName") == null || $session->get("passWord") == null) {
                exit();//遇到非法访问直接停止
            }
        }

        /**
         * 新增动画类型页面
         */
        public function addComicTypePage(){
            $alertFlag = 1;
            $session = new Session();
            $alert = $session->get("alert");
            if($alert!=null){
                $alertFlag = 0;
                $session->delete("alert");
            }
            $this->assign([
                "form"=>"addComicType",
                "alert"=>$alert,
                "alertFlag"=>$alertFlag
            ]);
            return $this->fetch("Comic/ComicType");
        }

        /**
         * 新增动画类型处理方法
         */
        public function addComicType(){
            $ComicName = input("TypeName");
            if($ComicName!=null){
                $sql = new module\comictype();
                $alert="保存失败!";
                if($sql->addComicType($ComicName)){
                    $alert = "保存成功!";
                }
                $session = new Session();
                $session->set("alert",$alert);
                $this->redirect("admin/Comic/addComicTypePage");
            }
        }

        /**
         * 管理动画类型的页面
         */
        public function adminComicTypePage(){
            $alertFlag = 1;
            $session = new Session();
            $alert = $session->get("alert");
            if($alert!=null){
                $alertFlag = 0;
                $session->delete("alert");
            }
            $this->assign([
                "alertFlag"=>$alertFlag,
                "alert"=>$alert
            ]);
            return $this->fetch("Comic/AdminComicType");
        }

        /**
         * 为管理动画类型的页面提供数据的方法
         */
        public function comicTypeData(){
            $page = input("page");//获取当前页
            $listLen = input("limit");//获取每页显示的数据量
            $sql = new module\comictype();
            $form = 0;
            /* 如果当前页不是第一页那么计算form的值 */
            if($page>1){
                $form = ($page-1)*$listLen;
            }
            $buffers = $sql->limit($form,$form+$listLen)->select();
            $array = [
                "code"=>0 //0表示成功，其它失败
                ,"msg"=> $page."页" //提示信息 //一般上传失败后返回
                ,'count'=> count($sql->getAllComic()) //总数据量
                ,"data"=>  $buffers//本页要显示的数据
            ];
            return json($array);
        }

        /**
         * 修改动画类型的页面
         */
        public function modifiedComicTypeNamePage(){
            if(input("TypeId")!=null){
                $sql = new module\comictype();
                $Comic = $sql->getComicByTypeId(input("TypeId"));
                $this->assign([
                    "form"=>"modifiedComicTypeName",
                    "Comic"=>$Comic,
                ]);
                return $this->fetch("Comic/ComicType");
            }
        }

        /**
         * 修改动画类型的处理方法
         */
        public function modifiedComicTypeName(){
            if(input("TypeName")!=null && input("TypeId")!=null){
                $sql = new module\comictype();
                $alert="修改失败!";
                if($sql->setComicType(input("TypeId"),input("TypeName"))>0){
                    $alert = "修改成功!";
                }
                $session = new Session();
                $session->set("alert",$alert);
                $this->redirect("admin/Comic/adminComicTypePage");
            }
        }

        /**
         * 这里只是软删除
         * 用于处理删除或恢复动画类型的方法
         */
        public function setDeleteComicType(){
            $is_deleted = input("is_deleted");
            $TypeId = input("TypeId");
            if($is_deleted!=null && $TypeId!=null){
                $sql = new module\comictype();
                if($sql->setDeleteComicType($is_deleted,$TypeId)>0){
                    $this->setDeleteComic($TypeId,$is_deleted);
                    return "true";//成功
                }else{
                    return "false";
                }
            }
        }

        /**
         * 配合软删除的方法，用于软删除掉或恢复，xx类型的动漫
         */
        public function setDeleteComic($TypeId,$is_delted=0){
            $sql = new module\comic();
            $ComicList = $sql->getComicListByTypeId($TypeId);
            if($ComicList!=null&&count($ComicList)>0){
                foreach ($ComicList as $Comic){
                    $buffer = $sql->setDeleteComic($Comic->Id,$is_delted);
                }
            }
        }

        /**
         * 硬删除动画类型，不可恢复，不推荐！！！
         */
        public function deleteById(){
            if(input("TypeId")!=null){
                $sql = new module\comictype();
                if($sql->deleteById(input("TypeId"))>0){
                    return "true";//成功
                }else{
                    return "false";
                }
            }
        }

        /**************************上面的是动画类型相关代码，下面的是动画相关代码********************************/

        /**
         *  新增番剧的页面
         */
        public function addComicPage(){
            $alertFlag = 1;
            $session = new Session();
            $alert = $session->get("alert");
            if($alert!=null){
                $alertFlag = 0;
                $session->delete("alert");
            }
            $ComicType = new module\comictype();
            /* 不会删除已经成功上传的动漫和封面的,保存成功后会删除seesion里的动漫和封面的url */
            $this->delete();
            $this->assign([
                "form"=>"addComic",
                "ComicTypeList"=>$ComicType->getNotDeleteAllComicType(),
                "alert"=>$alert,
                "alertFlag"=>$alertFlag,
            ]);
            return $this->fetch("Comic/Comic");
        }

        /**
         * 新增番剧的处理方法
         */
        public function addComic(){
            $session = new Session();
            $sql = new module\comic();
            $alert = "请上传动漫封面与动漫本体!";
            /* 判断是否已经上传封面与动漫本体 */
            if($session->get("Video")!=null && $session->get("CoverImg")!=null){
                $ComicUrl= $session->get("Video");
                $ComicNumber= count($ComicUrl);
                $ComicName= input("ComicName");
                $ComicType= input("ComicType");
                $ImgUrl= $session->get("CoverImg");
                $ComicDetailed= input("ComicDescribe");
                /* 开始保存 */
                if($sql->addComic($ComicUrl,$ComicNumber,$ComicName,$ComicType,$ImgUrl,$ComicDetailed)){
                    $alert = "保存成功!";
                    /* 清空session */
                    $session->delete("Video");
                    $session->delete("CoverImg");
                }else{
                    $alert = "未知错误!!!请尽快联系程序猿!!!";
                    $this->delete();
                }
            }else{
                $this->delete();
            }
            $session->set("alert",$alert);
            $this->redirect("admin/Comic/addComicPage");
        }

        public function test(){
            dump(6%6);
        }


        /**
         * 用于接收动漫的方法
         */
        public function getCoverVideo(){
            $file = request()->file("file");
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'Upload' . DS . 'Video');//下载到pulic/static/Upload/Video
            if($info){
                $session = new Session();
                $ComicUrlList = array();
                if($session->get("Video")!=null){
                    $ComicUrlList = $session->get("Video");
                }
                $ComicUrlList[count($ComicUrlList)] = $info->getSaveName();
                $session->set("Video",$ComicUrlList);
                $array = [
                    "code"=>0 ,//0表示成功，其它失败
                    "msg"=> "上传成功" ,//提示信息 //一般上传失败后返回
                    "data"=> [
                        "src"=> $info->getSaveName(),
                        "title"=> "名称" //可选
                    ]
                ];
                return json($array);
            }else{
                $array = [
                    "code"=>1 ,//0表示成功，其它失败
                    "msg"=> "上传失败", //提示信息 //一般上传失败后返回
                    "data"=> [
                        "src"=> null,
                        "title"=> "名称" //可选
                    ]
                ];
                return json($array);
            }
        }

        /**
         * 管理动漫的页面
         */
        public function adminComicPage(){
            $alertFlag = 1;
            $session = new Session();
            $alert = $session->get("alert");
            if($alert!=null){
                $alertFlag = 0;
                $session->delete("alert");
            }
            $this->assign([
                "alertFlag"=>$alertFlag,
                "alert"=>$alert
            ]);
            return $this->fetch("Comic/AdminComic");
        }

        /**
         * 为管理动漫页面的数据表格提供数据的方法
         */
        public function comicData(){
            $page = input("page");//获取当前页
            $listLen = input("limit");//获取每页显示的数据量
            $sql = new module\comic();
            $comicType = new module\comictype();
            $typeList = $comicType->getAllComic();//获取类型列表
            $form = 0;
            /* 如果当前页不是第一页那么计算form的值 */
            if($page>1){
                $form = ($page-1)*$listLen;
            }
            $buffers = $sql->limit($form,$form+$listLen)->select();
            $list = array();
            foreach($buffers as $buffer){
                $buffer->ImgUrl = "<img src='static/Upload/Cover/$buffer->ImgUrl'>";
                foreach($typeList as $TypeBuffer){
                    if($TypeBuffer->TypeId==$buffer->ComicType){
                        $buffer->ComicType = $TypeBuffer->TypeName;
                        break;
                    }
                }
                $list[count($list)] = $buffer;
            }
            $array = [
                "code"=>0 //0表示成功，其它失败
                ,"msg"=> $page."页" //提示信息 //一般上传失败后返回
                ,'count'=> count($sql->getAllComic()) //总数据量
                ,"data"=>  $list//本页要显示的数据
            ];
            return json($array);
        }

        /**
         * 修改动漫内容的页面，只能修改动画类型、名称、详情描述、封面图片
         */
        public function modifiedComicPage(){
            if(input("Id")!=null){
                /* 不会删除已经成功上传的动漫和封面的,保存成功后会删除seesion里的动漫和封面的url */
                $this->delete();

                $alertFlag = 1;
                $session = new Session();
                $alert = $session->get("alert");
                if($alert!=null){
                    $alertFlag = 0;
                    $session->delete("alert");
                }

                $Comic = new module\comic();
                $Comic = $Comic->getComicById(input("Id"));
                $ComicType = new module\comictype();

                /* 开始对动漫类型进行排序，本动画所属的类型在第一位 */
                $ComicTypeList = array();
                $ComicTypeList[count($ComicTypeList)] = $ComicType->getComicByTypeId($Comic->ComicType);//第一位
                foreach($ComicType->getNotDeleteAllComicType() as $buffer){
                    if($buffer->TypeId!=$Comic->ComicType){
                        $ComicTypeList[count($ComicTypeList)] = $buffer;
                    }
                }

                /* 将现役封面的Url保存到Session里 */
                $session->set("CoverImg_old",$Comic->ImgUrl);
                /* 将图片的Url转换成<img>标签的src属性 */
                $img = "src='static/Upload/Cover/$Comic->ImgUrl'";

                $this->assign([
                    "form"=>"modifiedComic",
                    "ComicTypeList"=>$ComicTypeList,
                    "alert"=>$alert,
                    "alertFlag"=>$alertFlag,
                    "Comic"=>$Comic,
                    "img"=>$img
                ]);
                return $this->fetch("Comic/modifiedComic");
            }
        }

        /**
         * 修改动漫内容的处理方法，只能修改动画类型、名称、详情描述、封面图片
         */
        public function modifiedComic(){
            $session = new Session();
            $sql = new module\comic();
            $alert = "请上传动漫封面与动漫本体!";
            /* 判断是否已经上传封面与动漫本体 */
            if($session->get("CoverImg_old")!=null || $session->get("CoverImg")!=null){
                $ComicName= input("ComicName");
                $ComicType= input("ComicType");
                $Id = input("Id");
                $ImgUrl= $session->get("CoverImg_old");
                /* 如果修改了图片，那么就用修改后的url */
                if($session->get("CoverImg")!=null){
                    $ImgUrl = $session->get("CoverImg");
                    /* 删除旧封面 */
                    unlink(ROOT_PATH."public\\static\\Upload\\Cover\\".$session->get("CoverImg_old"));
                    $session->delete("CoverImg_old");
                }
                $ComicDetailed= input("ComicDescribe");
                /* 开始修改 */
                if($sql->modifiedComic($Id,$ComicName,$ComicType,$ImgUrl,$ComicDetailed)>0){
                    $alert = "修改成功!";
                    /* 清空session */
                    $session->delete("Video");
                    $session->delete("CoverImg");
                }else{
                    $alert = "未知错误!!!请尽快联系程序猿!!!";
                    $this->delete();
                    $session->delete("CoverImg_old");
                }
            }else{
                $this->delete();
            }
            $session->set("alert",$alert);
            $this->redirect("admin/Comic/adminComicPage");//跳转到管理动漫页面
        }

        /**
         * 禁用/启用某动画的处理方法
         */
        public function setComicIs_deleted(){
            $is_deleted = input("is_deleted");
            $Id = input("Id");
            if($is_deleted!=null && $Id!=null){
                /* 先判断一下该动漫的类型是否被禁用 */
                $sql = new module\comic();
                $comicType = new module\comictype();
                $comic = $sql->getComicById($Id);
                $comicType = $comicType->getComicByTypeId($comic->ComicType);
                if($comicType->is_deleted==0){
                    /* 类型没有被禁用，允许对动画的is_deleted进行操作 */
                    if($sql->setDeleteComic($Id,$is_deleted)>0){
                        return "true";//成功
                    }else{
                        return "false";
                    }
                }else{
                    /* 类型被禁用，禁止对动画的is_deleted进行操作 */
                    return "-1";
                }
            }
        }

        /**
         * 硬删除该动漫的方法，不建议使用!!
         */
        public function deleteComic(){
            $Id = input("Id");
            if($Id!=null){
                $sql = new module\comic();
                $comic = $sql->getComicById($Id);
                /* 删除封面 */
                if($comic->ImgUrl!=null){
                    unlink(ROOT_PATH."public\\static\\Upload\\Cover\\".$comic->ImgUrl);
                }
                /* 删除动漫 */
                if($comic->ComicUrl!=null){
                    foreach($comic->ComicUrl as $comicUrl){
                        unlink(ROOT_PATH."public\\static\\Upload\\Video\\".$comicUrl);
                    }
                }
                /* 删除数据表中的该行数据 */
                if($sql->deleteById($Id)>0){
                    return "true";
                }else{
                    return "false";
                }
            }
        }

        /**
         * 单元表格修改内容的调度方法
         */
        public function unitTableModified(){
            $field = input("field");//要修改的字段
            $Id = input("Id");//Id
            $value = input("value");//旧值
            $sql = new module\comic();
            /* 根据要修改的字段来调度相应的方法 */
            if("ComicName"==$field){
                return $this->modifiedComicName($Id,$value,$sql);
            }else{
                /* 因为只有两个字段有单元表格的修改权限，所以直接用else */
                return $this->modifiedComicDetailed($Id,$value,$sql);
            }
        }

        /**
         * 单元表格修改动画详情的处理方法
         */
        public function modifiedComicDetailed($Id,$ComicDetailed,$sql){
            if($Id!=null && $ComicDetailed!=null){
                if($sql->modifiedComicDetailedById($Id,$ComicDetailed)>0){
                    return "true";
                }else{
                    return "false";
                }
            }
        }

        /**
         * 单元表格修改动画名称的处理方法
         */
        public function modifiedComicName($Id,$ComicName,$sql){
            if($Id!=null&&$ComicName!=null){
                if($sql->modifiedComicNameById($Id,$ComicName)>0){
                    return "true";
                }else{
                    return "false";
                }
            }
        }

        /**
         * 用于接收封面图的方法
         */
        public function getCoverImg(){
            $file = request()->file("file");
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'Upload' . DS . 'Cover');//下载到pulic/static/Upload/Cover
            if($info){
                $session = new Session();
                /* 删除已经存上传在服务器待命的图片 */
                if($session->get("CoverImg")!=null){
                    unlink(ROOT_PATH."public\\static\\Upload\\Cover\\".$session->get("CoverImg"));
                    $session->delete("CoverImg");
                }
                $session->set("CoverImg",$info->getSaveName());
                    $array = [
                    "code"=>0 //0表示成功，其它失败
                    ,"msg"=> "上传成功" //提示信息 //一般上传失败后返回
                    ,"data"=> [
                        "src"=> $info->getSaveName()
                        ,"title"=> "图片名称" //可选
                    ]
                ];
                return json($array);
            }else{
                $array = [
                    "code"=>1 //0表示成功，其它失败
                    ,"msg"=> "上传失败" //提示信息 //一般上传失败后返回
                    ,"data"=> [
                        "src"=> null
                        ,"title"=> "图片名称" //可选
                    ]
                ];
                return json($array);
            }
        }

        /**
         * 用于删除session里不用的封面与动漫
         */
        public function delete(){
            $session = new Session();
            /* 先删除图片 */
            if($session->get("CoverImg")!=null){
                unlink(ROOT_PATH."public\\static\\Upload\\Cover\\".$session->get("CoverImg"));
                $session->delete("CoverImg");
            }
            /* 再删除动漫 */
            if($session->get("Video")!=null){
                foreach ($session->get("Video") as $buffer){
                    unlink(ROOT_PATH."public\\static\\Upload\\Video\\".$buffer);
                }
                $session->delete("Video");
            }
        }
    }
?>