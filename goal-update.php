<?php
$menuAtivo = 'meta';
require('menu.php');
$setor = '';

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
	<title>Gestão de Desempenho - Atualizar Meta</title>
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
	<?php if (empty($setor) && isset($_POST['query']) == null ): ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="goal-update.php" method="POST">
		<div class="field">
			<label class="label is-size-7-touch">Mês*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="month"><?php 								
							$con = mysqli_query($phpmyadmin , "SELECT DATE_FORMAT(CADASTRO_EM,'%Y-%m') AS ANO_MES, DATE_FORMAT(CADASTRO_EM,'%m/%Y') AS MES_ANO FROM META GROUP BY 1, 2 ORDER BY ANO_MES DESC LIMIT 24");
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
						<select name="sector"><?php 								
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
				<label class="label is-size-7-touch">Nome</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth"><!--SELEÇÃO OU PESQUISA DE NOME-->
						<input name="name" type="text" class="input" placeholder="Ana Clara" value="<?php if($_SESSION["permissao"]==1){ echo $_SESSION["nameUser"];}?>">
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
	<?php endif; ?>		
</div>
<?php

if (isset($_POST['query'])) {
	$totalAlcancado = 0;

	if (!empty($_POST['name'])) {	
		$query = "SELECT M.ID , U.NOME, A.NOME AS ATIVIDADE, ATIVIDADE_ID, M.META, M.DESCRICAO, M.EXECUCAO, M.CADASTRO_EM, M.DESEMPENHO FROM META M INNER JOIN USUARIO U ON U.ID=M.USUARIO_ID INNER JOIN ATIVIDADE A ON A.ID=M.ATIVIDADE_ID WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE NOME LIKE '%".$_POST['name']."%' AND SETOR_ID=".$_POST['sector'].") AND M.EXECUCAO>=CONCAT('".$_POST['month']."','-01') AND M.EXECUCAO<= CONCAT('".$_POST['month']."', '-31');";
	} else {
		$query = "SELECT M.ID , U.NOME, A.NOME AS ATIVIDADE, ATIVIDADE_ID, M.META, M.DESCRICAO, M.EXECUCAO, M.CADASTRO_EM, M.DESEMPENHO FROM META M INNER JOIN USUARIO U ON U.ID=M.USUARIO_ID INNER JOIN ATIVIDADE A ON A.ID=M.ATIVIDADE_ID WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE SETOR_ID=".$_POST['sector'].") AND M.EXECUCAO>=CONCAT('".$_POST['month']."','-01') AND M.EXECUCAO<= CONCAT('".$_POST['month']."', '-31');";
	}

	$x = 0;
	$cnx = mysqli_query($phpmyadmin, $query);

	if (mysqli_num_rows($cnx) > 0) {
		while ($goal = $cnx->fetch_array()) {
			$vtId[$x] = $goal["ID"];
			$vtNome[$x] = $goal["NOME"];
			$vtAtividade[$x] = $goal["ATIVIDADE"];
			$vtIdAtividade[$x] = $goal["ATIVIDADE_ID"];
			$vtMeta[$x] = $goal["META"];
			$vtExecucao[$x] = $goal["EXECUCAO"];
			$vtDesempenho[$x] = $goal["DESEMPENHO"];
			$vtDescricao[$x] = $goal["DESCRICAO"];					
			$x++;
		}
	} else {
		echo "<script> alert('Nenhum registrado encontrado nesta consulta!'); window.location.href=window.location.href; </script>";	
	}	
}

if (isset($_POST['query']) && $x != 0) : ?>

<hr/>
<section class="section">
<form id="form2" action="goal-update.php" method="POST">	
<div class="table__wrapper">
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th class="ocultaColunaId">ID</th>
		<th>Funcionário</th>
		<th>Atividade</th>	
		<th>Meta</th>			
		<th>Descrição</th>
		<th>Execução</th>			
		<th>Feita</th> 			
	</tr>
