<?php
class Auto_Test_Page_Default extends ZF_Abstract_Page {
    public function doDefault(ZF_Request $input, ZF_Response $output) {
        $merchantId = $input->get('merchantId');
        echo '<pre>';
        print_r($merchantd);
        exit; 
    }
}
