<?php
    /**
     * 用于和comic数据库表进行交互的类
     * User: aaaq4
     * Date: 2018/3/29
     * Time: 16:16
     */
    namespace app\admin\module;
    use think\Model;
    class comic extends Model{
        /**
         * 设置自动类型转换，时间戳自动转换为时间,json转换成array
         */
        protected $type= [
            "gmt_create"=>"timestamp",
            "gmt_modified"=>"timestamp",
            "ComicUrl"=>"array",
        ];

        /**
         * 新增动画,自动将$ComicUrl数组转换为JSON字符串
         * ComicType是否存在由控制器来负责确认
         */
        public function addComic($ComicUrl="", $ComicNumber="",
            $ComicName="", $ComicType="", $ImgUrl="", $ComicDetailed=""){
            $time = time();//获取当前时间戳
            $data = [
                "gmt_create"  => $time,
                "gmt_modified" => $time,
                "is_deleted" => 0,
                "ComicUrl" => $ComicUrl,//自动转换为json
                "ComicNumber" => $ComicNumber,
                "ComicName" => $ComicName,
                "ComicType" => $ComicType,
                "ImgUrl" => $ImgUrl,
                "ComicDetailed" => $ComicDetailed
            ];
            return $this->save($data);//返回boolean类型
        }

        /**
         * 修改动画,只能修改动画类型、名称、详情描述、封面图片
         */
        public function modifiedComic($Id="", $ComicName="",
              $ComicType="", $ImgUrl="", $ComicDetailed=""){
            $data = [
                "Id" => $Id,
                "gmt_modified" => time(),
                "ComicName" => $ComicName,
                "ComicType" => $ComicType,
                "ImgUrl" => $ImgUrl,
                "ComicDetailed" => $ComicDetailed,
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }

        /**
         * 设置动画是否被删除，1为删除，0为不删除
         */
        public function setDeleteComic($Id,$is_deleted=0){
            $data = [
                "Id" => $Id,
                "is_deleted" => $is_deleted,
                "gmt_modified" => time()
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }

        /**
         * 硬删除动画，不可恢复。不推荐使用!!!!
         */
        public function deleteById($Id){
            $buffer = $this->getComicById($Id);
            return $buffer->delete();//返回影响行数
        }

        /**
         * 根据Id获取动画
         */
        public function getComicById($Id){
            $where = function($query) use($Id){
                $query->where("Id",$Id);
            };
            return $this->get($where);
        }

        /**
         * 获取全部动画
         */
        public function getAllComic(){
            return $this->all();
        }

        /**
         * 获取全部is_deleted=0的类型
         */
        public function getNotDeleteAllComic(){
            $where = function($query){
                $query->where("is_deleted",0);
            };
            return $this->all($where);
        }
        /**
         * 获取全部类型为XXX的Comic
         */
        public function getComicListByTypeId($TypeId){
            $where = function($query)use($TypeId){
                $query->where("ComicType",$TypeId);
            };
            return $this->all($where);
        }

        /**
         * 根据Id修改动漫名称的方法
         */
        public function modifiedComicNameById($Id,$ComicName){
            $data = [
                "Id"=>$Id,
                "ComicName"=>$ComicName,
                "gmt_modified"=>time(),
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }

        /**
         * 根据Id修改动漫详情的方法
         */
        public function modifiedComicDetailedById($Id,$ComicDetailed){
            $data = [
                "Id"=>$Id,
                "ComicDetailed"=>$ComicDetailed,
                "gmt_modified"=>time(),
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }
    }
?>