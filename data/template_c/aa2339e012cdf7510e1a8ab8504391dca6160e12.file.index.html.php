<?php /* Smarty version Smarty-3.1.16, created on 2017-09-06 13:55:06
         compiled from "tpl/index.html" */ ?>
<?php /*%%SmartyHeaderCode:19322781595997cdbfe03378-03882739%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa2339e012cdf7510e1a8ab8504391dca6160e12' => 
    array (
      0 => 'tpl/index.html',
      1 => 1504677304,
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

<!--
<img src="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/index/index/testGetImageCode">
-->
<form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/api/student/uploadPic" method="post" enctype="multipart/form-data">
    请选择上传学生头像：<input type="file" name="myFile" /><br />
    <input type="submit" value="上传" />
</form>
<hr />
<form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/index/index/testUploadPic" method="post" enctype="multipart/form-data">
    请选择上传教师头像：<input type="file" name="myFile" /><br />
    <input type="submit" value="上传" />
</form>
<hr />
<form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/index/index/testUploadPic" method="post" enctype="multipart/form-data">
    请选择上传企业logo：<input type="file" name="myFile" /><br />
    <input type="submit" value="上传" />
</form>
<hr />
<form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/index/index/testUploadPic" method="post" enctype="multipart/form-data">
    请选择上传营业照：<input type="file" name="myFile" /><br />
    <input type="submit" value="上传" />
</form>
<hr />
<form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/index/index/testUploadPic" method="post" enctype="multipart/form-data">
    请选择上传员工头像：<input type="file" name="myFile" /><br />
    <input type="submit" value="上传" />
</form>
<ul>
    <li><a href="javascript:GLOBAL.sendMobileMsg()">发送手机验证码</a></li>
    <li><a href="javascript:GLOBAL.sign()">注册</a></li>
    <li><a href="javascript:GLOBAL.login()">登录</a></li>
    <li><a href="javascript:GLOBAL.logout()">注销</a></li>
    <li><a href="javascript:GLOBAL.forgetPass()">忘记密码</a></li>
    <li><a href="javascript:GLOBAL.resetPass()">重置密码</a></li>
    <li><a href="javascript:GLOBAL.checkUserEmail()">验证用户是否完成了邮箱信息</a></li>
    <hr />
    <h3>学员模块</h3>
    <li>
        <select id="param">
            <option value="base">基本</option>
            <option value="center">核心</option>
            <option value="course">课程</option>
            <option value="education">教育</option>
            <option value="project">项目</option>
            <option value="work">工作</option>
            <option value="recommend">推荐</option>
            <option value="concern">关注</option>
            <option value="concerned">被关注</option>
        </select>
    </li>
    <li><a href="javascript:GLOBAL.getStudentInfo()">获得学生信息</a></li>
    <li><a href="javascript:GLOBAL.modifyStudentPass()">修改学生密码</a></li>
    <li><a href="javascript:GLOBAL.modifyStudentBaseInfo()">修改学生基本信息</a></li>
    <li><a href="javascript:GLOBAL.modifyStudentWorkInfo()">修改学生工作信息</a></li>
    <li><a href="javascript:GLOBAL.modifyStudentProjectInfo()">修改学生项目信息</a></li>
    <li><a href="javascript:GLOBAL.modifyStudentEducationInfo()">修改学生教育信息</a></li>
    <hr>
    <li><a href="javascript:GLOBAL.getAllCourse()">获得所有的开课信息</a></li>
    <li><a href="javascript:GLOBAL.getOneCourseInfo()">获得某个课程信息</a></li>
    <li><a href="javascript:GLOBAL.getClassList()">获得开班信息列表</a></li>
    <li><a href="javascript:GLOBAL.getOneClassInfo()">获得某个班级的详细信息</a></li>
    <li><a href="javascript:GLOBAL.getNewsList()">获得新闻列表信息</a></li>
    <li><a href="javascript:GLOBAL.getOneNewsInfo()">获得某个新闻的详细信息</a></li>
    <li><a href="javascript:GLOBAL.getRecruitList()">获得招聘列表信息</a></li>
    <li><a href="javascript:GLOBAL.getOneJobInfo()">获得某个职位的详细信息</a></li>
    <li><a href="javascript:GLOBAL.getStudentListForClass()">获得已参加某课程的学员列表信息</a></li>
</ul>
</body>
<script src="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
static/js/jquery.min.js"></script>
<script>
    var GLOBAL = {};
    GLOBAL.ajax = function(url,data)
    {
        var url = "<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
"+url;
        var dataType = 'json';
        var type = "POST";
        var success = function(data) {
            alert(data.status+'---'+data.msg);
        }
        var error = function(jqXHR) {
            alert('发生了错误'+jqXHR.status);
        }
        $.ajax({
            "url":url,
            "data":data,
            "dataType":dataType,
            "type":type,
            "success":success,
//            "error":error
        });
    }
    GLOBAL.ajaxGet = function(url)
    {
        var url = "<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
"+url;
        var dataType = 'json';
        var type = "GET";
        var success = function(data) {
            alert(data.status+'---'+data.msg);
        }
        var error = function(jqXHR) {
            alert('发生了错误'+jqXHR.status);
        }
        $.ajax({
            "url":url,
            "dataType":dataType,
            "type":type,
            "success":success,
//            "error":error
        });
    }

    //发送手机验证码
    GLOBAL.sendMobileMsg = function ()
    {
        var url  = 'index.php/api/admin/sendMobileMsg';
        var data = {
            'mobile':'18917095102',
            'type':1
        };
        GLOBAL.ajax(url,data);
    }


    //注册
    GLOBAL.sign = function ()
    {
        var url = 'index.php/api/admin/sign';
        var data = {
            /*"invitation":'1601321102',
            "name":'peterMorry',
            "mobile":'18917065421',
            'email':'18917065421@163.com',
            'password':'cheng1',
            "caseId":1,*/
            'mobile':'18917095102',
            'password':'cheng1',
            'msgCode':'5187',
        };
        GLOBAL.ajax(url,data);
    }

    //登录
    GLOBAL.login = function ()
    {
        var url = 'index.php/api/admin/login';
        var data = {
//            "verifyCode":'er84',
            "accNumber":'18917095102',
            //"accNumber":'18967023459',
            "password":'cheng1',
        };
        GLOBAL.ajax(url,data);
    }
    //注销
    GLOBAL.logout = function()
    {
        var url = 'index.php/api/admin/logout';
        GLOBAL.ajax(url,null);
    }

    //忘记密码
    GLOBAL.forgetPass = function ()
    {
        var url = 'index.php/api/admin/forgetPass';
        var data = {
            "mobile":'18967023459',
            "email":'zhengcheng@568it.cn',
        };
        GLOBAL.ajax(url,data);
    }
    //重置密码
    GLOBAL.resetPass = function()
    {
        var url = 'index.php/api/admin/resetPass';
        var data = {
            "mobile":'13289801234',
            "caseId":1,
            "password_1":'cheng1',
            "password_2":'cheng1',
        };
        GLOBAL.ajax(url,data);
    }

    //验证用户邮箱信息是否完成
    GLOBAL.checkUserEmail = function()
    {
        var url  = 'index.php/api/admin/checkUserEmail';
        GLOBAL.ajaxGet(url);
    }

    //获得学生信息
    GLOBAL.getStudentInfo = function()
    {
        var url = 'index.php/api/student/getStudentInfo';
        var param = $("#param").val();
        var data = {
            "accNumber":'1601321102',
            "param":param,
        };
        GLOBAL.ajax(url,data);
    }

    //修改学生密码
    GLOBAL.modifyStudentPass = function ()
    {
        var url     = 'index.php/api/student/modifyStudentPass';
        var data    = {
            'oldPass'   :'cheng2',
            'password_1':'cheng2',
            'password_2':'cheng2',
        };
        GLOBAL.ajax(url,data);
    }

    //修改学生基本信息
    GLOBAL.modifyStudentBaseInfo = function()
    {
        var url     = 'index.php/api/student/modifyStudentBaseInfo';
        var data    = {
            'mobile':'13289801234',
        };
        GLOBAL.ajax(url,data);
    }

    //修改学生工作经验信息
    GLOBAL.modifyStudentWorkInfo = function()
    {
        var url     = 'index.php/api/student/modifyStudentWorkInfo';
        var data    = {
            'id':1,
            'compAddress':'shengHua',
        };
        GLOBAL.ajax(url,data);
    }

    //修改学生项目信息
    GLOBAL.modifyStudentProjectInfo = function ()
    {
        var url     = 'index.php/api/student/modifyStudentProjectInfo';
        var data    = {
            "projectId": "2",
            "stuDescription": "负责网站数据库设计及后台管理的开发",
        };
        GLOBAL.ajax(url,data);
    }

    //修改学生教育信息
    GLOBAL.modifyStudentEducationInfo = function ()
    {
        var url     = 'index.php/api/student/modifyStudentEducationInfo';
        var data    = {
            'id':1,
            'eduSchool1':'情感大学',
        };
        GLOBAL.ajax(url,data);
    }

    //获得所有的开课信息
    GLOBAL.getAllCourse = function ()
    {
        var url     = 'index.php/api/index/getAllCourse';
        GLOBAL.ajaxGet(url);
    }

    //获得开班列表信息
    GLOBAL.getClassList = function()
    {
        var url     = 'index.php/api/index/getClassList';
        var data    = {
            'courseId':'56803',
            'addressId':1
        };
        GLOBAL.ajax(url,data);
    }

    //获得某个课程的详细信息
    GLOBAL.getOneCourseInfo = function()
    {
        var url  = 'index.php/api/index/getOneCourseInfo';
        var data = {
            'courseId':'56801',
            'page':1,
            'pageSize':10
        };
        GLOBAL.ajax(url,data);
    }

    //获取某个班级的详细信息
    GLOBAL.getOneClassInfo = function()
    {
        var url  = 'index.php/api/index/getOneClassInfo';
        var data = {
            'classId':1
        };
        GLOBAL.ajax(url,data);
    }

    //获取新闻列表信息
    GLOBAL.getNewsList = function()
    {
        var url  = 'index.php/api/index/getNewsList';
        var data = {
            'page':1,
            'pageSize':8,
        };
        GLOBAL.ajax(url,data);
    }

    //获取某个新闻的详细信息
    GLOBAL.getOneNewsInfo = function()
    {
        var url  = 'index.php/api/index/getOneNewsInfo';
        var data = {
            'id':1,
        };
        GLOBAL.ajax(url,data);
    }

    //获得职位列表信息
    GLOBAL.getRecruitList = function ()
    {
        var url  = 'index.php/api/index/getRecruitList';
        var data = {
            'page':1,
            'pageSize':8,
            'compId':'com5680001'
        };
        GLOBAL.ajax(url,data);
    }

    //获得某个职位的详细信息
    GLOBAL.getOneJobInfo = function()
    {
        var url  = 'index.php/api/index/getOneJobInfo';
        var data = {
            'jobId':1,
        };
        GLOBAL.ajax(url,data);
    }

    //获得已报名某课程的学员列表信息
    GLOBAL.getStudentListForClass = function()
    {
        var url  = 'index.php/api/index/getStudentListForClass';
        var data = {
            'classId':'1',
            'page':1,
            'pageSize':8,
        };
        GLOBAL.ajax(url,data);
    }
</script>
</html><?php }} ?>
