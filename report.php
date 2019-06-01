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
				<label for="odernacao" class="label">Ordenação:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="atividade">
								<option selected="selected" value="agrupado">Nome</option>	
								<option value="separado">Alcançado</option>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<!--SELEÇÃO TURNO-->
			<div class="field-label is-normal">
				<label for="odernacao" class="label">Turno:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="atividade">
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
	//OK.
	$query="select a.nome,(select count(presenca) from gestaodesempenho.desempenho where presenca='Ausente' and a.nome=nome)falta, (select count(presenca) from gestaodesempenho.desempenho where presenca='Folga' and a.nome=nome)folga, truncate(b.alcancado,2) alcancado, concat(concat(date_format(date_add(curdate(),interval -3 month),'%Y/%m'),'/21'), concat(date_format(date_add(curdate(), interval -2 month),' - %Y/%m'),'/20')) from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado from gestaodesempenho.desempenho group by nome) as b where a.nome=b.nome and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20') group by nome order by nome;";
	$con = mysqli_query($phpmyadmin , $query);
	echo $consulta;
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
	echo "teste3";
	$co2="select (select count(presenca) from gestaodesempenho.desempenho where presenca='Ausente' ".$data.")falta, count(presenca)folga from gestaodesempenho.desempenho where presenca='folga' ".$data."";
	$cnx= mysqli_query($co2) or die($mysqli->error);
	$presenca= $cnx->fetch_array();
	$xg=0;
	$cnx2=mysqli_query($gafrico1) or die($mysqli->error);
	while($graf1= $cnx2->fetch_array()){
		$vtMedia[$xg]=$graf1["media"];
		$vtMenor[$xg]=$graf1["menor"];
		$xg++;
	}
}	
?>
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


