<?php

class ZF_Request
{
	const BROWSER   = 1;
	const CLI       = 2;
	const AJAX      = 3;
	const XMLRPC    = 4;
	const AMF       = 5;

	protected $_aClean      = array();
	protected $_a      = array();
	protected $_type;
	
	public function __construct()
	{
		if ($this->isEmpty()) 
		{
			$type = self::resolveType();
			$this->setType($type);
			if ($type == ZF_Request::CLI)
			{
				$this->_a['get'] = $this->getCliOpt();
			}
			elseif ($type == ZF_Request::BROWSER || $type == ZF_Request::AJAX)
			{
				$this->_a['get'] = $_GET;
				$this->_a['post'] = $_POST;
				$this->_a['request'] = $_REQUEST;
				$this->_a['files'] = $_FILES;
				$this->_a['cookie'] = $_COOKIE;
				unset($_GET, $_FILES, $_POST, $_REQUEST, $_COOKIE);
			}
		}
	}

	public function setType($type)
	{
		$this->_type = $type;
	}

	public function getType()
	{
		return $this->_type;
	}
	
	protected function _getTypeName()
	{
		$class = new ReflectionClass(get_class($this));
		$aConstants = $class->getConstants();
		$aConstantsIntIndexed = array_flip($aConstants);
		$const = $aConstantsIntIndexed[$this->_type];
		$name = ucfirst(strtolower($const));
		return $name;
	}
	
	public static function resolveType()
	{
		if (PHP_SAPI == 'cli') {
			$ret = self::CLI;

		} elseif (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
						$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			$ret = self::AJAX;

		} elseif (isset($_SERVER['CONTENT_TYPE']) &&
			$_SERVER['CONTENT_TYPE'] == 'application/x-amf') {
			$ret = self::AMF;

		} else {
			$ret = self::BROWSER;
		}
		return $ret;
	}

	public function isEmpty()
	{
		return count($this->_aClean) ? false : true;
	}

	/*
	|---------------------------------------------------------------
	| Retrieves values from Request object.
	|---------------------------------------------------------------
	| @param   mixed   $paramName  Request param name
	| @param   string  $method     Method of request
	| @param   boolean $allowTags  If html/php tags are allowed or not
	| @return  mixed               Request param value or null if not exists
	| @todo make additional arg for defalut value
	*/
	public function getByMethod($key = '', $method = 'get', $allowTags = false)
	{
		$ret = '';
		if (empty($key))
		{
			if (false === $allowTags)
			{
				$ret = ZF_String::clean($this->_a[$method]);
			}
			else
			{
				$ret = $this->_a[$method];
			}
		}
		elseif (isset($this->_a[$method][$key]))
		{
			//  don't operate on reference to avoid segfault :-(
			$ret = $this->_a[$method][$key];

			//  if html not allowed, run an enhanced strip_tags()
			if (false === $allowTags) 
			{
				$ret = ZF_String::clean($ret);
			}
		}
		
		if (!empty($ret))
		{
			if (self::AJAX == $this->getType() && strcasecmp(SYSTEM_CHARSET, 'utf-8'))
			{
				if (in_array(strtolower($method), array('get', 'post')) && !empty($ret))
				{
					$ret = ZF_String::convertEncodingDeep($ret, SYSTEM_CHARSET, 'utf-8');
				}    
			}
		}
		
		return $ret;
	}
	
	public function get($key = '', $allowTags = false)
	{
		return $this->getByMethod($key, 'get', $allowTags);
	}
	
	public function post($key = '', $allowTags = false)
	{
		return $this->getByMethod($key, 'post', $allowTags);
	}
	
	public function cookie($key = '', $allowTags = false)
	{
		return $this->getByMethod($key, 'cookie', $allowTags);
	}
	
	public function request($key = '', $allowTags = false)
	{
		return $this->getByMethod($key, 'request', $allowTags);
	}
	
	public function files($key = '', $allowTags = false)
	{
		return $this->getByMethod($key, 'files', $allowTags);
	}
	
	/*
	|---------------------------------------------------------------
	| Set a value for Request object.
	|---------------------------------------------------------------
	| @access  public
	| @param   mixed   $name   Request param name
	| @param   mixed   $value  Request param value
	| @return  void
	*/
	public function set($key, $value)
	{
		$this->_aClean[$key] = $value;
	}

	public function __set($key, $value)
	{
		$this->_aClean[$key] = $value;
	}

	public function __get($key)
	{
		if (isset($this->_aClean[$key]))
		{

			return $this->_aClean[$key];
		}
		else
		{
			//throw new ZF_Exception("Notice: Undefined variable '$key'");
			trigger_error("Notice: Undefined variable '$key'");

			return false;
		}
	}

	public function exists($key) 
	{
		if (!empty($key)) {
			return isset($this->_aClean[$key]);
		} else {
			return false;
		}
	}

	public function add(array $aParams, $method = 'get')
	{
		$this->_a[$method] = array_merge_recursive($this->_a[$method], $aParams);
	}
	
	public function reset()
	{
		unset($this->_aClean);
		$this->_aClean = array();
	}
	
	public function removeSourceData()
	{
		unset($this->_a);
		$this->_a = array();
	}
	
	/*
	|---------------------------------------------------------------
	| Return an array of all filtered Request properties.
	|---------------------------------------------------------------
	| @access  public
	| @return  array
	*/
	public function getClean()
	{
		return $this->_aClean;
	}

	public function getControllerName()
	{
		$ret = '';
		if (!isset($this->_aClean['controller']))
		{
			$trigger = 'c';
			$ret = ($this->get($trigger) != '') ? $this->get($trigger) : $this->post($trigger);
			if (empty($ret)) {
				$ret = 'default';
			}
			$this->set('controller', $ret);
		}
		else
		{
			$ret = $this->_aClean['controller'];
		}
		return $ret;
	}

	public function getActionName()
	{
		$ret = '';
		if (!isset($this->_aClean['action']))
		{
			$trigger = 'a';
			$ret = ($this->get($trigger) != '') ? $this->get($trigger) : $this->post($trigger);
			if (empty($ret))
			{
				$ret = 'default';
			}
			$this->set('action', $ret);
		}
		else
		{
			$ret = $this->_aClean['action'];
		}
		return $ret;
	}
	
	/**
	* ִ���¼���
	*/
	public function getExecName()
	{
		$ret = '';
		
		if (!isset($this->_aClean['exec'])) {
			$ret = $this->request('exec') ? $this->request('exec') : $this->request('e');
			$this->set('exec', $ret);
		} else {
			$ret = $this->_aClean['exec'];
		}
		return $ret;
		
	}
	
	protected function getCliOpt()
	{
		$ret = array();
		$args = $this->readPHPArgv();
		if (!empty($args))
		{
			foreach ($args as $val)
			{
				if (isset($val{2}))
				{
					if ($val{0} == '-' && $val{1} == '-')
					{
						$exp = explode('=', $val, 2);
						$ret[substr($exp[0], 2)] = isset($exp[1]) ? $exp[1] : NULL;
					}
				}
			}
		}
		return $ret;
	}

	public function readPHPArgv()
	{
		global $argv;
		if (!is_array($argv)) {
			if (!@is_array($_SERVER['argv'])) {
				if (!@is_array($GLOBALS['HTTP_SERVER_VARS']['argv'])) {
					trigger_error("Console_Getopt: Could not read cmd args (register_argc_argv=Off?)");

					return false;
				}
				return $GLOBALS['HTTP_SERVER_VARS']['argv'];
			}
			return $_SERVER['argv'];
		}
		return $argv;
	}
   
}

?>
