<?php
    /**
     * 用于和数据库joinus进行沟通的类
     * 2018年3月2日12:05:28
     * 贺东泽X黑白大彩电
     */
    namespace app\admin\module;
    use think\Model;

    class joinus extends Model{
        /* 新增招聘信息 */
        public function addJoinUs($Position="", $Department="", $Nature="", $Number="", $Link="", $Salary=""){
            $data = [
                "Position"=>$Position,
                "Department"=>$Department,
                "Nature"=>$Nature,
                "Number"=>$Number,
                "Link"=>$Link,
                "Salary"=>$Salary,
                "Time"=>date("Y-m-d")
            ];
            return $this->save($data);//返回boolean类型
        }

        /* 删除招聘信息 */
        public function deleteJoinUs($Id){
            $buffer = $this->getJoinUsById($Id);
            return $buffer->delete();//返回影响行数
        }

        /* 修改招聘信息 */
        public function setJoinUs($Id,$Position="", $Department="", $Nature="", $Number="", $Link="", $Salary=""){
            $data = [
                "Id"=>$Id,
                "Position"=>$Position,
                "Department"=>$Department,
                "Nature"=>$Nature,
                "Number"=>$Number,
                "Link"=>$Link,
                "Salary"=>$Salary,
                "Time"=>date("Y-m-d")
            ];
            return $this->isUpdate()->save($data);//返回影响行数
        }

        /* 根据id查询招聘信息 */
        public function getJoinUsById($Id){
            $where = function($query) use($Id){
                $query->where("Id",$Id);
            };
            return $this->get($where);
        }

        /* 查询全部招聘信息 */
        public function getAllJoinUs(){
            return $this->all();
        }
    }
?>