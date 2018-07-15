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
		if(file_exists("../app/controllers/".ucwords($url[0]).".php")){
			$this->currentController = ucwords($url[0]);

			unset($url[0]);
		}

		//REQUIRE THE CONTROLLER
		require_once '../app/controllers/'.$this->currentController.'.php';

		//INTSTANCIATE CONTROLLER CLASS
		$this->currentController = new $this->currentController;

		//CHECK FOR SECOND PARAMETER OF URL
		if(isset($url[1])){
			//Check to see if method exists in controller
			if(method_exists($this->currentController, $url[1])){
				$this->currentMethod = $url[1];
				unset($url[1]);
			}
		}

		//Get Params
		if($url){
			$this->params = array_values($url);
		}else{
			$this->params = array();
		}

		// Call a callback with array of params
		call_user_func_array([$this->currentController, $this->currentMethod],$this->params );
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