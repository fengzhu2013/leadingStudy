<?php /* Smarty version Smarty-3.1.16, created on 2017-05-03 15:01:49
         compiled from "tpl/admin/index.html" */ ?>
<?php /*%%SmartyHeaderCode:16016711235908493d103e97-38902937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cddbf8473d851c5cc0e76c7a5ec57d8e4f2965f7' => 
    array (
      0 => 'tpl/admin/index.html',
      1 => 1493794906,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16016711235908493d103e97-38902937',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5908493ee1b4b4_15423398',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908493ee1b4b4_15423398')) {function content_5908493ee1b4b4_15423398($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>报名试听</title>
<link href="./static/admin/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="./static/index/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/index/js/common.js"></script>
<script type="text/javascript" src="./static/admin/js/index.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<h1><a href="#">报名试听</a> / <span>上海领思教育</span></h1>
		</div>
		<div id="login">
			<form method="get" action="">
				<fieldset>
					<a href="#">信息修改</a>/<a href="#">发布消息</a>/<a href="javascript:SHMTU.GLOBAL.ADMIN.logout();" id="logout">注销</a>
				</fieldset>
			</form>
		</div>
	</div>
	<!-- end #header -->
	<div id="menu">
		<ul>
			<li class="current_page_item"><a href="#" id="lost">报名</a></li>
			<li><a href="#" id="found"></a></li>
			<li class="info"><span id="userInfo">某某(201311010000)<span>欢迎您</span></span><span id="date">2017/4/2</span></li>
		</ul>
	</div>
	<!-- end #menu -->
	<div id="page">
		<div class="post">
			<form method="get" action="">
					<input type="text" name="s" id="search-text" size="15" placeholder="姓名" />
					<input type="submit" id="search-submit" value="搜索">
			</form>
		</div>
		<div class="two-column" id="lostDiv">
				<table class="mytable" cellspacing="0" id="lostTab">
					<caption></caption>
					<tr>
						<th scope="col" width="5%">编号</th>
						<th scope="col" width="15%">姓名</th>
						<th scope="col" width="20%">报名课程</th>
						<th scope="col" width="20%">报名时间</th>
						<th scope="col" width="20%">试听时间</th>
						<th scope="col" width="20%">联系方式</th>
					</tr>
					<tr name="test">
						<td>1</td>
						<td>某某</td>
						<td>java后端开发</td>
						<td>2017/4/2</td>
						<td>2017/4/2</td>
						<td>18917012345</td>
					</tr>
					<tr name="test">
						<td>1</td>
						<td>某某</td>
						<td>java后端开发</td>
						<td>2017/4/2</td>
						<td>2017/4/2</td>
						<td>18917012345</td>
					</tr>
					<tr name="test">
						<td>1</td>
						<td>某某</td>
						<td>java后端开发</td>
						<td>2017/4/2</td>
						<td>2017/4/2</td>
						<td>18917012345</td>
					</tr>
					<tr name="test">
						<td>1</td>
						<td>某某</td>
						<td>java后端开发</td>
						<td>2017/4/2</td>
						<td>2017/4/2</td>
						<td>18917012345</td>
					</tr>
					<tr name="test">
						<td>1</td>
						<td>某某</td>
						<td>java后端开发</td>
						<td>2017/4/2</td>
						<td>2017/4/2</td>
						<td>18917012345</td>
					</tr>
					<tr name="test">
						<td>1</td>
						<td>某某</td>
						<td>java后端开发</td>
						<td>2017/4/2</td>
						<td>2017/4/2</td>
						<td>18917012345</td>
					</tr>
					<tr name="test">
						<td>1</td>
						<td>某某</td>
						<td>java后端开发</td>
						<td>2017/4/2</td>
						<td>2017/4/2</td>
						<td>18917012345</td>
					</tr>
					<tr name="test">
						<td>1</td>
						<td>某某</td>
						<td>java后端开发</td>
						<td>2017/4/2</td>
						<td>2017/4/2</td>
						<td>18917012345</td>
					</tr>
					<tr name="test">
						<td colspan="5">总共有10页，当前是第1页<br/>首页上一页 [1][2][3][4][5][6][7][8][9][10]下一页尾页</td>
						<td colspan="1">每页显示<span><select id="pageSel">
															<option value="1">8</option>
															<option value="2">20</option>
															<option value="3">50</option>
															<option value="4">全部</option>
													</select></span>条信息</td>
					</tr>
				</table>
			</div>
	</div>
	<div id="about">
		<!--关于我们-->
	</div>
</div>
<div id="footer">
	<p> &copy;报名试听/上海领思教育</p>
</div>
<!-- end #footer -->
<script type="text/javascript">
	$("#lost").bind("focus",function(){
		$("#lost").css("background-color","#636900");
		$("#found").css("background-color","#401F13");
		$("#foundDiv").css("display","none");
		$("#lostDiv").css("display","");
	});
	$("#found").bind("focus",function(){
		$("#found").css("background-color","#636900");
		$("#lost").css("background-color","#401F13");
		$("#foundDiv").css("display","");
		$("#lostDiv").css("display","none");
	});
</script>
</body>
</html>
<?php }} ?>
