<style type="text/css">
	/*$table-cell-padding: .75rem !default; $table-sm-cell-padding: .3rem !default; $table-bg: transparent !default; $table-bg-accent: rgba(0,0,0,.05) !default; $table-bg-hover: rgba(0,0,0,.075) !default; $table-bg-active: $table-bg-hover !default; $table-border-width: $border-width !default; $table-border-color: $gray-lighter !default;*/
</style>
<?php
session_start();
$menuRelatorio="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$periodo = trim($_REQUEST['periodo']);
$atividade = trim($_REQUEST['atividade']);
$ordenacao = trim($_REQUEST['ordenacao']);
$meta = trim($_REQUEST['meta']);
$contador = 0;
$totalAlcancado=0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Relatórios</title>
</head>
<body>
	<span id="topo"></span>
	<?php
	/*CONSULTAS PARA CARREGAS AS OPÇÕES DE SELEÇÃO DO CADASTRO.*/
	$gdTurno="SELECT ID, NOME FROM TURNO WHERE SITUACAO='Ativo'";			
	?>
<div>
	<br/>
	<form id="form1" action="report.php" method="GET" >
		<div class="field is-horizontal">
			<div class="field-label is-normal"><!--SELEÇÃO PERÍODO-->
				<label class="label" for="periodo">Período:</label>
			</div>
			<div class="field-body">
			<div class="field is-grouped">							
				<div class="control">
					<div class="select">
						<select name="periodo">
							<option value="<?php echo date('Y-m', strtotime("+1 months"))?>"><?php echo date('m/Y', strtotime("+1 months"))?></option>
							<option selected="selected" value="<?php echo date('Y-m')?>"><?php echo date('m/Y')?></option>
							<option value="<?php echo date('Y-m', strtotime("-1 months"))?>"><?php echo date('m/Y', strtotime("-1 months"))?></option>
							<option value="<?php echo date('Y-m', strtotime("-2 months"))?>"><?php echo date('m/Y', strtotime("-2 months"))?></option>
							<option value="<?php echo date('Y-m', strtotime("-3 months"))?>"><?php echo date('m/Y', strtotime("-3 months"))?></option>
							<option value="<?php echo date('Y-m', strtotime("-4 months"))?>"><?php echo date('m/Y', strtotime("-4 months"))?></option>
							<option value="<?php echo date('Y-m', strtotime("-5 months"))?>"><?php echo date('m/Y', strtotime("-5 months"))?></option>
						</select>	
					</div>
				</div>
			</div>
			</div>
			<div class="field-label is-normal"><!--SELEÇÃO ATIVIDADE-->
				<label class="label">Atividade:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="atividade">
								<option selected="selected" value="agrupado">Agrupado</option>	
								<option value="separado">Separado</option>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<div class="field-label is-normal"><!--SELEÇÃO ORDENAÇÃO-->
				<label for="ordenacao" class="label">Ordenação:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="ordenacao">
								<option selected="selected" value="NOME">Nome</option>	
								<option value="DESEMPENHO DESC, NOME">Desempenho</option>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<div class="field-label is-normal"><!--SELEÇÃO TURNO-->
				<label for="turno" class="label">Turno:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="turno">								
								<?php $con = mysqli_query($phpmyadmin , $gdTurno);
								$x=0; 
								while($turno = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x]=$setor["ID"]; ?>"><?php echo $vtNome[$x] = utf8_encode($turno["NOME"]); ?></option>
								<?php $x;} endwhile;?>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>	
			<div class="field-label is-normal"><!--SELEÇÃO META-->
				<label class="label" for="meta">Meta:</label>
			</div>
				<div class="field-body">
					<div class="field is-grouped">							
						<div class="control">
							<div class="select">
								<select name='meta'>
									<option selected="selected"value="">Ambos</option>
									<option value="AND B.DESEMPENHO>=100">Atingida</option>
									<option value="AND B.DESEMPENHO<100">Não atingida ;/</option>
								</select>	
							</div>
						</div>
					<div class="control">
						<!--<button type="submit" class="button is-primary">Filtrar</button>-->
						<input type="submit" class="button is-primary" id="submitQuery" value="Filtrar"/>
					</div>
				</div>						
			</div>
		</div>
	</form>		
