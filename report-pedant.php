<?php

$menuAtivo = 'desempenho';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
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
	<title>Gestão de Desempenho - Desempenho Pedentes</title>
    <script type="text/javascript">
    	$(document).ready(function(){
	    	$(window).scroll(function(){
	        	if ($(this).scrollTop() > 100) {
	            	$('a[href="#top"]').fadeIn();
	        	}else {
	            	$('a[href="#top"]').fadeOut();
	        	}
	    	});
	    	$('a[href="#top"]').click(function(){
	        	$('html, body').animate({scrollTop : 0},800);
	        	return false;
	    	});
		});
		//SALVAR OPÇÃO SELECIONADA;
		$(window).on("load", onPageLoad);
		function onPageLoad() {
			initListeners();
			restoreSavedValues();
		}
		function initListeners() {
			$("#salvaTurno").on("change", function() {
				var value = $(this).val();
				localStorage.setItem("salvaTurno", value);
			}); 
		}
		function restoreSavedValues() {
			var storedValue = localStorage.getItem("salvaTurno");
			$("#salvaTurno").val(storedValue);
		}		
		$('#submitQuery').button().click(function(){
			$('#form1').submit();
		});		    	
    </script>
</head>
<body>
	<span id="topo"></span>
	<?php if ($setor == "" && isset($_POST['query']) == null ) : { ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="" method="POST" onsubmit="return check()">
		<div class="field">
			<label class="label is-size-7-touch">Turno*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth norequired">
			  		<select name="shift" class="is-fullwidth norequired " autofocus><?php
						$con = mysqli_query($phpmyadmin , "SELECT ID, NOME FROM TURNO");
						while ($_REQUEST['turno'] = $con->fetch_array()) { 
							echo "<option value=" . $_REQUEST['turno']["ID"] . ">" . $_REQUEST['turno']["NOME"] . "</option>";
						}?>
					</select>
				</div>
				<span class="icon is-small is-left" >
				  	<i class="fas fa-clock"></i>
				</span>
			</div>
		</div>
		<div class="field">
			<label class="label is-size-7-touch">Setor*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth" id="sector3">
					<select name="sector" id="sector" class="norequired is-fullwidth "><?php
						$con = mysqli_query($phpmyadmin , "SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'");
						while ($sector = $con->fetch_array()) {
							echo "<option value=" . $sector["ID"] . ">". $sector["NOME"] . "</option>";
						}
						?>
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-door-open"></i>
					</span>
				</div>						
			</div>
		</div>								
		<div class="field">
			<label class="label is-size-7-touch">Data*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth" id="date">
					<input name="date" type="text" onkeypress="addLoadField('date')" onkeyup="rmvLoadField('date')" class="input norequired" placeholder="Ana Clara ou deixe em branco p/ consultar todos." id="input3" value="<?php echo date('Y-m-d',strtotime('-1 day'));?>">
					<span class="icon is-left">
						<i class="fas fa-calendar-alt"></i>
					</span>
					<div id="msgOk3" style="display:none;"></div>	
				</div>
			</div>					
		</div>
		<div class="field-body is-fullwidth">
			<div class="field is-grouped is-fullwidth">
				<div class="control is-fullwidth">
					<button name="query" type="submit" class="button is-primary btn128" value="filter">Consultar</button>
				</div>
				<div class="control">
					<button name="clear" type="reset" class="button is-primary btn128" onclick="clearForm();">Limpar</button>
				</div>
			</div>
		</div>
	</form>
	</div>
	</section>	
	<?php } endif; ?>		
</div>
<?php

$count = 0;
$totalAlcancado = 0;

if (isset($_POST['query'])) {
	$x = 0;
	$cnx = mysqli_query($phpmyadmin, "SELECT U.ID FROM USUARIO U INNER JOIN DESEMPENHO D ON D.USUARIO_ID=U.ID WHERE U.TURNO_ID=".$_POST['shift']." AND U.SETOR_ID=".$_POST['sector']." AND U.SITUACAO='Ativo' AND D.REGISTRO='".$_POST['date']."' GROUP BY U.ID");
	
	while ($listaId = $cnx->fetch_array()) {
		$vtId[$x] = $listaId["ID"];				
		$x++;
	}
	
	if (mysqli_num_rows($cnx) > 0) {//CASO ENCONTRAR ALGUM REGISTRO NAQUELA DATA, EXECUTA ESTA QUERY.
		$query2 = "SELECT ID, NOME FROM USUARIO WHERE ID NOT IN (".implode(",",$vtId).") AND TURNO_ID=".$_POST['shift']." AND SETOR_ID=".$_POST['sector']." AND SITUACAO='Ativo' ORDER BY NOME;";
	} else {
		$query2 = "SELECT ID, NOME FROM USUARIO WHERE TURNO_ID = ".$_POST['shift']." AND SETOR_ID=".$_POST['sector']." AND SITUACAO='Ativo' ORDER BY NOME;";	
	}
	
	$x = 0;
	$cnx = mysqli_query($phpmyadmin, $query2);
	
	if (mysqli_num_rows($cnx) > 0) {
		while ($user = $cnx->fetch_array()){
			$vtId[$x] = $user["ID"];
			$vtNome[$x] = $user["NOME"];				
			$x++;
			$count = $x;
		}
	} else {
		echo "<script>alert('Nenhum registrado encontrado nesta consulta!'); window.location.href=window.location.href; </script>";		
	}	
} elseif (isset($_POST['query']) != null) {
	echo "<script>alert('A seleção é obrigatória!!'); window.location.href=window.location.href; </script>";	
}	

if (isset($_POST['query']) && $count != 0) : ?>
<hr/>
	<section class="section">
	<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch is-striped is-narrow is-hoverable">	
	<tr>
		<th>N°</th>
		<th>Funcionário</th>
		<th>Registros</th>		
		<th>Sem registro em</th> 			
	</tr>
	<?php 

	for ( $i = 0; $i < sizeof($vtNome); $i++ ) {
		$z = $i; 
		$registro = 1; 

		while ($vtNome[$z] == $vtNome[$z + 1]) {
			$registro++;
			$repeat = $registro;
			$z++;
		}

		if ($repeat > 0) { 
			$repeat--;
		}	
	
	echo "
		<tr>
			<td>" . $i . "</td>
			<td>" . $vtNome[$i] . "</td>
			<td><a href='report-detailed.php?periodo=" . date('Y-m',strtotime($_POST['date'])) . "&idUsuario=" . $vtId[$i] . " target='blank'><button class='button is-primary is-size-7-touch is-fullwidth'>Consultar</button></a>
			<td>" . $_POST['date'] . "</td>
		</tr>";
	} 

	?>
	</table>
	<a href="#top" class="glyphicon glyphicon-chevron-up"></a>
	<a href="#topo">		
		<div class=".scrollWrapper">
			<button class="button is-primary" style="width: 100%; display: table;">Ir Ao Topo</button>		
		</div>
	</a>
	<br/>
	<div class="table__wrapper">			
		<div class="field-body">
			<div class="field is-grouped">											
				<div class="control">
					<input type="submit" class="button is-primary btn128" id="submitQuery" onClick="history.go(0)" value="Atualizar"/>						
				</div>
			<div class="control">
				<a href="report-pedant.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
			</div>					
		</div>						
	</div>
</div>
</section>	
<?php  endif; ?>
</body>
</html>
