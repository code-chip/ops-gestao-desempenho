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
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style type="text/css" src="css/personal.css"></style>
	<title>Gestão de Desempenho - Inserir Penalidade</title>
	<script type="text/javascript">
		$(document).ready(function(){
	    	$(window).scroll(function(){
	        	if ($(this).scrollTop() > 100) {
	            	$('a[href="#topo"]').fadeIn();
	        	}else {
	            	$('a[href="#topo"]').fadeOut();
	        	}
	    	});
	    	$('a[href="#topo"]').click(function(){
	        	$('html, body').animate({scrollTop : 0},800);
	        	return false;
	    	});
		});
	</script>
</head>
<body>
	<section class="section">
	<?php if (!isset($_POST['pesquisar'])) : ?>	
	  	<div class="container">
	  		<form action="penalty-update.php" method="POST" id="form1">
	  			<div class="field">
					<label class="label is-size-7-touch">Setor*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="setor" id="setor">
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
				<div class="field">
					<label class="label is-size-7-touch">Colaborador*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="usuario" id="usuario" class="required">
								<option selected="selected" value="Todos">Selecione</option>
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-user-alt"></i>
							</span>	
						</div>
					</div>					
				</div>
				<div class="field">
					<label class="label is-size-7-touch">Ano/Mês*</label>
					<div class="control has-icons-left has-icons-right is-fullwidth" id="anoMes">
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
				<div class="field-body">
					<div class="field is-grouped">							
						<div class="control">
							<button name="pesquisar" type="submit" class="button is-primary btn128" value="pesquisar">Pesquisar</button>
						</div>
						<div class="control">
							<button name="limpar" type="reset" class="button is-primary btn128" onclick="clearForm()">Limpar</button>
						</div>
						<div class="control">
							<a href="home.php" class="button is-primary btn128">Cancelar</a>
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
							$('#usuario').html('<option value="Todos">Todos do Setor</option>');
						}
					});
				});
			</script>
	   	</div>
	<?php echo "</section>";
	
	endif;

	if (isset($_POST['pesquisar'])) {
		if($_POST['usuario'] != 'Todos') {
			$filter = "SELECT P.*, PT.TIPO, PT.PENALIDADE, U.NOME FROM PENALIDADE P INNER JOIN PENALIDADE_TIPO PT ON PT.ID = P.PENALIDADE_TIPO_ID INNER JOIN USUARIO U ON U.ID = P.USUARIO_ID WHERE USUARIO_ID = " . $_POST['usuario'] . " AND ANO_MES = '" . $_POST['anoMes'] . "';";
		} else {
			$filter = "SELECT P.*, PT.TIPO, PT.PENALIDADE, U.NOME FROM PENALIDADE P INNER JOIN PENALIDADE_TIPO PT ON PT.ID = P.PENALIDADE_TIPO_ID INNER JOIN USUARIO U ON U.ID = P.USUARIO_ID WHERE USUARIO_ID IN (SELECT ID FROM USUARIO WHERE SETOR_ID = " . $_POST['setor'] . ") AND ANO_MES = '" . $_POST['anoMes'] . "';";
		}
		
		$cnx = mysqli_query($phpmyadmin, $filter);

		if (isset($_POST['pesquisar']) && mysqli_num_rows($cnx) == 0) {
			echo "<script>alert('Nenhum registrado encontrado com o filtro utilizado.'); window.location.href='penalty-update.php';</script>";
		}

		$x = 0;
		while ($dice = $cnx->fetch_array()) {
			$id[$x] = $dice['ID'];
			$idType[$x] = $dice['PENALIDADE_TIPO_ID'];
			$idUser[$x] = $dice['USUARIO_ID'];
			$name[$x] = $dice['NOME'];
			$occurence[$x] = $dice['OCORRENCIA'];
			$penalty[$x] = $dice['PENALIDADE'];			
			$penaltyTotal[$x] = $dice['PENALIDADE_TOTAL'];
			$yearMonth[$x] = $dice['ANO_MES'];
			$observation[$x] = $dice['OBSERVACAO'];
			$register[$x] = $dice['REGISTRO'];
			$type[$x] = $dice['TIPO'];
			$x++;
		}
	}

	$cnx2 = mysqli_query($phpmyadmin, "SELECT ID, TIPO FROM PENALIDADE_TIPO");
	$y = 0;

	while ($dice = $cnx2->fetch_array()) {
		$listIdType[$y] = $dice['ID'];
		$listNameType[$y] = $dice['TIPO'];
		$y++;
	}

	if ($x > 0) : { ?>
		<form action="penalty-update.php" method="POST" onsubmit="return check()" id="form2">
		<table class="table__wrapper table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch scrollWrapper">
			<tr><td>N°</td>
			<td>+</td>
			<td>Nome</td>
			<td>Tipo</td>
			<td>Penalidade</td>
			<td>Ocorrencia's</td>
			<td>Registro</td>
			<td>Observação</td></tr>
			<?php

			$i = 0;
			$z = 0;

		while ( $i < $x) {
		if ($idType[$i] == $listIdType[$z]): { ?>
			<tr><td><?php echo $i+1;?></td>
			<td class="field"><!--COLUNA VETOR-->
			<div class="field">				
				<div class="control">					
					<input name="vetor[]" type="checkbox" class="checkbox is-size-7-touch" checkbox="checked" value="<?php echo $id[$i]?>">
				</div>
			</div>
			</td>		
			<td class="field"><!--COLUNA NOME-->
			<div class="field">				
				<div class="control">
					<?php echo $name[$i]?>
				</div>				
			</div>
			</td>		
			<td><!--SELEÇÃO TIPO-->						
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select is-size-7-touch">
							<select name="tipo[]" disabled><?php								
								$con = mysqli_query($phpmyadmin , "SELECT ID, TIPO FROM PENALIDADE_TIPO WHERE SITUACAO ='s' AND ID<> " . $idType[$i]);
								echo "<option value=" . $idType[$i] . ">" . $type[$i] . "</option>"; 
								while($loadType = $con->fetch_array()){
									echo "<option value=" . $loadType["ID"] . ">" . $loadType["TIPO"] . "</option>";
								} ?>																		
							</select>	
						</div>
					</div>					
				</div>						
			</div>
			</td>		
			<td><!--COLUNA PENALIDADE-->
			<div class="field">				
				<div class="control">
					<input name="penalty[]" style="max-width:5.5em;" type="text" class="input desempenho is-size-7-touch" placeholder="Obrigatório" maxlength="4" value="<?php echo $penalty[$i]; ?>" readonly>
				</div>				
			</div>
			</td>
			<td><!--COLUNA OCORRENCIA-->
			<div class="field">				
				<div class="control">
					<input name="occurence[]" style="max-width:5.5em;" type="text" class="input desempenho is-size-7-touch" placeholder="Obrigatório" maxlength="4" value="<?php echo $occurence[$i]; ?>">
				</div>				
			</div>
			</td>
			<td><!--COLUNA DATA-->
			<div class="field">				
				<div class="control">
					<input name="register[]" style="max-width:6.5em;" type="text" class="input registro is-size-7-touch" value="<?php echo $register[$i];?>" maxlength="10">
				</div>				
			</div>
			</td>
			<td><!--COLUNA OBSERVAÇÃO-->	
			<div class="field">				
				<div class="control">
					<input name="observation[]" type="text" class="input is-size-7-touch" placeholder="Máximo 200 caracteres." maxlength="200" value="<?php echo $observation[$i]; ?>">
				</div>				
			</div>
			</td></tr>						
			<?php 

			$i++;
			$z = 0;
		} endif;

		if ( $idType[$i] != $listIdType[$z]) {
			$z++;
		}	
	}
					
		?>
		</table>
		<a href="#topo">
			<div class="field is-grouped is-grouped-right">
				<button class="button is-primary is-fullwidth is-size-7-touch">Ir Ao Topo</button>		
			</div>
		</a>
		<br/>
		<div class="field is-horizontal">
			<div class="field-label is-normal">
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<button name="updatePenalty" type="submit" class="button is-primary" value="update">Atualizar</button>
					</div>
					<div class="control">
						<a href="penalty-update.php" class="button is-primary">Voltar</a>
					</div>
					<div class="control">
						<a href="home.php" class="button is-primary">Cancelar</a>
					</div>						
				</div>
			</div>
		</div>	
	    </form>
	    <?php
	
	} endif;

	?>
