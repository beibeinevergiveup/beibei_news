<?php
namespace Mobile\Controller;
use Think\Controller;

class CommonController extends Controller{

    public function  __construct()
    {
        header("Content-type: text/html; charset=utf-8");
        parent::__construct();
    }


    public function error($message)
    {
        $message = $message ? $message : '系统发生错误';
        $this->assign('message',$message);
        $this->display("Index/error");
    }


}