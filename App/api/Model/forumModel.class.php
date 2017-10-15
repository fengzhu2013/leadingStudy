<?php
namespace App\api\Model;

use App\common\Model\baseModel;
use App\common\Model\commonModel;
use App\common\Model\tableInfoModel;
use App\common\Model\verifyModel;
use framework\common\Model\uploadFileModel;
use libs\Model\tableModel;

class forumModel extends baseModel
{
    const   PICURL_NUM      = 5;
    const   IMAGE_SIZE      = 5242880;      //单位，字节，5M
    const   IMG_PATH        = './static/forum/images/upload/';
    private $table;
    private $where;
    private $pages;
    private $accNumber;
    public  $info;
    public  $imgPath;
    public  $id;
    public  $arr            = [];

    public function __construct($isVerify = true)
    {
        parent::__construct($isVerify);
        $this->accNumber = $this->getAccNumber();
    }

    /**
     * 发表一篇文章
     * @return array|string
     */
    public function addOneArticle()
    {
        if (!$this->accNumber)
            return '50002';
        //没有信息
        if (!count($this->_LP))
            return '20003';
        //信息不全
        if (!isset($this->_LP['title']) || !isset($this->_LP['keywords']) || !isset($this->_LP['content']))
            return '20001';
        //如果上传了图片
        if (count($_FILES)) {
            $obj     = new commonModel(false);
            $info    = $obj->uploadMorePic(self::IMAGE_SIZE,self::IMG_PATH,self::PICURL_NUM);
        }
        if (isset($info) && is_array($info))
            $this->_LP['picUrl'] = implode(',',$info);
        //确定所有的参数，包括时间，作者，阅读量,状态
        $this->_LP['fa_date']   = time();
        $this->_LP['author']    = $this->accNumber;
        $this->_LP['r_count']   = 0;
        $this->_LP['status']    = 0;
        //验证信息是否安全
        $this->table = tableInfoModel::getLeading_forum_article();
        if (!verifyModel::verifyInfoIsTrue($this->table,$this->_LP))
            return '20002';
        //插入数据库
        $resp_1      = parent::insert($this->table,$this->_LP);
        return parent::formatDatabaseResponse($resp_1);
    }

    /**
     * 发布者修改帖子，只能修改标题，关键字，内容及图片还有url,只有作者本身能修改帖子
     * @return mixed
     */
    public function modifyOneArticle()
    {
        if (!$this->accNumber)
            return '50002';
        //确定修改的是登录者的帖子
        if (!isset($this->_LP['fa_id']) || count($this->_LP) < 2)
            return '20001';
        $this->table = tableInfoModel::getLeading_forum_article();
        $this->where = ['fa_id' => $this->_LP['fa_id']];
        $resp_1      = parent::fetchOneInfo($this->table,['author'],$this->where);
        //文章id错误
        if (!count($resp_1))
            return '50004';
        //登录账号与修改帖子作者不一
        if ($this->accNumber != $resp_1['author'])
            return '50010';
        //如果修改了图片
        if (count($_FILES)) {
            $obj     = new commonModel(false);
            $info    = $obj->uploadMorePic(self::IMAGE_SIZE,self::IMG_PATH,self::PICURL_NUM);
        }
        if (isset($info) && is_array($info))
            $this->_LP['picUrl'] = implode(',',$info);
        //字段不安全
        if (count(array_diff_key($this->_LP,array_flip(['fa_id','title','keywords','content','picUrl','url']))))
            return '20002';
        //更新发布时间
        $this->_LP['fa_date'] = time();
        $arr         = array_diff_key($this->_LP,['fa_id' => 1]);
        $response    = parent::updateInfo($this->table,$arr,$this->where);
        return parent::formatDatabaseResponse($response);
    }

