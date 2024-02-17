<?php

namespace App\Controllers;

use App\Views\MainViews;
use App\Models\ProdutosModel;
use App\Utilidades;

class ProdutosController
{
    public function index()
    {
        if (isset($_SESSION['login'])) {

            MainViews::render('Produtos');
        } 
        if(isset($_POST['acao'])){
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_SPECIAL_CHARS);
            $estoque = filter_input(INPUT_POST, 'estoque', FILTER_SANITIZE_SPECIAL_CHARS);
            $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $preco = str_replace(',', '.', $preco);
            $preco = floatval($preco);
                      
           if(ProdutosModel::salva($nome,$codigo,$preco,$estoque)){
                Utilidades::mensagemEfeito('Produto salvo com sucesso!','green');
           }else{
                 Utilidades::mensagemEfeito('Produto já cadastrado!','red');
           }
        }
        
        
    }

 
}
