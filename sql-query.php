<?php 
$menuRelatorio="is-active";
include('menu.php');
$sql=trim($_POST['sql']);
if(isset($_POST["executar"])!=null){		
		if($sql!=""){				
			$cnx= mysqli_query($phpmyadmin, $sql);
			$erro=mysqli_error($phpmyadmin);
			$x=0;
			if($erro==null){
				while ($row=mysqli_fetch_array($cnx)) { 
					foreach ($cnx as $result) { 
						//print_r($result); 
						//$vt[$x]=print_r($result,true); echo "<br>";
						$vt[$x]=preg_replace("/[^\p{L}\p{N}\s]/", " ", str_replace("Array", "", print_r($result,true)));
						$x++;
					} 
				}
				//$teste=preg_replace("/[^a-zA-Z0-9_]/", " ", str_replace("Array", "", $vt[0]));
				//$teste=preg_replace("/[^\p{L}\p{N}\s]/", " ", str_replace("Array", "", $vt[0]));
				//echo $teste;	
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
					<textarea name="sql" class="textarea" placeholder="SELECT ID FROM ..."></textarea>
				</div>
				<div class="control">
					<button name="executar" type="submit" class="button is-primary">Executar</button>
				</div>	
	     	</form>	     	
	   	</div>
	</section>
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch"><?php	
		for($y=0 ;$y<sizeof($vt) ;$y++):?>
			<tr>
				<td class="is-size-7"><?php echo $vt[$y]; ?></td>
			</tr>	
		<?php endfor?>
	</table>	 	
</body>
</html>