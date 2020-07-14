<?php

$menuAtivo = "relatorios";
require('menu.php');

$periodo = trim($_REQUEST['periodo']);
$idUsuario = trim($_REQUEST['idUsuario']);
$contador = 0;
$totalAlcancado = 0;

if ( $_SESSION["permissao"] == 1 ) {
	echo "<script>alert('Usuário sem permissão para este acesso!!'); window.location.href='home.php'; </script>";
} else if ($periodo != '') {
	$con = mysqli_query($phpmyadmin , "SELECT U.NOME AS NOME, A.NOME AS ATIVIDADE, P.NOME AS PRESENCA, D.META AS META, D.ALCANCADO AS ALCANCADO, D.DESEMPENHO AS DESEMPENHO, D.REGISTRO AS REGISTRO, D.OBSERVACAO, D.PRESENCA_ID, (SELECT IFNULL(SUM(OCORRENCIA),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS OCORRENCIA, (SELECT IFNULL(SUM(PENALIDADE_TOTAL),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS TOTAL FROM DESEMPENHO D INNER JOIN USUARIO U ON U.ID = D.USUARIO_ID
	INNER JOIN ATIVIDADE A ON A.ID =D.ATIVIDADE_ID 	INNER JOIN PRESENCA P ON P.ID = D.PRESENCA_ID WHERE D.USUARIO_ID=".$idUsuario." AND D.ANO_MES='".$periodo."' ORDER BY REGISTRO;");	
	
	$x = 0; $menor = 1000; $maior = 0; $falta = 0; $folga = 0; $atestado = 0; $treinamento = 0;

	while ($dado = $con->fetch_array()) {
		$vetorNome[$x] = $dado['NOME'];	
		$vetorAtividade[$x] = $dado['ATIVIDADE'];
		$vetorIdPresenca[$x] = $dado['PRESENCA_ID'];
		$vetorPresenca[$x] = $dado['PRESENCA'];
		$vetorDesempenho[$x] = $dado['ALCANCADO'];
		$vetorMeta[$x] = $dado['META'];
		$vetorAlcancado[$x] = $dado['DESEMPENHO'];
		$totalAlcancado = $totalAlcancado + $dado['DESEMPENHO'];
		$vetorRegistro[$x] = $dado['REGISTRO'];
		$vetorObservacao[$x] = $dado['OBSERVACAO'];
		$ocurrence = $dado['OCORRENCIA'];
		$penaltyTotal = $dado['TOTAL'];

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

	if ($totalAlcancado > 0){
		$media = round($totalAlcancado/($contador-$folga-$treinamento), 2)."%";
		$menor = $menor."%";

	} else {
		$media = "0%";
		$menor = "0%";
	}
	$cx = mysqli_query($phpmyadmin, "SELECT OPERADOR, EMPRESA, (SELECT ROUND(DESEMPENHO, 2) FROM META_EMPRESA WHERE ANO_MES='" . $periodo . "') AS ALCANCADO FROM META_PESO WHERE ANO_MES='" . $periodo . "'");
	$peso = $cx->fetch_array();
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
		<tr><?php
			echo "
				<td>Colaborador: " . $vetorNome[0] . "</td>
				<td>Atestado's: " . $atestado . "</td>
				<td>Falta's: " . $falta . "</td>
				<td>Folga's: " . $folga . "</td>
				<td>Pena: " . $ocurrence . "</td>
				<td>Menor: " . $menor . "</td>
				<td>Maior: " . $maior . "%" . "</td>
				<td>Media: " .  $media . "</td>
				<td>Empresa: " . $peso["ALCANCADO"]."%" . "</td>
				<td>Final: " . round((($media / 100) * $peso["OPERADOR"]) + (($peso["ALCANCADO"] / 100) * $peso["EMPRESA"])-$penaltyTotal, 2) . "%" . "</td>";
		?></tr>
	</table>	
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">	
	<tr>
		<th>Data</th>
		<th>Atividade</th>
		<?php if ($folga > 0 || $falta>0 || $atestado > 0 || $treinamento > 0) { echo "<th>Presença</th>"; } ?>
		<th>Meta</th>
		<th>Alcançado</th>
		<th>Desempenho</th>
		<th>Media</th>
		<th>Observação</th>
	</tr><?php
	
	for ( $i = 0; $i < sizeof($vetorAtividade); $i++ ) {
		echo "<tr>"; 
		$registros = 1; $t = $i; 
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

			if ($folga > 0 || $falta > 0 || $atestado > 0 || $treinamento > 0) {
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

	echo "</tablte>";	

?></body>
</html>