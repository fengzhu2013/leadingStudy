<?php /* Smarty version Smarty-3.1.16, created on 2017-10-14 20:59:02
         compiled from "tpl/index.html" */ ?>
<?php /*%%SmartyHeaderCode:19322781595997cdbfe03378-03882739%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa2339e012cdf7510e1a8ab8504391dca6160e12' => 
    array (
      0 => 'tpl/index.html',
      1 => 1507985941,
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
    <input type="text" name="test">
    <input type="submit" value="上传" />
</form>
<form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/api/student/uploadPic" method="post" enctype="multipart/form-data">
    请选择上传学生头像：<input type="file" name="myFile[]" /><br />
    <input type="file" name="myFile[]" /><br />
    <input type="text" name="test">
    <input type="submit" value="上传" />
</form>
<hr />
<form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/index/test/testUploadPic" method="post" enctype="multipart/form-data">
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
    <li><a href="javascript:GLOBAL.getStudentResumeInfo()">获得学员的简历信息</a></li>
    <li><a href="javascript:GLOBAL.getStudentResumeLogInfo()">学员查看30天内投递的简历记录</a></li>
    <li><input type="text" placeholder="职位id" id="jobId_3"/></li>
    <li><a href="javascript:GLOBAL.sendResume()">学员投递简历</a></li>
    <li>
        <form>
            <input type="text" id="compName_1" placeholder="企业名"/>
            <input type="text" id="compAddress_1" placeholder="地址"/>
            <input type="text" id="jobName_1" placeholder="职位名"/>
            <input type="text" id="salary_1" placeholder="薪水"/>
            <input type="text" id="treatment_1" placeholder="待遇"/>
            <input type="text" id="dateWork_1" placeholder="入职时间"/>
            <input type="text" id="workOut_1" placeholder="离职时间"/>
            <input type="text" id="description_1" placeholder="工作内容简介"/>
            <input type="button" id="addWork_1" value="添加工作">
        </form>
    </li>
    <li>
        <form>
            <input type="text" id="eduSchool_1" placeholder="学校"/>
            <input type="text" id="major_1" placeholder="专业"/>
            <input type="text" id="dateinto_1" placeholder="入学时间"/>
            <input type="text" id="dateout_1" placeholder="离校时间"/>
            <input type="text" id="highest_1" placeholder="最高学历"/>
            <input type="button" id="addEducation_1" value="添加教育">
        </form>
    </li>
    <li>
        <form>
            <input type="text" id="projectName_1" placeholder="项目名"/>
            <input type="text" id="description_2" placeholder="项目介绍"/>
            <input type="text" id="status_1" placeholder="是否完成"/>
            <input type="text" id="startTime_1" placeholder="开始时间"/>
            <input type="text" id="endTime_1" placeholder="结束时间"/>
            <input type="text" id="picUrl_1" placeholder="项目截图"/>
            <input type="text" id="url_1" placeholder="项目地址"/>
            <input type="text" id="people_1" placeholder="参与人数"/>
            <input type="text" id="stuDescription_1" placeholder="负责功能介绍">
            <input type="text" id="professional_1" placeholder="运用到的技术">
            <input type="button" id="addProject_1" value="添加项目"/>
        </form>
    </li>
    <hr>
    <h3>前端模块</h3>
    <li><a href="javascript:GLOBAL.getAllCourse();">获得所有的开课信息</a></li>
    <li><a href="javascript:GLOBAL.getOneCourseInfo();">获得某个课程信息</a></li>
    <li><a href="javascript:GLOBAL.getClassList();">获得开班信息列表</a></li>
    <li><a href="javascript:GLOBAL.getOneClassInfo();">获得某个班级的详细信息</a></li>
    <li><a href="javascript:GLOBAL.getNewsList();">获得新闻列表信息</a></li>
    <li><a href="javascript:GLOBAL.getOneNewsInfo();">获得某个新闻的详细信息</a></li>
    <li><a href="javascript:GLOBAL.getRecruitList();">获得招聘列表信息</a></li>
    <li><a href="javascript:GLOBAL.getOneJobInfo();">获得某个职位的详细信息</a></li>
    <li><a href="javascript:GLOBAL.getStudentListForClass();">获得已参加某课程的学员列表信息</a></li>
    <li><a href="javascript:GLOBAL.getProjectList();">获得项目列表信息</a></li>
    <li><a href="javascript:GLOBAL.getOneProjectInfo();">获得项目的详细信息</a></li>
    <li><a href="javascript:GLOBAL.getCarouselList();">获得轮播图列表信息</a></li>
    <hr/>
    <h3>编辑模块</h3>
    <li><a href="javascript:GLOBAL.getEditBaseInfo();">获得编辑员的基本信息</a></li>
    <li><a href="javascript:GLOBAL.getStudentListForClass();">获得一个班级的学员信息</a></li>
    <li><a href="javascript:GLOBAL.getProjectList();">获得项目列表信息</a></li>
    <li><a href="javascript:GLOBAL.getOneProjectInfo();">获得一个项目的详细信息</a></li>
    <li><a href="javascript:GLOBAL.getCarouselList();">获得轮播图列表信息</a></li>
    <li><a href="javascript:GLOBAL.getVedioList();">获得视频列表信息</a></li>
    <li><a href="javascript:GLOBAL.handleTempInfo();">处理临时注册信息</a></li>
    <li><a href="javascript:GLOBAL.getRegisterInfo();">获得注册信息</a></li>
    <li><a href="javascript:GLOBAL.getCourseList();">获得大课课程列表信息</a></li>
    <li><a href="javascript:GLOBAL.modifyCourseInfo();">修改大课课程信息</a></li>
    <li><a href="javascript:GLOBAL.addOneCourse();">添加一条课程信息</a></li>
    <li><a href="javascript:GLOBAL.modifyPass();">管理员修改密码</a></li>
    <li><a href="javascript:GLOBAL.getClassForCourse();">获得一个课程下的所有班级</a></li>
    <li><a href="javascript:GLOBAL.addOneClass();">添加一个班级</a></li>
    <li><a href="javascript:GLOBAL.addTeacherForClass();">为班级添加教师</a></li>
    <li><a href="javascript:GLOBAL.getClassInfo();">获得一个班级的详细信息</a></li>
    <li><a href="javascript:GLOBAL.modifyClassInfo();">修改一个班级的详细信息</a></li>
    <li><a href="javascript:GLOBAL.addOneProject();">添加一个项目信息</a></li>
    <li><a href="javascript:GLOBAL.modifyAccNumberStatus();">修改账号状态</a></li>
    <li><a href="javascript:GLOBAL.modifyAccNumberRangeId();">修改职工权限</a></li>
    <li><a href="javascript:GLOBAL.addOneNews();">添加一条新闻信息</a></li>
    <li><a href="javascript:GLOBAL.getOneNewsInfo();">获得一条新闻信息</a></li>
    <li><a href="javascript:GLOBAL.modifyNewsInfo();">修改一条新闻信息</a></li>

    <hr/>
    <h3>论坛</h3>
    <li><a href="javascript:GLOBAL.addOneArticle();">发表一篇帖子</a></li>
    <li>
        <form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/api/forum/addOneArticle" method="post" enctype="multipart/form-data">
            标题：  <input type="text" name="title" placeholder="标题"><br />
            关键字：<input type="text" name="keywords" placeholder="关键字"><br />
            内容：  <input type="text" name="content" placeholder="内容"><br />
            图片1： <input type="file" name="myFile[]"><br/>
            图片2： <input type="file" name="myFile[]"><br/>
            图片3： <input type="file" name="myFile[]"><br/>
            <input type="submit" value="发表文章">
        </form>
    </li>
    <li>
        <form action="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
index.php/api/forum/modifyOneArticle" method="post" enctype="multipart/form-data">
            编号： <input type="text" name="fa_id" placeholder="文章编号"/><br />
            标题：  <input type="text" name="title" placeholder="标题"><br />
            关键字：<input type="text" name="keywords" placeholder="关键字"><br />
            内容：  <input type="text" name="content" placeholder="内容"><br />
            图片1： <input type="file" name="myFile[]"><br/>
            图片2： <input type="file" name="myFile[]"><br/>
            图片3： <input type="file" name="myFile[]"><br/>
            <input type="submit" value="修改文章">
        </form>
    </li>
    <li><a href="javascript:GLOBAL.deleteOneArticle();">删除一篇帖子</a></li>
    <li><a href="javascript:GLOBAL.getOneArticleInfo();">获得一篇帖子详细信息</a></li>
    <li><a href="javascript:GLOBAL.getArticleList();">获得帖子列表信息</a></li>
    <li><a href="javascript:GLOBAL.addOneComment();">添加一条评论</a></li>
    <li><a href="javascript:GLOBAL.getCommentListInfo();">获得评论信息</a></li>
    <li><a href="javascript:GLOBAL.CommentOnInfo();">点赞或踩👎</a></li>
    <li><a href="javascript:GLOBAL.getCommentOnNum();">获得帖子或评论的点赞数</a></li>
</ul>
</body>
<script src="<?php echo $_smarty_tpl->tpl_vars['root_path']->value;?>
static/js/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#addWork_1").bind('click',GLOBAL.studentAddWork);
        $("#addEducation_1").bind('click',GLOBAL.studentAddEducation);
        $("#addProject_1").bind('click',GLOBAL.studentAddProject);
    });
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
            //"accNumber":'18917095102',          //temp
            "accNumber":'13289801234',          //student
            //"accNumber":'18817095201',
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
            "mobile":'13289801234',
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

    //获得项目列表信息
    GLOBAL.getProjectList = function()
    {
        var url  = 'index.php/api/index/getProjectList';
        var data = {
//            'type' : 1,
            'relationship':'php',
        };
        GLOBAL.ajax(url,data);
    }

    //获得某个项目的详细信息
    GLOBAL.getOneProjectInfo = function()
    {
        var url  = 'index.php/api/index/getOneProjectInfo';
        var data = {
            'projectId':14,
        };
        GLOBAL.ajax(url,data);
    }

    //获得轮播图列表信息
    GLOBAL.getCarouselList = function()
    {
        var url  = 'index.php/api/index/getCarouselList';
        var data = {

        };
        GLOBAL.ajax(url,data);
    }

    //添加工作经验
    GLOBAL. studentAddWork = function()
    {
        var url  = 'index.php/api/student/addStudentOneWorkInfo';
        var data = {
            'compName'      :$("#compName_1").val(),
            'compAddress'   :$("#compAddress_1").val(),
            'jobName'       :$("#jobName_1").val(),
            'salary'        :$("#salary_1").val(),
            'treatment'     :$("#treatment_1").val(),
            'dateWork'      :$("#dateWork_1").val(),
            'workOut'       :$("#workOut_1").val(),
            'description'   :$("#description_1").val()
        };
        GLOBAL.ajax(url,data);
    }

    //学员添加教育经验
    GLOBAL.studentAddEducation = function ()
    {
        var url  = 'index.php/api/student/addStudentOneEducationInfo';
        var data = {
            'eduSchool'     :$("#eduSchool_1").val(),
            'major'         :$("#major_1").val(),
            'dateinto'      :$("#dateinto_1").val(),
            'dateout'       :$("#dateout_1").val(),
            'highest'       :$("#highest_1").val()
        };
        GLOBAL.ajax(url,data);
    }

    //学员添加项目
    GLOBAL.studentAddProject = function ()
    {
        var url  = 'index.php/api/student/addStudentOneProjectInfo';
        var data = {
            'projectName'   :$("#projectName_1").val(),
            'description'   :$("#description_2").val(),
            'status'        :$("#status_1").val(),
            'startTime'     :$("#startTime_1").val(),
            'endTime'       :$("#endTime_1").val(),
            'picUrl'        :$("#picUrl_1").val(),
            'url'           :$("#url_1").val(),
            'people'        :$("#people_1").val(),
            'stuDescription':$("#stuDescription_1").val(),
            'professional'  :$("#professional_1").val(),
        };
        GLOBAL.ajax(url,data);
    }

    //获得学员简历信息
    GLOBAL.getStudentResumeInfo = function()
    {
        var url  = 'index.php/api/student/getStudentResumeInfo';
        GLOBAL.ajaxGet(url);
    }

    //学员查看30天内投递的简历记录
    GLOBAL.getStudentResumeLogInfo = function()
    {
        var url  = 'index.php/api/student/getStudentResumeLogInfo';
        GLOBAL.ajaxGet(url);
    }

    //学员投递简历
    GLOBAL.sendResume = function()
    {
        var url  = 'index.php/api/student/sendResume';
        var data = {
            'jobId':$("#jobId_3").val(),
        };
        GLOBAL.ajax(url,data);
    }

    //获得编辑员的基本信息
    GLOBAL.getEditBaseInfo = function()
    {
        var url  = 'index.php/api/edit/getEditBaseInfo';
        GLOBAL.ajaxGet(url);
    }

    //获得一个班级的学员信息
    GLOBAL.getStudentListForClass = function()
    {
        var url  = 'index.php/api/edit/getStudentListForClass';
        var data = {
            'classId':1,
        };
        GLOBAL.ajax(url,data);
    }

    //获得项目列表信息
    GLOBAL.getProjectList = function()
    {
        var url  = 'index.php/api/edit/getProjectList';
        var data = {
            //'type':2
            'relationship':'php'
        };
        GLOBAL.ajax(url,data);
    }

    //获得一个项目的详细信息
    GLOBAL.getOneProjectInfo = function()
    {
        var url  = 'index.php/api/edit/getOneProjectInfo';
        var data = {
            'projectId':1
        };
        GLOBAL.ajax(url,data);
    }

    //获得轮播图列表信息
    GLOBAL.getCarouselList = function()
    {
        var url  = 'index.php/api/edit/getCarouselList';
        var data = {
            'page':1,
        };
        GLOBAL.ajax(url,data);
    }

    //获得视频列表信息
    GLOBAL.getVedioList = function()
    {
        var url  = 'index.php/api/edit/getVedioList';
        var data = {
            'page'      :1,
            'courseId'  :'56803',
        };
        GLOBAL.ajax(url,data);
    }

    //处理临时注册信息
    GLOBAL.handleTempInfo = function()
    {
        var url  = 'index.php/api/edit/handleTempInfo';
        var data = {
            'tmpId'     :'tmp5680009',
            'status'    :2,
            'caseId'    :9,
            /*'classId'   :1,
            'addressId' :1,*/
        };
        GLOBAL.ajax(url,data);
    }

    //获得注册信息
    GLOBAL.getRegisterInfo = function()
    {
        var url  = 'index.php/api/edit/getRegisterInfo';
        var data = {

        };
        GLOBAL.ajax(url,data);
    }

    //获得大课课程列表信息
    GLOBAL.getCourseList = function()
    {
        var url  = 'index.php/api/edit/getCourseList';
        var data = {
            'status':1,
        };
        GLOBAL.ajax(url,data);
    }

    //修改大课课程信息
    GLOBAL.modifyCourseInfo = function()
    {
        var url  = 'index.php/api/edit/modifyCourseInfo';
        var data = {
            'courseId':'56809',
            'description':'draw',
        };
        GLOBAL.ajax(url,data);
    }

    //添加一条课程信息
    GLOBAL.addOneCourse = function()
    {
        var url  = 'index.php/api/edit/addOneCourse';
        var data = {
            'courseName'    :'大数据3',
            'description'   :'数据处理',
            'status'        :0
        };
        GLOBAL.ajax(url,data);
    }

    //管理员修改密码
    GLOBAL.modifyPass = function()
    {
        var url  = 'index.php/api/edit/modifyPass';
        var data = {
            'mobile'    :'18917095102',
            'password'  :'cheng1',
        };
        GLOBAL.ajax(url,data);
    }

    //获得一个课程下的所有班级
    GLOBAL.getClassForCourse = function()
    {
        var url  = 'index.php/api/edit/getClassForCourse';
        var data = {
            'courseId'  :'56801',
            //'classType' :1,
        };
        GLOBAL.ajax(url,data);
    }

    //添加一个班级
    GLOBAL.addOneClass = function ()
    {
        var url  = 'index.php/api/edit/addOneClass';
        var data = {
            'name':'李好',
            'courseId':'56803',
            'className':'web基础班2'
        };
        GLOBAL.ajax(url,data);
    }

    //为班级添加教师
    GLOBAL.addTeacherForClass = function()
    {
        var url  = 'index.php/api/edit/addTeacherForClass';
        var data = {
            'classId' :2,
            'name'    :['李好','李及'],
        };
        GLOBAL.ajax(url,data);
    }

    //获得一个班级的详细信息
    GLOBAL.getClassInfo = function ()
    {
        var url  = 'index.php/api/edit/getClassInfo';
        var data = {
            'classId':1,
        };
        GLOBAL.ajax(url,data);
    }

    //修改一个班级信息
    GLOBAL.modifyClassInfo = function()
    {
        var url  = 'index.php/api/edit/modifyClassInfo';
        var data = {
            'classId'   :1,
            'name'      :'李及',
            'teacher'   :{
                'id':[1,2],'name':['李好','李及']
            },
        };
        GLOBAL.ajax(url,data);
    }

    //添加一条项目信息
    GLOBAL.addOneProject = function()
    {
        var url  = 'index.php/api/edit/addOneProject';
        var data = {
            'projectName'   :'学习web前端4',
            'description'   :'为了更好的学习与实践',
            'startTime'     :'2017-4-12',
            'endTime'       :'2017-10-9',
            'people'        :10,
            'relationship'  :'html,css,javascript',
            'url'           :'http://yuanqiong68.cn',
            'status'        :1
        };
        GLOBAL.ajax(url,data);
    }

    //修改账号状态
    GLOBAL.modifyAccNumberStatus = function()
    {
        var url  = 'index.php/api/edit/modifyAccNumberStatus';
        var data = {
            'mobile':'18917095102',
            'status':2,
        };
        GLOBAL.ajax(url,data);
    }

    //修改职工账号权限
    GLOBAL.modifyAccNumberRangeId = function()
    {
        var url  = 'index.php/api/edit/modifyAccNumberRangeId';
        var data = {
            'mobile':'18918012342',
            'rangeId':3,
        };
        GLOBAL.ajax(url,data);
    }

    //添加一条新闻
    GLOBAL.addOneNews = function()
    {
        var url  = 'index.php/api/edit/addOneNews';
        var data = {
            'title'         :'web',
            'description'   :'学习web',
            'content'       :'达到发呆发呆发呆',
            'courseId'      :'56803,56802',
            'top'           :1,
            'author'        :'18917095102'
        };
        GLOBAL.ajax(url,data);
    }

    //获得一条信息信息
    GLOBAL.getOneNewsInfo = function()
    {
        var url  = 'index.php/api/edit/getOneNewsInfo';
        var data = {
            'id':2,
        };
        GLOBAL.ajax(url,data);
    }

    //修改一条新闻信息
    GLOBAL.modifyNewsInfo = function()
    {
        var url  = 'index.php/api/edit/modifyNewsInfo';
        var data = {
            'id':1,
            'description':'xxxx',
        };
        GLOBAL.ajax(url,data);
    }

    //发表一篇帖子
    GLOBAL.addOneArticle = function()
    {
        var url  = 'index.php/api/forum/addOneArticle';
        var data = {

        };
        GLOBAL.ajax(url,data);
    }

    //删除一篇帖子
    GLOBAL.deleteOneArticle = function()
    {
        var url  = 'index.php/api/forum/deleteOneArticle';
        var data = {
            'fa_id':2
        };
        GLOBAL.ajax(url,data);
    }

    //获得一篇帖子的详细信息
    GLOBAL.getOneArticleInfo = function()
    {
        var url  = 'index.php/api/forum/getOneArticleInfo';
        var data = {
            'fa_id':2,
        };
        GLOBAL.ajax(url,data);
    }

    //获得帖子列表信息
    GLOBAL.getArticleList = function()
    {
        var url  = 'index.php/api/forum/getArticleList';
        var data = {
            'keywords':'llll'
        };
        GLOBAL.ajax(url,data);
    }

    //添加一条评论
    GLOBAL.addOneComment = function()
    {
        var url  = 'index.php/api/forum/addOneComment';
        var data = {
            'fa_id':2,
            'content':'listen good'
        };
        GLOBAL.ajax(url,data);
    }

    //获得评论信息
    GLOBAL.getCommentListInfo = function ()
    {
        var url  = 'index.php/api/forum/getCommentListInfo';
        var data = {
            'fc_id':2,
        };
        GLOBAL.ajax(url,data);
    }

    //点赞或踩
    GLOBAL.CommentOnInfo = function()
    {
        var url  = 'index.php/api/forum/CommentOnInfo';
        var data = {
            'fc_id':2,
            'status':0
        };
        GLOBAL.ajax(url,data);
    }

    //获得某个帖子或留言的点赞或踩的数量
    GLOBAL.getCommentOnNum = function ()
    {
        var url  = 'index.php/api/forum/getCommentOnNum';
        var data = {
            'id':2,
            'type':2
        };
        GLOBAL.ajax(url,data);
    }

</script>
</html><?php }} ?>
