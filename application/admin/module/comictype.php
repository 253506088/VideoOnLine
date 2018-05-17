<?php
    /**
     * 用于和comictype数据库表交互的类
     * User: java
     * Date: 2018/3/24
     * Time: 12:01
     */
    namespace app\admin\module;
    use think\Model;
    class comictype extends Model{
        /**
         * 设置自动类型转换，时间戳自动转换成时间
         */
        protected $type =[
            "gmt_create"=>"timestamp",
            "gmt_modified"=>"timestamp",
        ];

        /**
         * 新增动画类型
         */
        function addComicType($TypeName=""){
            $time = time();//获取时间戳
            $data = [
                "gmt_create" =>$time,
                "gmt_modified" =>$time,
                "is_deleted" =>0,
                "TypeName" => $TypeName
            ];
            return $this->save($data);//返回boolean类型
        }

        /**
         * 修改动画类型
         */
        function setComicType($TypeId="", $TypeName=""){
            $data = [
                "TypeId" => $TypeId,
                "TypeName" => $TypeName,
                "gmt_modified" => time()
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }

        /**
         * 设置动画类型是否被删除,1为删除，0为不删除
         */
        function setDeleteComicType($is_deleted=0,$TypeId=""){
            $data = [
                "TypeId" => $TypeId,
                "is_deleted" => $is_deleted,
                "gmt_modified" => time()
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }

        /**
         * 硬删除动画类型，不可恢复
         */
        public function deleteById($TypeId){
            $buffer = $this->getComicByTypeId($TypeId);
            return $buffer->delete();//返回影响行数
        }

        /**
         * 获取全部的动画类型
         */
        function getAllComic(){
            return $this->all();
        }

        /**
         * 获取全部is_deleted=0的类型
         */
        public function getNotDeleteAllComicType(){
            $where = function($query){
                $query->where("is_deleted",0);
            };
            return $this->all($where);
        }

        /**
         * 根据TypeId获取动画类型
         */
        function getComicByTypeId($TypeId=""){
            $where = function($query)use($TypeId){
                $query->where("TypeId",$TypeId);
            };
            return $this->get($where);
        }
    }
?>