<?php
namespace framework\common\Model;

class imageCodeModel
{
    private $image;
    private $width;
    private $height;
    private $codeNums;
    private $spotNums;
    private $lineNums;
    private $code;
    private $fontcolor;
    private $fontsize = 20;
    private $font = 'Microsoft YaHei';
    private $charset = 'abcdefghijkmnprstuvwxyABCDEFGHJKLMNPRSTUVWXYZ3456789';

    public function __construct($width = 80,$height = 40,$codeNums = 4,$spotNums = 50,$lineNums = 0)
    {
        $this->width    = $width;
        $this->height   = $height;
        $this->codeNums = $codeNums;
        $this->spotNums = $spotNums;
        $this->lineNums = $lineNums;
    }

    private function createCode() {
        $_len = strlen($this->charset)-1;
        for ($i=0;$i<$this->codeNums;$i++) {
            $this->code .= $this->charset[mt_rand(0,$_len)];
        }
    }
    private function createImageBackgroud()
    {
        $this->image    = imagecreatetruecolor($this->width,$this->height);
        $color          = imagecolorallocate($this->image,mt_rand(157,255),mt_rand(157,255),mt_rand(157,255));
        imagefilledrectangle($this->image,0,$this->height,$this->width,0,$color);
    }

    private function createCodeFont()
    {
        $_x = $this->width/$this->codeNums;
        for ($i = 0;$i < $this->codeNums;$i++) {
            $this->fontcolor = imagecolorallocate($this->image,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            //imagettftext($this->image,$this->fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->height / 1.4,$this->fontcolor,$this->font,$this->code[$i]);
            imagestring($this->image, $this->fontsize, $_x*$i+mt_rand(1,5), $this->height / 2.5, $this->code[$i], $this->fontcolor);
        }
    }

    private function createSpotAndLine()
    {
        for ($i = 0;$i < $this->lineNums;$i++) {
            $color = imagecolorallocate($this->image,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imageline($this->image,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
        for ($i=0;$i<100;$i++) {
            $color = imagecolorallocate($this->image,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
            imagestring($this->image,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'.',$color);
        }
    }

    private function outPut() {
        header('Content-type:image/png');
        imagepng($this->image);
        imagedestroy($this->image);
    }
    //对外生成
    public function toString() {
        $this->createImageBackgroud();
        $this->createCode();
        $this->createSpotAndLine();
        $this->createCodeFont();
        $this->getCode();
        $this->outPut();
    }

    private function getCode()
    {
        $_SESSION['code'] = $this->code;
        $_SESSION['code_time'] = time();
    }


}