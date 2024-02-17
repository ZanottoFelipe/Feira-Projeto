<?php

namespace App\Models;

use App\MySql;
use App\Utilidades;

class ProdutosModel
{
    public static function salva($nome, $codigo = null, $preco = null, $estoque = null)
    {
        if (self::verificaProduto($nome)) {
            $pdo = MySql::connect();
            $verifica = $pdo->prepare("INSERT INTO produtos VALUES (null,?,?,?,?)");
            $verifica->execute(array($nome, $codigo, $preco, $estoque));
            return true;
        }
    }

    public static function updateProduto($id, $nome, $codigo, $preco, $estoque)
    {

        $pdo = MySql::connect();
        $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, codigo = ?, preco = ?, estoque = ? WHERE id = ?");
        $stmt->execute([$nome, $codigo, $preco, $estoque, $id]);
        return true;
    }




    public static function verificaProduto($nome)
    {

        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT * FROM produtos WHERE nome = ?");
        $verifica->execute(array($nome));
        $verifica->fetchAll();
        if ($verifica->rowCount() >= 1) {
            return false;
        } else {
            return true;
        }
    }

    public static function pegaProdutos($produtos)
    {
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT * FROM produtos WHERE nome LIKE :produtos OR codigo LIKE :produtos");
        $verifica->bindValue(':produtos', "%$produtos%", \PDO::PARAM_STR);
        $verifica->execute();

        if ($verifica && $verifica->rowCount() != 0) {
            $dados = $verifica->fetchAll(\PDO::FETCH_ASSOC);
            return json_encode($dados);
        } else {
            Utilidades::mensagemEfeito('Nenhum produto com este nome!', 'red');
        }
    }

    public static function pegaTodosProdutos()
    {
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT * FROM produtos");
        $verifica->execute();
        $dados = $verifica->fetchAll(\PDO::FETCH_ASSOC);
        return $dados;
    }


    public static function excluirProduto($id)
    {
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
        $verifica->execute([$id]);

        // Verificar se a exclusão foi bem-sucedida
        $linhasAfetadas = $verifica->rowCount();
        if ($linhasAfetadas > 0) {
            // A exclusão foi bem-sucedida
            return true;
        } else {
            // Nenhuma linha foi excluída, possivelmente porque o ID não foi encontrado
            return false;
        }
    }
}
