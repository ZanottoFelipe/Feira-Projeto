<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH_STATIC?>estilos/styleLogin.css">
</head>
<body>
    <div id="container-mensagens" class="container-mensagens">   
    </div>
    <div id="divAlerta"></div>
    <div class="page">
        <form method="POST" class="formLogin">
            <h1>Cadastro</h1>
            <p>Digite os seus dados de acesso no campo abaixo.</p>
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Digite seu e-mail" autofocus="true" />
            <label for="password">Senha</label>
            <input type="password" name="senha" placeholder="Digite sua senha" />
            <a href="Login">Login</a>
            <input type="submit" name="acao" value="Acessar" class="btn" />
        </form>
    </div>
    
    

    <script type="text/javascript" src="<?php echo INCLUDE_PATH_STATIC?>Js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="<?php echo INCLUDE_PATH_STATIC?>Js/modernizr-3.5.0.min.js"></script>
    <script type="text/javascript" src="<?php echo INCLUDE_PATH_STATIC?>Js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo INCLUDE_PATH_STATIC?>Js/popper.min.js"></script> 
    <script type="text/javascript" src="<?php echo INCLUDE_PATH_STATIC?>Js/wow.min.js"></script>    
 
    
    <script>new WOW().init();</script>



</body>
</html>