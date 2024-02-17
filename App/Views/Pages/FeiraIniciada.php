<?php $nome = \App\Models\EmpresaModel::pegaEmpresSimples($_GET['empresa']) ?>
<div id="container-mensagens" class="container-mensagens"></div>

<div class="tabela">
    <div class="head-tabelas">
        <i class="fa-solid fa-download"></i>
        <h2>Feira em andamento: <?php print_r($nome['nome']) ?></h2>
    </div>
    <hr>
    <div class="conteudo-tabela">
        <form id="form-empresa" class="form-empresa" method="post">
            <label for="funcionario">Funcionário:</label>
            <input id="funcionario-feira" type="text" name="funcionario" required>

            <label for="search">Produto:</label>
            <input id="produto" type="search" name="produto[]">

            <table style="margin-top: 20px;" class="clientes">
                <tr>
                    <th>Código</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
                <tbody id="aqui"></tbody>
            </table>
            <div id="pedido" class="hiden">
                <div class="header-pedido">
                    <p>Nome: </p>
                </div>
                <hr>
                <div class="body-pedido">
                    <table style="margin-top: 20px;" id="tabela-pedido-cliente">
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Preço</th>
                            <th>Total</th>
                            <th>Ações</th>
                        </tr>
                        <tbody id="pedido-cliente"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: left;"><strong>Total:</strong></td>
                                <td id="total-pedido">R$ 0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="cobranca">
                        <label for="radio">Desconto em folha?</label>
                        <input id="desconto" type="checkbox" value="desconto" checked>
                    </div>
                    <div class="cobranca">
                        <label for="parcelas">Número de parcelas?</label>
                        <input id="parcelas" type="number" value="1" min="1">
                    </div>



                </div>
            </div>

            <input id="proximo" class="prox hiden" type="button" name="acao" value="Próximo">
            <input class="btn-info pdf" type="button" name="pdf" value="Gerar Pdf">

        </form>
    </div>
</div>

<input id="finalizar-feira" class="btn-info info" type="submit" value="Finalizar Feira!">


<!-- Modal de confirmação -->
<div class="modal fade" id="confirmacaoModal" tabindex="-1" aria-labelledby="confirmacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmacaoModalLabel">Confirmar Finalização da Feira</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja finalizar a feira?
            </div>
            <div class="modal-footer">

                <button type="button" id="cancelarFinalizacao" class="btn-modal cancel" data-bs-dismiss="modal">Cancelar</button>
                <form method="post">
                    <input id="confirma" class="btn-modal confirm" name="finalizarFeira" type="submit" value="Confirmar">
                </form>



            </div>
        </div>
    </div>
</div>



<div id="modal-pdf" class="modal">
    <div class="modal-content">
        <div class="header">
            <div class="flex-modal">
                <h3>Comprovante de Compra ChocoDê</h3>
                <button class="btn-fechar ocultar-ao-imprimir" onclick="fecharModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <p>Eu, <span id="NomeFuncionario"></span>, atesto a realização da minha compra na feira, ocorrida no dia <span id="data"></span>,
                na empresa onde exerço minhas funções profissionais.</p>
        </div>

        <div id="modal-conteudo">
            <table id="modal-tabela-pedido-cliente">
                <thead>
                    <tr>

                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="modal-pedido-cliente"></tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: left;"><strong>Total:</strong></td>
                        <td id="modal-total-pedido">R$ 0.00</td>
                    </tr>
                </tfoot>
            </table>
            <div class="opcoes-pagamento">
                <p>Desconto em folha: <span id="desconto-em-folha"></span></p>
                <p>Parcelas: <span id="parcelas-na-folha"></span></p>
                <p>Valor de cada parcela: <span id="total-por-parcelas"></span></p>
            </div>
        </div>



        <div class="flex-modal">
            <div class="assinatura">
                <p>Assinatura do Cliente:___________________________</p>
                <div class="linha-assinatura"></div>
            </div>
            <button class="btn-imprimir ocultar-ao-imprimir" onclick="imprimirModal()"><i class="fa-solid fa-print"></i></button>
        </div>
    </div>