    /**
     * 删除一篇帖子,如果登录者是管理员，且权限大于等于5，可以删除其他账号的帖子
     * @return array|string
     */
    public function deleteOneArticle()
    {
        if (!$this->accNumber)
            return '50002';
        //fa_id 必需
        if (!isset($this->_LP['fa_id']))
            return '20001';
        //确认fa_id是否正确
        $this->table = tableInfoModel::getLeading_forum_article();
        $this->where = ['fa_id' => $this->_LP['fa_id']];
        $resp_1      = parent::fetchOneInfo($this->table,['author'],$this->where);
        //文章id错误
        if (!count($resp_1))
            return '50004';
        //登录账号与帖子作者不一,且不是员工号
        $obj         = new commonModel(false);
        if (!$obj->verifyIsStaffId($this->accNumber) && $this->accNumber != $resp_1['author'])
            return '50010';
        //是员工号，但权限小于5，只能删除自己的帖子，否则提示权限不够
        if ($obj->verifyIsStaffId($this->accNumber)) {
            //获得登录者的权限
            $resp_2  = parent::fetchOneInfo($this->table,['rangeId'],['accNumber' => $this->accNumber]);
            if ($resp_2['rangeId'] < 5)
                return '80003';
        }
        //删除帖子
        $resp        = parent::deleteArr($this->table,$this->where);
        return parent::formatDatabaseResponse($resp);
    }

    /**
     * 没有登录也可以获得帖子信息
     * 获得一篇帖子详细信息
     * 每次获得详细信息，阅读量加1
     * @return array|string
     */
    public function getOneArticleInfo()
    {
        //fa_id 必需
        if (!isset($this->_LP['fa_id']))
            return '20001';
        $this->table = tableInfoModel::getLeading_forum_article();
        $this->where = ['fa_id' => $this->_LP['fa_id']];
        //获得帖子信息
        $resp        = parent::fetchOneInfo($this->table,['*'],$this->where);
        if (!count($resp))
            return '50004';
        //获得帖子作者名
        $user        = $this->getUserInfo();
        $resp['name'] = '';
        if (isset($user['name']))
            $resp['name'] = $user['name'];
        //阅读量加1
        $resp_1      = parent::updateInfo($this->table,['r_count' => $resp['r_count'] + 1],$this->where);
        $resp['r_count'] = $resp['r_count'] + 1;
        return parent::formatDatabaseResponse($resp);
    }

    /**
     * 获得或搜索帖子列表信息
     * 没有登录也可以获得
     * 若传入了账号信息，就获得该账号的帖子信息
     * 那么是编辑员获得所有的帖子（不考虑其他的筛选条件）
     */
    public function getArticleList()
    {
        $this->where = ['where2' => ' ORDER BY r_count,fa_id DESC '];
        //获得某个作者的帖子
        if (isset($this->_LP['author']))
            $this->where['author'] = $this->_LP['author'];
        //搜索关键字
        if (isset($this->_LP['keywords'])) {
            $whereArr = explode(',',$this->_LP['keywords']);
        }
        if (isset($whereArr) && count($whereArr)) {
            foreach ($whereArr as $where) {
                $where2[] = " keywords LIKE '%{$where}%' ";
            }
        }
        //有多个关键字
        if (isset($where2) && count($where2) > 1)
            $this->where['where2'] = implode(' OR ',$where2).$this->where['where2'];
        //一个关键字
        if (isset($where2) && count($where2) == 1)
            $this->where['where2'] = $where2[0].$this->where['where2'];
        if (count($this->where) == 1)
            $this->where['where2'] = ' WHERE'.$this->where['where2'];
        //分页信息
        $pages       = $this->getPages();
        $this->table = tableInfoModel::getLeading_forum_article();
        $arr         = ['fa_id','title','keywords','fa_date','r_count','author'];
        $resp_1      = getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']);
        $count       = count($resp_1['data']);
        //没有信息
        if ($count < 1)
            return '20003';
        $obj         = new commonModel(false);
        //合并姓名信息
        for ($i = 0;$i < $count;$i++) {
            //获得作者姓名
            $resp_2  = $obj->getNameById($resp_1['data'][$i]['author']);
            //姓名默认为空
            $resp_1['data'][$i]['name'] = '';
            //有姓名信息，合并
            if (is_array($resp_2))
                $resp_1['data'][$i]['name'] = $resp_2['name'];
        }
        return parent::formatDatabaseResponse($resp_1);
    }


