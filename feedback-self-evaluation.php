<?php
$menuAtivo = 'feedback';
require('menu.php');

$data = date('Y-m');

$cx = mysqli_query($phpmyadmin, "SELECT C.ID AS ID, C.NOME AS CARGO FROM USUARIO U JOIN CARGO C ON C.ID=U.CARGO_ID WHERE U.ID = ".$_SESSION['user']);
$cargo = $cx->fetch_array();

//CHECK SE JÁ HOUVE ALGUMA PERGUNTA RESPONDIDA;
$cy = mysqli_query($phpmyadmin, "SELECT ID, SITUACAO FROM AVAL_INDICE WHERE USUARIO_ID = ".$_SESSION['user']." AND AVALIACAO_POR = " . $_SESSION['userId'] . " AND DATE_FORMAT(REGISTRO, '%Y-%m')='" . $data . "';");
$index = $cy->fetch_array();
$answer = mysqli_num_rows($cy);

if ($index["SITUACAO"] == 'Finalizado') {
	echo "<script>alert('Avaliação realizada, aguarde o próximo período'); window.location.href='home.php';</script>";

} else if ($_SESSION['userId'] == $_SESSION['user']) {
	if ($_SESSION['permissao'] == 2) {
		$button = 'Enviar';
		$situation = 'Finalizado';
		$redirect = "<script>alert('Avaliação realizada com sucesso!'); window.location.href='feedback-agree-evaluation.php'; </script>";
	} else {
		$button = 'Próxima';
		$situation = 'Iniciado';
		$redirect = "<script> window.location.href='feedback-technical-evaluation.php'; </script>";
	}
	

} else {
	$button = 'Enviar';
	$situation = 'Finalizado';
	$redirect = "<script>alert('Avaliação realizada com sucesso!'); window.location.href='feedback-agree-evaluation.php'; </script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Autoavaliação</title>
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
	<form id="form" action="feedback-self-evaluation.php" method="POST" onsubmit="return check()">
	<div class="box" style="margin-bottom: -30px; background-color: rgb(64,224,208)"></div>
	<div class="box">
		<div class="is-size-1-desktop"><strong>Avaliação de Desempenho - Operação ( evino )</strong></div>
	</div>
	<div class="box is-size-4-desktop has-text-white" style="margin-bottom: -30px; background-color: rgb(64,224,208);"><?php echo $cargo["CARGO"];?><br></div><br>
	<div class="box is-size-7-touch">
		<div><strong>Auto-avaliação</strong> <br>Aqui você deverá fazer  a sua auto avaliação sobre cada item abordado:</div>
	</div><!--FINAL PERGUNTA TÉCNICA-->
	<div class="box">Técnicas</div>
	<?php 

	$y = 1;		
	//VERIFICA SE HÁ PERGUNTA P/ CARGO DO USUÁRIO.
	$cnx = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID = 1 AND CARGO_ID = " . $cargo['ID'] . " ORDER BY ORDEM;");
	while ($pergunta=$cnx->fetch_array()){ 
		$questao = "questao".$y; 
		$idPergunta[$y-1] = $pergunta["ID"];
		
		if ($answer > 0) {
			$cnx2 = mysqli_query($phpmyadmin, "SELECT AVAL_RESPOSTA_ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$index["ID"]." AND AVAL_PERGUNTA_ID=".$idPergunta[$y-1].";");
			$houveResposta = true;
			$getRes = $cnx2->fetch_array();
			$getIdResposta = $getRes["AVAL_RESPOSTA_ID"];
			$selecao = "CHECKED";
		} else {
			$selecao = null;
			$houveResposta = false;
		}
		
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
	$getPergunta = "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID = 2 AND CARGO_ID = " . $cargo['ID'] . " ORDER BY ORDEM;";
	$cnx = mysqli_query($phpmyadmin, $getPergunta);
	
	while ($pergunta = $cnx->fetch_array()) { 
		$questao = "questao" . $y; $idPergunta[$y-1] = $pergunta["ID"];		
		
		if ($answer > 0) {
			//CHECK SE A PERGUNTA FOI RESPONDIDA;
			$verifResposta = "SELECT AVAL_RESPOSTA_ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$index["ID"]." AND AVAL_PERGUNTA_ID=".$idPergunta[$y-1].";";
		    $cnx2 = mysqli_query($phpmyadmin, $verifResposta);
			$houveResposta = true;
			$getRes = $cnx2->fetch_array();
			$getIdResposta = $getRes["AVAL_RESPOSTA_ID"];
			$selecao = "CHECKED";
		} else {
			$selecao = null;
			$houveResposta = false;
		}
		
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
	
	$cnx7 = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=1 AND SITUACAO='Ativo'");
	$getComentario = $cnx7->fetch_array();
	
	if ($houveResposta == true) {
		$cnx8 = mysqli_query($phpmyadmin, "SELECT COMENTARIO FROM AVAL_COMENTARIO WHERE AVAL_PERGUNTA_COM_ID = " . $getComentario["ID"] . " AND AVAL_INDICE_ID = " . $index["ID"] . ";");
		$getCom = $cnx8->fetch_array();
	}
	?>
	<div class="box">	
		<div class="field">
		  	<label class="label"><?php echo $getComentario["PERGUNTA"];?></label>
		  	<div class="control">
		    	<textarea name="comentario" id="comment" class="textarea" placeholder="Sua resposta" maxlength="710"><?php echo $getCom["COMENTARIO"];?></textarea>
		  	</div>
		</div>
		<div class="field is-grouped">
			<div class="control">
		    	<input type="submit" name="proxima" class="button is-link is-light" value="<?php echo $button;?>">
		  	</div>
		  	<div class="control">
		    	<a href="feedback-agree-evaluation.php" class="button is-link">Cancelar</a>
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
		$z++;			
	}//CONSULTA SE HÁ REGISTRO DE AVALIAÇÃO NESTE DIA.
	
	if ( $answer == 0) {//Criar o indice do registro
		mysqli_query($phpmyadmin, "INSERT INTO AVAL_INDICE(USUARIO_ID, AVALIACAO_POR, REGISTRO, SITUACAO) VALUES(" . $_SESSION['user'] . ", " . $_SESSION['userId'] . ",'" . date('Y-m-d') . "','" . $situation . "')");
		
		$cnx5 = mysqli_query($phpmyadmin, "SELECT ID FROM AVAL_INDICE WHERE USUARIO_ID = " . $_SESSION['user'] . " AND AVALIACAO_POR = " . $_SESSION['userId'] . " AND DATE_FORMAT(REGISTRO, '%Y-%m')='" . $data . "';");//SALVA CHAVE DO INDICE.
		$index = $cnx5->fetch_array();

		for ($i = 0 ;$i < sizeof($resposta) - 1; $i++) {//PERCORRE PELAS QUESTÕES.			
			mysqli_query($phpmyadmin, "INSERT INTO AVAL_REALIZADA(AVAL_INDICE_ID, AVAL_PERGUNTA_ID, AVAL_RESPOSTA_ID) VALUES(" . $index["ID"] . ", ".$idPergunta[$i].",".$resposta[$i].");");
		}

		mysqli_query($phpmyadmin, "INSERT INTO AVAL_COMENTARIO(AVAL_INDICE_ID, AVAL_PERGUNTA_COM_ID, COMENTARIO) VALUES(" . $index["ID"] . ", (SELECT ID FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=1 AND SITUACAO='Ativo'),'" . $comentario . "')");

		echo $redirect;

	} else {//SALVA CHAVE DO INDICE.
		for ($i = 0; $i < sizeof($resposta) - 1; $i++) {//PERCORRE AS QUESTÕES.
			$cnx4 = mysqli_query($phpmyadmin, "SELECT ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID = " . $index["ID"] . " AND AVAL_PERGUNTA_ID = " . $idPergunta[$i]);
			
			if (mysqli_num_rows($cnx4) > 0) {
				$getRes = $cnx4->fetch_array();
				mysqli_query($phpmyadmin, "UPDATE AVAL_REALIZADA SET AVAL_RESPOSTA_ID = " . $resposta[$i] . " WHERE ID = " .$getRes["ID"]);
			}
		}
		$cnx6 = mysqli_query($phpmyadmin, "SELECT ID FROM AVAL_COMENTARIO WHERE AVAL_PERGUNTA_COM_ID = (SELECT ID FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=1 AND SITUACAO = 'Ativo') AND AVAL_INDICE_ID = " . $index["ID"]);
		$idComment = $cnx6->fetch_array();

		mysqli_query($phpmyadmin, "UPDATE AVAL_COMENTARIO SET COMENTARIO = '" . $comentario . "' WHERE ID=" . $idComment["ID"]);
		echo "<script>alert('Respostas atualizadas!'); window.location.href ='feedback-technical-evaluation.php'; </script>";
	}

}
?>