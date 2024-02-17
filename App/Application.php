<?php

namespace App;

class Application

{
	

	private $controller;

	private function setApp(){

		if(isset($_GET['sair'])){
			session_unset();
			session_destroy();
			\App\Utilidades::redirect('login');
		}



		$loadName = 'App\Controllers\\';
		$url = explode('/',@$_GET['url']);

		if($url[0] == ''){
			$loadName.='Login';
		}else{
			$loadName.=ucfirst(strtolower($url[0]));
		}

		$loadName.='Controller';
		$load = str_replace('\\', '/', $loadName);
		if (file_exists($load . '.php')) {
		 $this->controller = new $loadName();
		 } else {
		 include('Views/Pages/404.php');
		 die();
		 }
		 $this->controller = new $loadName();
	}
	
	
	public function run(){
		$this->setApp();
		$this->controller->index();	
	} 



}

?>