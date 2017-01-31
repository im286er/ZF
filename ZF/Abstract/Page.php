<?php
 
abstract class ZF_Abstract_Page
{
	/*
	|---------------------------------------------------------------
	| Array of action permitted by mgr subclass.
	|---------------------------------------------------------------
	| @access  private
	| @var     array
	|
	*/
	protected $_aActionsMapping = array();
	
	public function addActionMapping(array $aActionMap)
	{
		$this->_aActionsMapping = $aActionMap;
	}
	
	public function getActionMapping()
	{
		return $this->_aActionsMapping;
	}
	
	/*
	|---------------------------------------------------------------
	| Specific validations are implemented in sub classes.
	|---------------------------------------------------------------
	| @param   ZF_Request     $req    ZF_Request object received from user agent
	| @return  boolean
	|
	*/
	public function validate(ZF_Request $input, ZF_Response $output)
	{
		return true;
	}
}
