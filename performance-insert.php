<?php

$menuAtivo = 'desempenho';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php'; </script>";
}

$dataSetada = $_POST['dataSetada'];
$totalAlcancado = 0;
$idAtividade = 0;
$idMeta = 0;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style type="text/css" src="css/personal.css"></style>
	<title>Gestão de Desempenho - Inserir Desempenho</title>
    <script type="text/javascript">		
		function changeFunc() {
		    var selectBox = document.getElementById("selectBox");
		    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
		    if(selectedValue==1){
		    	var inputs = $('input[type=checkbox]');
		    	inputs.attr('checked', true);
		  		inputs.prop('checked', true);		    		
		    }
		    else{
		    	var inputs = $('input[type=checkbox]');
		    	inputs.attr('checked', false);
		  		inputs.prop('checked', false);		    		
		    }		    
	    }
	    function limpaCampo(){
	    	document.getElementById('meta').value=''; // Limpa o campo
	    }
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
<?php if (!isset($_POST['query'])) { ?>
	<section class="section">
	<div class="container">		
	<form id="form1" action="performance-insert.php" method="POST" onsubmit="return check()">
		<div class="field">			
			<label class="label is-size-7-touch">Turno*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="turno" class="required">
						<option selected="selected" value="">Selecione</option><?php	
						$con = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM TURNO WHERE SITUACAO='Ativo'");
						while($turno = $con->fetch_array()){
							echo "<option value=" . $turno["ID"] . ">" . $turno["NOME"] . "</option>";
						} ?>	
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-clock"></i>
					</span>
				</div>
			</div>
		</div>	
		<div class="field">
			<label class="label is-size-7-touch">Setor*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="setor" class="required">
						<option selected="selected" value="">Selecione</option><?php	
						$con = mysqli_query($phpmyadmin , "SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'");
						while($setor = $con->fetch_array()){
							echo "<option value=" . $setor["ID"] . ">" . $setor["NOME"] . "</option>";
						}?>	
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-door-open"></i>
					</span>	
				</div>
			</div>
		</div>	
		<div class="field">
			<label class="label is-size-7-touch">Data*</label>
			<div class="control has-icons-left">
				<input type="text" class="input registro required" name="dataSetada" value="<?php echo date('Y-m-d',strtotime('-1 day'));?>">
				<span class="icon is-small is-left">
					<i class="fas fa-calendar-alt"></i>
				</span>
			</div>
		</div>	
		<div class="field-body"></div>
			<div class="field is-grouped">
				<div class="control">
					<button name="query" type="submit" class="button is-primary btn128" value="Filtrar">Filtrar</button>
				</div>
				<div class="control">
					<button name="clear" type="reset" class="button is-primary btn128" onClick="clearForm()">Limpar</button>
				</div>
			</div>
		</div>		
	</form>
	</div>
	</section>	
	<?php } ?>		
</div>
<?php

if ( isset($_POST['query'])) {
	

	$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM USUARIO WHERE TURNO_ID=".$_POST['turno']." AND SETOR_ID=".$_POST['setor']." AND SITUACAO='Ativo' ORDER BY NOME");

	$x = 0;
	while ($user = $cnx->fetch_array()) {
		$vtId[$x] = $user["ID"];
		$vtNome[$x] = $user["NOME"];					
		$x++;
	}

	if (mysqli_num_rows($cnx) == null) {
		echo "<script>alert('Nenhum usuário cadastrado no turno e setor selecionado!');	window.location.href=window.location.href; </script>";	
	}			
}

