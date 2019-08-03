<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends CommonController{
    public function checklogin()
    {
        if($_SESSION['User']){
            redirect('/index.php');
        }

    }

    public function login()
    {
        $this->checklogin();
        $id = intval($_GET['id']);
        $rankNews = $this->getRank();
        //广告推送
        $advNews = D("PositionContent")->select(array('status'=>1,'position_id'=>5),2);
        $this->assign('result', array(
            'advNews'=>$advNews,
            'rankNews'=>$rankNews,
            'catId'=>$id,
        ));

        $this->display()
        ;
    }

    public function reg()
    {
        $this->checklogin();
        $id = intval($_GET['id']);

        $rankNews = $this->getRank();
        //广告推送
        $advNews = D("PositionContent")->select(array('status'=>1,'position_id'=>5),2);
        $this->assign('result', array(
            'advNews'=>$advNews,
            'rankNews'=>$rankNews,
            'catId'=>$id,

        ));
        $this->display();
    }

    public function check()
    {
        if($_POST) {

            if (!isset($_POST['verify']) || !$_POST['verify']) {
                return show(0, '验证码不能为空');

            }
            if (!isset($_POST['username']) || !$_POST['username']) {
                return show(0, '用户名不能为空');

            }
            if (!isset($_POST['password']) || !$_POST['password']) {
                return show(0, '密码不能为空');

            }
            $verify = check_verify($_POST['verify']);
            if (!$verify) {
                return show(0,'验证码错误');
          }

            $res = D('User')->getAdminByUsername($_POST['username']);
            if (!$res) {
                return show(0, '用户不存在');

            }
            if ($res['password'] === getMd5Password($_POST['password'])) {
                session('User', $res);
                return show(1, '登录成功');
            }else{
                return show(0,'密码错误，请重新输入');
            }
        }

    }
    public function add()
    {
        if ($_POST) {
            if (!isset($_POST['verify']) || !$_POST['verify']) {
                return show(0, '验证码不能为空');

            }
            if (!isset($_POST['username']) || !$_POST['username']) {
                return show(0, '用户名不能为空');
            }
            if (!isset($_POST['password']) || !$_POST['password']) {
                return show(0, '密码不能为空');
            }
            if (!isset($_POST['repassword']) || !$_POST['repassword']) {
                return show(0, '确认密码不能为空');
            }
            if($_POST['password']!=$_POST['repassword']){
                return show(0,'两次密码输入的不一致');

            }
            $verify = check_verify($_POST['verify']);
            if (!$verify) {
                return show(0,'验证码错误');
           }



            $p = '/^[A-Za-z0-9]{6,20}$/';
            $str1 = $_POST['username'];
            $str2 = $_POST['password'];
            if (!preg_match($p, $str1)) {
                return show(0, '账户格式不对：由字母或数字组成，且长度6~20字节');
            }
            if (!preg_match($p, $str2)) {
                return show(0, '账户格式不对：由字母或数字组成，且长度6~20字节');
            }

                $res = D('User')->getAdminByUsername($_POST['username']);
                if ($res) {
                    return show(0, '用户已经存在');

                }
//                 验证通过 可以进行其他数据操作
                $res1 = D('User')->add($_POST);
                if ($res1) {
                    return show(1, '注册成功');
                } else {
                    return show(0,'注册失败');
                }


        }


    }

    public function loginout()
    {
        session('User',null);
        redirect('/index.php');
    }

    public function verify()
    {
        $Verify =     new \Think\Verify();
        $Verify->length = 4;
        $Verify->fontttf = '5.ttf';
        $Verify->entry();
    }



}