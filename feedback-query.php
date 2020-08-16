<?php
$menuAtivo = 'feedback';
require('menu.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style type="text/css" src="css/personal.css"></style>
	<title>Gestão de Desempenho - Consultar Feedback</title>
</head>
<body>	
<section class="section" id="topo">
<?php if (isset($_POST['query']) == null ) { ?>
	<div class="container">	
	<form id="form1" action="feedback-query.php" method="POST">
		<div class="field">
			<label class="label is-size-7-touch">Ano/Mês*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="yearMonth"><?php
						$cnx = mysqli_query($phpmyadmin, "SELECT ANO_MES FROM FEEDBACK WHERE DESTINATARIO_ID= " . $_SESSION['userId'] . " GROUP BY 1 ORDER BY ANO_MES DESC LIMIT 24");
						while ( $date = $cnx->fetch_array()) {
							echo "<option value=" . $date["ANO_MES"] . ">" . $date["ANO_MES"] . "</option>";
						} ?>
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-calendar-alt"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field">
			<label class="label is-size-7-touch">Tipo*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="type">								
						<option value="feedback">Feedback</option>
						<option value="solicitacao">Solicitação</option>
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-exchange-alt"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field">
			<label class="label is-size-7-touch">Origem*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="origin">								
						<option value="REMETENTE_ID">Enviado(s)</option>
						<option value="DESTINATARIO_ID">Recebido(s)</option>
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-share-square"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field">
			<label class="label is-size-7-touch">Visualização</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="situation">
						<option value="AND F.SITUACAO IN('Aprovado','Lido')">Ambos</option>								
						<option value="AND F.SITUACAO = 'Aprovado'">Novo</option>
						<option value="AND F.SITUACAO = 'Lido'">Lido</option>
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-book-reader"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<button name="query" type="submit" class="button is-primary btn128">Consultar</button>
				</div>
			</div>
		</div>
	</form>
	</div>
<?php }
	
if (isset($_POST['query']) && $_POST["type"] == 'feedback') {
	if ($_POST["origin"]== 'REMETENTE_ID') {
		$query = "SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, FRP.RESPOSTA AS PRO, FRC.RESPOSTA AS COMP, FRD.RESPOSTA AS DES, F.TIPO, F.FEEDBACK, F.EXIBICAO, F.SITUACAO FROM FEEDBACK F INNER JOIN FEEDBACK_RESPOSTA FRP ON FRP.ID=F.PROFISSIONAL INNER JOIN FEEDBACK_RESPOSTA FRC ON FRC.ID=F.COMPORTAMENTAL INNER JOIN FEEDBACK_RESPOSTA FRD ON FRD.ID=F.DESEMPENHO INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID WHERE ".$_POST["origin"]."=".$_SESSION["userId"]." AND ANO_MES = '" . $_POST['yearMonth'] . "' " . $_POST['situation'] . " ORDER BY F.REGISTRO DESC";
	} else {
		$query = "SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, FRP.RESPOSTA AS PRO, FRC.RESPOSTA AS COMP, FRD.RESPOSTA AS DES ,F.TIPO, F.FEEDBACK, F.EXIBICAO, F.SITUACAO FROM FEEDBACK F INNER JOIN FEEDBACK_RESPOSTA FRP ON FRP.ID=F.PROFISSIONAL INNER JOIN FEEDBACK_RESPOSTA FRC ON FRC.ID=F.COMPORTAMENTAL INNER JOIN FEEDBACK_RESPOSTA FRD ON FRD.ID=F.DESEMPENHO INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID WHERE ".$_POST["origin"]."=".$_SESSION["userId"]." AND ANO_MES = '" . $_POST['yearMonth'] . "' " . $_POST['situation'] . " ORDER BY F.REGISTRO DESC";
	}
	
	$x = 0;
	$cnx = mysqli_query($phpmyadmin, $query);
	
	while ($feed = $cnx->fetch_array()) {
		$vtId[$x] = $feed["ID"];
		$vtRemetente[$x] = $feed["REMETENTE"];
		$vtDestinatario[$x] = $feed["DESTINATARIO"];
		$vtTipo[$x] = $feed["TIPO"];
		$vtProfissional[$x] = $feed["PRO"];
		$vtComportamental[$x] = $feed["COMP"];
		$vtDesempenho[$x] = $feed["DES"];
		$vtExibicao[$x] = $feed["EXIBICAO"];
		$vtSituacao[$x] = $feed["SITUACAO"];
		$vtFeedback[$x] = $feed["FEEDBACK"];
		$x++;
		$count = $x;
	}

	if ($x == 0) {
		echo "<script>alert('Nenhum feedback encontrado nesta consulta!'); window.location.href=window.location.href; </script>";		
	}

} else if (isset($_POST['query']) && $_POST["type"] == "solicitacao") {
	if ($_POST["origin"]== "REMETENTE_ID") {
		$query = "SELECT S.ID, U.NOME, S.MENSAGEM, S.SITUACAO FROM SOLICITACAO S INNER JOIN USUARIO U ON U.ID=S.DESTINATARIO_ID WHERE ".$_POST["origin"]."=".$_SESSION["userId"]." ORDER BY S.REGISTRO DESC";
	} else {
		$query = "SELECT S.ID, U.NOME, S.MENSAGEM, S.SITUACAO FROM SOLICITACAO S INNER JOIN USUARIO U ON U.ID=S.REMETENTE_ID WHERE ".$_POST["origin"]."=".$_SESSION["userId"]." ORDER BY S.REGISTRO DESC";
	}

	$x = 0;
	$cnx = mysqli_query($phpmyadmin, $query);
	while ($feed = $cnx->fetch_array()) {
		$vtId[$x] = $feed["ID"];
		$vtDestinatario[$x] = $feed["NOME"];		
		$vtFeedback[$x] = $feed["MENSAGEM"];
		$vtSituacao[$x] = $feed["SITUACAO"];
		$x++;
		$count = $x;
	}
	
	if ($x == 0) {
		echo "<script>alert('Nenhuma Solicitação encontrada nesta consulta!'); window.location.href=window.location.href; </script>";		
	}
}

if (isset($_POST['query']) && $x != 0) { 
	echo '	
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>';
		if ($_POST["origin"] == "DESTINATARIO_ID" ) { 
			echo "<th>Remetente</th>";
		} else {
			echo "<th>Destinatário</th>";	
		}

		if ($_POST["type"] == "feedback") {
			echo "
			<th>Tipo</th>
			<th>Profissional</th>
			<th>Compartamental</th>
			<th>Desempenho</th>";
		}

	echo "	
		<th>Situação</th>
	</tr>";

 	for ($i = 0; $i < sizeof($vtId); $i++ ) {
		echo "
		<tr>
		<td rowspan='2'>" . $i . "</td>";		

		if ($_POST["origin"] == "DESTINATARIO_ID") {
			if ($vtExibicao[$i] == 1) {
				echo "<td>" . $vtRemetente[$i] . "</td>";
			} elseif ($_POST["type"] == "solicitacao") {
				echo "<td>" . $vtDestinatario[$i] . "</td>";
			} else {
				echo "<td>Anônimo</td>";
			} 
		}
			
		if ($_POST["origin"] == "REMETENTE_ID") {
			echo "<td>" . $vtDestinatario[$i] . "</td>";
		}
		
		if ($_POST["type"] == "feedback") {
			echo "
			<td>" . $vtTipo[$i] . "</td>
			<td>" . $vtProfissional[$i] . "</td> 
			<td>" . $vtComportamental[$i] . "</td> 
			<td>" . $vtDesempenho[$i] . "</td>";
		}
		
  		echo "<td>" . $vtSituacao[$i] . "</td>  		
	</tr>
	<tr>
		<td colspan='6'>" . $vtFeedback[$i] . "</td>
	</tr>";
	
	}

	if ($_POST["origin"] == "DESTINATARIO_ID" ) {//Update status to read.
		$x = 0;
		$table = "FEEDBACK";
		
		if ($_POST["type"] == "solicitacao") {
			$table = "SOLICITACAO";
		}

		while ($x < sizeof($vtId)) {
			$cnx = mysqli_query($phpmyadmin, "UPDATE " . $table . " SET SITUACAO = 'Lido' WHERE ID =" . $vtId[$x]);
			$x++;
		}
	}

	?>
	</table>	
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
					<a href="feedback-query.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
				</div>									
			</div>						
		</div>
	</div>
</section>
<?php } ?>	
</body>
</html>