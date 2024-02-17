<?php
namespace App\Controllers;
use App\Views\MainViews;
use App\Models\UsuarioModel;
use App\MySql;
use App\Utilidades;

class CadastroController extends Controller{

	public function index(){

		MainViews::renderLogin('Cadastro');
        if(isset($_POST['acao'])){
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            
           

            if(UsuarioModel::emailExist($email)){               
               
                if(strlen($senha)< 6){
                    Utilidades::mensagemEfeito('Use uma senha com mais de 6 caracteres', 'red');

                }elseif(strlen($email) <= 2){                   
                    Utilidades::mensagemEfeito('Use um nome com mais de 3 caracteres', 'red');
                    
                }else{
                    if( UsuarioModel::cadastro($email, $senha)){
                        Utilidades::redirect('Login');
                        Utilidades::mensagemEfeito('Cadastrado com sucesso!', 'green');
                    }
                }
            }else{
                Utilidades::mensagemEfeito('Este e-mail já está cadastrado', 'red');
            }          
            
        }

	}


}

?>