<?php

$menuAtivo = 'desempenho';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php'; </script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style type="text/css" src="css/personal.css"></style>
	<title>Gestão de Desempenho - Atualizar Desempenho</title>
    <script type="text/javascript">
    	$(document).ready(function(){
	    	$(window).scroll(function(){
	        if ($(this).scrollTop() > 100) {
	            $('a[href="#topo"]').fadeIn();
	        }else {
	            $('a[href="#topo"]').fadeOut();
	        }
	    });
	    $('a[href="#topo"]').click(function(){
	        $('html, body').animate({scrollTop : 0},800);
	        return false;
	    });
	});
    </script>   
</head>
<body>
	<span id="topo"></span>
<div>	
	<?php if ($setor == "" && isset($_POST['query']) == null ): ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="report-update.php" method="POST" onsubmit="return check()">
		<div class="field">
			<label class="label is-size-7-touch">Mês*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth norequired">
			  		<select name="month" id="month" class="is-fullwidth norequired " autofocus>
						<option selected="selected" value="<?php echo date('Y-m')?>"><?php echo date('m/Y')?></option>
						<option value="<?php echo date('Y-m', strtotime("-1 months"))?>"><?php echo date('m/Y', strtotime("-1 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-2 months"))?>"><?php echo date('m/Y', strtotime("-2 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-3 months"))?>"><?php echo date('m/Y', strtotime("-3 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-4 months"))?>"><?php echo date('m/Y', strtotime("-4 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-5 months"))?>"><?php echo date('m/Y', strtotime("-5 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-6 months"))?>"><?php echo date('m/Y', strtotime("-6 months"))?></option>
					</select>
				</div>
				<span class="icon is-small is-left" >
				  	<i class="fas fa-calendar-alt"></i>
				</span>
			</div>
		</div>
		<div class="field">
			<label class="label is-size-7-touch">Setor*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth" id="sector3">
					<select name="sector" id="sector" class="norequired is-fullwidth "><?php
						$con = mysqli_query($phpmyadmin , "SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'");
						while ($sector = $con->fetch_array()) {
							echo "<option value=" . $sector["ID"] . ">". $sector["NOME"] . "</option>";
						}
						?>
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-door-open"></i>
					</span>
				</div>						
			</div>
		</div>								
		<div class="field">
			<label class="label is-size-7-touch">Nome*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth" id="name">
					<input name="name" type="text" onkeypress="addLoadField('name')" onkeyup="rmvLoadField('name')" class="input required" placeholder="Ana Clara" id="input3">
					<span class="icon is-left">
						<i class="fas fa-user-circle"></i>
					</span>
					<div id="msgOk3" style="display:none;"></div>	
				</div>
			</div>					
		</div>
		<div class="field-body is-fullwidth">
			<div class="field is-grouped is-fullwidth">
				<div class="control is-fullwidth">
					<button name="query" type="submit" class="button is-primary btn128" value="filter">Consultar</button>
				</div>
				<div class="control">
					<button name="clear" type="reset" class="button is-primary btn128" onclick="clearForm();">Limpar</button>
				</div>
			</div>
		</div>						
	</form>
	</div>
	</section>	
	<?php endif; ?>		
</div>
<?php

if ( isset($_POST['query'])) {

	$count = 0;
	$totalAlcancado = 0;	
	$query = "SELECT D.ID AS ID, U.NOME AS USUARIO, D.PRESENCA_ID AS PRESENCA_ID,P.NOME AS PRESENCA, D.ATIVIDADE_ID AS ATIVIDADE_ID, A.NOME AS ATIVIDADE, D.META, D.ALCANCADO AS ALCANCADO, D.DESEMPENHO, D.REGISTRO, D.OBSERVACAO FROM DESEMPENHO D INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID
		INNER JOIN PRESENCA P ON P.ID=D.PRESENCA_ID INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID WHERE SETOR_ID=".$_REQUEST['sector']." AND USUARIO_ID IN(SELECT ID FROM USUARIO WHERE NOME LIKE '%".$_REQUEST['name']."%')
		AND D.ANO_MES='".$_REQUEST['month']."';";
	
	$x = 0;
	$cnx = mysqli_query($phpmyadmin, $query);
	
	while($user= $cnx->fetch_array()){
		$vtId[$x] = $user["ID"];
		$name[$x] = $user["USUARIO"];
		$presenceId[$x] = $user["PRESENCA_ID"];
		$presence[$x] = $user["PRESENCA"];
		$activictyId[$x] = $user["ATIVIDADE_ID"];
		$activicty[$x] = $user["ATIVIDADE"];
		$goal[$x] = $user["META"];
		$reached[$x] = $user["ALCANCADO"];
		$performance[$x] = $user["DESEMPENHO"];
		$date[$x] = $user["REGISTRO"];
		$note[$x] = $user["OBSERVACAO"];					
		$x++;
		$count = $x;
	}

	if (mysqli_num_rows($cnx) == 0) {
		echo "<script>alert('Nenhum registrado encontrado nesta consulta!'); window.location.href=window.location.href; </script>";	
	}	
}
	
