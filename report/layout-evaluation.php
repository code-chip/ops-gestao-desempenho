<?php 
require('../connection.php');

$query = "SELECT AI.USUARIO_ID, U.NOME, UG.NOME AS LIDER, C.NOME AS CARGO,
TIMESTAMPDIFF(MONTH,U.EFETIVACAO,AI.REGISTRO ) AS MESES, TIMESTAMPDIFF(YEAR,U.NASCIMENTO,AI.REGISTRO ) 
AS IDADE, AI.REGISTRO, 
(SELECT COUNT(1) FROM DESEMPENHO WHERE PRESENCA_ID = 3 AND USUARIO_ID =U.ID) AS FOLGA,
(SELECT COUNT(1) FROM DESEMPENHO WHERE PRESENCA_ID = 4 AND USUARIO_ID =U.ID) AS ATESTADO,
(SELECT COUNT(1) FROM DESEMPENHO WHERE PRESENCA_ID = 2 AND USUARIO_ID =U.ID) AS FALTA,
(SELECT COUNT(1) FROM PENALIDADE WHERE USUARIO_ID =U.ID) AS PENALIDADE,
(SELECT ROUND(MIN(DESEMPENHO),2) FROM DESEMPENHO WHERE USUARIO_ID=AI.USUARIO_ID ) AS MINIMO,
(SELECT ROUND(AVG(DESEMPENHO),2) FROM DESEMPENHO WHERE USUARIO_ID=AI.USUARIO_ID ) AS MEDIA,
(SELECT ROUND(MAX(DESEMPENHO),2) FROM DESEMPENHO WHERE USUARIO_ID=AI.USUARIO_ID ) AS MAXIMO,
(SELECT COUNT(1) FROM FEEDBACK WHERE REMETENTE_ID=AI.USUARIO_ID ) AS F_ENV,
(SELECT COUNT(1) FROM FEEDBACK WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS F_REC,
(SELECT COUNT(1) FROM SOLICITACAO WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS S_ENV,
(SELECT COUNT(1) FROM SOLICITACAO WHERE REMETENTE_ID =AI.USUARIO_ID ) AS S_REC,
(SELECT ROUND(AVG(FR.NOTA),2) FROM FEEDBACK INNER JOIN FEEDBACK_RESPOSTA FR ON FR.ID=COMPORTAMENTAL WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS F_COM,
(SELECT ROUND(AVG(FR.NOTA),2) FROM FEEDBACK INNER JOIN FEEDBACK_RESPOSTA FR ON FR.ID=PROFISSIONAL WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS F_PRO,
(SELECT ROUND(AVG(FR.NOTA),2) FROM FEEDBACK INNER JOIN FEEDBACK_RESPOSTA FR ON FR.ID=DESEMPENHO WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS F_DES,
(SELECT IFNULL(ROUND(AVG(AR2.NOTA),2),0) FROM AVAL_REALIZADA AR
INNER JOIN AVAL_INDICE AIN ON AIN.ID=AR.AVAL_INDICE_ID
INNER JOIN AVAL_RESPOSTA AR2 ON AR2.ID=AR.AVAL_RESPOSTA_ID
INNER JOIN AVAL_PERGUNTA AP ON AP.ID=AR.AVAL_PERGUNTA_ID 
WHERE AIN.AVALIACAO_POR=AI.USUARIO_ID AND AP.AVAL_TIPO_PERGUNTA_ID =1) AS AUTO_AVAL_TEC,
(SELECT IFNULL(ROUND(AVG(AR2.NOTA),2),0) FROM AVAL_REALIZADA AR
INNER JOIN AVAL_INDICE AIN ON AIN.ID=AR.AVAL_INDICE_ID
INNER JOIN AVAL_RESPOSTA AR2 ON AR2.ID=AR.AVAL_RESPOSTA_ID
INNER JOIN AVAL_PERGUNTA AP ON AP.ID=AR.AVAL_PERGUNTA_ID 
WHERE AIN.AVALIACAO_POR=AI.USUARIO_ID AND AP.AVAL_TIPO_PERGUNTA_ID =2) AS AUTO_AVAL_COM,
(SELECT IFNULL(ROUND(AVG(AR2.NOTA),2),0) FROM AVAL_REALIZADA AR
INNER JOIN AVAL_INDICE AI ON AI.ID=AR.AVAL_INDICE_ID
INNER JOIN AVAL_RESPOSTA AR2 ON AR2.ID=AR.AVAL_RESPOSTA_ID
INNER JOIN AVAL_PERGUNTA AP ON AP.ID=AR.AVAL_PERGUNTA_ID 
WHERE AI.AVALIACAO_POR<>AI.USUARIO_ID AND AP.AVAL_TIPO_PERGUNTA_ID =1) AS LIDER_AVAL_TEC,
(SELECT IFNULL(ROUND(AVG(AR2.NOTA),2),0) FROM AVAL_REALIZADA AR
INNER JOIN AVAL_INDICE AI ON AI.ID=AR.AVAL_INDICE_ID
INNER JOIN AVAL_RESPOSTA AR2 ON AR2.ID=AR.AVAL_RESPOSTA_ID
INNER JOIN AVAL_PERGUNTA AP ON AP.ID=AR.AVAL_PERGUNTA_ID 
WHERE AI.AVALIACAO_POR<>AI.USUARIO_ID AND AP.AVAL_TIPO_PERGUNTA_ID =2) AS LIDER_AVAL_COM,
(SELECT COMENTARIO FROM AVAL_COMENTARIO AC INNER JOIN AVAL_PERGUNTA_COM APC ON APC.ID=AC.AVAL_PERGUNTA_COM_ID 
WHERE AC.AVAL_INDICE_ID =AI.ID AND APC.AVAL_TIPO_ID =1) AS AUTO_COMEN,
(SELECT COMENTARIO FROM AVAL_COMENTARIO AC INNER JOIN AVAL_PERGUNTA_COM APC ON APC.ID=AC.AVAL_PERGUNTA_COM_ID 
WHERE AC.AVAL_INDICE_ID =AI.ID AND APC.AVAL_TIPO_ID =2) AS LIDER_COMEN
FROM AVAL_INDICE AI
INNER JOIN USUARIO U ON U.ID = AI.USUARIO_ID
INNER JOIN USUARIO UG ON UG.ID = U.GESTOR_ID
INNER JOIN CARGO C ON C.ID = U.CARGO_ID 
WHERE AI.SITUACAO = 'Finalizado' AND AI.AVALIACAO_POR = U.ID;";

$cnx = mysqli_query($phpmyadmin, $query);
$x = 1;
while ($data = $cnx->fetch_array()) {
	$avgFeed = ($data["F_COM"] + $data["F_PRO"] + $data["F_DES"])/3;
	
	if ($avgFeed > 0) {
		$leaderGeneral = ($data["LIDER_AVAL_TEC"]+$data["LIDER_AVAL_COM"]+$avgFeed)/3;
		$autoGeneral = ($data["AUTO_AVAL_TEC"]+$data["AUTO_AVAL_COM"]+$avgFeed)/3;
	} else {
		$leaderGeneral = ($data["LIDER_AVAL_TEC"]+$data["LIDER_AVAL_COM"])/2;
		$autoGeneral = ($data["AUTO_AVAL_TEC"]+$data["AUTO_AVAL_COM"])/2;
	}	
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<link rel="stylesheet" href="../css/bulma.min.css"/>
	<link rel="stylesheet" href="../css/evaluation.css"/>
</head>
<body>
	
<page size="A4">
	<table class="table is-bordered pricing__table is-fullwidth borda">
		<tr class="black">
			<h2><td class="white-td tx" colspan="2"><b><center>( evino )</center></b></td></h2>
		</tr>
		<tr class="black">
			<td class="white-td" colspan="2"><b><center>Avaliação de Desempenho</center></b></td>
		</tr>
		<tr>
			<td colspan="2"><b>Colaborador:</b><?php echo $data["NOME"]; ?> <b>Líder: </b><?php echo $data["LIDER"]; ?></td>
		</tr>
	</table>
		<br>
	<table class="table is-bordered pricing__table is-fullwidth borda">	
		<tr class="red" >
			<td class="white-td"><b>Cargo</b></td>
			<td class="white-td"><b>Tempo de casa</b></td>
			<td class="white-td"><b>Idade</b></td>
		<tr>
			<td><?php echo $data["CARGO"];?></td>
			<td><?php echo $data["MESES"]; ?> meses</td>
			<td><?php echo $data["IDADE"]; ?> anos</td>
		</tr>
		
	</table>
	<table class="table is-bordered pricing__table is-fullwidth borda">	
		<tr>
			<td><b>Folga's</b></td>
			<td><b>Atestado's</b></td>
			<td><b>Falta's</b></td>
			<td><b>Penalidade's</b></td>
		</tr>
		<tr>
			<td><?php echo $data["FOLGA"]; ?></td>
			<td><?php echo $data["ATESTADO"]; ?></td>
			<td><?php echo $data["FALTA"]; ?></td>
			<td><?php echo $data["PENALIDADE"]; ?></td>
		</tr>
	</table>
	<br>
	<table class="table is-bordered pricing__table is-fullwidth borda">
		<tr class="grey"><td colspan="3"><b><center>Desempenho</center></b></td></tr>	
		<tr>
			<td><b>Mínimo</b></td>
			<td><b>Média</b></td>
			<td><b>Máximo</b></td>
		</tr>
		<tr>
			<td><?php echo $data["MINIMO"]; ?></td>
			<td><?php echo $data["MEDIA"]; ?></td>
			<td><?php echo $data["MAXIMO"]; ?></td>
		</tr>
		
	</table>
	<table class="table is-bordered pricing__table is-fullwidth borda">
		<tr class="grey">
			<td colspan="2"><b><center>Feedback</center></b></td>
			<td colspan="2"><b><center>Solicitado</center></b></td>
		</tr>	
		<tr>
			<td><b>Enviados</b></td>
			<td><b>Recebidos</b></td>
			<td><b>Enviados</b></td>
			<td><b>Recebidos</b></td>
		</tr>
		<tr>
			<td><?php echo $data["F_ENV"]; ?></td>
			<td><?php echo $data["F_REC"]; ?></td>
			<td><?php echo $data["S_ENV"]; ?></td>
			<td><?php echo $data["S_REC"]; ?></td>
		</tr>
		
	</table>
	<table class="table is-bordered pricing__table is-fullwidth borda">
		<tr class="grey"><td colspan="3"><b><center>Pilares Feedback</center></b></td></tr>	
		<tr>
			<td><b>Comportamental</b></td>
			<td><b>Profissional</b></td>
			<td><b>Desempenho</b></td>
		</tr>
		<tr>
			<td><?php echo $data["F_COM"]; ?></td>
			<td><?php echo $data["F_PRO"]; ?></td>
			<td><?php echo $data["F_DES"]; ?></td>
		</tr>
		
	</table>	
		<br>
	<table class="table is-bordered pricing__table is-fullwidth borda">	
		<tr class="grey" >
			<td><b>Avaliação</b></td>
			<td><b>Avaliação Técnica</b></td>
			<td><b>Avaliação Comportamental</b></td>
			<td><b>Feedback</b></td>
			<td><b>Avaliação Geral</b></td>
		</tr>
		<tr class="center">
			<td><b>Líder</b></td>
			<td><?php echo $data["LIDER_AVAL_TEC"]; ?></td>
			<td><?php echo $data["LIDER_AVAL_COM"]; ?></td>
			<td rowspan="2"><?php echo $avgFeed; ?></td>
			<td><?php echo round($leaderGeneral,2); ?></td>
		</tr>
		<tr>
			<td><b>Auto</b></td>
			<td><?php echo $data["AUTO_AVAL_TEC"]; ?></td>
			<td><?php echo $data["AUTO_AVAL_COM"]; ?></td>
			<td><?php echo round($autoGeneral,2); ?></td>
		</tr>	
	</table>
	<br>
	<table class="table is-bordered pricing__table is-fullwidth borda">	
		<tr class="red">
			<td class="white-td"><b><center>Comentário do Colaborador</center></b></td>
		</tr>
		<tr>
			<td><?php echo $data["AUTO_COMEN"]; ?></td>
		</tr>
		<tr class="red">
			<td class="white-td"><b><center>Comentário do Líder</center></b></td>
		</tr>
		<tr>
			<td><?php echo $data["LIDER_COMEN"]; ?></td>
		</tr>	
	</table>
</page>

</body>	
</html><?php
	if($x < sizeof($data)){
		echo "<div></div>";
	}
$x++;
}