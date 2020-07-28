<?php
$menuAtivo = 'configuracoes';
require('menu.php');	

$filter = trim($_REQUEST['filtro']);
$search = trim($_REQUEST['busca']);
$redirect = "<script> alert('Funcionário removido com sucesso!!!'); window.location.href='user-update.php'; </script>"

?>
<!DOCTYPE html>
<html>
<head>	
	<title>Gestão de Desempenho - Consultar Usuário</title>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones -->
	<script type="text/javascript" src="js/myjs.js"></script>
	<link rel="stylesheet" href="css/personal.css" />
</head>
<body>
</br>
<div>
<?php if ($filter == "" && isset($_POST['search']) == null && $_SESSION["permissao"] > 1): ?>
<section class="section">
  	<div class="container">  		
	<form id="form1" action="user-query.php" method="POST">
		<div class="field is-horizontal">				
			<div class="field-label is-normal">
				<label class="label">Filtro:</label>
			</div>
			<div class="field-body">
				<div class="field" style="max-width:17em;">							
					<div class="control">
						<div class="select">
							<select onchange="upPlaceholder(this.value)" name="filtro" id="tipoCampo" style="width:16.7em;">
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
							<button name="search" type="submit" class="button is-primary btn128">Consultar</button>
						</div>
						<div class="control">
							<a href="register.php" class="button is-primary btn128">Cancelar</a>	
						</div>
					</div>
				</div>
			</div>
		</div>						
	</form>
	</div>
</section>	
<?php endif;
	
