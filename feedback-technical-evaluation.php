<?php
$menuAtivo = 'feedback';
require('menu.php');

$data = date('Y-m-d');

$cy = mysqli_query($phpmyadmin, "SELECT ID, SITUACAO, C.CARGO, C.CARGO_ID FROM AVAL_INDICE, (SELECT C.NOME AS CARGO, C.ID AS CARGO_ID FROM USUARIO U JOIN CARGO C ON C.ID=U.CARGO_ID WHERE U.ID = ". $_SESSION['user'] . ") AS C WHERE USUARIO_ID = ".$_SESSION['user']." AND AVALIACAO_POR = " . $_SESSION['userId'] . " AND REGISTRO='" . $data . "';");
$index = $cy->fetch_array();
$answer = mysqli_num_rows($cy);

if ($index["SITUACAO"] == "Finalizado") {
	echo "<script>alert('Avaliação já realizada, aguarde o próximo período'); window.location.href='home.php';</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Avaliação Líder</title>
	<script type="text/javascript">
		function check(){
			var inputs = document.getElementsByClassName('required');
			size = inputs.length;
			request = (inputs.length)/4; //4 é o número de respostas por pergunta.
			var limit = size - request;
			var count = 0;
			
			for (var i = 0; i < size; i++) {
				if (!inputs[i].checked) {
					count++;
				}
			}
			
			count = count-limit;
			
			if (count > 0) {
				if(count == 1){
					alert('Falta responder 1 pergunta!')
				} else {
					alert('Faltam responder '+count+' perguntas!');
				}

				return false;
			} else if (document.getElementById('comment').value == "") {
				alert('O comentário é obrigatório!');
				return false;
			}

			return true;
		}
	</script>
	<style type="text/css">
		.button{
			width: 121px;
		}
	</style>
</head>
<body>
<div>	
	<section class="section">
	<div class="container">	
	<form id="form" action="feedback-technical-evaluation.php" method="POST" onsubmit="return check()">
	<div class="box" style="margin-bottom: -30px; background-color: rgb(64,224,208)"></div>
	<div class="box">
		<div class="is-size-1-desktop"><strong>Avaliação de Desempenho - Operação ( evino )</strong></div>
	</div>
	<div class="box is-size-4-desktop has-text-white" style="margin-bottom: -30px; background-color: rgb(64,224,208);"><?php echo $index["CARGO"];?><br></div><br>
	<div class="box is-size-7-touch">
		<div><strong>Avaliação Líder</strong> <br>Responda sobre o seu líder</div>
	</div><!--FINAL PERGUNTA TÉCNICA-->
	<div class="box">Técnicas</div>
	<?php 

	$y = 1;		
	//VERIFICA SE HÁ PERGUNTA P/ CARGO DO USUÁRIO.
	$cnx = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID = 3 AND CARGO_ID=" . $index['CARGO_ID'] . " ORDER BY ORDEM;");
	while ($pergunta=$cnx->fetch_array()){ 
		$questao = 'questao' . $y; 
		$idPergunta[$y-1] = $pergunta['ID'];
		
		echo "
		<div class='box'>	
			<div class='field is-horizontal'>
				<div class='text'>" . $pergunta["PERGUNTA"] . "</div>				
			</div>";
		
		$x = 0;
		$cnx3 = mysqli_query($phpmyadmin, "SELECT ID, RESPOSTA FROM AVAL_RESPOSTA WHERE SITUACAO='Ativo';");
		while ($resposta = $cnx3->fetch_array()) { ?>
			<div class="field ">
			  	<div class="control">
			    	<label class="radio">
			      		<input type="radio" name="<?php echo $questao;?>" class='required' value="<?php echo $resposta["ID"];?>" <?php if($getIdResposta==$resposta["ID"]){ echo $selecao; } ?> ><?php echo $resposta["RESPOSTA"];?>
			    	</label>		    	
			  	</div>
			</div>
		<?php

		$x++;

		}

		echo '</div>';
		$y++;
	}

	//<!--PERGUNTA COMPORTAMENTAL-->
	echo "<div class='box'>Comportamentais</div>";
	$getPergunta = "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID = 4 AND CARGO_ID = " . $index['CARGO_ID'] . " ORDER BY ORDEM;";
	$cnx = mysqli_query($phpmyadmin, $getPergunta);
	
	while ($pergunta = $cnx->fetch_array()) { 
		$questao = "questao" . $y; $idPergunta[$y-1] = $pergunta["ID"];		
		
		echo "<div class='box'>	
		<div class='field is-horizontal'>
			<div class='text'>" . $pergunta["PERGUNTA"] ."</div>				
		</div>";

		$x = 0;
		$cnx3 = mysqli_query($phpmyadmin, "SELECT ID, RESPOSTA FROM AVAL_RESPOSTA WHERE SITUACAO = 'Ativo';"); 
		$ts = false; 
		echo $ts;
		while ($resposta = $cnx3->fetch_array()) { ?>
			<div class="field ">
			  	<div class="control">
			    	<label class="radio">
			      		<input type="radio" name="<?php echo $questao;?>" class='required' value="<?php echo $resposta["ID"];?>" <?php if($getIdResposta==$resposta["ID"]){ echo $selecao;}?>><?php echo $resposta["RESPOSTA"];?>
			    	</label>		    	
			  	</div>
			</div>
			<?php	
			$x++;
		}

		echo '</div>';
		$y++;
	}//<!--FINAL PERGUNTA COMPORTAMENTAL-->
	
	$cnx7 = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID = 2 AND SITUACAO = 'Ativo'");
	$getComentario = $cnx7->fetch_array();
	
	?>
	<div class="box">	
		<div class="field">
		  	<label class="label"><?php echo $getComentario["PERGUNTA"];?></label>
		  	<div class="control">
		    	<textarea name="comentario" id="comment" class="textarea" placeholder="Sua resposta" maxlength="710"></textarea>
		  	</div>
		</div>
		<div class="field is-grouped">
		  	<div class="control">
		    	<input type="button" class="button is-link" value="Voltar" onclick="window.location.href='feedback-self-evaluation.php'">
		  	</div>
		  	<div class="control">
		    	<button class="button is-link is-light" name="enviar" type="submit">Enviar</button>
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

if (isset($_POST['enviar'])) {
	$comentario = $_POST["comentario"];

	$comentario = str_replace(array('\'', '"'), '', $comentario);
	
	$z = 1; 
	$respostaNula = 0;
	
	while ($z <= $y) {//ARMAZENA AS RESPOSTAS NO VETOR.
		$resposta[$z-1] = $_POST["questao".$z];
		$z++;			
	}
	
	for ($i = 0 ;$i < sizeof($resposta) - 1; $i++) {//PERCORRE PELAS QUESTÕES.			
		mysqli_query($phpmyadmin, "INSERT INTO AVAL_REALIZADA(AVAL_INDICE_ID, AVAL_PERGUNTA_ID, AVAL_RESPOSTA_ID) VALUES(" . $index["ID"] . ", " . $idPergunta[$i] . ", " . $resposta[$i] . ");");
	}
	mysqli_query($phpmyadmin, "UPDATE AVAL_INDICE SET SITUACAO='Finalizado' WHERE ID=" . $index["ID"]);

	mysqli_query($phpmyadmin, "INSERT INTO AVAL_COMENTARIO(AVAL_INDICE_ID, AVAL_PERGUNTA_COM_ID, COMENTARIO) VALUES(" . $index["ID"] . ", (SELECT ID FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=2 AND SITUACAO='Ativo'),'" . $comentario . "')");

	echo "<script>alert('Avaliação finalizada com sucesso'); window.location.href='home.php'; </script>";
}
?>