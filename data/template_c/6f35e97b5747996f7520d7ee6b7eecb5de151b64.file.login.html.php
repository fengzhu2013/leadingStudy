<?php /* Smarty version Smarty-3.1.16, created on 2017-05-03 12:18:46
         compiled from "tpl/admin/login.html" */ ?>
<?php /*%%SmartyHeaderCode:80036232759094dd7b0c397-89736944%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f35e97b5747996f7520d7ee6b7eecb5de151b64' => 
    array (
      0 => 'tpl/admin/login.html',
      1 => 1493785123,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '80036232759094dd7b0c397-89736944',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_59094dd8a70d01_56417098',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59094dd8a70d01_56417098')) {function content_59094dd8a70d01_56417098($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<title>上海领思后台登陆</title>
<!--Custom Theme files-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<link href="./static/admin/css/styleLo.css" rel="stylesheet" type="text/css" media="all" />
<!--web-fonts-->
<link href='//fonts.googleapis.com/css?family=Signika:400,300,600,700' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
<!--//web-fonts-->
<!--js-->
<script src="./static/index/js/jquery.min.js"></script>
<script src="./static/admin/js/md5.js"></script>
<script src="./static/index/js/common.js"></script>
<script src="./static/admin/js/login.js" type="text/javascript"></script>
<script src="./static/admin/js/easyResponsiveTabs.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#horizontalTab').easyResponsiveTabs({
				type: 'default', //Types: default, vertical, accordion           
				width: 'auto', //auto or any width like 600px
				fit: true   // 100% fit in a container
			});
		});
	   </script>
<!--//js-->
</head>
<body>
	<!-- main -->
	<div class="main">
		<h1>Tab Login Form</h1>
		<div class="login-form">
			<div class="login-left">
				<div class="logo">
					<img src="./static/admin/images/lingsi.png" alt=""/>
					<h2>Welcome </h2>
					<p>上海领思教育后台</p>
				</div>
				<div class="social-icons">
					<ul>
					<!--其他登陆方式-->
					</ul>
				</div>
			</div>
			<div class="login-right">
				<div class="sap_tabs">
					<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
						<ul class="resp-tabs-list">
							<li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><span>登陆</span></li>
							<div class="clear"> </div>
						</ul>				  	 
						<div class="resp-tabs-container">
							<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
								<div class="login-top">
									<form>
										<input type="text" class="name" placeholder="账号" id="name"/>
										<input type="password" class="password" placeholder="密码" id="password"/>		
									</form>
									<div class="login-text">
										<ul>
											<li><a href="#">忘记密码</a></li>
										</ul>
									</div>
									<div class="login-bottom login-bottom1">
										<div class="submit">
											<form>
												<input type="button" value="登陆" id="lsLogin"/>
											</form>
										</div>
										<ul>
										</ul>
										<div class="clear"></div>
									</div>	
								</div>
							</div>
							<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
								<div class="login-top sign-top">
									<form>
										<input type="text" class="name active" placeholder="Your Name" required=""/>
										<input type="text" class="email" placeholder="Email" required=""/>
										<input type="password" class="password" placeholder="Password" required=""/>		
									</form>
									<div class="login-bottom">
										<div class="submit">
											<form>
												<input type="submit" value="LOGIN"/>
											</form>
										</div>
										<div class="clear"></div>
									</div>		
								</div>
							</div>
						</div>							
					</div>	
				</div>
			</div>
			<div class="clear"> </div>
		</div>
	</div>
	<!--//main -->	
	<div class="copyright">
		<p> &copy; 上海领思教育 </p>
	</div>	
</body>
</html><?php }} ?>
