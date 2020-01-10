<style type="text/css">
</style>
<?php
$menuMeta="is-active";
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
	<title>Gestão de Desempenho - Remover Meta</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">
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
	<?php
	/*CONSULTAS PARA CARREGAS AS OPÇÕES DE SELEÇÃO DO CADASTRO.*/
	$gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'";			
	?>
	<br/>
	<span id="topo"></span>
<div>	
	<?php if($setor =="" && isset($_POST['consultar'])==null ): ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="goal-remove.php" method="POST">
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Mês:</label>
			</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select name="periodo">
									<option value="<?php echo date('Y-m', strtotime("+1 months"))?>"><?php echo date('m/Y', strtotime("+1 months"))?></option>
									<option selected="selected" value="<?php echo date('Y-m')?>"><?php echo date('m/Y')?></option>
									<option value="<?php echo date('Y-m', strtotime("-1 months"))?>"><?php echo date('m/Y', strtotime("-1 months"))?></option>
									<option value="<?php echo date('Y-m', strtotime("-2 months"))?>"><?php echo date('m/Y', strtotime("-2 months"))?></option>
									<option value="<?php echo date('Y-m', strtotime("-3 months"))?>"><?php echo date('m/Y', strtotime("-3 months"))?></option>
									<option value="<?php echo date('Y-m', strtotime("-4 months"))?>"><?php echo date('m/Y', strtotime("-4 months"))?></option>
									<option value="<?php echo date('Y-m', strtotime("-5 months"))?>"><?php echo date('m/Y', strtotime("-5 months"))?></option>
								</select>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Setor:</label>
				</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select name="setor">								
								<?php $con = mysqli_query($phpmyadmin , $gdSetor);
								$x=0; 
								while($setor = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x]=$setor["ID"]; ?>"><?php echo $vtNome[$x] = $setor["NOME"]; ?></option>
								<?php $x;} endwhile;?>	
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Nome:</label>
				</div>
				<div class="field-body">
					<div class="field">							
						<div class="control">
							<div class="select"><!--SELEÇÃO OU PESQUISA DE NOME-->
							<input name="nome" type="text" class="input" placeholder="Ana Clara">
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
	</div>
	</section>	
	<?php endif; ?>		
</div>
<?php
if(isset($_POST['consultar'])){	
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
?>
<!--FINAL DO FORMULÁRIO DE FILTRAGEM-->
<?php if(isset($_POST['consultar']) && $contador!=0) : ?>
<hr/>
<section class="section">
<form id="form2" action="goal-remove.php" method="POST">	
<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch">	
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
					<input type="submit" class="button is-primary" id="submitQuery" onClick="history.go(0)" value="Atualizar"/>						
				</div>
				<div class="control">
					<a href="goal-remove.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
				</div>
				<div class="control">
					<input name="removerDados" type="submit" class="button is-primary" value="Deletar Dados"/>
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