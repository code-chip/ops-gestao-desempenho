<?php

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

$loginError = false;

if (isset($_SESSION['not_authenticated'])) {
    $loginError = true;
    unset($_SESSION['not_authenticated']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gestão de Desempenho - Login</title>
    <link rel="shortcut icon" href="/images/favicon_codechip.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="/css/personal.css" />
    <link rel="stylesheet" href="/css/bulma.min.css" />
    <link rel="stylesheet" href="/css/login.css" />
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="/js/myjs.js"></script>    
    <style>
        .hero-background.is-transparent { opacity: 0.73; }
    </style>
</head>
<body>
<div class="hero is-fullheight is-primary has-background">
    <img alt="wallpaper" class="hero-background is-transparent" src="/images/wallpaper/data-science9-min.jpg" />
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-blue">Gestão de Desempenho</h3>

                <?php if ($loginError): ?>
                    <div class="notification is-danger">
                        <p>ERRO: Usuário ou senha inválidos.</p>
                    </div>
                <?php endif; ?>

                <div class="box">
                    <form action="/login" method="POST">
                        <div class="field">
                            <div class="control has-icons-left is-large" id="usuario">
                                <input name="user" type="text" class="input is-large" placeholder="Seu usuário" autofocus>
                                <span class="icon is-medium is-left">
                                    <i class="fas fa-user"></i>
                                </span>                                    
                            </div>
                        </div>
                        <div class="field">
                            <div class="control has-icons-left is-large" id="senha">
                                <input name="password" class="input is-large" type="password" placeholder="Sua senha">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="button is-block is-link is-large is-fullwidth">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>      
    <div class="copyright">
        <div class="container">
            <p>&copy; 2019 - Desenvolvido por: <a href="https://codechip.com.br/" target="_blank">Code Chip <img src="/images/favicon_codechip.ico"/></a></p>
        </div>
    </div>
</div>
</body>
</html>
