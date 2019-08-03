<?php
namespace Mobile\Controller;
use Think\Controller;

class TopController extends  Controller{
    public function index()
    {


        $conds['status'] = 1;
        $news = D("News")->getRank($conds,10);
        $this->assign('news', $news);
        $this->assign('top','热点新闻');

        $this->display();
    }


}