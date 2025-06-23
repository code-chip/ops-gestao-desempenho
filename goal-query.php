<?php

$menuAtivo = 'meta';
require('menu.php');
$sector = null;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style type="text/css" src="css/personal.css"></style>
	<title>Gestão de Desempenho - Consultar Meta</title>
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
<?php if (empty($sector) && isset($_POST['query']) == null ) { ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="" method="POST">
		<div class="field">
			<label class="label is-size-7-touch">Mês*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="periodo"><?php 								
							$con = mysqli_query($phpmyadmin , "SELECT DATE_FORMAT(CADASTRO_EM,'%Y-%m') AS ANO_MES, DATE_FORMAT(CADASTRO_EM,'%m/%Y') AS MES_ANO FROM META GROUP BY 1,2 ORDER BY ANO_MES DESC LIMIT 24");
							while($sector = $con->fetch_array()){
								echo '<option value=' . $sector['ANO_MES'] . '>' . $sector["MES_ANO"] . '</option>';
							 }
						?></select>
						<span class="icon is-small is-left">
							<i class="fas fa-calendar-alt"></i>
						</span>	
					</div>
				</div>
			</div>
			<div class="field">
				<label class="label is-size-7-touch">Setor*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="setor"><?php 								
							$con = mysqli_query($phpmyadmin , "SELECT ID, NOME FROM SETOR WHERE SITUACAO = 'Ativo'");
							while($sector = $con->fetch_array()){
								echo '<option value=' . $sector['ID'] . '>' . $sector["NOME"] . '</option>';
							 }
						?></select>
						<span class="icon is-small is-left">
							<i class="fas fa-door-open"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="field">
				<label class="label is-size-7-touch">Nome*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth"><!--SELEÇÃO OU PESQUISA DE NOME-->
						<input name="nome" type="text" class="input" placeholder="Ana Clara" value="<?php if($_SESSION["permissao"]==1){ echo $_SESSION["nameUser"];}?>">
						<span class="icon is-small is-left">
							<i class="fas fa-user-circle"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="field-body"></div>
				<div class="field is-grouped">
					<div class="control">
						<button name="query" type="submit" class="button is-primary btn128">Pesquisar</button>
					</div>
					<div class="control">
						<button name="clear" type="reset" class="button is-primary btn128">Limpar</button>
					</div>
				</div>
			</div>
		</div>						
	</form>
	</div>
	</section>	
<?php }

if(isset($_POST['query'])){
	$periodo = trim($_REQUEST['periodo']);
	$sector = trim($_REQUEST['setor']);
	$name = trim($_REQUEST['nome']);
	$count = 0;
	$totalReached = 0;

	if ( $name != "") {		
		$query = "SELECT U.NOME, A.NOME AS ATIVIDADE, M.META, M.DESCRICAO, M.EXECUCAO, M.CADASTRO_EM, M.DESEMPENHO FROM META M
	INNER JOIN USUARIO U ON U.ID=M.USUARIO_ID INNER JOIN ATIVIDADE A ON A.ID=M.ATIVIDADE_ID WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE NOME LIKE '%".$name."%' AND SETOR_ID=".$sector.") AND M.EXECUCAO>=CONCAT('".$periodo."','-01') AND M.EXECUCAO<= CONCAT('".$periodo."', '-31');";
	}	
	else {	
		$query = "SELECT U.NOME, A.NOME AS ATIVIDADE, M.META, M.DESCRICAO, M.EXECUCAO, M.CADASTRO_EM, M.DESEMPENHO FROM META M
	INNER JOIN USUARIO U ON U.ID=M.USUARIO_ID
	INNER JOIN ATIVIDADE A ON A.ID=M.ATIVIDADE_ID
	WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE SETOR_ID=".$sector.") AND M.EXECUCAO>=CONCAT('".$periodo."','-01') AND M.EXECUCAO<= CONCAT('".$periodo."', '-31') ORDER BY 1;";
	}
	
	$x = 0;
	$cnx = mysqli_query($phpmyadmin, $query);
	if (mysqli_num_rows($cnx) > 0) {
		while($goal = $cnx->fetch_array()){
			$vName[$x] = $goal["NOME"];
			$vActivity[$x] = $goal["ATIVIDADE"];
			$vGoal[$x] = $goal["META"];
			$vExecution[$x] = $goal["EXECUCAO"];
			$vPerformance[$x] = $goal["DESEMPENHO"];
			$vDescription[$x] = $goal["DESCRICAO"];					
			$x++;
			$count = $x;
		}
	}
	else {
		echo "<script>alert('Nenhum registrado encontrado nesta consulta!'); window.location.href=window.location.href; </script>";		
	}	
}	
?>
<!--FINAL DO FORMULÁRIO DE FILTRAGEM-->
<?php if(isset($_POST['query']) && $count != 0) : ?>
<hr/>
	<section class="section">
	<div class="table__wrapper">
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th>Funcionário</th>
		<th>Atividade</th>	
		<th>Meta</th>			
		<th>Descrição</th>
		<th>Execução</th>			
		<th>Feita</th>
	</tr>
	<?php 

	for( $i = 0; $i < sizeof($vName); $i++ ) {
		echo "<tr>
		<td>" . $i . "</td>
		<td>" .  $vName[$i] . "</td>
		<td>" .  $vActivity[$i] . "</td>
		<td>" .  $vGoal[$i] . "</td>
		<td>" .  $vDescription[$i] . "</td>
		<td>" .  $vExecution[$i] . "</td>";
		
		if ($vPerformance[$i] == 0) { 
			echo "<td>Não</td>";
		} else { 
			echo "<td>Sim</td>";
		}
	}

	?>
	</tr>
	</table>
	<a href="#top" class="glyphicon glyphicon-chevron-up"></a>
	<a href="#topo">		
		<div class=".scrollWrapper">
			<button class="button is-primary is-fullwidth">Ir Ao Topo</button>		
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
				<a href="goal-query.php" class="button is-primary">Nova consulta</a>
			</div>					
		</div>						
	</div>
</div>
</section>	
<?php endif; ?>
</body>
</html>