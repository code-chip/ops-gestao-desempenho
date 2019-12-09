<?php 
$menuRelatorio="is-active";
include('menu.php');
$sql=trim($_POST['sql']);
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
					<textarea name="sql" class="textarea" placeholder="SELECT ID FROM ..."></textarea>
				</div>
				<div class="control">
					<button name="executar" type="submit" class="button is-primary">Executar</button>
				</div>	
	     	</form>	     	
	   	</div>
	</section>
	<table><?php	
	if(isset($_POST["executar"])!=null){		
		if($sql!=""){				
			$cnx= mysqli_query($phpmyadmin, $sql);
			$erro=mysqli_error($phpmyadmin);
			$x=0;
			if($erro==null){
				while ($row=mysqli_fetch_array($cnx)) { print_r($row); } 
				/*while ($dados= $cnx->fetch_array()) {
				 	
				 	foreach($dados as $a) { echo $a." "; }
				} */
				echo sizeof($row);	
			}
			else{
				?><script>var erro="<?php echo $erro;?>";  alert('Erro ao enviar: '+erro)</script><?php
			}
		}	
		else{
			echo "<script>alert('O campo não pode está vazio!!')</script>";
		}
	}?>
	</table>	 	
</body>
</html>