<style type="text/css">
	/*$table-cell-padding: .75rem !default; $table-sm-cell-padding: .3rem !default; $table-bg: transparent !default; $table-bg-accent: rgba(0,0,0,.05) !default; $table-bg-hover: rgba(0,0,0,.075) !default; $table-bg-active: $table-bg-hover !default; $table-border-width: $border-width !default; $table-border-color: $gray-lighter !default;*/
</style>
<?php
session_start();
include('conexao.php');
//require_once('js/loader.js');
include('verifica_login.php');
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
<div>
	<br/>
	<form id='form1' action='report.php' method='GET' >
		<div class="field is-horizontal">
			<!--SELEÇÃO PERÍODO-->
			<div class="field-label is-normal">
				<label class="label" for="periodo">Período:</label>
			</div>
			<div class="field-body">
			<div class="field is-grouped">							
				<div class="control">
					<div class="select">
						<select name='periodo'>
							<option value='proximo'><?php echo strftime('%h', strtotime("+1 months"))?></option>
							<option selected='selected' value='atual'><?php echo strftime('%h')?></option>
							<option value='ultimo'><?php echo strftime('%h', strtotime("-1 months"))?></option>
							<option value='penultimo'><?php echo strftime('%h', strtotime("-2 months"))?></option>
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
								<option selected="selected" value="nome">Nome</option>	
								<option value="alcancado desc, nome">Alcançado</option>	
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
								<option selected="selected" value="agrupado">Todos</option>	
								<option value="separado">Matutino</option>
								<option value="separado">Vespetino</option>	
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
	$presenca="(select count(presenca) from gestaodesempenho.desempenho where presenca='Ausente' and a.nome=nome)falta,(select count(presenca) from gestaodesempenho.desempenho where presenca='Folga' and a.nome=nome)folga ,";
	if($periodo =="atual"){
		$data="and registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')";
		$registro="concat(concat(date_format(date_add(curdate(),interval -1 month),'%Y/%m'),'/21'), concat(date_format(curdate(),' - %Y/%m'),'/20')) registro";
	}
	else if($periodo =="proximo"){
		$data="and registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20')";
		$registro="concat(concat(date_format(curdate(),'%Y/%m'),'/21'), concat(date_format(date_add(curdate(), interval +1 month),' - %Y/%m'),'/20')) registro";
	}
	else if($periodo =="ultimo"){
		$data="and registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20')";
		$registro="concat(concat(date_format(date_add(curdate(),interval -2 month),'%Y/%m'),'/21'), concat(date_format(date_add(curdate(), interval -1 month),' - %Y/%m'),'/20')) registro";
	}
	else{
		$data="and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20')";
		$registro="concat(concat(date_format(date_add(curdate(),interval -3 month),'%Y/%m'),'/21'), concat(date_format(date_add(curdate(), interval -2 month),' - %Y/%m'),'/20')) ";
	}
	$filtroAdd= str_replace("and registro >=", "where registro >=", $data);
	if($atividade!="agrupado"){
		echo $filtroAdd;
		$consulta="select a.nome,".$presenca." truncate(b.alcancado,2) alcancado, ".$registro.", a.atividade from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado, atividade from gestaodesempenho.desempenho ".$filtroAdd." and presenca <>'Folga' group by nome, atividade) as b
where a.nome=b.nome and a.atividade=b.atividade ".$data."".$meta."
group by nome, atividade
order by ".$ordenacao.";";
	}
	else{		
		$consulta ="select a.nome,".$presenca." truncate(b.alcancado,2) alcancado, ".$registro." from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado from gestaodesempenho.desempenho ".$filtroAdd." and presenca <>'Folga' group by nome) as b
where a.nome=b.nome ".$data."".$meta."
group by nome
order by ".$ordenacao.";";
	}
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
	#set global sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
	$x3=0;
	//$cnxG3= $mysqli->query($queryG3) or die($mysqli->error);
	$cnxG3= mysqli_query($phpmyadmin, $queryG3);//or die(' Erro na query:' . $queryG3 . ' ' . mysql_error());	
	while($G3 = $cnxG3->fetch_array()){
		$vtG3nome[$x3]= $G3["nome"];
		$vtG3alcancado[$x3]= $G3["alcancado"];
		$vtG3menor[$x3]= $G3["menor"];		
		$x3++;				
	}				
	$con = mysqli_query($phpmyadmin, $consulta);// or die($mysqli->error);
	$row = mysqli_num_rows($con);
	echo $row;
	$x=0;
	$maior=0;
	$menor=1000;	
	$query="select a.nome,(select count(presenca) from gestaodesempenho.desempenho where presenca='Ausente' and a.nome=nome)falta, (select count(presenca) from gestaodesempenho.desempenho where presenca='Folga' and a.nome=nome)folga, truncate(b.alcancado,2) alcancado, concat(concat(date_format(date_add(curdate(),interval -3 month),'%Y/%m'),'/21'), concat(date_format(date_add(curdate(), interval -2 month),' - %Y/%m'),'/20')) from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado from gestaodesempenho.desempenho group by nome) as b where a.nome=b.nome and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20') group by nome order by nome;";		
	$con = mysqli_query($phpmyadmin , $query);	
	//while($dado = $con->fetch_array()){	
	while($dado = $con->fetch_array()){				
		$vetorNome[$x] = $dado["nome"];
		$vetorAlcancado[$x] = $dado["alcancado"];
		$vetorAtividade[$x] = $dado["atividade"];
		$vetorFalta[$x] = $dado["falta"];
		$vetorFolga[$x] = $dado["folga"];
		$totalAlcancado=$totalAlcancado+$dado["alcancado"];
		$vetorRegistro[$x] = $dado["registro"];		
		if($maior<$vetorAlcancado[$x]){
			$maior=$vetorAlcancado[$x];
		}
		if($menor>$vetorAlcancado[$x] && $vetorAlcancado[$x]!=0){
			$menor=$vetorAlcancado[$x];
		}			
		$contador++;
		$x++;		
	}	
	$co2="select (select count(presenca) from gestaodesempenho.desempenho where presenca='Ausente' ".$data.")falta, count(presenca)folga from gestaodesempenho.desempenho where presenca='folga' ".$data."";
	$cnx= mysqli_query($phpmyadmin, $co2); //or die($mysqli->error);
	$presenca= $cnx->fetch_array();
	$xg=0;
	$cnx2=mysqli_query($phpmyadmin, $gafrico1); //or die($mysqli->error);
	while($graf1= $cnx2->fetch_array()){
		$vtMedia[$xg]=$graf1["media"];
		$vtMenor[$xg]=$graf1["menor"];
		$xg++;
	}	
}	
?>
<!--FINAL DO FORMULÁRIO-->
<?php if($contador !=0) : ?>
<hr/>
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth" style=".table-hover tbody tr:hover td, .table-hover tbody tr:hover th { background-color: #7CFC00; } ">
		<tr class="teste">
			<td class='table_title'>
				<span class='title_left'>Resultado:<?php echo sizeof($vetorNome);?></span>
			</td>	
			<td class='table_title'>
				<span class='title_left'>Falta's: <?php echo $presenca["falta"]?></span>
			</td>
			<td class='table_title'>
				<span class="title_left">Folga's: <?php echo $presenca["folga"]?></span>
			<td class='table_title'>
				<span class='title_left'>Menor: <?php echo $menor."%"?></span>
			</td>
			<td class='table_title'>
				<span class='title_left'>Media: <?php echo round($totalAlcancado/$contador, 2)."%"?>
				</span>
			</td>
			<td class='table_title'>
				<span class='title_left'>Maior: <?php echo $maior."%"?></span>
			</td>			
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
		<th>Alcançado</th>				
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
		<td><?php echo $vetorNome[$i]?></td>
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
<?php endif; ?>
<button class="button is-primary" id="go_top" onclick="$('body').scrollTop(0)" >Ir Ao Topo</button>
<div style='clear:both' ></div>
<div id='dialog_info' ></div>	
<script>
		$('#submitQuery').button().click(function(){
				$('#form1').submit();
			});
			$('#cleanQuery').button().click(function(){
				$('#form1 input[type=text]').val("");
			});			
			$('#go_top').button().css('width','100%');
</script>
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
      data.addRows([
        [0, parseFloat('<?php echo $vetorAlcancado[0]?>')],   [1, parseFloat('<?php echo $vetorAlcancado[1]?>')],  [2, parseFloat('<?php echo $vetorAlcancado[2]?>')],
        [3, parseFloat('<?php echo $vetorAlcancado[3]?>')],  [4, parseFloat('<?php echo $vetorAlcancado[4]?>')],  [5, parseFloat('<?php echo $vetorAlcancado[5]?>')],
        [6, parseFloat('<?php echo $vetorAlcancado[6]?>')],  [7, parseFloat('<?php echo $vetorAlcancado[7]?>')],  [8, parseFloat('<?php echo $vetorAlcancado[8]?>')],
        [9, parseFloat('<?php echo $vetorAlcancado[9]?>')],  [10, parseFloat('<?php echo $vetorAlcancado[10]?>')], [11, parseFloat('<?php echo $vetorAlcancado[11]?>')],
        [12, parseFloat('<?php echo $vetorAlcancado[12]?>')], [13, parseFloat('<?php echo $vetorAlcancado[13]?>')], [14, parseFloat('<?php echo $vetorAlcancado[14]?>')], 
        [15, parseFloat('<?php echo $vetorAlcancado[15]?>')], [16, parseFloat('<?php echo $vetorAlcancado[16]?>')], [17, parseFloat('<?php echo $vetorAlcancado[17]?>')],
        [18, parseFloat('<?php echo $vetorAlcancado[18]?>')], [19, parseFloat('<?php echo $vetorAlcancado[19]?>')], [20, parseFloat('<?php echo $vetorAlcancado[19]?>')], 
        [21, parseFloat('<?php echo $vetorAlcancado[21]?>')], [22, parseFloat('<?php echo $vetorAlcancado[22]?>')], [23, parseFloat('<?php echo $vetorAlcancado[23]?>')],
        [24, parseFloat('<?php echo $vetorAlcancado[24]?>')], [25, parseFloat('<?php echo $vetorAlcancado[25]?>')], [26, parseFloat('<?php echo $vetorAlcancado[26]?>')], 
        [27, parseFloat('<?php echo $vetorAlcancado[27]?>')], [28, parseFloat('<?php echo $vetorAlcancado[28]?>')], [29, parseFloat('<?php echo $vetorAlcancado[29]?>')],
        [30, parseFloat('<?php echo $vetorAlcancado[30]?>')], [31, parseFloat('<?php echo $vetorAlcancado[31]?>')], [32, parseFloat('<?php echo $vetorAlcancado[32]?>')], 
        [33, parseFloat('<?php echo $vetorAlcancado[33]?>')], [34, parseFloat('<?php echo $vetorAlcancado[34]?>')], [35, parseFloat('<?php echo $vetorAlcancado[35]?>')],
        [36, parseFloat('<?php echo $vetorAlcancado[36]?>')], [37, parseFloat('<?php echo $vetorAlcancado[37]?>')], [38, parseFloat('<?php echo $vetorAlcancado[38]?>')], 
        [39, parseFloat('<?php echo $vetorAlcancado[39]?>')], [40, parseFloat('<?php echo $vetorAlcancado[40]?>')], [41, parseFloat('<?php echo $vetorAlcancado[41]?>')],
        [42, parseFloat('<?php echo $vetorAlcancado[42]?>')], [43, parseFloat('<?php echo $vetorAlcancado[43]?>')], [44, parseFloat('<?php echo $vetorAlcancado[44]?>')], 
        [45, parseFloat('<?php echo $vetorAlcancado[45]?>')], [46, parseFloat('<?php echo $vetorAlcancado[46]?>')], [47, parseFloat('<?php echo $vetorAlcancado[47]?>')],
        [48, parseFloat('<?php echo $vetorAlcancado[48]?>')], [49, parseFloat('<?php echo $vetorAlcancado[49]?>')], [50, parseFloat('<?php echo $vetorAlcancado[50]?>')], 
        [51, parseFloat('<?php echo $vetorAlcancado[51]?>')], [52, parseFloat('<?php echo $vetorAlcancado[52]?>')], [53, parseFloat('<?php echo $vetorAlcancado[53]?>')],
        [54, parseFloat('<?php echo $vetorAlcancado[54]?>')], [55, parseFloat('<?php echo $vetorAlcancado[55]?>')], [56, parseFloat('<?php echo $vetorAlcancado[56]?>')], 
        [57, parseFloat('<?php echo $vetorAlcancado[57]?>')], [58, parseFloat('<?php echo $vetorAlcancado[58]?>')], [59, parseFloat('<?php echo $vetorAlcancado[59]?>')],
        [60, parseFloat('<?php echo $vetorAlcancado[60]?>')], [61, parseFloat('<?php echo $vetorAlcancado[61]?>')], [62, parseFloat('<?php echo $vetorAlcancado[62]?>')], 
        [63, parseFloat('<?php echo $vetorAlcancado[63]?>')], [64, parseFloat('<?php echo $vetorAlcancado[64]?>')], [65, parseFloat('<?php echo $vetorAlcancado[65]?>')],
        [66, parseFloat('<?php echo $vetorAlcancado[66]?>')], [67, parseFloat('<?php echo $vetorAlcancado[67]?>')], [68, parseFloat('<?php echo $vetorAlcancado[68]?>')], 
        [69, parseFloat('<?php echo $vetorAlcancado[69]?>')], [70, parseFloat('<?php echo $vetorAlcancado[70]?>')], [71, parseFloat('<?php echo $vetorAlcancado[71]?>')],
        [72, parseFloat('<?php echo $vetorAlcancado[72]?>')], [73, parseFloat('<?php echo $vetorAlcancado[73]?>')], [74, parseFloat('<?php echo $vetorAlcancado[74]?>')],
        [75, parseFloat('<?php echo $vetorAlcancado[75]?>')], [76, parseFloat('<?php echo $vetorAlcancado[76]?>')], [77, parseFloat('<?php echo $vetorAlcancado[77]?>')], 
        [78, parseFloat('<?php echo $vetorAlcancado[78]?>')], [79, parseFloat('<?php echo $vetorAlcancado[79]?>')], [80, parseFloat('<?php echo $vetorAlcancado[80]?>')],
        [81, parseFloat('<?php echo $vetorAlcancado[81]?>')], [82, parseFloat('<?php echo $vetorAlcancado[82]?>')], [83, parseFloat('<?php echo $vetorAlcancado[83]?>')], 
        [84, parseFloat('<?php echo $vetorAlcancado[84]?>')], [85, parseFloat('<?php echo $vetorAlcancado[85]?>')], [86, parseFloat('<?php echo $vetorAlcancado[86]?>')],
        [87, parseFloat('<?php echo $vetorAlcancado[87]?>')], [88, parseFloat('<?php echo $vetorAlcancado[88]?>')], [89, parseFloat('<?php echo $vetorAlcancado[89]?>')], 
        [90, parseFloat('<?php echo $vetorAlcancado[90]?>')], [91, parseFloat('<?php echo $vetorAlcancado[91]?>')], [92, parseFloat('<?php echo $vetorAlcancado[92]?>')]    
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