    /**
     * 添加一条评论，或回复一条评论
     * @return array|string
     */
    public function addOneComment()
    {
        //需要登录，提示未登录
        if (!$this->accNumber)
            return '50002';
        //必需存在帖子id，没有，提示没有身份标识符
        if (!isset($this->_LP['fa_id']))
            return '50008';
        //验证帖子id是否存在，提示标识符错误
        $this->id    = $this->_LP['fa_id'];
        if (!$this->verifyIdIsTrue())
            return '50004';
        //评论者默认登录账号
        $this->_LP['fc_accNumber'] = $this->accNumber;
        //必需存在评论内容
        if (!isset($this->_LP['content']))
            return '20001';
        //如果评论内容超过255个字符，提示信息不安全
        if (mb_strlen($this->_LP['content'],'utf8') > 255)
            return '20002';
        $this->table = tableInfoModel::getLeading_forum_comment();
        //如果是回复留言者，必需存在l_accNumber和m_id,需要验该l_accNumber是否回复了该帖子，提示标识符错误
        if (isset($this->_LP['l_accNumber'])) {
            $where   = ['fc_accNumber' => $this->_LP['l_accNumber'],'fa_id' => $this->_LP['m_id']];
            $resp_1  = parent::fetchOneInfo($this->table,['fc_id'],$where);
            if (!count($resp_1))
                return '50004';
        }
        //评论时间
        $this->_LP['fc_date'] = time();
        //验证字段是否安全
        if (!verifyModel::verifyInfoIsTrue($this->table,$this->_LP))
            return '20002';
        $resp_2      = parent::insert($this->table,$this->_LP);
        return parent::formatDatabaseResponse($resp_2);
    }

    /**
     * 验证帖子id是否存在
     * @return bool
     */
    public function verifyIdIsTrue()
    {
        if (empty($this->id))
            return false;
        $resp        = parent::fetchOneInfo(tableInfoModel::getLeading_forum_article(),['title'],['fa_id' => $this->id]);
        if (empty($resp))
            return false;
        return true;
    }

    //获得评论列表信息
    public function getCommentListInfo()
    {
        /**
         * 1、传入的是帖子id，获得是评论及回复评论
         * 2、没有传入id，默认获得登录账号的所有评论及回复评论信息
         * 3、传入的是评论id，获得是回复该评论的信息
         */
        $this->table = tableInfoModel::getLeading_forum_comment();
        //1
        if (isset($this->_LP['fa_id'])) {
            $this->where = ['fa_id' => $this->_LP['fa_id']];
            return $this->getArticleCommentListInfo();
        }
        //3
        if (isset($this->_LP['fc_id'])) {
            $this->where = ['m_id' => $this->_LP['fc_id']];
            return $this->getCommentsListInfo();
        }
        //2
        if (!$this->accNumber)
            return '50002';
        $this->where = ['fc_accNumber' => $this->accNumber,'where2' => ' ORDER BY fc_date DESC '];
        return $this->getCommentsRecentlyListInfo();
    }

    /**
     * 传入的是帖子id，获得是评论及回复评论
     * @return mixed
     */
    public function getArticleCommentListInfo()
    {
        //1、先获得页容量的评论信息
        $pages       = $this->getPages();
        $resp_1      = getPage($this->table,['*'],$this->where,$pages['page'],$pages['pageSize']);
        //获得评论者名字
        $obj         = new commonModel(false);
        $count       = count($resp_1['data']);
        if ($count < 1)
            return '20003';
        for ($i = 0;$i < $count;$i++) {
            $resp_2      = $obj->getNameById($resp_1['data'][$i]['fc_accNumber']);
            $resp_1['data'][$i]['name'] = isset($resp_2['name'])?$resp_2['name']:'';
            //如果是回复评论信息，获得评论者名字
            if (!empty($resp_1['data'][$i]['m_id'])) {
                $resp_3  = parent::fetchOneInfo($this->table,['fc_id','content','fc_accNumber'],['fc_id' => $resp_1['data'][$i]['m_id']]);
                if (!empty($resp_3['fc_accNumber']))
                    $resp_4 = $obj->getNameById($resp_3['fc_accNumber']);
            }
            $resp_1['data'][$i]['name_2']    = isset($resp_4['name'])?$resp_4['name']:'';
            $resp_1['data'][$i]['content_2'] = isset($resp_3['content'])?$resp_3['content']:'';
        }
        return parent::formatDatabaseResponse($resp_1);
    }

