<style type="text/css">
	.coluna{
		max-width:7em;
	}
</style>
<?php
session_start();
include('connection.php');
//require_once('js/loader.js');
include('login-check.php');
$menuDesempenho="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$turno = trim($_POST['turno']);
$setor= trim($_REQUEST['setor']);
$contador = 0;
$totalAlcancado=0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Inserir Desempenho</title>
	<meta charset="UTF-8">
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">    
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
	<?php
	/*CONSULTAS PARA CARREGAS AS OPÇÕES DE SELEÇÃO DO CADASTRO.*/	
	$gdTurno="SELECT ID, NOME FROM TURNO WHERE SITUACAO='Ativo'";
	$gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'";	
	?>
	<br/>
	<span id="topo"></span>
<div>	
	<?php if($turno =="" && isset($_POST['salvarDados'])==null): ?>
	<section class="section">
	<div class="container">		
	<form id="form1" action="" method="POST" onSubmit="(return(preencheCheckbox())">
		<div class="field is-horizontal">			
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Turno:</label>
				</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select name="turno">
								<option selected="selected" value="">Selecione</option>	
								<?php $con = mysqli_query($phpmyadmin , $gdTurno);
								$x=0; 
								while($turno = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $turno["ID"]; ?>"><?php echo $vtNome[$x] = $turno["NOME"]; ?></option>
								<?php $x;} endwhile;?>	
							</select>
							</div>&nbsp&nbsp&nbsp
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Setor:</label>
				</div>
				<div class="field-body">
					<div class="field">							
						<div class="control">
							<div class="select">
								<select name="setor">
									<option selected="selected" value="">Selecione</option>	
									<?php $con = mysqli_query($phpmyadmin , $gdSetor);
									$x=0; 
									while($setor = $con->fetch_array()):{?>
										<option value="<?php echo $vtId[$x] = $setor["ID"]; ?>"><?php echo $vtNome[$x] = $setor["NOME"]; ?></option>
									<?php $x;} endwhile;?>	
								</select>	
							</div>
						</div>						
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label"></div>
				<div class="field-body">
					<div class="field">
						<div class="control">
							<button name="consultar" type="submit" class="button is-primary" onClick=""value="Filtrar">Filtrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</form>
	</div>
	</section>	
	<?php endif; ?>		
</div>
<?php
if( $turno != "" && $setor != ""){	
	$query="SELECT ID, NOME FROM USUARIO WHERE TURNO_ID=".$turno." AND SETOR_ID=".$setor." AND SITUACAO='Ativo' ORDER BY NOME";
	$ajusteBD="set global sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';";
	$ajustes= mysqli_query($phpmyadmin, $ajusteBD);
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($operadores= $cnx->fetch_array()){
		$vtId[$x]=$operadores["ID"];
		$vtNome[$x]=$operadores["NOME"];					
		$x++;
		$contador=$x;
	}
	if(mysqli_num_rows($cnx)==null){
		?><script type="text/javascript">
			alert('Nenhum usuário cadastrado no turno e setor selecionado!');
			window.location.href=window.location.href;
		</script> <?php		
	}			
}
$gdPresenca="SELECT ID, NOME FROM PRESENCA WHERE SITUACAO='Ativo'";
$gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'";
$gdAtividade="SELECT ID, NOME FROM ATIVIDADE WHERE SITUACAO='Ativo'";	
?>
<!--FINAL DO FORMULÁRIO DE FILTRAGEM-->
<?php if($contador !=0) : ?>
<hr/>
	<form id="form2" action="" method="POST">	
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th class="field ocultaColunaId">ID</th>
		<th>+</th>
		<th>Funcionário</th>
		<th>Presença</th>
		<th>Atividade</th>		
		<th class="coluna">Meta</th>
		<th>Alcançado</th>		
		<th>Data</th>
		<th>Observação</th>  			
	</tr>
