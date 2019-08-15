<?php
session_start();
include('connection.php');
include('login-check.php');
$menuDesempenho="is-active";
include('menu.php');
$erro = '';
$contador = 0;
$totalAlcancado=0;

$periodo = trim($_REQUEST['periodo']);
$atividade = trim($_REQUEST['atividade']);
$meta = trim($_REQUEST['meta']);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Relatório Individual</title>
</head>
<body>
	<span id="topo"></span>
<div>
	<br/>
	<form id="form1" action="report-private.php" method="GET" >
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
								<option selected="selected" value="Todas">Todas</option>	
								<option value="Checkout">Checkout</option>
								<option value="Picking">Picking</option>
								<option value="PBL">PBL</option>
								<option value="Embalagem">Embalagem</option>
								<option value="Recebimento">Recebimento</option>
								<option value="Avarias e Devoluções">Avaria/Devolução</option>						
								<option value="Expedição">Expedição</option>	
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
								<select name="meta">
									<option selected="selected"value="">Ambos</option>
									<option value="and b.alcancado>=100">Atingida</option>
									<option value="and b.alcancado<100">Não atingida</option>
								</select>	
							</div>
						</div>
					<div class="control">
						<!--<button type="submit" class="button is-primary">Filtrar</button>-->
						<input type="submit" class="button is-primary" id="submitQuery" value="Pesquisar"/>
					</div>
				</div>						
			</div>
		</div>
	</form>		
</div>
<!--FINAL DO FORMULÁRIO-->
<?php
if( $periodo != ""){	
	if($periodo =="atual"){
		if($atividade !="Todas"){
			$consulta ="select * from gestaodesempenho.desempenho where nome='".$name."' and atividade='".$atividade."' and registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		else{
			$consulta ="select * from gestaodesempenho.desempenho where nome='".$name."' and registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')".$meta." order by registro;";
		}
	}
	else if($periodo =="proximo"){
		if($atividade !="Todas"){
			$consulta="select * from gestaodesempenho.desempenho where nome='".$name."' and atividade='".$atividade."' and registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		else{
			$consulta="select * from gestaodesempenho.desempenho where nome='".$name."' and registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		
	}
	else if($periodo =="penultimo"){
		if($atividade !="Todas"){
			$consulta="select * from gestaodesempenho.desempenho where nome='".$name."' and atividade='".$atividade."' and registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		else{
			$consulta="select * from gestaodesempenho.desempenho where nome='".$name."' and registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}		
	}
	else{
		if($atividade !="Todas"){
			$consulta="select * from gestaodesempenho.desempenho where nome='".$name."' and atividade='".$atividade."' and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		else{
			$consulta="select * from gestaodesempenho.desempenho where nome='".$name."' and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}
		
	}
	$consulta="SELECT U.NOME, A.NOME, P.NOME, D.META, D.ALCANCADO, D.DESEMPENHO, D.REGISTRO, D.OBSERVACAO FROM DESEMPENHO D
	INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID
	INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID
	INNER JOIN PRESENCA P ON P.ID=D.PRESENCA_ID
	WHERE D.USUARIO_ID=1 AND REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20'
	ORDER BY REGISTRO;";	
	$con = mysqli_query($phpmyadmin, $consulta);
	$x=0;
	while($dado = $con->fetch_array()){		
		$vetorAtividade[$x] = $dado["ATIVIDADE"];
		$vetorDesempenho[$x] = $dado["DESEMPENHO"];
		$vetorMeta[$x] = $dado["META"];
		$vetorAlcancado[$x] = $dado["ALCANCADO"];
		$totalAlcancado=$totalAlcancado+$dado["ALCANCADO"];
		$vetorRegistro[$x] = $dado["REGISTRO"];
		$contador++;
		$x++;
		echo $x;
	}
	if($contador==0){
		?><script type="text/javascript">alert('Nenhum resultado encontrado!');</script><?php
	}	
}
else{
	
}?>
<?php if( $periodo !="" && $contador !=0) : ?>
<hr/>
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		<tr>
			<td colspan='10' class='table_title'>
				<span class='title_left'><?php echo $ordersData[0]['increment_id'] ?>Colaborador: <?php echo $name?> Media: <?php echo round($totalAlcancado/$contador, 2)."%" ?>
				</span>
			</td>
		</tr>
	<tr>
		<th>Atividade</th>
		<th>Desempenho</th>
		<th>Meta</th>
		<th>Alacançado</th>
		<th>Data</th>
		<th style='width:250px;'>Observação</th>
	</tr>
<?php for( $i = 0; $i < sizeof($vetorAtividade); $i++ ) : ?>
	<tr>
		<td><?php echo $vetorAtividade[$i]?></td>			
		<td><?php echo $vetorDesempenho[$i]?></td>			
		<td><?php echo $vetorMeta[$i]?></td>
		<td><?php echo $vetorAlcancado[$i]."%"?></td>
		<td><?php echo $vetorRegistro[$i]?></td>			
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



