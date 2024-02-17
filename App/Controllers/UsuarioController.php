<?php

namespace App\Controllers;

use App\Views\MainViews;
use App\Utilidades;
use App\Models\UsuarioModel;

class UsuarioController
{
    public function index()
    {
        if (isset($_SESSION['login'])) {

            MainViews::render('Usuario');
        }


        if (isset($_POST['acao'])) {
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            if ($senha != '' && $email != '') {
                if (UsuarioModel::emailExist($email)) {
                    try {
                        UsuarioModel::cadastro($email, $senha);
                        Utilidades::mensagemEfeito('Usuário cadastrado!', 'green');
                    } catch (\Exception $e) {
                        Utilidades::mensagemEfeito('Erro ao salvar!', 'red');
                        error_log($e->getMessage());
                    }
                }else{
                    Utilidades::mensagemEfeito('E-mail já cadastrado!', 'red');
                    exit;
                }
            } else {
                Utilidades::mensagemEfeito('Não deixe o campos vazio!', 'red');
                exit;
            }
        }
    }
}
