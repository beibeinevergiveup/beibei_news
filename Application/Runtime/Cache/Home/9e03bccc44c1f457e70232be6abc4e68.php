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
	<section>
		<div class="container" style="text-align:center;">
			<h1 style="color:red"><?php echo ($message); ?></h1>
			<h3 style="color:red" id="location" >系统将在<span style="color:red">3</span>秒后自动跳转到首页</h3>
		</div>
	</section>
</body>
<script>
  //首页
  var url = "/index.php";
  var time = 3;
  setInterval("refer()",1000);
  function refer() {
	if(time==0) {
	  location.href=url;
	}
	$("#location span").html(time);
	time--;
  }
</script>
</html>