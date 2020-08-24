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
	<title>Gestão de Desempenho - Remover Desempenho</title>
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
	<span id="topo"></span>
<div>	
	<?php if ($setor == "" && isset($_POST['query']) == null ): ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="report-remove.php" method="POST">
		<div class="field">
			<label class="label is-size-7-touch">Mês*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth norequired">
			  		<select name="month" id="month" class="is-fullwidth norequired " autofocus><?php 								
						$con = mysqli_query($phpmyadmin , "SELECT DATE_FORMAT(REGISTRO,'%Y-%m') AS ANO_MES, DATE_FORMAT(REGISTRO,'%m/%Y') AS MES_ANO FROM DESEMPENHO GROUP BY 1 ORDER BY ANO_MES DESC LIMIT 24;");
						while($sector = $con->fetch_array()){
							echo '<option value=' . $sector['ANO_MES'] . '>' . $sector["MES_ANO"] . '</option>';
						}
					?></select>
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
				<div class="select is-fullwidth" id="name">
					<input name="name" type="text" onkeypress="addLoadField('name')" onkeyup="rmvLoadField('name')" class="input norequired" placeholder="Ana Clara ou deixe em branco p/ consultar todos." id="input3">
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
	</form>
	</div>
	</section>	
	<?php endif; ?>		
</div>
<?php

if( isset($_POST['query'])){
	$count = 0;
	$totalAlcancado = 0;

	$query = "SELECT D.ID AS ID, U.NOME AS USUARIO, D.PRESENCA_ID AS PRESENCA_ID,P.NOME AS PRESENCA, D.ATIVIDADE_ID AS ATIVIDADE_ID, A.NOME AS ATIVIDADE, D.META, D.ALCANCADO AS ALCANCADO, D.DESEMPENHO, D.REGISTRO, D.OBSERVACAO FROM DESEMPENHO D INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID INNER JOIN PRESENCA P ON P.ID=D.PRESENCA_ID INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID WHERE SETOR_ID=".$_REQUEST['sector']." AND USUARIO_ID IN(SELECT ID FROM USUARIO WHERE NOME LIKE '%".$_REQUEST['name']."%') AND D.ANO_MES='".$_REQUEST['month']."';";
	$x=0;	
	$cnx=mysqli_query($phpmyadmin, $query);

	while($user= $cnx->fetch_array()) {
		$id[$x] = $user["ID"];
		$name[$x] = $user["USUARIO"];
		$presenceId[$x] = $user["PRESENCA_ID"];
		$presence[$x] = $user["PRESENCA"];
		$activityId[$x] = $user["ATIVIDADE_ID"];
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
		echo "<script>alert('Nenhum registrado encontrado nesta consulta!'); window.location.href=window.location.href; </script>";		
	}	
}

if (isset($_POST['query']) && $count != 0) : ?>
<hr/>
<section class="section">
<form id="form2" action="report-remove.php" method="POST">	
<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch is-striped is-narrow is-hoverable">	
	<tr>
		<th>N°</th>
		<th>Apagar</th>
		<th>Funcionário</th>
		<th>Presença</th>
		<th>Atividade</th>		
		<th class="coluna">Meta</th>
		<th >Alcançado</th>			
		<th>Data</th>
		<th>Observação</th> 			
	</tr>
	<?php 

	for ( $i = 0; $i < sizeof($name); $i++ ) :
		$z = $i; 
		$registro = 1; 

		while ($name[$z] == $name[$z+1]) {
		$registro++;
		$repeat = $registro;
		$z++;
	}

	if ($repeat > 0) { 
		$repeat--;
	}	
	
	?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td>
			<label class="checkbox">
  				<input name="id[]" type="checkbox" value="<?php echo $id[$i]?>">
  				Sim
  			</label>  			
		</td>	
		<td><?php echo $name[$i]?></td>		
		<td><?php echo $presence[$i];?></td>			
		<td><?php echo $activity[$i];?></td>
		<td><?php echo $goal[$i]?></td>
		<td><?php echo $reached[$i]?></td>
		<td><?php echo $date[$i]?></td>
		<td><?php echo $note[$i]?></td>
	</tr>
<?php endfor;?>
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
					<input name="removerDados" type="submit" class="button is-primary btn128" value="Remover"/>
				</div>												
				<div class="control">
					<a href="report-remove.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
				</div>
			</div>						
		</div>
	</div>
</div>
</form>
</section>	
<?php endif; ?>
</body>
</html>
<?php

if (isset($_POST['removerDados'])) {
	$ids = array_filter($_POST['id']);
	$upCount = 0;

	for ( $i = 0; $i < sizeof($ids); $i++ ) {
		$cnx = mysqli_query($phpmyadmin, "DELETE FROM DESEMPENHO WHERE ID=".$ids[$i].";");
		$upCount = $upCount+1;			 
	}

	if (mysqli_error($phpmyadmin) == null && $upCount > 0) {	
		echo "<script>alert('" . $upCount . " registro(s) de desempenho deletado(s)'); window.location.href=window.location.href; </script>";
	} else if ($upCount == 0) {
		echo "<script>alert('Nenhuma Informação foi marcada p/ ser deletada!!'); </script>";
	} else {
		echo "<script>alert('Erro ao deletar registro de Desempenho!!'); window.location.href=window.location.href; </script>";
	}
}
?>