<?php
// MAIN APP CORE CLASS

//CREATES URL AND LOADS CORE CONTROLLER
//URL FORMAT  - /CONTROLLER/METHOD/PARAMS


class Core{

	protected $currentController = 'Pages';
	protected $currentMethod = 'index';
	protected $params = [];

	public function __construct(){
		$url = $this->getUrl();

		//LOOK FOR CONTROLLERS FOR FIRST VALUE
		if(file_exists('_MVC/app/controllers/'.ucwords($url[0].'php'))){
			$this->currentController = ucwords($url[0]);

			unset($url[0]);
		}

		//REQUIRE THE CONTROLLER
		require_once '../app/controllers/'.$this->currentController.'.php';

		//INTSTANCIATE CONTROLLER CLASS
		$this->currentController = new $this->currentController;

	}

	public function getUrl()
	{
		if(isset($_GET['url'])){
			$url = rtrim($_GET['url'],'/');
			$url = filter_var($url,FILTER_SANITIZE_URL);
			$url =explode('/', $url);
			return $url;

		}
	}
}


?>