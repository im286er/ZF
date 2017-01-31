<?php

/*
|---------------------------------------------------------------
| Container for output data and renderer strategy.
|---------------------------------------------------------------
| @package ZF
|
*/

abstract class ZF_Abstract_View
{

    /*
    |---------------------------------------------------------------
    | Response object.
    |---------------------------------------------------------------
    | @var ZF_Response
    */
    public $data;

    /*
    |---------------------------------------------------------------
    | Reference to renderer strategy.
    |---------------------------------------------------------------
    | @var ZF_OutputRendererStrategy
    */
    protected $_rendererStrategy;

    /*
    |---------------------------------------------------------------
    | Constructor.
    |---------------------------------------------------------------
    | @param ZF_Response $data
    | @param ZF_OutputRendererStrategy $rendererStrategy
    | @return ZF_View
    */
    public function __construct(ZF_Response $response, ZF_Abstract_OutputRendererStrategy $rendererStrategy)
    {
        $this->data = $response;
        $this->_rendererStrategy = $rendererStrategy;
    }

    /*
    |---------------------------------------------------------------
    | Post processing tasks specific to view type.
    |---------------------------------------------------------------
    | @param ZF_View $view
    | @return boolean
    */
    abstract public function postProcess(ZF_View $view);

    /*
    |---------------------------------------------------------------
    | Delegates rendering strategy based on view.
    |---------------------------------------------------------------
    | @param ZF_View $this
    | @return string   Rendered output data
    */
    public function render()
    {
        return $this->_rendererStrategy->render($this);
    }
}

?>