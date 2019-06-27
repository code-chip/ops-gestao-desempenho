<?php
session_start();
include('conexao.php');
include('verifica_login.php');
$menuConfiguracoes="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$cargo = trim($_REQUEST['cargo']);
$nome = trim($_REQUEST['nome']);
$login = trim($_REQUEST['login']);
$senha = trim($_REQUEST['senha']);
$email = trim($_REQUEST['email']);
//$cargo=$_GET['cargo'];
//$cargo=$_POST['cargo'];
$turno = trim($_REQUEST['turno']);
$gestor = trim($_REQUEST['gestor']);
$setor = trim($_REQUEST['setor']);
$matricula = trim($_REQUEST['matricula']);
$efetivacao = trim($_REQUEST['efetivacao']);
$cadastradoem = trim($_REQUEST['cadastradoem']);
$situacao = trim($_REQUEST['situacao']);
$observacao = trim($_REQUEST['observacao']);
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
<?php
	/*CONSULTAS PARA CARREGAR AS OPÇÕES DE SELEÇÃO DO CADASTRO.*/	
	$gdGestor="SELECT ID, NOME FROM gd.GESTOR WHERE SITUACAO='Ativo'";
	$gdCargo="SELECT ID, NOME FROM gd.CARGO WHERE SITUACAO='Ativo'";
	$gdTurno="SELECT ID, NOME FROM gd.TURNO WHERE SITUACAO='Ativo'";
	$gdSetor="SELECT ID, NOME FROM gd.SETOR WHERE SITUACAO='Ativo'";

	$con = mysqli_query($phpmyadmin , $gdCargo);
	$xt=0; 
	while($cargo = $con->fetch_array()){
		$vtId[$xt] = $cargo["ID"]; 
		$vtNome[$xt] = utf8_encode($cargo["NOME"]); 
		$xt++;
	}
	echo $cargo;			
?>
<div>	
	<section class="section">
		<div class="container">
			<h3 class="title">Cadastro de Usuário</h3>
		<hr>
	<main>
	<form id="form1" action="user-insert.php" method="POST">
		<div class="field">
			<label class="label" for="textInput">Nome completo</label>
				<div class="control">
					<input name="nome" type="text" class="input" id="textInput" placeholder="Ana Clara" value="<?php echo "TESTE"; ?>">
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
		<!--DIVISÃO EM HORIZONTAL-->
		<div class="field is-horizontal">
			<!--SELEÇÃO CARGO-->
			<div class="field-label is-normal">
				<label for="cargo" class="label">Cargo:</label>
			</div>
			<div class="field-body">
			<div class="field is-grouped">							
				<div class="control">
					<div class="select">
						<select name="cargo">
							<?php $con = mysqli_query($phpmyadmin , $gdCargo);
								$xt=0; 
								while($cargo = $con->fetch_array()){
									echo '<option value="teste">'.$vtNome[$xt].'</option>';
									$xt++;
								} 
							?>								
						</select>	
					</div>
				</div>
			</div>
			</div>
			<!--SELEÇÃO TURNO-->
			<div class="field-label is-normal">
				<label for="turno" class="label">Turno</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="turno">
								<option selected="selected" value="">Selecione</option>	
								<?php $con = mysqli_query($phpmyadmin , $gdTurno);
								$x=0; 
								while($turno = $con->fetch_array()):{?>
									<option value="<?php $vtId[$x] = $turno["ID"]; ?>"><?php echo $vtNome[$x] = utf8_encode($turno["NOME"]); ?></option>
								<?php $x;} endwhile;?>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<!--FINAL DIVISÃO EM HORIZONTAL-->
			<div class="field-label is-normal">
				<label for="gestor" class="label">Gestor</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="gestor">
								<option selected="selected" value="">Selecione</option>	
								<?php $con = mysqli_query($phpmyadmin , $gdGestor);
								$x=0; 
								while($gestor = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $gestor["ID"]; ?>"><?php echo $vtNome[$x] = utf8_encode($gestor["NOME"]); ?></option>
								<?php $x;} endwhile;?>								
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<!--SELEÇÃO SETOR-->
			<div class="field-label is-normal">
				<label for="setor" class="label">Setor</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="setor">
								<option selected="selected" value="">Selecione</option>	
								<?php $con = mysqli_query($phpmyadmin , $gdSetor);
								$x2=0; 
								while($setor = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x2] = $setor["ID"]; ?>"><?php echo $vtNome[$x2] = utf8_encode($setor["NOME"]); ?></option>
								<?php $x;} endwhile;?>									
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
				<label class="label" for="matricula">Matricula:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:8em;">
						<input name="matricula" type="text" class="input" id="textInput" placeholder="629">
					</div>
				</div>
			</div>
			<!--CAMPO EFETIVADO-->
			<div class="field-label is-normal">
				<label class="label" for="efetivacao">Admissão:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:7em;">
						<input name="efetivacao" type="text" class="input" id="textInput" placeholder="2019-05-29">
					</div>
				</div>
			</div>
			<!--CAMPO DATA E HORA DE CADASTRO-->
			<div class="field-label is-normal">
				<label class="label" for="Cadastrado">Cadastrado:</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">
					<fieldset disabled>								
					<div class="control" style="max-width:11em;">
						<input name="cadastradoem" type="text" class="input" id="textInput" value="<?php echo date('Y-m-d H:i:s')?>">
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
							<select name="situacao">
								<option selected="selected" value="">Ativo</option>	
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
<?php 
	echo "teste";
	echo "0"+$cargo;
?>
</div>
</body>
</html>
<!--LÓGICA DE INSERÇÃO NO BANCO DE DADOS-->
<?php
if( $nome != "" && $login !="" && $senha !=""){
	echo $cargo;	
	$inserirUsuario="INSERT INTO USUARIO(NOME, LOGIN, SENHA, EMAIL, CARGO_ID, TURNO_ID, GESTOR_ID, SETOR_ID, MATRICULA, EFETIVACAO, CADASTRADOEM, SITUACAO) VALUES('".$nome."','".$login."',MD5('".$senha."'),'".$email."',".$cargo.",".$turno.",".$gestor.",".$setor.",".$matricula.",'".$efetivacao."','".$cadastradoem."','".$situacao."');";
	echo $inserirUsuario;
	$cnx=mysqli_query($phpmyadmin, $inserirUsuario); //or die($mysqli->error);
	header("Location: localhost/gestaodesempenho/register.php");	
}	
?>
<!--$nome 
$login 
$senha 
$email 
$cargo 
$turno 
$gestor
$setor 
$matricula 
$efetivacao
$cadastradoem 
$situacao 
$observacao-->