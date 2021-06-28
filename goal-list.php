<style type="text/css">
</style>
<?php
$menuAtivo="configuracoes";
include('menu.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else{
$contador = 0;
$query="SELECT U.NOME, A.NOME AS ATIVIDADE, M.DESCRICAO, M.EXECUCAO, M.DESEMPENHO FROM META M
INNER JOIN USUARIO U ON U.ID=M.USUARIO_ID
INNER JOIN ATIVIDADE A ON A.ID=M.ATIVIDADE_ID
INNER JOIN SETOR S ON S.ID=M.SETOR_ID";
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($meta= $cnx->fetch_array()){
		$vtNome[$x]=$meta["NOME"];
		$vtAtividade[$x]=$meta["ATIVIDADE"];
		$vtDescricao[$x]=$meta["DESCRICAO"];
		$vtExecucao[$x]=$meta["EXECUCAO"];
		$vtFeito[$x]=$meta["DESEMPENHO"];
		$x++;
		$contador=$x;
	}
	if(mysqli_num_rows($cnx)==0){
		?><script type="text/javascript">			
			alert('Nenhum registrado encontrado nesta consulta!');
			window.location.href=window.location.href;
		</script> <?php		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Lista Metas</title>
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
		<th>Funcionário</th>
		<th>Atividade</th>
		<th>Descrição</th>		
		<th>Execução</th>			
		<th>Desempenho</th>
	</tr>
	<?php
 	for( $i = 0; $i < sizeof($vtNome); $i++ ) : ?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td><?php echo $vtNome[$i]?></td>
		<td><?php echo $vtAtividade[$i]?></td>
		<td><?php echo $vtDescricao[$i]?></td>
		<td><?php echo $vtExecucao[$i]?></td>
		<td><?php echo $vtFeito[$i]?></td>			
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