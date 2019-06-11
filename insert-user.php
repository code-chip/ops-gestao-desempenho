<?php
session_start();
include('conexao.php');
//require_once('js/loader.js');
include('verifica_login.php');
$menuConfiguracoes="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$turno = trim($_REQUEST['turno']);
$nome = trim($_REQUEST['nome']);
$efetivacao = trim($_REQUEST['efetivacao']);
$situacao = trim($_REQUEST['situacao']);
$contador = 0;
$totalAlcancado=0;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Cadastrar Usuário</title>
</head>
<body>
<div>	
	<section class="section">
		<div class="container">
			<h3 class="title">Cadastro de Usuário</h3>
		<hr>
	<main>
	<form id="form1" action="insert-user.php" method="GET">
		<div class="field">
			<label class="label" for="textInput">Nome completo</label>
				<div class="control">
					<input type="text" class="input" id="textInput" placeholder="Ana Clara">
				</div>			
		</div>
		<div class="field">
			<label class="label" for="numberInput">Login</label>
				<div class="control">
					<input type="text" class="input" id="textInput" placeholder="ana.clara">
				</div>
			<p class="help">Use de preferência texto caixa baixa, primeiro e último nome p/ manter a padronização de nome de login.</p>
		</div>
		<div class="field">
			<label class="label" for="numberInput">Senha</label>
				<div class="control">
					<input type="password" class="input" id="textInput" placeholder="">
				</div>			
		</div>
		<div class="field">
			<label class="label" for="numberInput">E-mail</label>
				<div class="control">
					<input type="text" class="input" id="textInput" placeholder="anaclara@gmail.com">
				</div>			
		</div>
		<!--DIVISÃO EM HORIZONTAL-->
			<div class="field is-horizontal">
			<!--SELEÇÃO CARGO-->
			<div class="field-label is-normal">
				<label class="label" for="periodo">Cargo:</label>
			</div>
			<div class="field-body">
			<div class="field is-grouped">							
				<div class="control">
					<div class="select">
						<select name='periodo'>
							<option value="Operador de Logística 1">Operador de Logística 1</option>
							<option value="Operador de Logística 1">Operador de Logística 2</option>
							<option value="Operador de Logística 1">Operador de Logística 3</option>
							<option value="Operador de Logística 1">Auxiliar Administrativo</option>
							<option value="Operador de Logística 1">Assistente Administrativo</option>
							<option value="Operador de Logística 1">Líder de Operação</option>
							<option value="Operador de Logística 1">Assistente de Logística</option>
							<option value="Operador de Logística 1">Analista Administrativo</option>
							<option value="Operador de Logística 1">Analista de Logística</option>
							<option value="Operador de Logística 1">Supervisor de Operação</option>	
							<option value="Operador de Logística 1">RH</option>	
							<option value="Operador de Logística 1">Gerente de CD</option>								
						</select>	
					</div>
				</div>
			</div>
			</div>
			<!--SELEÇÃO TURNO-->
			<div class="field-label is-normal">
				<label class="label">Turno</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="turno">
								<option selected="selected" value="">Selecione</option>	
								<option value="matutino">Matutino</option>
								<option value="vespetino">Vespetino</option>
								<option value="comercial">Comercial</option>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<!--FINAL DIVISÃO EM HORIZONTAL-->
			<div class="field-label is-normal">
				<label class="label">Gestor</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="turno">
								<option selected="selected" value="">Selecione</option>	
								<option value="matutino">Raphael Souza</option>
								<option value="vespetino">Marivalda</option>
								<option value="comercial">Pedro Becali</option>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<!--DIVISÃO SITUAÇÃO-->
			<div class="field-label is-normal">
				<label class="label">Situação</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="turno">
								<option selected="selected" value="">Ativo</option>	
								<option value="matutino">Férias</option>
								<option value="vespetino">Licença</option>
								<option value="comercial">Desligado</option>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<!--FINAL DIVISÃO EM HORIZONTAL-->
		</div>	
		<!---->		
		<div class="field">
			<label class="label" for="numberInput">Observação</label>
				<div class="control">
					<input type="text" class="input" id="textInput" placeholder="Operador temporário...">
				</div>			
		</div>
			<div class="field">
				<div class="control">
					<button type="submit" class="button is-primary" id="submitQuery">Cadastrar</button>
				</div>
			</div>				
		</form>
		<!--FINAL DO FORMULÁRIO-->
	</main>	
</div>
</section>
</div>


</body>
</html>


<!--<?php
/*if( $turno != "" && $nome !="" && $data !=""){	
	$query="INSERT INTO desempenho (nome, turno, registro) VALUES('".$nome."','."$turno".',"$data")";	
	$ajusteBD="set global sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';";
	$ajustes= mysqli_query($phpmyadmin, $ajusteBD);
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query); //or die($mysqli->error);
	while($operadores= $cnx->fetch_array()){
		$vtNome[$x]=$operadores["nome"];
		$contador=$x;		
		$x++;
	}	
}	
?>*/

