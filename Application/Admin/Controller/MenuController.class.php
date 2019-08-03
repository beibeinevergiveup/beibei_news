<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class MenuController extends CommonController{
    public function add(){
        if($_POST) {
            if(!isset($_POST['name']) || !$_POST['name']) {
                return show(0,'菜单名不能为空');
            }
            if(!isset($_POST['m']) || !$_POST['m']) {
                return show(0,'模块名不能为空');
            }
            if(!isset($_POST['c']) || !$_POST['c']) {
                return show(0,'控制器不能为空');
            }
            if(!isset($_POST['f']) || !$_POST['f']) {
                return show(0,'方法名不能为空');
            }
            if($_POST['menu_id']) {
                return $this->save($_POST);
            }
            $menuId = D("Menu")->insert($_POST);
            if($menuId) {
                return show(1,'新增成功',$menuId);
            }
            return show(0,'新增失败',$menuId);

        }else {
            $this->display();
        }
        //echo "welcome to singcms";
    }
    public function index(){
        $data=array();
        if(isset($_REQUEST['type']) && (in_array(0,$_REQUEST) || in_array(1,$_REQUEST))){
            $data['type']=intval($_REQUEST['type']);
            $this->assign('type',$data['type']);
        }else{
            $this->assign('type',-100);
        }
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 6;
        $menus = D("Menu")->getMenus($data,$page,$pageSize);
        //print_r($menus);
        $menusCount = D("Menu")->getMenusCount($data);

        $res = new \Think\Page($menusCount, $pageSize);
        $pageRes = $res->show();
        $this->assign('pageRes', $pageRes);
        $this->assign('menus',$menus);
        $this->display();
    }

    public function edit(){
        $menuId = $_GET['id'];

        $menu = D('Menu')->find($menuId);
        $this->assign('menu',$menu);
        $this->display();
    }
    public function save($data){
        $menuId = $data['menu_id'];
        unset($data['menu_id']);

        try{
            $id = D("Menu")->updateMenuById($menuId,$data);
                if($id==false){
                    return show(0,'更新失败');

                }
                return show(1,'更新成功');
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }

    }
    public function setStatus(){
        try{
            if($_POST){
                $id = $_POST['id'];
                $status = $_POST['status'];
                $res = D('Menu')->updateStatusById($id,$status);
                if($res){
                    return show(1,'操作成功');

                }else{
                    return show(0,'操作失败');
                }
            }
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
       return show(0,'没有提交的数据');
    }

    public function listorder() {
        $listorder = $_POST['listorder'];
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $errors = array();
        if($listorder) {
            try {
                foreach ($listorder as $menuId => $v) {
                    // 执行更新
                    $id = D("Menu")->updateMenuListorderById($menuId, $v);
                    if ($id === false) {
                        $errors[] = $menuId;
                    }

                }
            }catch(Exception $e) {
                return show(0,$e->getMessage(),$jumpUrl);
            }
            if($errors) {
                return show(0,'排序失败-'.implode(',',$errors),$jumpUrl);
            }
            return show(1,'排序成功',$jumpUrl);
        }

        return show(0,'排序数据失败',$jumpUrl);
    }
    public function getActive($navc){
        $c = strtolower(CONTROLLER_NAME);
        if(strtolower($navc)==$c){
            return 'class=active';
        }
        return '';
    }



}