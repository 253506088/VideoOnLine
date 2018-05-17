<?php
    /**
     * 用于和数据库webinfo进行沟通的类
     * 2018年2月28日10:16:56
     * 贺东泽X黑白大彩电
     */
    namespace app\admin\module;
    use think\Model;
    class webinfo extends Model{
        /* 获取首页的配置数据 */
        function getWebInfo(){
            $where = function($query){
                $query->where("Id",1);
            };
            return $this->get($where);
        }

        function setWebInfo($Id="",$indexName="", $gameName="", $newsName="", $aboutAsName="", $joinUsName="",
                $weiXinUrl="", $weiBoLink="", $address="", $contactInfo="", $copyright="", $recordNum="",$logo=""){
            $where = function ($query) use($Id){
                $query->where("Id",$Id);
            };
            $data=[
                "indexName" =>$indexName,
                "gameName" =>$gameName,
                "newsName" =>$newsName,
                "aboutAsName" =>$aboutAsName,
                "joinUsName" =>$joinUsName,
                "weiXinUrl" =>$weiXinUrl,
                "weiBoLink" =>$weiBoLink,
                "address" =>$address,
                "contactInfo" =>$contactInfo,
                "copyright" =>$copyright,
                "recordNum" =>$recordNum,
                "logo" =>$logo
            ];
            return $this->isUpdate()->save($data,$where);
        }
    }
?>