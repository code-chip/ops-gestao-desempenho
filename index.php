<?php 
session_start();
?>
<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema Logístico</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/personal.css" />
    <link rel="stylesheet" href="css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">	 
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Sistema Logístico</h3>
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
                                <div class="control">
                                    <input name="usuario" name="text" class="input is-large" placeholder="Seu usuário" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="senha" class="input is-large" type="password" placeholder="Sua senha">
                                </div>
                            </div>
                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		<style>	
			.copyright {			  
			  width: 100%;
			  padding: 10px 0;		  
			  font-size: 14px;
			  font-weight: bold;
			  text-align: center;
			}
			.copyright p{
				color:#1E90FF;
				margin:0;
			}
			.copyright a:hover {
			  text-decoration: underline;
			  color:#008B00;
			}			
			.copyright img{			 
				margin: -1px 1px;
			}		
		</style>
		<div class="copyright">
        <div class="container">
            <p>&copy; Copyright 2019 - Desenvolvido por:<a href="https://codechip.com.br/" target="blank"> Code Chip <img src="img\favicon_codechip.ico"/></a></p>
        </div>
    </section>
</body>

</html>