if (isset($_POST['query']) && $count != 0) : { ?>
<hr/>
<section class="section">
<form id="form2" action="report-update.php" method="POST">	
<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch is-striped is-narrow is-hoverable">	
	<tr>
		<th>N°</th>
		<th class="ocultaColunaId">ID</th>
		<th>*</th>
		<th style="border-left: -25px;">Funcionário</th>
		<th>Presença</th>
		<th>Atividade</th>		
		<th class="coluna">Meta</th>
		<th >Alcançado</th>			
		<th>Data</th>
		<th>Observação</th> 			
	</tr><?php 
	
	for ( $i = 0; $i < sizeof($name); $i++ ) : {
		$z = $i; 
		$registro = 1; 

		while ($name[$z] == $name[$z+1]) {
			$registro++;
			$repeat = $registro;
			$z++;
		}

		if ($repeat > 0) { 
			$repeat--;
		}

	?>
	<tr>
		<td><?php echo $i+1;?></td>
		
		<td class="field ocultaColunaId"><!--COLUNA ID-->
			<div class="field">
				<div class="control">
					<input name="id[]" type="input" class="is-size-7-touch" value="<?php echo $vtId[$i]?>" >
				</div>
			</div>
		</td>
		<td class="field "><!--COLUNA NUMBER-->
			<div class="field ">
				<div class="control">
					<input name="n[]" type="checkbox" class="checkbox is-size-7-touch" value="<?php echo $i?>" >
				</div>
			</div>
		</td>
		<td><!--COLUNA NOME-->
			<div class="field">
				<div class="control">
					<input type="text" class="input is-size-7-touch" value="<?php echo $name[$i]?>">
				</div>
			</div>
		</td>		
		<td><!--COLUNA PRESENÇA-->
			<div class="field">								
				<div class="control">
					<div class="select is-size-7-touch">
						<select name="presenca[]">
							<option selected="selected" value="<?php echo $presenceId[$i];?>"><?php echo $presence[$i];?></option><?php
							$con = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM PRESENCA WHERE SITUACAO='Ativo' AND ID<>".$presenceId[$i].";"); $x=0;
							while ($presenca = $con->fetch_array()) { 
								echo "<option value=" .  $presenca["ID"] . ">" . $presenca["NOME"] . "</option>";
							} 
							?>															
						</select>	
					</div>
				</div>					
			</div>
		</td>			
		<td class="field"><!--COLUNA ATIVIDADE-->
			<div class="field">
				<div class="control">
					<div class="select is-size-7-touch">
						<select name="atividade[]">
							<option selected="selected" value="<?php echo $activictyId[$i];?>"><?php echo $activicty[$i];?></option><?php
							$con = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM ATIVIDADE WHERE SITUACAO='Ativo' AND ID<>".$activictyId[$i].";");
							while($atividade = $con->fetch_array()) {
								echo "<option value=" . $atividade["ID"] . ">" . $atividade["NOME"] . "</option>";
							}?>															
						</select>	
					</div>
				</div>
			</div>
		</td>
		<td>
			<div class="field" style="max-width:5em;"><!--COLUNA META-->
				<div class="control">
					<input name="meta[]" type="text" class="input numero is-size-7-touch" value="<?php echo $goal[$i]?>">
				</div>							
			</div>
		</td>
		<td><!--COLUNA ALCANÇADO-->	
			<div class="field" style="max-width:5em;">
				<div class="control">
					<input name="alcancado[]" type="text" class="input numero is-size-7-touch" value="<?php echo $reached[$i]?>">
				</div>
			</div>
		</td>
		<td><!--COLUNA DATA-->	
			<div class="field" style="max-width:7em;">
				<div class="control">
					<input name="registro[]" type="text" class="input registro is-size-7-touch" value="<?php echo $date[$i]?>">
				</div>
			</div>
		</td>
		<td><!--COLUNA OBSERVACAO-->	
			<div class="field">
				<div class="control">
					<input name="observacao[]" type="text" class="input is-size-7-touch" value="<?php echo $note[$i]?>">
				</div>
			</div>
		</td>
	</tr>
<?php } endfor;?>
	</table>
	<a href="#topo">		
		<div class=".scrollWrapper">
			<button class="button is-primary" style="width: 100%; display: table;">Ir Ao Topo</button>		
		</div>
	</a>
	<br/>
	<div class="field-body">
		<div class="field is-grouped">
			<div class="control">
				<input name="alterarDados" type="submit" class="button is-primary" value="Alterar Dados"/>
			</div>												
			<div class="control">
				<input type="submit" class="button is-primary btn128" id="submitQuery" onClick="history.go(0)" value="Atualizar"/>						
			</div>
			<div class="control">
				<a href="report-update.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
			</div>
		</div>						
	</div>
</div>
</form>
</section>	
<?php } endif; ?>
</body>
</html>
<?php

