<?php


namespace Admin\Controller;
use Think\Controller;

class UserController extends CommonController
{
    public function index()
    {
        $users = D('User')->getUsers();
        $this->assign('user', $users);
        $this->display();
    }
    public function add()
    {
        if ($_POST) {
            if (!isset($_POST['username'] )|| !$_POST['username']) {
                return show(0,'用户名不能为空');
            }
            if (!isset($_POST['password']) || !$_POST['password']) {
                return show(0, '密码不能为空');
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
            $_POST['password'] = getMd5Password($_POST['password']);
            $admin = D('User')->getAdminByUsername($_POST['username']);
            if ($admin) {
                return show(0, "用户名已经存在");
            }
            $id = D("User")->add($_POST);
            if (!$id) {
                return show(0, "插入失败");
            }
            return show(1, '插入成功');
        }
        $this->display();
    }
    public function setStatus()
    {
        try {
            if ($_POST) {
                $id = $_POST['id'];
                $status = $_POST['status'];
                if (!$id) {
                    return show(0, 'ID不存在');
                }
                $res = D('User')->updateStatusById($id, $status);
                if ($res) {
                    return show(1, '操作成功');
                } else {
                    return show(0, '操作失败');
                }
            }
            return show(0, '没有提交的内容');
        }catch(Exception $e) {
            return show(0, $e->getMessage());
        }
    }

}