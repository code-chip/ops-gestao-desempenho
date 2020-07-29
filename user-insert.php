<?php
$menuAtivo = 'configuracoes';
require('menu.php');

if ($_SESSION['permissao'] == 1) {
	echo "<script>alert('Usuário sem permissão!'); window.location.href='home.php'; </script>";
}

?>
<!DOCTYPE html>
<html>
<head>	
	<title>Gestão de Desempenho - Inserir Usuário</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script type="text/javascript" src="js/myjs.js"></script>
    <link rel="stylesheet" href="css/personal.css" />
</head>
<body>
<div>	
	<section class="section">
		<div class="container">
			<h3 class="title"><i class="fas fa-calendar-plus"></i> Inserir Usuário</h3>
		<hr>
	<main>
	<form id="form" action="user-insert.php" method="POST" onsubmit="return check()">
		<div class="field">
			<label class="label is-size-7-touch" for="textInput">Nome Completo*</label>
			<div class="control has-icons-left has-icons-right" id="name">
				<input name="name" onkeypress="addLoadField('name')" onkeyup="rmvLoadField('name')" type="text" class="input required" placeholder="Harry Will"  maxlength="200" onblur="checkAdress(form.name, 'msgOk1','msgNok1')" id="input1" autofocus>
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
				<input name="login" onkeypress="addLoadField('login')" onkeyup="rmvLoadField('login')" type="text" class="input required" placeholder="harry.will"  maxlength="60" onblur="checkAdress(form.login, 'msgOk2','msgNok2')" id="input2">
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
				<input name="password" type="password" class="input required" placeholder="&634kfa@934301" maxlength="32" onkeypress="addLoadField('password')" onkeyup="rmvLoadField('password')" onblur="checkAdress(form.password, 'msgOk3','msgNok3')" id="input3">
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
		    	<input name="email" class="input required" id="email" type="text" placeholder="willvix@outlook.com" onblur="validacaoEmail(form.email)"  maxlength="50" onkeypress="addLoadField('emailLoad')" onkeyup="rmvLoadField('emailLoad')">
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
					<input name="birth" onkeypress="addLoadField('birth')" onkeyup="rmvLoadField('birth')" type="text" class="input required registro sf17" placeholder="1992-12-31"  maxlength="10" onblur="checkAdress(form.birth, 'msgOk4','msgNok4')" id="input4">
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
					<input name="phone" onkeypress="addLoadField('phone')" onkeyup="rmvLoadField('phone')" type="text" class="input required celular sf17" placeholder="(27)99296-8195"  maxlength="13" onblur="checkAdress(form.phone, 'msgOk5','msgNok5')" id="input5">
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
					  	<select name="sex" class="sf23-15 required " onchange="change(this.value)">
					  		<option value="">Selecione</option>								
							<option value="m">Masculino</option>
							<option value="f">Feminino</option>
						</select>
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
			<div class="field srf20" id="vehicleType"><!--Seleção role-->
				<label class="label is-size-7-touch" for="textInput">Cargo*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="role" class="sf23-15"><?php							
								$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM CARGO WHERE SITUACAO = 'Ativo';"); 
								while ($role = $cnx->fetch_array()) { 
									echo "<option value=" . $role["ID"] . ">" . $role["NOME"] . "</option>";
								} 
							?></select>
						</select>
					</div>
					<div id="carVehicle">
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
					<input name="admission" onkeypress="addLoadField('admission')" onkeyup="rmvLoadField('admission')" type="text" class="input required registro sf17" placeholder="2018-01-22"  maxlength="10" onblur="checkAdress(form.admission, 'msgOk8','msgNok8')" id="input8">
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
			<div class="field srf20" id="vehicleType"><!--Seleção turno-->
				<label class="label is-size-7-touch" for="textInput">Turno*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="shift" class="sf17"><?php  
								$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM TURNO WHERE SITUACAO = 'Ativo';"); 
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
			<div class="field srf20" id="vehicleType"><!--Seleção role-->
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
			<div class="field srf20" id="vehicleType"><!--Seleção gestor-->
				<label class="label is-size-7-touch" for="textInput">Gestor*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="leader" class="sf23-15" onchange="upIconVehicle(this.value)"><?php  
								$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM USUARIO WHERE PERMISSAO_ID > 1 AND SITUACAO = 'Ativo' ORDER BY 2;"); 
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
					<input name="wardrobe" onkeypress="addLoadField('wardrobe')" onkeyup="rmvLoadField('wardrobe')" type="text" class="input numero sf17" placeholder="125"  maxlength="3" onblur="checkAdress(form.wardrobe, 'msgOk12','msgNok12')" id="input12">
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
					<input name="registration" onkeypress="addLoadField('registration')" onkeyup="rmvLoadField('registration')" type="text" class="input required numero sf17" placeholder="629"  maxlength="4" onblur="checkAdress(form.registration, 'msgOk13','msgNok13')" id="input13">
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
			<div class="field srf20" id="vehicleType"><!--Seleção permissão-->
				<label class="label is-size-7-touch" for="textInput">Permissão*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="permission" class="sf23-15"><?php  
								$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM PERMISSAO WHERE ID <= " . $_SESSION["permissao"] . " AND SITUACAO='Ativo';"); 
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
			<div class="field srf20" id="vehicleType"><!--Seleção situação-->
				<label class="label is-size-7-touch" for="textInput">Situação*</label>
				<div class="control has-icons-left">
					<div class="select ">
					  		<select name="situation" class="sf23-15">							
								<option selected="selected" value="Ativo">Ativo</option>	
								<option value="Férias">Férias</option>
								<option value="Licença">Licença</option>
								<option value="Desligado">Desligado</option>														
							</select>
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
					<input name="note" type="text" class="input" id="textInput" placeholder="Exemplo:Informações de e-mail e celular pedente." maxlength="250" onkeypress="addLoadField('note')" onkeyup="rmvLoadField('note')">
				</div>			
		</div><!--END BLOCK EIGHT-->
		<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<input name="insert" type="submit" class="button is-primary btn128" value="Inserir"/>
				</div>
				<div class="control">
					<input name="clear" type="reset" class="button is-primary btn128" value="Limpar"/>
				</div>
				<div class="control">
					<a href="register.php" class="button is-primary btn128">Cancelar</a>										
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
<?php

