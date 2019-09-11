<style type="text/css">
</style>
<?php
session_start();
$menuConfiguracoes="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$contador = 0;
$query="SELECT U.MATRICULA, U.NOME, C.NOME AS CARGO,T.NOME AS TURNO, G.NOME AS GESTOR, U.EFETIVACAO, P.NOME AS PERMISSAO, U.SITUACAO, U.DESLIGADO_EM FROM USUARIO U
INNER JOIN TURNO T ON T.ID=U.TURNO_ID
INNER JOIN GESTOR G ON G.ID=U.GESTOR_ID
INNER JOIN CARGO C ON C.ID=U.CARGO_ID
INNER JOIN PERMISSAO P ON P.ID=U.PERMISSAO_ID WHERE U.SITUACAO='Desligado'
ORDER BY U.SITUACAO, U.NOME";
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($operadores= $cnx->fetch_array()){
		$vtNome[$x]=$operadores["NOME"];
		$vtMatricula[$x]=$operadores["MATRICULA"];
		$vtCargo[$x]=$operadores["CARGO"];
		$vtTurno[$x]=$operadores["TURNO"];
		$vtGestor[$x]=$operadores["GESTOR"];
		$vtEfetivacao[$x]=$operadores["EFETIVACAO"];
		$vtPermissao[$x]=$operadores["PERMISSAO"];
		$vtDesligado[$x]=$operadores["DESLIGADO_EM"];
		$vtSituacao[$x]=$operadores["SITUACAO"];					
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
		<th>Gestor</th>
		<th>Cargo</th>		
		<th class="coluna">Turno</th>
		<th >Gestor</th>
		<th >Efetivação</th>			
		<th>Permissão</th>
		<th>Desligado em</th> 
		<th>Situação</th> 			
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
		<td><?php echo $vtNome[$i]?></td>
		<td><?php echo $vtMatricula[$i]?></td>
		<td><?php echo $vtCargo[$i]?></td>
		<td><?php echo $vtTurno[$i]?></td>
		<td><?php echo $vtGestor[$i]?></td>
		<td><?php echo $vtEfetivacao[$i]?></td>			
		<td><?php echo $vtPermissao[$i]?></td>
		<td><?php echo $vtDesligado[$i]?></td>
		<td><?php echo $vtSituacao[$i]?></td>
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
</html>