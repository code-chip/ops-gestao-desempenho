<?php
session_start();
include('connection.php');
include('login-check.php');
$menuConfiguracoes="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$nome = trim($_REQUEST['nome']);
$login = trim($_REQUEST['login']);
$senha = trim($_REQUEST['senha']);
$email = trim($_REQUEST['email']);
$cargo = trim($_REQUEST['cargo']);
$turno = trim($_REQUEST['turno']);
$gestor = trim($_REQUEST['gestor']);
$setor = trim($_REQUEST['setor']);
$matricula = trim($_REQUEST['matricula']);
$efetivacao = trim($_REQUEST['efetivacao']);
$permissao = trim($_REQUEST['permissao']);
$situacao = trim($_REQUEST['situacao']);
$observacao = trim($_REQUEST['observacao']);
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
	<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <script language="javascript">
	    $(document).ready(function () {
	        $('.mascara-data').mask('9999-99-99');
	        $('#mascara-numero').mask('9999');
	        return false;
	    });
    </script>
</head>
<body>
<?php/*CONSULTAS PARA CARREGAR AS OPÇÕES DE SELEÇÃO DO CADASTRO.*/	
	$gdGestor="SELECT ID, NOME FROM GESTOR WHERE SITUACAO='Ativo'";
	$gdTurno="SELECT ID, NOME FROM TURNO WHERE SITUACAO='Ativo'";
	$gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'";				
