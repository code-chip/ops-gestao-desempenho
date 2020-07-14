<?php

$menuAtivo = 'relatorios';
require('menu.php');
$contador = 0;
$totalDesempenho = 0;

?><!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Relatório Individual</title>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
<span id="topo"></span>
<section class="section">
<div class="container">
	<form id="form1" action="report-private.php" method="POST" >
		<div class="field is-horizontal">
			<div class="field-label is-normal"><!--SELEÇÃO PERÍODO-->
				<label class="label" for="periodo">Período:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control has-icons-left">
						<div class="select is-size-7-touch">
							<select name="periodo" id="saveDate" style="width: 10em">
								<option selected="selected" value="<?php echo date('Y-m')?>"><?php echo date('m/Y', strtotime("+1 months"))?></option>
								<option value="<?php echo date('Y-m', strtotime("-1 months"))?>"><?php echo date('m/Y')?></option>
								<option value="<?php echo date('Y-m', strtotime("-2 months"))?>"><?php echo date('m/Y', strtotime("-1 months"))?></option>
								<option value="<?php echo date('Y-m', strtotime("-3 months"))?>"><?php echo date('m/Y', strtotime("-2 months"))?></option>
								<option value="<?php echo date('Y-m', strtotime("-4 months"))?>"><?php echo date('m/Y', strtotime("-3 months"))?></option>
								<option value="<?php echo date('Y-m', strtotime("-5 months"))?>"><?php echo date('m/Y', strtotime("-4 months"))?></option>
								<option value="<?php echo date('Y-m', strtotime("-6 months"))?>"><?php echo date('m/Y', strtotime("-5 months"))?></option>
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-calendar-alt"></i>
							</span>	
						</div>
					</div>
				</div>
			</div>			
			<div class="field-label is-normal"><!--SELEÇÃO ATIVIDADE-->
				<label class="label">Atividade:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control has-icons-left">
						<div class="select">
							<select name="atividade">
								<option selected="selected" value="">Todas</option><?php	
								$con = mysqli_query($phpmyadmin , "SELECT ID, NOME FROM ATIVIDADE WHERE SITUACAO='Ativo'"); 
								while ($atividade = $con->fetch_array()) { 
									echo "<option value='AND A.ID=" . $atividade["ID"] . "'>" . $atividade["NOME"] . "</option>";
								} ?>								
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-diagnoses"></i>
							</span>
						</div>
					</div>					
				</div>						
			</div>	
			<!--SELEÇÃO META-->
			<div class="field-label is-normal">
				<label class="label" for="meta">Meta:</label>
			</div>
				<div class="field-body">
					<div class="field is-grouped">							
						<div class="control has-icons-left">
							<div class="select">
								<select name="meta">
									<option selected="selected"value="">Ambas</option>
									<option value="AND D.DESEMPENHO>99">Atingida</option>
									<option value="AND D.DESEMPENHO<100">Não atingida</option>
								</select>
								<span class="icon is-small is-left">
									<i class="fas fa-bullseye"></i>
								</span>	
							</div>
						</div>
					<div class="control">
						<!--<button type="submit" class="button is-primary">Filtrar</button>-->
						<input type="submit" class="button is-primary" id="submitQuery" value="Pesquisar"/>
					</div>
				</div>						
			</div>
		</div>
	</form><!--FINAL DO FORMULÁRIO-->		
</div><?php

$periodo = trim($_REQUEST['periodo']);
$atividade = trim($_REQUEST['atividade']);
$meta = trim($_REQUEST['meta']);

