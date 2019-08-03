<?php
namespace Common\Model;
use Think\Model;

class MessageModel extends Model{

    private $_db = "";

    public function __construct()
    {
        $this->_db = M('Message');
    }

    public function insert($data)
    {

        if(!is_array($data)) {
            return show('0', '数据不合法');
        }
        return $this->_db->add($data);
    }

    public function select($condition=array())
    {


       return $this->_db->where($condition)->order('listorder desc ,status')->select();
    }

    public function updateStatusById($id,$status)
    {
        if (!is_numeric($status)) {
            throw_exception('status不能为非数字');
        }
        if (!$id || !is_numeric($id)) {
            throw_exception('id不合法');
        }
        $data['status'] = $status;
        return $this->_db->where('id=' . $id)->save($data);
    }

    public function find($id)
    {
        $data = array(
            'status' => array('neq',-1),
            'id' => $id,
        );
        return $res = $this->_db->where($data)->select();
    }
    public function getMessage($data,$page,$pageSize=6){
        $offset = ($page - 1 )*$pageSize;
        $list = $this->_db->where($data)
            ->order('status')
            ->limit($offset, $pageSize)
            ->select();
        return $list;

    }
    public function getMessageCount($data = array()){



        return $this->_db->where($data)->count();
    }

}