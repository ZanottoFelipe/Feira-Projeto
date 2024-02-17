<?php

namespace App\Views;


class MainViews{

	

	 public static function render($filename, $header='Pages/includes/Header.php',$footer='Pages/includes/Footer.php'){
		include($header);
		include('Pages/'.$filename.'.php');
		include($footer);

	}

	public static function renderLogin($filename){
		include('Pages/'.$filename.'.php');
	}

	public static function renderPainel($filename, $header='Pages/Includes/PainelHeader.php',$footer='Pages/Includes/PainelFooter.php'){
		include($header);
		include('Pages/Painel/'.$filename.'.php');
		include($footer);

	}
	
}



?>