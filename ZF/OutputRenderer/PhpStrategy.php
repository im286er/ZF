<?php

class ZF_OutputRenderer_PhpStrategy extends ZF_Abstract_OutputRendererStrategy
{

	public function render(ZF_Abstract_View $view)
	{
		$php = $this->_initEngine($view->data);
		if (!ZF_File::exists($php->getTemplate()))
		{
			throw new ZF_Exception('The template dose not exist or is not readable: ' . $php->getTemplate());
		}
		$variables = $php->getBody();
		if (!empty($variables))
		{
			extract($variables);
		}
		ob_start();
		include $php->getTemplate();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	protected function _initEngine(ZF_Response $response)
	{
		return $response;
	}
}

?>
