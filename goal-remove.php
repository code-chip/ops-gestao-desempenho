<?php
$menuAtivo="meta";
include('menu.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else{
$periodo= trim($_REQUEST['periodo']);
$setor= trim($_REQUEST['setor']);
$nome= trim($_REQUEST['nome']);
$contador = 0;
$totalAlcancado=0;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style type="text/css" src="css/personal.css"></style>
	<title>Gestão de Desempenho - Remover Meta</title>
    <style type="text/css">
    	.w24-2{
    		width:24.2em;
    	}
    </style>
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
	<?php if($setor =="" && isset($_POST['query'])==null ): ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="goal-remove.php" method="POST">
		<div class="field">
			<label class="label is-size-7-touch">Mês*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="periodo"><?php 								
							$con = mysqli_query($phpmyadmin , "SELECT DATE_FORMAT(CADASTRO_EM,'%Y-%m') AS ANO_MES, DATE_FORMAT(CADASTRO_EM,'%m/%Y') AS MES_ANO FROM META GROUP BY 1 ORDER BY ANO_MES DESC LIMIT 24");
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
				<label class="label is-size-7-touch">Nome</label>
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
	<?php endif; ?>		
</div>
<?php
if(isset($_POST['query'])){	
	if( $nome != ""){		
		$query="SELECT U.NOME, A.NOME AS ATIVIDADE, M.META, M.DESCRICAO, M.EXECUCAO, M.CADASTRO_EM, M.DESEMPENHO FROM META M
	INNER JOIN USUARIO U ON U.ID=M.USUARIO_ID
	INNER JOIN ATIVIDADE A ON A.ID=M.ATIVIDADE_ID
	WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE NOME LIKE '%".$nome."%' AND SETOR_ID=".$setor.")
		AND M.EXECUCAO>=DATE_SUB(CONCAT('".$periodo."','-21'), interval 1 month) AND M.EXECUCAO<= CONCAT('".$periodo."', '-20');";
	}	
	else{	
		$query="SELECT M.ID AS ID, U.NOME, A.NOME AS ATIVIDADE, M.META, M.DESCRICAO, M.EXECUCAO, M.CADASTRO_EM, M.DESEMPENHO FROM META M
	INNER JOIN USUARIO U ON U.ID=M.USUARIO_ID
	INNER JOIN ATIVIDADE A ON A.ID=M.ATIVIDADE_ID
	WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE SETOR_ID=".$setor.") AND M.EXECUCAO>=DATE_SUB(CONCAT('".$periodo."','-21'), interval 1 month) AND M.EXECUCAO<= CONCAT('".$periodo."', '-20') ORDER BY 1;";
	}
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	if(mysqli_num_rows($cnx)>0){
		while($meta= $cnx->fetch_array()){
			$vtId[$x]=$meta["ID"];
			$vtNome[$x]=$meta["NOME"];
			$vtAtividade[$x]=$meta["ATIVIDADE"];
			$vtMeta[$x]=$meta["META"];
			$vtExecucao[$x]=$meta["EXECUCAO"];
			$vtDesempenho[$x]=$meta["CADASTRO_EM"];
			$vtDescricao[$x]=$meta["DESCRICAO"];					
			$x++;
			$contador=$x;
		}
	}
	else{
		?><script type="text/javascript">			
			alert('Nenhum registrado encontrado nesta consulta!');
			window.location.href=window.location.href;
		</script> <?php		
	}
}	
?><!--FINAL DO FORMULÁRIO DE FILTRAGEM-->
<?php if(isset($_POST['query']) && $contador!=0) : ?>
<hr/>
<section class="section">
<form id="form2" action="goal-remove.php" method="POST">	
<div class="table__wrapper">
	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th>Apagar</th>
		<th>Funcionário</th>
		<th>Atividade</th>	
		<th>Meta</th>			
		<th>Descrição</th>
		<th>Execução</th>			
		<th>Feita</th>		
	</tr>
<?php for( $i = 0; $i < sizeof($vtNome); $i++ ) : ?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td>
			<label class="checkbox">
  				<input name="id[]" type="checkbox" value="<?php echo $vtId[$i]?>">
  				Sim
  			</label>  			
		</td>	
		<td><?php echo $vtNome[$i]?></td>
		<td><?php echo $vtAtividade[$i]?></td>
		<td><?php echo $vtMeta[$i]?></td>
		<td><?php echo $vtDescricao[$i]?></td>
		<td><?php echo $vtExecucao[$i]?></td>
		<td><?php if($vtDesempenho[$i]==0){ echo "Não";}else{ echo "Sim";}?></td>
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
					<input name="removerDados" type="submit" class="button is-primary btn128" value="Deletar Dados"/>
				</div>	
				<div class="control">
					<a href="goal-remove.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
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
if(isset($_POST['removerDados'])){
	$ids= array_filter($_POST['id']);
	$upCount=0;
	for( $i = 0; $i < sizeof($ids); $i++ ){
		$delete="DELETE FROM META WHERE ID=".$ids[$i].";";
		$cnx=mysqli_query($phpmyadmin, $delete);
		$upCount=$upCount+1;			 
	}	
	if(mysqli_error($phpmyadmin)==null && $upCount>0){	
		?><script type="text/javascript">
			alert('<?php echo $upCount;?> Meta(s) deletada(s)');
			window.location.href=window.location.href;		
		</script><?php
	}
	else if($upCount==0){
		?><script type="text/javascript">
			alert('Nenhuma Informação foi marcada p/ ser deletada!!');
		</script><?php
	}
	else{
		?><script type="text/javascript">
			alert('Erro ao deletar registro de Meta!!');
			window.location.href=window.location.href;
		</script><?php
	}
}
}//ELSE - caso o usuário não tenha permissão.
?>