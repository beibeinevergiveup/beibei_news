<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController
{

    public function index($type ="")
    {
        //获取首页轮播大图
        $topPicNews=D("PositionContent")->select(array('status'=>1, 'position_id' => 2),4);
        //获取首页3个小图推荐
        $topSmailNews = D("PositionContent")->select(array('status'=>1,'position_id'=>3),3);
        //获取新闻列表
        $listNews = D("News")->select(array('status'=>1,'thumb'=>array('neq','')),10);
        //获取首页头条
        $topNews = D("PositionContent")->select(array('status'=>1, 'position_id' => 1),1);
        $rankNews = $this->getRank();
        //广告推送
        $advNews = D("PositionContent")->select(array('status'=>1,'position_id'=>5),2);

        $this->assign('result', array(
            'topPicNews' => $topPicNews,
            'topSmailNews' =>$topSmailNews,
            'listNews'=>$listNews,
            'advNews'=>$advNews,
            'rankNews'=>$rankNews,
            'topNews'=>$topNews,
            ));
        //print_r($listNews);
        if($type == 'buildHtml') {
            //$this->buildHtml('静态文件', '静态路径','模板文件');
            $this->buildHtml('index',HTML_PATH,'Index/index');

        }
        elseif ($type == 'dumpMysql'){
            $shell = "/phpstudy/mysql/bin/mysqldump -u".C("DB_USER")." -p".C("DB_PWD")." " .C("DB_NAME")." > /data/tp/cms".date("Ymd").".sql";
            //return show(0, $shell);
            exec($shell);

        }
        else {
            $this->display();
        }

    }
    public function build_html() {
        $this->index('buildHtml');
        return show(1, '首页缓存生成成功');
    }

    public function dumpMysql()
    {
        $this->index('dumpMysql');
        return show(1, '数据库备份成功成功');
    }


    public function crontab_build_html() {
        if(APP_CRONTAB != 1) {
            die("the_file_must_exec_crontab");
        }
        $result = D("Basic")->select();
        if(!$result['cacheindex']) {
            die('系统没有设置开启自动生成首页缓存的内容');
        }
        $this->index('buildHtml');

    }
//    public function error($message = '')
//    {
//       $message = $message ? $message : '系统发生错误';
//       $this->assign('message',$message);
//        $this->display();
//    }
    //计数器
    public function getCount() {
        if(!$_POST) {
            return show(0, '没有任何内容');
        }

        $newsIds =  array_unique($_POST);

        try{
            $list = D("News")->getNewsByNewsIdIn($newsIds);
        }catch (Exception $e) {
            return show(0, $e->getMessage());
        }

        if(!$list) {
            return show(0, 'notdataa');
        }

        $data = array();
        foreach($list as $k=>$v) {
            $data[$v['news_id']] = $v['count'];
        }
        return show(1, 'success', $data);
    }

    public function search(){
        if(!$_GET['title']||!trim($_GET['title'])){
            //$this->error('没有输入标题');
            return show('0','请输入合法标题标题');
        }else {
            $data = array();
            $data['title'] = $_GET['title'];
            $data['status'] = 1;
            $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
            $pageSize = 8;
            $news = D("News")->getNews($data, $page, $pageSize);
            $count = D("News")->getNewsCount($data);
            if (!$count || $count == 0) {
                $this->error('没有查询到相关新闻');
                return;
            }
            $res = new \Think\Page($count, $pageSize);
            $pageres = $res->show();
            $newsId = array();
            foreach ($news as $k => $v){
                $newsId[$k] = $v['news_id'];
            }
            $other = D('News')->OtherNews($newsId);
            $this->assign('pageres', $pageres);
            $this->assign('news', $news);
            $this->assign('title',$_GET['title']);
            $this->assign('other', $other);
            $this->display();

        }

    }

    public function crondumpmysql() {
        $result = D("Basic")->select();
        if(!$result['dumpmysql']) {
            die("系统没有设置开启自动备份数据库的内容");
        }
        $shell = "/phpstudy/mysql/bin/mysqldump -u".C("DB_USER")." -p".C("DB_PWD")." " .C("DB_NAME")." > /data/tp/cms".date("Ymd").".sql";
        exec($shell);
        //echo $shell;
    }

}