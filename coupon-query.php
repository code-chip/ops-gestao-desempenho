<?php 
$menuAtivo="Feedback";
include('menu.php');
$n=rand(1,13);
$img="img/wallpaper/evaluation".$n."-min.jpg";
if(isset($_POST["iniciar"]) && $_POST["concordo"]!=null){
	//echo "<script>window.location.href='feedback-self-evaluation.php';</script>";
}
/*Verifica se existe celular e endereço cadastrado*/
$checkAdress="SELECT CELULAR, (SELECT COUNT(*) FROM ENDERECO WHERE USUARIO_ID=".$_SESSION["userId"].") AS ENDERECO FROM USUARIO WHERE ID=".$_SESSION["userId"];
$cnx=mysqli_query($phpmyadmin, $checkAdress);
$validate= $cnx->fetch_array();
if($validate["CELULAR"]!=NULL && $validate["ENDERECO"]==1){
	$cupom= $cnx->fetch_array();
	$checkCupom="SELECT CODIGO FROM CUPOM WHERE MATRICULA_ID=".$_SESSION["matriculaLogada"]." ORDER BY REGISTRO DESC LIMIT 1;";
	$cnx2=mysqli_query($phpmyadmin, $checkCupom);
	$cupom= $cnx2->fetch_array();
}
else if($validate["CELULAR"]==NULL){
	echo "<script>alert('Para acessar o seu cupom, o preenchimendo do campo Celular em Configurações->Atualizar Usuário é obrigatório!'); window.history.back();</script>";
}
else{
	echo "<script>alert('Para acessar o seu cupom, o cadastro do endereço em Configurações->Inserir Endereçõ é obrigatório!'); window.history.back();</script>";
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
</script>
	
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="<?php echo $img;?>" />
	  	<div class="hero-body">
	    	<div class="container">
	    		<form method="POST" action="coupon-query.php">
	    		<div class="box transparencia bloco">
	    			<strong>Cupom eviner, desconto de até R$100!</strong>
	    			<div class="box antitransparencia">
	    				Olá eviner <?php echo $_SESSION["nameUser"] ?>, aproveite o seu cupom:<br><h6 class="is-size-1" id="cupom" value="<?php echo $cupom["CODIGO"]?>"><?php echo $cupom["CODIGO"]?></h6> 
	    			</div>	
		    	<div class="field">
				<div class="control">
				    <label class="checkbox">
					    <input type="checkbox" id="demso" name="concordo" value="<?php echo $cupom["CODIGO"]?>">					    
				      Cupom usado
				    </label>
				</div>				
				</div>
				<textarea id="demo" style="position: absolute; margin-top: -2000px;"><?php echo $cupom["CODIGO"]?></textarea>
				<div class="field is-grouped">
				  	<div class="control">
				    	<button class="button is-link" name="iniciar" onclick="copyText()">Copiar</button>
				  	</div>
				  	<div class="control">
				    	<button class="button is-link" name="usado">Usado</button>
				  	</div>
				  	<div class="control">
				    	<a href="home.php"><button class="button is-link is-light">Voltar</button></a>
				  	</div>
				</div>				 
				</div>
				</form>
	    	</div>
	  	</div>
	</div>
	<script type="text/javascript">
		document.getElementById("botao").addEventListener("click", function(){
			document.getElementById("cupom").select();
			document.execCommand('copy');
		});
	</script>
</body>
</html>