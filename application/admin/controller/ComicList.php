<?php
    /**
     * Created by PhpStorm.
     * User: java
     * Date: 2018/3/31
     * Time: 11:58
     */
    namespace app\admin\controller;
    use app\admin\module;
    use think\Session;
    use think\Controller;
    class ComicList extends Controller{
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
         * 动漫列表首页
         */
        function comicListIndex(){

            $sql = new module\comic();
            $ComicType = new module\comictype();
            /* 第一个参数是每一页显示的数据量，第二个参数是总数据量，分多少页会自动算 */
            $buffers = $sql->paginate((3*6),count($sql->getAllComic()));
            $this->assign([
                'ComicList' =>$buffers,//分页的数据
                'page' =>input("page"),//当前页
                "ComicTypeList"=>$ComicType->getNotDeleteAllComicType(),
                "ComicNumber"=>count($sql->getNotDeleteAllComic()),
            ]);
            return $this->fetch("ComicList/comicListIndex");
        }

        /**
         * 播放页面
         */
        public function playPage(){
            if(input("Id")!=null){
                $p=0;
                if(input("p")!=null){
                    $p = input("p");//获取当前分P
                }
                $sql = new module\comic();
                $Comic = $sql->getComicById(input("Id"));

                $pageList = array();
                for($i=0;$i<count($Comic->ComicUrl);$i++){
                    $buffer = "";
                    if($i==$p){
                        $buffer = "<span class=\"layui-laypage-curr\"><em class=\"layui-laypage-em\"></em><em>".($i+1)."</em></span>";
                    }else{
                        $buffer = "<a href='javascript:;'"."onclick= \"newWindow('playPage?Id=".$Comic->Id."&p=".$i."')\"".">".($i+1)."</a>";
                    }
                    $pageList[count($pageList)] = $buffer;
                }
                $this->assign([
                    "ComicUrl"=>$Comic->ComicUrl[$p],
                    "Comic"=>$Comic,
                    "pageList"=>$pageList,
                ]);
                return $this->fetch("ComicList/play");
            }
        }
    }
?>