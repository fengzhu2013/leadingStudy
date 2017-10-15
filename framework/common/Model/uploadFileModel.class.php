<?php
namespace framework\common\Model;

class uploadFileModel{

    private static $imageType  = array('jpg','jpeg','png','gif');  //图片类型
    private static $imgPath    ='./static/admin/images/uploads';
    private static $imgMaxSize = '2097152';                        //单位字节 ，2M
    private static $imgFlag    = true;

    //验证是否符合上传文件类型
    public function verifyImgType($type)
    {
        $res = false;
        if(in_array($type,self::$imageType)){
            $res = true;
        }
        return $res;
    }

    public function getImgPath()
    {
        return self::$imgPath;
    }


    //为上传文件构建信息数组
    public function buildInfo()
    {
        $i = 0;
        $data = $_FILES;
        foreach($data as $val){
            if(is_string($val['name'])){//单文件上传
                $files[$i] = $val;
                $i++;
            }else{
                //多文件
                foreach($val['name'] as $key=>$value){
                    $files[$i]['name'] = $value;
                    $files[$i]['size'] = $val['size'][$key];
                    $files[$i]['tmp_name'] = $val['tmp_name'][$key];
                    $files[$i]['error'] = $val['error'][$key];
                    $files[$i]['type'] = $val['type'][$key];
                    $i++;
                }
            }
        }
        return $files;
    }
    /**
     * 上传文件
     */
    /**
     * 上传文件
     * @param int $size        能上传的最大文件大小
     * @param string $imgPath default null
     * @param int $count default 0 上传图片张数限制
     * @return mixed
     */
    public function uploadFileImg($size = null,$imgPath = null,$count = 0)
    {
        if (!is_null($imgPath))
            self::$imgPath = $imgPath;
        $i = 0;
        if(!file_exists(self::$imgPath)){
            mkdir(self::$imgPath,0777,true);
        }
        $files = $this->buildInfo();
        if ($count && count($files) > $count)
            $this->preg_error(9);
        foreach ($files as $file) {
            if($file['error'] === UPLOAD_ERR_OK ){//success
                //检验图片类型
                $ext = getExt($file['name']);
                if(!in_array($ext,self::$imageType)){
                    exit('非法文件类型');
                }
                if(self::$imgFlag){
                    if(!getimagesize($file['tmp_name'])){
                        exit("不是真正的图片类型");
                    }
                }
                //检验图片大小
                $size  = empty($size)?self::$imgMaxSize:$size;
                if($file['size']>$size){
                    exit('上传文件过大');
                }
                if(!is_uploaded_file($file['tmp_name'])){
                    exit('不是通过HTTP POST方式上传的');
                }
                $uniName     = getUniName();                            //生成唯一标识符
                $fileName    = $uniName.".".$ext;                       //唯一标识符拼接后缀名
                $destination = self::$imgPath."/".$fileName;            //文件存放地址
                if(move_uploaded_file($file['tmp_name'],$destination)){ //临时文件移动到目的地
                    $file['name'] = $fileName;
                    unset($file['error'],$file['tmp_name'],$file['type']);
                    $uploadFiles[$i] = $file;
                    //$uploadFiles[$i] = $destination;
                    $i++;
                }
            }else{
                return $this->preg_error($file['error']);
            }
        }
        if (isset($uploadFiles))
            return $uploadFiles;
        return false;
    }

    //匹配文件上传错误信息
    public function preg_error($errKey){
        $status = '70001';              //默认上传失败
        switch($errKey){
            case 1:                     //UPLOAD_ERR_INI_SIZE   超过了配置文件上传文件的大小
                $status = '70002';
                break;
            case 2:			            //UPLOAD_ERR_FORM_SIZE  超过了表单设置上传文件的大小
                $status = '70003';
                break;
            case 3:                     //UPLOAD_ERR_PARTIAL    文件部分被上传
                $status = '70004';
                break;
            case 4:                     //UPLOAD_ERR_NO_FILE    没有文件被上传
                $status = '70005';
                break;
            case 6:                     //UPLOAD_ERR_NO_TMP_DIR 没有找到临时目录
                $status = '70006';
                break;
            case 7:                     //UPLOAD_ERR_CANT_WRITE 文件不可写
                $status = '70007';
                break;
            case 8:                     //UPLOAD_ERR_EXTENSION  由于PHP的扩展程序中断了文件上传
                $status = '70008';
                break;
            case 9:
                $status = '70009';
                break;
        }
        return $status;
    }


    //生成缩略图
    public function thumb($fileName,$destination = null,$dst_w = null,$dst_h = null,$isReservedSource = true,$scale = 0.5)
    {
        list($src_w,$src_h,$imageType) = getimagesize($fileName);
        if(is_null($dst_w) || is_null($dst_h)){
            $dst_w = $src_w * $scale;
            $dst_h = $src_h * $scale;
        }
        $mime = image_type_to_mime_type($imageType);      //获得的图像类型的 MIME 类型
        $createFun = str_replace('/','createfrom',$mime);
        $outFun = str_replace('/',null,$mime);
        $src_image = $createFun($fileName);
        $dst_image = imagecreatetruecolor($dst_w,$dst_h);
        imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
        if($destination && !file_exists(dirname($destination))){
            mkdir(dirname($destination),0777,true);
        }
        $dstFileName = ($destination == null)?getUniName().'.'.getExt($fileName):$destination;
        $outFun($dst_image,$dstFileName);
        imagedestroy($src_image);
        imagedestroy($dst_image);
        if(!$isReservedSource){
            unlink($fileName);
        }
        return $dstFileName;
    }
}