if ( $periodo != "") {
	
	$con = mysqli_query($phpmyadmin, "SELECT U.NOME AS NOME, A.NOME AS ATIVIDADE, P.NOME AS PRESENCA, D.META, D.ALCANCADO, D.DESEMPENHO, D.REGISTRO, D.OBSERVACAO, D.PRESENCA_ID, (SELECT IFNULL(SUM(OCORRENCIA),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS OCORRENCIA, (SELECT IFNULL(SUM(PENALIDADE_TOTAL),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS TOTAL FROM DESEMPENHO D INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID INNER JOIN PRESENCA P ON P.ID=D.PRESENCA_ID WHERE D.USUARIO_ID =" . $_SESSION["userId"] . " AND ANO_MES = '" . $periodo . "'" . $atividade . "" . $meta . " ORDER BY REGISTRO;");
	$x = 0; 
	$falta = 0; 
	$folga = 0; 
	$menor = 1000; 
	$maior = 0; 
	$atestado = 0; 
	$treinamento = 0;
	
	while ($dado = $con->fetch_array()) {
		$nome = $dado["NOME"];		
		$vetorAtividade[$x] = $dado["ATIVIDADE"];
		$vetorIdPresenca[$x] = $dado["PRESENCA_ID"];
		$vetorPresenca[$x] = $dado["PRESENCA"];
		$vetorMeta[$x] = $dado["META"];
		$vetorAlcancado[$x] = $dado["ALCANCADO"];
		$vetorDesempenho[$x] = $dado["DESEMPENHO"];
		$totalDesempenho=$totalDesempenho+$dado["DESEMPENHO"];
		$vetorRegistro[$x] = $dado["REGISTRO"];
		$vetorObservacao[$x] = $dado["OBSERVACAO"];
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

		if ($maior < $vetorDesempenho[$x]) {
			$maior = $vetorDesempenho[$x];
		}

		if ($menor > $vetorDesempenho[$x] && $vetorDesempenho[$x] > 0) {
			$menor = $vetorDesempenho[$x];
		}

		$contador++;
		$x++;		
	}

	if ($contador == 0) {
		echo "<script>alert('Nenhum resultado encontrado!'); </script>";
		exit;
	}

	$cx = mysqli_query($phpmyadmin, "SELECT OPERADOR, EMPRESA, (SELECT DESEMPENHO FROM META_EMPRESA WHERE ANO_MES='" . $periodo . "') AS ALCANCADO FROM META_PESO");
	$peso = $cx->fetch_array();
	$media = round($totalDesempenho / ($contador - $folga - $treinamento), 2);
} 

if ( $periodo != "" && $contador != 0) : ?>
<hr/>
	<div class="table__wrapper">
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch table__wrapper .scrollWrapper">
		<tr><?php echo
			"<td>Colaborador:  " . $nome . "</td>
			<td>Atestado's: " . $atestado . "</td>
			<td>Falta's: " . $falta . "</td>
			<td>Folga's: " . $folga . "</td>
			<td>Pena: " . $ocurrence . "</td>
			<td>Menor: " . $menor . "%" . "</td>
			<td>Maior: " . $maior . "%" . "</td>
			<td>Media: " .  $media . "</td>
			<td>Empresa: " . $peso["ALCANCADO"]."%" . "</td>
			<td>Final: " . round((($media / 100) * $peso["OPERADOR"]) + (($peso["ALCANCADO"] / 100) * $peso["EMPRESA"])-$penaltyTotal, 2) . "%" . "</td>";
		?></tr>
	</table>
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch table__wrapper .scrollWrapper">	
	<tr>
		<th style='width:55px;'>Atividade</th><?php
		if ($falta > 0 || $folga > 0 || $atestado > 0) { 
			echo "<th style='width:55px;'>Presença</th>";
		}		
		
		echo "<th style='width:30px;'>Meta</th>
		<th style='width:40px;'>Alacançado</th>
		<th style='width:45px;'>Desempenho</th>
		<th style='width:70px;'>Data</th>
		<th style='width:350px;'>Observação</th>
	</tr>";

	for ( $i = 0; $i < sizeof($vetorAtividade); $i++ ) {
		echo "<tr>
			<td>" . $vetorAtividade[$i] . "</td>";
			if ($falta > 0 || $folga > 0 || $atestado > 0) { 
				echo "<td>" . $vetorPresenca[$i] . "</td>";
			}
			echo "<td>" . $vetorMeta[$i] . "</td>
			<td>" . $vetorAlcancado[$i] . "</td>
			<td>" . $vetorDesempenho[$i]."%" . "</td>
			<td>" . $vetorRegistro[$i] . "</td>
			<td>" . $vetorObservacao[$i] . "</td>			
		</tr>";
	}

	?></table>
	<a href="#topo">
		<div class=".scrollWrapper">
			<button class="button is-primary is-fullwidth is-size-7-touch">Ir Ao Topo</button>		
		</div>
	</a>
	</div>	
<?php endif; ?>
</section>
</body>
</html>



