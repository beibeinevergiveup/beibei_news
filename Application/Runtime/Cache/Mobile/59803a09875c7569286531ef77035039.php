<?php if (!defined('THINK_PATH')) exit(); $config = D("Basic")->select(); $navs = D("Menu")->getBarMenus(); $id = $_GET['id']; if($id){ $flag = D("News")->find($id);} if($flag){ $config['title'] = $flag['title']; } ?>
<!doctype html>
<html class="no-js">
<head>
    <!--<script src="/Public/js/bootstrap.min.js"></script>-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title><?php echo ($config["title"]); ?></title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link rel="icon" type="image/png" href="/Public/assets/i/favicon.png">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="/Public/assets/i/app-icon72x72@2x.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <link rel="apple-touch-icon-precomposed" href="/Public/assets/i/app-icon72x72@2x.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="/Public/assets/i/app-icon72x72@2x.png">
    <meta name="msapplication-TileColor" content="#0e90d2">

    <link rel="stylesheet" href="/Public/assets/css/amazeui.min.css">
    <link rel="stylesheet" href="/Public/assets/css/app.css">
    <!--<link rel="stylesheet" href="/Public/css/bootstrap.min.css" type="text/css" >-->
</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <a href="/mobile.php" class="">

            <i class="am-header-icon am-icon-home"></i>
        </a>
    </div>

    <h1 class="am-header-title">
        <a href="#title-link" class="">
            <?php if($top != null): echo ($top); ?>
                <?php else: ?>
                贝贝新闻<?php endif; ?>
        </a>
    </h1>

    <div class="am-header-right am-header-nav">
        <a href="#right-link" class="">

            <i class="am-header-icon am-icon-bars"></i>
        </a>
    </div>
</header>

<nav data-am-widget="menu" class="am-menu am-menu-offcanvas1"



     data-am-menu-offcanvas
>
    <a href="javascript: void(0)" class="am-menu-toggle">
        <i class="am-menu-toggle-icon am-icon-bars"></i>
    </a>

    <div class="am-offcanvas am-avg-sm-1" >
        <div class="am-offcanvas-bar">

            <ul class="am-menu-nav am-avg-sm-1">
                <li class="">
                    <a href="/mobile.php?c=top"><span class="am-icon-fire">热点新闻</span></a>
                </li>
                <li class="am-parent">
                    <a class="" ><span class="am-icon-edge">新闻类别</span></a>
                    <ul class="am-menu-sub am-collapse  am-avg-sm-3 ">
                        <?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="">
                                <a href="/mobile.php?c=cat&id=<?php echo ($vo["menu_id"]); ?>" class="" ><?php echo ($vo["name"]); ?></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>

                    </ul>
                </li>
                <li class="am-parent">
                    <a class="" ><span class="am-icon-search">新闻搜索</span></a>
                    <ul class="am-menu-sub am-collapse  am-avg-sm-4 ">
                        <div class="am-u-lg-6">
                            <div class="am-input-group">
                                <form action="mobile.php" method="get">
                                    <input type="hidden" class="am-form-field" name="c" value="index">
                                    <input type="hidden" class="am-form-field" name="a" value="search">
                                     <input style="width: 70%" type="text" class="am-form-field" name="title">
                                     <span class="am-input-group-btn">
                    <button class="am-btn am-btn-default" type="submit"><span class="am-icon-search"></span> </button>
                                </span>
                                </form>
                            </div>
                        </div>
                    </ul>
                </li>
                <li class="am-parent">
                    <a class="" ><span class="am-icon-user-md">关于我们</span></a>
                    <ul class="am-menu-sub am-collapse  am-avg-sm-4 ">
                        <div style="color:white"><?php echo ($config["description"]); ?></div>
                    </ul>
                </li>
                <li class="">
                    <a href="/mobile.php?a=author" class="" ><span class="am-icon-angellist">about me</span> </a>
                </li>
            </ul>

        </div>
    </div>
</nav>
<div data-am-widget="slider" class="am-slider am-slider-default" data-am-slider='{}' >
    <ul class="am-slides">
        <?php if(is_array($toppicnews)): $i = 0; $__LIST__ = $toppicnews;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <a href="/mobile.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img style="height: 179px; width: 100% " src="<?php echo ($vo["thumb"]); ?>"></a>

            </li><?php endforeach; endif; else: echo "" ;endif; ?>

    </ul>
</div>

<div data-am-widget="list_news" class="am-list-news am-list-news-default" >
    <!--列表标题-->
    <div class="am-list-news-hd am-cf">
        <!--带更多链接-->
        <a class="">
            <h2>主要新闻</h2>
        </a>
    </div>
    <div class="am-list-news-bd">
        <ul class="am-list">
            <!--缩略图在标题右边-->
            <?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-right">
                <div class=" am-u-sm-8 am-list-main">
                    <h3 class="am-list-item-hd"><a href="/mobile.php?c=detail&id=<?php echo ($vo["news_id"]); ?>" class=""><?php echo ($vo["title"]); ?></a></h3>
                    <div class="am-list-item-text"><?php echo ($vo["description"]); ?></div>
                </div>

            <div class="am-u-sm-4 am-list-thumb">
           <a href="/mobile.php?c=detail&id=<?php echo ($vo["news_id"]); ?>" class="">
            <img src="<?php echo ($vo["thumb"]); ?>" alt=""/>
           </a>
         </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>

        </ul>
    </div>

</div>




<script src="/Public/js/jquery.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/Public/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="/Public/assets/js/amazeui.min.js"></script>
</body>
</html>