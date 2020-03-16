<?php
$menuAtivo="configuracoes";
include('menu.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão!')</script>";
	header("Refresh:1;url=home.php");
}
else{
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
	<form id="form1" action="user-insert.php" method="POST">
		<div class="field">
			<label class="label" for="textInput">Nome completo</label>
				<div class="control">
					<input name="nome" type="text" class="input" id="textInput" placeholder="Ana Clara" maxlength="60">
				</div>			
		</div>
		<div class="field">
			<label class="label" for="numberInput">Login</label>
				<div class="control has-icons-left has-icons-right">
					<input name="login" class="input" type="text" id="textInput" placeholder="ana.clara" maxlength="60">				
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
				<label class="label" for="nascimento">Nascimento</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:7em;">
						<input name="nascimento" type="text" class="input registro" placeholder="1992-12-31">
					</div>
				</div>
			</div>
			<div class="field-label is-normal"><!--CAMPO EFETIVADO-->
				<label class="label" for="efetivacao">Admissão</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:7em;">
						<input name="efetivacao" type="text" class="input registro" placeholder="2018-12-31">
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
								<?php $gdCargo="SELECT ID, NOME FROM CARGO WHERE SITUACAO='Ativo'"; 
								$con = mysqli_query($phpmyadmin , $gdCargo); $x=0; 
								while($cargo = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x]=$cargo["ID"];?>"><?php echo $vtNome[$x]=$cargo["NOME"];?></option>
								<?php $x;} endwhile;?>														
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
								<?php $gdTurno="SELECT ID, NOME FROM TURNO WHERE SITUACAO='Ativo'"; 
								$con = mysqli_query($phpmyadmin , $gdTurno); $x=0; 
								while($turno = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x]=$turno["ID"];?>"><?php echo $vtNome[$x]=$turno["NOME"];?></option>
								<?php $x;} endwhile;?>	
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
								<?php $gdGestor="SELECT ID, NOME FROM GESTOR WHERE SITUACAO='Ativo'"; 
								$con = mysqli_query($phpmyadmin , $gdGestor); $x=0; 
								while($gestor = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x]=$gestor["ID"];?>"><?php echo $vtNome[$x]=$gestor["NOME"];?></option>
								<?php $x;} endwhile;?>								
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
								<?php $gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'"; 
								$con = mysqli_query($phpmyadmin , $gdSetor); $x=0; 
								while($setor = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x]=$setor["ID"];?>"><?php echo $vtNome[$x]=$setor["NOME"];?></option>
								<?php $x;} endwhile;?>										
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
						<input name="matricula" type="text" class="input numero" placeholder="635" maxlength="4">
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
								<?php $gdPermissao="SELECT ID, NOME FROM PERMISSAO WHERE ID<=".$_SESSION["permissao"]." AND SITUACAO='Ativo'"; 
								$con = mysqli_query($phpmyadmin , $gdPermissao); $x=0; 
								while($permissao = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x]=$permissao["ID"];?>"><?php echo $vtNome[$x]=$permissao["NOME"];?></option>
								<?php $x;} endwhile;?>																			
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
					<input name="observacao" type="text" class="input" id="textInput" placeholder="Exemplo: funcionário terceirizado da empresa MWService..." maxlength="60">
				</div>			
		</div>
		<div class="field-body">
			<div class="field is-grouped">											
				<div class="control">
					<a href="register.php" class="button is-primary">Voltar</a>										
				</div>
				<div class="control">
					<a href="user-insert.php"><input name="limpar" type="submit" class="button is-primary" value="Limpar"/></a>
				</div>
				<div class="control">
					<input name="cadastrar" type="submit" class="button is-primary" value="Cadastrar"/>
				</div>					
			</div>
		</div>							
		</form>
	</main>	
</div>
</section>
</div>
</body>
</html>
<!--LÓGICA DE INSERÇÃO NO BANCO DE DADOS-->
<?php
if(isset($_POST['cadastrar'])){
	//<!--- DECLARAÇÃO DAS VARIAVEIS -->
	$nome = trim($_POST['nome']);
	$login = trim($_POST['login']);
	$senha = trim($_POST['senha']);
	$email = trim($_POST['email']);
	$sexo = trim($_POST['sexo']);
	$nascimento = trim($_POST['nascimento']);
	$cargo = trim($_POST['cargo']);
	$turno = trim($_POST['turno']);
	$gestor = trim($_POST['gestor']);
	$setor = trim($_POST['setor']);
	$matricula = trim($_POST['matricula']);
	$efetivacao = trim($_POST['efetivacao']);
	$permissao = trim($_POST['permissao']);
	$situacao = trim($_POST['situacao']);
	$observacao = trim($_POST['observacao']);
	//VALIDAÇÃO SE LOGIN É ÚNICO.
	$checkLogin="SELECT LOGIN FROM USUARIO WHERE LOGIN='".$login."'";
	$result = mysqli_query($phpmyadmin, $checkLogin);		 
	$check = mysqli_num_rows($result);	
	if($check >= 1){
		?><script language="Javascript"> alert('Já existe usuário com o mesmo Login!');</script><?php
	}
	else{		
		if($nome!="" && $login!="" && $senha!="" && $email!="" && $cargo!="" && $turno!="" && $gestor!="" && $setor!="" && $matricula!="" && $efetivacao!="" && $situacao!=""){
			if($nascimento=="" || $nascimento==null){				
				$nascimento="1900-01-01";
			}	
			$inserirUsuario="INSERT INTO USUARIO(NOME, LOGIN, SENHA, EMAIL, SEXO, NASCIMENTO, CARGO_ID, TURNO_ID,GESTOR_ID, SETOR_ID, MATRICULA, EFETIVACAO, PERMISSAO_ID, CADASTRADOEM, SITUACAO) VALUES('".$nome."','".$login."',MD5('".$senha."'),'".$email."','".$sexo."','".$nascimento."',".$cargo.",".$turno.",".$gestor.",".$setor.",".$matricula.",'".$efetivacao."',".$permissao.",'".date('Y-m-d H:i:s')."','".$situacao."')";
			$cnx=mysqli_query($phpmyadmin, $inserirUsuario);		
			if(mysqli_error($phpmyadmin)==null){
				?><script language="Javascript"> alert('Funcionário cadastrado com sucesso!!!');</script><?php
				header("Location: register.php");	
			}
			else{
				?><script language="Javascript"> alert('Erro ao cadastrar!!!');</script><?php
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
		else{	
			?><script language="Javascript"> alert('Preenchimento da Situação é obrigatório!');</script><?php
		}
	}	
}//FINAL DA VERIFICAÇÃO DO ENVIO DO FORMULÁRIO
}//ELSE - caso o usuário tenha permissão.
?>