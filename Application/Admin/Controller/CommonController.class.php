<?php

namespace Admin\Controller;
use Think\Controller;


class CommonController extends Controller{
    public function  __construct()
    {
        parent::__construct();
        $this->_init();

    }

    private function  _init(){
        $isLogin = $this->isLogin();
        if(!$isLogin) {
            // 跳转到登录页面
            $this->redirect('/admin.php?c=login');
        }
    }
    public function  getLoginUser(){
        return session ("adminUser");

    }//判断是否登录。
    public function  isLogin(){
        $user = $this->getLoginUser();
        if($user&&is_array($user)){
            return true;
        }
        return false;
    }






}