if ($x != 0 ) : ?>
<hr/>
	<form id="form2" action="performance-insert.php" method="POST">	
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th class="field ocultaColunaId">ID</th>
		<th>+</th>
		<th>Funcionário</th>
		<th>Presença</th>
		<th class="coluna">Atividade</th>		
		<th>Meta</th>
		<th>Alcançado</th>		
		<th>Data</th>
		<th>Observação</th>  			
	</tr><?php
 
	 for ( $i = 0; $i < sizeof($vtNome); $i++ ) {
		$result = 0; 
		//VERIFICA SE É SETOR COM METAS VARIADAS.
		$_SESSION["metaAdd"] = 1;
		$cx = mysqli_query($phpmyadmin, "SELECT M.META, A.NOME AS ATIVIDADE, M.ATIVIDADE_ID, M.DESCRICAO FROM META M INNER JOIN ATIVIDADE A ON A.ID=M.ATIVIDADE_ID WHERE USUARIO_ID=".$vtId[$i]." AND EXECUCAO='".$dataSetada."' AND DESEMPENHO=0 ORDER BY M.ID LIMIT 1");
		$defMeta = $cx->fetch_array();
		$result = mysqli_num_rows($cx);
		
		if ($result > 0) {			
			$idAtividade = $defMeta["ATIVIDADE_ID"];
		}

		?>
		<tr>
		<td><?php echo $i+1;?></td>
		<td class="field ocultaColunaId"><!--COLUNA ID-->
			<div class="field">				
				<div class="control">					
		  			<input name="id[]" id="teste3" type="text" class="is-size-7-touch" value="<?php echo $vtId[$i]?>">
		  		</div>
		  	</div>
		</td>
		<td class="field"><!--COLUNA VETOR-->
			<div class="field">				
				<div class="control">					
		  			<input name="vetor[]" id="teste3" type="checkbox" class="checkbox is-size-7-touch" checkbox="checked" value="<?php echo $i?>">
		  		</div>
		  	</div>
		</td>		
		<td class="field"><!--COLUNA NOME-->
			<div class="field">				
				<div class="control">
					<input name="nome[]" type="text" class="input is-size-7-touch" value="<?php echo $vtNome[$i]?>">
				</div>				
			</div>
		</td>		
		<td><!--SELEÇÃO PRESENÇA-->						
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select is-size-7-touch">
							<select name="presenca[]"><?php								
								$con = mysqli_query($phpmyadmin , "SELECT ID, NOME FROM PRESENCA WHERE SITUACAO ='Ativo'");
								while ($presenca = $con->fetch_array()) {
									echo "<option value=" . $presenca["ID"] . ">" . $presenca["NOME"] . "</option>";
								}
								?>																		
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</td>		
		<td><!--SELEÇÃO ATIVIDADE-->						
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select is-size-7-touch">
							<select name="atividade[]">
								<?php 
								if ($result > 0) {
									echo "<option selected='selected' value=" . $defMeta["ATIVIDADE_ID"] . ">" . $defMeta["ATIVIDADE"] . "</option>"; 
								}	
								$con = mysqli_query($phpmyadmin , "SELECT ID, NOME FROM ATIVIDADE WHERE SITUACAO='Ativo' AND ID<>".$idAtividade); 
								while ($atividade = $con->fetch_array()) {									
									echo "<option value=" . $atividade["ID"] . ">" . $atividade["NOME"] . "</option>";
								}
								?>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</td>
		<td><!--COLUNA META-->
			<div class="field">				
				<div class="control">
					<input name="meta[]" style="max-width:5.5em;" type="text" class="input desempenho is-size-7-touch" placeholder="Obrigatório" maxlength="4" value="<?php if($result==1){ echo $defMeta["META"];}?>">
				</div>				
			</div>
		</td>
		<td><!--COLUNA ALCANÇADO-->	
			<div class="field">				
				<div class="control">
					<input name="alcancado[]" style="max-width:5.5em;" type="text" class="input desempenho is-size-7-touch" placeholder="Obrigatório" maxlength="4">
				</div>				
			</div>
		</td>
		<td><!--COLUNA DATA-->
			<div class="field">				
				<div class="control">
					<input name="registro[]" style="max-width:6.5em;" type="text" class="input registro is-size-7-touch" value="<?php echo $dataSetada;?>" maxlength="10">
				</div>				
			</div>
		</td>
		<td><!--COLUNA OBSERVAÇÃO-->	
			<div class="field">				
				<div class="control">
					<input name="observacao[]" type="text" class="input is-size-7-touch" placeholder="Máximo 200 caracteres." maxlength="200" value="<?php if ($result == 1){ echo $defMeta["DESCRICAO"]; } ?>">
				</div>				
			</div>
		</td>						
		</tr>
	<?php } ?>
	</table>
	<a href="#topo">
		<div class="field is-grouped is-grouped-right">
			<button class="button is-primary is-fullwidth is-size-7-touch">Ir Ao Topo</button>		
		</div>
	</a>
	<br/>
	<div class="field is-grouped is-grouped-right">			
		<div class="field-label is-normal">
			<label for="turno" class="label">Inserção:</label>
		</div>
		<div class="field-body">
			<div class="field is-grouped">							
				<div class="control">
					<div class="select is-size-7-touch">
						<select name="inserir" id="selectBox" onchange="changeFunc();">									
							<option selected="selected" value="2">Específico</option>
							<option value="1">Todos</option>								
						</select>	
					</div>										
				</div>
			<div class="control">
				<input name="salvarDados" type="submit" class="button is-primary is-size-7-touch" value="Salvar Dados"/>
			</div>	
							
			<div class="control">
				<input name="clear" type="reset" class="button is-primary is-size-7-touch btn128"/ value="Limpar">
			</div>
			<div class="control">
				<a href="performance-insert.php" class="button is-primary is-size-7-touch btn128">Voltar</a>
			</div>							
		</div>
	</div>
	</form>	
