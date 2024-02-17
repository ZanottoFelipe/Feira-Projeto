<div id="container-mensagens" class="container-mensagens">
</div>



<div class="tabela">
    <div class="head-tabelas">
        <i class="fa-solid fa-download"></i>
        <h2>Feira:</h2>
    </div>
    <hr>
    <div class="conteudo-tabela">
        <label for="empresa">Empresa:</label>
        <form method="get">
        <select name="empresa" id="seletor-empresas-feiras">

            <option value="selecione" select>Selecione</option>
            <?php $empresas = \App\Models\EmpresaModel::pegaEmpresas()?>
            <?php foreach($empresas as $key => $value){ ?>
            <option value="<?php echo $value['id']?>"><?php echo $value['nome']?></option>
            <?php } ?>
        </select>
        <input id="iniciar-feira" type="hidden" name="idFeira" value="<?php echo \App\Controllers\FeirasController::idFeira() ?>">

        <input id="iniciar-feira" type="submit" name="FeiraIniciada" value="Iniciar Feira!">
        </form>
    </div>

</div>