</div><!--FINAL DO FORMULÁRIO-->
<?php if($periodo!=""):?><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="graficos" style="position: relative; width: 100%; height: 250px; /*border: 3px solid #73AD21;*/">
<div id="chart_div" style="position: absolute; top:2%; left:0%; width: 25%; height: 250px; /*border: 3px solid #73AD26;*/"></div>
<div id="chart_div2" style="position: absolute; top:2%; left:25%; width: 30%; height: 250px;/*border: 3px solid #73AD29;*/"></div>
<div id="chart_div3" style="position: absolute; top:2%; left:55%; width: 30%; height: 250px;/*border: 3px solid #73AD29;*/"></div>
<?php endif;?>
</div>
<?php
if( $periodo != "" && $_SESSION["permissao"]!=1){
	if($atividade=="agrupado"){
	$consulta ="SELECT U.NOME, D.USUARIO_ID AS ID, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID) AS FALTA, 
(SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID) AS FOLGA, TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO,  
CONCAT(DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH),' a ".$periodo."-20') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) DESEMPENHO FROM DESEMPENHO WHERE REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20' AND PRESENCA_ID<>3 GROUP BY USUARIO_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID WHERE D.USUARIO_ID=B.USUARIO_ID AND REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20'".$meta." GROUP BY D.USUARIO_ID ORDER BY ".$ordenacao.";";
	}
	else{
	$consulta ="SELECT U.NOME, D.USUARIO_ID AS ID, A.NOME AS ATIVIDADE, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID) AS FALTA, 
(SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID) AS FOLGA, TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO,  
CONCAT(DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH),' a ".$periodo."-20') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) DESEMPENHO,ATIVIDADE_ID FROM DESEMPENHO WHERE REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20' AND PRESENCA_ID<>3 GROUP BY USUARIO_ID, ATIVIDADE_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID INNER JOIN ATIVIDADE A ON A.ID=B.ATIVIDADE_ID WHERE D.USUARIO_ID=B.USUARIO_ID AND REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20'".$meta." AND D.ATIVIDADE_ID=B.ATIVIDADE_ID GROUP BY D.USUARIO_ID, D.ATIVIDADE_ID ORDER BY ".$ordenacao.";";
	}
	require("query.php");
	$queryG3="SELECT U.NOME AS NOME, TRUNCATE(B.MAXIMO,2) AS MAXIMO, B.MINIMO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) MAXIMO, MIN(DESEMPENHO) MINIMO FROM DESEMPENHO WHERE REGISTRO>='2019-07-21' AND
REGISTRO<='2019-08-20' AND PRESENCA_ID<>3 GROUP BY USUARIO_ID) AS B
INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID 
WHERE D.USUARIO_ID=B.USUARIO_ID AND REGISTRO>='2019-07-21' AND REGISTRO<='2019-08-20' AND B.MAXIMO>=100
GROUP BY D.USUARIO_ID ORDER BY 2 DESC LIMIT 4;";			
	
	$x3=0;
	$cnxG3= mysqli_query($phpmyadmin, $queryG3);
	echo mysqli_error($phpmyadmin);
	while($G3 = $cnxG3->fetch_array()){
		$vtG3nome[$x3]= $G3["NOME"];
		$vtG3desempenho[$x3]= $G3["MAXIMO"];
		$vtG3menor[$x3]= $G3["MINIMO"];		
		$x3++;				
	}		
	$con = mysqli_query($phpmyadmin, $consulta);
	$row = mysqli_num_rows($con);
	$x=0;
	$maior=0;
	$menor=1000;
	$totalFaltas=0;
	$totalFolgas=0;	
	$con = mysqli_query($phpmyadmin , $consulta);
	while($dado = $con->fetch_array()){
		$vtIdUsuario[$x]=$dado["ID"];				
		$vtNome[$x] = $dado["NOME"];
		$vtDesempenho[$x] = $dado["DESEMPENHO"];
		$vtAtividade[$x] = $dado["ATIVIDADE"];
		$vtFalta[$x] = $dado["FALTA"];
		$vtFolga[$x] = $dado["FOLGA"];
		$totalAlcancado=$totalAlcancado+$dado["DESEMPENHO"];
		$vtRegistro[$x] = $dado["REGISTRO"];
		$totalFaltas=$totalFaltas+$vtFalta[$x];
		$totalFolgas=$totalFolgas+$vtFolga[$x];	
		if($maior<$vtDesempenho[$x]){
			$maior=$vtDesempenho[$x];
		}
		if($menor>$vtDesempenho[$x] && $vtDesempenho[$x]!=0){
			$menor=$vtDesempenho[$x];
		}			
		$contador++;
		$x++;		
	}	
	$xg=0;
	$cnx2=mysqli_query($phpmyadmin, $gafrico1);
	while($graf1= $cnx2->fetch_array()){
		$vtMedia[$xg]=$graf1["MEDIA"];
		$vtMenor[$xg]=$graf1["MENOR"];
		$xg++;
	}	
}?>
<?php if($contador !=0) : ?>
	<hr/>
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		<tr class="is-selected">
			<td>Resultado:<?php echo sizeof($vtNome);?></td>	
			<td>Falta's: <?php echo $totalFaltas;?></td>
			<td>Folga's: <?php echo $totalFolgas;?></td>
			<td>Menor: <?php echo $menor."%"?></td>
			<td>Media: <?php echo round($totalAlcancado/$contador, 2)."%"?></td>
			<td>Maior: <?php echo $maior."%"?></td>			
		</tr>
	</table>	
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth"style="$table-row-active-background-color:hsl(171, 100%, 41%);">	
	<tr>
		<th width="-20">N°</th>
		<th width="20" class="">Operador</th>
		<th>Detalhes</th>		
		<th>Falta's</th>
		<th>Folga's</th>
		<?php if($atividade=="separado") : ?><th>Atividade</th><?php endif; ?>
		<th>Desempenho</th>				
		<th>Período</th>			
	</tr>
