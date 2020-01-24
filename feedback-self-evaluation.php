<?php
$menuFeedback="is-active";
include('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Autoavaliação</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">   
    <link rel="stylesheet" type="text/css" href="/css/test.css">   
</head>
<body>
<div>	
	<section class="section">
	<div class="container">	
	<form id="form1" action="" method="POST">
	<div class="box" style="margin-bottom: -30px; background-color: rgb(205,92,92)"></div>
	<div class="box">
		<div class="is-size-1-desktop"><strong>Avaliação de Desempenho - Operação ( evino )</strong></div>
	</div>
	<div class="box is-size-4-desktop has-text-white" style="margin-bottom: -30px; background-color: rgb(205,92,92);"> Operador I <br></div><br>
	<div class="box is-size-7-touch">
		<div><strong>Auto-avaliação</strong> <br>Aqui você deverá fazer  a sua auto avaliação sobre cada item abordado:</div>
	</div>
	<?php $getPergunta="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA ORDER BY ORDEM;";
	$cnx=mysqli_query($phpmyadmin, $getPergunta);
	while ($pergunta=$cnx->fetch_array()):{?>
	<div class="box">	
		<div class="field is-horizontal">
			<div class="text"><?php echo $pergunta["PERGUNTA"];?></div>				
		</div>
		<?php $getResposta="SELECT ID, RESPOSTA FROM AVAL_RESPOSTA WHERE SITUACAO='Ativo';";
		$x=0;
		$cnx2=mysqli_query($phpmyadmin, $getResposta);
		while ($resposta= $cnx2->fetch_array()){?>
		<div class="field ">
		  	<div class="control">
		    	<label class="radio">
		      		<input type="radio" name="question" value="<?php echo $resposta["ID"];?>"><?php echo $resposta["RESPOSTA"];?>
		    	</label>		    	
		  	</div>
		</div>
		<?php	$x++;} ?>		
	</div>
<?php }endwhile;?>
	<div class="box">	
		<div class="field">
		  	<label class="label">Comente os pontos positivos e pontos de melhorias mais relevantes: *</label>
		  	<div class="control">
		    	<textarea class="textarea" placeholder="Sua resposta" maxlength="500"></textarea>
		  	</div>
		</div>
		<div class="field is-grouped">
		  	<div class="control">
		    	<button class="button is-link">Cancelar</button>
		  	</div>
		  	<div class="control">
		    	<button class="button is-link is-light">Próxima</button>
		  	</div>
		</div>
	</div>									
	</form>
	</div>
	</section>	
</section>	
</body>
</html>