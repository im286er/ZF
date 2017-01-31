<?php
class Test_Page_Default extends ZF_Abstract_Page {
    public function validate(ZF_Request $input, ZF_Response $output)
	{
		return true;
	}
    
    public function __construct(ZF_Request $input, ZF_Response $output) {
        $this->addActionMapping(array('cjw' => array('default')));
    }
    
    public function doDefault(ZF_Request $input, ZF_Response $output) {
        $page = (int) $input->get('page');
        
        $totalNumber = Libs_Test_TestTable::getCount();
        //分页
        $perPageNum         = 5;
        $maxPage            = ceil($totalNumber / $perPageNum);
        if($page > $maxPage) {
            $page = $maxPage;
        }
        if($page < 1) {
            $page = 1;
        }
        $pageUrl = Helper_Global_Func::clearPageUrl($input->get());
        $pageUrl = 'list_{PAGE}';
        $pageConfig         = array(
            'page'      => $page, //当前页码
            'rownum'    => $perPageNum, //一页显示多少条
            'target'    => '_self', //链接打开形式
            'total'     => $totalNumber, //总数
            'url'       => $pageUrl, //当前页链接
        );
        $pageObj    = new Helper_Global_Page($pageConfig);
        $pageStyle  = array('PREV' => 'prev', 'NEXT' => 'next', 'CURRENT' => 'current');
        $pageObj->setStyle($pageStyle);
        $pageTpl    = '{PREV:上一页}{FIRST:[NUM]}{PREVHD:...}{BAR:[NUM]:5:2}{NEXTHD:...}{LAST:[NUM]}{NEXT:下一页}';
        $pageStr      = $pageObj->display($pageTpl);
        
        $output->setTemplate('Index');
    }
}
