<?php
namespace App\api\Model;

use App\common\Model\actionModel;
use App\common\Model\baseModel;
use App\common\Model\commonModel;
use App\common\Model\tableInfoModel;
use App\common\Model\verifyModel;
use function Sodium\crypto_aead_aes256gcm_decrypt;

class editModel extends baseModel
{
    private $table;
    private $where;
    private $pages;
    private $accNumber;
    public  $isTrue;
    public  $info;
    public function __construct($isVerify = true)
    {
        parent::__construct($isVerify);
        $this->accNumber = $this->getAccNumber();
        $this->table     = tableInfoModel::getLeading_staff_info();
        if ($this->accNumber) {
            $this->isTrue = true;
            $this->where['accNumber'] = $this->accNumber;
            $instance = new commonModel();
            //登录的账号不是编辑员的
            if (!$instance->verifyIsStaffId($this->accNumber))
                $this->isTrue = false;
        }

    }

    /**
     * 获得编辑员的基本信息
     * @return array
     */
    public function getEditBaseInfo()
    {
        $arr      = ['mobile','name','email'];
        $response = parent::fetchOneInfo($this->table,$arr,$this->where);
        return parent::formatDatabaseResponse($response);
    }


    /**
     * 获得一个班级的所有学员
     * @return mixed|string
     */
    public function getStudentListForClass()
    {
        //不存在classId
        if (!$this->_LP['classId'])
            return '20001';
        $obj         = new actionModel();
        $res         = $obj->getClassInfoById($this->_LP['classId'],['ClassName']);
        //classId 错误
        if (!count($res))
            return '50004';
        $this->table = [tableInfoModel::getLeading_student(),tableInfoModel::getLeading_student_info()];
        $this->where = ['classId' => $this->_LP['classId'],'where2' => ' AND s.`stuId`= f.`stuId` '];
        $pages       = parent::getPages();
        $arr         = ['stuId','name','dateinto'];
        $response    = getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']);
        return parent::formatDatabaseResponse($response);
    }

    //添加一条新闻信息
    public function addOneNews()
    {

    }

    //获得一条信息的详细信息
    public function getOneNewsInfo()
    {

    }


    //添加视频信息
    public function addOneVedio()
    {

    }

    //添加一条轮播图信息
    public function addOneCarousel()
    {

    }

    //获得已有的项目列表信息,按类型分为，全部，学员，内部，按类属分为应用到的技术
    public function getProjectList()
    {
        if (!$this->verifyLogined())
            return '50003';
        $this->pages = $this->getPages();
        $this->table = tableInfoModel::getProject();
        $this->where = [];
        $arr         = ['projectId','projectName','startTime','picUrl','url'];
        //查询按类型
        if (isset($this->_LP['type']))
            $this->where['type'] = $this->_LP['type'];
        //运用的技术分类
        if (isset($this->_LP['relationship'])) {
            $whereArr               = explode(',',$this->_LP['relationship']);
        }
        if (isset($whereArr) && count($whereArr)) {
            foreach ($whereArr as $where) {
                $where2[] = " relationship LIKE '%{$where}%' ";
            }
        }
        if (isset($where2) && count($where2) > 1)
            $this->where['where2'] = implode(' OR ',$where2);
        if (isset($where2) && count($where2) == 1)
            $this->where['where2'] = $where2[0];
        if (isset($this->_LP['type']) && isset($this->where['where2']))
            $this->where['where2'] = ' AND '.$this->where['where2'];
        if (!isset($this->_LP['type']) && isset($this->where['where2']))
            $this->where['where2'] = ' WHERE '.$this->where['where2'];
        @$this->where['where2'] = empty($this->where['where2'])?' ORDER BY projectId DESC ':$this->where['where2'].' ORDER BY projectId DESC ';
        $resp = getPage($this->table,$arr,$this->where,$this->pages['page'],$this->pages['pageSize']);
        return parent::formatDatabaseResponse($resp);
    }

    //获得一个项目的详细信息
    public function getOneProjectInfo()
    {
        //如果要检查登录，且没有登录的账号，返回提示信息
        if (!$this->verifyLogined())
            return '50003';
        //没有标识符
        if (!isset($this->_LP['projectId']))
            return '50004';
        $this->table = tableInfoModel::getProject();
        $arr         = ['projectId','projectName','description','startTime','endTime','status','picUrl','url','people'];
        $this->where = ['projectId' => $this->_LP['projectId']];
        $resp        = parent::fetchOneInfo($this->table,$arr,$this->where);
        return parent::formatDatabaseResponse($resp);
    }

