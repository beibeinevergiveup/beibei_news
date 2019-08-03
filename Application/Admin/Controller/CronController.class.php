<?php
namespace Admin\Controller;
use Think\Controller;


class CronController extends CommonController{


    public function dumpmysql() {
        $result = D("Basic")->select();
        if(!$result['dumpmysql']) {
            die("系统没有设置开启自动备份数据库的内容");
        }
        $shell = "/phpstudy/mysql/bin/mysqldump -u".C("DB_USER")." -p".C("DB_PWD")." " .C("DB_NAME")." > /data/cms".date("Ymd").".sql";
        //exec($shell);
        echo $shell;
    }

}