<?php
    /**
     * 用于和数据库news进行沟通的类
     * 2018年3月1日16:11:24
     * 贺东泽X黑白大彩电
     */
    namespace app\admin\module;
    use think\Model;

    class news extends Model
    {
        /* 新增新闻 */
        public function addNews($Name, $Content, $ImgUrl)
        {
            $data = [
                "Name" => $Name,
                "Content" => $Content,
                "ImgUrl" => $ImgUrl,
                "Time" =>date("Y-m-d"),
            ];
            return $this->save($data);//返回一个boolean类型
        }

        /* 修改新闻 */
        public function setNews($Id, $Name, $Content, $ImgUrl)
        {
            $data = [
                "Id" => $Id,
                "Name" => $Name,
                "Content" => $Content,
                "ImgUrl" => $ImgUrl,
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }

        /* 根据id删除新闻 */
        public function deleteNewsById($Id)
        {
            $buffer = $this->getNewsById($Id);
            return $buffer->delete();//返回影响行数
        }

        /* 根据Id查找新闻 */
        public function getNewsById($Id)
        {
            $where = function ($query) use($Id){
                $query->where("Id",$Id);
            };
            return $this->get($where);
        }

        /* 获取全部的新闻列表 */
        public function getAllNews()
        {
            return $this->all();
        }

        /* 获取首页上展示的最多5个新闻 */
        public function getIndexNews(){
            $buffer = $this->getAllNews();
            $newsList = array();
            /* 大于5条的话取出最新的5条，小于5条的话取出全部 */
            if(count($buffer)>5){
                for($i=(count($buffer)-5);$i<count($buffer);$i++){
                    $newsList[count($newsList)] = $buffer[$i];
                }
            }else if(count($buffer)<5){
                $newsList = $buffer;
            }
            return $newsList;
        }
    }
?>