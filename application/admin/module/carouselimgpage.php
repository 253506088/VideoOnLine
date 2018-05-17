<?php
    /**
     * 用于和数据库carouselimg进行沟通的类
     * 2018年2月28日13:56:06
     * 贺东泽X黑白大彩电
     */
    namespace app\admin\module;
    use think\Model;

    class carouselimgpage extends Model{
        /* 获取全部需要设置轮播图的页面对象 */
        function getAll(){
            return $this->all();
        }

        /* 根据id获取需要设置轮播图的页面对象 */
        function getPageById($pageId){
            $where = function($query) use($pageId){
                $query->where("pageId",$pageId);
            };
            return $this->get($where);
        }
    }
?>