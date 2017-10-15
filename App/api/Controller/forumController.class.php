<?php
namespace App\api\Controller;

use App\common\Controller\baseController;
use App\api\Model\forumModel;

class forumController extends baseController
{
    private $obj;

    public function __construct()
    {
        $this->obj = new forumModel();
//        if (!$this->obj->getAccNumber())
//            parent::ajaxReturn('50002');            //未登录
    }

    //发表帖子
    public function addOneArticle()
    {
        $response = $this->obj->addOneArticle();
        parent::ajaxReturn($response);
    }

    //修改帖子
    public function modifyOneArticle()
    {
        $response = $this->obj->modifyOneArticle();
        parent::ajaxReturn($response);
    }

    //删除一篇帖子
    public function deleteOneArticle()
    {
        $response = $this->obj->deleteOneArticle();
        parent::ajaxReturn($response);
    }

    //获得一篇帖子详细信息
    public function getOneArticleInfo()
    {
        $response = $this->obj->getOneArticleInfo();
        parent::ajaxReturn($response);
    }

    //获得帖子列表信息
    public function getArticleList()
    {
        $response = $this->obj->getArticleList();
        parent::ajaxReturn($response);
    }


    //添加一条评论
    public function addOneComment()
    {
        $response = $this->obj->addOneComment();
        parent::ajaxReturn($response);
    }

    //获得评论信息
    public function getCommentListInfo()
    {
        $response = $this->obj->getCommentListInfo();
        parent::ajaxReturn($response);
    }

    //点赞或踩
    public function CommentOnInfo()
    {
        $response = $this->obj->CommentOnInfo();
        parent::ajaxReturn($response);
    }

    //获得帖子或评论的点赞数
    public function getCommentOnNum()
    {
        $response = $this->obj->getCommentOnNum();
        parent::ajaxReturn($response);
    }
}