<?php endif; ?>
</body>
</html>
<?php

if (isset($_POST['salvarDados']) && $_POST['id'] != null) {
	$ids = array_filter($_POST['id']);
	$pvt = array_filter($_POST['vetor']);
	$presencas = array_filter($_POST['presenca']);
	$atividades = array_filter($_POST['atividade']);
	$metas = array_filter($_POST['meta']);
	$alcancados = array_filter($_POST['alcancado']);	
	$registros = array_filter($_POST['registro']);
	$observacoes = $_POST['observacao'];
	
	$cnx = mysqli_query($phpmyadmin, "SELECT TURNO_ID FROM USUARIO WHERE ID=".$ids[0]."");
	$turnoResult = $cnx->fetch_array();
	$v = 0;//VARIÁVEL USADA PEGAR A REFERÊNCIA DO VETOR SELECIONADO P/ SALVAR A INFORMAÇÃO.
	
	for ( $i = 0; $i < sizeof($presencas); $i++ ) {
		if ($pvt[$v] == $i) {
			if ($presencas[$i] == 3 || $presencas[$i] == 5 ) {
				$desempenho = 0;
				$metas[$i] = 0;
				$alcancados[$i] = 0;

			} else if ($alcancados[$i] == 0 || $alcancados[$i] == null) {
				$desempenho = 0;
				$alcancados[$i] = 0;

			} else {
				$desempenho = round(($alcancados[$i] / $metas[$i]) * 100,2);	
			}

			$anoMes = new DateTime($registros[$i]);
			$anoMes = $anoMes->format('Y-m');
			
			$cnx = mysqli_query($phpmyadmin, "INSERT INTO DESEMPENHO(USUARIO_TURNO_ID, USUARIO_ID, ATIVIDADE_ID, PRESENCA_ID,META, ALCANCADO, DESEMPENHO, REGISTRO, ANO_MES, OBSERVACAO, CADASTRADO_POR, CADASTRADO_DATA) VALUES(".$turnoResult["TURNO_ID"].",".$ids[$i].",".$atividades[$i].",".$presencas[$i].",".$metas[$i].",".$alcancados[$i].",".$desempenho.",'".$registros[$i]."', '" . $anoMes . "', '".$observacoes[$i]."',".$_SESSION["userId"].",'".date('Y-m-d')."'); ");
			
			$erro = mysqli_error($phpmyadmin);
			$v++;
			
			if ($_SESSION["metaAdd"] == 1) {//VERIFICA E DAR BAIXA NA META CADASTRADA.
				$cnx2 = mysqli_query($phpmyadmin, "SELECT ID FROM META WHERE USUARIO_ID=".$ids[$i]." AND DESEMPENHO=0 AND EXECUCAO='".$registros[$i]."' ORDER BY ID LIMIT 1");			
				
				if (mysqli_num_rows($cnx2)>0) {
					$dowMeta = $cnx2->fetch_array();
					$cnx3 = mysqli_query($phpmyadmin, "UPDATE META SET DESEMPENHO=1 WHERE ID=".$dowMeta["ID"]);
				}
			}
		}
	}

	if ($erro == null) {
		$metaAdd = 0;
		echo "<script>alert('Desempenho cadastro com sucesso!'); window.location.href=window.location.href; </script>";
	} else {
		echo "<script>alert('Erro ao cadastrar Desempenho, campo Meta e/ou Alcançado vazio!!'); window.location.href=window.location.href; </script>";
	}

} else if (isset($_POST['salvarDados']) != null) {
	echo "<script>alert('Nenhum Checkbox foi selecionado p/ salvar!!'); window.location.href=window.location.href;</script>";
}
?>