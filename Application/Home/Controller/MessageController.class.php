<?php
namespace Home\Controller;
use Think\Controller;

class MessageController extends  CommonController{

    public function index()
    {
        $url = $_SERVER['HTTP_REFERER'];
        $this->assign('url', $url);
        $this->display();
    }

    public function getMessage()
    {
        $user = $_SESSION['User'];
       $data = $_POST;
       if(!is_array($data)){

           return show(0, "数据不合法");

       }
        if(!$user) {
            return show(0, '请先登入');
        }
       if(!trim($data['e-mail'])){

           return show(0, '邮箱不能为空');

       }
        if(!trim($data['message'])){

            return show(0, '内容不能为空');

        }
        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        $email = $_POST['e-mail'];
        if (!preg_match($pattern, $email)) {
            return show(0, '邮箱格式不对');
        }
        $data['time'] = time();
        $data['user'] = $user['username'];
        $res = D('Message')->insert($data);
        if ($res) {
            return show(1,'留言成功，感谢你的支持');
        }


    }

    public function detail()
    {
        $id = $_GET['id'];
        $res = D('Message')->find($id);
        $url = $_SERVER['HTTP_REFERER'];
        $this->assign('url', $url);
        $this->assign('res', $res);
        $this->display();
    }





}