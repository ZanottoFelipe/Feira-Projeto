<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH_STATIC ?>estilos/style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/fd81845bd8.js" crossorigin="anonymous"></script>
   

    <title>Feira - ChocoDe</title>
</head>



<body>

    <div id="sidebar" class="sidebar">
        <div class="lgo"><img src="<?php echo INCLUDE_PATH_STATIC ?>images/logo.png"></div>
        <hr>
        <div class="menu ">
            <a id="home"  href="Home"><i class="fa-solid fa-house"></i> Home</a>
            <a id="feiras" href="Feiras"><i class="fa-solid fa-right-to-bracket"></i> Iniciar Feira</a>
            
            <a id="cadastro"  href="#"><i class="fa-solid fa-arrow-right"></i> Cadastros</a>
            
            <!-- escondido !-->
            <div class="cadastros hiden fadeInDown" >
                <a id="empresa-home" href="Empresa"><i class="fa-solid fa-city"></i> Cadastro de empresa</a>
                <a id="usuario-home" href="usuario"><i class="fa-regular fa-user"></i> Cadastro de usuário</a>
                <a id="produtos-home" href="produtos"><i class="fa-solid fa-download"></i> Cadastro de produtos</a>
                <hr>
            </div>
            
            <a class="solo" id="historico" href="historico"><i class="fa-solid fa-cloud"></i> Histórico de feiras</a>
            <a  href="?sair"><i class="fa-solid fa-xmark"></i> Sair</a>

        </div>
    </div>
    <main id="main" class="main">