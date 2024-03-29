<?php
namespace Common\Model;
use Think\Model;

class NewsModel extends Model{
    private $_db = '';

    public function __construct()
    {
        $this->_db = M('news');

    }

    public function select($data = array(),$limit = 100)
    {
        $condition = $data;
        $list = $this->_db->where($condition)->order('news_id desc')->limit($limit)->select();
        return $list;
    }

    public function insert($data = array()) {
        if(!is_array($data) || !$data) {
            return 0;
        }

        $data['create_time']  = time();
        $data['user_name'] =  getLoginUsername();
        return $this->_db->add($data);
    }
    public function getNews($data,$page,$pageSize=10){
        $conditions = $data;
        if(isset($data['title'])&&$data['title']){}
        $conditions['title']= array('like','%'.$data['title'].'%');

        if (isset($data['catid'])&&$data['catid']) {
            $conditions['catid']=intval($data['catid']);
        }
        if(!isset($data['status'])&&!$data['status']){
        $conditions['status'] = array('neq',-1);}
        $offset = ($page - 1 )*$pageSize;
        $list = $this->_db->where($conditions)
            ->order('listorder desc ,news_id desc')
            ->limit($offset, $pageSize)
            ->select();
        return $list;

    }
    public function getNewsCount($data = array()){
        $conditions = $data;
        if(isset($data['title'])&&$data['title']){
        $conditions['title']= array('like','%'.$data['title'].'%');

        }

        if (isset($data['catid'])&&$data['catid']) {
            $conditions['catid']=intval($data['catid']);
        }
        if(!$conditions['status']){
        $conditions['status'] = array('neq',-1);}

        return $this->_db->where($conditions)->count();
    }

    public function find($id) {
        $data = $this->_db->where('news_id='.$id)->find();
        return $data;
    }
    public function updateById($id, $data) {
        if(!$id || !is_numeric($id) ) {
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)) {
            throw_exception('更新数据不合法');
        }

        return $this->_db->where('news_id='.$id)->save($data);
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
        return $this->_db->where('news_id=' . $id)->save($data);
    }
    public function updateNewsListorderById($id, $listorder)
    {
        if (!$id || !is_numeric($id)) {
            throw_exception('ID不能为非数字');
        }
        $data = array('listorder' => intval($listorder));
        return $this->_db->where('news_id=' . $id)->save($data);
    }
    public function getNewsByNewsIdIn($newsIds) {
        if(!is_array($newsIds)) {
            throw_exception("参数不合法");
        }

        $data = array(

            'news_id' => array('in', $newsIds),
        );

        return $this->_db->where($data)->select();
    }

    public function getRank($data = array(), $limit = 100) {
        $list = $this->_db->where($data)->order('count desc,news_id desc ')->limit($limit)->select();
        return $list;
    }

    public function updateCount($id, $count)
    {
        if (!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        if (!is_numeric($count)) {
            throw_exception("count不能为非数字");
        }
        $data['count'] = $count;
        return $this->_db->where('news_id=' . $id)->save($data);
    }
    public function maxcount() {
        $data = array(
            'status' => 1,
        );
        return $this->_db->where($data)->order('count desc')->limit(1)->find();
    }
//    public function getKeywords($newsId)
//    {
//      $data = array(
//          'news_id' => $newsId,
//      );
//        return $this->_db->where($data)->select();
//    }

    public function getCatNews($news){
        $data = array(
            'catid' => $news['catid'],
            'status' => array('eq', 1),
            'news_id' => array('neq',$news['news_id']),

        );
        return $this->_db->where($data)->select();
    }
    public function getRelatedNews($news)
    {
        if(!$news['keywords']) {

            $list = $this->getCatNews($news);
            return $list;


        }
        $Allcount = 0;
        $flag=0;
        $keywords = explode(',',$news['keywords']);
        $count = count($keywords);
        for ($i = 0; $i < $count; $i++) {
            $data = array(
                'title'=>array('like','%'.$keywords[$i].'%'),
                'status' => array('eq', 1),
                'news_id' => array('neq',$news['news_id']),
            );
            //$newscount = $this->_db->where($data)->count();;
            $list= $this->_db->where($data)->select();
            if($list){
                 foreach ($list as $key => $value) {
                  $news1[$flag++] = $value;
                 }
            }
            $newscount = count($news1);
            $Allcount = $Allcount+$newscount;
            if ($Allcount>10){
                break;
            }
        }
        $tmp_arr = array();$i=0;
        foreach ($news1 as $k => $v){
            if(in_array($v['news_id'],$tmp_arr))
            {
              unset($news1[$k]);
            }
            else {
                $tmp_arr[$i++] = $v['news_id'];
            }
        }
        if ($Allcount == 0){
            $list = $this->getCatNews($news);
            return $list;
        }else {
            return $news1;
        }

    }

    public function OtherNews($NewsId=array())
    {
        if(!is_array($NewsId)){
            return 0;
        }
        $data = array(
            'status' => array('eq', 1),
            'news_id' => array('not in', $NewsId),
        );
        return $this->_db->where($data)->select();

    }


}