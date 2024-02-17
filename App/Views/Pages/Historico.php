<div id="container-mensagens" class="container-mensagens">
</div>

<div class="tabela">
    <div class="head-tabelas">
        <i class="fa-solid fa-cloud"></i>
        <h2>Histórico de Feiras:</h2>
    </div>
    <table class="clientes">
        <?php $feiras = \App\Models\FeirasModel::recuperaFeira() ?>

        <tr>
            <th>Empresa</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
        <?php if ($feiras == '') { ?>
            <h3>Não existe feiras cadastradas até o momento!</h3>

        <?php } else { ?>

            <?php foreach ($feiras as $key => $value) { ?>

                <tr>

                    <td><?php echo $value['empresa'] ?></td>
                    <td><?php echo $value['data'] ?></td>
                    <td>
                        <form method="get">
                            <input type="submit" name="FeiraSingle" value="Ver feira">
                            <input type="hidden" name="id" value="<?php echo $value['idNumero']; ?>">
                            <a href="<?php echo $value['url']; ?>" class="btn-a">Continuar Feira</a>
                            <input id="unico" class="excluir-feira btn-a" type="submit" name="excluir" value="Excluir Feira">

                        </form>
                    </td>
                </tr>
        <?php }
        } ?>


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
                Tem certeza de que deseja Excluir a feira?
            </div>
            <div class="modal-footer">
                <button type="button" id="cancelarFinalizacao" class="btn-modal cancel" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmarExclusao" class="btn-modal confirm">Confirmar Exclusão</button>
            </div>
        </div>
    </div>
</div>