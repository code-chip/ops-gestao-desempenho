<?php 
$menuAtivo = 'feedback';
require('menu.php');

$n = rand(1,13);
$img = "img/wallpaper/evaluation" . $n . "-min.jpg";
$yearMonther = date('Y-m');

if($_SESSION["permissao"] == 1) {
	$c = mysqli_query($phpmyadmin, "SELECT TIMESTAMPDIFF(MONTH,EFETIVACAO,NOW() ) AS MESES FROM USUARIO WHERE ID=".$_SESSION['userId']);
	$houseTime = $c->fetch_array();

	if ($houseTime["MESES"] < 4){
		echo "<script>alert('Pouco tempo de casa, aguarde o próximo ciclo de avaliação!'); window.location.href='home.php';</script>";
	}

}

$query = "SELECT ID, NOME FROM USUARIO WHERE GESTOR_ID = " . $_SESSION['userId'] . " AND ID NOT IN(SELECT USUARIO_ID FROM AVAL_INDICE WHERE AVALIACAO_POR = " . $_SESSION['userId'] . " AND DATE_FORMAT(REGISTRO, '%Y-%m')='" . $yearMonther . "') AND SITUACAO<>'Desligado' ORDER BY NOME";

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
	<script type="text/javascript" src="js/myjs.js"></script>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="<?php echo $img;?>" />
	  	<div class="hero-body">
	    	<div class="container">
	    		<form method="POST" action="feedback-agree-evaluation.php" onsubmit="return check()">
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
		    	<?php if ($_SESSION['permissao'] > 1): { ?>	
		    	<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Colaborador*:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="usuario" class="required">
									<option value="">Selecione</option>
									<?php
										$cnx = mysqli_query($phpmyadmin, $query);
										while($user = mysqli_fetch_assoc($cnx)) {
											echo '<option value="' . $user['ID'] . '">' . $user['NOME'] . '</option>';
										}
										
										echo '<option value="' . $_SESSION['userId'] . '">' . $_SESSION['nameUser'] . '</option>';
									?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<?php } endif; ?>	
				<div class="control">
				    <label class="checkbox">
					    <input type="checkbox" name="concordo" class="required">
				      Eu li e concordo com as orientações*
				    </label>
				</div>
				</div>
				<div class="field is-grouped">
				  	<div class="control">
				    	<button class="button is-link btn128" name="iniciar">Iniciar</button>
				  	</div>
				  	<div class="control">
				    	<a href="home.php"><button class="button is-link is-light btn128">Cancelar</button></a>
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

if (isset($_POST['iniciar']) && $_POST['concordo'] != null) {
	if ($_SESSION['permissao'] > 1) {
		$_SESSION['user'] = $_POST['usuario'];

		echo "<script>window.location.href='feedback-self-evaluation.php';</script>";
	} else {
		$_SESSION['user'] = $_SESSION['userId'];

		echo "<script>window.location.href='feedback-self-evaluation.php';</script>";	
	}
	
}

?>