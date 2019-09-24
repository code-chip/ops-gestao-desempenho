<?php
$menuRelatorio="is-active";
include('menu.php');
$periodo = trim($_REQUEST['periodo']);
$idUsuario = trim($_REQUEST['idUsuario']);
$contador=0;
$totalAlcancado=0;
if( $_SESSION["permissao"]!=1 ){
	$consulta="SELECT U.NOME AS NOME, A.NOME AS ATIVIDADE, P.NOME AS PRESENCA, D.META AS META, D.ALCANCADO AS ALCANCADO, D.DESEMPENHO AS DESEMPENHO, D.REGISTRO AS REGISTRO, D.OBSERVACAO, D.PRESENCA_ID FROM DESEMPENHO D
	INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID
	INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID
	INNER JOIN PRESENCA P ON P.ID=D.PRESENCA_ID
	WHERE D.USUARIO_ID=".$idUsuario." AND REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20' ORDER BY REGISTRO;";
	$con = mysqli_query($phpmyadmin , $consulta);	
	$x=0; $menor=1000; $maior=0;
	while($dado = $con->fetch_array()){
		$vetorNome[$x] = $dado["NOME"];	
		$vetorAtividade[$x] = $dado["ATIVIDADE"];
		$vetorPresenca[$x] = $dado["PRESENCA"];
		$vetorDesempenho[$x] = $dado["ALCANCADO"];
		$vetorMeta[$x] = $dado["META"];
		$vetorAlcancado[$x] = $dado["DESEMPENHO"];
		$totalAlcancado=$totalAlcancado+$dado["DESEMPENHO"];
		$vetorRegistro[$x] = $dado["REGISTRO"];
		$vetorObservacao[$x] = $dado["OBSERVACAO"];					
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
	$consulta2="SELECT (SELECT COUNT(*) FROM DESEMPENHO WHERE USUARIO_ID=".$idUsuario."  AND PRESENCA_ID=2 AND REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20')AS FALTA, COUNT(*) AS FOLGA FROM DESEMPENHO WHERE USUARIO_ID=".$idUsuario."  AND PRESENCA_ID=3 AND REGISTRO>=DATE_SUB('".$periodo."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$periodo."-20';";
	$con2= mysqli_query($phpmyadmin,$consulta2);
	$presenca= $con2->fetch_array();		
}
else{
	echo "<script>alert('Usuário sem permissão para este acesso!!')</script>";
}?>
<?php if( $periodo !='' && $contador !=0) : ?>
<hr/>
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		<tr>
			<td >
				<span class='title_left'>Colaborador: <?php echo $vetorNome[0];?></span>
			</td>
			<td>Falta's: <?php echo $presenca["FALTA"];?></td>
			<td>Folga's: <?php echo $presenca["FOLGA"];?></td>
			<td>Menor: <?php if($totalAlcancado>0){echo $menor."%";}else{echo"0%";}?></td>
			<td>Media: <?php if($totalAlcancado>0){echo round($totalAlcancado/($contador-$presenca["FOLGA"]), 2)."%";}else{echo"0%";} ?></td>
			<td>Maior: <?php echo $maior."%"?></td>
		</tr>
	</table>	
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">	
	<tr>
		<th>Data</th>
		<th>Atividade</th>
		<?php if($presenca["FOLGA"]>0 || $presenca["FALTA"]>0): ?><th>Presença</th><?php endif;?>
		<th>Meta</th>
		<th>Alcançado</th>
		<th>Desempenho</th>
		<th>Media</th>
		<th>Observação</th>
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
			<?php if($presenca["FOLGA"]>0 || $presenca["FALTA"]>0): ?><td><?php if($vetorPresenca[$i]=="") echo "Presente"; else echo $vetorPresenca[$i]?></td><?php endif;?>
			<td><?php echo $vetorMeta[$i]?></td>
			<td><?php echo $vetorDesempenho[$i]?></td>
			<td><?php  echo $vetorAlcancado[$i]."%"?></td>
			<?php if($registros>1 && $repeat!=0 && $mesclaM==false) : ?><td rowspan='<?php echo $registros; ?>'><?php echo round($somaAlcancado,2)."%"; $mesclaM=true; endif;?></td><?php if($repeat==0 && $vetorRegistro[$i-1]!=$vetorRegistro[$i]) :?>
				<td></td><?php $mesclaM=false; endif;?>
			<?php if($vetorRegistro[$i]!=$vetorRegistro[$i+1] && $repeat==0){$mescla=false; $mesclaM=false;}?>
			<td><?php  echo $vetorObservacao[$i]?></td>	
		</tr>
	<?php endfor; ?>
	</table>	
<?php endif; ?>