</body>
</html>
<?php

if (isset($_POST["updatePenalty"]) != null && isset($_POST["vetor"])) {
	$id = array_filter($_POST['vetor']);
	$observation = array_filter($_POST['observation']);
	$penalty = array_filter($_POST['penalty']);
	$occurence = array_filter($_POST['occurence']);
	$register = array_filter($_POST['register']);
	
	for ( $i = 0; $i < sizeof($id); $i++ ) {
		$yearMonth = new DateTime($register[$i]);
		$yearMonth = $yearMonth->format('Y-m');

		$update = "UPDATE PENALIDADE SET OCORRENCIA = " . $occurence[$i] . ", PENALIDADE_TOTAL = " . $penalty[$i] * $occurence[$i] . ", ANO_MES = '" . $yearMonth . "', REGISTRO = '" . $register[$i] . "', OBSERVACAO = '" . $observation[$i] . "' WHERE ID = " . $id[$i];
		$cnx = mysqli_query($phpmyadmin, $update);
	}
	
	if (mysqli_error($phpmyadmin) == null) {
		echo "<script>alert('Penalidade atualizada com sucesso!'); window.location.href=window.location.href; </script>";
	} else {
		echo "<script>alert('Erro ao atualizar penalidade!!'); window.location.href=window.location.href; </script>";
	}
} else if (isset($_POST["updatePenalty"]) != null) {
	echo "<script>alert('Nenhum registro selecionado na coluna + p/ ser atualizado!'); window.location.href=window.location.href; </script>";
}

?>