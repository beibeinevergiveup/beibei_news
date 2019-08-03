<?php
namespace Admin\Controller;
use Think\Controller;
use Application\Common\Model;
class LoginController extends Controller
{
    public function index()
    {
        if(session('adminUser')){
            //print_r(session('adminUser')); exit;
        $this->redirect('/admin.php?c=index');
    }
        $this->display();
    }
    public function check(){
      $username = $_POST['username'];
      $password = $_POST['password'];
      if(!trim($username)){
          return show(0,'用户名不能为空');

      }
      if(!trim($password)){
            return show(0,'密码不能为空');

        }
     $ret= D('Admin')->getAdminByUsername($username);
      //print_r($ret);

        if(!$ret){
            return show(0,'该用户不存在');

        }
        if($ret['password'] != getMd5Password($password)){
            return show(0,'密码错误');

        }
        D("Admin")->updateByAdminId($ret['admin_id'],array('last_login_time'=>time()));
          session('adminUser', $ret);
        return show(1,'登陆成功');  

    }
    public function loginout(){
        session('adminUser',null);
        $this->redirect('/admin.php?c=login');
    }


}