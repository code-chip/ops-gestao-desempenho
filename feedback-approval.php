<?php
$menuAtivo = 'feedback';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php';</script>";
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
	<style type="text/css">
		td{
			vertical-align:middle !important
		}
	</style>
	<title>Gestão de Desempenho - Aprovação Feedback</title> 
</head>
<body>	
<section class="section" id="topo">
<?php if ($situacao == "" && isset($_POST['consultar']) == null ): ?>	
<div class="container">
	<form id="form1" action="feedback-approval-n.php" method="POST">
		<div class="field">
			<label class="label is-size-7-touch">Ano/Mês*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="yearMonth"><?php
						$cnx = mysqli_query($phpmyadmin, "SELECT ANO_MES FROM FEEDBACK GROUP BY 1 ORDER BY ANO_MES DESC LIMIT 24");
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
			<label class="label is-size-7-touch">Situação*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="situacao">								
						<option value="'Enviado'">Aguardando</option>
						<option value="'Reprovado'">Reprovado</option>
						<option value="'Aprovado'">Aprovado</option>
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-sort"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<button name="consultar" type="submit" class="button is-primary btn128">Pesquisar</button>
				</div>
			</div>
		</div>						
	</form>
</div>
<?php endif;

if (isset($_POST['consultar'])) {

	$situacao = trim($_POST['situacao']);
	$contador = 0;

	if ($situacao == "'Enviado'") {
		$query = "SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, FRP.RESPOSTA AS PRO, FRC.RESPOSTA AS COMP, FRD.RESPOSTA AS DES ,F.TIPO, F.FEEDBACK FROM FEEDBACK F INNER JOIN FEEDBACK_RESPOSTA FRP ON FRP.ID=F.PROFISSIONAL INNER JOIN FEEDBACK_RESPOSTA FRC ON FRC.ID=F.COMPORTAMENTAL INNER JOIN FEEDBACK_RESPOSTA FRD ON FRD.ID=F.DESEMPENHO INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID WHERE F.SITUACAO=" . $situacao;
	} else {
		$query = "SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, FRP.RESPOSTA AS PRO, FRC.RESPOSTA AS COMP, FRD.RESPOSTA AS DES ,F.TIPO, FEEDBACK, U3.NOME AS ATUALIZADO_POR FROM FEEDBACK F INNER JOIN FEEDBACK_RESPOSTA FRP ON FRP.ID=F.PROFISSIONAL INNER JOIN FEEDBACK_RESPOSTA FRC ON FRC.ID=F.COMPORTAMENTAL INNER JOIN FEEDBACK_RESPOSTA FRD ON FRD.ID=F.DESEMPENHO INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID INNER JOIN USUARIO U3 ON U3.ID=F.ATUALIZADO_POR WHERE F.SITUACAO=" . $situacao;
	}
	$x = 0;
	$cnx = mysqli_query($phpmyadmin, $query);
	while ($feed = $cnx->fetch_array()) {
		$vtId[$x] = $feed['ID'];
		$sender[$x] = $feed['REMETENTE'];
		$recipient[$x] = $feed['DESTINATARIO'];
		$professional[$x] = $feed['PRO'];
		$behavioral[$x] = $feed['COMP'];
		$performance[$x] = $feed['DES'];
		$type[$x] = $feed['TIPO'];
		$feedback[$x] = $feed['FEEDBACK'];
		$approval[$x] = $feed['ATUALIZADO_POR'];				
		$x++;
		$contador = $x;
	} if (mysqli_num_rows($cnx) == 0) {
		echo "<script>alert('Nenhum feedback encontrado nesta consulta!'); window.location.href = window.location.href;	</script>";	
	}	
}
 
