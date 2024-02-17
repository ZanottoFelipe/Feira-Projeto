<?php

namespace App\Controllers;

use App\Utilidades;
use App\Views\MainViews;
use \App\Models\FeirasModel;

class HistoricoController
{
    public function index()
    {
        if (isset($_SESSION['login'])) {

            MainViews::render('Historico');

          if(isset($_GET['FeiraSingle'])){
            MainViews::render('FeiraSingle');
          }

          if(isset($_GET['excluir'])){
          
            FeirasModel::deletaFeira($_GET['excluir']);
            Utilidades::redirect('Historico');
          }
        } 

       
        
        
    }

 
}
