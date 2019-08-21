<?php
session_start();
$menuConfiguracoes="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$filtro = trim($_REQUEST['filtro']);
$busca= trim($_REQUEST['busca']);
?>
<!DOCTYPE html>
<html>
<head>	
	<title>Gestão de Desempenho - Atualizar Usuário</title>
</head>
<body>
</br>
<div>	
	<form id="form1" action="" method="POST">
		<div class="field is-horizontal section">			
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Filtro:</label>
				</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select name="filtro">
									<option value="MATRICULA=">Matricula</option>
									<option value="LOGIN=">Login</option>
									<option value="NOME LIKE">Nome</option>
									<option value="EMAIL=">E-mail</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>			
			<div class="field is-horizontal">&nbsp&nbsp&nbsp&nbsp
				<div class="field-label is-normal">
					<label class="label">Buscar:</label>
				</div>
				<div class="field-body">
					<div class="field">							
						<div class="control">
							<div class="select"><!--SELEÇÃO OU PESQUISA DE NOME-->
							<input name="busca" type="text" class="input" id="filtro" placeholder="635">
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
							<button name="consultar" type="submit" class="button is-primary">Consultar</button>
						</div>
					</div>
				</div>
			</div>
		</div>						
	</form>
<?php
if( $busca != ""){
	if($filtro=="MATRICULA="){
		$f="USUARIO.".$filtro."".$busca." LIMIT 1;";
	}
	else{
		$f="USUARIO.".$filtro."'".$busca."' LIMIT 1;";
	}	
	$query="SELECT *, USUARIO.NOME AS NOME, T.NOME AS TURNO, P.NOME AS PERMISSAO, G.NOME AS GESTOR, S.NOME AS SETOR, C.NOME AS CARGO FROM USUARIO
INNER JOIN TURNO T ON T.ID=USUARIO.TURNO_ID
INNER JOIN PERMISSAO P ON P.ID=USUARIO.PERMISSAO_ID
INNER JOIN GESTOR G ON G.ID=USUARIO.GESTOR_ID
INNER JOIN SETOR S ON S.ID=USUARIO.SETOR_ID
INNER JOIN CARGO C ON C.ID=USUARIO.CARGO_ID
WHERE ".$f;
	$x=0;	
	$cnx=mysqli_query($phpmyadmin, $query);
	$dados= $cnx->fetch_array();
	$row=mysqli_num_rows($cnx);		
	if(mysqli_error($phpmyadmin)=="" || mysqli_num_rows($dados)==1){		

	}
	else{
		mysqli_error($phpmyadmin);		
		?><script type="text/javascript">			
			alert('Nenhum registrado encontrado nesta consulta!');
			window.location.href=window.location.href;
		</script> <?php			
	}
}	
?>
<!--FINAL DO FORM FILTRAR CONSULTA-->
<!--FINAL DO FORMULÁRIO DE FILTRAGEM-->
<?php if(isset($_POST['consultar']) && $busca!="") : ?>
	<section class="section">
	<main>
	<form id="form2" action="user-query.php" method="GET">
		<div class="field">
			<label class="label" for="textInput">Nome completo</label>
				<div class="control">
					<input name="nome" type="text" class="input" id="textInput" placeholder="Ana Clara" value="<?php echo $dados["NOME"];?>">
				</div>			
		</div>
		<div class="field">
			<label class="label" for="numberInput">Login</label>
				<div class="control has-icons-left has-icons-right">
					<input name="login" class="input" type="text" id="textInput" placeholder="ana.clara" value="<?php echo $dados["LOGIN"];?>">				
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
					<input name="senha" type="password" class="input" id="textInput" placeholder="" value="<?php echo $dados["SENHA"];?>">
				</div>			
		</div>
		<div class="field">
		  	<label class="label">Email</label>
		  	<div class="control has-icons-left has-icons-right">
		    	<input name="email" class="input is-danger" type="text" placeholder="anaclara@gmail.com" value="<?php echo $dados["EMAIL"];?>" onblur="validacaoEmail(form1.email)"  maxlength="60" size='65'>
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
								<?php if($dados["SEXO"] =="M"):{?>							
								<option selected="selected" value="M">Masculino</option>
								<option value="F">Feminino</option><?php }endif?>
								<?php if($dados["SEXO"] =="F"):{?>	
								<option selected="selected" value="F">Feminino</option>
								<option value="M">Masculino</option><?php }endif?>
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
						<input name="nascimento" type="text" class="input mascara-data" placeholder="1992-12-31" value="<?php echo $dados["NASCIMENTO"];?>">
					</div>
				</div>
			</div>
			<div class="field-label is-normal"><!--CAMPO EFETIVADO-->
				<label class="label" for="efetivacao">Admissão</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:7em;">
						<input name="efetivacao" type="text" class="input mascara-data" placeholder="2018-12-31" value="<?php echo $dados["EFETIVACAO"];?>">
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
							<option selected="selected" value="<?php echo $dados["CARGO_ID"];?>"><?php echo $dados["CARGO"];?></option>	
								<?php $gdCargo="SELECT ID, NOME FROM CARGO WHERE SITUACAO='Ativo' AND ID<>".$dados["CARGO_ID"]; 
								$con = mysqli_query($phpmyadmin , $gdCargo);
								$x=0; 
								while($cargo = $con->fetch_array()):{ $vtId[$x] = $cargo["ID"];?>
									<option value="<?php echo $vtId[$x]; ?>"><?php echo $vtNome[$x] = utf8_encode($cargo["NOME"]); ?></option>
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
								<option selected="selected" value="<?php echo $dados["TURNO_ID"];?>"><?php echo $dados["TURNO"];?></option>	
								<?php $gdTurno="SELECT ID, NOME FROM TURNO WHERE SITUACAO='Ativo' AND ID<>".$dados["TURNO_ID"]; 
								$con = mysqli_query($phpmyadmin , $gdTurno);
								$x=0; 
								while($turno = $con->fetch_array()):{ $vtId[$x] = $turno["ID"];?>
									<option value="<?php echo $vtId[$x]; ?>"><?php echo $vtNome[$x] = utf8_encode($turno["NOME"]); ?></option>
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
								<option selected="selected" value="<?php echo $dados["GESTOR_ID"];?>"><?php echo $dados["GESTOR"];?></option>	
								<?php $gdGestor="SELECT ID, NOME FROM GESTOR WHERE SITUACAO='Ativo' AND ID<>".$dados["GESTOR_ID"]; 
								$con = mysqli_query($phpmyadmin , $gdGestor);
								$x=0; while($gestor = $con->fetch_array()):{ ?>
									<option value="<?php echo $vtId[$x]=$gestor["ID"];?>"><?php echo $vtNome[$x]=utf8_encode($gestor["NOME"]); ?></option>
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
								<option selected="selected" value="<?php echo $dados["SETOR_ID"];?>"><?php echo $dados["SETOR"];?></option>	
								<?php $gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo' AND ID<>".$dados["SETOR_ID"]; 
								$con = mysqli_query($phpmyadmin , $gdSetor);
								$x=0; while($setor = $con->fetch_array()):{ ?>
									<option value="<?php echo $vtId[$x]=$setor["ID"];?>"><?php echo $vtNome[$x]=utf8_encode($setor["NOME"]); ?></option>
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
						<input name="matricula" type="text" class="input" placeholder="629" value="<?php echo $dados["MATRICULA"]?>">
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
								<option selected="selected" value="<?php echo $dados["PERMISSAO_ID"];?>"><?php echo $dados["PERMISSAO"];?></option>	
								<?php $gdPermissao="SELECT ID, NOME FROM PERMISSAO WHERE SITUACAO='Ativo' AND ID<>".$dados["PERMISSAO_ID"]; 
								$con = mysqli_query($phpmyadmin , $gdPermissao);
								$x=0; while($permissao = $con->fetch_array()):{ ?>
									<option value="<?php echo $vtId[$x]=$permissao["ID"];?>"><?php echo $vtNome[$x]=utf8_encode($permissao["NOME"]); ?></option>
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
					<input name="observacao" type="text" class="input" id="textInput" placeholder="Exemplo: funcionário terceirizado da empresa MWService...">
				</div>			
		</div>
			<div class="field">
				<div class="control">
					<button name="cadastrar" type="submit" class="button is-primary" id="submitQuery">Atualizar</button>
				</div>
			</div>				
		</form>
	</main>	
</section>
<?php endif;?>
</div>
</body>
</html>
<!--LÓGICA DE INSERÇÃO NO BANCO DE DADOS-->
<?php
if(isset($_GET['cadastrar'])){
	//VALIDAÇÃO SE LOGIN É ÚNICO.
	$checkLogin="SELECT LOGIN FROM USUARIO WHERE LOGIN='".$login."' AND ID<>".$dados["ID"];
	$result = mysqli_query($phpmyadmin, $checkLogin);		 
	$check = mysqli_num_rows($result);	
	if($check >= 1){
		?><script language="Javascript"> alert('Já existe usuário com o mesmo Login!');</script><?php
	}
	else{		
		if(isset($_GET['cadastrar']) && $nome!="" && $login!="" && $senha!="" && $email!="" && $cargo!="" && $turno!="" && $gestor!="" && $setor!="" && $matricula!="" && $efetivacao!="" && $situacao!=""){
			if($nascimento=="" || $nascimento==null){
				echo $nascimento;
				$nascimento="1990-01-01";
			}	
			$upUser="UPDATE USUARIO SET NOME='".utf8_encode($nome)."', LOGIN='".$login."', SENHA=MD5('".$senha."'), EMAIL='".$email."', SEXO='".$sexo."', NASCIMENTO='".$nascimento."', CARGO_ID=".$cargo.", TURNO_ID=".$turno.",GESTOR_ID=".$gestor.", SETOR_ID=".$setor.", MATRICULA=".$matricula.", EFETIVACAO='".$efetivacao."', PERMISSAO_ID=".$permissao.", SITUACAO='".$situacao."';";
			$cnx=mysqli_query($phpmyadmin, $inserirUsuario);					
			if(mysqli_error($phpmyadmin)==null){
				?><script language="Javascript"> alert('Funcionário atualizado com sucesso!!!');</script><?php
				header("Location: localhost/gestaodesempenho/register.php");	
			}
			else{
				?><script language="Javascript"> alert('Erro ao cadastrar!!!');</script><?php
				echo mysqli_error($phpmyadmin);
				echo $nascimento;
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