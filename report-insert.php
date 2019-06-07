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
	<title>Gestão de Desempenho - Inserir Desempenho</title>
</head>
<body>
	<span id="topo"></span>
<div>
	<br/>
	<form id="form1" action="report-insert.php" method="GET" >
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
	
	$ajusteBD="set global sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';";
	$ajustes= mysqli_query($phpmyadmin, $ajusteBD);
	
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
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		<tr class="is-selected">
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
	<a href="#topo">
		<div class="field is-grouped is-grouped-centered">
			<button class="button is-primary is-fullwidth">Ir Ao Topo</button>		
		</div>
	</a>			
<?php endif; ?>
</body>
</html>


