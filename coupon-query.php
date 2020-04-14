<?php 
$menuAtivo="Feedback";
include('menu.php');
$n=rand(1,13);
$img="img/wallpaper/evaluation".$n."-min.jpg";
if(isset($_POST["iniciar"]) && $_POST["concordo"]!=null){
	echo "<script>window.location.href='feedback-self-evaluation.php';</script>";
}
$checkCupom="SELECT CODIGO FROM CUPOM WHERE MATRICULA_ID=".$_SESSION["matriculaLogada"]." ORDER BY REGISTRO DESC LIMIT 1;";
$cnx=mysqli_query($phpmyadmin, $checkCupom);
$cupom= $cnx->fetch_array();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Cupom</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/personal.css"/>
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script type="text/javascript">
		document.getElementById(“botao”).addEventListener(“click”, function(){
		document.getElementById(“texto”).select();
		document.execCommand(‘copy’);

});
	</script>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="<?php echo $img;?>" />
	  	<div class="hero-body">
	    	<div class="container">
	    		<form method="POST">
	    		<div class="box transparencia bloco">
	    			<strong>Cupom eviner, desconto de até R$100!</strong>
	    			<div class="box antitransparencia">
	    				Olá eviner <?php echo $_SESSION["nameUser"] ?>, aproveite o seu cupom:<br><h6 class="is-size-1"><?php echo $cupom["CODIGO"]?></h6> 
	    			</div>	
		    	<div class="field">
				<div class="control">
				    <label class="checkbox">
					    <input type="checkbox" name="concordo">
				      Cupom usado
				    </label>
				</div>
				</div>
				<div class="field is-grouped">
				  	<div class="control">
				    	<button class="button is-link" name="iniciar">Copiar</button>
				  	</div>
				  	<div class="control">
				    	<button class="button is-link" name="iniciar">Registrar</button>
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