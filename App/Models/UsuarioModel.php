<?php

namespace App\Models;
use App\MySql;
use App\Bcrypt;
use App\Utilidades;
class UsuarioModel{

    public static function login($email, $senha){
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $verifica->execute(array($email));
        if($verifica->rowCount() <= 1 ){
            $dados = $verifica->fetch();
            $senhaBanco = $dados['senha'];
            print_r($dados);
            if(Bcrypt::check($senha,$senhaBanco)){
                $_SESSION['login'] = true;
                $_SESSION['nome'] = $dados['nome'];
                $_SESSION['email'] = $dados['email'];              

                Utilidades::redirect('Home');
        
            }else{
                Utilidades::mensagemEfeito('Senha ou E-mail iválidos!','red');
                

        }
    }
    }

	public static function cadastro($email, $senha){
        $pdo = MySql::connect();
        $senha = Bcrypt::hash($senha);
        $verifica=$pdo->prepare("INSERT INTO usuarios VALUES (null,?,?)");
        $verifica->execute(array($email,$senha));
        return true;
    }

    public static function emailExist($email){
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $verifica->execute(array($email));
        if($verifica->rowCount() >= 1){
            //aqui quando ja esta cadastrado o email    
            return false;
        }else{
            //aqui quando o email nao existe 
            return true;
        }
    }


}



?>