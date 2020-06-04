<?php

$menuAtivo="relatorios";
require('menu.php');

$periodo = trim($_REQUEST['periodo']);
$idUsuario = trim($_REQUEST['idUsuario']);
$contador = 0;
$totalAlcancado = 0;

if ( $_SESSION["permissao"] == 1 ){
	echo "<script>alert('Usuário sem permissão para este acesso!!'); window.location.href='home.php'; </script>";
} else if($periodo != ''){
	$con = mysqli_query($phpmyadmin , "SELECT U.NOME AS NOME, A.NOME AS ATIVIDADE, P.NOME AS PRESENCA, D.META AS META, D.ALCANCADO AS ALCANCADO, D.DESEMPENHO AS DESEMPENHO, D.REGISTRO AS REGISTRO, D.OBSERVACAO, D.PRESENCA_ID FROM DESEMPENHO D INNER JOIN USUARIO U ON U.ID = D.USUARIO_ID
	INNER JOIN ATIVIDADE A ON A.ID =D.ATIVIDADE_ID 	INNER JOIN PRESENCA P ON P.ID = D.PRESENCA_ID WHERE D.USUARIO_ID=".$idUsuario." AND D.ANO_MES='".$periodo."' ORDER BY REGISTRO;");	
	
	$x = 0; $menor = 1000; $maior = 0; $falta = 0; $folga = 0; $atestado = 0; $treinamento = 0;

	while ($dado = $con->fetch_array()) {
		$vetorNome[$x] = $dado["NOME"];	
		$vetorAtividade[$x] = $dado["ATIVIDADE"];
		$vetorIdPresenca[$x] = $dado["PRESENCA_ID"];
		$vetorPresenca[$x] = $dado["PRESENCA"];
		$vetorDesempenho[$x] = $dado["ALCANCADO"];
		$vetorMeta[$x] = $dado["META"];
		$vetorAlcancado[$x] = $dado["DESEMPENHO"];
		$totalAlcancado=$totalAlcancado+$dado["DESEMPENHO"];
		$vetorRegistro[$x] = $dado["REGISTRO"];
		$vetorObservacao[$x] = $dado["OBSERVACAO"];

		if ($vetorIdPresenca[$x] == 2) {
			$falta++;
		} else if ($vetorIdPresenca[$x] == 3) {
			$folga++;
		} else if ($vetorIdPresenca[$x] == 4) {
			$atestado++;
		} else if ($vetorIdPresenca[$x] == 5) {
			$treinamento++;
		}						
		
		if ($maior < $vetorAlcancado[$x]) {
			$maior = $vetorAlcancado[$x];
		}

		if ($menor > $vetorAlcancado[$x] && $vetorAlcancado[$x] > 0) {
			$menor = $vetorAlcancado[$x];
		}

		$contador++;
		$x++;
	}

	if ($contador == 0) {
		echo "<script>alert('Nenhum resultado encontrado!'); </script>";
		exit;
	}
} 

?><!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Relatório Detalhado</title>
</head>
<body>
<hr/>
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		<tr>
			<td>Colaborador: <?php echo $vetorNome[0];?></td>
			<td>Atestado's: <?php echo $atestado;?></td>
			<td>Falta's: <?php echo $falta;?></td>
			<td>Folga's: <?php echo $folga;?></td>
			<td>Menor: <?php if($totalAlcancado>0){echo $menor."%";}else{echo"0%";}?></td>
			<td>Media: <?php if($totalAlcancado>0){echo round($totalAlcancado/($contador-$folga-$treinamento), 2)."%";}else{echo"0%";} ?></td>
			<td>Maior: <?php echo $maior."%"?></td>
		</tr>
	</table>	
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">	
	<tr>
		<th>Data</th>
		<th>Atividade</th>
		<?php if ($folga > 0 || $falta>0 || $atestado > 0) { echo "<th>Presença</th>"; } ?>
		<th>Meta</th>
		<th>Alcançado</th>
		<th>Desempenho</th>
		<th>Media</th>
		<th>Observação</th>
	</tr><?php
	
	for ( $i = 0; $i < sizeof($vetorAtividade); $i++ ) {
		echo "<tr>"; $registros = 1; $t = $i; 
		$somaAlcancado = null; $z = $i; $laco = false;
			
		while ($vetorRegistro[$z] == $vetorRegistro[$z+1]) {
			$registros++; 
			$repeat = $registros;

			if ($laco == false) { 
				$somaAlcancado = $somaAlcancado + $vetorAlcancado[$z] + $vetorAlcancado[$z + 1];
			} else {
				$somaAlcancado = $somaAlcancado + $vetorAlcancado[$z + 1];}
				$laco = true; 
				$z = $z + 1;
			}

			if ($repeat > 0){ 
				$repeat--;
			}

			$somaAlcancado = ($somaAlcancado / $registros);
			
			if ($registros > 1 && $repeat != 0 && $mescla == false) { 
				echo "<td rowspan=" . $registros . ">" . $vetorRegistro[$i] . "</td>";	
				$mescla = true;
			}  

			if( $repeat == 0 && $vetorRegistro[$i - 1] != $vetorRegistro[$i]) {
				echo "<td>" . $vetorRegistro[$i] . "</td>";
				$mescla = false;
			}

			echo "<td>" . $vetorAtividade[$i] . "</td>";

			if ($folga > 0 || $falta > 0 || $atestado > 0) {
				echo "<td>" . $vetorPresenca[$i] . "</td>";
			}
			
			echo "<td>" . $vetorMeta[$i] . "</td>";
			echo "<td>" . $vetorDesempenho[$i] . "</td>";
			echo "<td>" . $vetorAlcancado[$i] . "%" . "</td>";

			if ($registros > 1 && $repeat != 0 && $mesclaM == false) {
				echo "<td rowspan=" . $registros . ">" . round($somaAlcancado,2) . "%" . "</td>";
				$mesclaM = true;
			}

			if ($repeat == 0 && $vetorRegistro[$i-1] != $vetorRegistro[$i]) {
				echo "<td></td>"; 
				$mesclaM = false;
			}
				
			if ($vetorRegistro[$i] != $vetorRegistro[$i + 1] && $repeat == 0){
				$mescla = false; 
				$mesclaM = false;
			}
			
			echo "<td>" . $vetorObservacao[$i] . "</td>";	
		echo "</tr>";
	}

	echo "</table>";	

?></body>
</html>