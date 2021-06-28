<?php

$menuAtivo = 'configuracoes';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.locantion.href='register.php'; </script>";
}

$count = 0;
$x = 0;
$cnx = mysqli_query($phpmyadmin, "SELECT NOME, SITUACAO FROM CARGO;");

while ($r = $cnx->fetch_array()) {
	$role[$x] = $r["NOME"];		
	$rSituation[$x] = $r["SITUACAO"];
	$x++;
	$count = $x;
}

$x = 0;
$cnx = mysqli_query($phpmyadmin, "SELECT NOME, SITUACAO FROM SETOR;");

while ($s = $cnx->fetch_array()) {
	$sector[$x] = $s["NOME"];		
	$sSituation[$x] = $s["SITUACAO"];
	$x++;
}

$x = 0;
$cnx = mysqli_query($phpmyadmin, "SELECT NOME, SITUACAO FROM ATIVIDADE;");

while($a = $cnx->fetch_array()){
	$activity[$x] = $a["NOME"];		
	$aSituation[$x] = $a["SITUACAO"];
	$x++;
}

$x = 0;
$cnx = mysqli_query($phpmyadmin, "SELECT NOME, SITUACAO FROM PERMISSAO;");

while($p = $cnx->fetch_array()){
	$permession[$x] = $p["NOME"];		
	$pSituation[$x] = $p["SITUACAO"];
	$x++;
}

if (mysqli_num_rows($cnx) == 0 ) {
	echo "<script>alert('Nenhum registrado encontrado nesta consulta!'); window.location.href=window.location.href; </script>";		
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Lista de Opções</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">
    <link rel="stylesheet" type="text/css" href="/css/personal.css">     
</head>
<body>	
<hr/>
	<section class="section" id="topo">
	<div class="table__wrapper table">
	<table class="table__wrapper table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch scrollWrapper">	
	<tr>
		<th>Cargo</th>
		<th>Situação</th>
		<th>Atividade</th>
		<th>Situação</th>
		<th>Setor</th>
		<th>Situação</th>
		<th>Permissão</th>
		<th>Situação</th>		 			
	</tr>
	<?php

 	for( $i = 0; $i < sizeof($role); $i++ ) {
	 	echo "
	 	<tr>	
			<td>" . $role[$i] . "</td>
			<td>" . $rSituation[$i] . "</td>
			<td>" . $activity[$i] . "</td>
			<td>" . $aSituation[$i] . "</td>
			<td>" . $sector[$i] . "</td>
			<td>" . $sSituation[$i] . "</td>
			<td>" . $permession[$i] . "</td>
			<td>" . $pSituation[$i] . "</td>
		</tr>";	
	} 
	?>	
	</table>	
	<a href="#topo">	
		<button class="button is-primary" style="width: 100%; display: table;">Ir Ao Topo</button>		
	</a>
	<br/>				
	<div class="field-body">
		<div class="field">
			<div class="control">
				<a href="register.php" class="button is-primary btn128">Voltar</a>
			</div>					
		</div>						
	</div>	
</section>	
</body>
</html>