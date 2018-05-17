<?php
    /**
     * 负责后台用户登录的类
     * 2018年2月27日16:34:08
     * 贺东泽X黑白大彩电
     * */
    namespace app\admin\controller;
    use think\Controller;
    use app\admin\module;
    use think\Session;

    class Login extends Controller{
        /* 用于显示登录页面 */
        function LoginPage(){
            return $this->fetch("index/LoginPage");
        }

        /* 用于验证登陆 */
        function Login(){
            $userName = input("userName");
            $passWord = md5(input("passWord"));//md5加密一下
            $rootUser = new module\rootuser();

            /* 进行登录验证 */
            if($rootUser->login($userName,$passWord)){
                $session = new Session();
                session_start();//初始化session
                /* 判断一下防止重复插入 */
                if($session->get("userName")==null && $session->get("passWord")==null){
                    /* 添加session信息 */
                    $session->set("userName",$userName);
                    $session->set("passWord",$passWord);
                    $session->set("alert","欢迎回来~");
                    $session->set("alertFlag",0);
                }
                $this->redirect("admin/Login/adminIndex");//打印后台首页
            }else{
                $this->redirect("admin/Login/LoginPage");//返回登录页
            }
        }

        /* 后台首页 */
        function adminIndex(){
            $session = new Session();
            /* 判断是否是非法访问 */
            if($session->get("userName")!=null && $session->get("passWord")!=null){
                $this->assign([
                    "alert" =>$session->get("alert"),
                    "alertFlag" =>$session->get("alertFlag")
                ]);
                /* 删除提示信息，防止重复提示 */
                $session->delete("alert");
                $session->delete("alertFlag");
                return $this->fetch("index/admin");
            }else{
                $this->redirect("admin/Login/LoginPage");//如果是非正常手段访问后台首页，直接遣送回登陆页面
            }
        }

        /* 退出登录 */
        function logout(){
            $session = new Session();
            session_start();//初始化session
            $session->destroy();//销毁session
            $this->redirect("admin/Login/LoginPage");//返回登录页
        }
    }
?>