<?php
namespace framework\common\Model;

class paramModel
{
    private $_LG;

    private $_LP;

    public function __construct($_LG = [],$_LP = [])
    {
        if (empty($_LG))
            $_LG = $_GET;
        if (empty($_LP))
            $_LP = $_POST;
        if (count($_LG))
            $this->_LG = $this->init_params($_LG);
        if (count($_LP))
            $this->_LP = $this->init_params($_LP);
    }

    private function init_params($data,$name = '_LS')
    {
        if(count($data)) {
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    ${$name}["{$key}"] = $val;
                    self::init_params($val,$name);
                } elseif (is_int($val)) {
                    ${$name}["{$key}"] = intval(daddslashes($val));
                } else {
                    ${$name}["{$key}"] = strval(daddslashes($val));
                }
            }
            return ${$name};
        } else {
            return [];
        }
    }

    public function getLG()
    {
        return $this->_LG;
    }

    public function getLP()
    {
        return $this->_LP;
    }

}