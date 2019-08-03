<?php
namespace Mobile\Controller;
use Think\Controller;
class CatController extends CommonController{

    public function index(){


        $id = intval($_GET['id']);
//        if (!$id) {
//            return $this->error('ID不存在');
//        }

        $nav = D("Menu")->find($id);
        if(!$nav){
            return $this->error('类别错误');
        }
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 10;
        $conds = array(
            'status' => 1,
            'thumb' => array('neq', ''),
            'catid' => $id,
        );
        $news = D("News")->getNews($conds,$page,$pageSize);
        $count = D("News")->getNewsCount($conds);

        $res  =  new \Think\Page($count,$pageSize);
        $res ->setConfig("theme","%FIRST% %UP_PAGE% %DOWN_PAGE% %END%");
        $res ->setConfig('prev','上一页');
        $res ->setConfig('next','下一页');

        $pageres = $res->show();
        $this->assign('result', array(
            'catId' => $id,
            'listNews' => $news,
            'pageres' => $pageres,
            'navs'   => $nav
        ));

        $this->display();
    }


}


