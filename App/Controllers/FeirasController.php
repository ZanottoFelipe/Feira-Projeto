<?php

namespace App\Controllers;

use App\Models\ProdutosModel;
use App\Models\FeirasModel;
use App\Views\MainViews;
use App\Utilidades;

class FeirasController
{
    public function index()
    {
        if (isset($_SESSION['login'])) {
            MainViews::render('Feiras');
        } else {
            MainViews::render('Login');
        }

      
        if (isset($_GET['empresa'])) {
            $this->processaFeiraIniciada();
        }
        if (isset($_POST['palavra'])) {
            $this->PegaProdutos();
        }
        if (isset($_POST['finalizarFeira'])) {
            $urlCompleta = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";             
            FeirasModel::saveFeira($_GET['empresa'],$_GET['idFeira'],$urlCompleta);
            Utilidades::redirect('Historico');
        }
    }

    public function PegaProdutos()
    {
        if (isset($_POST['palavra']) != '') {
            Utilidades::alerta('clique');
            $produtos = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $resultados = ProdutosModel::pegaProdutos($produtos);
            echo $resultados;
        }
    }

    private function processaFeiraIniciada()
    {
        if ($_GET['empresa'] == 'selecione') {
            Utilidades::mensagemEfeito('Selecione uma empresa', 'red');
        } else {
            MainViews::render('FeiraIniciada');
            Utilidades::mensagemEfeito('Feira iniciada', 'green');
        }
    }

    public static function idFeira(){
        $id = uniqid();
        return $id;
    }
}
