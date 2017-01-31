<?php

/*
|---------------------------------------------------------------
| output renderer strategy
|---------------------------------------------------------------
| @package ZF
|
*/

abstract class ZF_Abstract_OutputRendererStrategy
{

    public function __construct()
    {
    }

    abstract protected function _initEngine(ZF_Response $data);


    abstract public function render(ZF_Abstract_View $view);
}

?>