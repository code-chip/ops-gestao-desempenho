<?php
session_start();
include('phpmyadmin.php');
include('verifica_login.php');
$menuInicio="is-active";
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

<?php if($periodo!=''):?><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="graficos" style="position: relative; width: 100%; height: 250px; /*border: 3px solid #73AD21;*/">
<div id="chart_div" style="position: absolute; top:-1%; left:0%; width: 25%; height: 250px; /*border: 3px solid #73AD26;*/"></div>
<div id="chart_div2" style="position: absolute; top:-1%; left:25%; width: 30%; height: 250px;/*border: 3px solid #73AD29;*/"></div>
<div id="chart_div3" style="position: absolute; top:-1%; left:55%; width: 30%; height: 250px;/*border: 3px solid #73AD29;*/"></div>
<?php endif;?>
</div>
<?php
/*result = mysqli_query($conexao, $query);
 
$row = mysqli_num_rows($result);
//echo $row;
if($row == 1){
	$_SESSION['usuario'] = $_POST['usuario'];
	header('Location: home.php');
	exit();
}
else{
	$_SESSION['nao_autenticado']=true;
	header('Location: index.php');
}*/
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
	$cnxG3= $mysqli->query($queryG3) or die($mysqli->error);
	while($G3 = $cnxG3->fetch_array()){
		$vtG3nome[$x3]= $G3["nome"];
		$vtG3alcancado[$x3]= $G3["alcancado"];
		$vtG3menor[$x3]= $G3["menor"];
		$x3++;
	}
	
	$con = $mysqli->query($consulta) or die($mysqli->error);
	$x=0;
	$maior=0;
	$menor=1000;
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
	echo "teste";
	$co2="select (select count(presenca) from gestaodesempenho.desempenho where presenca='Ausente' ".$data.")falta, count(presenca)folga from gestaodesempenho.desempenho where presenca='folga' ".$data."";
	$cnx= $mysqli->query($co2) or die($mysqli->error);
	$presenca= $cnx->fetch_array();
	$xg=0;
	$cnx2=$mysqli->query($gafrico1) or die($mysqli->error);
	while($graf1= $cnx2->fetch_array()){
		$vtMedia[$xg]=$graf1["media"];
		$vtMenor[$xg]=$graf1["menor"];
		$xg++;
	}
}
else{
	
}?>

</body>
</html>


