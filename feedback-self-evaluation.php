<?php
$menuFeedback="is-active";
include('menu.php');
//$houveResposta[];
$info="SELECT C.NOME AS CARGO FROM USUARIO U JOIN CARGO C ON C.ID=U.CARGO_ID WHERE U.ID=".$_SESSION["userId"];
$cx=mysqli_query($phpmyadmin, $info);
$cargo=$cx->fetch_array();
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
	<form id="form" action="" method="POST">
	<div class="box" style="margin-bottom: -30px; background-color: rgb(64,224,208)"></div>
	<div class="box">
		<div class="is-size-1-desktop"><strong>Avaliação de Desempenho - Operação ( evino )</strong></div>
	</div>
	<div class="box is-size-4-desktop has-text-white" style="margin-bottom: -30px; background-color: rgb(64,224,208);"><?php echo $cargo["CARGO"];?><br></div><br>
	<div class="box is-size-7-touch">
		<div><strong>Auto-avaliação</strong> <br>Aqui você deverá fazer  a sua auto avaliação sobre cada item abordado:</div>
	</div><!--FINAL PERGUNTA TÉCNICA-->
	<div class="box">Técnicas</div><?php $y=1;	
	$getPergunta="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=1 AND CARGO_ID=1 ORDER BY ORDEM;";//VERIFICA SE HÁ PERGUNTA PARA CARGO DO USUÁRIO.
	$cnx=mysqli_query($phpmyadmin, $getPergunta);
	while ($pergunta=$cnx->fetch_array()):{ $questao="questao".$y; $idPergunta[$y-1]=$pergunta["ID"];
		//CHECK SE A PERGUNTA FOI RESPONDIDA;
		$checkInd="SELECT ID FROM AVAL_INDICE WHERE ID=".$_SESSION["userId"]." AND REGISTRO='".date('Y-m-d')."' AND SITUACAO<>'Finalizado';";
		$cnx5=mysqli_query($phpmyadmin, $checkInd);
		$indice=$cnx5->fetch_array();
		$verifResposta="SELECT AVAL_RESPOSTA_ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$indice["ID"]." AND AVAL_PERGUNTA_ID=".$idPergunta[$y-1]." AND REGISTRO='".date('Y-m-d')."';";
		$cnx2=mysqli_query($phpmyadmin, $verifResposta);
		if(mysqli_num_rows($cnx2)>0){
			$houveResposta[$y-1]=true;
			$getRes=$cnx2->fetch_array();
			$getIdResposta=$getRes["AVAL_RESPOSTA_ID"];
			$selecao="CHECKED";
		}
		else{
			$selecao=null;
			$houveResposta[$y-1]=false;
		}
		?>
	<div class="box">	
		<div class="field is-horizontal">
			<div class="text"><?php echo $pergunta["PERGUNTA"];?></div>				
		</div>
		<?php $getResposta="SELECT ID, RESPOSTA FROM AVAL_RESPOSTA WHERE SITUACAO='Ativo';";
		$x=0;
		$cnx3=mysqli_query($phpmyadmin, $getResposta);
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
<?php $y++;}endwhile;?>
	<!--PERGUNTA COMPORTAMENTAL-->
	<div class="box">Comportamentais</div><?php
	//$y=1;	
	$getPergunta="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=2 AND CARGO_ID=1 ORDER BY ORDEM;";
	$cnx=mysqli_query($phpmyadmin, $getPergunta);
	while ($pergunta=$cnx->fetch_array()):{ $questao="questao".$y; $idPergunta[$y-1]=$pergunta["ID"];
		//CHECK SE A PERGUNTA FOI RESPONDIDA;
		$verifResposta="SELECT AVAL_RESPOSTA_ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$indice["ID"]." AND AVAL_PERGUNTA_ID=".$idPergunta[$y-1]." AND REGISTRO='".date('Y-m-d')."';";
		$cnx2=mysqli_query($phpmyadmin, $verifResposta);
		if(mysqli_num_rows($cnx2)>0){
			$houveResposta[$y-1]=true;
			$getRes=$cnx2->fetch_array();
			$getIdResposta=$getRes["AVAL_RESPOSTA_ID"];
			$selecao="CHECKED";
		}
		else{
			$selecao=null;
			$houveResposta[$y-1]=false;
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
<?php $y++;}endwhile;?><!--FINAL PERGUNTA COMPORTAMENTAL-->
	<div class="box">	
		<div class="field">
		  	<label class="label">Comente os pontos positivos e pontos de melhorias mais relevantes: *</label>
		  	<div class="control">
		    	<textarea name="comentario" class="textarea" placeholder="Sua resposta" maxlength="500"></textarea>
		  	</div>
		</div>
		<div class="field is-grouped">
		  	<div class="control">
		    	<button class="button is-link">Cancelar</button>
		  	</div>
		  	<div class="control">
		    	<button class="button is-link is-light" name="proxima" type="submit">Próxima</button>
		  	</div>
		</div>
	</div>									
	</form>
	<script>
</script>
	</div>
	</section>	
</section>	
</body>
</html>
<?php 
if(isset($_POST['proxima'])){
	$comentario=$_POST["comentario"];
	$z=1; $respostaNula=0;
	while ($z <= $y) {//ARMAZENA AS RESPOSTAS NO VETOR.
		$resposta[$z-1]=$_POST["questao".$z];
		if($resposta[$z-1]==null){			
			$respostaNula++;
			$resposta[$z-1]=5;//ID REFERENTE AO TEXTO AGUARDANDO RESPOSTA.
		}
		$z++;			
	}//CONSULTA SE HÁ REGISTRO DE AVALIAÇÃO NESTE DIA.
	$checkInd="SELECT ID FROM AVAL_INDICE WHERE ID=".$_SESSION["userId"]." AND REGISTRO='".date('Y-m-d')."' AND SITUACAO<>'Finalizado';";
	$cnx5=mysqli_query($phpmyadmin, $checkInd);
	$indice=$cnx5->fetch_array();
	if(mysqli_num_rows($cnx5)==0){
		$upInd="INSERT INTO AVAL_INDICE(USUARIO_ID,REGISTRO,SITUACAO) VALUES(".$_SESSION["userId"].",'".date('Y-m-d')."','Iniciado')";
		mysqli_query($phpmyadmin, $upInd);
		//SALVA CHAVE DO INDICE.
		$checkInd="SELECT ID FROM AVAL_INDICE WHERE ID=".$_SESSION["userId"]." AND REGISTRO='".date('Y-m-d')."' AND SITUACAO<>'Finalizado';";
		$cnx5=mysqli_query($phpmyadmin, $checkInd);
		$indice=$cnx5->fetch_array();
		$idInd=$indice["ID"];
	}
	else{//SALVA CHAVE DO INDICE.
		$idInd=$indice["ID"];
	}	
	for($i=0 ;$i<sizeof($resposta);$i++){//PERCORRE PELAS QUESTÕES.
		if($houveResposta[$i]==true){//CHECK SE HÁ ALGUMA PERGUNTA RESPONDIDA.	
			$verifResposta="SELECT ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$idInd." AND AVAL_PERGUNTA_ID=".$idPergunta[$i]." AND REGISTRO='".date('Y-m-d')."';";	
			$cnx4=mysqli_query($phpmyadmin, $verifResposta);
			if(mysqli_num_rows($cnx4)==1){//CASO O USUÁRIO JÁ RESPONDEU ALGUMA PERGUNTA, ATUALIZA AS RESPOSTAS.			
				$getRes=$cnx4->fetch_array();
				$atualiza="UPDATE AVAL_REALIZADA SET AVAL_RESPOSTA_ID=".$resposta[$i]." WHERE ID=".$getRes["ID"].";";
			}
			else{
				$atualiza="INSERT INTO AVAL_REALIZADA(AVAL_INDICE_ID, AVAL_PERGUNTA_ID, AVAL_RESPOSTA_ID, REGISTRO) VALUES(".$idInd.", ".$idPergunta[$i].",".$resposta[$i].", '".date('Y-m-d')."');";
			}
			$cnx=mysqli_query($phpmyadmin, $atualiza);				
		}
		else{			
			//for($i=0 ;$i<sizeof($resposta);$i++){//INSERE NO BANCO OS ID'S DAS PERGUNTAS E RESPOSTAS.
			$salvar="INSERT INTO AVAL_REALIZADA(AVAL_INDICE_ID, AVAL_PERGUNTA_ID, AVAL_RESPOSTA_ID, REGISTRO) VALUES(".$idInd.", ".$idPergunta[$i].",".$resposta[$i].", '".date('Y-m-d')."');";
			echo $salvar;
			$cnx5=mysqli_query($phpmyadmin, $salvar);
		}
	}
	
	$respostaNula=$respostaNula-1;
	if($respostaNula>0){?>
		<script type="text/javascript">
			//alert('Atenção a respostas de todas perguntas são obrigatórias!');
			//window.location.href=window.location.href;
		</script><?php	
	}
	else{?>
		<script type="text/javascript">
			window.location.href="feedback-technical-evaluation.php";
		</script><?php	
	}
}
?>