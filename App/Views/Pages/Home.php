<?php $produtos = \App\Models\ProdutosModel::pegaTodosProdutos() ?>
<div id="container-mensagens" class="container-mensagens">
</div>
<div class="tabela">
    <div class="head-tabelas">
        <i class="fa-regular fa-folder-open"></i>
        <h2>Produtos Cadastrados:</h2>
    </div>
    <table class="clientes">
        <tr>
            <th>Produtos</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $key => $value) : ?>
            <tr>
                <td><?php echo $value['nome'] ?></td>
                <td><?php echo isset($value['preco']) ? 'R$ ' . number_format($value['preco'] / 100, 2, ',', '.') : 'R$ 0,00' ?></td>
                <td><?php echo isset($value['estoque']) ? $value['estoque'] : '0' ?></td>
                <td>
                    <form method="get">
                        <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
                        <input type="button" class="btn-home editar-produto info" value="Editar">

                        <input type="button" class="btn-home excluir-produto excluir" value="Excluir">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>



    </table>
</div>


<div class="tabela">
    <div class="head-tabelas">
        <i class="fa-solid fa-cart-shopping"></i>
        <h2>Produtos com Mais vendas:</h2>
    </div>
    <table class="clientes">
        <tr>
            <th>Produto</th>
            <th>Vendas</th>

        </tr>
        <tr>
            <td>Ovo 250g</td>
            <td>65</td>

        </tr>

    </table>
</div>










<!-- Modal de confirmação -->
<div class="modal fade" id="confirmacaoModalexcluir" tabindex="-1" aria-labelledby="confirmacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmacaoModalLabel">Confirmar Finalização da Feira</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja Excluir o Produto?
            </div>
            <div class="modal-footer">
                <button type="button" id="cancelarFinalizacao" class="btn-modal cancel" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmarExclusao" class="btn-modal confirm">Confirmar Exclusão</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal de editar produto -->
<div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="confirmacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmacaoModalLabel">Editar Produto:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-empresa" method="post">
                    <label for="email">Nome:</label>
                    <input id="nomeProduto" type="text" name="nomeProduto" required>
                    <label for="text">Código:</label>
                    <input id="codigoProduto" type="text" name="codigoProduto">
                    <label for="text">Estoque:</label>
                    <input id="estoqueProduto" type="text" name="estoqueProduto">
                    <label for="preco">Preço:</label>
                    <input id="preco" type="text" name="precoProduto" required>
                    <input id="idProduto" type="hidden" name="idProduto">




                    <div class="modal-footer">
                        <button type="button" id="cancelarEdicao" class="btn-modal cancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="confirmarEdicao" name="editar" class="btn-modal confirm">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>