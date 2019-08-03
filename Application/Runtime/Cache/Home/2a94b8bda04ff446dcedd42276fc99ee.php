<?php if (!defined('THINK_PATH')) exit(); $config = D("Basic")->select(); $navs = D("Menu")->getBarMenus(); $id = $_GET['id']; if($id&&$titleflag){ $flag = D("News")->find($id); if($flag){ $config['title'] = $flag['title']; } } $user=getIndexUsername(); $admin = getLoginUsername(); ?>
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
    <script src="/Public/js/jquery-3.4.1.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/dialog/layer.js"></script>
    <script src="/Public/js/dialog.js"></script>
    <script src="/Public/js/admin/common.js"></script>
    <script src="/Public/js/admin/user.js"></script>
    <script>
        $(function(){

            $('#verify_img').click(function(){

                $('#verify_img').attr('src',"/index.php/Home/Index/verify/random/"+Math.random());//点击事件改变图片地址

            });

        });
    </script>
    <style>
        body{
            background:url("/Public/images/timg.jpg") repeat-y;
            background-size: 100%;
            width:100%;
            height:100%
        }
    </style>
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
            <?php if($user != null): ?><li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo $user ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/index.php?c=message"><i class="fa fa-fw fa-user"></i>给我留言</a>
                        </li>


                        <li class="divider"></li>
                        <li>
                            <a href="/index.php?c=user&a=loginout"><i class="fa fa-fw fa-power-off"></i>注销</a>
                        </li>
                    </ul>
                </li>
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

  <div class="container" style="background: white">
    <div class="row">
      <div class="col-md-9 col-lg-9">
        <div class="banner">

          <div style="width: 670px;height: 360px" class="banner-left">
          <!--<div class="banner-left">-->
            <!--<div class="banner-info"><span>阅读数</span><i class="news_count node-<?php echo ($result['topPicNews'][0]['news_id']); ?>" news-id="<?php echo ($result['topPicNews'][0]['news_id']); ?>" id="node-<?php echo ($result['topPicNews'][0]['news_id']); ?>"></i></div>-->
            <!--<a target="_blank" href=" /index.php?c=detail&id=<?php echo ($result['topPicNews'][0]['news_id']); ?>"><img width="670" height="360" src="<?php echo ($result['topPicNews'][0]['thumb']); ?>" alt=""></a>-->
          <!--</div>-->
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
              <?php if(is_array($result['topPicNews'])): $k = 0; $__LIST__ = array_slice($result['topPicNews'],1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li data-target="#carousel-example-generic" data-slide-to="<?php echo ($k); ?>"></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <?php if(is_array($result['topPicNews'])): $i = 0; $__LIST__ = array_slice($result['topPicNews'],0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div style="width: 670px;height: 360px" class="item active">
                <div class="banner-info"><span>阅读数</span><i class="news_count node-<?php echo ($vo["news_id"]); ?>" news-id="<?php echo ($vo["news_id"]); ?>" id="node-<?php echo ($vo["news_id"]); ?>"></i></div>
                <a href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img style="width: 670px;height: 360px" src="<?php echo ($vo["thumb"]); ?>" alt="..."></a>
                <div class="carousel-caption">
                  <h3><?php echo ($vo["title"]); ?></h3>
                </div>
              </div><?php endforeach; endif; else: echo "" ;endif; ?>
              <?php if(is_array($result['topPicNews'])): $i = 0; $__LIST__ = array_slice($result['topPicNews'],1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div style="width: 670px;height: 360px" class="item">
                  <div class="banner-info"><span>阅读数</span><i class="news_count node-<?php echo ($vo["news_id"]); ?>" news-id="<?php echo ($vo["news_id"]); ?>" id="node-<?php echo ($vo["news_id"]); ?>"></i></div>
                  <a href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img style="width: 670px;height: 360px" src="<?php echo ($vo["thumb"]); ?>" alt="..."></a>
                  <div class="carousel-caption">
                    <h3><?php echo ($vo["title"]); ?></h3>
                  </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
          </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <div class="banner-right">
            <ul>
              <?php if(is_array($result['topSmailNews'])): $i = 0; $__LIST__ = $result['topSmailNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img width="150" height="113" src="<?php echo ($vo["thumb"]); ?>" alt="<?php echo ($vo["title"]); ?>"></a>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>

            </ul>
          </div>
      </div>
        <div class="news-list">

            <div class="right-title">
          <h2 style="color: #d43f3a">今日头条</h2>
          <span>HOT ARTICLES</span>
        </div>
          <?php if(is_array($result['topNews'])): $i = 0; $__LIST__ = $result['topNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl>
              <dt><a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><span style="color: crimson"><h2><?php echo ($vo["title"]); ?></h2></span></a></dt>
              <dd class="news-img">
                <a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img width="200" height="200" src="<?php echo ($vo["thumb"]); ?>" alt="<?php echo ($vo["title"]); ?>"></a>
              </dd>
              <div>
                <?php
 echo "</br>"; ?>
              </div>
              <dd class="news-info">
                <?php echo ($vo["keywords"]); ?> <span><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></span> 阅读(<i news-id="<?php echo ($vo["news_id"]); ?>" class="news_count node-<?php echo ($vo["news_id"]); ?>"><?php echo ($vo["count"]); ?></i>)
              </dd>
            </dl><?php endforeach; endif; else: echo "" ;endif; ?>

          <div class="right-title">
            <h3>主要新闻</h3>
            <span>MAIN ARTICLES</span>
          </div>
          <?php if(is_array($result['listNews'])): $i = 0; $__LIST__ = $result['listNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl>
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

        </div>
      </div>
      <!--网站右侧信息-->
      <!-- 右侧排行-->
<div class="col-sm-3 col-md-3 col-lg-3">
  <div class="right-title">
    <h3>文章排行</h3>
    <span>TOP ARTICLES</span>
  </div>

  <div class="right-content">
    <ul>
      <?php if(is_array($result['rankNews'])): $k = 0; $__LIST__ = $result['rankNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="num<?php echo ($k); ?> curr">
        <a target="_blank" href="/index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><?php echo ($vo["small_title"]); ?></a>
        <?php if($k == 1): ?><div class="intro">
          <?php echo ($vo["description"]); ?>
        </div><?php endif; ?>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
  <div class="right-title">
    <h4>广告推荐</h4>
    <span>advantage</span>
  </div>
  <?php if(is_array($result['advNews'])): $k = 0; $__LIST__ = $result['advNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div class="thumbnail">
      <a target="_blank" href="<?php echo ($vo["url"]); ?>"> <img src="<?php echo ($vo["thumb"]); ?>" alt="<?php echo ($vo["title"]); ?>">
      <div class="caption">
        <h3 style="font-size: 20px"><?php echo ($vo["title"]); ?></h3>
      </div>
      </a>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>


    </div>

    </div>
  </div>
</section>
</body>
<script src="/Public/js/count.js"></script>
</html>