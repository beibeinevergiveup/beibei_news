<?php
namespace Mobile\Controller;
use Think\Controller;

class IndexController extends CommonController
{
    public function index()
    {

        $news = D("News")->select(array('status'=>1,'thumb'=>array('neq','')),10);

        //获取首页大图
        $topPicNews=D("PositionContent")->select(array('status'=>1, 'position_id' => 2),4);
        //获取首页3个小图推荐
        //$topSmailNews = D("PositionContent")->select(array('status'=>1,'position_id'=>3),3);
        $this->assign('news', $news);
        $this->assign('toppicnews', $topPicNews);
        //$this->assign('topsmallnews', $topSmailNews);
        $this->display();
    }

    public function search()
    {
         $title=$_GET['title'];
        if (!$title||!trim($title)) {
          $this->error('标题不能为空');

        }else {
            $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
            $pageSize = 10;
            $conds = array(
                'status' => 1,
                'thumb' => array('neq', ''),
                'title' => $title,
            );
            $news = D("News")->getNews($conds, $page, $pageSize);
            $count = D("News")->getNewsCount($conds);

            $res = new \Think\Page($count, $pageSize);
            $res->setConfig("theme", "%FIRST% %UP_PAGE% %DOWN_PAGE% %END%");
            $res->setConfig('prev', '上一页');
            $res->setConfig('next', '下一页');
            $pageres = $res->show();
            $this->assign('result', array(
                'listNews' => $news,
                'pageres' => $pageres,
                'title' => $title,
            ));

            $this->display();
        }


    }


    public function author()
    {
        $this->display();
    }
}