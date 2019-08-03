<?php
namespace Home\Controller;
use Think\Controller;

class DetailController extends CommonController{

    public function index($flag=0)
    {

        $id = intval($_GET['id']);
        $titleflag = 1;
        $this->assign('titleflag', $titleflag);
        if (!$id || $id < 0) {
            return $this->error('ID不合法');

        }
        $news = D('News')->find($id);
        if ((!$news || $news['status']!=1)&&$flag==0) {
            return $this->error("ID不存在或咨询被关闭");
        }
        if(!getIndexUsername()&&!getLoginUsername()){
            return $this->error('抱歉,你需要登入才能浏览此页面');
        }
        $count = intval($news['count'])+1;
        D('news')->updateCount($id, $count);
        $content = D("NewsContent")->find($id);
       $news['content']=htmlspecialchars_decode($content['content']);

        $advNews = D("PositionContent")->select(array('status'=>1,'position_id'=>5),2);
        //相关新闻
        $related = D('News')->getRelatedNews($news);
        //$rankNews = $this->getRank();
        $this->assign('result', array(
            //'rankNews' => $rankNews,
            'advNews' => $advNews,
            'catId' => $news['catid'],
            'news' => $news,
            'related' => $related,
            'keywords' => $news['keywords'],
        ));
        $this->display('Detail/index');
    }
    public function view()
    {
        if(!getLoginUsername()){
            $this->error(0, '抱歉，你没有浏览权限');
        }
        $this->index(1);

    }








}