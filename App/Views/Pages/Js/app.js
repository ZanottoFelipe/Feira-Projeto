$(document).ready(function () {
    // Evento de clique do link "Cadastros"
    $('#cadastro').on('click', function (e) {
        e.preventDefault();
        // Adiciona ou remove a classe 'hiden' para controlar a visibilidade
        $('.cadastros').toggleClass('hiden');
    });

    // Evento de clique do botão "Editar Produto"
    $('.editar-produto').on('click', function (e) {
        e.preventDefault();
        editarProduto($(this));
    });

    $('#cancelarEdicao').on('click', function (e) {
        e.preventDefault();
        cancelarEdicao($(this));
    });
    // Evento de clique do botão "Excluir Produto"
    $('.excluir-produto').on('click', function (e) {
        e.preventDefault();
        excluirProduto($(this));
    });

    // Evento de clique do botão "Excluir Feira"
    $('.excluir-feira').on('click', function (e) {
        e.preventDefault();
        excluirFeira($(this));
    });

    // Evento de clique do botão "Cancelar" na modal de confirmação
    $('#cancelarFinalizacao').on('click', function () {
        $('#confirmacaoModalexcluir').modal('hide');
    });

    // Evento de mudança no input de preço
    $('#preco').on('input', function (event) {
        formatarPreco(event.target);
    });

    // Verificar se a feira foi iniciada
    verificarFeiraIniciada();

    verificarbtn();
});

function editarProduto(btnEditar) {
    var nomeProduto = btnEditar.closest('tr').find('td:nth-child(1)').text();
    var precoProduto = btnEditar.closest('tr').find('td:nth-child(2)').text().trim().replace('R$ ', '').replace(',', '.');
    var estoqueProduto = btnEditar.closest('tr').find('td:nth-child(3)').text();
    var codigoProduto = btnEditar.closest('form').find('input[name="id"]').val();

    // Preencher campos do formulário de edição
    $('#nomeProduto').val(nomeProduto);
    $('#preco').val(precoProduto);
    $('#estoqueProduto').val(estoqueProduto);
    $('#codigoProduto').val(codigoProduto);

    // Definir o valor do campo oculto idProduto
    $('#idProduto').val(codigoProduto);

    // Exibir modal de edição
    $('#modalEditarProduto').modal('show');
}

function excluirProduto(btnExcluir) {
    var idProduto = btnExcluir.closest('form').find('input[name="id"]').val();
    confirmarExclusao(idProduto);
}

function excluirFeira(btnExcluir) {
    var idFeira = btnExcluir.closest('form').find('input[name="id"]').val();
    confirmarExclusaoFeira(idFeira);
}
function confirmarExclusaoFeira(id) {
    $('#confirmacaoModalexcluir').modal('show');
    $('#confirmarExclusao').off('click').on('click', function () {
        window.location.href = '?excluir=' + id;
    });
}

function confirmarExclusao(id) {
    $('#confirmacaoModalexcluir').modal('show');
    $('#confirmarExclusao').off('click').on('click', function () {
        window.location.href = '?excluirProduto=' + id;
    });
}
function cancelarEdicao() {
    $('#modalEditarProduto').modal('hide');
}

function formatarPreco(inputPreco) {
    let valorDigitado = inputPreco.value.replace(/\D/g, '');
    valorDigitado = valorDigitado.replace(/^0+/, '');

    while (valorDigitado.length < 3) {
        valorDigitado = '0' + valorDigitado;
    }

    const centavos = valorDigitado.slice(-2);
    const reais = valorDigitado.slice(0, -2) || '0';
    const valorFormatado = reais + ',' + centavos;

    inputPreco.value = valorFormatado;
}

function verificarFeiraIniciada() {
    // Obter os parâmetros da URL
    var urlParams = new URLSearchParams(window.location.search);

    // Verificar se o parâmetro 'FeiraIniciada' existe na URL
    if (urlParams.has('empresa')) {
        var feiraIniciada = urlParams.get('empresa');
        if (feiraIniciada != 'selecione') {
            console.log("Feira Iniciada:", feiraIniciada);
            // Adicionar a classe 'feira-iniciada' para ocultar o sidebar e ajustar o width e left do main
            $('.sidebar').addClass('feira-iniciada-sidebar');
            $('.main').addClass('feira-iniciada');
        }

    } else {
        // Se não existe, imprimir uma mensagem no console
        console.log("Feira não iniciada.");

        // Aqui você pode adicionar qualquer outra lógica que desejar para lidar com o caso em que a feira não está iniciada
    }
}


function verificarbtn() {
    // Obter a parte do caminho da URL
    var pathName = window.location.pathname;

    // Verificar se "Home" está presente no caminho da URL
    if (pathName.includes('Home')) {
        $('#home').addClass('btn');
    }
    if (pathName.includes('Feiras')) {
        $('#feiras').addClass('btn');
    }
    if (pathName.includes('Empresa')) {
        $('.cadastros').toggleClass('hiden');
        $('#empresa-home').addClass('btn');
    }
    if (pathName.includes('usuario')) {
        $('.cadastros').toggleClass('hiden');
        $('#usuario-home').addClass('btn');
    }
    if (pathName.includes('produtos')) {
        $('.cadastros').toggleClass('hiden');
        $('#produtos-home').addClass('btn');
    }
    if (pathName.includes('historico')) {
        $('.solo').addClass('btn');
    }
    if (pathName.includes('Ver feira')) {
        $('.solo').addClass('btn');
    }
}

