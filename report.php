<?php

$menuAtivo = 'relatorios';
require('menu.php');

$periodo = trim($_REQUEST['periodo']);
$atividade = trim($_REQUEST['atividade']);
$ordenacao = trim($_REQUEST['ordenacao']);
$meta = trim($_REQUEST['meta']);
$contador = 0;
$totalAlcancado = 0;

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão') window.locantion.href='report-private.php'; </script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Relatório Gestão</title>
	<script type="text/javascript">
		$(window).on("load", onPageLoad);
			function onPageLoad() {
				initListeners();
				restoreSavedValues();
			}
			function initListeners() {
				$("#saveDate").on("change", function() {
					var value = $(this).val();
					localStorage.setItem("saveDate", value);
				}); 
			}
			function restoreSavedValues() {
				var storedValue = localStorage.getItem("saveDate");
				$("#saveDate").val(storedValue);
			}		
			$('#submitQuery').button().click(function(){
				$('#form1').submit();
		});
	</script>
</head>
<body>
	<span id="topo"></span>
	<section class="section">
	<form id="form1" action="report.php" method="POST" >
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label is-size-7-touch" for="periodo">Período:</label>
			</div>
			<div class="field-body">
			<div class="field is-grouped">							
				<div class="control">
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
					</div>
				</div>
			</div>
			</div>
			<div class="field-label is-normal"><!--SELEÇÃO ATIVIDADE-->
				<label class="label is-size-7-touch">Atividade:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select is-size-7-touch">
							<select name="atividade" style="width: 10em">
								<option selected="selected" value="agrupado">Agrupado</option>	
								<option value="separado">Separado</option>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<div class="field-label is-normal"><!--SELEÇÃO ORDENAÇÃO-->
				<label for="ordenacao" class="label is-size-7-touch">Ordenação:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select is-size-7-touch">
							<select name="ordenacao" style="width: 10em">
								<option value="NOME">Nome</option>	
								<option value="DESEMPENHO DESC, NOME">Desempenho</option>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</div>
		<div class="field is-horizontal">
			<div class="field-label is-normal"><!--SELEÇÃO SETOR-->
				<label for="ordenacao" class="label is-size-7-touch">Setor:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select is-size-7-touch">
							<select name="setor">
							<option selected="selected" value="">Todos</option><?php																
								$con = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM SETOR WHERE SITUACAO = 'Ativo'");
								while($setor = $con->fetch_array()){
									echo "<option value='AND SETOR_ID=" . $setor["ID"] . "'>" . $setor["NOME"] . "</option>";
								}?>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>	
			<div class="field-label is-normal"><!--SELEÇÃO TURNO-->
				<label for="turno" class="label is-size-7-touch">Turno:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select is-size-7-touch">
							<select name="turno" id="salvaTurno" style="width: 10em">
							<option selected="selected"value="">Todos</option><?php																
								$con = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM TURNO WHERE SITUACAO='Ativo'");
								while($turno = $con->fetch_array()){
									echo "<option value='AND TURNO_ID=" . $turno["ID"] ."'>" . $turno["NOME"] . "</option>";
								}?>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<div class="field-label is-normal"><!--SELEÇÃO META-->
				<label class="label is-size-7-touch" for="meta">Meta:</label>
			</div>
				<div class="field-body">
					<div class="field is-grouped">							
						<div class="control">
							<div class="select is-size-7-touch">
								<select name='meta' style="width: 10em">
									<option selected="selected"value="">Ambos</option>
									<option value="AND B.DESEMPENHO>=100">Atingida :D</option>
									<option value="AND B.DESEMPENHO<100">Perdida ;(</option>
								</select>	
							</div>
						</div>
					<div class="control">
						<!--<button type="submit" class="button is-primary">Filtrar</button>-->
						<input name="filtro" type="submit" class="button is-primary is-size-7-touch" id="submitQuery" value="Filtrar"/>
					</div>
				</div>						
			</div>
		</div>
	</form><!--FINAL DO FORMULÁRIO-->		
<?php

$turno = trim($_REQUEST['turno']);
$setor = trim($_REQUEST['setor']);

if ( $periodo != "") {

	$date = date_create($periodo);
	//date_add($date, date_interval_create_from_date_string('0 months'));
	$anoMes = date_format($date, 'Y-m');
	$date = date_format($date, 't/m');
	echo "<br>".$periodo;
	echo "<br>".$anoMes;
	echo "<br>".$date;

	if ($atividade == "agrupado") {
		$consulta = "SELECT U.NOME, D.USUARIO_ID AS ID, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FALTA, 
(SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FOLGA, TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO,  
CONCAT(DATE_FORMAT('".$periodo."-01','%d/%m'),' a ".$date."') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) DESEMPENHO FROM DESEMPENHO WHERE ANO_MES='".$periodo."' AND PRESENCA_ID NOT IN (3,5) GROUP BY USUARIO_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID WHERE D.USUARIO_ID=B.USUARIO_ID AND ANO_MES='".$periodo."'".$meta." ".$turno." ".$setor." GROUP BY D.USUARIO_ID ORDER BY ".$ordenacao.";";
	} else {
		$consulta = "SELECT U.NOME, D.USUARIO_ID AS ID, A.NOME AS ATIVIDADE, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FALTA, 
(SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FOLGA, TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO,  
CONCAT(DATE_FORMAT('".$periodo."-01','%d/%m'),' a ".$date."') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) DESEMPENHO,ATIVIDADE_ID FROM DESEMPENHO WHERE ANO_MES='".$periodo."' AND PRESENCA_ID NOT IN (3,5) GROUP BY USUARIO_ID, ATIVIDADE_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID INNER JOIN ATIVIDADE A ON A.ID=B.ATIVIDADE_ID WHERE D.USUARIO_ID=B.USUARIO_ID AND ANO_MES='".$periodo."'".$meta." " .$turno." AND D.ATIVIDADE_ID=B.ATIVIDADE_ID ".$setor." GROUP BY D.USUARIO_ID, D.ATIVIDADE_ID ORDER BY ".$ordenacao.";";
	}
	
	$cx = mysqli_query($phpmyadmin, "SELECT OPERADOR, EMPRESA, (SELECT DESEMPENHO FROM META_EMPRESA WHERE ANO_MES='" . $anoMes . "') AS ALCANCADO FROM META_PESO");
	$peso = $cx->fetch_array();
	$con = mysqli_query($phpmyadmin, $consulta);
	
	if (mysqli_num_rows($con) != 0) {
		$x = 0;
		$maior = 0;
		$menor = 1000;
		$totalFaltas = 0;
		$totalFolgas = 0;

		while ($dado = $con->fetch_array()) {
			$vtIdUsuario[$x] = $dado["ID"];				
			$vtNome[$x] = $dado["NOME"];
			$vtDesempenho[$x] = $dado["DESEMPENHO"];
			$vtAtividade[$x] = $dado["ATIVIDADE"];
			$vtFalta[$x] = $dado["FALTA"];
			$vtFolga[$x] = $dado["FOLGA"];
			$totalAlcancado = $totalAlcancado + $dado["DESEMPENHO"];
			$vtRegistro[$x] = $dado["REGISTRO"];
			$totalFaltas = $totalFaltas + $vtFalta[$x];
			$totalFolgas = $totalFolgas + $vtFolga[$x];	
			
			if ($maior < $vtDesempenho[$x]) {
				$maior = $vtDesempenho[$x];
			}
			
			if ($menor > $vtDesempenho[$x] && $vtDesempenho[$x] != 0) {
				$menor = $vtDesempenho[$x];
			}			
			
			$contador++;
			$x++;		
		}

		$g1 = "SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND ANO_MES= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 3 MONTH),'%Y-%m')),2)MENOR FROM DESEMPENHO 
		WHERE ANO_MES = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 3 MONTH),'%Y-%m') AND PRESENCA_ID NOT IN(3,5)
		UNION ALL
		SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND ANO_MES= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH),'%Y-%m')),2)MENOR FROM DESEMPENHO 
		WHERE ANO_MES = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH),'%Y-%m') AND PRESENCA_ID NOT IN(3,5)
		UNION ALL
		SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND ANO_MES= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH),'%Y-%m')),2)MENOR FROM DESEMPENHO 
		WHERE ANO_MES = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH),'%Y-%m') AND PRESENCA_ID NOT IN(3,5)
		UNION ALL
		SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND ANO_MES= DATE_FORMAT(CURDATE(),'%Y-%m')),2)MENOR FROM DESEMPENHO 
		WHERE ANO_MES = DATE_FORMAT(CURDATE(), '%Y-%m') AND PRESENCA_ID NOT IN(3,5);";

		/*DASHABOARD TOP 5 RANKGING MENSAL OPERADORES*/
		$g4 = "SELECT U.NOME, AVG(DESEMPENHO) MEDIA FROM DESEMPENHO 
		INNER JOIN USUARIO U ON U.ID=USUARIO_ID	WHERE PRESENCA_ID<>3 AND ANO_MES='".$periodo."'	GROUP BY USUARIO_ID ORDER BY MEDIA DESC LIMIT 6;";

		$x = 0;
		$cnxG4 = mysqli_query($phpmyadmin, $g4);
		while ($G4 = $cnxG4->fetch_array()) {
			$vtG4nome[$x] = $G4["NOME"];
			$vtG4media[$x] = $G4["MEDIA"];
			$x++;				
		}
			
		$xg = 0;
		$cnx2 = mysqli_query($phpmyadmin, $g1);
		while ($graf1 = $cnx2->fetch_array()) {
			$vtMedia[$xg] = $graf1["MEDIA"];
			$vtMenor[$xg] = $graf1["MENOR"];
			$xg++;
		}
	}	
} 
if ($contador != 0): ?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<div class="field is-horizontal" id="graficos">		
		<div class="column is-mobile" id="dash-desempenho"></div>
		<div class="column is-mobile" id="dash-variacao"></div>
		<div class="column is-mobile" id="dash-top5"></div>
	</div>	
	<hr/>
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">
		<tr class='is-selected'><?php
			echo "<td>Resultado: " . sizeof($vtNome) . "</td>	
			<td>Falta's: " . $totalFaltas . "</td>
			<td>Folga's: " . $totalFolgas . "</td>
			<td>Menor: " . $menor."%" . "</td>
			<td>Media: " . round($totalAlcancado / $contador, 2)."%" . "</td>
			<td>Maior: " . $maior."%" . "</td>
			<td>Empresa: " . $peso["ALCANCADO"]."%" . "</td>";	?>		
		</tr>
	</table>
	<table class="table__wrapper table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch scrollWrapper"style="$table-row-active-background-color:hsl(171, 100%, 41%);">	
	<tr>
		<th width="1">N°</th>
		<th width="200">Funcionário</th>
		<th>Detalhes</th>		
		<th width="4">Falta's</th>
		<th width="4">Folga's</th>
		<th width="4">Pena</th>
		<?php if ($atividade == "separado") { echo "<th width='14'>Atividade</th>"; } ?>
		<th width="14">Desempenho</th>
		<th width="4">Final</th>				
		<th width="40">Período</th>			
	</tr><?php
 	for ( $i = 0; $i < sizeof($vtNome); $i++ ): 
		$z=$i; $registro=1; 
		
		while ($vtNome[$z] == $vtNome[$z+1]) {
			$registro++;
			$repeat=$registro;
			$z++;
		}
		if ($repeat>0){ $repeat--;}	
		?>
		<tr>
			<td><?php echo $i+1;?></td>
			<td><?php echo $vtNome[$i]?></td>
			<?php if($registro>1 && $repeat!=0 && $mesclaa==false): ?><td width="1"; rowspan="<?php echo $registro?>"><a href="report-detailed.php?periodo=<?php echo $periodo ?>&idUsuario=<?php echo $vtIdUsuario[$i]?>" target="_blank"><button class="button is-primary is-size-7-touch">Consultar</button></a></td><?php $mesclaa=true;endif;?>
			<?php if($repeat==0 && $vtNome[$i-1]!=$vtNome[$i]): ?><td width="1";><a href="report-detailed.php?periodo=<?php echo $periodo ?>&idUsuario=<?php echo $vtIdUsuario[$i]?>&anoMes=<?php echo $anoMes ?>" target="_blank"><button class="button is-primary is-size-7-touch">Consultar</button></a></td><?php $mesclaa=false; endif;?>
			<?php if($registro>1 && $repeat!=0 && $mescla==false): ?><td width="4" rowspan="<?php echo $registro?>"><?php echo $vtFalta[$i]; $mescla=true;?></td><td rowspan="<?php echo $registro?>"><?php echo $vtFolga[$i]?></td><?php endif;?>	
			<?php if($repeat==0 && $vtNome[$i-1]!=$vtNome[$i]):?><td><?php echo $vtFalta[$i]; $mescla=false;?>
			<td width="4";><?php echo $vtFolga[$i]?></td><?php endif;?>
			<td></td>
			<?php if($atividade=="separado"):?><td><?php echo $vtAtividade[$i]?></td><?php endif;?>
			<td><?php echo $vtDesempenho[$i]."%"?></td>
			<td><?php echo round((($vtDesempenho[$i] / 100) * $peso["OPERADOR"]) + (($peso["ALCANCADO"] / 100) * $peso["EMPRESA"]), 2)."%"  ?></td>				
			<td style="max-width:800px;"><?php echo $vtRegistro[$i]?></td>
			<?php if($vtNome[$i]!=$vtNome[$i+1] && $repeat==0 && $mescla==true){ $mescla=false; $mesclaf=false; $mesclaa=false;}?>				
		</tr><?php
 	endfor; 
	?></table>
	<a href="#topo">
		<div class="field is-grouped is-grouped-centered">
			<button class="button is-primary is-fullwidth is-size-7-touch">Ir Ao Topo</button>		
		</div>
	</a>
	</section>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      var t='<?php echo $teste; ?>';
      var p=parseFloat('<?php echo $fava?>');
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'avg', 'min'],
          ['<?php echo strftime('%h', strtotime("-2 months"))?>',  parseFloat('<?php echo $vtMedia[0]?>'), parseFloat('<?php echo $vtMenor[0]?>')],
          ['<?php echo strftime('%h', strtotime("-1 months"))?>',  parseFloat('<?php echo $vtMedia[1]?>'), parseFloat('<?php echo $vtMenor[1]?>')],
          ['<?php echo strftime('%h')?>',  parseFloat('<?php echo $vtMedia[2]?>'), parseFloat('<?php echo $vtMenor[2]?>')],
          ['<?php echo strftime('%h', strtotime("+1 months"))?>',  parseFloat('<?php echo $vtMedia[3]?>'), parseFloat('<?php echo $vtMenor[3]?>')]
        ]);
        var options = {
          title: 'Desempenho da Empresa',
          hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };
        var chart = new google.visualization.AreaChart(document.getElementById('dash-desempenho'));
        chart.draw(data, options);
      }
