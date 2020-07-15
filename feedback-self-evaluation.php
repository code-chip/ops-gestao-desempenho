<?php
$menuAtivo ='feedback';
require('menu.php');

$data = date('Y-m-d');

$cx = mysqli_query($phpmyadmin, "SELECT C.NOME AS CARGO FROM USUARIO U JOIN CARGO C ON C.ID=U.CARGO_ID WHERE U.ID=".$_SESSION["userId"]);
$cargo = $cx->fetch_array();

//CHECK SE JÁ HOUVE ALGUMA PERGUNTA RESPONDIDA;
$cy = mysqli_query($phpmyadmin, "SELECT ID, SITUACAO FROM AVAL_INDICE WHERE USUARIO_ID=".$_SESSION["userId"]." AND REGISTRO='".$data."';");
$indice = $cy->fetch_array();

if ($indice["SITUACAO"] == "Finalizado") {
	echo "<script>alert('Avaliação já realizada, aguarde o próximo período'); window.location.href='home.php';</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Autoavaliação</title>
</head>
<body>
<div>	
	<section class="section">
	<div class="container">	
	<form id="form" action="feedback-self-evaluation.php" method="POST">
	<div class="box" style="margin-bottom: -30px; background-color: rgb(64,224,208)"></div>
	<div class="box">
		<div class="is-size-1-desktop"><strong>Avaliação de Desempenho - Operação ( evino )</strong></div>
	</div>
	<div class="box is-size-4-desktop has-text-white" style="margin-bottom: -30px; background-color: rgb(64,224,208);"><?php echo $cargo["CARGO"];?><br></div><br>
	<div class="box is-size-7-touch">
		<div><strong>Auto-avaliação</strong> <br>Aqui você deverá fazer  a sua auto avaliação sobre cada item abordado:</div>
	</div><!--FINAL PERGUNTA TÉCNICA-->
	<div class="box">Técnicas</div><?php $y=1;		
	//VERIFICA SE HÁ PERGUNTA P/ CARGO DO USUÁRIO.
	$cnx=mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=1 AND CARGO_ID=".$_SESSION["cargo"]." ORDER BY ORDEM;");
	while ($pergunta = $cnx->fetch_array()):{ 
		$questao = "questao" . $y; 
		$idPergunta[$y-1] = $pergunta["ID"];
		
		if (mysqli_num_rows($cy) > 0) {
			$cnx2 = mysqli_query($phpmyadmin, "SELECT AVAL_RESPOSTA_ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$indice["ID"]." AND AVAL_PERGUNTA_ID=".$idPergunta[$y-1].";");
			$houveResposta = true;
			$getRes = $cnx2->fetch_array();
			$getIdResposta = $getRes["AVAL_RESPOSTA_ID"];
			$selecao = "CHECKED";
		} else {
			$selecao = null;
			$houveResposta = false;
		}
	
	?>
	<div class="box">	
		<div class="field is-horizontal">
			<div class="text"><?php echo $pergunta["PERGUNTA"];?></div>				
		</div>
		<?php
		$x = 0;
		$cnx3 = mysqli_query($phpmyadmin, "SELECT ID, RESPOSTA FROM AVAL_RESPOSTA WHERE SITUACAO='Ativo';");
		while ($resposta = $cnx3->fetch_array()) { ?>
		<div class="field ">
		  	<div class="control">
		    	<label class="radio">
		      		<input type="radio" name="<?php echo $questao;?>" value="<?php echo $resposta["ID"];?>" <?php if($getIdResposta==$resposta["ID"]){ echo $selecao;}?>><?php echo $resposta["RESPOSTA"];?>
		    	</label>		    	
		  	</div>
		</div>
		<?php	$x++;} ?>		
	</div>
<?php $y++;}endwhile;?>	<!--PERGUNTA COMPORTAMENTAL-->
	<div class="box">Comportamentais</div><?php
	$cnx = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=2 AND CARGO_ID=".$_SESSION["cargo"]." ORDER BY ORDEM;");
	while ($pergunta = $cnx->fetch_array()):{ 
		$questao = "questao" . $y; 
		$idPergunta[$y-1] = $pergunta["ID"];

		if (mysqli_num_rows($cy) > 0) {
			//CHECK SE A PERGUNTA FOI RESPONDIDA;
		    $cnx2 = mysqli_query($phpmyadmin, "SELECT AVAL_RESPOSTA_ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$indice["ID"]." AND AVAL_PERGUNTA_ID=".$idPergunta[$y-1].";");
			$houveResposta = true;
			$getRes = $cnx2->fetch_array();
			$getIdResposta = $getRes["AVAL_RESPOSTA_ID"];
			$selecao = "CHECKED";
		} else {
			$selecao = null;
			$houveResposta = false;
		}
		?>
	<div class="box">	
		<div class="field is-horizontal">
			<div class="text"><?php echo $pergunta["PERGUNTA"];?></div>				
		</div>
		<?php $getResposta="SELECT ID, RESPOSTA FROM AVAL_RESPOSTA WHERE SITUACAO='Ativo';";
		$x=0;
		$cnx3=mysqli_query($phpmyadmin, $getResposta); $ts=false; echo $ts;
		while ($resposta= $cnx3->fetch_array()){?>
		<div class="field ">
		  	<div class="control">
		    	<label class="radio">
		      		<input type="radio" name="<?php echo $questao;?>" value="<?php echo $resposta["ID"];?>" <?php if($getIdResposta==$resposta["ID"]){ echo $selecao;}?>><?php echo $resposta["RESPOSTA"];?>
		    	</label>		    	
		  	</div>
		</div>
		<?php	$x++;} ?>		
	</div>
<?php $y++;}endwhile; //<!--FINAL PERGUNTA COMPORTAMENTAL-->
	$cnx7 = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=1 AND SITUACAO='Ativo'");
	$getComentario = $cnx7->fetch_array();
	if ($houveResposta == true) {
		$cnx8=mysqli_query($phpmyadmin, "SELECT COMENTARIO FROM AVAL_COMENTARIO WHERE AVAL_PERGUNTA_COM_ID=".$getComentario["ID"]." AND AVAL_INDICE_ID=".$indice["ID"].";");
		$getCom=$cnx8->fetch_array();
	}
?>
	<div class="box">	
		<div class="field">
		  	<label class="label"><?php echo $getComentario["PERGUNTA"];?></label>
		  	<div class="control">
		    	<textarea name="comentario" class="textarea" placeholder="Sua resposta" maxlength="1000"><?php echo $getCom["COMENTARIO"];?></textarea>
		  	</div>
		</div>
		<div class="field is-grouped">
		  	<div class="control">
		    	<a href="home.php"><button class="button is-link">Cancelar</button></a>
		  	</div>
		  	<div class="control">
		    	<input type="submit" name="proxima" class="button is-link is-light" onclick="window.location.href='feedback-technical-evaluation.php'" value="Próxima">
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
if (isset($_POST['proxima'])) {
	$comentario = $_POST["comentario"];
	$z = 1; 
	$respostaNula = 0;

	while ($z <= $y) {//ARMAZENA AS RESPOSTAS NO VETOR.
		$resposta[$z-1] = $_POST["questao".$z];
		if ($resposta[$z-1] == null) {			
			$respostaNula++;
			$resposta[$z-1] = 5;//ID REFERENTE AO TEXTO AGUARDANDO RESPOSTA.
		}

		$z++;			
	}//CONSULTA SE HÁ REGISTRO DE AVALIAÇÃO NESTE DIA.
	
	if (mysqli_num_rows($cy) == 0) {
		mysqli_query($phpmyadmin, "INSERT INTO AVAL_INDICE(USUARIO_ID,REGISTRO,SITUACAO) VALUES(".$_SESSION["userId"].",'".$data."','Iniciado')");
		//SALVA CHAVE DO INDICE.
		$cnx5 = mysqli_query($phpmyadmin, "SELECT ID FROM AVAL_INDICE WHERE USUARIO_ID=".$_SESSION["userId"]." AND REGISTRO='".$data."' AND SITUACAO<>'Finalizado';");
		$indice = $cnx5->fetch_array();
		$idInd = $indice["ID"];
	} else {//SALVA CHAVE DO INDICE.
		$idInd = $indice["ID"];
	}

	if ($houveResposta == true) {//SE JÁ HOUVE RESPOSTA, ATUALIZA.	
		for ($i = 0; $i < sizeof($resposta) - 1; $i++) {//PERCORRE AS QUESTÕES.
			$cnx4 = mysqli_query($phpmyadmin, "SELECT ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$idInd." AND AVAL_PERGUNTA_ID=".$idPergunta[$i].";");
			if (mysqli_num_rows($cnx4) > 0) {
				$getRes = $cnx4->fetch_array();
				mysqli_query($phpmyadmin, "UPDATE AVAL_REALIZADA SET AVAL_RESPOSTA_ID=".$resposta[$i]." WHERE ID=".$getRes["ID"].";");
			}
		}					
	} else {
		for ($i = 0; $i < sizeof($resposta) - 1; $i++) {//PERCORRE PELAS QUESTÕES.			
			mysqli_query($phpmyadmin, "INSERT INTO AVAL_REALIZADA(AVAL_INDICE_ID, AVAL_PERGUNTA_ID, AVAL_RESPOSTA_ID) VALUES(".$idInd.", ".$idPergunta[$i].",".$resposta[$i].");");
		}
	}//VERIFICAÇÃO DO COMENTÁRIO.
	
	$cnx6 = mysqli_query($phpmyadmin, "SELECT ID FROM AVAL_COMENTARIO WHERE AVAL_PERGUNTA_COM_ID=(SELECT ID FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=1 AND SITUACAO='Ativo') AND AVAL_INDICE_ID = " . $idInd);

	if (mysqli_num_rows($cnx6) == 0 && $comentario != null) {
		mysqli_query($phpmyadmin, "INSERT INTO AVAL_COMENTARIO(AVAL_INDICE_ID, AVAL_PERGUNTA_COM_ID, COMENTARIO) VALUES(".$idInd.", (SELECT ID FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=1 AND SITUACAO='Ativo'),'".$comentario."')");
		$houveComentario = true;
	}
	else if (mysqli_num_rows($cnx6) == 1 && $comentario != null) {
		$idComentario = $cnx6->fetch_array();
		mysqli_query($phpmyadmin, "UPDATE AVAL_COMENTARIO SET COMENTARIO='".$comentario."' WHERE ID=".$idComentario["ID"]);
	}

	$respostaNula = $respostaNula-1;
	
	if ($respostaNula > 0) {
		echo "<script>alert('Atenção todas respostas são obrigatórias!'); window.location.href=window.location.href; </script>";	
	} else if ($respostaNula == 0 && $comentario == null) {
		echo "<script>alert('Preenchimento do comentário é obrigatório!'); window.location.href=window.location.href; </script>";
	} else {
		if ($indice["SITUACAO"] != "Lider") {
			mysqli_query($phpmyadmin, "UPDATE AVAL_INDICE SET SITUACAO='Auto' WHERE ID=".$idInd);
		}
		
		echo "<script>window.location.href='feedback-technical-evaluation.php'; </script>";	
	}
}
?>