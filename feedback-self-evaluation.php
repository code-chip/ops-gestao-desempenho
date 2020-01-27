<?php
$menuFeedback="is-active";
include('menu.php');
$info="SELECT C.NOME AS CARGO FROM USUARIO U JOIN CARGO C ON C.ID=U.CARGO_ID WHERE U.ID=1".$_SESSION["userId"];
$cx=mysqli_query($phpmyadmin, $info);
$cargo=$cx->fetch_array();
echo $cargo["CARGO"];
echo $_SESSION["userId"];
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
	<div class="box" style="margin-bottom: -30px; background-color: rgb(64,224,208)"></div>
	<div class="box">
		<div class="is-size-1-desktop"><strong>Avaliação de Desempenho - Operação ( evino )</strong></div>
	</div>
	<div class="box is-size-4-desktop has-text-white" style="margin-bottom: -30px; background-color: rgb(64,224,208);"><?php echo $cargo["CARGO"];?><br></div><br>
	<div class="box is-size-7-touch">
		<div><strong>Auto-avaliação</strong> <br>Aqui você deverá fazer  a sua auto avaliação sobre cada item abordado:</div>
	</div><?php
	$y=1;	
	$getPergunta="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA ORDER BY ORDEM;";
	$cnx=mysqli_query($phpmyadmin, $getPergunta);
	while ($pergunta=$cnx->fetch_array()):{ $questao="questao".$y; $idPergunta[$y-1]=$pergunta["ID"];?>
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
		      		<input type="radio" name="<?php echo $questao;?>" value="<?php echo $resposta["ID"];?>"><?php echo $resposta["RESPOSTA"];?>
		    	</label>		    	
		  	</div>
		</div>
		<?php	$x++;} ?>		
	</div>
<?php $y++;}endwhile;?>
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
		    	<button class="button is-link is-light" name="proxima">Próxima</button>
		  	</div>
		</div>
	</div>									
	</form>
	</div>
	</section>	
</section>	
</body>
</html>
<?php 
if(isset($_POST['proxima'])){
	$z=1;
	while ($z <= $y) {//ARMAZENAS AS RESPOSTAS NO VETOR.
		$resposta[$z-1]=$_POST["questao".$z];
		$z++;
	}
	for($i=0 ;$i<sizeof($resposta);$i++){//INSERE NO BANCO OS ID'S DAS PERGUNTAS E RESPOSTAS.
		echo $resposta[$i];
		$salvar="INSERT INTO AVAL_REALIZADA(USUARIO_ID, AVAL_PERGUNTA, AVAL_RESPOSTA, REGISTRO) VALUES(".$_SESSION['userId'].", ".$idPergunta[$i].",".$resposta[$i].", '".date('Y-m-d')."');";
		echo $salvar;
		//$cnx=mysqli_query($phpmyadmin, $salvar);
	}
	//header("refresh: 1; url=feedback-techinnal.php");
}
?>