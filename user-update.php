<?php
$menuAtivo = 'configuracoes';
require('menu.php');	

$filter = trim($_REQUEST['filtro']);
$search = trim($_REQUEST['busca']);
$redirect = "<script> alert('Funcionário atualizado com sucesso!!!'); window.location.href='user-update.php'; </script>"

?>
<!DOCTYPE html>
<html>
<head>	
	<title>Gestão de Desempenho - Atualizar Usuário</title>
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
	<form id="form1" action="user-update.php" method="POST">
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
	;

	if ($_SESSION["permissao"] == 1 ) {
		$f = "U.ID=".$_SESSION['userId'] . ";";
		$redirect = "<script> alert('Funcionário atualizado com sucesso!!!'); window.location.href='register.php'; </script>";

	} else if ($filter == "MATRICULA=") {
		$f = "U." . $filter . "" . $search . " LIMIT 1;";


	} else {
		$f = "U." . $filter . "'" . $search . "' LIMIT 1;";
	}	
	
	$query = "SELECT U.ID AS ID, U.NOME AS NOME, U.LOGIN,U.SENHA AS SENHA, U.EMAIL, U.SEXO, U.CELULAR, U.NASCIMENTO, U.EFETIVACAO, U.CARGO_ID,C.NOME AS CARGO, U.TURNO_ID, T.NOME AS TURNO, U.GESTOR_ID, UG.NOME AS GESTOR, U.SETOR_ID, S.NOME AS SETOR, U.ARMARIO, U.MATRICULA, U.PERMISSAO_ID, P.NOME AS PERMISSAO, U.OBSERVACAO, U.SITUACAO  FROM USUARIO U INNER JOIN TURNO T ON T.ID=U.TURNO_ID INNER JOIN PERMISSAO P ON P.ID=U.PERMISSAO_ID INNER JOIN USUARIO UG ON UG.ID=U.GESTOR_ID INNER JOIN SETOR S ON S.ID=U.SETOR_ID INNER JOIN CARGO C ON C.ID=U.CARGO_ID WHERE ".$f;
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
			<h3 class="title"><i class="fas fa-calendar-plus"></i> Atualizar Usuário</h3>
		<hr>
	<main>
	<form id="form" action="user-update.php" method="POST" onsubmit="return check()">
		<div class="field">
			<label class="label is-size-7-touch" for="textInput">Nome Completo*</label>
			<div class="control has-icons-left has-icons-right" id="name">
				<input name="name" onkeypress="addLoadField('name')" onkeyup="rmvLoadField('name')" type="text" class="input required" placeholder="Harry Will"  maxlength="200" onblur="checkAdress(form.name, 'msgOk1','msgNok1')" id="input1" value="<?php echo $dados["NOME"];?>" >
				<span class="icon is-small is-left">
			   		<i class="fas fa-user-circle"></i>
			   	</span>
			   	<div id="msgNok1" style="display:none;">
			    	<span class="icon is-small is-right">
			      		<i class="fas fa-fw"></i>
			    	</span>
			    	<p class="help is-danger">O nome é obrigatório</p>		    	
			   	</div>
			   	<div id="msgOk1" style="display:none;">
			    	<span class="icon is-small is-right">
			      		<i class="fas fa-check"></i>
			    	</span>
			   	</div>
			</div>
		</div><!--END BLOCK ONE-->
		<!--BLOCK TWO-->
		<div class="field">
			<label class="label is-size-7-touch" for="textInput">Login*</label>
			<div class="control has-icons-left has-icons-right" id="name">
				<input name="login" onkeypress="addLoadField('login')" onkeyup="rmvLoadField('login')" type="text" class="input required" placeholder="harry.will"  maxlength="60" onblur="checkAdress(form.login, 'msgOk2','msgNok2')" id="input2" value="<?php echo $dados["LOGIN"];?>">
				<span class="icon is-small is-left">
			   		<i class="fas fa-user"></i>
			   	</span>
			   	<div id="msgNok2" style="display:none;">
			    	<span class="icon is-small is-right">
			      		<i class="fas fa-user"></i>
			    	</span>
			    	<p class="help is-danger">O login é obrigatório</p>		    	
			   	</div>
			   	<div id="msgOk2" style="display:none;">
			    	<span class="icon is-small is-right">
			      		<i class="fas fa-check"></i>
			    	</span>
			   	</div>
			</div>
			<p class="help">Use de preferência texto caixa baixa, primeiro e último nome p/ manter a padronização de nome de login.</p>
		</div><!--END BLOCK TWO-->
		<!--BLOCK THREE-->
		<div class="field">
			<label class="label is-size-7-touch" for="textInput">Senha*</label>
			<div class="control has-icons-left has-icons-right" id="password">
				<input name="password" type="password" class="input required" placeholder="&634kfa@934301" maxlength="32" onkeypress="addLoadField('password')" onkeyup="rmvLoadField('password')" onblur="checkAdress(form.password, 'msgOk3','msgNok3')" id="input3" value="<?php echo $dados["SENHA"];?>">
				<span class="icon is-small is-left">
					<i class="fas fa-lock-open"></i>
				</span>
				<div id="msgNok3" style="display:none;">
				   	<span class="icon is-small is-right">
				   		<i class="fas fa-fw"></i>
				   	</span>
				   	<p class="help is-danger">A senha é obrigatória</p>		    	
				</div>
				<div id="msgOk3" style="display:none;">
				   	<span class="icon is-small is-right">
				   		<i class="fas fa-check"></i>
				   	</span>
				</div>
			</div>			
		</div><!--END BLOCK THREE-->
		<!--BLOCK FOUR-->
		<div class="field">
		  	<label class="label">Email</label>
		  	<div class="control has-icons-left has-icons-right" id="emailLoad">
		    	<input name="email" class="input required" id="email" type="text" placeholder="willvix@outlook.com" onblur="validacaoEmail(form.email)"  maxlength="50" onkeypress="addLoadField('emailLoad')" onkeyup="rmvLoadField('emailLoad')" value="<?php echo $dados["EMAIL"];?>">
		    	<span class="icon is-small is-left">
		      		<i class="fas fa-envelope" id="iconMail"></i>
		    	</span>
		    	<div id="msgemail" style="display:none;">
			    	<span class="icon is-small is-right">
			      		<i class="fas fa-exclamation-triangle"></i>
			    	</span>
			    	
			    	<p class="help is-danger">E-mail inválido, este campo é obrigatório!</p>		    	
		    	</div>
		  	</div>		  	
		</div><!--ENDS BLOCK FOUR-->
		<!--BLOCK FIVE-->
		<div class="field is-horizontal">
			<div class="field srf20"><!--Campo nascimento-->
				<label class="label is-size-7-touch" for="textInput">Nascimento*</label>
				<div class="control has-icons-left has-icons-right" id="birth">
					<input name="birth" onkeypress="addLoadField('birth')" onkeyup="rmvLoadField('birth')" type="text" class="input required registro sf17" placeholder="1992-12-31"  maxlength="10" onblur="checkAdress(form.birth, 'msgOk4','msgNok4')" id="input4" value="<?php echo $dados["NASCIMENTO"];?>">
					<span class="icon is-small is-left">
				   		<i class="fas fa-calendar-alt"></i>
				   	</span>
				   	<div id="msgNok4" style="display:none;">
				    	<span class="icon is-small is-right">
				      		<i class="fas fa-fw"></i>
				    	</span>
				    	<p class="help is-danger">A data de nascimento é obrigatória</p>		    	
				   	</div>
				   	<div id="msgOk4" style="display:none;">
				    	<span class="icon is-small is-right">
				      		<i class="fas fa-check"></i>
				    	</span>
				   	</div>
				</div>
			</div>
			<div class="field srf20">
				<label class="label is-size-7-touch" for="textInput">Celular*</label>
				<div class="control has-icons-left has-icons-right" id="phone">
					<input name="phone" onkeypress="addLoadField('phone')" onkeyup="rmvLoadField('phone')" type="text" class="input required celular sf17" placeholder="(27)99296-8195"  maxlength="13" onblur="checkAdress(form.phone, 'msgOk5','msgNok5')" id="input5" value="<?php echo $dados["CELULAR"];?>">
					<span class="icon is-small is-left">
				   		<i class="fas fa-phone"></i>
				   	</span>
				   	<div id="msgNok5" style="display:none;">
				    	<span class="icon is-small is-right">
				      		<i class="fas fa-fw"></i>
				    	</span>
				    	<p class="help is-danger">O celular é obrigatório</p>		    	
				   	</div>
				   	<div id="msgOk5" style="display:none;">
				    	<span class="icon is-small is-right">
				      		<i class="fas fa-check"></i>
				    	</span>
				   	</div>
				</div>
			</div>
			<div class="field srf20" ><!--Seleção sexo-->
				<label class="label is-size-7-touch" for="textInput">Sexo*</label>
				<div class="control has-icons-left">
					<div class="select">
					  	<select name="sex" class="sf23-15 required " onchange="change(this.value)"><?php
					  		if ($dados["SEXO"] == "m") {							
								echo "<option selected='selected' value='m'>Masculino</option>";
								echo "<option value='f'>Feminino</option>";
							} else {	
								echo "<option selected='selected' value='f'>Feminino</option>";
								echo "<option value='m'>Masculino</option>";
							}
						?></select>
					</div>
					<div class='loadId'>
						<span class="icon is-small is-left" >
						  	<i class="fas fa-street-view"></i>
						</span>
					</div>
					<div class='loadId' id="m" style="display: none;">
						<span class="icon is-small is-left" >
						  	<i class="fas fa-male"></i>
						</span>
					</div>
					<div class='loadId' id="f" style="display: none;">
						<span class="icon is-small is-left"  >
						  	<i class="fas fa-female"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="field srf20"><!--Seleção role-->
				<label class="label is-size-7-touch" for="textInput">Cargo*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  	<select name="role" class="sf23-15">
					  		<option selected="selected" value="<?php echo $dados["CARGO_ID"];?>"><?php echo $dados["CARGO"];?></option>
					  		<?php
							$cnx = mysqli_query($phpmyadmin , "SELECT ID, NOME FROM CARGO WHERE SITUACAO='Ativo' AND ID<>".$dados["CARGO_ID"]);
							while($cargo = $cnx->fetch_array()){
								echo "<option value=" . $cargo["ID"] . ">" . $cargo["NOME"] . "</option>";
							} 
						?></select>
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
					<input name="admission" onkeypress="addLoadField('admission')" onkeyup="rmvLoadField('admission')" type="text" class="input required registro sf17" placeholder="2018-01-22"  maxlength="10" onblur="checkAdress(form.admission, 'msgOk8','msgNok8')" id="input8" value="<?php echo $dados["EFETIVACAO"];?>">
					<span class="icon is-small is-left">
				   		<i class="fas fa-calendar-alt"></i>
				   	</span>
				   	<div id="msgNok8" style="display:none;">
				    	<span class="icon is-small is-right">
				      		<i class="fas fa-fw"></i>
				    	</span>
				    	<p class="help is-danger">A data de admissão é obrigatória</p>		    	
				   	</div>
				   	<div id="msgOk8" style="display:none;">
				    	<span class="icon is-small is-right">
				      		<i class="fas fa-check"></i>
				    	</span>
				   	</div>
				</div>
			</div>
			<div class="field srf20"><!--Seleção turno-->
				<label class="label is-size-7-touch" for="textInput">Turno*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="shift" class="sf17">
					  			<option selected="selected" value="<?php echo $dados["TURNO_ID"];?>"><?php echo $dados["TURNO"];?></option>
					  			<?php  
								$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM TURNO WHERE SITUACAO = 'Ativo'AND ID<>".$dados["TURNO_ID"]); 
								while ($shift = $cnx->fetch_array()) { 
									echo "<option value=" . $shift["ID"] . ">" . $shift["NOME"] . "</option>";
								} 
							?></select>
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
					  		<select name="sector" class="sf23-15"><?php  
								$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo';"); 
								while ($role = $cnx->fetch_array()) { 
									echo "<option value=" . $role["ID"] . ">" . $role["NOME"] . "</option>";
								} 
							?></select>
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
					  		<select name="leader" class="sf23-15" onchange="upIconVehicle(this.value)">
					  			<option selected="selected" value="<?php echo $dados["GESTOR_ID"];?>"><?php echo $dados["GESTOR"];?></option><?php 
								$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM USUARIO WHERE SITUACAO='Ativo' AND PERMISSAO_ID>1 AND ID<>".$dados["GESTOR_ID"]." ORDER BY 2"); 
								while ($leader = $cnx->fetch_array()) { 
									echo "<option value=" . $leader["ID"] . ">" . $leader["NOME"] . "</option>";
								} 
							?></select>
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
					<input name="wardrobe" onkeypress="addLoadField('wardrobe')" onkeyup="rmvLoadField('wardrobe')" type="text" class="input numero sf17" placeholder="162"  maxlength="3" onblur="checkAdress(form.wardrobe, 'msgOk12','msgNok12')" id="input12" value="<?php echo $dados["ARMARIO"];?>">
					<span class="icon is-small is-left">
				   		<i class="fas fa-briefcase"></i>
				   	</span>
				   	<div id="msgOk12" style="display:none;">
				    	<span class="icon is-small is-right">
				      		<i class="fas fa-check"></i>
				    	</span>
				   	</div>
				</div>
			</div>
			<div class="field srf20"><!--Campo matricula-->
				<label class="label is-size-7-touch" for="textInput">Matricula ADP*</label>
				<div class="control has-icons-left has-icons-right" id="registration">
					<input name="registration" onkeypress="addLoadField('registration')" onkeyup="rmvLoadField('registration')" type="text" class="input required numero sf17" placeholder="629"  maxlength="4" onblur="checkAdress(form.registration, 'msgOk13','msgNok13')" id="input13" value="<?php echo $dados["MATRICULA"];?>">
					<span class="icon is-small is-left">
				   		<i class="fas fa-ad"></i>
				   	</span>
				   	<div id="msgNok13" style="display:none;">
				    	<span class="icon is-small is-right">
				      		<i class="fas fa-fw"></i>
				    	</span>
				    	<p class="help is-danger">A matricula é obrigatória</p>		    	
				   	</div>
				   	<div id="msgOk13" style="display:none;">
				    	<span class="icon is-small is-right">
				      		<i class="fas fa-check"></i>
				    	</span>
				   	</div>
				</div>
			</div>
			<div class="field srf20"><!--Seleção permissão-->
				<label class="label is-size-7-touch" for="textInput">Permissão*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="permission" class="sf23-15">
					  			<option selected="selected" value="<?php echo $dados["PERMISSAO_ID"];?>"><?php echo $dados["PERMISSAO"];?></option><?php 
								$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM PERMISSAO WHERE SITUACAO='Ativo' AND ID<=".$_SESSION["permissao"]." AND ID<>".$dados["PERMISSAO_ID"]); 
								while ($role = $cnx->fetch_array()) { 
									echo "<option value=" . $role["ID"] . ">" . $role["NOME"] . "</option>";
								} 
							?></select>
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
					  		<select name="situation" class="sf23-15">
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
					<input name="note" type="text" class="input" id="textInput" placeholder="Exemplo:Informações de e-mail e celular pedente." maxlength="250" onkeypress="addLoadField('note')" onkeyup="rmvLoadField('note')" value="<?php echo $dados["OBSERVACAO"]?>">
				</div>			
		</div><!--END BLOCK EIGHT-->
		<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<input name="update" type="submit" class="button is-primary btn128" value="Atualizar"/>
				</div>
				<?php 
				if ( $_SESSION["permissao"] > 1){
					echo "<div class='control'>
						<a href='user-update.php' class='button is-primary btn128'>Voltar</a>
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
<?php

if(isset($_POST['update'])){
	$checkLogin = "SELECT LOGIN FROM USUARIO WHERE LOGIN = '" . $login . "' AND ID <> " . $_SESSION["upUser"];//VALIDAÇÃO SE LOGIN É ÚNICO.
	$result = mysqli_query($phpmyadmin, $checkLogin);		 
	$check = mysqli_num_rows($result);	
	
	if ($check >= 1) {
		echo "<script>alert('Já existe usuário com o mesmo Login!');</script>";
	} else {		
		$cx = mysqli_query($phpmyadmin, "SELECT SENHA FROM USUARIO WHERE ID = " . $_SESSION["upUser"] . " AND SENHA ='" . $_POST['password'] . "';");
		
		if ($_POST['situation'] == 'Desligado') {
			$desligadoEm = ", DESLIGADO_EM = '" . date('Y-m-d') . "'";
		} else {
			$desligadoEm = ", DESLIGADO_EM = NULL";
		}
		
		if ($_POST['wardrobe'] == "" || $_POST['wardrobe'] == null) {				
			$wardrobe = 0;
		} else {
			$wardrobe = $_POST['wardrobe'];
		}	

		if (mysqli_num_rows($cx) == 0 || mysqli_num_rows($cx) == "") {
			$upUser = "UPDATE USUARIO SET NOME = '" . $_POST['name'] . "', LOGIN='" . $_POST['login'] . "', SENHA=MD5('" . $_POST['password'] . "'), EMAIL='" . $_POST['email'] . "', SEXO='" . $_POST['sex'] . "', CELULAR='" . $_POST['phone'] . "', NASCIMENTO='" . $_POST['birth'] . "', CARGO_ID=" . $_POST['role'] . ", TURNO_ID=" . $_POST['shift'] . ",GESTOR_ID=" . $_POST['leader'] . ", SETOR_ID=" . $_POST['sector'] . ", ARMARIO=" . $wardrobe . ",MATRICULA=" . $_POST['registration'] . ", EFETIVACAO='" . $_POST['admission'] . "', PERMISSAO_ID=" . $_POST['permission'] . ",OBSERVACAO='" . $_POST['note'] . "', SITUACAO='" . $_POST['situation'] . "'" . $desligadoEm . " WHERE ID=".$_SESSION["upUser"].";";				
		} else {
			$upUser = "UPDATE USUARIO SET NOME='" . $_POST['name'] . "', LOGIN='" . $_POST['login'] . "', EMAIL='" . $_POST['email'] . "', SEXO='" . $_POST['sex'] . "', CELULAR='" . $_POST['phone'] . "', NASCIMENTO='" . $_POST['birth'] . "', CARGO_ID=" . $_POST['role'] . ", TURNO_ID=" . $_POST['shift'] . ",GESTOR_ID=" . $_POST['leader'] . ", SETOR_ID=" . $_POST['sector'] . ", ARMARIO=" . $wardrobe . ", MATRICULA=" . $_POST['registration'] . ", EFETIVACAO='" . $_POST['admission'] . "', PERMISSAO_ID=" . $_POST['permission'] . ",OBSERVACAO='" . $_POST['note'] . "', SITUACAO='" . $_POST['situation'] . "'" . $desligadoEm . " WHERE ID=" . $_SESSION["upUser"] . ";";
		}
		
		$cnx = mysqli_query($phpmyadmin, $upUser);					
		
		if (mysqli_error($phpmyadmin) == null) {
			echo $redirect;					
		} else { 
			echo "<script> alert('Erro ao atualizar!!!');</script>";
			echo mysqli_error($phpmyadmin);
		}
		
	}	
}

?>