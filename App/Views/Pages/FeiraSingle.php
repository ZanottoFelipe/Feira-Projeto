<div id="container-mensagens" class="container-mensagens">
</div>

<?php

$nomeEmpresa = \App\Models\FeirasModel::pegaFeirasingle($_GET['id']);
$pedidos = \App\Models\FeirasModel::recuperaPedidos($_GET['id']);
$faturamentoPorMes  = \App\Models\FeirasModel::contabilidadeFaturamentoPorMes($pedidos);


?>

<div class="tabela">
    <div class="head-tabelas">
        <i class="fa-solid fa-cloud"></i>
        <h2>Feira realizada na: <?php echo $nomeEmpresa['empresa']; ?> - <?php echo $nomeEmpresa['data']; ?> </h2>
    </div>
    <table class="clientes">
        <tr>
            <th>Funcionário</th>

            <th>Desconto em Folha</th>
            <th>Parcelas</th>
            <th>Total gasto pelo cliente</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($pedidos as $pedido) : ?>
            <tr>
                <td><?php echo $pedido['nome_funcionario']; ?></td>
                <td><?php echo $pedido['desconto_em_folha'] ? 'Sim' : 'Não'; ?></td>
                <td><?php echo $pedido['parcelas']; ?></td>
                <td class="dinheiro"><?php

                    $totalCliente = 0;

                    // Itera sobre os produtos do pedido
                    foreach ($pedido['produtos'] as $produto) {
                        // Calcula o total do produto (quantidade * preço)
                        $totalProduto = $produto['quantidade'] * $produto['preco'];

                        // Adiciona o total do produto ao total do cliente
                        $totalCliente += $totalProduto;
                    }

                    // Exibe o total do cliente
                    echo 'R$ ' . number_format($totalCliente / 100, 2, ',', '.'); // Divida por 100 se o valor estiver em centavos


                    ?></td>

                <td>
                    <!-- Adicionando um atributo data-pedido para armazenar os dados do pedido -->
                    <a class="btn-info info" href="#" data-pedido='<?php echo json_encode($pedido); ?>'>
                        Ver Pedido
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
    <button onclick="abrirModalFuncionarios()" class="btn-imprimir btn-imprimir-resumo ocultar-ao-imprimir"><i class="fa-solid fa-print"></i></button>

</div>



<div id="suaDiv" class="tabela">
    <div class="head-tabelas">
        <i class="fa-solid fa-box-open"></i>
        <h2>Resumo de produtos vendidos:</h2>
    </div>
    <table class="clientes">
        <tr>
            <th>Produto</th>
            <th>Total de Quantidade</th>
        </tr>

        <?php
        // Array para armazenar o total de cada produto
        $resumo_produtos = array();

        // Itera sobre cada pedido
        foreach ($pedidos as $pedido) {
            // Itera sobre cada produto do pedido
            foreach ($pedido['produtos'] as $produto) {
                $nome_produto = $produto['nome_produto'];
                $quantidade = $produto['quantidade'];
                // Se o produto já existe no resumo, soma a quantidade
                if (isset($resumo_produtos[$nome_produto])) {
                    $resumo_produtos[$nome_produto] += $quantidade;
                } else {
                    // Caso contrário, cria uma nova entrada no resumo
                    $resumo_produtos[$nome_produto] = $quantidade;
                }
            }
        }

        // Exibe o resumo de produtos vendidos
        foreach ($resumo_produtos as $nome_produto => $total_quantidade) {
            echo "<tr>";
            echo "<td>$nome_produto</td>";
            echo "<td>$total_quantidade</td>";
            echo "</tr>";
        }
        ?>

    </table>
    <button onclick="abrirModalResumo()" class="btn-imprimir btn-imprimir-resumo ocultar-ao-imprimir"><i class="fa-solid fa-print"></i></button>
</div>








