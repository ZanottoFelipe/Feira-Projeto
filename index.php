<?php
require('vendor/autoload.php');

session_start();
date_default_timezone_set('America/Sao_Paulo');



//define('INCLUDE_PATH_STATIC', 'http://localhost/projeto/App/Views/Pages/');
//define('INCLUDE_PATH', 'http://localhost/projeto/App/');
define('INCLUDE_PATH_STATIC', 'https://teste.zanottofelipe.com/projeto/App/Views/Pages/');
define('INCLUDE_PATH', 'https://teste.zanottofelipe.com/projeto/');


define('HOST','localhost');
define('SENHA','FE15zafelipe');
define('DBNAME','zanott61_feiras');
define('USUARIO','zanott61_felipe');

//define('HOST','localhost');
//define('SENHA','');
//define('DBNAME','feiras');
//define('USUARIO','root');




$app = new App\Application();

$app->run();


?>