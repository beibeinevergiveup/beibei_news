<?php
namespace Common\Model;
use Think\Model;


class UserModel extends Model{

    private $_db = '';

    public function getUsers()
    {
        $data = array(
            'status' => array('neq',-1),
        );
        return $this->_db->where($data)->order('id desc')->select();
    }

    public function __construct()
    {
        $this->_db = M('users');

    }

    public function add($data = array())
    {
        if(!is_array($data)||!$data){
            return show(0,'数据或格式错误');
        }
        $data['password']=getMd5Password($data['password']);
        $data['status']=1;
      return $this->_db->add($data);
    }
    public function getAdminByUsername($username)
    {
        $data = array(
            'username' => $username ,
            'status' => array('eq',1),
        );
        $ret = $this->_db->where($data)->find();
        return $ret;
    }
    public function updateStatusById($id, $status) {
        if(!is_numeric($status)) {
            throw_exception("status不能为非数字");
        }
        if(!$id || !is_numeric($id)) {
            throw_exception("ID不合法");
        }
        $data['status'] = $status;
        return  $this->_db->where('id='.$id)->save($data); // 根据条件更新记录

    }
//    protected $_validate = array(
//        # 用正则表达式验证密码, [必须包含字母+数字，且长度6~20字节]
//        array('password', '/^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]{6,20}$/', '密码格式不对：必须包含字母+数字，且长度6~20字节', 0),
//        array('username', '/^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]{6,20}$/', '密码格式不对：必须包含字母+数字，且长度6~20字节', 0),
//
//    );



}