<?php 
$menuFeedback="is-active";
include('menu.php');
$n=rand(1,13);
$img="img/wallpaper/evaluation".$n."-min.jpg";
?>
<style type="text/css">
	.transparencia {
     filter:alpha(opacity=80);
     opacity: 0.8;
     -moz-opacity:0.8;
     -webkit-opacity:0.8;
}
</style>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Atualizar Cargo</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/login.css" />
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">-->
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="<?php echo $img;?>" />
	  	<div class="hero-body">
	    	<div class="container">
	    		<div class="box transparencia bloco">
	    			<strong>Orientações da Avaliação</strong>
	    			<div class="box antitransparencia">
	    				Olá <?php echo $_SESSION["nameUser"] ?>,<br>
Essa é a sua Avaliação de Desempenho, o preenchimento correto e fidedigno será muito importante para o seu desenvolvimento e a do seu liderado.
A primeira página contém a sua autoavaliação e a segunda página você fará a avaliação da sua liderança.
<br><br>Todas as respostas são obrigatórias, aproveite o campo comentário para enriquecer e evidenciar com fatos ou exemplos da sua avaliação.
No segundo momento de sua avaliação, lembre-se de avaliar o seu líder considerando todo o período de sua sugestão, não considere somente os acontecimentos atuais ou pontos negativos.  
	    			</div>	
		    	<div class="field">
				<div class="control">
				    <label class="checkbox">
					    <input type="checkbox">
				      Eu li e concordo com as orientações
				    </label>
				</div>
				</div>
				<div class="field is-grouped">
				  	<div class="control">
				    	<a href="feedback-self-evaluation.php"><button class="button is-link">Iniciar</button></a>
				  	</div>
				  	<div class="control">
				    	<a href="home.php"><button class="button is-link is-light">Cancelar</button></a>
				  	</div>
				</div> 
				</div>
	    	</div>
	  	</div>
	</div>
</body>
</html>