<?php for( $i = 0; $i < sizeof($vtNome); $i++ ) : ?>
	<?php $z=$i; $registro=1; while($vtNome[$z]==$vtNome[$z+1]){
		$registro++;
		$repeat=$registro;
		$z++;
	}
	if($repeat>0){ $repeat--;}	
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
							<select name="presenca[]">								
								<?php $con = mysqli_query($phpmyadmin , $gdPresenca);
								$x=0; 
								while($presenca = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $presenca["ID"]; ?>"><?php echo $vtNome[$x] = $presenca["NOME"]; ?></option>
								<?php $x;} endwhile;?>																		
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
								<?php $con = mysqli_query($phpmyadmin , $gdAtividade);
								$x=0; 
								while($atividade = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $atividade["ID"]; ?>"><?php echo $vtNome[$x] = $atividade["NOME"]; ?></option>
								<?php $x;} endwhile;?>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</td>
		<td><!--COLUNA META-->
			<div class="field">				
				<div class="control">
					<input name="meta[]" style="max-width:5.5em;" type="text" class="input desempenho is-size-7-touch" placeholder="Obrigatório" maxlength="4">
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
					<input name="registro[]" style="max-width:6.5em;" type="text" class="input registro is-size-7-touch" value="<?php echo date('Y-m-d',strtotime('-1 day'));?>" maxlength="10">
				</div>				
			</div>
		</td>
		<td><!--COLUNA OBSERVAÇÃO-->	
			<div class="field">				
				<div class="control">
					<input name="observacao[]" type="text" class="input is-size-7-touch" placeholder="Máximo 200 caracteres." maxlength="200">
				</div>				
			</div>
		</td>						
	</tr>
<?php endfor; 
	echo "<script type='text/javascript'>
		alert('Clique no Checkbox da coluna + ou Selecione a opção Todos em Inserção p/ SALVAR.');
		</script>";
	?>
	</table>
	<a href="#topo">
		<div class="field is-grouped is-grouped-right">
			<button class="button is-primary is-fullwidth">Ir Ao Topo</button>		
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
					<div class="select">
						<select name="inserir" id="selectBox" onchange="changeFunc();">									
							<option selected="selected" value="2">Específico</option>
							<option value="1">Todos</option>								
						</select>	
					</div>										
				</div>
			<div class="control">
				<a href="report-insert.php" class="button">Voltar</a>
			</div>					
			<div class="control">
				<input name="Limpar" type="button" class="button is-primary" onClick="preencheCheckbox()" value="Limpar"/>
			</div>
			<div class="control">
				<input name="salvarDados" type="submit" class="button is-primary" id="submitQuery" value="Salvar Dados"/>
			</div>						
		</div>
	</div>
	</form>	
<?php endif; ?>
</body>
</html>
<?php
if(isset($_POST['salvarDados']) && $_POST['id']!=null){
	$ids= array_filter($_POST['id']);
	$pvt= array_filter($_POST['vetor']);
	$presencas = array_filter($_POST['presenca']);
	$atividades = array_filter($_POST['atividade']);
	$metas = array_filter($_POST['meta']);
	$alcancados= array_filter($_POST['alcancado']);	
	$registros = array_filter($_POST['registro']);
	$observacoes= $_POST['observacao'];
	//CHECK TURNO
	$checkTurno="SELECT TURNO_ID FROM USUARIO WHERE ID=".$ids[0]."";
	$cnx= mysqli_query($phpmyadmin, $checkTurno);
	$turnoresult=$cnx->fetch_array();
	$turno=$turnoresult["TURNO_ID"];
	$v=0;//VARIÁVEL USADA PEGAR A REFERÊNCIA DO VETOR SELECIONADO P/ SALVAR A INFORMAÇÃO.
	for( $i = 0; $i < sizeof($presencas); $i++ ){
		if($pvt[$v]==$i){
			if($alcancados[$i]==0 || $alcancados[$i]==null){
				$desempenho=0;
				$alcancados[$i]=0;
			}
			else{
				$desempenho=round(($alcancados[$i]/$metas[$i])*100,2);	
			}				
			$inserirDesempenho="INSERT INTO DESEMPENHO(USUARIO_TURNO_ID, USUARIO_ID, ATIVIDADE_ID, PRESENCA_ID,META, ALCANCADO, DESEMPENHO, REGISTRO, OBSERVACAO, CADASTRADO_POR) VALUES(".$turno.",".$ids[$i].",".$atividades[$i].",".$presencas[$i].",".$metas[$i].",".$alcancados[$i].",".$desempenho.",'".$registros[$i]."','".$observacoes[$i]."',".$_SESSION["userId"]."); ";
			$cnx=mysqli_query($phpmyadmin, $inserirDesempenho);
			$v++;
		}

	}	
	if(mysqli_error($phpmyadmin)==null){	
		?><script type="text/javascript">
			alert('Desempenho cadastro com sucessos');
			window.location.href=window.location.href;		
		</script><?php
	}
	else{
		?><script type="text/javascript">
			alert('Erro ao cadastrar Desempenho, campos Meta e/ou Alcançado não pode estar vazio!!');
			window.location.href=window.location.href;
		</script><?php
	}
}
else if(isset($_POST['salvarDados'])!=null){
	?><script type="text/javascript">
		alert('Nenhum Checkbox foi selecionado p/ salvar!!');
		window.location.href=window.location.href;
	</script><?php
}
?>