<?php


namespace Admin\Controller;
use Think\Controller;

class AdminController extends  CommonController{
    public function index()
    {
        $admins = D('Admin')->getAdmins();
        $this->assign('admins', $admins);
        $this->display();
    }

    public function add()
    {
        if ($_POST) {
            if (!isset($_POST['user_name'] )|| !$_POST['user_name']) {
                return show(0,'用户名不能为空');
            }
            if (!isset($_POST['password']) || !$_POST['password']) {
                return show(0, '密码不能为空');
            }
            $_POST['password'] = getMd5Password($_POST['password']);
            $admin = D('Admin')->getAdminByUsername($_POST['password']);
            if ($admin && $admin['status' != -1]) {
                return show(0, "用户名已经存在");
            }
            $id = D("Admin")->insert($_POST);
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
                $res = D('Admin')->updateStatusById($id, $status);
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
    public function personal() {
        $res = $this->getLoginUser();
        $user = D("Admin")->getAdminByAdminId($res['admin_id']);
        $this->assign('vo',$user);
        $this->display();
    }

    public function save() {
        $user = $this->getLoginUser();
        if(!$user) {
            return show(0,'用户不存在');
        }

        $data['real_name'] = $_POST['real_name'];
        $data['email'] = $_POST['email'];

        try {
            $id = D("Admin")->updateByAdminId($user['admin_id'], $data);
            if($id === false) {
                return show(0, '配置失败');
            }
            return show(1, '配置成功');
        }catch(Exception $e) {
            return show(0, $e->getMessage());
        }
    }


}