?>
<div>	
	<section class="section">
		<div class="container">
			<h3 class="title">Cadastro de Usuário</h3>
		<hr>
	<main>
	<form id="form1" action="user-insert.php" method="GET">
		<div class="field">
			<label class="label" for="textInput">Nome completo</label>
				<div class="control">
					<input name="nome" type="text" class="input" id="textInput" placeholder="Ana Clara">
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
		<div class="field is-horizontal">
			<div class="field-label is-normal"><!--SELEÇÃO SEXO-->
				<label for="sexo" class="label">Sexo</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="sexo">
								<option value="">Selecione</option>								
								<option value="M">Masculino</option>
								<option value="F">Feminino</option>																	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<div class="field-label is-normal"><!--CAMPO EFETIVADO-->
				<label class="label" for="efetivacao">Nascimento</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:7em;">
						<input name="efetivacao" type="text" class="input mascara-data" placeholder="1992-12-31">
					</div>
				</div>
			</div>
			<div class="field-label is-normal"><!--CAMPO EFETIVADO-->
				<label class="label" for="efetivacao">Admissão</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:7em;">
						<input name="efetivacao" type="text" class="input mascara-data" placeholder="2018-12-31">
					</div>
				</div>
			</div>
		</div><!--FINAL DIVISÃO EM HORIZONTAL-->
		<!--DIVISÃO EM HORIZONTAL-->
		<div class="field is-horizontal"><!--SELEÇÃO CARGO-->
			<div class="field-label is-normal">
				<label for="cargo" class="label">Cargo</label>
			</div>
			<div class="field-body">
			<div class="field is-grouped">							
				<div class="control">
					<div class="select">
						<select name="cargo">							
							<option value="1">Operador de Logística 1</option>
							<option value="2">Operador de Logística 2</option>
							<option value="3">Operador de Logística 3</option>
							<option value="4">Auxiliar Administrativo</option>
							<option value="5">Assistente Administrativo</option>
							<option value="6">Líder de Operação</option>
							<option value="7">Assistente de Logística</option>
							<option value="8">Analista Administrativo</option>
							<option value="9">Analista de Suporte</option>
							<option value="10">Analista de Logística</option>
							<option value="11">Supervisor de Operação</option>	
							<option value="12">Recursos Humanos</option>															
						</select>	
					</div>
				</div>
			</div>
			</div>
			<div class="field-label is-normal"><!--SELEÇÃO TURNO-->
				<label for="turno" class="label">Turno</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="turno">
								<option value="">Selecione</option>
								<option value="1">Matutino</option>
								<option value="2">Vespetino</option>
								<option value="3">Comercial</option>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<div class="field-label is-normal">
				<label for="gestor" class="label">Gestor</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="gestor">								
								<option value="">Selecione</option>
								<option value="1">Marivalda Souza</option>
								<option value="2">Raphael Souza</option>
								<option value="3">Lucas Souza</option>
								<option value="4">Pedro Becali</option>
								<option value="5">Monara Marim</option>
								<option value="6">Marcos Freitas</option>							
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</div><!--FINAL DIVISÃO EM HORIZONTAL 2-->
		<!--DIVISÃO EM HORIZONTAL 2-->			
		<div class="field is-horizontal">
			<div class="field-label is-normal"><!--SELEÇÃO SETOR-->
				<label for="setor" class="label">Setor</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="setor">
								<option value="">Selecione</option>
								<option value="1">Operação</option>
								<option value="2">Administrativo</option>
								<option value="3">Recebimento</option>
								<option value="4">Devolução</option>
								<option value="5">Avarias</option>
								<option value="6">SAC</option>										
							</select>	
						</div>
					</div>					
				</div>						
			</div>		
			<div class="field-label is-normal"><!--CAMPO MATRICULA-->
				<label class="label" for="matricula">Matricula</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:8em;">
						<input name="matricula" type="text" class="input" id="mascara-numero" placeholder="629">
					</div>
				</div>
			</div>
			<div class="field-label is-normal"><!--SELEÇÃO PERMISSÃO-->
				<label for="setor" class="label">Permissão</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="permissao">								
								<option value="1">Usuário</option>
								<option value="2">Líder</option>
								<option value="3">Gestor</option>
								<option value="4">Administrador</option>																		
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<div class="field-label is-normal"><!--DIVISÃO SITUAÇÃO-->
				<label class="label">Situação</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="situacao">
								<option selected="selected" value="Ativo">Ativo</option>	
								<option value="Férias">Férias</option>
								<option value="Licença">Licença</option>
								<option value="Desligado">Desligado</option>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</div><!--FINAL DIVISÃO EM HORIZONTAL 2-->	
		<!---->					
		<div class="field">
			<label class="label" for="observacao">Observação</label>
				<div class="control">
					<input name="observacao" type="text" class="input" id="textInput" placeholder="Exemplo: funcionário terceirizado da empresa MWService...">
				</div>			
		</div>
			<div class="field">
				<div class="control">
					<button name="cadastrar" type="submit" class="button is-primary" id="submitQuery">Cadastrar</button>
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
<!--LÓGICA DE INSERÇÃO NO BANCO DE DADOS-->
<?php
if(isset($_GET['cadastrar'])){
	//VALIDAÇÃO SE LOGIN É ÚNICO.
	$checkLogin="SELECT LOGIN FROM USUARIO WHERE LOGIN='".$login."'";
	$result = mysqli_query($phpmyadmin, $checkLogin);		 
	$check = mysqli_num_rows($result);	
	if($check >= 1){
		?><script language="Javascript"> alert('Já existe usuário com o mesmo Login!');</script><?php
	}
	else{
		if(isset($_GET['cadastrar']) && $nome!="" && $login!="" && $senha!="" && $email!="" && $cargo!="" && $turno!="" && $gestor!="" && $setor!="" && $matricula!="" && $efetivacao!="" && $situacao!=""){	
			$inserirUsuario="INSERT INTO USUARIO(NOME, LOGIN, SENHA, EMAIL, CARGO_ID, TURNO_ID,GESTOR_ID, SETOR_ID, MATRICULA, EFETIVACAO, PERMISSAO_ID, CADASTRADOEM, SITUACAO) VALUES('".utf8_encode($nome)."','".$login."',MD5('".$senha."'),'".$email."',".$cargo.",".$turno.",".$gestor.",".$setor.",".$matricula.",'".$efetivacao."',".$permissao.",'".date('Y-m-d H:i:s')."','".$situacao."')";
			$cnx=mysqli_query($phpmyadmin, $inserirUsuario);		
			if(mysqli_error($phpmyadmin)==null){
				?><script language="Javascript"> alert('Funcionário cadastrado com sucesso!!!');</script><?php
				header("Location: localhost/gestaodesempenho/register.php");	
			}
			else{
				echo mysqli_error($phpmyadmin);
			}
		}
		else if( $nome==""){ 
			?><script language="Javascript"> alert('Preenchimento do Nome é obrigatório!');</script><?php
		}
		else if($login==""){
			?><script language="Javascript"> alert('Preenchimento do Login é obrigatório!');</script><?php
		} 
		else if($senha==""){
			?><script language="Javascript"> alert('Preenchimento da Senha é obrigatório!');</script><?php
		} 
		else if($email==""){
			?><script language="Javascript"> alert('Preenchimento do E-mail é obrigatório!');</script><?php
		}
		else if($cargo==""){
			?><script language="Javascript"> alert('Preenchimento do Cargo é obrigatório!');</script><?php
		}
		else if($turno==""){
			?><script language="Javascript"> alert('Preenchimento do Turno é obrigatório!');</script><?php
		}
		else if($gestor==""){
			?><script language="Javascript"> alert('Preenchimento do Gestor é obrigatório!');</script><?php
		}
		else if($setor==""){
			?><script language="Javascript"> alert('Preenchimento do Setor é obrigatório!');</script><?php
		}
		else if($matricula==""){
			?><script language="Javascript"> alert('Preenchimento da Matricula é obrigatório!');</script><?php
		}
		else if($efetivacao==""){
			?><script language="Javascript"> alert('Preenchimento da Admissão é obrigatório!');</script><?php
		}
		else if($cadastradoem==""){
			?><script language="Javascript"> alert('Preenchimento do Cadastro é obrigatório!');</script><?php
		}
		else{	
			?><script language="Javascript"> alert('Preenchimento da Situação é obrigatório!');</script><?php
		}
	}	
}//FINAL DA VERIFICAÇÃO DO ENVIO DO FORMULÁRIO
?>