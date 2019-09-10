<style type="text/css">
	/*$table-cell-padding: .75rem !default; $table-sm-cell-padding: .3rem !default; $table-bg: transparent !default; $table-bg-accent: rgba(0,0,0,.05) !default; $table-bg-hover: rgba(0,0,0,.075) !default; $table-bg-active: $table-bg-hover !default; $table-border-width: $border-width !default; $table-border-color: $gray-lighter !default;*/
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
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">
    <meta charset="UTF-8">   
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
	<?php if($turno =="" && isset($_POST['salvarDados'])==null ): ?>
	<section class="section">
	<div class="container">		
	<form id="form1" action="" method="POST">
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
									<option value="<?php echo $vtId[$x] = $turno["ID"]; ?>"><?php echo $vtNome[$x] = utf8_encode($turno["NOME"]); ?></option>
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
										<option value="<?php echo $vtId[$x] = $setor["ID"]; ?>"><?php echo $vtNome[$x] = utf8_encode($setor["NOME"]); ?></option>
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
							<button name="consultar" type="submit" class="button is-primary" value="Filtrar">Filtrar</button>
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
	$query="SELECT ID, NOME FROM USUARIO WHERE TURNO_ID=".$turno." AND SETOR_ID=".$setor." AND SITUACAO='Ativo'";
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
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">	
	<tr>
		<th>N°</th>
		<th class="ocultaColunaId">ID</th>
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
					<input name="id[]" type="text" class="input" value="<?php echo $vtId[$i]?>">
				</div>				
			</div>
		</td>
		<td class="field"><!--COLUNA NOME-->
			<div class="field">				
				<div class="control">
					<input name="nome[]" type="text" class="input" value="<?php echo utf8_encode($vtNome[$i])?>">
				</div>				
			</div>
		</td>		
		<td><!--SELEÇÃO PRESENÇA-->						
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="presenca[]">								
								<?php $con = mysqli_query($phpmyadmin , $gdPresenca);
								$x=0; 
								while($presenca = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $presenca["ID"]; ?>"><?php echo $vtNome[$x] = utf8_encode($presenca["NOME"]); ?></option>
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
						<div class="select">
							<select name="atividade[]">
								<?php $con = mysqli_query($phpmyadmin , $gdAtividade);
								$x=0; 
								while($atividade = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $atividade["ID"]; ?>"><?php echo $vtNome[$x] = utf8_encode($atividade["NOME"]); ?></option>
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
					<input name="meta[]" style="max-width:5.5em;" type="text" class="input desempenho" placeholder="Obrigatório" id="telefone" maxlength="4">
				</div>				
			</div>
		</td>
		<td><!--COLUNA ALCANÇADO-->	
			<div class="field">				
				<div class="control">
					<input name="alcancado[]" style="max-width:5.5em;" type="text" class="input desempenho" placeholder="Obrigatório" maxlength="4">
				</div>				
			</div>
		</td>
		<td><!--COLUNA DATA-->
			<div class="field">				
				<div class="control">
					<input name="registro[]" style="max-width:6.5em;" type="text" class="input registro" value="<?php echo date('Y-m-d');?>" maxlength="10">
				</div>				
			</div>
		</td>
		<td><!--COLUNA OBSERVAÇÃO-->	
			<div class="field">				
				<div class="control">
					<input name="observacao[]" type="text" class="input" placeholder="Máximo 200 caracteres." maxlength="200">
				</div>				
			</div>
		</td>						
	</tr>
<form>	
<?php endfor;?>
	</table>
	<a href="#topo">
		<div class="field is-grouped is-grouped-right">
			<button class="button is-primary is-fullwidth">Ir Ao Topo</button>		
		</div>
	</a>
	<br/>
	<form id="form1" action="" method="POST" >
		<div class="field is-grouped is-grouped-right">			
			<!--SELEÇÃO TURNO-->
			<div class="field-label is-normal">
				<label for="turno" class="label">Inserção:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="inserir">
								<option selected="selected" value="todos">Todos</option>	
								<option value="especifico">Específico</option>								
							</select>	
						</div>
						<!--<div class="control">-->
						<!--<button type="submit" class="button is-primary">Filtrar</button>-->
						<input type="submit" class="button is-primary" id="submitQuery" value="Atualizar"/>						
					</div>
					<div class="control">
						<a href="report-insert.php" class="button">Voltar</a>
					</div>
					<div class="control">
						<input name="Limpar" type="submit" class="button is-primary" onClick="history.go(0)" value="Limpar"/>
					</div>
					<input name="salvarDados" type="submit" class="button is-primary" id="submitQuery" value="Salvar Dados"/>
				</div>						
			</div>
		</div>
	</form>	
<?php endif; ?>
</body>
</html>
<?php
if(isset($_POST['salvarDados'])){
	$ids= array_filter($_POST['id']);
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
	for( $i = 0; $i < sizeof($atividades); $i++ ){
		if($alcancados[$i]==0 || $alcancados[$i]==null){
			$desempenho=0;
			$alcancados[$i]=0;
		}
		else{
			$desempenho=round(($alcancados[$i]/$metas[$i])*100,2);	
		}	
		$inserirDesempenho="INSERT INTO DESEMPENHO(USUARIO_TURNO_ID, USUARIO_ID, ATIVIDADE_ID, PRESENCA_ID,META, ALCANCADO, DESEMPENHO, REGISTRO, OBSERVACAO, CADASTRADO_POR) VALUES(".$turno.",".$ids[$i].",".$atividades[$i].",".$presencas[$i].",".$metas[$i].",".$alcancados[$i].",".$desempenho.",'".$registros[$i]."','".$observacoes[$i]."',".$_SESSION["userId"]."); ";		
		$cnx=mysqli_query($phpmyadmin, $inserirDesempenho);			 
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
	//header("Location: /gestaodesempenho/report-insert.php");	
}
?>