<?php for ( $i = 0; $i < sizeof($vtNome); $i++ ) : ?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td class="field ocultaColunaId"><!--COLUNA ID-->
			<div class="field">
				<div class="control">
					<input name="id[]" type="text" class="input is-size-7-touch" value="<?php echo $vtId[$i]?>" >
				</div>
			</div>
		</td>
		<td><!--COLUNA NOME-->
			<div class="field">
				<div class="control">
					<input type="text" class="input is-size-7-touch" value="<?php echo $vtNome[$i]?>">
				</div>
			</div>
		</td>	
		<td class="field"><!--COLUNA ATIVIDADE-->
			<div class="field">
				<div class="control">
					<div class="select is-size-7-touch">
						<select name="atividade[]">
							<option selected="selected" value="<?php echo $vtIdAtividade[$i];?>"><?php echo $vtAtividade[$i];?></option>	
								<?php $gdAtividade="SELECT ID, NOME FROM ATIVIDADE WHERE SITUACAO='Ativo' AND ID<>".$vtIdAtividade[$i].";";
								$con = mysqli_query($phpmyadmin, $gdAtividade); $x=0;
								while($atividade = $con->fetch_array()):{ ;?>
									<option value="<?php echo $vtId[$x] = $atividade["ID"]; ?>"><?php echo $vtNome[$x] = $atividade["NOME"]; ?></option>
							<?php $x;} endwhile;?>															
						</select>	
					</div>
				</div>
			</div>
		</td>
		<td>
			<div class="field" style="max-width:5em;"><!--COLUNA META-->
				<div class="control">
					<input name="meta[]" type="text" class="input numero is-size-7-touch" value="<?php echo $vtMeta[$i]?>">
				</div>							
			</div>
		</td>
		<td><!--COLUNA DESCRIÇÃO-->	
			<div class="field">
				<div class="control">
					<input name="descricao[]" type="text" class="input is-size-7-touch" value="<?php echo $vtDescricao[$i]?>">
				</div>
			</div>
		</td>
		<td><!--COLUNA EXECUCAÇÃO-->	
			<div class="field" style="max-width:7em;">
				<div class="control">
					<input name="execucao[]" type="text" class="input registro is-size-7-touch" value="<?php echo $vtExecucao[$i]?>">
				</div>
			</div>
		</td>		
		<td class="field"><!--COLUNA FEITA-->
			<div class="field">
				<div class="control">
					<div class="select is-size-7-touch">
						<select name="atividade3[]">
							<?php if($vtDesempenho[$i]==0):{?>
							<option selected="selected" value="<?php echo "0"?>">Não</option>
							<option value="1">Sim</option>
							<?php }endif; if($vtDesempenho[$i]==1):{?>
							<option selected="selected" value="1">Sim</option>	
							<option value="0">Não</option> <?php }endif;?>		
						</select>	
					</div>
				</div>
			</div>
		</td>	
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
					<input name="alterarDados" type="submit" class="button is-primary" value="Alterar Dados"/>
				</div>												
				<div class="control">
					<a href="report-update.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
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

if (isset($_POST['alterarDados'])) {
	$ids = array_filter($_POST['id']);
	$atividades = array_filter($_POST['atividade']);
	$goals = array_filter($_POST['meta']);
	$descricoes = array_filter($_POST['descricao']);	
	$execucoes = array_filter($_POST['execucao']);
	$feitos = array_filter($_POST['atividade3']);
	$upCount = 0;

	for ($i = 0; $i < sizeof($atividades) -1; $i++) {
		if ($feitos[$i] == null) {
			$feitos[$i] = 0;
		}

		if ($descricoes[$i] == "" || $descricoes[$i] == null) {//VERIFICA SE ALGUMA DAS INFORMAÇÕES FOI ATUALIZADA.
			$checkUp = "SELECT ID FROM META WHERE ID=".$ids[$i]." AND ATIVIDADE_ID=".$atividades[$i]." AND META=".$goals[$i]." AND EXECUCAO='".$execucoes[$i]."' AND DESEMPENHO=".$feitos[$i].";";
		} else {
			$checkUp = "SELECT ID FROM META WHERE ID=".$ids[$i]." AND ATIVIDADE_ID=".$atividades[$i]." AND META=".$goals[$i]." AND DESEMPENHO=".$feitos[$i]." AND EXECUCAO='".$execucoes[$i]."' AND DESCRICAO='".$descricoes[$i]."';";
		}
		
		$tx = mysqli_query($phpmyadmin, $checkUp);		
		
		if (mysqli_num_rows($tx) == 0 && mysqli_error($phpmyadmin) == null) {			
			$cnx = mysqli_query($phpmyadmin, "UPDATE META SET ATIVIDADE_ID=".$atividades[$i].", META=".$goals[$i].", EXECUCAO='".$execucoes[$i]."', DESEMPENHO=".$feitos[$i].", DESCRICAO='".$descricoes[$i]."' WHERE ID=".$ids[$i].";");
			$upCount = $upCount + 1;			
		}

	}

	if ($upCount == 0) {	
		echo "<script>alert('Nenhum registro foi alterado p/ ser atualizado!!'); window.location.href=window.location.href;	</script>";
	} else {
		echo "<script>alert('Foi atualizado $upCount registro(s)!!'); window.location.href=window.location.href; </script>";
	}
}

?>