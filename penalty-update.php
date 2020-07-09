<?php

$menuAtivo = 'penalidade';
require('menu.php');

if ($_SESSION["permissao"] == 1){
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php'; </script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<ocorrencia charset="UTF-8">	
	<ocorrencia name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir Penalidade</title>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones-->
	<script type="text/javascript" src="js/myjs.js"></script>
	<style type="text/css">
		.carregando{
			color:#ff0000;
			display:none;
		}
		.button{ 
			width: 121px;
		}
	</style>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  		<?php if (!isset($POST['consultar'])) : ?>
	  		<form action="penalty-update.php" method="POST" id="form1">
	  			<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Setor:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control has-icons-left">
								<div class="select is-size-7-touch">
									<select name="setor" id="setor" style="width:24.2em;">
									<option value="">Selecione</option><?php
										$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo' ORDER BY NOME");
										while ($reSetor = mysqli_fetch_assoc($cnx)) {
											echo '<option value="'.$reSetor['ID'].'">'.$reSetor['NOME'].'</option>';
										} ?>
									</select>
									<span class="icon is-small is-left">
										<i class="fas fa-door-open"></i>
									</span>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Colaborador:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control has-icons-left">
								<div class="select">
									<span class="carregando">Aguarde, carregando...</span>
									<select name="usuario" id="usuario" class="required" style="width:24.2em;">
										<option selected="selected" value="">Selecione</option>
									</select>
									<span class="icon is-small is-left">
										<i class="fas fa-user-alt"></i>
									</span>	
								</div>
							</div>
						</div>
					</div>					
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Ano/Mês*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="anoMes">
								<input type="text" class="input required maskAnoMes" name="anoMes" placeholder="2020-05" maxlength="7" onkeypress="addLoadField('anoMes')" onkeyup="rmvLoadField('anoMes')" onblur="checkAdress(form1.anoMes, 'msgOk1','msgNok1')" id="input1">
								<span class="icon is-small is-left">
							   		<i class="fas fa-calendar-alt"></i>
							   	</span>
								<div id="msgNok1" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">Ano/Mês do Peso é obrigatório</p>		    	
							   	</div>
							   	<div id="msgOk1" style="display:none;">
							    	<span class="icon is-small is-right">
							      		<i class="fas fa-check"></i>
							    	</span>
							   	</div>
							</div>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control">
								<button name="inserirPenalidade" type="submit" class="button is-primary" value="inserir">Pesquisar</button>
							</div>
							<div class="control">
								<button name="limpar" type="reset" class="button is-primary">Limpar</button>
							</div>
							<div class="control">
								<a href="home.php" class="button is-primary">Cancelar</a>
							</div>						
						</div>
					</div>
				</div>
	  		</form>
	  		<?php endif ?>
	   			    			
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Penalidade:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control has-icons-left">
								<div class="select is-size-7-touch">
									<select name="penalidade" style="width:24.2em;"><?php
									$con = mysqli_query($phpmyadmin ,"SELECT ID, TIPO FROM PENALIDADE_TIPO WHERE SITUACAO = 's' ORDER BY TIPO");  
									while($penalidade = $con->fetch_array()){
										echo "<option value=" . $penalidade["ID"] . ">" . $penalidade["TIPO"] . "</option>";
									} ?>
									</select>
									<span class="icon is-small is-left">
							   		<i class="fas fa-angle-double-down"></i>
								   	</span>
								</div>
							</div>						
						</div>
					</div>
				</div>
				
			<form action="penalty-update.php" method="POST" onsubmit="return check()" id="form2">
				<table>
					
				</table>>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control">
								<button name="inserirPenalidade" type="submit" class="button is-primary" value="inserir">Inserir</button>
							</div>
							<div class="control">
								<button name="limpar" type="reset" class="button is-primary">Limpar</button>
							</div>
							<div class="control">
								<a href="home.php" class="button is-primary">Cancelar</a>
							</div>						
						</div>
					</div>
				</div>	
	     	</form>
	     	<script type="text/javascript" scr="https://www.google.com/jsapi"></script>
	     	<script type="text/javascript">
	     		google.loader("jquery", "1.4.2");
	     	</script>
	     	<script type="text/javascript">
				$(function(){
					$('#setor').change(function(){
						if( $(this).val() ) {
							$('#usuario').hide();
							$('.carregando').show();
							$.getJSON('loading-users.php?search=',{setor: $(this).val(), ajax: 'true'}, function(j){
								var options = '<option value="Todos">Todos do Setor</option>';	
								for (var i = 0; i < j.length; i++) {
									options += '<option value="' + j[i].id + '">' + j[i].nome_usuario + '</option>';
								}	
								$('#usuario').html(options).show();
								$('.carregando').hide();
							});
						} else {
							$('#usuario').html('<option value="">Todos do Setor</option>');
						}
					});
				});
			</script>
	   	</div>
	</section>	 	
</body>
</html><?php

if (isset($_POST["inserirPenalidade"]) != null) {
	$cnx= mysqli_query($phpmyadmin, "INSERT INTO PENALIDADE(PENALIDADE_TIPO_ID, USUARIO_ID, OCORRENCIA, PENALIDADE_TOTAL, ANO_MES, OBSERVACAO, REGISTRO) VALUES(" . $_POST['penalidade'] . ", " . $_POST['usuario'] . "," . $_POST['ocorrencia'] . ",(SELECT PENALIDADE*" . $_POST['ocorrencia'] . " FROM PENALIDADE_TIPO WHERE ID=" . $_POST['penalidade'] . " ), '" . $_POST['anoMes'] . "', '" . $_POST['descricao'] . "', '" . date('Y-m-d') . "');");
		
	$erro = mysqli_error($phpmyadmin);
	if ($erro == null) {
		echo "<script>alert('Penalidade inserida com sucesso!')</script>";	
	} else {
		?><script>var erro="<?php echo $erro;?>";  alert('Erro ao cadastrar: '+erro)</script><?php
	}
}

?>