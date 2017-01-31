<?php
class ZF_Controller_Front
{
	public static function run()
	{
		ZF_Registry::set('request', new ZF_Request);
		$request = ZF_Registry::get('request');

		ZF_Registry::set('response', new ZF_Response());
		$response = ZF_Registry::get('response');
	
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		
		$controller = ZF_String::toValidVariableName($controller);
		$action = ZF_String::toValidVariableName($action);
		
		if (empty($controller))
		{
			throw new ZF_Exception("The controller of '$controller' is empty in request!");
		}
		if (empty($action))
		{
			throw new ZF_Exception("The action of '$action' is empty in request!");
		}
		
		$controller =  APP_NAME . '_Page_' . ucfirst($controller);
		$page = new $controller($request, $response);
		if ($page->validate($request, $response)) {
			
			$actionMap = $page->getActionMapping();
			if (empty($actionMap) || !isset($actionMap[$action])) {
				$action = 'do' . ucfirst($action);
				if (method_exists($page, $action)) {
					$page->$action($request, $response);
				} else {
					throw new ZF_Exception("The function of '{$action}' does not exist in class '$controller'!");
				}
			} else {
				foreach($actionMap[$action] as $methodName) {
					$methodName = 'do' . ucfirst($methodName);
					if (method_exists($page, $methodName)) {
						$page->$methodName($request, $response);
					} else {
						throw new ZF_Exception(' the function dose not exist:' . $methodName );
					}
				}
			}
		}
		$response->display();
	}
}