</div>






















<script>
    function fecharModal() {
        $('#modal-pdf').hide();
    }

    function imprimirModal() {
        window.print();
    }
    const URL = 'https://teste.zanottofelipe.com/projeto/Ajax/Ajax.php';
    //const URL = 'http://localhost/projeto/Ajax/Ajax.php';

    // Seletor do campo de funcionário
    let funcionarioInput = document.getElementById('funcionario-feira');

    // Seletor do campo de produto
    let produtoInput = document.getElementById('produto');

    // Desabilita o campo de produto inicialmente
    produtoInput.disabled = true;

    // Adiciona um ouvinte de evento de entrada no campo de funcionário
    funcionarioInput.addEventListener('input', function() {
        // Verifica se o campo de funcionário está vazio
        if (funcionarioInput.value.trim() === '') {
            // Se estiver vazio, desabilita o campo de produto e limpa seu valor
            produtoInput.disabled = true;
            produtoInput.value = '';
        } else {
            // Se houver algo digitado no campo de funcionário, habilita o campo de produto
            produtoInput.disabled = false;
        }
    });



  





    $(document).ready(function() {
        var allowExit = false;

        // Evento de mudança de foco nos inputs
        $('input').focus(function() {
            console.log($(this).attr('class'));
            // Se o foco estiver no input que permite a saída, permita a saída
            if ($(this).attr('id') === 'confirma' || $(this).attr('id') === 'proximo') {
                allowExit = true;
            } else {
                allowExit = false;
            }
        });

        // Evento de mudança da URL
        $(window).on('beforeunload', function() {
            // Se permitir a saída, não exiba a mensagem de confirmação
            if (allowExit) {
                return;
            }

            // Caso contrário, exiba a mensagem de confirmação
            return 'Tem certeza de que deseja sair? As alterações não salvas serão perdidas.';
        });
    });



    $(document).ready(function() {
        // Evento de submissão do formulário
        $('#finalizar-feira').on('click', function() {
            // Exibir a modal de confirmação
            $('#confirmacaoModal').modal('show');

        });

        // Evento de clique do botão "Cancelar" na modal de confirmação
        $('#cancelarFinalizacao').on('click', function() {
            $('#confirmacaoModal').modal('hide');
        });


    });





    document.addEventListener('DOMContentLoaded', function() {
        var PEDIDO = [];




        $("#produto").keyup(function() {
            var pesquisa = $(this).val();
            $.ajax({
                url: URL,
                method: 'POST',
                data: {
                    dados: pesquisa
                },
                success: function(response) {
                    console.log(response);

                    $("#aqui").empty();

                    try {
                        var parsedResponse = JSON.parse(response);

                        if (Array.isArray(parsedResponse) && parsedResponse.length > 0) {
                            parsedResponse.forEach(function(produto) {
                                $("#aqui").append(
                                    "<tr>" +
                                    "<td>" + produto.codigo + "</td>" +
                                    "<td>" + produto.nome + "</td>" +
                                    "<td>R$ " + (produto.preco / 100).toFixed(2).replace('.', ',') + "</td>" +
                                    "<td><button class='btn-info info adicionar-btn' data-codigo='" + produto.codigo + "' data-nome='" + produto.nome + "' data-preco='" + produto.preco + "'>Adicionar</button> <a class='btn-info excluir' data-codigo='" + produto.codigo + "'>Retirar</a></td>" +
                                    "</tr>"
                                );
                            });
                        } else {
                            console.error("Resposta inesperada:", parsedResponse);
                        }
                    } catch (error) {
                        console.error("Erro ao analisar resposta JSON:", error);
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        $(document).off('click', '.adicionar-btn').on('click', '.adicionar-btn', function(e) {
            e.preventDefault();

            let nome = $('#funcionario-feira').val();
            let codigo = $(this).data('codigo');
            let produtoNome = $(this).data('nome');
            let preco = $(this).data('preco');
            let quantidadeAtual = 1;

            let clienteExistente = PEDIDO.find((cliente) => cliente.nome === nome);

            if (clienteExistente) {
                let produtoExistente = clienteExistente.pedido.find((item) => item.codigo === codigo);

                if (produtoExistente) {
                    produtoExistente.quantidade += quantidadeAtual;
                } else {
                    clienteExistente.pedido.push({
                        codigo: codigo,
                        nome: produtoNome,
                        preco: preco,
                        quantidade: quantidadeAtual
                    });
                }
            } else {
                let novoCliente = {
                    nome: nome,
                    pedido: [{
                        codigo: codigo,
                        nome: produtoNome,
                        preco: preco,
                        quantidade: quantidadeAtual
                    }]
                };
                PEDIDO.push(novoCliente);
            }
            $('#produto').val('');
            console.log(PEDIDO);

            if (PEDIDO.length > 0) {
                $("#pedido").removeClass('hiden');

                // Limpa a tabela antes de recriá-la
                $("#pedido-cliente").empty();

                let totalPedido = 0;

                PEDIDO.forEach(function(cliente) {
                    $("#pedido .header-pedido p").text("Nome: " + cliente.nome);
                    let totalPedido = 0;

                    cliente.pedido.forEach(function(item) {
                        let totalItem = parseFloat(item.quantidade * item.preco) / 100; // Convertendo o preço para reais
                        totalPedido += totalItem;

                        $("#pedido-cliente").append(
                            "<tr>" +
                            "<td>" + item.nome + "</td>" +
                            "<td>" + item.quantidade + "</td>" +
                            "<td>R$ " + (item.preco / 100).toFixed(2).replace('.', ',') + "</td>" + // Formatando o preço
                            "<td>R$ " + totalItem.toFixed(2).replace('.', ',') + "</td>" + // Formatando o total do item
                            "<td><button class='btn-info excluir' data-codigo='" + item.codigo + "'>Retirar</button></td>" +
                            "</tr>"
                        );
                    });

                    $("#total-pedido").text("R$ " + totalPedido.toFixed(2).replace('.', ',')); // Formatando o total do pedido
                });

            }
        });

        $(document).off('click', '.excluir').on('click', '.excluir', function(e) {
            e.preventDefault();

            let nome = $('#funcionario-feira').val();
            let codigo = $(this).data('codigo');
            let clienteExistente = PEDIDO.find((cliente) => cliente.nome === nome);

            if (clienteExistente) {
                let produtoExistenteIndex = clienteExistente.pedido.findIndex((item) => item.codigo === codigo);

                if (produtoExistenteIndex !== -1) {
                    if (clienteExistente.pedido[produtoExistenteIndex].quantidade > 1) {
                        clienteExistente.pedido[produtoExistenteIndex].quantidade--;
                    } else {
                        clienteExistente.pedido.splice(produtoExistenteIndex, 1);
                    }

                    // Atualize a tabela e o total
                    atualizarTabelaPedido(clienteExistente);
                }
            }
        });

        function atualizarTabelaPedido(cliente) {
            if (PEDIDO.length > 0) {
                $("#pedido").removeClass('hiden');

                // Limpa a tabela antes de recriá-la
                $("#pedido-cliente").empty();

                let totalPedido = 0;

                cliente.pedido.forEach(function(item) {
                    let totalItem = parseFloat(item.quantidade * item.preco) / 100; // Convertendo o preço para reais
                    totalPedido += totalItem;

                    $("#pedido-cliente").append(
                        "<tr>" +
                        "<td>" + item.nome + "</td>" +
                        "<td>" + item.quantidade + "</td>" +
                        "<td>R$ " + (item.preco / 100).toFixed(2).replace('.', ',') + "</td>" + // Formatando o preço
                        "<td>R$ " + totalItem.toFixed(2).replace('.', ',') + "</td>" + // Formatando o total do item
                        "<td><button class='btn-info excluir' data-codigo='" + item.codigo + "'>Retirar</button></td>" +
                        "</tr>"
                    );
                });

                $("#total-pedido").text("R$ " + totalPedido.toFixed(2).replace('.', ',')); // Formatando o total do pedido
            } else {
                $("#pedido").addClass('hiden');
            }

        }









        $(document).off('click', '.pdf').on('click', '.pdf', function() {
            // Obter os valores dos campos
            let descontoEmFolha = $('#desconto').is(':checked') ? 'Sim' : 'Não';
            let numeroDeParcelas = $('#parcelas').val();
            var dataAtual = new Date();
            // Formata a data como DD/MM/AAAA (por exemplo, 25/01/2024)
            var formatoData = dataAtual.getDate() + '/' + (dataAtual.getMonth() + 1) + '/' + dataAtual.getFullYear();

            // Obter informações da URL
            let urlParams = new URLSearchParams(window.location.search);
            let empresaId = urlParams.get('empresa');

            // Adicionar valores aos clientes no objeto PEDIDO
            PEDIDO.forEach(function(cliente) {
                cliente.descontoEmFolha = descontoEmFolha;
                cliente.numeroDeParcelas = numeroDeParcelas;

                // Adicionar informações da URL
                cliente.empresaId = empresaId;
            });

            // Agora você pode enviar o objeto PEDIDO para o servidor ou fazer o que for necessário com esses valores
            console.log(PEDIDO);

            // ... Código anterior para obter o JSON ...

            if (PEDIDO.length > 0) {
                // Preencher os campos da modal
                let cliente = PEDIDO[0]; // Considerando apenas o primeiro cliente para simplificar
                $('#NomeFuncionario').text(cliente.nome);
                $('#data').text(formatoData);
                $('#nomeEmpresa').text(cliente.empresa);
                $('#desconto-em-folha').text(descontoEmFolha);
                $('#parcelas-na-folha').text(numeroDeParcelas);

                // Calcula o total do pedido
                let totalPedido = 0;

                cliente.pedido.forEach(function(item) {
                    let totalItem = parseFloat(item.quantidade * item.preco) / 100; // Convertendo o preço para reais
                    totalPedido += totalItem;

                    $("#modal-pedido-cliente").append(
                        "<tr>" +
                        "<td>" + item.nome + "</td>" +
                        "<td>" + item.quantidade + "</td>" +
                        "<td>R$ " + (item.preco / 100).toFixed(2).replace('.', ',') + "</td>" + // Formatando o preço
                        "<td>R$ " + totalItem.toFixed(2).replace('.', ',') + "</td>" + // Formatando o total do item
                        "</tr>"
                    );
                });

                // Preenche o campo total-por-parcelas
                $('#total-por-parcelas').text('R$ ' + (totalPedido / parseInt(numeroDeParcelas)).toFixed(2).replace('.', ','));

                $("#modal-total-pedido").text("R$ " + totalPedido.toFixed(2).replace('.', ',')); // Formatando o total do pedido

                // Exibir a modal
                $('#modal-pdf').show();
                $("#proximo").removeClass('hiden');

            } else {
                alert('Não há itens para gerar o PDF.');
            }
        });






        $(document).off('click', '.prox').on('click', '.prox', function() {
            // Obter os valores dos campos
            let descontoEmFolha = $('#desconto').is(':checked');
            let numeroDeParcelas = $('#parcelas').val();

            // Obter informações da URL
            let urlParams = new URLSearchParams(window.location.search);
            let empresaId = urlParams.get('empresa');
            let idFeira = urlParams.get('idFeira');

            // Adicionar valores aos clientes no objeto PEDIDO
            PEDIDO.forEach(function(cliente) {
                cliente.descontoEmFolha = descontoEmFolha;
                cliente.numeroDeParcelas = numeroDeParcelas;

                // Adicionar informações da URL
                cliente.empresaId = empresaId;
                cliente.idFeira = idFeira;
            });

            // Agora você pode enviar o objeto PEDIDO para o servidor ou fazer o que for necessário com esses valores
            console.log(PEDIDO);

            if (PEDIDO.length > 0) {
                $.ajax({
                    url: URL,
                    method: 'POST',
                    data: {
                        proximo: JSON.stringify(PEDIDO)
                    },
                    dataType: 'json',
                    success: function(response, status, xhr) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Falha ao salvar pedido.');
                        }
                    },

                });
            } else {
                alert('Não há pedido para enviar.');
            }
        });




    });
</script>