<div class="tabela">
    <div class="head-tabelas">
        <i class="fa-solid fa-comments-dollar"></i>
        <h2>Contabilidade: </h2>
    </div>
    <table class="clientes">


        <tr>
            <td>Total Faturado:</td>
            <td>R$ <?php
                    print_r($faturamentoPorMes);
                    ?></td>
        </tr>
    </table>
</div>




















<!-- Modal Resumo -->
<div id="modalResumo" class="modal">

    <div class="modal-content">
        <div class="head-tabelas " style="justify-content: space-between;">
            <h2>Resumo da feira na <?php echo $nomeEmpresa['empresa']; ?>  - <?php echo $nomeEmpresa['data']; ?></h2>
            <i class="fa-solid fa-xmark ocultar-ao-imprimir" onclick="fecharModalResumo()"></i>

        </div>
        <table class="clientes">
            <tr>
                <th>Produto</th>
                <th>Total de Quantidade</th>
            </tr>

            <?php
            // Array para armazenar o total de cada produto
            $resumo_produtos = array();

            // Itera sobre cada pedido
            foreach ($pedidos as $pedido) {
                // Itera sobre cada produto do pedido
                foreach ($pedido['produtos'] as $produto) {
                    $nome_produto = $produto['nome_produto'];
                    $quantidade = $produto['quantidade'];
                    // Se o produto já existe no resumo, soma a quantidade
                    if (isset($resumo_produtos[$nome_produto])) {
                        $resumo_produtos[$nome_produto] += $quantidade;
                    } else {
                        // Caso contrário, cria uma nova entrada no resumo
                        $resumo_produtos[$nome_produto] = $quantidade;
                    }
                }
            }

            // Exibe o resumo de produtos vendidos
            foreach ($resumo_produtos as $nome_produto => $total_quantidade) {
                echo "<tr>";
                echo "<td>$nome_produto</td>";
                echo "<td>$total_quantidade</td>";
                echo "</tr>";
            }
            ?>

        </table>
        <button onclick="ImprimirModal()" class="btn-imprimir btn-imprimir-resumo ocultar-ao-imprimir"><i class="fa-solid fa-print"></i></button>

    </div>

</div>







<!-- Modal funcionarios -->
<div id="modalResumoFuncionarios" class="modal">

    <div class="modal-content">
        <div class="head-tabelas " style="justify-content: space-between;">
            <h2>Resumo da feira na <?php echo $nomeEmpresa['empresa']; ?>  - <?php echo $nomeEmpresa['data']; ?></h2>
            <i class="fa-solid fa-xmark ocultar-ao-imprimir" onclick="fecharModalFuncionarios()"></i>

        </div>
        <table class="clientes">
            <tr>
                <th>Funcionário</th>

                <th>Desconto em Folha</th>
                <th>Parcelas</th>
                <th>Total gasto pelo cliente</th>

            </tr>

            <?php foreach ($pedidos as $pedido) : ?>
                <tr>
                    <td><?php echo $pedido['nome_funcionario']; ?></td>
                    <td><?php echo $pedido['desconto_em_folha'] ? 'Sim' : 'Não'; ?></td>
                    <td><?php echo $pedido['parcelas']; ?></td>
                    <td><?php

                        $totalCliente = 0;

                        // Itera sobre os produtos do pedido
                        foreach ($pedido['produtos'] as $produto) {
                            // Calcula o total do produto (quantidade * preço)
                            $totalProduto = $produto['quantidade'] * $produto['preco'];

                            // Adiciona o total do produto ao total do cliente
                            $totalCliente += $totalProduto;
                        }

                        // Exibe o total do cliente
                        echo 'R$ ' . number_format($totalCliente / 100, 2, ',', '.'); // Divida por 100 se o valor estiver em centavos


                        ?></td>


                </tr>
            <?php endforeach; ?>

        </table>
        <div class="or" style="justify-content: space-between; width: 100%; display: flex;">
            <tr>
                <td>Total Faturado:</td>
                <td>R$ <?php
                        print_r($faturamentoPorMes);
                        ?></td>
            </tr>

            <button onclick="imprimirDiv('modalResumoFuncionarios')" class="btn-imprimir btn-imprimir-funcionarios ocultar-ao-imprimir"><i class="fa-solid fa-print"></i></button>

        </div>

    </div>

