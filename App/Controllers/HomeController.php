<?php
namespace App\Controllers;

use App\Utilidades;
use App\Views\MainViews;
use App\Models\ProdutosModel;
class HomeController extends Controller{

	public function index(){

		if(isset($_SESSION['login'])){

			MainViews::render('Home');

			if(isset($_GET['excluirProduto'])){
				ProdutosModel::excluirProduto($_GET['excluirProduto']);
				Utilidades::redirect("Home");
			}
			
			if(isset($_POST['editar'])){
				$id = filter_input(INPUT_POST, 'idProduto', FILTER_SANITIZE_SPECIAL_CHARS);
				$nome = filter_input(INPUT_POST, 'nomeProduto', FILTER_SANITIZE_SPECIAL_CHARS);
				$codigo = filter_input(INPUT_POST, 'codigoProduto', FILTER_SANITIZE_SPECIAL_CHARS);
				$estoque = filter_input(INPUT_POST, 'estoqueProduto', FILTER_SANITIZE_SPECIAL_CHARS);
				$preco = filter_input(INPUT_POST, 'precoProduto', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				$preco = str_replace('.', '', $preco);
				
				
			   if(ProdutosModel::updateProduto($id, $nome,$codigo,$preco,$estoque)){
					Utilidades::redirect('Home');
					Utilidades::mensagemEfeito('Produto Editado com sucesso!','green');
			   }else{
					 Utilidades::mensagemEfeito('Produto já cadastrado!','red');
			   }
			}



		}else{
			Utilidades::redirect('Login');
		}
		
		
	
	}


}

?>