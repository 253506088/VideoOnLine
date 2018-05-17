<?php
    /**
     * 用于和数据库carouselimg进行沟通的类
     * 2018年2月28日13:56:06
     * 贺东泽X黑白大彩电
     */
    namespace app\admin\module;
    use think\Model;

    class carouselimg extends Model{
        /* 根据id获取轮播图对象 */
        function getCarouselImgById($Id){
            $where = function ($query) use($Id){
                $query->where("Id",$Id);
            };
            return $this->get($where);
        }

        /* 添加滚动图 */
        function addCarouselImg($PageId,$PageName,$Url,$Link){
            $data=[
                "PageId"=>$PageId,
                "PageName"=>$PageName,
                "Url"=>$Url,
                "Link"=>$Link
            ];
            return $this->save($data);
        }

        /* 修改轮播图 */
        function modifyCarouselimg($Id,$PageId,$PageName,$Url,$Link){
            $data=[
                "Id"=>$Id,
                "PageId"=>$PageId,
                "PageName"=>$PageName,
                "Url"=>$Url,
                "Link"=>$Link
            ];
            return $this->isUpdate()->save($data);
        }

        /* 根据Id删除轮播图 */
        function deleteCarouselImgById($Id){
            $buffer = $this->getCarouselImgById($Id);
            return $buffer->delete();
        }

        /* 获取全部的轮播图对象 */
        function getAllCarouselImg(){
            return $this->all();
        }

        /* 根据pageId获取轮播图对象集合 */
        function getCarouselImgByPageId($PageId){
            $where = function($query) use($PageId){
                $query->where("PageId",$PageId);
            };
            return $this->all($where);
        }
    }
?>