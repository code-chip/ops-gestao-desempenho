<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestão de Desempenho</title>
    <link rel="shortcut icon" href="img\favicon_codechip.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/personal.css" />
    <link rel="stylesheet" href="css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <!---<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">-->
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script type="text/javascript" src="js/myjs.js"></script>    
    <style type="text/css">
        .hero-background.is-transparent{
        opacity: 0.73;
    }
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics 
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-156503826-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-156503826-3');
    </script>-->
</head>
<body>
    <div class="hero is-fullheight is-primary has-background">
        <img alt="Fill Murray" class="hero-background is-transparent" src="img/wallpaper/data-science9-min.jpg" />
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-blue">Gestão de Desempenho</h3>
                     <?php
                    if(isset($_SESSION['nao_autenticado'])):
                    ?>
                    <div class="notification is-danger">
                      <p>ERRO: Usuário ou senha inválidos.</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['nao_autenticado']);
                    ?>
                    <div class="box">
                        <form action="login.php" method="POST">
                            <div class="field">
                                <div class="control has-icons-left is-large" id="usuario">
                                    <input name="usuario" type="text" class="input is-large" placeholder="Seu usuário" onkeypress="addLoadField('usuario')" onkeyup="rmvLoadField('usuario')" autofocus="enable">
                                    <span class="icon is-medium is-left">
                                        <i class="fas fa-user"></i>
                                    </span>                                    
                                </div>
                            </div>

                            <div class="field">
                                <div class="control has-icons-left is-large" id="senha">
                                    <input name="senha" class="input is-large" type="password" placeholder="Sua senha" onkeypress="addLoadField('senha')" onkeyup="rmvLoadField('senha')">
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
            <p>&copy; Copyright 2019 - Desenvolvido por:<a href="https://codechip.com.br/" target="blank"> Code Chip <img src="img\favicon_codechip.ico"/></a></p>
        </div>
  </div>
</body>
</html>