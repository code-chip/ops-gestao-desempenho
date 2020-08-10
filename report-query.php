<?php

$menuAtivo = 'desempenho';
require('menu.php');

 if ($_SESSION["permissao"] == 1 ) {
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
	<title>Gestão de Desempenho - Consultar Desempenho</title>

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
    </script>   
</head>
<body>
	<span id="top"></span>
<div>	
	<?php if ($sector == "" && isset($_POST['query']) == null ){ ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="report-query.php" method="POST">
		<div class="field">
			<label class="label is-size-7-touch">Mês*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth norequired">
			  		<select name="month" id="month" class="is-fullwidth norequired " autofocus>
						<option selected="selected" value="<?php echo date('Y-m')?>"><?php echo date('m/Y')?></option>
						<option value="<?php echo date('Y-m', strtotime("-1 months"))?>"><?php echo date('m/Y', strtotime("-1 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-2 months"))?>"><?php echo date('m/Y', strtotime("-2 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-3 months"))?>"><?php echo date('m/Y', strtotime("-3 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-4 months"))?>"><?php echo date('m/Y', strtotime("-4 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-5 months"))?>"><?php echo date('m/Y', strtotime("-5 months"))?></option>
						<option value="<?php echo date('Y-m', strtotime("-6 months"))?>"><?php echo date('m/Y', strtotime("-6 months"))?></option>
					</select>
				</div>
				<span class="icon is-small is-left" >
				  	<i class="fas fa-calendar-alt"></i>
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
			<label class="label is-size-7-touch">Nome</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<input name="name" type="text" onkeypress="addLoadField('name')" onkeyup="rmvLoadField('name')" class="input norequired" placeholder="Ana Clara ou deixe em branco p/ consultar todos.">
					<span class="icon is-left">
						<i class="fas fa-user-circle"></i>
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
	<?php } ?>		
</div>
<?php

if (isset($_POST['query'])) {
	$count = 0;
	$totalAlcancado = 0;

	if ( $name != "") {	
		$query = "SELECT U.NOME AS USUARIO, P.NOME AS PRESENCA, A.NOME AS ATIVIDADE, D.META, D.ALCANCADO AS ALCANCADO, D.DESEMPENHO, D.REGISTRO, D.OBSERVACAO FROM DESEMPENHO D INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID INNER JOIN PRESENCA P ON P.ID=D.PRESENCA_ID INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID WHERE SETOR_ID=".$_REQUEST['sector']." AND USUARIO_ID IN(SELECT ID FROM USUARIO WHERE NOME LIKE '%".$_REQUEST['name']."%') AND ANO_MES='".$_REQUEST['month']."'";
	} else {	
		$query = "SELECT U.NOME AS USUARIO, P.NOME AS PRESENCA, A.NOME AS ATIVIDADE, D.META, D.ALCANCADO AS ALCANCADO, D.DESEMPENHO, D.REGISTRO, D.OBSERVACAO FROM DESEMPENHO D INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID INNER JOIN PRESENCA P ON P.ID=D.PRESENCA_ID INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID WHERE SETOR_ID=".$_REQUEST['sector']." AND USUARIO_ID IN(SELECT ID FROM USUARIO) AND ANO_MES= '".$_REQUEST['month']."' ORDER BY REGISTRO, U.NOME;";
	}

	$x = 0;
	$cnx = mysqli_query($phpmyadmin, $query);
	while($user = $cnx->fetch_array()){
		$name[$x] = $user["USUARIO"];
		$presence[$x] = $user["PRESENCA"];
		$activity[$x] = $user["ATIVIDADE"];
		$goal[$x] = $user["META"];
		$reached[$x] = $user["ALCANCADO"];
		$performance[$x] = $user["DESEMPENHO"];
		$date[$x] = $user["REGISTRO"];
		$note[$x] = $user["OBSERVACAO"];					
		$x++;
		$count = $x;
	}

	if (mysqli_num_rows($cnx) == 0) {
		echo "<script>alert('Nenhum registrado encontrado nesta consulta!'); window.location.href=window.location.href;</script>";		
	}	
}	

if (isset($_POST['query']) && $count != 0) : ?>

	<hr/>
	<section class="section">
	<div class="table__wrapper">
	<table class="table__wrapper table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch scrollWrapper">	
	<tr>
		<th>N°</th>
		<th>Funcionário</th>
		<th>Presença</th>
		<th>Atividade</th>		
		<th class="coluna">Meta</th>
		<th >Alcançado</th>
		<th >Desempenho</th>			
		<th>Data</th>
		<th>Observação</th> 			
	</tr>
	<?php 

	for( $i = 0; $i < sizeof($name); $i++ ) :
		$z = $i; 
		$registro = 1; 

		while ($name[$z] == $name[$z+1]) {
			$registro++;
			$repeat=$registro;
			$z++;
		}

		if($repeat > 0) { 
			$repeat--;
		}	
	?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td><?php echo $name[$i]?></td>
		<td><?php echo $presence[$i]?></td>
		<td><?php echo $activity[$i]?></td>
		<td><?php echo $goal[$i]?></td>
		<td><?php echo $reached[$i]?></td>
		<td><?php echo round($performance[$i],2)."%"?></td>			
		<td><?php echo $date[$i]?></td>
		<td><?php echo $note[$i]?></td>
	</tr>
<?php endfor;?>
	</table>
	<a href="#top">		
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
				<a href="report-query.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
			</div>					
		</div>						
	</div>
</div>
</section>	
<?php endif; ?>
</body>
</html>