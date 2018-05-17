<?php
    /**
     * 用于和数据库aboutas进行沟通的类
     * 2018年3月2日12:05:28
     * 贺东泽X黑白大彩电
     */
    namespace app\admin\module;
    use think\Model;

    class aboutas extends Model{
        /* 获取【关于我们】信息对象 */
        function getAboutAs(){
            $where = function ($query){
                $query->where("Id","aboutas");
            };
            return $this->get($where);
        }

        /* 修改【关于我们】信息 */
        function setAboutAs($ImgUrl,$Content){
            $data = [
                "Id" =>"aboutas",
                "ImgUrl" =>$ImgUrl,
                "Content" =>$Content,
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }
    }
?>