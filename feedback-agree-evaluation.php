<?php 
$menuAtivo = 'feedback';
require('menu.php');

$n = rand(1,13);
$img = "img/wallpaper/evaluation" . $n . "-min.jpg";



if (3 == $_SESSION['userId']) {//Monara
	$query = "SELECT ID, NOME FROM USUARIO WHERE SETOR_ID IN (4,5) AND TURNO_ID IN (1,2,3) AND SITUACAO<>'Desligado' ORDER BY NOME";
} else if (57 == $_SESSION['userId']) {//Marivalda
	$query = "SELECT ID, NOME FROM USUARIO WHERE SETOR_ID = 1 AND TURNO_ID = 2 AND SITUACAO<>'Desligado' ORDER BY NOME";
} else if (58 == $_SESSION['userId']) {//Ataíde
	$query = "SELECT ID, NOME FROM USUARIO WHERE SETOR_ID = 3 AND TURNO_ID IN (1,2,3) AND SITUACAO<>'Desligado' ORDER BY NOME";
} else if (99 == $_SESSION['userId']) {//Thiago
	$query = "SELECT ID, NOME FROM USUARIO WHERE SETOR_ID = 1 AND TURNO_ID = 1 AND SITUACAO<>'Desligado' ORDER BY NOME";
} else {//Todos
	$query = 'subordinado';
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Orientações da Avaliação</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/personal.css"/>
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<style type="text/css">
		.button{
			width: 121px;
		}
	</style>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="<?php echo $img;?>" />
	  	<div class="hero-body">
	    	<div class="container">
	    		<form method="POST" action="feedback-agree-evaluation.php">
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
		    	<?php if ($query != 'subordinado'): { ?>	
		    	<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Colaborador:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="usuario">
									<option value="">Selecione</option>
									<?php
										$cnx = mysqli_query($phpmyadmin, $query);
										while($user = mysqli_fetch_assoc($cnx)) {
											echo '<option value="' . $user['ID'] . '">' . $user['NOME'] . '</option>';
										}?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<?php } endif; ?>	
				<div class="control">
				    <label class="checkbox">
					    <input type="checkbox" name="concordo">
				      Eu li e concordo com as orientações
				    </label>
				</div>
				</div>
				<div class="field is-grouped">
				  	<div class="control">
				    	<button class="button is-link" name="iniciar">Iniciar</button>
				  	</div>
				  	<div class="control">
				    	<a href="home.php"><button class="button is-link is-light">Cancelar</button></a>
				  	</div>
				</div> 
				</div>
				</form>
	    	</div>
	  	</div>
	</div>
</body>
</html>
<?php

if (isset($_POST["iniciar"]) && $_POST["concordo"] != null) {
	if ($query == 'subordinado') {
		$_SESSION['user'] = $_POST['usuario'];
	} else {
		$_SESSION['user'] = $_SESSION['userId'];
	}

	echo "<script>window.location.href='feedback-self-evaluation.php';</script>";
}

?>