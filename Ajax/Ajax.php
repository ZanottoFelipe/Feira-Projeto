<?php
namespace Ajax;

define('HOST','localhost');
define('SENHA','FE15zafelipe');
define('DBNAME','zanott61_feiras');
define('USUARIO','zanott61_felipe');

//define('HOST','localhost');
//define('SENHA','');
//define('DBNAME','feiras');
//define('USUARIO','root');

function connect() {
    $pdo = '';
    if ($pdo == null) {
        try {
            
            $pdo = new \PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USUARIO, SENHA, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            // Em caso de erro, exibe uma mensagem e registra o erro no log
            echo 'Erro ao conectar';
            error_log($e->getMessage());
        }
    }
    return $pdo;
}

function pegaProdutos($produtos)
    {
        $pdo = connect();       
        $verifica = $pdo->prepare("SELECT * FROM produtos WHERE nome LIKE ?");
        $verifica->execute(array('%'.$produtos.'%'));

        if ($verifica && $verifica->rowCount() != 0) {
            $dados = $verifica->fetchAll(\PDO::FETCH_ASSOC);
            return print_r(json_encode($dados));
        } else {
            
        }
    }

function salvaFuncionarios($nome,$id_empresa){
    $pdo = connect();
    $verifica = $pdo->prepare("SELECT * FROM funcionarios WHERE nome = ? and id_empresa = ?");
    $verifica->execute(array($nome, $id_empresa));
    if($verifica->rowCount() > 0){
        return;
    }else{
        $verifica = $pdo->prepare("INSERT INTO funcionarios VALUES (null, ?, ? ) ");
        $verifica->execute(array($nome,$id_empresa));
    }   
}




function salvarPedido(array $pedido) {
    salvaFuncionarios($pedido[0]['nome'],$pedido[0]['empresaId']);
    $pdo = connect();

    foreach ($pedido[0]['pedido'] as $produto) {
        $verifica = $pdo->prepare("INSERT INTO pedidos VALUES (null, ?,?,?,?,?,?,?,? ) ");
        $verifica->execute(array(
            $pedido[0]['nome'],
            $produto['nome'],
            $produto['quantidade'],
            $produto['preco'],
            $pedido[0]['empresaId'],
            $pedido[0]['idFeira'],
            $pedido[0]['descontoEmFolha'],
            $pedido[0]['numeroDeParcelas']
        ));
    }

    echo json_encode(['success' => true, 'message' => 'Pedido salvo com sucesso']);

    
    
}



if (isset($_POST['proximo'])) {
    $pedido = json_decode($_POST['proximo'], true);  // O segundo parâmetro true converte para array associativo
    salvarPedido($pedido);  // Corrigir aqui, passando o array decodificado
}



function pdf($pedido){
// Criação do arquivo PDF
// necessita de uma biblioteca
}

if (isset($_POST['pedido'])) {
    $pedido = json_decode($_POST['pedido'], true);  // O segundo parâmetro true converte para array associativo
    pdf($pedido);    
}
    


if (isset($_POST['dados'])) {
    pegaProdutos($_POST['dados']);
    
}

/* 
[
    {
        "nome": "Felipe",
        "pedido": [
            {
                "codigo": 100,
                "nome": "Ovo 250g",
                "preco": "30.00",
                "quantidade": 2
            },
            {
                "codigo": 658,
                "nome": "Ovo 500g",
                "preco": "6055.00",
                "quantidade": 1
            },
            {
                "codigo": 543,
                "nome": "Palha italiana",
                "preco": "12.00",
                "quantidade": 2
            }
        ],
        "descontoEmFolha": true,
        "numeroDeParcelas": "3",
        "empresaId": "2"
    }
]


*/