    //添加一条项目信息（不是学员的私人项目，可以考虑）
    public function addOneProject()
    {
        //传参不能为空
        $count = count($this->_LP);
        if (!$count)
            return '20001';
        //除了type,url,picUrl不是必需的以外，其他的都是必需的，故元素的个数为7，不考虑 porjectId
        //如果信息不安全，提示信息不安全
        $this->table = tableInfoModel::getProject();
        if ($count < 7 || !verifyModel::verifyInfoIsTrue($this->table,$this->_LP))
            return '20002';
        //格式化时间值
        if (!empty($this->_LP['startTime']))
            $this->_LP['startTime'] = strtotime($this->_LP['startTime']);
        if (!empty($this->_LP['endTime']))
            $this->_LP['endTime']   = strtotime($this->_LP['endTime']);
        //是否重复添加，如果是，提示不用重复添加
        $resp_1      = parent::fetchOneInfo($this->table,['projectId'],$this->_LP);
        if (count($resp_1))
            return '30002';
        //修改信息
        $resp        = parent::insert($this->table,$this->_LP);
        //插入成功返回last_id，条件是该id是自增的
        if ($resp)
            return true;
        return false;
    }


    //获取轮播图列表信息
    public function getCarouselList()
    {
        if (!$this->verifyLogined())
            return '50003';
        $this->table = tableInfoModel::getCarousel_figure();
        $arr         = ['id','picUrl','url','top'];
        $this->where = ['where2' => ' ORDER BY top DESC,id DESC '];
        //如果存在置顶的，取一条置顶的，多条也是取最新的那条
        $pages       = $this->getPages();
        return parent::formatDatabaseResponse(getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']));
    }

    //添加一条轮播图信息
    public function addOneCarouse()
    {

    }

    //获得一条录播图的详细信息
    public function getOneCarouseInfo()
    {

    }

    //获得视频列表信息
    public function getVedioList()
    {
        //如果要检查登录，且没有登录的账号，返回提示信息
        if (!$this->verifyLogined())
            return '50003';
        $this->table    = tableInfoModel::getVedio();
        $arr            = ['vedioId','vedioName','vedioUrl','picUrl'];
        //如果传参courseId
        if (isset($this->_LP['courseId']) && !empty($this->_LP['courseId'])) {
            //课程号错误
            if (!verifyModel::verifyCourseIdIsTrue($this->_LP['courseId']))
                return '50004';
            $this->where = ['courseId' => $this->_LP['courseId']];
        }
        //获得分页信息
        $pages    = $this->getPages();
        //获取数据信息
        $response = getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']);
        //格式化数据数据
        return $this->formatDatabaseResponse($response);

    }

    //获得一个视频的详细信息
    public function getOneVedioInfo()
    {

    }


    //处理临时注册信息
    public function handleTempInfo()
    {
        //获得tmpId和status
        @$tmpId     = $this->_LP['tmpId'];
        @$status    = intval($this->_LP['status']);

        //传参不齐全
        if (!$tmpId || !$status)
            return '20001';

        //通过临时账号获得所有账号信息
        $resp_1     = $this->getTempInfoById($tmpId);
        //临时账号错误或没有账号信息
        if (empty($resp_1))
            return '50004';
        $this->where  = ['tmpId' => $tmpId];

        //状态修改未通过
        if ($status == 0) {
            $resp_2 = $this->modifyStatusOfAcc($this->where,0,$this->table);
            return parent::formatDatabaseResponse($resp_2);
        }

        //状态修改为通过
        if ($status == 2) {
            $resp_3 = $this->handleInfo($resp_1);
            if (is_bool($resp_3) && $resp_3) {
                $resp_4 = $this->modifyStatusOfAcc($this->where,2,$this->table);
            }
            //两者都修改成功，返回true
            if (is_bool($resp_3) && $resp_3 && $resp_4)
                return true;
            //插入信息成功，修改状态失败，提示系统维修中
            if (is_bool($resp_3) && $resp_3)
                return '10003';
            return $resp_3;
        }
        //other return false;
        return false;
    }

    //通过临时账号获得所有账号信息
    public function getTempInfoById($tmpId)
    {
        $arr            = ['*'];
        $this->table    = tableInfoModel::getTemp_register();
        $this->where    = ['tmpId' => $tmpId];
        return parent::fetchOneInfo($this->table,$arr,$this->where);
    }


    /**
     * 改变账号的状态
     * @param array $accNumber [key => val]就是where条件
     * @param $status   改变的状态
     * @param null $table
     * @return mixed
     */
    public function modifyStatusOfAcc($accNumber,$status,$table = null)
    {
        if (is_null($table))
            $table = $this->table;
        $arr    = ['status' => $status];
        $resp   = parent::fetchOneInfo($table,['status'],$accNumber);
        //如果更改的状态和更改之前一样，直接true
        if (count($resp) && $resp['status'] == $status)
            return true;
        return parent::updateInfo($table,$arr,$accNumber);
    }

    /**
     * 处理注册信息
     * @param array $info 注册账号信息
     * @return string
     */
    public function handleInfo($info)
    {
        //没有角色id，提示未知错误哦
        if (!isset($info['caseId']) || empty($info['caseId']))
            return '10002';
        //如果传入了caseId，按传入的值修改，如果没有传入，按申请的修改
        $info['caseId'] = isset($this->_LP['caseId'])?$this->_LP['caseId']:$info['caseId'];
        switch ($info['caseId']) {
            //注册学员
            case 1:
                $resp = $this->handleStudentInfo($info);
                break;
            case 2:
            case 3:
                $resp = $this->handleTeacherInfo($info);
                break;
            case 4:
            case 5:
            case 6:
            case 7:
                $resp = $this->handleEditInfo($info);
                break;
            case 9:
                $resp = $this->handleCompanyInfo($info);
                break;
            case 8:
            default:
        }
        return $resp;
    }

    /**
     * 处理注册学员的临时信息
     * @param $info
     * @return bool|string
     */
    public function handleStudentInfo($info)
    {
        //注册信息为空，提示未知错误
        if (empty($info))
            return '10002';

        //判断手机号和邮箱号是否存在student表中，如果存在，提示已注册
        $res_1       = parent::fetchOneInfo(tableInfoModel::getLeading_student(),['stuId'],['mobile' => $info['mobile']]);
        if (count($res_1))
            return '30008';
        $res_2       = parent::fetchOneInfo(tableInfoModel::getLeading_student(),['stuId'],['email' => $info['email']]);
        if (count($res_2))
            return '30009';

        //判断qq号和微信号是否存在student_info表中，如果存在，提示已注册
        if (isset($info['qq']) && !empty($info['qq'])) {
            $res_3       = parent::fetchOneInfo(tableInfoModel::getLeading_student_info(),['stuId'],['qq' => $info['qq']]);
            if (count($res_3))
                return '30013';
        }
        if (isset($info['wechat']) && !empty($info['wechat'])) {
            $res_4       = parent::fetchOneInfo(tableInfoModel::getLeading_student_info(),['stuId'],['wechat' => $info['wechat']]);
            if (count($res_4))
                return '30014';
        }

        //生成学号
        @$classId    = $this->_LP['classId'];
        @$addressId  = $this->_LP['addressId'];
        if (!$classId || !$addressId)
            return '20001';
        $obj         = new commonModel(false);
        $stuId       = $obj->productStuId($classId,$addressId);

        //先插入student表
        $arr         = ['stuId'     => $stuId,
                        'name'      => $info['name'],
                        'mobile'    => $info['mobile'],
                        'email'     => $info['email'],
                        'password'  => $info['password'],
                        'status'    => 1,
                        'caseId'    => 1,
                        'dateinto'  => time()
                        ];
        $resp_1      = parent::insert(tableInfoModel::getLeading_student(),$arr);
        //插入失败，提示failed
        if (!$resp_1)
            return '10001';

        //插入student_info表
        $arr_2       = ['stuId'     => $stuId,
                        'qq'        => $info['qq'],
                        'wechat'    => $info['wechat'],
                        'classId'   => $classId
                        ];
        $resp_2      = parent::insert(tableInfoModel::getLeading_student_info(),$arr_2);
        //插入失败，提示failed,并且删除插入student的记录
        if (!$resp_2) {
            $resp    = parent::deleteArr(tableInfoModel::getLeading_student_info(),['stuId' => $stuId]);
            return '10001';
        }

        //如果有推荐人，插入推荐表
        $dateinto    = empty($info['dateinto'])?time():$info['dateinto'];
        if (isset($info['recommendId']) && !empty($info['recommendId'])) {
            $arr_3   = ['recommendId'   => $info['recommendId'],
                        'stuId'         => $stuId,
                        'dateinto'      => $dateinto
                        ];
            parent::insert(tableInfoModel::getRecommend(),$arr_3);
        }
        //here everything is ok!
        return true;
    }


    /**
     * 处理教师注册的临时信息,包括班主任和教师
     * @param $info
     * @return string
     */
    public function handleTeacherInfo($info)
    {
        //注册信息为空，提示未知错误
        if (empty($info))
            return '10002';

        //判断手机号和邮箱号是否存在teacher表中，如果存在，提示已注册
        $res_1       = parent::fetchOneInfo(tableInfoModel::getLeading_teacher(),['teacherId'],['mobile' => $info['mobile']]);
        if (count($res_1))
            return '30008';
        $res_2       = parent::fetchOneInfo(tableInfoModel::getLeading_teacher(),['teacherId'],['email' => $info['email']]);
        if (count($res_2))
            return '30009';

        //生成教师号teacherId
        $obj         = new commonModel(false);
        $teacherId   = $obj->productTeacherId();

        //插入teacher表
        $arr         = ['teacherId' => $teacherId,
                        'name'      => $info['name'],
                        'mobile'    => $info['mobile'],
                        'password'  => $info['password'],
                        'email'     => $info['email'],
                        'status'    => 1,
                        'caseId'    => $info['caseId'],
                        'dateinto'  => time(),
                        ];
        $resp_1      = parent::insert(tableInfoModel::getLeading_teacher(),$arr);
        if (!$resp_1)
            return '10001';

        //插入teacher_info表
        $arr_2       = ['teacherId' => $teacherId,
                        'title'     => 1,
                        ];
        $resp_2      = parent::insert(tableInfoModel::getLeading_teacher_info(),$arr_2);

        //if insert successful ,return true,else delete the row of the teacher table
        if ($resp_2)
            return true;
        else
            parent::deleteArr(tableInfoModel::getLeading_teacher(),['teacherId' => $teacherId]);
        //here false
        return false;
    }

    /**
     * 处理内部员工注册信息
     * @param $info
     * @return bool|string
     */
    public function handleEditInfo($info)
    {
        //注册信息为空，提示未知错误
        if (empty($info))
            return '10002';

        //判断手机号和邮箱号是否存在staff_info表中，如果存在，提示已注册
        $res_1       = parent::fetchOneInfo(tableInfoModel::getLeading_staff_info(),['accNumber'],['mobile' => $info['mobile']]);
        if (count($res_1))
            return '30008';
        $res_2       = parent::fetchOneInfo(tableInfoModel::getLeading_staff_info(),['accNumber'],['email' => $info['email']]);
        if (count($res_2))
            return '30009';

        //生成内部员工号
        $obj         = new commonModel(false);
        $accNumber   = $obj->productStaffId();

        //插入staff_info表
        $arr         = ['accNumber' => $accNumber,
                        'name'      => $info['name'],
                        'mobile'    => $info['mobile'],
                        'password'  => $info['password'],
                        'email'     => $info['email'],
                        'status'    => 1,
                        'caseId'    => $info['caseId'],
                        'workTime'  => time(),
                        ];
        $resp_1      = parent::insert(tableInfoModel::getLeading_staff_info(),$arr);
        if ($resp_1)
            return true;
        return false;
    }

    /**
     * 处理注册企业的临时信息
     * @param $info
     * @return bool|string
     */
    public function handleCompanyInfo($info)
    {
        //注册信息为空，提示未知错误
        if (empty($info))
            return '10002';

        //判断手机号和邮箱号是否存在company表中，如果存在，提示已注册
        $res_1       = parent::fetchOneInfo(tableInfoModel::getLeading_company(),['compId'],['mobile' => $info['mobile']]);
        if (count($res_1))
            return '30008';
        $res_2       = parent::fetchOneInfo(tableInfoModel::getLeading_company(),['compId'],['email' => $info['email']]);
        if (count($res_2))
            return '30009';

        //生成企业号
        $obj         = new commonModel(false);
        $compId      = $obj->productCompId();

        //插入company表中
        $arr         = ['compId'    => $compId,
                        'compName'  => $info['name'],
                        'mobile'    => $info['mobile'],
                        'password'  => $info['password'],
                        'email'     => $info['email'],
                        'status'    => 1,
                        'caseId'    => 9 ,
                        'dateinto'  => time(),
                        ];
        $resp_1      = parent::insert(tableInfoModel::getLeading_company(),$arr);
        if (!$resp_1)
            return false;

        //插入company_info表中
        $arr_1       = ['compId'    => $compId,
                        'unionCode' => 0,
                        ];
        $resp_2      = parent::insert(tableInfoModel::getLeading_company_info(),$arr_1);
        //如果插入company_info失败，删除company表的记录
        if ($resp_2)
            return true;
        else
            parent::deleteArr(tableInfoModel::getLeading_company_info(),['compId' => $compId]);

        //here return false
        return false;
    }


    /**
     * 根据条件获得注册信息
     * @return array|string
     */
    public function getRegisterInfo()
    {
        //如果要检查登录，且没有登录的账号，返回提示信息
        if (!$this->verifyLogined())
            return '50003';

        //确定搜索条件
        $this->where = ['where2' => ' ORDER BY id DESC '];
        if (isset($this->_LP['status']))
            $this->where['status'] = $this->_LP['status'];
        if (isset($this->_LP['caseId']))
            $this->where['caseId'] = $this->_LP['caseId'];

        //搜索信息
        $arr         = ['name','mobile','caseId','tmpId','id'];
        $this->table = tableInfoModel::getTemp_register();
        $pages       = $this->getPages();
        $response    = getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']);
        return parent::formatDatabaseResponse($response);
    }

    /**
     * 获得大课课程列表信息
     * @return array
     */
    public function getCourseList()
    {
        //确定搜索条件
        if (isset($this->_LP['status']))
            $this->where = ['status' => $this->_LP['status']];
        $pages       = $this->getPages();
        $this->table = tableInfoModel::getCourse();
        $response    = getPage($this->table,['*'],$this->where,$pages['page'],$pages['pageSize']);
        return parent::formatDatabaseResponse($response);
    }

    public function modifyCourseInfo_1()
    {
        global $_LS;
        $data = array();
        @$accNumber   = $_LS['accNumber'];
        @$courseId    = $_LS['courseId'];
        if ($accNumber && $courseId) {
            if ($this->obj->verifyUser($accNumber)) {
                $arr = array_diff($_LS,array('accNumber' => $accNumber,'courseId' => $courseId));           //要操作的信息数组
                if (count($arr) > 0) {
                    $count = parent::verifyCount($arr,$this->obj->getArr('courseInfo'));
                    if ($count == 0) {                                                                      //信息安全
                        $res_2 = $this->verifyCourseId($courseId);
                        if (count($res_2) > 0) {                                                            //课程号正确
                            $table = $this->obj->getTable('courseTab');
                            $where = array('courseId' => $courseId);
                            /**查看是否需要 **/
                            $where_2 = array_merge($arr,array('courseId' => $courseId));
                            $res_2   = parent::fetchOne_byArr($table,array('courseId'),$where_2);
                            if (count($res_2) == 0) {
                                $data  = parent::update($table,$arr,$where);                                    //修改信息
                                $data  = parent::formatResponse($data);
                            } else {
                                $data['status'] = 16;
                            }
                        } else {
                            $data['status'] = 14;
                            //$data['msg']    = '课程号不存在';
                        }
                    } else {
                        $data['status'] = 5;
                    }
                } else {
                    $data['status'] = 4;
                }
            } else {
                $data['status'] = 3;
            }
        } else {
            $data['status'] = 2;
        }
        return $data;
    }

    /**
     * 修改大课信息，只修改课程名，课程简介，课程状态
     * @return bool|string
     */
    public function modifyCourseInfo()
    {
        /**处理传参信息**/
        $count       = count($this->_LP);
        if (!$count || $count == 1)
            return '20003';
        //如果传参没有courseId，提示没有身份标识符
        if (!isset($this->_LP['courseId']))
            return '50008';
        //验证courseId是否正确
        if (!verifyModel::verifyCourseIdIsTrue($this->_LP['courseId']))
            return '50004';
        //验证传参信息是否安全
        $this->table = tableInfoModel::getCourse();
        if (!verifyModel::verifyInfoIsTrue($this->table,$this->_LP))
            return '20002';

        /**查看修改的信息是否有更改,若有提示不用重复修改**/
        $resp_1      = parent::fetchOneInfo($this->table,['courseId'],$this->_LP);
        if (count($resp_1))
            return '30001';

        /**修改信息**/
        $arr         = array_diff_key($this->_LP,['courseId' => 1]);
        $resp_2      = parent::updateInfo($this->table,$arr,['courseId' => $this->_LP['courseId']]);
        if ($resp_2)
            return true;
        return false;
    }

    /**
     * 一次添加多条课程
     * @return string
     */
    public function addCourse()
    {
        $this->table = tableInfoModel::getCourse();
        /**处理传参，可以是多维数组**/
        $normal      = count($this->_LP);
        if (!$normal)
            return '20001';
        for ($i = 0; $i < $normal;$i++) {

        }
    }

    /**
     * 添加一条课程
     * @return array|string
     */
    public function addOneCourse()
    {
        $this->table = tableInfoModel::getCourse();
        /**处理传参**/
        $count       = count($this->_LP);
        //只能是courseName，description，status
        if ($count != 3)
            return '20001';
        //验证信息是否安全
        if (!verifyModel::verifyInfoIsTrue($this->table,$this->_LP))
            return '20002';
        //验证courseName是否唯一
        $resp_2      = parent::fetchOneInfo($this->table,['courseId'],['courseName' => $this->_LP['courseName']]);
        if (count($resp_2))
            return '30004';

        /**插入数据库**/
        //生成课程号
        $obj         = new commonModel(false);
        $courseId    = $obj->productCourseId();
        $this->_LP['courseId'] = $courseId;
        //插入数据
        $resp_1      = parent::insert($this->table,$this->_LP);
        return true;
    }

    /**
     * 管理员修改密码
     * @return string
     */
    public function modifyPass()
    {
        /**确定传参安全且齐全**/
        if (count($this->_LP) != 2)
            return '20001';
        if (!isset($this->_LP['mobile']) || !isset($this->_LP['password']))
            return '20002';

        //一个账号只能有一个身份
        $obj         = new tableInfoModel();
        $tables      = $obj->getUserTable();
        $where       = ['mobile' => $this->_LP['mobile']];
        $this->table = '';
        foreach ($tables as $table) {
            $resp_1  = parent::fetchOneInfo($table,['id','password'],$where);
            if (count($resp_1)) {
                $this->table = $table;
                break;
            }
        }
        //没有相关表，表示手机号错误
        if (!$this->table)
            return '50004';

        /**修改密码**/
        //如果修改之后的密码没有变化，提示不用重复修改
        $newPassword = myMd5($this->_LP['password']);
        if (isset($resp_1['password']) && $resp_1['password'] == $newPassword)
            return '30001';
        //修改密码
        $resp_2      = parent::updateInfo($this->table,['password' => $newPassword],$where);
        return parent::formatDatabaseResponse($resp_2);
    }


    /**
     * 获得一个课程下的所有班级
     * @return array|string
     */
    public function getClassForCourse()
    {
        //没有传入courseId，提示参数不全
        if (!isset($this->_LP['courseId']))
            return '20001';
        $this->where = ['courseId' => $this->_LP['courseId'],'where2' => ' ORDER BY startClassTime DESC ' ];
        //如果传参classType，加入搜索条件
        if (isset($this->_LP['classType']))
            $this->where['classType'] = $this->_LP['classType'];
        $this->table = tableInfoModel::getLeading_class();
        $arr         = ['classId','className','masterId','startClassTime','endClassTime','classType','addressId'];
        $pages       = $this->getPages();
        $resp_1      = getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']);

        //获取班主任姓名
        $count       = count($resp_1['data']);
        if ($count) {
            for ($i = 0;$i < $count;$i++) {
                $resp_2 = parent::fetchOneInfo(tableInfoModel::getLeading_teacher(),['name'],['teacherId' => $resp_1['data'][$i]['masterId']]);
                if (isset($resp_2['name']))
                    $resp_1['data'][$i]['name'] = $resp_2['name'];
            }
        }
        return parent::formatDatabaseResponse($resp_1);
    }

    /**
     * 添加一个班级信息，包括班级名，班主任id，班级类型等
     * @return array|string
     */
    public function addOneClass()
    {
        /**验证参数信息是否安全**/
        //必需上传教师名称,课程号，班级名
        if(!isset($this->_LP['name']) || !isset($this->_LP['courseId']) || !isset($this->_LP['className']))
            return '20001';
        //通过教师名获得教师号,如果没有教师号，提示标识符错误
        $resp_1      = parent::fetchOneInfo(tableInfoModel::getLeading_teacher(),['teacherId'],['name' => $this->_LP['name']]);
        if (empty($resp_1['teacherId']))
            return '50004';
        $arr         = array_diff_key($this->_LP,['name' => 1]);
        $arr['masterId'] = $resp_1['teacherId'];
        //验证信息是否安全
        if (!verifyModel::verifyInfoIsTrue(tableInfoModel::getLeading_class(),$arr))
            return '20002';
        //验证信息是否重复添加
        if (!verifyModel::verifyIsRepeat(tableInfoModel::getLeading_class(),$arr))
            return '30002';

        /**插入数据库**/
        $resp_2      = parent::insert(tableInfoModel::getLeading_class(),$arr);
        return parent::formatDatabaseResponse($resp_2);

    }

    /**
     * 为一个班级添加教师
     * @return array|string
     */
    public function addTeacherForClass()
    {
        if (!isset($this->_LP['classId']))
            return '20001';
        $count       = count($this->_LP);
        //一个班级最多三个教师,如果超过三个，提示信息不安全
        if ($count > 3)
            return '20002';
        //验证教师姓名是否正确,有一个不正确，提示标识符错误
        foreach ($this->_LP['name'] as $name) {
            $resp_1      = parent::fetchOneInfo(tableInfoModel::getLeading_teacher(),['teacherId'],['name' => $name]);
            if (!count($resp_1))
                return '50004';
            $arr[]       = ['teacherId' => $resp_1['teacherId'],'classId' => $this->_LP['classId']];
        }
        //插入数据
        $resp_2      = parent::insert(tableInfoModel::getLeading_class_teacher(),$arr);
        return parent::formatDatabaseResponse($resp_2);
    }

    /**
     * 获得班级的详细信息
     * @return array|string
     */
    public function getClassInfo()
    {
        //如果没有传入classId，提示参数不齐全
        if (!isset($this->_LP['classId']))
            return '20001';
        $this->info['classId'] = $this->_LP['classId'];
        $this->where = ['classId' => $this->info['classId'],'where2' => ' AND s.masterId=f.teacherId'];
        $this->table = [tableInfoModel::getLeading_class(),tableInfoModel::getLeading_teacher()];
        $resp_1      = parent::fetchOneInfo($this->table,['classId','courseId','className','startClassTime','endClassTime','masterId','name','classType','addressId','time_table'],$this->where);
        //没有信息，提示标识符错误
        if (!count($resp_1))
            return '50004';
        //获得教师信息
        $resp_2      = $this->getClassTeacher();
        if (!empty($resp_2)) {
            $info['class']      = $resp_1;
            $info['teacher']    = $resp_2;
            return parent::formatDatabaseResponse($info);
        }
        return parent::formatDatabaseResponse($resp_1);
    }

    /**
     * 获得一个班级的教师，最多三个
     * @return mixed
     */
    public function getClassTeacher()
    {
        $where = ['classId' => $this->info['classId'],'where2' =>' AND s.teacherId = f.teacherId ORDER BY s.id DESC LIMIT 3'];
        $table = [tableInfoModel::getLeading_class_teacher(),tableInfoModel::getLeading_teacher()];
        $arr   = ['id','teacherId','name'];
        return parent::fetchAllInfo($table,$arr,$where);
    }

    public function modifyClassInfo()
    {
        //classId 必需
        if (!isset($this->_LP['classId']))
            return '20001';
        if (count($this->_LP) < 2)
            return '20002';
        /**处理更改参数，分为class表和class_teacher表**/
        if (isset($this->_LP['teacher'])) {
            $teacher = $this->_LP['teacher'];
        }
        $arr = array_diff_key($this->_LP,['classId' => 1,'teacher' => 1]);

        //有修改class表的信息
        if (count($arr)) {
            $where = ['classId' => $this->_LP['classId']];
            //如果要修改班主任名称
            if (isset($arr['name'])) {
                //确认要修改的班主任名称是否正确,若不正确，提示标识符错误
                $resp_1 = parent::fetchOneInfo(tableInfoModel::getLeading_teacher(),['teacherId'],['name' => $arr['name']]);
                if (!count($resp_1))
                    return '50004';
                //去掉$arr中的name字段
                $arr = array_diff_key($arr,['name' => 1]);
                //加上masterId字段
                $arr['masterId'] = $resp_1['teacherId'];
            }
            //验证$arr中的键是否安全,不安全时提示信息不安全
            if (!verifyModel::verifyInfoIsTrue(tableInfoModel::getLeading_class(),$arr))
                return '20002';
            //是否无效修改，如果是， 不用再修改
            $resp_3 = parent::fetchOneInfo(tableInfoModel::getLeading_class(),['classId'],$arr);
            if (count($resp_3))
                $res_1 = true;
            //修改class表
            if (!isset($res_1))
                $res_1 = parent::updateInfo(tableInfoModel::getLeading_class(),$arr,$where);
        }
        //有修改class表但失败了，直接返回false
        if (isset($res_1) && !$res_1)
            return false;

        /**
         * 有修改class_teacher表的信息.
         * teacher元素组成如下 $teacher = ['id' => [1,2,3],'name' => [xxx,xxx,xxx],……];
         */
        if (isset($teacher) && count($teacher)) {
            //确定修改的where条件
            $where_2['id'] = $teacher['id'];
            //去掉修改中的id字段
            $arr_2         = array_diff_key($teacher,['id' => 1]);
            //如果修改中需要修改教师姓名，全部换成相应的教师id
            if (isset($arr_2['name']) && is_array($arr_2['name'])) {
                foreach ($arr_2['name'] as $name ) {
                    $resp_2 = parent::fetchOneInfo(tableInfoModel::getLeading_teacher(),['teacherId'],['name' => $name]);
                    if (!count($resp_2)) {
                        $res_2 = false;
                        break;
                    } else {
                        $arr_2['teacherId'][] = $resp_2['teacherId'];
                    }
                }
                //去掉name字段
                $arr_2 = array_diff_key($arr_2,['name' => 1]);
            }
            //如果没有问题，修改class_teacher表
            if (!isset($res_2))
                $res_2         = parent::updateInfo(tableInfoModel::getLeading_class_teacher(),$arr_2,$where_2);
        }
        //两个表都修改成功
        if (isset($res_1) && isset($res_2) && $res_1 && $res_2)
            return true;
        //只需要修改教师表，且修改成功
        if (!count($arr) && isset($res_2) && $res_2)
            return true;
        //只需要修改班级表，且修改成功
        if (!isset($teacher) && isset($res_1) && $res_1)
            return true;
        //两个表都修改，class表修改成功，class_teacher表修改失败,提示修改了一部分
        if (isset($res_1) && isset($res_2) && $res_1 && !$res_2)
            return '30015';
        //other return false
        return false;
    }

    /**
     * 修改账号的状态
     * @return array|string
     */
    public function modifyAccNumberStatus()
    {
        //如果参数中没有手机号和状态值，提示信息不全
        if (!isset($this->_LP['mobile']) || !isset($this->_LP['status']))
            return '20001';
        //如果传参的个数不是2，提示信息不安全
        if (count($this->_LP) != 2)
            return '20002';
        //确定账号是否存在,不存在，提示标识符错误
        if (!verifyModel::verifyAccNumberIsSigned($this->_LP['mobile']))
            return '50004';
        //通过手机号获得该账号的状态信息
        $obj         = new commonModel(false);
        $resp_1      = $obj->getInfoByMobile($this->_LP['mobile'],['id','status']);
        //手机号错误，没有相应的信息
        if (isset($resp_1) && is_bool($resp_1))
            return '50004';
        //获得账号所在的用户表
        $this->table = $obj->table;
        //如果重复修改，提示不用重复修改
        if (isset($resp_1['status']) && $this->_LP['status'] == $resp_1['status'])
            return '30001';
        //修改状态
        $resp_2      = parent::updateInfo($this->table,['status' => $this->_LP['status']],['mobile' => $this->_LP['mobile']]);
        return parent::formatDatabaseResponse($resp_2);
    }

    //管理员赋予权限，可以给其他账号赋予低于自己的权限，不能修改自己的权限
    public function modifyAccNumberRangeId()
    {
        
    }


}