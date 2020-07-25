<style type="text/css"></style>  
<?php
$menuAtivo = 'configuracoes';
require('menu.php');

if ($_SESSION['permissao'] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php';</script>";
}

$contador = 0;
$x = 0;

$query = "SELECT U.MATRICULA, U.NOME, C.NOME AS CARGO,T.NOME AS TURNO, UG.NOME AS GESTOR, U.EFETIVACAO, P.NOME AS PERMISSAO, U.SITUACAO FROM USUARIO U INNER JOIN TURNO T ON T.ID=U.TURNO_ID INNER JOIN USUARIO UG ON UG.ID=U.GESTOR_ID INNER JOIN CARGO C ON C.ID=U.CARGO_ID INNER JOIN PERMISSAO P ON P.ID=U.PERMISSAO_ID WHERE U.SITUACAO<>'Desligado' ORDER BY U.SITUACAO, U.TURNO_ID, U.NOME";

$cnx = mysqli_query($phpmyadmin, $query);
while ($user = $cnx->fetch_array()){
	$name[$x] = $user['NOME'];
	$registration[$x] = $user['MATRICULA'];
	$role[$x] = $user['CARGO'];
	$shift[$x] = $user['TURNO'];
	$leader[$x] = $user['GESTOR'];
	$effectuation[$x] = $user['EFETIVACAO'];
	$permission[$x] = $user['PERMISSAO'];
	$situation[$x] = $user['SITUACAO'];					
	$x++;
	$contador = $x;
}

if (mysqli_num_rows($cnx) == 0) {
	echo "<script>alert('Nenhum registrado encontrado nesta consulta!'); window.location.href=window.location.href; </script>";		
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Lista de Usuários</title>
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
		<th>Matr.</th>
		<th>Cargo</th>		
		<th class="coluna">Turno</th>
		<th >Gestor</th>
		<th >Efetivação</th>			
		<th>Permissão</th>
		<th>Situação</th> 			
	</tr>
	<?php
 	
 	for ( $i = 0; $i < sizeof($name); $i++ ){
	 	$z = $i; 
	 	$registro = 1; 

	 	while ($name[$z] == $name[$z + 1]) {
			$registro++;
			$repeat = $registro;
			$z++;
		}
		
		if ($repeat > 0) { 
			$repeat--;
		}	
		
		echo "
		<tr>
			<td>" . $i . "</td>
			<td>" . $name[$i] . "</td>
			<td>" . $registration[$i] . "</td>
			<td>" . $role[$i] . "</td>
			<td>" . $shift[$i] . "</td>
			<td>" . $leader[$i] . "</td>
			<td>" . $effectuation[$i] . "</td>			
			<td>" . $permission[$i] . "</td>
			<td>" . $situation[$i] . "</td>
		</tr>";
	}

 	?>
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
</html>