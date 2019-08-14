<style type="text/css">
	/*$table-cell-padding: .75rem !default; $table-sm-cell-padding: .3rem !default; $table-bg: transparent !default; $table-bg-accent: rgba(0,0,0,.05) !default; $table-bg-hover: rgba(0,0,0,.075) !default; $table-bg-active: $table-bg-hover !default; $table-border-width: $border-width !default; $table-border-color: $gray-lighter !default;*/
</style>
<?php
session_start();
include('connection.php');
//require_once('js/loader.js');
include('login-check.php');
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
			<!--SELEÇÃO PERÍODO-->
			<div class="field-label is-normal">
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
			<!--SELEÇÃO ATIVIDADE-->
			<div class="field-label is-normal">
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
			<!--SELEÇÃO ORDENAÇÃO-->
			<div class="field-label is-normal">
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
			<!--SELEÇÃO TURNO-->
			<div class="field-label is-normal">
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
			<!--SELEÇÃO META-->
			<div class="field-label is-normal">
				<label class="label" for="meta">Meta:</label>
			</div>
				<div class="field-body">
					<div class="field is-grouped">							
						<div class="control">
							<div class="select">
								<select name='meta'>
									<option selected="selected"value="">Ambos</option>
									<option value="and b.alcancado>=100">Atingida</option>
									<option value="and b.alcancado<100">Não atingida ;/</option>
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
</div>

<?php if($periodo!=""):?><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="graficos" style="position: relative; width: 100%; height: 250px; /*border: 3px solid #73AD21;*/">
<div id="chart_div" style="position: absolute; top:2%; left:0%; width: 25%; height: 250px; /*border: 3px solid #73AD26;*/"></div>
<div id="chart_div2" style="position: absolute; top:2%; left:25%; width: 30%; height: 250px;/*border: 3px solid #73AD29;*/"></div>
<div id="chart_div3" style="position: absolute; top:2%; left:55%; width: 30%; height: 250px;/*border: 3px solid #73AD29;*/"></div>
<?php endif;?>
</div>
<?php
if( $periodo != ""){	
	$consulta ="SELECT U.NOME, D.USUARIO_ID, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID) AS FALTA, 
(SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID) AS FOLGA, TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO,  
CONCAT(DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH),' a ".$periodo."-20') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) DESEMPENHO FROM DESEMPENHO WHERE REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20' AND PRESENCA_ID<>3 GROUP BY USUARIO_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID WHERE D.USUARIO_ID=B.USUARIO_ID AND REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20' GROUP BY D.USUARIO_ID ORDER BY ".$ordenacao.";";
	$gafrico1="select truncate(avg(ALCANCADO),2)media,truncate((select min(ALCANCADO) from gestaodesempenho.desempenho where ALCANCADO>0 and registro >= concat(date_format(date_sub(curdate(),interval 3 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_sub(curdate(),interval 2 month),'%Y-%m'),'-20')),2)menor from gestaodesempenho.desempenho 
