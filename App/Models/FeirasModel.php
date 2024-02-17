<?php

namespace App\Models;

use App\MySql;
use App\Utilidades;

class FeirasModel
{
    public static function empresaSingle($id)
    {
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT nome FROM empresa WHERE id = ?");
        $verifica->execute(array($id));
        return $verifica->fetch();
    }

    public static function UpdateFeira($id)
    {
        $data = date("d-m-Y -- H:i:s"); // Formato da data compatível com o MySQL
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("UPDATE feira SET data = ? WHERE idNumero = ?");
        $verifica->execute(array($data, $id));
        return;
    }
    
    public static function verificaFeiraExistente($id)
    {
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT * FROM feira WHERE idNumero = ?");
        $verifica->execute(array($id));
        if ($verifica->rowCount() >= 1) {
            self::UpdateFeira($id);
            return true; // Retorna true se a feira já existe
        } else {
            return false;
        }
    }
    
    public static function saveFeira($id, $idNumero, $url)
    {
        $resposta = self::verificaFeiraExistente($idNumero); 
        if($resposta == false){   
            $id = self::empresaSingle($id);         
            $data = date("d-m-Y -- H:i:s"); // Formato da data compatível com o MySQL
            $pdo = MySql::connect();
            $verifica = $pdo->prepare("INSERT INTO feira VALUES (null, ?, ?, ?, ?)");
            $verifica->execute(array($id['nome'], $idNumero, $data, $url));
        }
    }
    
    
    public static function recuperaFeira()
    {
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT * FROM feira ");
        $verifica->execute();
        return $verifica->fetchAll(\PDO::PARAM_STR);
    }


    public static function pegaFeirasingle($url)
    {
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT * FROM feira WHERE idNumero = ?");
        $verifica->execute(array($url));
        return $verifica->fetch(\PDO::PARAM_STR);
    }


    public static function recuperaPedidos($idFeira)
    {
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("SELECT * FROM pedidos WHERE idFeira = ?");
        $verifica->execute(array($idFeira));

        $aray = $verifica->fetchAll(\PDO::PARAM_STR);

        return self::agruparProdutosPorFuncionario($aray);
    }

    public static function agruparProdutosPorFuncionario($array)
    {
        $funcionarios = array();

        foreach ($array as $produto) {
            $nomeFuncionario = $produto['nome_funcionario'];

            if (!isset($funcionarios[$nomeFuncionario])) {
                // Se o funcionário não existir no array, cria uma entrada para ele
                $funcionarios[$nomeFuncionario] = array(
                    'nome_funcionario' => $nomeFuncionario,
                    'produtos' => array(),
                    'desconto_em_folha' => $produto['desconto_em_folha'], // Adicione a informação de desconto em folha
                    'parcelas' => $produto['parcelas'] // Adicione a informação de parcelas
                );
            }

            // Adiciona o produto à lista de produtos do funcionário
            $funcionarios[$nomeFuncionario]['produtos'][] = array(
                'nome_produto' => $produto['nome_produto'],
                'quantidade' => $produto['quantidade'],
                'preco' => $produto['preco']

                // Adicione outras chaves do produto conforme necessário
            );
        }

        return array_values($funcionarios);
    }


    public static function contabilidadeFaturamentoPorMes($array)
    {
        $total_vendido = 0;

        // Itera sobre cada pedido
        foreach ($array as $pedido) {
            // Itera sobre cada produto no pedido
            foreach ($pedido['produtos'] as $produto) {
                // Calcula o valor total do produto (quantidade * preço) e adiciona ao total vendido
                $total_vendido += $produto['quantidade'] * $produto['preco'];
            }
        }

        // Exibe o total vendido
        return number_format($total_vendido / 100, 2, ',', '.');
        
    }


    public static function deletaFeira($id)
    {
        $pdo = MySql::connect();
        $verifica = $pdo->prepare("DELETE FROM feira WHERE idNumero = ?");
        $verifica->execute(array($id));
        $verifica = $pdo->prepare("DELETE FROM pedidos WHERE idFeira = ?");
        $verifica->execute(array($id));
    }
}
