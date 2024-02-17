<?php

namespace App\Controllers;
use App\Views\MainViews;
use App\Models\UsuarioModel;

class LoginController{

    public static function index(){

        MainViews::renderLogin('Login');
        if(isset($_POST['acao'])){
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);          
            UsuarioModel::login($email, $senha);
        }
    }
}

?>