if(isset($_POST['alterarDados'])){
	$n = array_filter($_POST['n']);//Armazena posição do vetor clicada p/ atualizar.
	$ids = array_filter($_POST['id']);
	$presencas = array_filter($_POST['presenca']);
	$atividades = array_filter($_POST['atividade']);
	$metas = array_filter($_POST['meta']);
	$alcancados = array_filter($_POST['alcancado']);	
	$registros = array_filter($_POST['registro']);
	$observacoes = array_filter($_POST['observacao']);
	$upCount = 0;

	for ( $i = 0; $i < sizeof($n); $i++ ) {
		if ($alcancados[$n[$i]] == null) {//A função array_filter setar null quando o dado é zero.
			$alcancados[$n[$i]] = 0;
		}
			
		if ($metas[$n[$i]] == null ) {//A função array_filter setar null quando o dado é zero.
			$metas[$n[$i]] = 0;
		}

		if ($presencas[$n[$i]] == 3 || $presencas[$i] == 5) {//CASO SEJA FOLGA/TREINAMENTO SETA 0.
			$desempenho = 0;
			$metas[$n[$i]] = 0;
			$alcancados[$n[$i]] = 0;
		} elseif ($alcancados[$n[$i]] == 0 || $alcancados[$n[$i]] == null) {
			$desempenho = 0;
			$alcancados[$n[$i]] = 0;
		} else {
			$desempenho = round(($alcancados[$n[$i]] / $metas[$n[$i]]) * 100,2);
		}

		$cnx = mysqli_query($phpmyadmin, "UPDATE DESEMPENHO SET ATIVIDADE_ID=".$atividades[$n[$i]].", PRESENCA_ID=".$presencas[$n[$i]].",META=".$metas[$n[$i]].", ALCANCADO=".$alcancados[$n[$i]].", DESEMPENHO=".$desempenho.", REGISTRO='".$registros[$n[$i]]."', OBSERVACAO='".$observacoes[$n[$i]]."',ATUALIZADO_POR=".$_SESSION["userId"].", ATUALIZADO_DATA='".date('Y-m-d')."' WHERE ID=".$ids[$n[$i]].";");
			
		$upCount = $upCount+1;
	}

	if ($upCount == 0) {	
		echo "<script>alert('Nenhum registro clicado na coluna * p/ ser atualizado!!'); window.location.href=window.location.href;	</script>";
	} else {
		echo "<script>alert('Foi atualizado " . $upCount . " registro(s)!!'); window.location.href=window.location.href; </script>";
	}

}

?>