<?php

/*
|---------------------------------------------------------------
| Wrapper for simple HTML views.
|---------------------------------------------------------------
| @package ZF
|
*/

class ZF_View_Simple extends ZF_Abstract_View
{
    /*
    |---------------------------------------------------------------
    | HTML renderer decorator
    |---------------------------------------------------------------
    | @param ZF_Response $data
    | @param string $templateEngine
    |
    */
    public function __construct(ZF_Response $response, $templateEngine = null)
    {
        //  prepare renderer class
        if (is_null($templateEngine)) {
            $templateEngine = 'php';
        }
        $templateEngine =  ucfirst($templateEngine);
        $rendererClass  = 'ZF_OutputRenderer_' . $templateEngine . 'Strategy';

        parent::__construct($response, new $rendererClass);
    }

    public function postProcess(ZF_View $view)
    {
        // do nothing
    }
}
?>