if (isset($_POST['insert'])) {//VALIDAÇÃO SE LOGIN É ÚNICO.
	$checkLogin = "SELECT LOGIN FROM USUARIO WHERE LOGIN = '" . $_POST['login'] . "';";
	$result = mysqli_query($phpmyadmin, $checkLogin);		 
	$check = mysqli_num_rows($result);	
	
	if ($check >= 1) {
		echo "<script> alert('Já existe usuário com o mesmo Login!'); </script>";
	} else {		
		if ($_POST['wardrobe'] == "" || $_POST['wardrobe'] == null) {				
			$wardrobe = 0;
		} else {
			$wardrobe = $_POST['wardrobe'];
		}	
		
		$user = "INSERT INTO USUARIO(NOME, LOGIN, SENHA, EMAIL, SEXO, CELULAR, NASCIMENTO, CARGO_ID, TURNO_ID, GESTOR_ID, SETOR_ID, ARMARIO, MATRICULA, EFETIVACAO, PERMISSAO_ID, CADASTRADOEM, OBSERVACAO, SITUACAO) VALUES('".$_POST['name']."','".$_POST['login']."',MD5('".$_POST['password']."'),'".$_POST['email']."','".$_POST['sex']."','".$_POST['phone']."','".$_POST['birth']."',".$_POST['role'].",".$_POST['shift'].",".$_POST['leader'].",".$_POST['sector'].", ".$wardrobe.",".$_POST['registration'].",'".$_POST['admission']."',".$_POST['permission'].",'".date('Y-m-d H:i:s')."', '".$_POST['note']."','".$_POST['situation']."')";
		
		$cnx = mysqli_query($phpmyadmin, $user);		
		$erro = mysqli_error($phpmyadmin);
		if ($erro == null) {
			echo "<script> alert('Funcionário inserido com sucesso!!!');</script>";
		} else {?>
			<script type="text/javascript">
				var erro = "<?php echo $erro;?>";
				alert('Erro '+erro+' ao cadastrar!!!');
			</script>
			<?php				
		}
	}	
}

?>