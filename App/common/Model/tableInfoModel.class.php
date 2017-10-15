<?php
namespace App\common\Model;

class tableInfoModel
{

    private static $table = [
        0   => 'access_token',
        1   => 'carousel_figure',
        2   => 'concern',
        3   => 'course',
        4   => 'course_content',
        5   => 'course_goal_ablity',
        6   => 'course_goal_problem',
        7   => 'course_goal_value',
        8   => 'course_project',
        9   => 'course_stage',
        10  => 'leading_address',
        11  => 'leading_class',
        12  => 'leading_class_teacher',
        13  => 'leading_company',
        14  => 'leading_company_info',
        15  => 'leading_job',
        16  => 'leading_news',
        17  => 'leading_resume_log',
        18  => 'leading_sign',
        19  => 'leading_staff_case',
        20  => 'leading_staff_info',
        21  => 'leading_student',
        22  => 'leading_student_info',
        23  => 'leading_teacher',
        24  => 'leading_teacher_info',
        25  => 'login_log',
        26  => 'note',
        27  => 'leading_project',
        28  => 'province',
        29  => 'recommend',
        30  => 'second_course',
        31  => 'second_course_sign',
        32  => 'student_course',
        33  => 'student_education',
        34  => 'student_project',
        35  => 'student_work',
        36  => 'teacher_courseware',
        37  => 'teaching_course',
        38  => 'temp_register',
        39  => 'tuition',
        40  => 'vedio',
        41  => 'vedio_download',
        42  => 'leading_message_code',
        43  => 'leading_forum_article',
        44  => 'leading_forum_comment',
        45  => 'leading_forum_commentOn'
    ];


    private static $UserKey = [
        'student'   => 'stuId',
        'teacher'   => 'teacherId',
        'company'   => 'compId',
        'staff'     => 'accNumber',
        'tmp'       => 'tmpId',
    ];

    private static $caseForTable = [];

    private static $userTable = [];

    public function __construct()
    {
        self::$caseForTable = [
            '1'     => self::getLeading_student(),
            '2'     => self::getLeading_teacher(),
            '3'     => self::getLeading_teacher(),
            '4'     => self::getLeading_staff_info(),
            '5'     => self::getLeading_staff_info(),
            '6'     => self::getLeading_staff_info(),
            '7'     => self::getLeading_staff_info(),
            '8'     => self::getTemp_register(),
            '9'     => self::getLeading_company(),
        ];
        self::$userTable = [
            self::getLeading_student(),
            self::getLeading_teacher(),
            self::getLeading_company(),
            self::getLeading_staff_info(),
            self::getTemp_register(),
        ];
        self::$UserKey = [
            self::getLeading_student()      => 'stuId',
            self::getLeading_company()      => 'compId',
            self::getLeading_teacher()      => 'teacherId',
            self::getLeading_staff_info()   => 'accNumber',
            self::getTemp_register()        => 'tmpId',
        ];
    }

    public function getUserTable()
    {
        return self::$userTable;
    }

    public function getTableByCase($case)
    {
        return self::$caseForTable[$case];
    }

    public static function getKeyByUser($userType)
    {
        return self::$UserKey[$userType];
    }

    public function getUserKey()
    {
        return self::$UserKey;
    }


    public static function getAccess_token()
    {
        return self::$table[0];
    }

    public static function getCarousel_figure()
    {
        return self::$table[1];
    }

    public static function getConcern()
    {
        return self::$table[2];
    }

    public static function getCourse_content()
    {
        return self::$table[4];
    }

    public static function getCourse_goal_ablity()
    {
        return self::$table[5];
    }

    public static function getCourse_goal_problem()
    {
        return self::$table[6];
    }

    public static function getCourse_goal_value()
    {
        return self::$table[7];
    }

    public static function getCourse_project()
    {
        return self::$table[8];
    }

    public static function getCourse_stage()
    {
        return self::$table[9];
    }

    public static function getCourse()
    {
        return self::$table[3];
    }

    public static function getLeading_address()
    {
        return self::$table[10];
    }

    public static function getLeading_class_teacher()
    {
        return self::$table[12];
    }

    public static function getLeading_class()
    {
        return self::$table[11];
    }

    public static function getLeading_company_info()
    {
        return self::$table[14];
    }

    public static function getLeading_company()
    {
        return self::$table[13];
    }

    public static function getLeading_job()
    {
        return self::$table[15];
    }

    public static function getLeading_news()
    {
        return self::$table[16];
    }

    public static function getLeading_resume_log()
    {
        return self::$table[17];
    }

    public static function getLeading_sign()
    {
        return self::$table[18];
    }

    public static function getLeading_staff_case()
    {
        return self::$table[19];
    }

    public static function getLeading_staff_info()
    {
        return self::$table[20];
    }

    public static function getLeading_student_info()
    {
        return self::$table[22];
    }

    public static function getLeading_student()
    {
        return self::$table[21];
    }

    public static function getLeading_teacher_info()
    {
        return self::$table[24];
    }

    public static function getLeading_teacher()
    {
        return self::$table[23];
    }

    public static function getLogin_log()
    {
        return self::$table[25];
    }

    public static function getNote()
    {
        return self::$table[26];
    }

    public static function getProject()
    {
        return self::$table[27];
    }

    public static function getProvince()
    {
        return self::$table[28];
    }

    public static function getRecommend()
    {
        return self::$table[29];
    }

    public static function getSecond_course_sign()
    {
        return self::$table[31];
    }

    public static function getSecond_course()
    {
        return self::$table[30];
    }

    public static function getStudent_course()
    {
        return self::$table[32];
    }

    public static function getStudent_education()
    {
        return self::$table[33];
    }

    public static function getStudent_project()
    {
        return self::$table[34];
    }

    public static function getStudent_work()
    {
        return self::$table[35];
    }

    public static function getTeacher_courseware()
    {
        return self::$table[36];
    }

    public static function getTeaching_course()
    {
        return self::$table[37];
    }

    public static function getTemp_register()
    {
        return self::$table[38];
    }

    public static function getTuition()
    {
        return self::$table[39];
    }

    public static function getVedio()
    {
        return self::$table[40];
    }

    public static function getVedio_download()
    {
        return self::$table[41];
    }

    public static function getLeading_message_code()
    {
        return self::$table[42];
    }

    public static function getLeading_forum_article()
    {
        return self::$table[43];
    }

    public static function getLeading_forum_comment()
    {
        return self::$table[44];
    }

    public static function getLeading_forum_commentOn()
    {
        return self::$table[45];
    }



}