<?php 
//include('login-check.php');
$menuInicio="is-active";
include('menu.php');
$n=rand(1,25);
$img="img/wallpaper/data-science".$n."-min.jpg";
//print_r($_SESSION);exit();
$query="SELECT MAX(DATE_FORMAT(ULTIMO_LOGIN,'%Y-%m-%d')) ULTIMO_LOGIN, MAX(ACESSO_TOTAL) TOTAL FROM ACESSO WHERE USUARIO_ID=".$_SESSION["userId"].";";
$acesso=mysqli_query($phpmyadmin, $query);
$cnx=$acesso->fetch_array();
$acesso=$cnx["TOTAL"];
$dataAtual=date_create();
$ultimoLogin=date_create($cnx["ULTIMO_LOGIN"]);
$resultado = date_diff($ultimoLogin, $dataAtual);
$dias= date_interval_format($resultado, '%a');
list($nome, $sobrenome)=explode(' ', $_SESSION["nameUser"],2);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/animate.css" />	
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">-->
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="<?php echo $img;?>" />
	  	<div class="hero-body">
	    	<div class="container">
		     	<h1 class="title animated bounceInDown"><?php		     		
		        	if($_SESSION["$visualizou"]==0){
		        		echo "Bem vindo";
		        		$_SESSION["$visualizou"]=1;		        	
		        	}
		        	else if($_SESSION["$visualizou"]==1 && date('H', time())>="6" && date('H', time())<="11"){		        		
		        		echo "Bom dia";
		        		$_SESSION["$visualizou"]=2;
		        	}
		        	else if($_SESSION["$visualizou"]==1 && date('H', time())>="12" && date('H', time())<="17"){		        		
		        		echo "Boa tarde";
		        		$_SESSION["$visualizou"]=2;
		        	}
		        	else if($_SESSION["$visualizou"]==1 && date('H', time())>="18" && date('H', time())<="23"){		        		
		        		echo "Boa noite";
		        		$_SESSION["$visualizou"]=2;
		        	}
		        	else if($_SESSION["$visualizou"]==1 && date('H', time())>="00" && date('H', time())<="05"){		        		
		        		echo "Boa madrugada";
		        		$_SESSION["$visualizou"]=2;
		        	}
		        	else{
		        		echo "Olá";
		        	}
		        	?>
		      	</h1>
		      	<h3 class="subtitle animated bounceInRight"><?php
		      		if($acesso==1){
		      			echo $nome.", notamos que este é o seu primeiro acesso, espero que goste das novidades.";
		      		}
		      		else if($dias>2 && $dias <7){
		        		echo "Seu último acesso foi há mais de 3 dias, sentimos sua falta ".$nome."!!";
		        	}
		        	else if($dias>6){ 
		        		echo $nome.", notamos sua ausência de uma semana, nos alegramos com o seu retorno ;).";
		        	}
		        	else{
		        		echo $nome;
		        	}
		        	?>
		      	</h3>
	    	</div>
	  	</div>
	</div>
</body>
</html>