if (isset($_POST['consultar']) && $contador != 0) : ?>	
<form method="POST" action="feedback-approval-n.php" id="form2">	
	<div class="table__wrapper">
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th class="ocultaColunaId">ID</th>
		<th>Remetente</th>
		<th>Destinatário</th>
		<th>Profissional</th>
		<th>Comportamental</th>
		<th>Desempenho</th>
		<th>Tipo</th>
		
		<?php 

		if ($situacao == "'Enviado'") {
			echo '<th>Aguardando</th>
			<th>Aprovar</th>';
		} else if ($situacao == "'Aprovado'") {
			echo '<th>Aprovação</th>
		    <th>Aprovar</th>';
		} else if ($situacao == "'Reprovado'") {
			echo '<th>Reprovação</th>
			<th>Aprovar</th>';
		} //else if ($situacao != "'Enviado'") {
			//echo '<th>Aprovar</th>';   			
		//}
	echo '</tr>';
 	for ( $i = 0; $i < sizeof($sender); $i++ ) : ?>
	<tr>
		<td rowspan="2"><?php echo $i+1;?></td>
		<td class="field ocultaColunaId"><!--COLUNA VETOR-->
			<div class="field">				
				<div class="control">					
		  			<input name="id[]" type="text" value="<?php echo $vtId[$i]?>">
		  		</div>
		  	</div>
		</td>
		<?php
		echo "<td>" . $sender[$i] . "</td>
		<td>" . $recipient[$i] . "</td>
		<td>" . $professional[$i] . "</td>
		<td>" . $behavioral[$i] . "</td>
		<td>" . $performance[$i] . "</td>
		<td>" . $type[$i] . "</td>
		";

  		if ($situacao != "'Enviado'") {
  			echo "<td>" . $approval[$i] . "</td>";
  		}
  		
  		if ($situacao == "'Enviado'") {
  			echo '<td>Aguardando</td>';
  			echo "<td rowspan='2'>
  			<div class='select is-fullwidth'>
  				<select name='upSituacao[]''>
  					<option value='Enviado'>...</option>
  					<option value='Aprovado'>Sim</option>
  					<option value='Reprovado'>Não</option>
  				</select>					
			</div>	
  			</td>";
  		}

  		if ($situacao == "'Aprovado'") {
  			echo "<td rowspan='2'>
  			<div class='select'>
  				<select name='upSituacao[]'>
  					<option value='Aprovado'>Sim</option>
  					<option value='Reprovado'>Não</option>
  				</select>					
			</div>	
  			</td>";
  		}
  		
  		if ($situacao == "'Reprovado'") {
  			echo "<td rowspan='2'>
  			<div class='select'>
  				<select name='upSituacao[]'>
  					<option value='Reprovado'>Não</option>
  					<option value='Aprovado'>Sim</option>
  				</select>					
			</div>	
  			</td>";
  		}
		echo "</tr>";

	  echo "<tr><td colspan='8'>".$feedback[$i]."</td></tr>";
	endfor; 

	?>
	

	</table>

	<a href="#topo">		
		<div class=".scrollWrapper">
			<button class="button is-primary" style="width: 100%; display: table;">Ir Ao Topo</button>		
		</div>
	</a>
	<br/>
	<div class="field-body">
		<div class="field is-grouped">
			<div class="control">
				<input name="aprovar" type="submit" class="button is-primary btn128" value="Atualizar"/>
			</div>
			<div class="control">
				<a href="feedback-approval-n.php"><input name="Limpar" type="submit" class="button is-primary btn128" value="Voltar"/></a>
			</div>
			<div class="control">
				<a href="home.php" class="button is-primary btn128">Cancelar</a>
			</div>
		</div>
	</div>

</form>
<?php endif;?>	

</section>
</body>
</html>
<?php

if (isset($_POST['aprovar'])) {
	$ids = array_filter($_POST['id']);
	$situacoes = array_filter($_POST['upSituacao']);
	$x = 0;
	while ($x < sizeof($ids)) {
		$cnx = mysqli_query($phpmyadmin, "UPDATE FEEDBACK SET ATUALIZADO_POR = " . $_SESSION["userId"] . ", SITUACAO = '" . $situacoes[$x] . "' WHERE ID = " . $ids[$x]);
		$x++;
	}

	if ($x > 0) {
		$x = $x + 1;
		?><script type="text/javascript">			
			alert('Foi atualizado(s) "<?php echo $x; ?>" feedback(s)!');
		</script> <?php		
	} else {
		?><script type="text/javascript">			
			alert('Nenhum feedback foi atualizado!');
		</script> <?php	
	}
}
?>