</div>













<!-- Modal -->
<div id="modal" class="modal">

    <div class="modal-content">
        <div class="modal-header">
            <h2>Detalhes do Pedido</h2>
            <span class="close" onclick="fecharModal()"><i class="fa-solid fa-xmark"></i></span>

        </div>
        <hr>

        <div id="detalhes-pedido"></div>
    </div>
</div>






<script>
    // Adicionando um ouvinte de evento para os links "Ver Pedido"
    var infoLinks = document.querySelectorAll('.btn-info.info');

    infoLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Obtendo os dados do pedido do atributo data-pedido
            var pedidoData = JSON.parse(link.getAttribute('data-pedido'));

            // Exibindo os dados do pedido (pode ajustar conforme necessário)
            console.log('Dados do Pedido:', pedidoData);
        });
    });




    function abrirModal(pedidoData) {
        var detalhesPedido = document.getElementById('detalhes-pedido');
        detalhesPedido.innerHTML = '';

        // Construa o conteúdo da modal com base nos dados do pedido
        detalhesPedido.innerHTML += '<p><strong>Nome do Funcionário:</strong> ' + pedidoData.nome_funcionario + '</p>';
        detalhesPedido.innerHTML += '<p><strong>Desconto em Folha:</strong> ' + (pedidoData.desconto_em_folha ? 'Sim' : 'Não') + '</p>';
        detalhesPedido.innerHTML += '<p><strong>Parcelas:</strong> ' + pedidoData.parcelas + '</p>';

        // Adicione detalhes sobre os produtos (ajuste conforme necessário)
        detalhesPedido.innerHTML += '<p><strong>Produtos:</strong></p>';
        detalhesPedido.innerHTML += '<ul>';
        pedidoData.produtos.forEach(function(produto) {
            detalhesPedido.innerHTML += '<li>' + produto.nome_produto + ' - Quantidade: ' + produto.quantidade + '</li>';
        });
        detalhesPedido.innerHTML += '</ul>';

        // Exibe a modal
        document.getElementById('modal').style.display = 'block';
    }

    function fecharModal() {
        // Fecha a modal
        document.getElementById('modal').style.display = 'none';
    }

    // Adiciona um ouvinte de evento para os links "Ver Pedido"
    var infoLinks = document.querySelectorAll('.btn-info.info');

    infoLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Obtendo os dados do pedido do atributo data-pedido
            var pedidoData = JSON.parse(link.getAttribute('data-pedido'));

            // Abrir a modal com os detalhes do pedido
            abrirModal(pedidoData);
        });
    });




    function abrirModalResumo() {
        // Exibe a modal de resumo
        document.getElementById('modalResumo').style.display = 'block';
    }

    function fecharModalResumo() {
        // Fecha a modal de resumo
        document.getElementById('modalResumo').style.display = 'none';
    }



    function abrirModalFuncionarios() {
        // Exibe a modal de resumo
        document.getElementById('modalResumoFuncionarios').style.display = 'block';
    }

    function fecharModalFuncionarios() {
        // Fecha a modal de resumo
        document.getElementById('modalResumoFuncionarios').style.display = 'none';
    }

    function ImprimirModal() {
        window.print();
    }






    function imprimirDiv(nomeDiv) {
        var conteudoDiv = document.getElementById(nomeDiv).innerHTML;
       
        var janelaImpressao = window.open('', '', 'height=600,width=800');
        janelaImpressao.document.write('<html><head><title>Imprimir Div</title>');
        janelaImpressao.document.write('</head><body>');
        janelaImpressao.document.write(conteudoDiv);
        janelaImpressao.document.write('</body></html>');
        janelaImpressao.document.close();
        janelaImpressao.print();
    }
</script>