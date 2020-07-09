<?php 
$menuAtivo = 'rh';
include('menu.php');
$n = rand(1,1);
$img = "img/wallpaper/coupon".$n."-min.png";

/*Verifica se existe celular e endereço cadastrado*/
$cnx = mysqli_query($phpmyadmin, "SELECT CELULAR, (SELECT COUNT(*) FROM ENDERECO WHERE USUARIO_ID=".$_SESSION["userId"].") AS ENDERECO FROM USUARIO WHERE ID=".$_SESSION["userId"]);
$validate = $cnx->fetch_array();

if ($validate["CELULAR"] != NULL && $validate["ENDERECO"] == 1) {
	$cupom = $cnx->fetch_array();
	$cnx2 = mysqli_query($phpmyadmin, "SELECT CODIGO, UTILIZADO FROM CUPOM WHERE MATRICULA_ID=".$_SESSION["matriculaLogada"]." ORDER BY REGISTRO DESC LIMIT 1;");
	$cupom = $cnx2->fetch_array();
	if (mysqli_num_rows($cnx2) == 0) {
		echo "<script>alert('Não foi liberado nenhum cupom p/ o seu usuário.'); window.history.back(); </script>";
	}
} else if ($validate["CELULAR"] == NULL) {
	echo "<script>alert('Para acessar o seu cupom, o preenchimendo do campo Celular em Configurações->Atualizar Usuário é obrigatório!'); window.history.back();</script>";
} else {
	echo "<script>alert('Para acessar o seu cupom, o cadastro do endereço em Configurações->Inserir Endereçõ é obrigatório!'); window.history.back();</script>";
}

if (isset($_POST["utilizado"])) {
	mysqli_query($phpmyadmin, "UPDATE CUPOM SET UTILIZADO='s' WHERE MATRICULA_ID=".$_SESSION["matriculaLogada"]);
	echo "<script>alert('Utilização do cupom registrado com sucesso!'); window.location.href=window.location.href;</script>";
}

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
	<script>
	  	function copyText() {
	    	document.getElementById("demo").select();
	    	document.execCommand('copy');
		}
		function checkForm() {
			var clique = document.getElementById("utilizado").checked;
			
			if (clique == false) {
				alert('Marque o checkbox "Cupom utilizado"!');
			}

			return clique;
		}
	</script>
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
	    		<form method="POST" action="coupon-query.php" onsubmit="return checkForm(form1.usado)" id="form1">
	    		<div class="box transparencia bloco">
	    			<strong>Cupom eviner, desconto de até R$50!</strong>
	    			<div class="box antitransparencia">
	    				Olá eviner <?php echo $_SESSION["nameUser"] ?>, aproveite o seu cupom:<br><h6 class="is-size-1" id="cupom" value=""><?php echo $cupom["CODIGO"]?></h6> 
	    			</div>	
		    	<div class="field">
				<div class="control">
				    <label class="checkbox">
					    <input type="checkbox" id="utilizado" name="utilizado" <?php if($cupom["UTILIZADO"]=="s"){ echo "checked";}?>>					    
				      Cupom utilizado
				    </label>
				</div>				
				</div>
				<textarea id="demo" style="position: absolute; margin-top: -2000px;"><?php echo $cupom["CODIGO"]?></textarea>
				<div class="field is-grouped">
				  	<div class="control">
				    	<button type="button" class="button is-link" name="iniciar" onclick="copyText()">Copiar cupom</button>
				  	</div>
				  	<div class="control">
				    	<button class="button is-link" name="utilizado" id="utilizadoBotao">Utilizado</button>
				  	</div>
				  	<div class="control">
				    	<a href="home.php" class="button is-link is-light">Voltar</a>
				  	</div>
				</div>				 
				</div>
				</form>
	    	</div>
	  	</div>
	</div>
</body>
</html>