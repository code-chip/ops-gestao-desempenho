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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script language="Javascript">
		function validacaoEmail(field) {
		usuario = field.value.substring(0, field.value.indexOf("@"));
		dominio = field.value.substring(field.value.indexOf("@")+ 1, field.value.length);
		if ((usuario.length >=1) &&
		    (dominio.length >=3) && 
		    (usuario.search("@")==-1) && 
		    (dominio.search("@")==-1) &&
		    (usuario.search(" ")==-1) && 
		    (dominio.search(" ")==-1) &&
		    (dominio.search(".")!=-1) &&      
		    (dominio.indexOf(".") >=1)&& 
		    (dominio.lastIndexOf(".") < dominio.length - 1)) {
		document.getElementById("msgemail").innerHTML="E-mail válido";
		//alert("email valido");
		}
		else{
		document.getElementById("msgemail").innerHTML="<font color='red'>Email inválido </font>";
		alert("E-mail invalido");
		}
		}
	</script>
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
				<div class="control has-icons-left has-icons-right">
					<input name="login" class="input" type="text" id="textInput" placeholder="ana.clara">				
					<span class="icon is-small is-left">
				      	<i class="fas fa-user"></i>
				    </span>
				    <span class="icon is-small is-right">
				      	<i class="fas fa-check"></i>
				    </span>
				</div>    
			<p class="help">Use de preferência texto caixa baixa, primeiro e último nome p/ manter a padronização de nome de login.</p>
		</div>
		<!--<div class="field">
		  	<label class="label">Username</label>
		  		<div class="control has-icons-left has-icons-right">
		    		<input class="input is-success" type="text" placeholder="Text input" value="bulma">
		    		<span class="icon is-small is-left">
		      			<i class="fas fa-user"></i>
		    		</span>
		    		<span class="icon is-small is-right">
		      			<i class="fas fa-check"></i>
		    		</span>
		  		</div>
		  	<p class="help is-success">This username is available</p>
		</div>-->
		<div class="field">
			<label class="label" for="numberInput">Senha</label>
				<div class="control">
					<input name="senha" type="password" class="input" id="textInput" placeholder="">
				</div>			
		</div>
		<div class="field">
		  	<label class="label">Email</label>
		  	<div class="control has-icons-left has-icons-right">
		    	<input name="email" class="input is-danger" type="text" placeholder="anaclara@gmail.com" value="" onblur="validacaoEmail(form1.email)"  maxlength="60" size='65'>
		    	<span class="icon is-small is-left">
		      		<i class="fas fa-envelope"></i>
		    	</span>
		    	<span class="icon is-small is-right">
		      		<i class="fas fa-exclamation-triangle"></i>
		    	</span>		    	
		    	<div id="msgemail"></div>
		  	</div>
		  	<p class="help is-danger">E-mail inválido</p>
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
								<option value="vespetino">Marivalda Souza</option>
								<option value="vespetino">Lucas Souza</option>
								<option value="vespetino">Monara Marim</option>
								<option value="comercial">Pedro Becali</option>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<!--SELEÇÃO SETOR-->
			<div class="field-label is-normal">
				<label class="label">Setor</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="setor">
								<option selected="selected" value="">Operação</option>	
								<option value="matutino">Administrativo</option>
								<option value="vespetino">Recebimento</option>
								<option value="comercial">Expedição</option>
								<option value="comercial">Devolução</option>
								<option value="comercial">Avarias</option>
							</select>	
						</div>
					</div>					
				</div>						
			</div>		
		</div><!--FINAL DIVISÃO EM HORIZONTAL-->	
		<!--DIVISÃO EM HORIZONTAL 2-->
		<div class="field is-horizontal">			
			<!--CAMPO MATRICULA-->
			<div class="field-label is-normal">
				<label class="label" for="periodo">Matricula:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:8em;">
						<input type="text" class="input" id="textInput" placeholder="635">
					</div>
				</div>
			</div>
			<!--CAMPO EFETIVADO-->
			<div class="field-label is-normal">
				<label class="label" for="periodo">Efetivação:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:7em;">
						<input type="text" class="input" id="textInput" placeholder="2019-05-29">
					</div>
				</div>
			</div>
			<!--CAMPO DATA E HORA DE CADASTRO-->
			<div class="field-label is-normal">
				<label class="label" for="periodo">Cadastrado:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">
					<fieldset disabled>								
					<div class="control" style="max-width:11em;">
						<input type="text" class="input" id="textInput" value="<?php echo date('Y-m-d H:i:s')?>">
					</div>
					</fieldset>
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
		</div><!--FINAL DIVISÃO EM HORIZONTAL 2-->	
		<!---->
					
		<div class="field">
			<label class="label" for="numberInput">Observação</label>
				<div class="control">
					<input type="text" class="input" id="textInput" placeholder="Exemplo: funcionário terceirizado da empresa MWService...">
				</div>			
		</div>
			<div class="field">
				<div class="control">
					<button type="submit" class="button is-primary" id="submitQuery">Cadastrar</button>
				</div>
			</div>				
		</form>
		<!--FINAL DO FORMULÁRIO-->
		<!--<form name="f1">
			<h3> Validação de E-mail com JavaScript</h3>
			<hr color='gray'>
			<table>
				<tr>
				<td>E-mail:
					<input type="text" name="email" onblur="validacaoEmail(f1.email)"  maxlength="60" size='65'>
				</td>
				<td>
				<div id="msgemail"></div>
				</td>
				</tr>
			</table>
			<hr color='gray'>
		</form>-->
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