<?php for( $i = 0; $i < sizeof($vtNome); $i++ ) : ?>
	<?php $z=$i; $registro=1; while($vtNome[$z]==$vtNome[$z+1]){
		$registro++;
		$repeat=$registro;
		$z++;
	}
	if($repeat>0){ $repeat--;}	
	?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td><?php echo utf8_encode($vtNome[$i])?></td>
		<?php if($registro>1 && $repeat!=0 && $mesclaa==false): ?><td rowspan="<?php echo $registro?>"><a href="report-detailed.php?periodo=<?php echo $periodo ?>&atividade=Todas&idUsuario=<?php echo $vtIdUsuario[$i]?>" target='blank'><button class="button is-primary">Consultar</button></a></td><?php $mesclaa=true;endif;?>
		<?php if($repeat==0 && $vtNome[$i-1]!=$vtNome[$i]): ?><td><a href="report-detailed.php?periodo=<?php echo $periodo ?>&atividade=Todas&idUsuario=<?php echo $vtIdUsuario[$i]?>" target='blank'><button class="button is-primary">Consultar</button></a></td><?php $mesclaa=false; endif;?>
		<?php if($registro>1 && $repeat!=0 && $mescla==false): ?><td rowspan="<?php echo $registro?>"><?php echo $vtFalta[$i]; $mescla=true;?></td><td rowspan="<?php echo $registro?>"><?php echo $vtFolga[$i]?></td><?php endif;?>	
		<?php if($repeat==0 && $vtNome[$i-1]!=$vtNome[$i]):?><td><?php echo $vtFalta[$i]; $mescla=false;?>
		<td><?php echo $vtFolga[$i]?></td><?php endif;?>
		<?php if($atividade=="separado"):?><td><?php echo $vtAtividade[$i]?></td><?php endif;?>		
		<td><?php echo $vtDesempenho[$i]."%"?></td>				
		<td><?php echo $vtRegistro[$i]?></td>
		<?php if($vtNome[$i]!=$vtNome[$i+1] && $repeat==0 && $mescla==true){ $mescla=false; $mesclaf=false; $mesclaa=false;}?>				
	</tr>
<?php endfor; ?>
	</table>
	<a href="#topo">
		<div class="field is-grouped is-grouped-centered">
			<button class="button is-primary is-fullwidth">Ir Ao Topo</button>		
		</div>
	</a>			
<?php endif; ?>
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

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
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
      	var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
      	chart.draw(data, options);
    }
</script>	
<script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawTitleSubtitle);
	function drawTitleSubtitle() {
    	var data = google.visualization.arrayToDataTable([
        ['Operador', 'avg', 'min'],
        ['<?php echo $vtG3nome[0]?>', parseFloat('<?php echo $vtG3desempenho[0]?>'), parseFloat('<?php echo $vtG3menor[0]?>')],
        ['<?php echo $vtG3nome[1]?>', parseFloat('<?php echo $vtG3desempenho[1]?>'), parseFloat('<?php echo $vtG3menor[1]?>')],
        ['<?php echo $vtG3nome[2]?>', parseFloat('<?php echo $vtG3desempenho[2]?>'), parseFloat('<?php echo $vtG3menor[2]?>')],
        ['<?php echo $vtG3nome[3]?>', parseFloat('<?php echo $vtG3desempenho[3]?>'), parseFloat('<?php echo $vtG3menor[3]?>')]        
      	]);
      	var materialOptions = {
        	chart: {
         		title: 'Ranking mensal dos operadores',
          		subtitle: 'Top 4 desempenho do mês '
        	},
        	hAxis: {
          		title: 'Total Alcançado',
          		minValue: 0,
        	},
        	vAxis: {
          		title: 'Ranking'
        	},
        	bars: 'horizontal'
      	};
      	var materialChart = new google.charts.Bar(document.getElementById('chart_div3'));
      	materialChart.draw(data, materialOptions);
    }
</script>
</body>
</html>