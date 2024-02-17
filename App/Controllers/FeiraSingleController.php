<?php

namespace App\Controllers;

use App\Utilidades;
use App\Views\MainViews;

class FeiraSingleController
{
    public function index()
    {
        if (isset($_SESSION['login'])) {

            
            MainViews::render('FeiraSingle');
        

            
         
        } 
        
      
        
        
    }

 
}
