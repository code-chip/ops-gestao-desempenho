<style type="text/css">
</style>
<?php
session_start();
$menuDesempenho="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$turno= trim($_REQUEST['turno']);
$setor= trim($_REQUEST['setor']);
$data= trim($_REQUEST['data']);
$contador = 0;
$totalAlcancado=0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Desempenho Pedentes</title>
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
	$gdTurno="SELECT ID, NOME FROM TURNO WHERE SITUACAO='Ativo'";
	$gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'";			
	?>
	<br/>
	<span id="topo"></span>
<div>	
	<?php if($setor =="" && isset($_POST['consultar'])==null ): ?>
	<section class="section">
	<div class="container">	
	<form id="form1" action="" method="POST">
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Turno:</label>
			</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select name="turno">
								<option selected="selected" value="">Selecione</option>	
								<?php $con = mysqli_query($phpmyadmin , $gdTurno);
								$x=0; 
								while($turno = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $turno["ID"]; ?>"><?php echo $vtNome[$x] = $turno["NOME"]; ?></option>
								<?php $x;} endwhile;?>	
							</select>
							</div>&nbsp&nbsp&nbsp
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
					<label class="label">Data:</label>
				</div>
				<div class="field-body">
					<div class="field">							
						<div class="control">
							<div class="select"><!--SELEÇÃO OU PESQUISA DE NOME-->
							<input name="data" type="text" class="input" placeholder="Ana Clara" value="<?php echo date('Y-m-d',strtotime('-1 day'));?>">
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
if($data != "" && $setor!="" && $turno!=""){	
	$query="SELECT U.ID, U.NOME FROM USUARIO U 
INNER JOIN DESEMPENHO D ON D.USUARIO_ID=U.ID
WHERE U.TURNO_ID=".$turno." AND U.SETOR_ID=".$setor." AND U.SITUACAO='Ativo' AND D.REGISTRO<>'".$data."' GROUP BY U.ID ORDER BY NOME";
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($operadores= $cnx->fetch_array()){
		$vtNome[$x]=$operadores["NOME"];				
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
else if(isset($_POST['consultar'])!=null){
	?><script type="text/javascript">			
		alert('A seleção é obrigatória!!');
		window.location.href=window.location.href;
	</script> <?php	
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
		<th>Sem registro em</th> 			
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
		<td><?php echo $data?></td>
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
				<a href="report-pedant.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consultar"/></a>
			</div>					
		</div>						
	</div>
</div>
</section>	
<?php endif; ?>
</body>
</html>
<?php