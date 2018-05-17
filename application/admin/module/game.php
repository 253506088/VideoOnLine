<?php
    /**
     * 用于和数据库game进行沟通的类
     * 2018年3月1日10:45:58
     * 贺东泽X黑白大彩电
     */
    namespace app\admin\module;
    use think\Model;

    class game extends Model{
        /* 保存游戏信息 */
        function addGame($Name,$Describe,$Link,$Url){
            $data = [
                "Name" =>$Name,
                "Describe" =>$Describe,
                "Link" =>$Link,
                "Url" =>$Url,
            ];
            return $this->save($data);//返回boolean类型
        }

        /* 修改游戏信息 */
        function setGame($Id,$Name,$Describe,$Link,$Url){
            $data = [
                "Id"=>$Id,
                "Name" =>$Name,
                "Describe" =>$Describe,
                "Link" =>$Link,
                "Url" =>$Url,
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }

        /* 根据id查询游戏信息 */
        function getGameById($Id){
            $where = function($query) use($Id){
                $query->where("Id",$Id);
            };
            return $this->get($where);
        }

        /* 根据id删除游戏信息 */
        function deleteGameById($Id){
            $buffer = $this->getGameById($Id);
            return $buffer->delete();//返回影响行数
        }

        /* 获取全部游戏信息 */
        function getAllGame(){
            return $this->all();
        }

    }
?>