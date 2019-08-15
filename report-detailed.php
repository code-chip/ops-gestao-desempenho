<?php
require_once 'include/Util.php';
require_once 'include/conexao.php';
require_once 'include/style.css';

$userid = startPage();
$erro = '';
$contador = 0;
$totalAlcancado=0;
$currentStatus = '';
if( !validateOP() || !isset($_GET) && $userid==147 || $userid==66 || $userid==64 || $userid==15 || $userid==4 ){
	setHeader();
	$periodo = trim($_REQUEST['periodo']);
	$atividade = trim($_REQUEST['atividade']);
	$meta = trim($_REQUEST['meta']);
	$name = trim($_REQUEST['name']);
set_time_limit(0);
?>

<?php
if( $periodo != ""){
	if($periodo =="atual"){
		$data="and registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')";
		if($atividade !="Todas"){			
			$consulta ="select * from evinops.desempenho where nome='".$name."' and atividade='".$atividade."'".$data."".$meta." order by registro;";
		}
		else{			
			$consulta ="select * from evinops.desempenho where nome='".$name."'".$data."".$meta." order by registro;";
		}
	}
	else if($periodo =="proximo"){
		$data="and registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20')";
		if($atividade !="Todas"){			
			$consulta="select * from evinops.desempenho where nome='".$name."' and atividade='".$atividade."'".$data."".$meta." order by registro;";
		}
		else{			
			$consulta="select * from evinops.desempenho where nome='".$name."'".$data."".$meta." order by registro;";
		}
		
	}
	else if($periodo =="ultimo"){//ultimo
		$data="and registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20')";
		if($atividade !="Todas"){			
			$consulta="select * from evinops.desempenho where nome='".$name."' and atividade='".$atividade."' ".$data."".$meta." order by registro;";
		}
		else{			
			$consulta="select * from evinops.desempenho where nome='".$name."'".$data."".$meta." order by registro;";
		}		
	}
	else{
		$data="and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20')";
		if($atividade !="Todas"){			
			$consulta="select * from evinops.desempenho where nome='".$name."' and atividade='".$atividade."' ".$data."".$meta." order by registro;";
		}
		else{
			$consulta="select * from evinops.desempenho where nome='".$name."' and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20')".$meta." order by registro;";
		}		
	}	
	$con = $mysqli->query($consulta) or die($mysqli->error);
	$x=0; $menor=1000; $maior=0;
	while($dado = $con->fetch_array()){		
		$vetorAtividade[$x] = $dado["ATIVIDADE"];
		$vetorPresenca[$x] = $dado["PRESENCA"];
		$vetorDesempenho[$x] = $dado["DESEMPENHO"];
		$vetorMeta[$x] = $dado["META"];
		$vetorAlcancado[$x] = $dado["ALCANCADO"];
		$totalAlcancado=$totalAlcancado+$dado["ALCANCADO"];
		$vetorRegistro[$x] = $dado["REGISTRO"];		
		if($maior<$vetorAlcancado[$x]){
			$maior=$vetorAlcancado[$x];
		}
		if($menor>$vetorAlcancado[$x] && $vetorAlcancado[$x]>0){
			$menor=$vetorAlcancado[$x];
		}
		$contador++;
		$x++;
	}	
	if($contador==0){
		?><script type="text/javascript">alert('Nenhum resultado encontrado!');</script><?php
	}
	$consulta2="select (select count(presenca) from evinops.desempenho where PRESENCA='Folga' and nome='".$name."' ".$data.")folga, count(presenca) falta from evinops.desempenho where PRESENCA='Ausente' and nome='".$name."'".$data."";
	$con2= $mysqli->query($consulta2) or die($mysqli->error);
	$presenca= $con2->fetch_array();		
}
else{
	
}?>
<?php if( $periodo !='' && $contador !=0) : ?>
<hr/>
	<table class='list_table_b'>
		<tr>
			<td colspan='10' class='table_title'>
				<span class='title_left'><?php echo $ordersData[0]['increment_id'] ?>Colaborador: <?php echo $name?>
				</span>
			</td>
			<td colspan='10' class='table_title'>Falta's: <?php echo $presenca["falta"];?></td>
			<td colspan="10" class='table_title'>Folga's: <?php echo $presenca["folga"];?></td>
			<td colspan='10' class='table_title'>Menor: <?php echo $menor."%"?></td>
			<td colspan='10' class='table_title'>Media: <?php echo round($totalAlcancado/($contador-$presenca["folga"]), 2)."%" ?></td>
			<td colspan='10' class='table_title'>Maior: <?php echo $maior."%"?></td>
		</tr>
	</table>	
	<table class='list_table_b'>	
	<tr>
		<th>Data</th>
		<th>Atividade</th>
		<?php if($presenca["folga"]>0 || $presenca["falta"]>0): ?><th>Presença</th><?php endif;?>
		<th>Desempenho</th>
		<th>Meta</th>
		<th>Alacançado</th>
		<th>Media</th>
	</tr>
<?php for( $i = 0; $i < sizeof($vetorAtividade); $i++ ) : ?>
	<tr <?php $registros=1; $t=$i;?> >
		<?php $somaAlcancado=null; $z=$i; $laco=false;
		while($vetorRegistro[$z]==$vetorRegistro[$z+1]){
			$registros++; 
			$repeat=$registros;
			if($laco==false){ $somaAlcancado=$somaAlcancado+$vetorAlcancado[$z]+$vetorAlcancado[$z+1];}
			else{$somaAlcancado=$somaAlcancado+$vetorAlcancado[$z+1];}
			$laco=true; $z=$z+1;
		}
		if($repeat>0){ $repeat--;}		 
		$somaAlcancado=($somaAlcancado/$registros);?>
		<?php if($registros>1 && $repeat!=0 && $mescla==false) : ?>
		<td rowspan='<?php echo $registros; ?>'><?php echo $vetorRegistro[$i]?></td>
		<?php $mescla=true; endif;  if($repeat==0 && $vetorRegistro[$i-1]!=$vetorRegistro[$i]) :?>
		<td><?php echo $vetorRegistro[$i];?></td><?php $mescla=false; endif;?>
		<td><?php echo $vetorAtividade[$i]?></td>
		<?php if($presenca["folga"]>0 || $presenca["falta"]>0): ?><td><?php if($vetorPresenca[$i]=="") echo "Presente"; else echo $vetorPresenca[$i]?></td><?php endif;?>			
		<td><?php echo $vetorDesempenho[$i]?></td>			
		<td><?php echo $vetorMeta[$i]?></td>
		<td><?php  echo $vetorAlcancado[$i]."%"?></td>
		<?php if($registros>1 && $repeat!=0 && $mesclaM==false) : ?><td rowspan='<?php echo $registros; ?>'><?php echo round($somaAlcancado,2)."%"; $mesclaM=true; endif;?></td><?php if($repeat==0 && $vetorRegistro[$i-1]!=$vetorRegistro[$i]) :?>
			<td></td><?php $mesclaM=false; endif;?>
		<?php if($vetorRegistro[$i]!=$vetorRegistro[$i+1] && $repeat==0){$mescla=false; $mesclaM=false;}?>						
	</tr>
<?php endfor; ?>
	</table>	
<?php endif; ?>	
<button id="go_top" onclick="$('body').scrollTop(0)" >Ir Ao Topo</button>
<div style='clear:both' ></div>
<div id='dialog_info' ></div>
<script>
	$('#submitQuery').button().click(function(){
		$('#form1').submit();
	});			
	$('.title_right input').button();
	$('#go_top').button().css('width','100%');
</script>
		
<?php	
}
setFooter();