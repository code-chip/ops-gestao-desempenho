<?php
$menuAtivo="configuracoes";
require('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$filtro = trim($_POST['filtro']);
$busca= trim($_POST['busca']);
?>
<!DOCTYPE html>
<html>
<head>	
	<title>Gestão de Desempenho - Consultar Usuário</title>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones -->
	<script type="text/javascript" src="js/myjs.js"></script>
</head>
<body>
</br>
<div>
<?php if($filtro =="" && isset($_POST['consultar'])==null ): ?>
<section class="section">
  	<div class="container">  		
		<form id="form1" action="" method="POST">
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Filtro:</label>
				</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select onchange="upPlaceholder(this.value)" name="filtro">
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
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Buscar:</label>
				</div>
				<div class="field-body">
					<div class="field">							
						<div class="control">
							<div class="select"><!--SELEÇÃO OU PESQUISA DE NOME-->
							<input name="busca" type="text" class="input" id="filtro" placeholder="629">
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label"></div>
				<div class="field-body">
					<div class="field is-grouped">
						<div class="control">
							<button name="consultar" type="submit" class="button is-primary">Consultar</button>
						</div>
						<div class="control">
							<a href="register.php" class="button is-primary">Voltar</a>	
						</div>
					</div>
				</div>
			</div>
		</div>						
	</form><!--FINAL DO FORM FILTRAR CONSULTA-->
	</div><!--Final div container-->
</section>
	<?php endif;?>
<?php
if( $busca != ""){
	if($_SESSION["permissao"]==1){
		$f="USUARIO.MATRICULA=".$_SESSION["matriculaLogada"].";";
	}
	else if($filtro=="MATRICULA="){
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
	if($row==0){		
		mysqli_error($phpmyadmin);		
		?><script type="text/javascript">			
			alert('Nenhum usuário encontrado com o filtro aplicado!');
			window.location.href=window.location.href;
		</script> <?php			
	}
}
else if(isset($_POST['consultar'])!=null){
	?><script type="text/javascript">			
		alert('O Preenchimento do campo busca é obrigatório.!');
		window.location.href=window.location.href;
	</script> <?php	
}		
?>
<?php if(isset($_POST['consultar']) && $row!=0) : ?>
	<section class="section">
		<div class="container">
			<h3 class="title">Consultar Usuário</h3>
		<hr>
	<main>	
	<form id="form2" action="user-query.php" method="POST">		
		<div class="field">
			<label class="label" for="textInput">Nome completo</label>
				<div class="control">
					<input name="nome" type="text" class="input" id="textInput" placeholder="Ana Clara" value="<?php echo $dados["NOME"];?>" disabled>
				</div>			
		</div>
		<div class="field">
			<label class="label" for="numberInput">Login</label>
				<div class="control has-icons-left has-icons-right">
					<input name="login" class="input" type="text" id="textInput" placeholder="ana.clara" value="<?php echo $dados["LOGIN"];?>" disabled>				
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
					<input name="senha" type="password" class="input" id="textInput" placeholder="" value="<?php echo $dados["SENHA"];?>" disabled>
				</div>			
		</div>
		<div class="field">
		  	<label class="label">Email</label>
		  	<div class="control has-icons-left has-icons-right">
		    	<input name="email" class="input" id="email" type="text" placeholder="anaclara@gmail.com" value="<?php echo $dados["EMAIL"];?>" onblur="validacaoEmail(form1.email)"  maxlength="50" disabled>
		    	<span class="icon is-small is-left">
		      		<i class="fas fa-envelope"></i>
		    	</span>
		    	<div id="msgemail" style="display:none;">
			    	<span class="icon is-small is-right">
			      		<i class="fas fa-exclamation-triangle"></i>
			    	</span>
			    	<p class="help is-danger">E-mail inválido</p>		    	
		    	</div>
		  	</div>
		</div>
		<div class="field is-horizontal">
			<div class="field-label is-normal"><!--SELEÇÃO SEXO-->
				<label for="sexo" class="label">Sexo</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="sexo" disabled>
								<?php if($dados["SEXO"] =="M"):{?>							
								<option selected="selected" value="M">Masculino</option>
								<?php }endif?>
								<?php if($dados["SEXO"] =="F"):{?>	
								<option selected="selected" value="F">Feminino</option>
								<?php }endif?>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			<div class="field-label is-normal"><!--CAMPO CELULAR-->
				<label class="label" for="celular">Celular</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:9em;">
						<input name="celular" type="text" class="input celular" placeholder="(027)99296-8195" value="<?php echo $dados["CELULAR"];?>" disabled>
					</div>
				</div>
			</div>
			<div class="field-label is-normal"><!--CAMPO EFETIVADO-->
				<label class="label" for="nascimento">Nascimento</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:7em;">
						<input name="nascimento" type="text" class="input mascara-data" placeholder="1992-12-31" value="<?php echo $dados["NASCIMENTO"];?>" disabled>
					</div>
				</div>
			</div>
			<div class="field-label is-normal"><!--CAMPO EFETIVADO-->
				<label class="label" for="efetivacao">Admissão</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control" style="max-width:7em;">
						<input name="efetivacao" type="text" class="input mascara-data" placeholder="2018-12-31" value="<?php echo $dados["EFETIVACAO"];?>" disabled>
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
						<select name="cargo" disabled>
							<option selected="selected" value="<?php echo $dados["CARGO_ID"];?>"><?php echo $dados["CARGO"];?></option>	
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
							<select name="turno" disabled>
								<option selected="selected" value="<?php echo $dados["TURNO_ID"];?>"><?php echo $dados["TURNO"];?></option>
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
							<select name="gestor" disabled>								
								<option selected="selected" value="<?php echo $dados["GESTOR_ID"];?>"><?php echo $dados["GESTOR"];?></option>	
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</div><!--FINAL DIVISÃO EM HORIZONTAL 2-->				
		<div class="field is-horizontal"><!--DIVISÃO EM HORIZONTAL 2-->	
			<div class="field-label is-normal"><!--SELEÇÃO SETOR-->
				<label for="setor" class="label">Setor</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="setor" disabled>
								<option selected="selected" value="<?php echo $dados["SETOR_ID"];?>"><?php echo $dados["SETOR"];?></option>
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
						<input name="matricula" type="text" class="input" placeholder="629" value="<?php echo $dados["MATRICULA"]?>" disabled>
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
							<select name="permissao" disabled>							
								<option selected="selected" value="<?php echo $dados["PERMISSAO_ID"];?>"><?php echo $dados["PERMISSAO"];?></option disabled>
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
							<select name="situacao" disabled>
								<option selected="selected" value="<?php echo $dados["SITUACAO"];?>"><?php echo $dados["SITUACAO"];?></option disabled>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</div><!--FINAL DIVISÃO EM HORIZONTAL 2-->							
		<div class="field"><!---->	
			<label class="label" for="observacao">Observação</label>
				<div class="control">
					<input name="observacao" type="text" class="input" id="textInput" placeholder="Exemplo: funcionário terceirizado da empresa MWService..." value="<?php echo $dados["OBSERVACAO"];?>" disabled>
				</div>			
		</div>
			<div class="field is-grouped">
				<div class="control">
					<a href="user-query.php"><button name="cadastrar" type="submit" class="button is-primary" id="submitQuery">Voltar</button></a>
				</div>
				<div class="control">
					<a href="register.php" class="button is-primary">Cancelar</a>
				</div>
			</div>						
		</form>
	</main>	
</section>
<?php endif;?>
</div>
</body>
</html>