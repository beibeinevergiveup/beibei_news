<?php

namespace Admin\Controller;
use Think\Controller;

class MessagemangerController extends CommonController
{


    public function index()
    {
        $data=array(
          'status' => array('neq',-1),

        );
        if($_GET['name']){
            $name = $_GET['name'];
            $data['user']=array('like','%'.$name.'%');
        }
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $count = D('Message')->getMessageCount($data);
        $res = D('Message')->getMessage($data,$page);
        $pages  =  new \Think\Page($count,6);
        $show = $pages->show();
        $this->assign('res', $res);
        $this->assign('name', $name);
        $this->assign('page',$show);

        $this->display();
    }
    public function setStatus()
    {
        try {
            if($_POST){
                $id = $_POST['id'];
                $status = $_POST['status'];
                if (!$id) {
                    return show(0, 'ID不存在');
                }
                $res = D('Message')->updateStatusById($id, $status);
                if ($res) {
                    return show(1, '操作成功');
                }else{
                    return show(0, '操作失败');
                }
            }
            return show(0, '没有提交的内容');
        } catch (Exception $e) {

            return show(0, $e->getMessage());


        }
    }

    public function listorder()
    {
        $listorder = $_POST['listorder'];
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $errors = array();
        try {
            if ($listorder) {
                foreach ($listorder as $newsId => $v) {
                    $id = D('Message')->updateMessageById($newsId, $v);
                    if ($id === false) {
                        $errors[] = $newsId;
                    }
                }
                if ($errors) {
                    return show(0, '排序失败—' . implode(',', $errors),
                        $jumpUrl);

                }
                return show(1, '排序成功',$jumpUrl);
            }
        } catch (Exception $e) {
            return show(0, $e->getMessage());

        }
        return show(0,'排序失败',$jumpUrl);
    }

}