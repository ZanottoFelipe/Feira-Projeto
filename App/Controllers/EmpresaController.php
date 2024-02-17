<?php

namespace App\Controllers;

use App\Views\MainViews;
use App\Utilidades;
use App\Models\EmpresaModel;
class EmpresaController
{
    public function index()
    {
        if (isset($_SESSION['login'])) {

            MainViews::render('Empresa');
        } 
        
        if(isset($_POST['acao'])){
            $cnpj = filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_SPECIAL_CHARS);
            $nome_fantasia = filter_input(INPUT_POST, 'nome-fantasia', FILTER_SANITIZE_SPECIAL_CHARS);

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);   

            if($nome_fantasia == ''){
                Utilidades::mensagemEfeito('Não deixe o campo Nome fantasia vazio!', 'red');
                exit;
            }else{
                 
                if(EmpresaModel::salva($nome_fantasia,$cnpj,$email)){
                    Utilidades::mensagemEfeito('Empresa salva com sucesso!', 'green');
                }else{
                    Utilidades::mensagemEfeito('Empresa já cadastrada!', 'red');
                    
                }
                
            }
            
        }

        
    }

 
 
}
