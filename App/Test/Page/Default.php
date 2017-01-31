<?php
class Test_Page_Default extends ZF_Abstract_Page {
    public function doDefault(ZF_Request $input, ZF_Response $output) {
        $str = $input->get('str');
        
        $output->setTemplate('Index');
    }
}
