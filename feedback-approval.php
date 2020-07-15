<?php
$menuAtivo = 'feedback';
require('menu.php');

$situacao = trim($_POST['situacao']);
$contador = 0;

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php';</script>";
} 

if (isset($_POST['consultar'])) {
	if ($situacao == "'Enviado'") {
		$query = "SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, F.TIPO, F.FEEDBACK FROM FEEDBACK F INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID WHERE F.SITUACAO=" . $situacao;
	} else {
		$query ="SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, TIPO, FEEDBACK, U3.NOME AS ATUALIZADO_POR FROM FEEDBACK F INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID INNER JOIN USUARIO U3 ON U3.ID=F.ATUALIZADO_POR WHERE F.SITUACAO=" . $situacao;
	}
	$x = 0;
	$cnx = mysqli_query($phpmyadmin, $query);
	while ($feed = $cnx->fetch_array()) {
		$vtId[$x] = $feed['ID'];
		$vtRemetente[$x] = $feed['REMETENTE'];
		$vtDestinatario[$x] = $feed['DESTINATARIO'];
		$vtTipo[$x] = $feed['TIPO'];
		$vtFeedback[$x] = $feed['FEEDBACK'];
		$vtAprovadoPor[$x] = $feed['ATUALIZADO_POR'];				
		$x++;
		$contador = $x;
	} if (mysqli_num_rows($cnx) == 0) {
		?><script type="text/javascript">			
			alert('Nenhum feedback encontrado nesta consulta!');
			window.location.href = window.location.href;
		</script> <?php		
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Aprovação Feedback</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">
    <style type="text/css">
    	.button{
    		width: 121px;
    	}
    </style>   
</head>
<body>	
<hr/>
<section class="section" id="topo">
<?php if ($situacao == "" && isset($_POST['consultar']) == null ): ?>	
	<form id="form1" action="feedback-approval.php" method="POST">
		<div class="field is-horizontal">
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Situação:</label>
				</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select name="situacao">								
									<option value="'Enviado'">Aguardando</option>
									<option value="'Reprovado'">Reprovado</option>
									<option value="'Aprovado'">Aprovado</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label"></div>
				<div class="field-body">
					<div class="field">
						<div class="control">
							<button name="consultar" type="submit" class="button is-primary">Consultar</button>
						</div>
					</div>
				</div>
			</div>
		</div>						
	</form>
<?php endif;
 
if (isset($_POST['consultar']) && $contador != 0) : ?>	
<form method="POST" action="feedback-approval.php" id="form2">	
	<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th class="ocultaColunaId">ID</th>
		<th>Remetente</th>
		<th>Destinatário</th>
		<th>Tipo</th>
		<th>Feedback</th>
		<?php 

		if ($situacao == "'Enviado'") {
			echo '<th>Aprovar</th>';
		} else if ($situacao == "'Aprovado'") {
			echo '<th>Aprovado por</th>
		    <th>Aprovar</th>';
		} else if ($situacao == "'Reprovado'") {
			echo '<th>Reprovado por</th>
			<th>Aprovar</th>';
		} else if ($situacao != "'Enviado'") {
			echo '<th>Aprovar</th>';   			
		}
	echo '</tr>';
 	for ( $i = 0; $i < sizeof($vtRemetente); $i++ ) : ?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td class="field ocultaColunaId"><!--COLUNA VETOR-->
			<div class="field">				
				<div class="control">					
		  			<input name="id[]" type="text" value="<?php echo $vtId[$i]?>">
		  		</div>
		  	</div>
		</td>
		<?php
		echo "<td>" . $vtRemetente[$i] . "</td>
		<td>" . $vtDestinatario[$i] . "</td>
		<td>" . $vtTipo[$i] . "</td>
		<td>" . $vtFeedback[$i] . "</td>";

  		if ($situacao != "'Enviado'") {
  			echo "<td>" . $vtAprovadoPor[$i] . "</td>";
  		}
  		
  		if ($situacao == "'Enviado'") {
  			echo "<td>
  			<div class='select'>
  				<select name='upSituacao[]''>
  					<option value='Enviado'>...</option>
  					<option value='Aprovado'>Sim</option>
  					<option value='Reprovado'>Não</option>
  				</select>					
			</div>	
  			</td>";
  		}

  		if ($situacao == "'Aprovado'") {
  			echo "<td>
  			<div class='select'>
  				<select name='upSituacao[]'>
  					<option value='Aprovado'>Sim</option>
  					<option value='Reprovado'>Não</option>
  				</select>					
			</div>	
  			</td>";
  		}
  		
  		if ($situacao == "'Reprovado'") {
  			echo "<td>
  			<div class='select'>
  				<select name='upSituacao[]'>
  					<option value='Reprovado'>Não</option>
  					<option value='Aprovado'>Sim</option>
  				</select>					
			</div>	
  			</td>";
  		}
		echo "</tr>";
	endfor; 

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
					<input name="aprovar" type="submit" class="button is-primary" value="Atualizar"/>
				</div>
				<div class="control">
					<a href="feedback-approval.php"><input name="Limpar" type="submit" class="button is-primary" value="Voltar"/></a>
				</div>
				<div class="control">
					<a href="home.php" class="button is-primary">Cancelar</a>
				</div>
									
			</div>						
		</div>
	</div>
</section>
</form>
<?php endif;?>	
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