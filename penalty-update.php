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
	<?php if (!isset($_POST['pesquisar'])) : ?>	
	  	<div class="container">
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
								<button name="pesquisar" type="submit" class="button is-primary" value="pesquisar">Pesquisar</button>
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
	<?php echo "</section>";
	
	endif;

	if (isset($_POST['pesquisar'])) {
		if($_POST['usuario'] != null) {
			$filter = "SELECT P.*, PT.TIPO, PT.PENALIDADE, U.NOME FROM PENALIDADE P INNER JOIN PENALIDADE_TIPO PT ON PT.ID = P.PENALIDADE_TIPO_ID INNER JOIN USUARIO U ON U.ID = P.USUARIO_ID WHERE USUARIO_ID = " . $_POST['usuario'] . " AND ANO_MES = '" . $_POST['anoMes'] . "';";
		} else {
			$filter = "SELECT P.*, PT.TIPO, PT.PENALIDADE, U.NOME FROM PENALIDADE P INNER JOIN PENALIDADE_TIPO PT ON PT.ID = P.PENALIDADE_TIPO_ID WHERE USUARIO_ID IN (SELECT ID FROM USUARIO INNER JOIN USUARIO U ON U.ID = P.USUARIO_ID WHERE SETOR_ID = " . $_POST['setor'] . ") AND ANO_MES = '" . $_POST['anoMes'] . "';";
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
	while ($dice = $cnx2->fetch_array()) {
		$idType[$y] = $dice['ID'];
		$nameType[$y] = $dice['TIPO'];
	}

	if ($x > 0) : { ?>
		<form action="penalty-update.php" method="POST" onsubmit="return check()" id="form2">
			<table class="table__wrapper table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch scrollWrapper">
				<tr><td>N°</td>
				<td>Nome</td>
				<td>Tipo</td>
				<td>Penalidade</td>
				<td>Ocorrencia's</td>
				<td>Total</td>
				<td>Registro</td>
				<td>Observação</td></tr>
				<?php

				$i = 0;
				$z = 0;
				while ( $i < $x) {
					if ($type[$i] == $idType[$z]) {
						echo "<tr><td>" . $idUser[$i] . "</td>
						<td>" . $name[$i] . "</td>
						<td>" . $type[$i] . "</td>
						<td>" . $penalty[$i] . "</td>
						<td>" . $penaltyTotal[$i] . "</td>
						<td>" . $occurence[$i] . "</td>
						<td>" . $register[$i] . "</td>
						<td>" . $observation[$i] . "</td></tr>";
						$i++;
						$z = 0;
					} else {
						$z++;
					}	
				}
					
			?>
			</table>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
				</div>
				<div class="field-body">
					<div class="field is-grouped">							
						<div class="control">
							<button name="inserirPenalidade" type="submit" class="button is-primary" value="inserir">Atualizar</button>
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
	    <?php
	
	} endif;

	?>
</body>
</html>
<?php

if (isset($_POST["inserirPenalidade"]) != null) {
	$cnx = mysqli_query($phpmyadmin, "INSERT INTO PENALIDADE(PENALIDADE_TIPO_ID, USUARIO_ID, OCORRENCIA, PENALIDADE_TOTAL, ANO_MES, OBSERVACAO, REGISTRO) VALUES(" . $_POST['penalidade'] . ", " . $_POST['usuario'] . "," . $_POST['ocorrencia'] . ",(SELECT PENALIDADE*" . $_POST['ocorrencia'] . " FROM PENALIDADE_TIPO WHERE ID = " . $_POST['penalidade'] . " ), '" . $_POST['anoMes'] . "', '" . $_POST['descricao'] . "', '" . date('Y-m-d') . "');");
		
	$erro = mysqli_error($phpmyadmin);
	if ($erro == null) {
		echo "<script>alert('Penalidade inserida com sucesso!')</script>";	
	} else {
		?><script>var erro = "<?php echo $erro;?>";  alert('Erro ao cadastrar: '+erro)</script><?php
	}
}

?>