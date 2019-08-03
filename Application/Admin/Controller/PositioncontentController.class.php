<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositioncontentController extends CommonController
{
    public function index()
    {
        $flag['status'] = array('eq', 1);
        $positions = D("Position")->select($flag);
        $this->assign('positions', $positions);

        if ($_GET['title']) {
            $data['title'] = trim($_GET['title']);
            $this->assign('title', $data['title']);
        }
        $data['status']= array('neq',-1);
        $data['position_id'] = $_GET['position_id'] ? intval($_GET['position_id']) : $positions[0]['id'];
        $contents = D("PositionContent")->select($data);
        $this->assign('contents', $contents);
        $this->assign('positionId', $data['position_id']);
        $this->display();
    }

    public function add()
    {
        if ($_POST) {
            if (!isset($_POST['position_id']) || !$_POST['position_id']) {
                return show(0, '推荐位ID不能为空');
            }
            if (!isset($_POST['title']) || !$_POST['title']) {
                return show(0, '推荐位标题不能为空');
            }
            if (!$_POST['url'] && !$_POST['news_id']) {
                return show(0, 'url和news_id不能同时为空');
            }
            if (!isset($_POST['thumb']) || !$_POST['thumb']) {
                if ($_POST['news_id']) {
                    $res = D("News")->find($_POST['news_id']);
                    if ($res && is_array($res)) {
                        $_POST['thumb'] = $res['thumb'];
                    }
                } else {
                    return show(0, '图片不能为空');
                }

            }
            if ($_POST['id']) {
                return $this->save($_POST);
            }
            try {
                $id = D("PositionContent")->insert($_POST);
                if ($id) {
                    return show(1, '添加成功');
                }
                return show(0, '添加失败');
            } catch (Exception $e) {
                return show(0, $e->getMessage());
            }


        } else {
            $flag['status'] = array('eq', 1);
            $positions = D("Position")->select($flag);
            $this->assign('positions', $positions);
            $this->display();
        }


    }

    public function edit()
    {
        $id = $_GET['id'];
        $position = D("PositionContent")->find($id);
        $flag['status'] = array('eq', 1);
        $positions = D("Position")->select($flag);
        $this->assign('positions', $positions);
        $this->assign('vo', $position);
        $this->display();
    }

    public function save($data)
    {
        $id = $data['id'];
        unset($data['id']);
        try {
            $resId = D("PositionContent")->updateById($id,$data);
            if ($resId === false) {
                return show(0, '更新失败');

            }
            return show(1, '更新成功');
        } catch (Exception $e) {
            return show(0, $e->getMessage());
        }

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
                $res = D('PositionContent')->updateStatusById($id, $status);
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
                    $id = D('PositionContent')->updatePositionListorderById($newsId, $v);
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