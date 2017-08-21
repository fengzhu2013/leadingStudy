<?php /* Smarty version Smarty-3.1.16, created on 2017-08-21 16:51:09
         compiled from "tpl/index.html" */ ?>
<?php /*%%SmartyHeaderCode:19322781595997cdbfe03378-03882739%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa2339e012cdf7510e1a8ab8504391dca6160e12' => 
    array (
      0 => 'tpl/index.html',
      1 => 1503305465,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19322781595997cdbfe03378-03882739',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5997cdbfe36fd6_54307961',
  'variables' => 
  array (
    'root_path' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5997cdbfe36fd6_54307961')) {function content_5997cdbfe36fd6_54307961($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>

<img src="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/index/index/testGetImageCode">
<form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/index/index/testUploadPic" method="post" enctype="multipart/form-data">
    请选择上传学生头像：<input type="file" name="myFile" /><br />
    <input type="submit" value="上传" />
</form>
</body>
</html><?php }} ?>