    /**
     * 传入的是评论id，获得是回复该评论的信息
     * @return array|string
     */
    public function getCommentsListInfo()
    {
        $pages       = $this->getPages();
        $arr         = ['fc_id','fc_accNumber','content','fc_date'];
        //获得回复评论者内容信息
        $resp_1      = getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']);
        $count       = count($resp_1['data']);
        if ($count < 1)
            return '20003';
        $obj         = new commonModel(false);
        //获得回复评论者名字
        for($i = 0;$i < $count;$i++) {
            $resp_2  = $obj->getNameById($resp_1['data'][$i]['fc_accNumber']);
            $resp_1['data'][$i]['name'] = isset($resp_2['name'])?$resp_2['name']:'';
        }
        return parent::formatDatabaseResponse($resp_1);
    }

    /**
     * 获得登录者的评论信息
     * @return mixed
     */
    public function getCommentsRecentlyListInfo()
    {
        return $this->getArticleCommentListInfo();
    }

    /**
     * 点赞或踩
     */
    public function CommentOnInfo()
    {
        if (!$this->accNumber)
            return '50002';
        //给帖子点赞
        if (isset($this->_LP['fa_id'])) {
            //验证帖子id是否正确
            $resp_1             = parent::fetchOneInfo(tableInfoModel::getLeading_forum_article(),['fa_id'],['fa_id' => $this->_LP['fa_id']]);
            if (!count($resp_1))
                return '50004';
            //帖子id正确,type=1表示是帖子id
            $this->arr['c_id']  = $this->_LP['fa_id'];
            $this->arr['type']  = 1;
        }
        //评论点赞
        if (isset($this->_LP['fc_id'])) {
            //验证评论id是否存在
            $resp_2             = parent::fetchOneInfo(tableInfoModel::getLeading_forum_comment(),['fc_id'],['fc_id' => $this->_LP['fc_id']]);
            if (!count($resp_2))
                return '50004';
            //评论id正确
            $this->arr['c_id']  = $this->_LP['fc_id'];
            $this->arr['type']  = 2;
        }
        //status 0-踩，1-赞，只有这两种情况
        if (!in_array($this->_LP['status'],[0,1]))
            return '20002';
        $this->arr['status']    = $this->_LP['status'];
        //是否重复操作，是，提示重复操作
        $this->table = tableInfoModel::getLeading_forum_commentOn();
        $resp_3      = parent::fetchOneInfo($this->table,['id'],$this->arr);
        if (isset($resp_3['id']) && !empty($resp_3['id']))
            return '30017';
        //插入数据
        $this->arr['c_date']    = time();
        $resp        = parent::insert($this->table,$this->arr);
        return parent::formatDatabaseResponse($resp);
    }

    //获得某个帖子或留言的点赞或踩的数量
    public function getCommentOnNum()
    {
        //如果不存在id
        if (!$this->_LP['id'] || !$this->_LP['type'])
            return '20001';
        $table       = tableInfoModel::getLeading_forum_commentOn();
        $sql         = "SELECT COUNT(*) FROM {$table} WHERE `c_id` = {$this->_LP['id']} AND `type` = {$this->_LP['type']} AND `status` = 0 UNION SELECT COUNT(*) FROM {$table} WHERE `c_id` = {$this->_LP['id']} AND `type` = {$this->_LP['type']} AND `status` = 1";
        $resp        = parent::fetchOneSql($sql);
        var_dump($sql);
        exit;
    }






}