where registro >= concat(date_format(date_sub(curdate(),interval 3 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_sub(curdate(),interval 2 month),'%Y-%m'),'-20')
union all
select truncate(avg(ALCANCADO),2)media,truncate((select min(ALCANCADO) from gestaodesempenho.desempenho where ALCANCADO>0 and registro >= concat(date_format(date_sub(curdate(),interval 2 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_sub(curdate(),interval 1 month),'%Y-%m'),'-20')),2)menor from gestaodesempenho.desempenho 
where registro >= concat(date_format(date_sub(curdate(),interval 2 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_sub(curdate(),interval 1 month),'%Y-%m'),'-20')
union all
select truncate(avg(ALCANCADO),2)media,truncate((select min(ALCANCADO) from gestaodesempenho.desempenho where ALCANCADO>0 and registro >= concat(date_format(date_sub(curdate(),interval 1 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')),2)menor from gestaodesempenho.desempenho 
where registro >= concat(date_format(date_sub(curdate(),interval 1 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')
union all
select truncate(avg(ALCANCADO),2)media,truncate((select min(ALCANCADO) from gestaodesempenho.desempenho where ALCANCADO>0 and registro >= concat(date_format(curdate(),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_add(curdate(),interval 1 month),'%Y-%m'),'-20')),2)menor from gestaodesempenho.desempenho 
where registro >= concat(date_format(curdate(),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_add(curdate(),interval 1 month),'%Y-%m'),'-20')";

	$queryG3="select a.nome nome, max(b.alcancado) alcancado, b.menor
from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado, min(alcancado) menor from gestaodesempenho.desempenho where 
registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20') and presenca <>'Folga' group by nome order by alcancado desc limit 1) as b
where a.nome=b.nome and registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20')
union all
select a.nome, max(b.alcancado) alcancado, b.menor
from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado, min(alcancado) menor from gestaodesempenho.desempenho where 
registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20') and presenca <>'Folga' group by nome order by alcancado desc limit 1) as b
where a.nome=b.nome and registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')
union all 
select a.nome, max(b.alcancado) alcancado, b.menor
from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado, min(alcancado) menor from gestaodesempenho.desempenho where registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20') and presenca <>'Folga' group by nome order by alcancado desc limit 1) as b
where a.nome=b.nome and registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20')
union all 
select a.nome, max(b.alcancado) alcancado, b.menor
from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado, min(alcancado) menor from gestaodesempenho.desempenho where registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20') and presenca <>'Folga' group by nome order by alcancado desc limit 1) as b
where a.nome=b.nome and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20')
";		
	$ajusteBD="set global sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';";
	$ajustes= mysqli_query($phpmyadmin, $ajusteBD);
	$x3=0;
	$cnxG3= mysqli_query($phpmyadmin, $queryG3);
	while($G3 = $cnxG3->fetch_array()){
		$vtG3nome[$x3]= $G3["nome"];
		$vtG3alcancado[$x3]= $G3["alcancado"];
		$vtG3menor[$x3]= $G3["menor"];		
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
		$vetorNome[$x] = $dado["NOME"];
		$vetorAlcancado[$x] = $dado["DESEMPENHO"];
		$vetorAtividade[$x] = $dado["ATIVIDADE"];
		$vetorFalta[$x] = $dado["FALTA"];
		$vetorFolga[$x] = $dado["FOLGA"];
		$totalAlcancado=$totalAlcancado+$dado["DESEMPENHO"];
		$vetorRegistro[$x] = $dado["REGISTRO"];
		$totalFaltas=$totalFaltas+$vetorFalta[$x];
		$totalFolgas=$totalFolgas+$vetorFolga[$x];	
		if($maior<$vetorAlcancado[$x]){
			$maior=$vetorAlcancado[$x];
		}
		if($menor>$vetorAlcancado[$x] && $vetorAlcancado[$x]!=0){
			$menor=$vetorAlcancado[$x];
		}			
		$contador++;
		$x++;		
	}	
	$xg=0;
	$cnx2=mysqli_query($phpmyadmin, $gafrico1); //or die($mysqli->error);
	while($graf1= $cnx2->fetch_array()){
		$vtMedia[$xg]=$graf1["media"];
		$vtMenor[$xg]=$graf1["menor"];
		$xg++;
	}	
}?>
<!--FINAL DO FORMULÁRIO-->
<?php if($contador !=0) : ?>
	<hr/>
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		<tr class="is-selected">
			<td>Resultado:<?php echo sizeof($vetorNome);?></td>	
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
<?php for( $i = 0; $i < sizeof($vetorNome); $i++ ) : ?>
	<?php $z=$i; $registro=1; while($vetorNome[$z]==$vetorNome[$z+1]){
		$registro++;
		$repeat=$registro;
		$z++;
	}
	if($repeat>0){ $repeat--;}	
	?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td><?php echo utf8_encode($vetorNome[$i])?></td>
		<?php if($registro>1 && $repeat!=0 && $mesclaa==false): ?><td rowspan="<?php echo $registro?>"><a href="http://192.168.217.6/evino/acomp_individual.php?periodo=<?php echo $periodo ?>&atividade=Todas&name=<?php echo $vetorNome[$i]?>" target='blank'><button>Consultar</button></a></td><?php $mesclaa=true;endif;?>
		<?php if($repeat==0 && $vetorNome[$i-1]!=$vetorNome[$i]): ?><td><a href="http://192.168.217.6/evino/acomp_individual.php?periodo=<?php echo $periodo ?>&atividade=Todas&name=<?php echo $vetorNome[$i]?>" target='blank'><button class="button is-primary">Consultar</button></a></td><?php $mesclaa=false; endif;?>
		<?php if($registro>1 && $repeat!=0 && $mescla==false): ?><td rowspan="<?php echo $registro?>"><?php echo $vetorFalta[$i]; $mescla=true;?></td><td rowspan="<?php echo $registro?>"><?php echo $vetorFolga[$i]?></td><?php endif;?>	
		<?php if($repeat==0 && $vetorNome[$i-1]!=$vetorNome[$i]):?><td><?php echo $vetorFalta[$i]; $mescla=false;?>
		<td><?php echo $vetorFolga[$i]?></td><?php endif;?>
		<?php if($atividade=="separado"):?><td><?php echo $vetorAtividade[$i]?></td><?php endif;?>		
		<td><?php echo $vetorAlcancado[$i]."%"?></td>				
		<td><?php echo $vetorRegistro[$i]?></td>
		<?php if($vetorNome[$i]!=$vetorNome[$i+1] && $repeat==0 && $mescla==true){ $mescla=false; $mesclaf=false; $mesclaa=false;}?>				
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
          ['Mês', 'Media', 'Menor'],
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
      data.addColumn('number', 'Alcançado'); 
	var i;
	"<?php echo $count=0;?>";
	for (i = 0; i < 90; i++) {			
  		data.addRows([
        [i, parseFloat("<?php echo $vetorAlcancado["<script>document.write(i)</script>"];?>")]
        ]);
        "<?php echo $count=$count+1;?>";
	}
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
        ['Operador', 'Alcançado', 'Menor do período'],
        ['<?php echo $vtG3nome[0]?>', parseFloat('<?php echo $vtG3alcancado[0]?>'), parseFloat('<?php echo $vtG3menor[0]?>')],
        ['<?php echo $vtG3nome[1]?>', parseFloat('<?php echo $vtG3alcancado[1]?>'), parseFloat('<?php echo $vtG3menor[1]?>')],
        ['<?php echo $vtG3nome[2]?>', parseFloat('<?php echo $vtG3alcancado[2]?>'), parseFloat('<?php echo $vtG3menor[2]?>')],
        ['<?php echo $vtG3nome[3]?>', parseFloat('<?php echo $vtG3alcancado[3]?>'), parseFloat('<?php echo $vtG3menor[3]?>')]        
      ]);

      var materialOptions = {
        chart: {
          title: 'Ranking mensal dos operadores',
          subtitle: 'Melhor desempenho no mês atual e nos últimos 3 meses'
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


