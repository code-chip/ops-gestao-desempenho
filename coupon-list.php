<style type="text/css"></style>
<?php
$menuAtivo="configuracoes";
include('menu.php');
if($_SESSION["permissao"]!=4 && $_SESSION["cargo"]!=12){
	echo "<script>alert('Usuário sem permissão'); window.history.back()</script>";
}
else{
$contador = 0;
$query="SELECT C.MATRICULA_ID, U.NOME, C.CODIGO, C.UTILIZADO, C.REGISTRO FROM CUPOM C INNER JOIN USUARIO U ON U.MATRICULA=C.MATRICULA_ID WHERE REGISTRO=(SELECT MAX(REGISTRO) FROM CUPOM);";
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($list= $cnx->fetch_array()){
		$vtMatricula[$x]=$list["MATRICULA_ID"];
		$vtNome[$x]=$list["NOME"];		
		$vtCodigo[$x]=$list["CODIGO"];
		if($list["UTILIZADO"]=="s"){
			$vtUtilizado[$x]="Sim";
		}
		else{
			$vtUtilizado[$x]="Não";
		}		
		$registro=$list["REGISTRO"];					
		$x++;
		$contador=$x;
	}
	if(mysqli_num_rows($cnx)==0){
		echo "<script>alert('Nenhum cupom foi cadastrado!'); window.history.back(); </script>";	
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Lista de Cupons</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">   
</head>
<body>	
<hr/>
	<section class="section" id="topo">
	<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th>Matr.</th>
		<th>Funcionário</th>		
		<th>Cupom</th>		
		<th>Utilizado?</th>			
		<th>Liberado em</th>
	</tr>
	<?php
 	for( $i = 0; $i < sizeof($vtNome); $i++ ) : ?>
	<?php $z=$i; $registro=1; while($vtNome[$z]==$vtNome[$z+1]){
		$registro++;
		$repeat=$registro;
		$z++;
	}
	if($repeat>0){ $repeat--;}	
	?>
	<tr>
		<td><?php echo $i+1;?></td>		
		<td><?php echo $vtMatricula[$i]?></td>
		<td><?php echo $vtNome[$i]?></td>
		<td><?php echo $vtCodigo[$i]?></td>			
		<td><?php echo $vtUtilizado[$i]?></td>
		<td><?php echo $registro?></td>
	</tr>
<?php endfor;?>
	</table>	
	<a href="#topo">		
		<div class=".scrollWrapper">
			<button class="button is-primary" style="width: 100%; display: table;">Ir Ao Topo</button>		
		</div>
	</a>
	<br/>
	<div class="table__wrapper">			
		<div class="field-body">
			<div class="field">
				<div class="control">
					<a href="register.php"><input name="Limpar" type="submit" class="button is-primary" value="Voltar"/></a>
				</div>					
			</div>						
		</div>
	</div>
</section>	
</body>
</html><?php }//ELSE - caso o usuário não tenha permissão.