</script>
<script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'line']});
	google.charts.setOnLoadCallback(drawBasic);
	function drawBasic() {
      	var data = new google.visualization.DataTable();''
     	var o;     
      	data.addColumn('number', 'X');
      	data.addColumn('number', 'Desempenho');
  		data.addRows([
	        [0, parseFloat('<?php echo $vtDesempenho[0]?>')],   [1, parseFloat('<?php echo $vtDesempenho[1]?>')],  [2, parseFloat('<?php echo $vtDesempenho[2]?>')],
	        [3, parseFloat('<?php echo $vtDesempenho[3]?>')],  [4, parseFloat('<?php echo $vtDesempenho[4]?>')],  [5, parseFloat('<?php echo $vtDesempenho[5]?>')],
	        [6, parseFloat('<?php echo $vtDesempenho[6]?>')],  [7, parseFloat('<?php echo $vtDesempenho[7]?>')],  [8, parseFloat('<?php echo $vtDesempenho[8]?>')],
	        [9, parseFloat('<?php echo $vtDesempenho[9]?>')],  [10, parseFloat('<?php echo $vtDesempenho[10]?>')], [11, parseFloat('<?php echo $vtDesempenho[11]?>')],
	        [12, parseFloat('<?php echo $vtDesempenho[12]?>')], [13, parseFloat('<?php echo $vtDesempenho[13]?>')], [14, parseFloat('<?php echo $vtDesempenho[14]?>')], 
	        [15, parseFloat('<?php echo $vtDesempenho[15]?>')], [16, parseFloat('<?php echo $vtDesempenho[16]?>')], [17, parseFloat('<?php echo $vtDesempenho[17]?>')],
	        [18, parseFloat('<?php echo $vtDesempenho[18]?>')], [19, parseFloat('<?php echo $vtDesempenho[19]?>')], [20, parseFloat('<?php echo $vtDesempenho[19]?>')], 
	        [21, parseFloat('<?php echo $vtDesempenho[21]?>')], [22, parseFloat('<?php echo $vtDesempenho[22]?>')], [23, parseFloat('<?php echo $vtDesempenho[23]?>')],
	        [24, parseFloat('<?php echo $vtDesempenho[24]?>')], [25, parseFloat('<?php echo $vtDesempenho[25]?>')], [26, parseFloat('<?php echo $vtDesempenho[26]?>')], 
	        [27, parseFloat('<?php echo $vtDesempenho[27]?>')], [28, parseFloat('<?php echo $vtDesempenho[28]?>')], [29, parseFloat('<?php echo $vtDesempenho[29]?>')],
	        [30, parseFloat('<?php echo $vtDesempenho[30]?>')], [31, parseFloat('<?php echo $vtDesempenho[31]?>')], [32, parseFloat('<?php echo $vtDesempenho[32]?>')], 
	        [33, parseFloat('<?php echo $vtDesempenho[33]?>')], [34, parseFloat('<?php echo $vtDesempenho[34]?>')], [35, parseFloat('<?php echo $vtDesempenho[35]?>')],
	        [36, parseFloat('<?php echo $vtDesempenho[36]?>')], [37, parseFloat('<?php echo $vtDesempenho[37]?>')], [38, parseFloat('<?php echo $vtDesempenho[38]?>')], 
	        [39, parseFloat('<?php echo $vtDesempenho[39]?>')], [40, parseFloat('<?php echo $vtDesempenho[40]?>')], [41, parseFloat('<?php echo $vtDesempenho[41]?>')],
	        [42, parseFloat('<?php echo $vtDesempenho[42]?>')], [43, parseFloat('<?php echo $vtDesempenho[43]?>')], [44, parseFloat('<?php echo $vtDesempenho[44]?>')], 
	        [45, parseFloat('<?php echo $vtDesempenho[45]?>')], [46, parseFloat('<?php echo $vtDesempenho[46]?>')], [47, parseFloat('<?php echo $vtDesempenho[47]?>')],
	        [48, parseFloat('<?php echo $vtDesempenho[48]?>')], [49, parseFloat('<?php echo $vtDesempenho[49]?>')], [50, parseFloat('<?php echo $vtDesempenho[50]?>')], 
	        [51, parseFloat('<?php echo $vtDesempenho[51]?>')], [52, parseFloat('<?php echo $vtDesempenho[52]?>')], [53, parseFloat('<?php echo $vtDesempenho[53]?>')],
	        [54, parseFloat('<?php echo $vtDesempenho[54]?>')], [55, parseFloat('<?php echo $vtDesempenho[55]?>')], [56, parseFloat('<?php echo $vtDesempenho[56]?>')], 
	        [57, parseFloat('<?php echo $vtDesempenho[57]?>')], [58, parseFloat('<?php echo $vtDesempenho[58]?>')], [59, parseFloat('<?php echo $vtDesempenho[59]?>')],
	        [60, parseFloat('<?php echo $vtDesempenho[60]?>')], [61, parseFloat('<?php echo $vtDesempenho[61]?>')], [62, parseFloat('<?php echo $vtDesempenho[62]?>')], 
	        [63, parseFloat('<?php echo $vtDesempenho[63]?>')], [64, parseFloat('<?php echo $vtDesempenho[64]?>')], [65, parseFloat('<?php echo $vtDesempenho[65]?>')],
	        [66, parseFloat('<?php echo $vtDesempenho[66]?>')], [67, parseFloat('<?php echo $vtDesempenho[67]?>')], [68, parseFloat('<?php echo $vtDesempenho[68]?>')], 
	        [69, parseFloat('<?php echo $vtDesempenho[69]?>')], [70, parseFloat('<?php echo $vtDesempenho[70]?>')], [71, parseFloat('<?php echo $vtDesempenho[71]?>')],
	        [72, parseFloat('<?php echo $vtDesempenho[72]?>')], [73, parseFloat('<?php echo $vtDesempenho[73]?>')], [74, parseFloat('<?php echo $vtDesempenho[74]?>')],
	        [75, parseFloat('<?php echo $vtDesempenho[75]?>')], [76, parseFloat('<?php echo $vtDesempenho[76]?>')], [77, parseFloat('<?php echo $vtDesempenho[77]?>')], 
	        [78, parseFloat('<?php echo $vtDesempenho[78]?>')], [79, parseFloat('<?php echo $vtDesempenho[79]?>')], [80, parseFloat('<?php echo $vtDesempenho[80]?>')],
	        [81, parseFloat('<?php echo $vtDesempenho[81]?>')], [82, parseFloat('<?php echo $vtDesempenho[82]?>')], [83, parseFloat('<?php echo $vtDesempenho[83]?>')], 
	        [84, parseFloat('<?php echo $vtDesempenho[84]?>')], [85, parseFloat('<?php echo $vtDesempenho[85]?>')], [86, parseFloat('<?php echo $vtDesempenho[86]?>')],
	        [87, parseFloat('<?php echo $vtDesempenho[87]?>')], [88, parseFloat('<?php echo $vtDesempenho[88]?>')], [89, parseFloat('<?php echo $vtDesempenho[89]?>')], 
	        [90, parseFloat('<?php echo $vtDesempenho[90]?>')], [91, parseFloat('<?php echo $vtDesempenho[91]?>')], [92, parseFloat('<?php echo $vtDesempenho[92]?>')]    
	    ]);
      	var options = {
        	hAxis: {
          		title: 'Operadores'
        	},
        	vAxis: {
          		title: 'Variação do desempenho'
        	}
      	};
      	var chart = new google.visualization.LineChart(document.getElementById('dash-variacao'));
      	chart.draw(data, options);
    }
</script>	
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ['<?php echo $vtG4nome[0]?>', parseFloat('<?php echo $vtG4media[0]?>'), "gold"],
        ['<?php echo $vtG4nome[1]?>', parseFloat('<?php echo $vtG4media[1]?>'), "silver"],
        ['<?php echo $vtG4nome[3]?>', parseFloat('<?php echo $vtG4media[3]?>'), "#b87333"],
        ['<?php echo $vtG4nome[4]?>', parseFloat('<?php echo $vtG4media[4]?>'), "#b87333"],
        ['<?php echo $vtG4nome[5]?>', parseFloat('<?php echo $vtG4media[5]?>'), "color: #e5e4e2"]
      ]);
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
      var options = {
        title: "Top 5 melhores do mês",
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("dash-top5"));
      chart.draw(view, options);
  }
  </script>
<?php endif;
	if ($contador == 0 && isset($_GET["filtro"]) != null) {
		echo "<script>alert('Nenhum resultado encontrao com o filtro aplicado!')</script>";		
	}
  ?>
</body>
</html>