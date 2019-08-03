<?php
namespace Mobile\Controller;
use Think\Controller;
class DetailController extends CommonController{
    public function index()
    {
        $id = intval($_GET['id']);


        $news = D('News')->find($id);
        if (!$news) {
            $this->error('新闻不存在');
        }else{
        $count = intval($news['count'])+1;
        D('news')->updateCount($id, $count);
        $content = D("NewsContent")->find($id);
        $news['content']=htmlspecialchars_decode($content['content']);
        $this->assign('news', $news);
        $this->display();}
    }


}