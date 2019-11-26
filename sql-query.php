<?php 
$menuRelatorio="is-active";
include('menu.php');
$sql=trim($_POST['sql']);

if(isset($_POST["executar"])!=null){
	$sql="SELECT * FROM USUARIO;";
	if($sql!=""){				
		$cnx= mysqli_query($phpmyadmin, $sql);
		$erro=mysqli_error($phpmyadmin);
		$x=0;
		if($erro==null){
			while ($dados= $cnx->fetch_array()) {
				//echo $dados[$x];
				echo $cnx->fetch_array();
				$x++;
			}

		}
		else{
			?><script>var erro="<?php echo $erro;?>";  alert('Erro ao enviar: '+erro)</script><?php
		}
	}	
	else{
		echo "<script>alert('O campo não pode está vazio!!')</script>";
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Relatório SQL</title>
	<style type="text/css">
		.carregando{
		color:#ff0000;
		display:none;
		}
	</style>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form action="sql-query.php" method="POST">	   					
				<div class="control">
					<textarea nome="sql" class="textarea" placeholder="SELECT ID FROM ..."></textarea>
				</div>
				<div class="control">
					<button name="executar" type="submit" class="button is-primary">Executar</button>
				</div>	
	     	</form>	     	
	   	</div>
	</section>	 	
</body>
</html>