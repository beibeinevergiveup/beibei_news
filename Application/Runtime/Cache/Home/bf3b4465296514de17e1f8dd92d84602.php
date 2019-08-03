<?php if (!defined('THINK_PATH')) exit(); $config = D("Basic")->select(); $navs = D("Menu")->getBarMenus(); $id = $_GET['id']; if($id){ $flag = D("News")->find($id);} if($flag){ $config = $flag; } $user=getIndexUsername(); $admin = getLoginUsername(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo ($config["title"]); ?></title>
  <meta name="keywords" content="<?php echo ($config["keywords"]); ?>" />
  <meta name="description" content="<?php echo ($config["description"]); ?>" />
    <link rel="icon" href="/Public/images/headlogo.ico" type="image/x-icon"/>
  <link rel="stylesheet" href="/Public/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="/Public/css/home/main.css" type="text/css" />
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/dialog/layer.js"></script>
    <script src="/Public/js/dialog.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/admin/common.js"></script>
    <script src="/Public/js/admin/user.js"></script>
    <script>
        $(function(){

            $('#verify_img').click(function(){

                $('#verify_img').attr('src',"/index.php/Home/Index/verify/random/"+Math.random());//点击事件改变图片地址

            });

        });
    </script>
</head>
<body>
<header id="header">
  <div class="navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <a href="/index.php">
          <img src="/Public/images/logn.jpg" alt="">
        </a>
      </div>
      <ul class="nav navbar-nav navbar-left">
        <li><a href="/index.php" <?php if($result['catId'] == 0): ?>class="curr"<?php endif; ?>>首页</a></li>
        <?php if(is_array($navs)): foreach($navs as $key=>$vo): ?><li><a href="/index.php?c=cat&id=<?php echo ($vo["menu_id"]); ?>" <?php if($vo['menu_id'] == $result['catId']): ?>class="curr"<?php endif; ?>><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; ?>
      </ul>
        <form>
        <div class="col-lg-3 col-md-3">
            <div class="input-group" style="margin-top: 18px">
                <!--<input type="hidden" name="c" value="index"/>-->
                <!--<input type="hidden" name="a" value="search"/>-->
                <input type="text" class="form-control" placeholder="搜索相关新闻" value="<?php echo ($title); ?>" name="title" id="searchvalue"/>
                <span class="input-group-btn">
            <button class="btn btn-default" type="button" id="search"><span class="glyphicon glyphicon-search"></span></button>
           </span>
            </div>
        </div>
        </form>
        <ul class="nav navbar-right navbar-nav ">
            <?php if($user != null): ?><li> <a href="#"><?php echo $user;?></a></li>
                <li> <a href="#" onclick="userout.check()">注销</a></li>

            <?php elseif($admin != null ): ?>
                <li> <a href="#"><?php echo "管理员： ".$admin;?></a></li>
                <li> <a href="#" onclick="adminout.check()">注销</a></li>
             <?php else: ?>
                <li> <a href="/index.php?c=user&a=login&id=-1"<?php if($result['catId'] == -1): ?>class="curr"<?php endif; ?>> 登录</a></li>
                <li> <a href="/index.php?c=user&a=reg&id=-2"<?php if($result['catId'] == -2): ?>class="curr"<?php endif; ?>> 注册</a></li><?php endif; ?>
        </ul>
    </div>
  </div>
    <script>
        $('#search').click(function(){
            var val = $('#searchvalue').val();
            //console.log(val);
            if($.trim(val)==''){

                return 0;

            }else{

                window.location.href="/index.php?a=search&title="+val;
            }

        });




    </script>
</header>
<?php
 ?>
<div class="container">
    <div class="row">
        <div class="col-md-9 col-lg-9">
            <div class="news-list">
            <?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl>
                    <dt><a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><span style="color: <?php echo ($vo["title_font_color"]); ?>"><?php echo ($vo["title"]); ?></span></a></dt>
                    <dd class="news-img">
                        <a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img width="200" height="120" src="<?php echo ($vo["thumb"]); ?>" alt="<?php echo ($vo["title"]); ?>"></a>
                    </dd>
                    <dd class="news-intro">
                        <?php echo ($vo["description"]); ?>
                    </dd>
                    <dd class="news-info">
                        <?php echo ($vo["keywords"]); ?> <span><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></span> 阅读(<i news-id="<?php echo ($vo["news_id"]); ?>" class="news_count node-<?php echo ($vo["news_id"]); ?>"><?php echo ($vo["count"]); ?></i>)
                    </dd>
                </dl><?php endforeach; endif; else: echo "" ;endif; ?>


            <ul >
                <?php echo ($pageres); ?>
            </ul>

        </div>
    </div>

    <div class="col-md-3 col-lg-3">
        <div class="right-title">
            <h3>其他新闻</h3>
            <span>RELATED NEWS</span>
        </div>
        <div class="list-group">
            <?php if(is_array($other)): $i = 0; $__LIST__ = $other;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!--<div class="panel panel-default">-->
                <!--<div class="panel-heading"><a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><h3><?php echo ($vo["small_title"]); ?></h3></a></div>-->
                <!--<div class="panel-body">-->
                <!--<h5><?php echo ($vo["description"]); ?></h5>-->
                <!--</div>-->
                <!--</div>-->
                <a href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>" class="list-group-item list-group-item-info"><?php echo ($vo["small_title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
</div>