<?php
$menuFeedback="is-active";
include('menu.php');
$data=date('Y-m-d');
$info="SELECT C.NOME AS CARGO FROM USUARIO U JOIN CARGO C ON C.ID=U.CARGO_ID WHERE U.ID=".$_SESSION["userId"];
$cx=mysqli_query($phpmyadmin, $info);
$cargo=$cx->fetch_array();
//CHECK SE JÁ HOUVE ALGUMA PERGUNTA RESPONDIDA;
$checkInd="SELECT ID, SITUACAO FROM AVAL_INDICE WHERE USUARIO_ID=".$_SESSION["userId"]." AND REGISTRO='".$data."' AND SITUACAO<>'Finalizado';";
$cy=mysqli_query($phpmyadmin, $checkInd);
$indice=$cy->fetch_array();
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
	$getPergunta="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=1 AND CARGO_ID=".$_SESSION["cargo"]." ORDER BY ORDEM;";//VERIFICA SE HÁ PERGUNTA P/ CARGO DO USUÁRIO.
	$cnx=mysqli_query($phpmyadmin, $getPergunta);
	while ($pergunta=$cnx->fetch_array()):{ $questao="questao".$y; $idPergunta[$y-1]=$pergunta["ID"];
		if(mysqli_num_rows($cy)>0){
			$verifResposta="SELECT AVAL_RESPOSTA_ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$indice["ID"]." AND AVAL_PERGUNTA_ID=".$idPergunta[$y-1].";";
			$cnx2=mysqli_query($phpmyadmin, $verifResposta);
			$houveResposta=true;
			$getRes=$cnx2->fetch_array();
			$getIdResposta=$getRes["AVAL_RESPOSTA_ID"];
			$selecao="CHECKED";
		}
		else{
			$selecao=null;
			$houveResposta=false;
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
<?php $y++;}endwhile;?>	<!--PERGUNTA COMPORTAMENTAL-->
	<div class="box">Comportamentais</div><?php
	$getPergunta="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=2 AND CARGO_ID=".$_SESSION["cargo"]." ORDER BY ORDEM;";
	$cnx=mysqli_query($phpmyadmin, $getPergunta);
	while ($pergunta=$cnx->fetch_array()):{ $questao="questao".$y; $idPergunta[$y-1]=$pergunta["ID"];		
		if(mysqli_num_rows($cy)>0){
			//CHECK SE A PERGUNTA FOI RESPONDIDA;
			$verifResposta="SELECT AVAL_RESPOSTA_ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$indice["ID"]." AND AVAL_PERGUNTA_ID=".$idPergunta[$y-1].";";
		    $cnx2=mysqli_query($phpmyadmin, $verifResposta);
			$houveResposta=true;
			$getRes=$cnx2->fetch_array();
			$getIdResposta=$getRes["AVAL_RESPOSTA_ID"];
			$selecao="CHECKED";
		}
		else{
			$selecao=null;
			$houveResposta=false;
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
	$getPerComentario="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=1 AND SITUACAO='Ativo'";
	$cnx7=mysqli_query($phpmyadmin, $getPerComentario);
	$getComentario=$cnx7->fetch_array();
	if($houveResposta==true){
		$getResComentario="SELECT COMENTARIO FROM AVAL_COMENTARIO WHERE AVAL_PERGUNTA_COM_ID=".$getComentario["ID"]." AND AVAL_INDICE_ID=".$indice["ID"].";";
		$cnx8=mysqli_query($phpmyadmin, $getResComentario);
		$getCom=$cnx8->fetch_array();
	}
?>
	<div class="box">	
		<div class="field">
		  	<label class="label"><?php echo $getComentario["PERGUNTA"];?></label>
		  	<div class="control">
		    	<textarea name="comentario" class="textarea" placeholder="Sua resposta" maxlength="500"><?php echo $getCom["COMENTARIO"];?></textarea>
		  	</div>
		</div>
		<div class="field is-grouped">
		  	<div class="control">
		    	<a href="home.php"><button class="button is-link">Cancelar</button></a>
		  	</div>
		  	<div class="control">
		    	<input type="button" name="proxima" class="button is-link is-light" value="Próxima" onclick="window.location.href='feedback-technical-evaluation.php'">
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
	if(mysqli_num_rows($cy)==0){
		$upInd="INSERT INTO AVAL_INDICE(USUARIO_ID,REGISTRO,SITUACAO) VALUES(".$_SESSION["userId"].",'".$data."','Iniciado')";
		mysqli_query($phpmyadmin, $upInd);
		//SALVA CHAVE DO INDICE.
		$checkInd="SELECT ID FROM AVAL_INDICE WHERE USUARIO_ID=".$_SESSION["userId"]." AND REGISTRO='".$data."' AND SITUACAO<>'Finalizado';";
		$cnx5=mysqli_query($phpmyadmin, $checkInd);
		$indice=$cnx5->fetch_array();
		$idInd=$indice["ID"];
	}
	else{//SALVA CHAVE DO INDICE.
		$idInd=$indice["ID"];
	}	
	if($houveResposta==true){//SE JÁ HOUVE RESPOSTA, ATUALIZA.	
		for($i=0 ;$i<sizeof($resposta)-1;$i++){//PERCORRE AS QUESTÕES.
			$verifResposta="SELECT ID FROM AVAL_REALIZADA WHERE AVAL_INDICE_ID=".$idInd." AND AVAL_PERGUNTA_ID=".$idPergunta[$i].";";	
			$cnx4=mysqli_query($phpmyadmin, $verifResposta);
			if(mysqli_num_rows($cnx4)>0){
				$getRes=$cnx4->fetch_array();
				$atualiza="UPDATE AVAL_REALIZADA SET AVAL_RESPOSTA_ID=".$resposta[$i]." WHERE ID=".$getRes["ID"].";";
				mysqli_query($phpmyadmin, $atualiza);
			}
		}					
	}
	else{
		for($i=0 ;$i<sizeof($resposta)-1;$i++){//PERCORRE PELAS QUESTÕES.			
			$salvar="INSERT INTO AVAL_REALIZADA(AVAL_INDICE_ID, AVAL_PERGUNTA_ID, AVAL_RESPOSTA_ID) VALUES(".$idInd.", ".$idPergunta[$i].",".$resposta[$i].");";
			mysqli_query($phpmyadmin, $salvar);
		}
	}//VERIFICAÇÃO DO COMENTÁRIO.
	$checkComentario="SELECT ID FROM AVAL_COMENTARIO WHERE AVAL_PERGUNTA_COM_ID=(SELECT ID FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=1 AND SITUACAO='Ativo') AND AVAL_INDICE_ID=".$idInd;
	$cnx6=mysqli_query($phpmyadmin, $checkComentario);
	if(mysqli_num_rows($cnx6)==0 && $comentario!=null){
		$insCom="INSERT INTO AVAL_COMENTARIO(AVAL_INDICE_ID, AVAL_PERGUNTA_COM_ID, COMENTARIO) VALUES(".$idInd.", (SELECT ID FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=1 AND SITUACAO='Ativo'),'".$comentario."')";
		mysqli_query($phpmyadmin, $insCom);
		$houveComentario=true;
	}
	else if(mysqli_num_rows($cnx6)==1 && $comentario!=null){
		$idComentario=$cnx6->fetch_array();
		$insCom="UPDATE AVAL_COMENTARIO SET COMENTARIO='".$comentario."' WHERE ID=".$idComentario["ID"];
		mysqli_query($phpmyadmin, $insCom);
	}
	$respostaNula=$respostaNula-1;
	if($respostaNula>0){?>
		<script type="text/javascript">
			alert('Atenção todas respostas são obrigatórias!');
			window.location.href=window.location.href;
		</script><?php	
	}
	else if($respostaNula==0 && $comentario==null){?>
		<script type="text/javascript">
			alert('Preenchimento do comentário é obrigatório!');
			window.location.href=window.location.href;
		</script><?php
	}
	else{
		if($indice["SITUACAO"]!="Lider"){
			$upInd="UPDATE AVAL_INDICE SET SITUACAO='Auto' WHERE ID=".$idInd;
			mysqli_query($phpmyadmin, $upInd);
		}
		?><script type="text/javascript">
			window.location.href="feedback-technical-evaluation.php";
		</script><?php	
	}
}
?>