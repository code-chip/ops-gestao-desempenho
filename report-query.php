<?php
$menuAtivo="Desempenho";
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
	<title>Gestão de Desempenho - Consultar Desempenho</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">
    <link rel="stylesheet" type="text/css" href="/css/personal.css">
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
	<?php /*CONSULTAS PARA CARREGAS AS OPÇÕES DE SELEÇÃO DO CADASTRO.*/
	$gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'";			
	?>
	<br/>
	<span id="top"></span>
<div>	
	<?php if($setor =="" && isset($_POST['consultar'])==null ): ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="" method="POST">
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Mês:</label>
			</div>
				<div class="field-body">
					<div class="field">							
						<div class="control">
							<div class="select">
								<select name="periodo" class="w24-2">
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
					<div class="field">							
						<div class="control">
							<div class="select">
								<select name="setor" class="w24-2">								
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
							<div class="select w24-2"><!--SELEÇÃO OU PESQUISA DE NOME-->
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
							<button name="consultar" type="submit" class="button is-primary btn128">Consultar</button>
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
	$query="SELECT U.NOME AS USUARIO, P.NOME AS PRESENCA, A.NOME AS ATIVIDADE, D.META, D.ALCANCADO AS ALCANCADO, D.DESEMPENHO, D.REGISTRO, D.OBSERVACAO FROM DESEMPENHO D 
	INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID
	INNER JOIN PRESENCA P ON P.ID=D.PRESENCA_ID
	INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID
	WHERE SETOR_ID=".$setor." AND USUARIO_ID IN(SELECT ID FROM USUARIO WHERE NOME LIKE '%".$nome."%')
	AND D.REGISTRO>=DATE_SUB(CONCAT('".$periodo."','-21'), interval 1 month) AND D.REGISTRO<= CONCAT('".$periodo."', '-20');";
	}
	else{	
	$query="SELECT U.NOME AS USUARIO, P.NOME AS PRESENCA, A.NOME AS ATIVIDADE, D.META, D.ALCANCADO AS ALCANCADO, D.DESEMPENHO, D.REGISTRO, D.OBSERVACAO FROM DESEMPENHO D 
	INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID
	INNER JOIN PRESENCA P ON P.ID=D.PRESENCA_ID
	INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID
	WHERE SETOR_ID=".$setor." AND USUARIO_ID IN(SELECT ID FROM USUARIO)
	AND D.REGISTRO>=DATE_SUB(CONCAT('".$periodo."','-21'), interval 1 month) AND D.REGISTRO<= CONCAT('".$periodo."', '-20') ORDER BY REGISTRO, U.NOME;";
	}
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($operadores= $cnx->fetch_array()){
		$vtNome[$x]=$operadores["USUARIO"];
		$vtPresenca[$x]=$operadores["PRESENCA"];
		$vtAtividade[$x]=$operadores["ATIVIDADE"];
		$vtMeta[$x]=$operadores["META"];
		$vtAlcancado[$x]=$operadores["ALCANCADO"];
		$vtDesempenho[$x]=$operadores["DESEMPENHO"];
		$vtRegistro[$x]=$operadores["REGISTRO"];
		$vtObservacao[$x]=$operadores["OBSERVACAO"];					
		$x++;
		$contador=$x;
	}
	if(mysqli_num_rows($cnx)==0){
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
	<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch">	
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
<?php for( $i = 0; $i < sizeof($vtNome); $i++ ) : ?>
	<?php $z=$i; $registro=1; while($vtNome[$z]==$vtNome[$z+1]){
		$registro++;
		$repeat=$registro;
		$z++;
	}
	if($repeat>0){ $repeat--;}	
	?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td><?php echo $vtNome[$i]?></td>
		<td><?php echo $vtPresenca[$i]?></td>
		<td><?php echo $vtAtividade[$i]?></td>
		<td><?php echo $vtMeta[$i]?></td>
		<td><?php echo $vtAlcancado[$i]?></td>
		<td><?php echo round($vtDesempenho[$i],2)."%"?></td>			
		<td><?php echo $vtRegistro[$i]?></td>
		<td><?php echo $vtObservacao[$i]?></td>
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
</html><?php }//ELSE - caso o usuário não tenha permissão.