if ( $search != "" || $_SESSION["permissao"] == 1) {

	if ($_SESSION["permissao"] == 1 ) {
		$f = "U.ID=".$_SESSION['userId'] . ";";
		$redirect = "<script> alert('Funcionário removido com sucesso!!!'); window.location.href='register.php'; </script>";

	} else if ($filter == "MATRICULA=") {
		$f = "U." . $filter . "" . $search . " LIMIT 1;";


	} else {
		$f = "U." . $filter . "'" . $search . "' LIMIT 1;";
	}	
	
	$query = "SELECT U.ID AS ID, U.NOME AS NOME, U.LOGIN,U.SENHA AS SENHA, U.EMAIL, U.SEXO, U.CELULAR, U.NASCIMENTO, U.EFETIVACAO, U.CARGO_ID,C.NOME AS CARGO, U.TURNO_ID, T.NOME AS TURNO, U.GESTOR_ID, UG.NOME AS GESTOR, U.SETOR_ID, S.NOME AS SETOR, U.MATRICULA, U.PERMISSAO_ID, P.NOME AS PERMISSAO, U.OBSERVACAO, U.SITUACAO  FROM USUARIO U INNER JOIN TURNO T ON T.ID=U.TURNO_ID INNER JOIN PERMISSAO P ON P.ID=U.PERMISSAO_ID INNER JOIN USUARIO UG ON UG.ID=U.GESTOR_ID INNER JOIN SETOR S ON S.ID=U.SETOR_ID INNER JOIN CARGO C ON C.ID=U.CARGO_ID WHERE ".$f;
	$x = 0;	
	$cnx = mysqli_query($phpmyadmin, $query);
	$dados = $cnx->fetch_array();
	$row = mysqli_num_rows($cnx);

	if ($row == 0) {		
		mysqli_error($phpmyadmin);		
		echo "<script>alert('Nenhum usuário encontrado com o filtro aplicado!'); window.location.href=window.location.href; </script>";			
	}

	$_SESSION["upUser"] = $dados["ID"];
}
else if (isset($_POST['search']) != null) {
	echo "<script>alert('O Preenchimento do campo busca é obrigatório.!'); window.location.href=window.location.href;</script>";
}	
//<!--FINAL DO FORM FILTRAR CONSULTA-->
//<!--FINAL DO FORMULÁRIO DE FILTRAGEM-->
if(isset($_POST['search']) && $row != 0 || $_SESSION['permissao'] == 1 && $row!=0) : ?>
	<section class="section">
		<div class="container">
			<h3 class="title"><i class="fas fa-calendar-check"></i> Consultar Usuário</h3>
		<hr>
	<main>
	<form id="form" action="user-query.php" method="POST" onsubmit="return check()">
		<div class="field">
			<label class="label is-size-7-touch" for="textInput">Nome Completo*</label>
			<div class="control has-icons-left has-icons-right" id="name">
				<input name="name" type="text" class="input required" placeholder="Harry Will" value="<?php echo $dados["NOME"];?>" disabled>
				<span class="icon is-small is-left">
			   		<i class="fas fa-user-circle"></i>
			   	</span>
			</div>
		</div><!--END BLOCK ONE-->
		<!--BLOCK TWO-->
		<div class="field">
			<label class="label is-size-7-touch" for="textInput">Login*</label>
			<div class="control has-icons-left has-icons-right" id="name">
				<input name="login" type="text" class="input required" placeholder="harry.will" id="input2" value="<?php echo $dados["LOGIN"];?>" disabled>
				<span class="icon is-small is-left">
			   		<i class="fas fa-user"></i>
			   	</span>
			</div>
			<p class="help">Use de preferência texto caixa baixa, primeiro e último nome p/ manter a padronização de nome de login.</p>
		</div><!--END BLOCK TWO-->
		<!--BLOCK THREE-->
		<div class="field">
			<label class="label is-size-7-touch" for="textInput">Senha*</label>
			<div class="control has-icons-left has-icons-right" id="password">
				<input name="password" type="password" class="input required" placeholder="&634kfa@934301" maxlength="32" id="input3" value="<?php echo $dados["SENHA"];?>" disabled>
				<span class="icon is-small is-left">
					<i class="fas fa-lock-open"></i>
				</span>
			</div>			
		</div><!--END BLOCK THREE-->
		<!--BLOCK FOUR-->
		<div class="field">
		  	<label class="label">Email</label>
		  	<div class="control has-icons-left has-icons-right" id="emailLoad">
		    	<input name="email" class="input required" id="email" type="text" placeholder="willvix@outlook.com" maxlength="50" value="<?php echo $dados["EMAIL"];?>" disabled>
		    	<span class="icon is-small is-left">
		      		<i class="fas fa-envelope" id="iconMail"></i>
		    	</span>
		  	</div>		  	
		</div><!--ENDS BLOCK FOUR-->
		<!--BLOCK FIVE-->
		<div class="field is-horizontal">
			<div class="field srf20"><!--Campo nascimento-->
				<label class="label is-size-7-touch" for="textInput">Nascimento*</label>
				<div class="control has-icons-left has-icons-right" id="birth">
					<input name="birth" type="text" class="input required registro sf17" placeholder="1992-12-31"  maxlength="10" id="input4" value="<?php echo $dados["NASCIMENTO"];?>" disabled>
					<span class="icon is-small is-left">
				   		<i class="fas fa-calendar-alt"></i>
				   	</span>
				</div>
			</div>
			<div class="field srf20">
				<label class="label is-size-7-touch" for="textInput">Celular*</label>
				<div class="control has-icons-left has-icons-right" id="phone">
					<input name="phone" type="text" class="input required celular sf17" placeholder="(27)99296-8195"  maxlength="13" value="<?php echo $dados["CELULAR"];?>" disabled>
					<span class="icon is-small is-left">
				   		<i class="fas fa-phone"></i>
				   	</span>
				</div>
			</div>
			<div class="field srf20" ><!--Seleção sexo-->
				<label class="label is-size-7-touch" for="textInput">Sexo*</label>
				<div class="control has-icons-left">
					<div class="select">
					  	<select name="sex" class="sf23-15 required " disabled><?php
					  		if ($dados["SEXO"] == "m") {							
								echo "<option selected='selected' value='m'>Masculino</option>";
							} else {	
								echo "<option selected='selected' value='f'>Feminino</option>";
							}
						?></select>
					</div>
					<div class='loadId'>
						<span class="icon is-small is-left" >
						  	<i class="fas fa-street-view"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="field srf20"><!--Seleção role-->
				<label class="label is-size-7-touch" for="textInput">Cargo*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  	<select name="role" class="sf23-15" disabled>
					  		<option selected="selected" value="<?php echo $dados["CARGO_ID"];?>"><?php echo $dados["CARGO"];?></option>
					  	</select>
					</div>
					<div>
						<span class="icon is-small is-left" >
						  	<i class="fas fa-suitcase-rolling"></i>
						</span>
					</div>
				</div>
			</div>
		</div><!--END BLOCK FIVE-->
		<!--BLOCK SIX-->
		<div class="field is-horizontal">
			<div class="field srf20"><!--Campo admissão-->
				<label class="label is-size-7-touch" for="textInput">Admissão*</label>
				<div class="control has-icons-left has-icons-right" id="admission">
					<input name="admission" type="text" class="input required registro sf17" placeholder="2018-01-22"  maxlength="10" value="<?php echo $dados["EFETIVACAO"];?>" disabled>
					<span class="icon is-small is-left">
				   		<i class="fas fa-calendar-alt"></i>
				   	</span>
				</div>
			</div>
			<div class="field srf20"><!--Seleção turno-->
				<label class="label is-size-7-touch" for="textInput">Turno*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="shift" class="sf17" disabled>
					  			<option selected="selected" value="<?php echo $dados["TURNO_ID"];?>"><?php echo $dados["TURNO"];?></option>
					  		</select>
						</select>
					</div>
					<div id="carVehicle">
						<span class="icon is-small is-left" >
						  	<i class="fas fa-clock"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="field srf20"><!--Seleção role-->
				<label class="label is-size-7-touch" for="textInput">Setor*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="sector" class="sf23-15" disabled>
					  			<option selected="selected" value="<?php echo $dados["SETOR_ID"];?>"><?php echo $dados["SETOR"];?></option>
					  		</select>
						</select>
					</div>
					<div id="carVehicle">
						<span class="icon is-small is-left" >
						  	<i class="fas fa-door-open"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="field srf20"><!--Seleção gestor-->
				<label class="label is-size-7-touch" for="textInput">Gestor*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="leader" class="sf23-15" onchange="upIconVehicle(this.value)" disabled>
					  			<option selected="selected" value="<?php echo $dados["GESTOR_ID"];?>"><?php echo $dados["GESTOR"];?></option>
					  		</select>
						</select>
					</div>
					<div id="carVehicle">
						<span class="icon is-small is-left" >
						  	<i class="fas fa-user-tie"></i>
						</span>
					</div>
				</div>
			</div>
		</div><!--END BLOCK SIX-->
		<!--BLOCK SERVER-->			
		<div class="field is-horizontal">
			<div class="field srf20"><!--Campo armário-->
				<label class="label is-size-7-touch" for="textInput">Nº Armário</label>
				<div class="control has-icons-left has-icons-right" id="wardrobe">
					<input name="wardrobe" type="text" class="input numero sf17" placeholder="125"  maxlength="3" value="<?php echo $dados["ARMARIO"];?>" disabled>
					<span class="icon is-small is-left">
				   		<i class="fas fa-briefcase"></i>
				   	</span>
				</div>
			</div>
			<div class="field srf20"><!--Campo matricula-->
				<label class="label is-size-7-touch" for="textInput">Matricula ADP*</label>
				<div class="control has-icons-left has-icons-right" id="registration">
					<input name="registration" type="text" class="input required numero sf17" placeholder="629"  maxlength="4" value="<?php echo $dados["MATRICULA"];?>" disabled>
					<span class="icon is-small is-left">
				   		<i class="fas fa-ad"></i>
				   	</span>
				</div>
			</div>
			<div class="field srf20"><!--Seleção permissão-->
				<label class="label is-size-7-touch" for="textInput">Permissão*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="permission" class="sf23-15" disabled>
					  			<option selected="selected" value="<?php echo $dados["PERMISSAO_ID"];?>"><?php echo $dados["PERMISSAO"];?></option>
					  		</select>
						</select>
					</div>
					<div id="carVehicle">
						<span class="icon is-small is-left" >
						  	<i class="fas fa-id-card-alt"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="field srf20"><!--Seleção situação-->
				<label class="label is-size-7-touch" for="textInput">Situação*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="situation" class="sf23-15" disabled>
					  			<option selected="selected" value="<?php echo $dados["SITUACAO"]?>"><?php echo $dados["SITUACAO"]?></option><?php
					  			if ($dados["SITUACAO"] == "Ativo") {	
									echo "<option value='Férias'>Férias</option>
									<option value='Licença'>Licença</option>
									<option value='Desligado'>Desligado</option>";
								
								} else if ($dados['SITUACAO'] == 'Férias') {
									echo "<option value='Ativo'>Ativo</option>
									<option value='Licença'>Licença</option>
									<option value='Desligado'>Desligado</option>";
								
								} else if($dados['SITUACAO'] == 'Licença') {
									echo "<option value='Ativo'>Ativo</option>
									<option value='Férias'>Férias</option>
									<option value='Desligado'>Desligado</option>";
								
								} else {
									echo "<option value='Ativo'>Ativo</option>
									<option value='Férias'>Férias</option>
									<option value='Licença'>Licença</option>";
								
								}
							?></select>
						</select>
					</div>
					<div id="carVehicle">
						<span class="icon is-small is-left" >
						  	<i class="fas fa-sort"></i>
						</span>
					</div>
				</div>
			</div>
		</div><!--END BLOCK SERVER-->
		<!--BLOCK EIGHT-->				
		<div class="field">
			<label class="label is-size-7-touch" for="note">Observação</label>
				<div class="control" id="note">
					<input name="note" type="text" class="input" id="textInput" placeholder="Exemplo:Informações de e-mail e celular pedente." maxlength="250" value="<?php echo $dados["OBSERVACAO"]?>" disabled>
				</div>			
		</div><!--END BLOCK EIGHT-->
		<div class="field-body">
			<div class="field is-grouped"><?php 
				if ( $_SESSION["permissao"] > 1){
					echo "<div class='control'>
						<a href='user-query.php' class='button is-primary btn128'>Voltar</a>
					</div>";
				}
				?>
				<div class="control">
					<a href="register.php" class="button is-primary btn128">Cancelar</a>										
				</div>									
			</div>
		</div>							
		</form>
	</main>	
	</div>
	</section>
<?php endif;?>
</div>
</body>
</html>