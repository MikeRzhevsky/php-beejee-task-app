<?php
namespace  Views;

class View
{

    protected $data=[];


    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __set($name, $value)
    {
        $this->data[$name]=$value;
    }

    public function display($tempalte)
    {
        include $tempalte;
    }

}
?>