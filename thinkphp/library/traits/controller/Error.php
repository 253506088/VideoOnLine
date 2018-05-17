<?php
    namespace traits\controller;
    trait Error{
        public function _empty($method){
            return "您访问的".$method."页面不存在";
        }
    }
?>