<?php

namespace App\Models;
use App\MySql;
use App\Bcrypt;
use App\Utilidades;
class EmpresaModel{

    public static function salva($nome, $email = null, $cnpj = null){
       if(self::verificaEmpresa($nome)){
        $pdo = MySql::connect();       
        $verifica=$pdo->prepare("INSERT INTO empresa VALUES (null,?,?,?)");
        $verifica->execute(array($nome,$cnpj,$email));
        return true;
       }else{
        return false;
       }
       
    }

    public static function pegaEmpresSimples($id){
        $pdo = MySql::connect();       
        $verifica = $pdo->prepare("SELECT nome FROM empresa WHERE id = ?");
        $verifica->execute(array($id));
        $dados = $verifica->fetch(\PDO::FETCH_ASSOC);
        if($verifica->rowCount() >= 1){        
             return $dados;          
        }else{
            return true;
        }
    }

    public static function verificaEmpresa($nome){

        $pdo = MySql::connect();       
        $verifica = $pdo->prepare("SELECT * FROM empresa WHERE nome = ?");
        $verifica->execute(array($nome));
        $verifica->fetchAll();
        if($verifica->rowCount() >= 1){        
             return false;          
        }else{
            return true;
        }
    }
    public static function pegaEmpresas(){
        try {
            $pdo = MySql::connect();       
            $verifica = $pdo->prepare("SELECT * FROM empresa");
            $verifica->execute();
            
            if ($verifica->rowCount() >= 1) {
                return $verifica->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                return array(); // Retorna um array vazio se não houver resultados
            }
        } catch (\PDOException $e) {
          
            echo "Erro de banco de dados: " . $e->getMessage();
            return false;
        }
    }



}



?>