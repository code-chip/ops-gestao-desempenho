<?php 

$menuAtivo = "relatorios";
require('menu.php');
$sql = trim($_POST['sql']);

if (isset($_POST["executar"]) != null && $_SESSION["permissao"] == 4) {
	if ($sql != "") {				
		$cnx = mysqli_query($phpmyadmin, $sql);
		$erro = mysqli_error($phpmyadmin);
		$x = 0;

		if ($erro == null) {
			while ($row = mysqli_fetch_array($cnx)) { 
				foreach ($cnx as $result) { 
					$vt[$x] = preg_replace("/[^\p{L}\p{N}\s_]/", " ", str_replace("Array", "", print_r($result,true)));
					$x++;
				} 
			}				
		} else {
			?><script>var erro="<?php echo $erro;?>";  alert('Erro ao enviar: '+erro)</script><?php
		}
	} else {
		echo "<script>alert('O campo não pode está vazio!!')</script>";
	}
} else if (isset($_POST["executar"]) != null) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php'; </script>";
}

?><!DOCTYPE html>
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
	  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	   		<form action="sql-query.php" method="POST">	   					
				<div class="control">
					<textarea id="buscar" name="sql" class="textarea" placeholder="SELECT ID FROM ..."></textarea>
				</div>
				<div class="control">
					<button name="executar" type="submit" class="button is-primary">Executar</button>
				</div>	
	     	</form>	     	
	   	</div><?php
		
		if ($x > 0) {  		
			echo "<table class='table is-bordered pricing__table is-fullwidth is-size-7-touch'>";	
			for ($y = 0 ; $y < sizeof($vt) ; $y++) {
				echo "<tr>
					<td class='is-size-7'>" . $vt[$y] . "</td>
				</tr>";	
			}		
			echo "</table>";
		}	
	?></section>
	<script type="text/javascript">
		$("#buscar").on("blur", function(e) {
	  		verify(e);
		});
		$("#buscar").on("keypress", function(e) {
	  		if (e.keyCode == 13) {
	   		verify(e);
	  	}
		});
		function verify(e) {
		  if (!(/\w/.test($("#buscar").val()))) {
		    e.preventDefault();
		    $('p').html('Preencha algo!');
		  } else {
		    $('p').html('');
		  }
		}	
	</script>	 	
</body>
</html>