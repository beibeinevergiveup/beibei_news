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
            贝贝新闻
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
                <li class="am-parent">
                    <a class="" >新闻类别</a>
                    <ul class="am-menu-sub am-collapse  am-avg-sm-3 ">
                        <?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="">
                                <a href="/mobile.php?c=cat&id=<?php echo ($vo["menu_id"]); ?>" class="" ><?php echo ($vo["name"]); ?></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>

                    </ul>
                </li>
                <li class="am-parent">
                    <a class="" >新闻搜索</a>
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
                    <a class="" >关于我们</a>
                    <ul class="am-menu-sub am-collapse  am-avg-sm-4 ">
                        <div style="color:white"><?php echo ($config["description"]); ?></div>
                    </ul>
                </li>
                <li class="">
                    <a href="/mobile.php?a=author" class="" >about me</a>
                </li>
            </ul>

        </div>
    </div>
</nav>
<div data-am-widget="intro"
     class="am-intro am-cf am-intro-default"
>
    <div class="am-intro-hd">
        <h2 class="am-intro-title">你好，贝贝</h2>
    </div>

    <div class="am-g am-intro-bd">
        <div
                class="am-intro-left am-u-sm-5"><img src="/Public/images/dontcry.jpg" alt="beibei" /></div>
        <div
                class="am-intro-right am-u-sm-7"> 也许有一天，你对未来一片的赤诚却倒在现实的残酷之下，你发现你拼命的努力不如别人父母一两句话的直通车，
         请你静下心来，回顾的往日的每一页，DON'T CRY ,BEIBEI NEVER GIVE UP.

        </div>
    </div>
</div>
<article data-am-widget="paragraph"
         class="am-paragraph am-paragraph-default"

         data-am-paragraph="{ tableScrollable: true, pureview: true }">
       <img src="/Public/images/励志1.jpeg" />
        <p>在2019年，你对未来充满着迷茫，即使你已经努力的熬夜的学习，但你却永远找不到目标，你知道学无止境，但是你也并非
        圣人，你也很羡慕周围玩耍的同学，你知道自己的家境无法和他们一样，你知道他们出生就仿佛活到了终点，你懂只能依靠自己的努力拼搏自己的一片未来。</p>
           <img src="/Public/images/励志2.jpeg" />
    <p>
        经历了2年的大学洗礼，此时的你不像初入学校时的青涩，玩物丧志，开始会对未来尝试着努力。但是也许是快乐惯了，
        脆弱的心态经不起一丝丝挫折敲打，自闭、奔溃、等等负面的情绪涌上心头。。。
    </p>
    <img src="/Public/images/励志3.jpeg" />
    <p>
       令人欣慰的是，曾经开朗的你，结实一群可靠的朋友。他们也许不曾在你身边，但是他们会用全心全意的尝试着理解你，鼓励你。
        天底下最让人温暖的鸡汤莫过于平日里嘻嘻哈哈不正经的玩伴突然用心的鼓励你。。。
        感谢遇见！！！ MY BEST FRIENDS
    </p>
</article>




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