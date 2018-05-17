<?php
    /*
     * 负责后台用户登录的类
     *2018年2月27日16:34:08
     * 贺东泽X黑白大彩电
     * */
    namespace app\admin\module;
    use think\Model;
    class rootuser extends Model{
        /* 登陆确认账号密码是否正确 */
        function login($userName,$passWord){
            $where = function($query) use($userName,$passWord){
                $query->where([
                    'userName'=>$userName,
                    'passWord'=>$passWord
                ]);
            };
            /* 判断一下账号密码是否正确 */
            $rootUser = $this->get($where);
            if($rootUser==null){
                return false;
            }else{
                return true;
            }
        }
    }
?>