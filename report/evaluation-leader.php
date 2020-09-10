<?php 

require('../connection.php');
$yearMonth = $_GET['filter'];

$r = mysqli_query($phpmyadmin, "SELECT ROUND(AVG(D.DESEMPENHO),2) AS MEDIA, D.USUARIO_ID FROM DESEMPENHO D INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID WHERE U.SITUACAO<>'Desligado' AND ANO_MES >=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES <='$yearMonth' GROUP BY 2 ORDER BY 1 DESC;");

$positions = mysqli_num_rows($r);

$i = 0;
while ($list = $r->fetch_array()) {
	$ranking[$i] = $list["USUARIO_ID"];
	$i++;
}

$query = "SELECT AI.USUARIO_ID, U.NOME, UG.NOME AS LIDER, C.NOME AS CARGO,
TIMESTAMPDIFF(MONTH,U.EFETIVACAO,AI.REGISTRO ) AS MESES, TIMESTAMPDIFF(YEAR,U.NASCIMENTO,AI.REGISTRO ) 
AS IDADE, AI.REGISTRO, 
(SELECT COUNT(1) FROM DESEMPENHO WHERE PRESENCA_ID = 3 AND USUARIO_ID =U.ID AND ANO_MES >=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES <='$yearMonth') AS FOLGA,
(SELECT COUNT(1) FROM DESEMPENHO WHERE PRESENCA_ID = 4 AND USUARIO_ID =U.ID AND ANO_MES >=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES <='$yearMonth') AS ATESTADO,
(SELECT COUNT(1) FROM DESEMPENHO WHERE PRESENCA_ID = 2 AND USUARIO_ID =U.ID AND ANO_MES >=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES <='$yearMonth') AS FALTA,
(SELECT COUNT(1) FROM PENALIDADE WHERE USUARIO_ID =U.ID AND ANO_MES >=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES <='$yearMonth') AS PENALIDADE,
(SELECT ROUND(MIN(DESEMPENHO),2) FROM DESEMPENHO WHERE USUARIO_ID=AI.USUARIO_ID AND DESEMPENHO>0 AND ANO_MES >=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES <='$yearMonth') AS MINIMO,
(SELECT ROUND(AVG(DESEMPENHO),2) FROM DESEMPENHO WHERE USUARIO_ID=AI.USUARIO_ID AND PRESENCA_ID NOT IN(3,5) AND ANO_MES >=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES <='$yearMonth') AS MEDIA,
(SELECT ROUND(MAX(DESEMPENHO),2) FROM DESEMPENHO WHERE USUARIO_ID=AI.USUARIO_ID AND ANO_MES >=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES <='$yearMonth') AS MAXIMO,
(SELECT COUNT(1) FROM FEEDBACK WHERE REMETENTE_ID=AI.USUARIO_ID ) AS F_ENV,
(SELECT COUNT(1) FROM FEEDBACK WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS F_REC,
(SELECT COUNT(1) FROM SOLICITACAO WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS S_ENV,
(SELECT COUNT(1) FROM SOLICITACAO WHERE REMETENTE_ID =AI.USUARIO_ID ) AS S_REC,
(SELECT IFNULL(ROUND(AVG(FR.NOTA),2),0) FROM FEEDBACK INNER JOIN FEEDBACK_RESPOSTA FR ON FR.ID=COMPORTAMENTAL WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS F_COM,
(SELECT IFNULL(ROUND(AVG(FR.NOTA),2),0) FROM FEEDBACK INNER JOIN FEEDBACK_RESPOSTA FR ON FR.ID=PROFISSIONAL WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS F_PRO,
(SELECT IFNULL(ROUND(AVG(FR.NOTA),2),0) FROM FEEDBACK INNER JOIN FEEDBACK_RESPOSTA FR ON FR.ID=DESEMPENHO WHERE DESTINATARIO_ID =AI.USUARIO_ID ) AS F_DES,
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
INNER JOIN AVAL_INDICE AII ON AII.ID=AR.AVAL_INDICE_ID
INNER JOIN AVAL_RESPOSTA AR2 ON AR2.ID=AR.AVAL_RESPOSTA_ID
INNER JOIN AVAL_PERGUNTA AP ON AP.ID=AR.AVAL_PERGUNTA_ID 
WHERE AII.USUARIO_ID =AI.USUARIO_ID AND AII.AVALIACAO_POR<>AI.USUARIO_ID  AND AP.AVAL_TIPO_PERGUNTA_ID =1) AS LIDER_AVAL_TEC,
(SELECT IFNULL(ROUND(AVG(AR2.NOTA),2),0) FROM AVAL_REALIZADA AR
INNER JOIN AVAL_INDICE AII ON AII.ID=AR.AVAL_INDICE_ID
INNER JOIN AVAL_RESPOSTA AR2 ON AR2.ID=AR.AVAL_RESPOSTA_ID
INNER JOIN AVAL_PERGUNTA AP ON AP.ID=AR.AVAL_PERGUNTA_ID 
WHERE AII.USUARIO_ID =AI.USUARIO_ID AND AII.AVALIACAO_POR<>AI.USUARIO_ID AND AP.AVAL_TIPO_PERGUNTA_ID =2) AS LIDER_AVAL_COM,
(SELECT COMENTARIO FROM AVAL_COMENTARIO AC INNER JOIN AVAL_PERGUNTA_COM APC ON APC.ID=AC.AVAL_PERGUNTA_COM_ID 
WHERE AC.AVAL_INDICE_ID =AI.ID AND APC.AVAL_TIPO_ID =1) AS AUTO_COMEN,
(SELECT COMENTARIO FROM AVAL_COMENTARIO AC INNER JOIN AVAL_PERGUNTA_COM APC ON APC.ID=AC.AVAL_PERGUNTA_COM_ID 
WHERE AC.AVAL_INDICE_ID =AI.ID AND APC.AVAL_TIPO_ID =2) AS LIDER_COMEN
FROM AVAL_INDICE AI
INNER JOIN USUARIO U ON U.ID = AI.USUARIO_ID
INNER JOIN USUARIO UG ON UG.ID = U.GESTOR_ID
INNER JOIN CARGO C ON C.ID = U.CARGO_ID  
WHERE AI.SITUACAO = 'Finalizado' AND AI.AVALIACAO_POR = U.ID AND U.CARGO_ID=6 AND AI.ANO_MES='$yearMonth';";

$cnx = mysqli_query($phpmyadmin, $query);
$reports = mysqli_num_rows($cnx);
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

	$position = $positions;//Percorrer vetor p/ encontrar a posição entre os demais.
	$o = 0;
	
	while ($o < $positions) {
		if ($ranking[$o] == $data["USUARIO_ID"]) {
			$position = $o+1;
			break;
		}
		$o++;
	}

	$cnx2 = mysqli_query($phpmyadmin,"SELECT ATIVIDADE_ID, A.NOME, COUNT(ATIVIDADE_ID) AS VEZES FROM DESEMPENHO D INNER JOIN ATIVIDADE A ON A.ID = D.ATIVIDADE_ID WHERE ANO_MES >= DATE_SUB('".$data["REGISTRO"]."', INTERVAL 6 MONTH) AND ANO_MES <= '".$data["REGISTRO"]."' AND USUARIO_ID = ".$data["USUARIO_ID"]." GROUP BY ATIVIDADE_ID" );
	$i = 0;
	
	$occurrence = "t:100";
	$activity = "Sem registro";
	
	while ($dash = $cnx2->fetch_array()) {
		if ($i == 0 ) { 
			$occurrence ="t:".$dash["VEZES"];
			$activity ="".$dash["NOME"];
		} else {
			$occurrence .=",".$dash["VEZES"];
			$activity .="|".$dash["NOME"];
		}
		$i++;
	}

	$b1 = mysqli_query($phpmyadmin,"SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, ANO_MES, DATE_FORMAT(REGISTRO,'%b') AS MES FROM DESEMPENHO WHERE USUARIO_ID = ".$data["USUARIO_ID"]." AND ANO_MES>=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES<='$yearMonth' GROUP BY 2 ORDER BY 2 LIMIT 6;" );
	$i = 0;

	$b1_avg = "t:0,0,0,0,0,0";
	$b1_month = "nul|nul|nul|nul|nul|nul";
	
	while ($b1_dash = $b1->fetch_array()) {
		if ($i == 0 ) { 
			$b1_avg ="t:".$b1_dash["MEDIA"];
			$b1_month ="".$b1_dash["MES"];
		} else {
			$b1_avg .=",".$b1_dash["MEDIA"];
			$b1_month .="|".$b1_dash["MES"];
		}
		$i++;
	}

	$c1 = mysqli_query($phpmyadmin, "SELECT A.ACESSOS, A.MES, A.ANO_MES FROM (SELECT SUM(ACESSO) AS ACESSOS, DATE_FORMAT(ULTIMO_LOGIN , '%b') AS MES, DATE_FORMAT(ULTIMO_LOGIN , '%Y-%m') AS ANO_MES FROM ACESSO 
WHERE USUARIO_ID = ".$data["USUARIO_ID"]." AND DATE_FORMAT(ULTIMO_LOGIN , '%Y-%m')<='".$yearMonth."'
GROUP BY ANO_MES ORDER BY ANO_MES DESC LIMIT 6) AS A ORDER BY 3;");
	
  	$i = 0;
	while ($c1_dash = $c1->fetch_array()) {
		if ($i == 0 ) { 
			$c1_access ="t:".$c1_dash["ACESSOS"];
			$c1_month ="".$c1_dash["MES"];
		} else {
			$c1_access .=",".$c1_dash["ACESSOS"];
			$c1_month .="|".$c1_dash["MES"];
		}
		$i++;
	}

	$a2 = mysqli_query($phpmyadmin, "SELECT A.MEDIA, A.REGISTRO FROM (SELECT ROUND(AVG(D.DESEMPENHO),2) AS MEDIA, REGISTRO FROM DESEMPENHO D 
INNER JOIN USUARIO U ON U.ID=D.USUARIO_ID 
WHERE U.GESTOR_ID=99 AND PRESENCA_ID NOT IN(3,5) GROUP BY REGISTRO ORDER BY REGISTRO DESC LIMIT 264) AS A
ORDER BY A.REGISTRO;");
	$a2_activitys = mysqli_num_rows($a2);
	
  	$i = 0;
	while ($a2_dash = $a2->fetch_array()) {
		if ($i == 0 ) { 
			$a2_avg ="t:".$a2_dash["MEDIA"];
		} else {
			$a2_avg .=",".$a2_dash["MEDIA"];
		}
		$i++;
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
			<h2><td class="white-td tx" colspan="3"><b><center>( evino )</center></b></td></h2>
		</tr>
		<tr class="black">
			<td class="white-td" colspan="3"><b><center>Avaliação de Desempenho Semestral</center></b></td>
		</tr>
		<tr>
			<td ><b>Líder: </b><?php echo $data["NOME"]; ?></td>
			<td ><b>Supervisor: </b><?php echo $data["LIDER"]; ?></td>
			<td ><b>Data: </b><?php echo $data["REGISTRO"]; ?></td>
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
			<?php 
		echo "<img src='http://chart.apis.google.com/chart?chs=300x150&cht=p&chd=".$occurrence."&chl=".$activity."&chtt=Distribuição+das+atividades' width='33%' height='30%'>";
	
		echo "<img src='http://chart.apis.google.com/chart?chs=300x150&cht=bvg&chxt=x,y&chm=N,000000,0,-1,11&chd=".$b1_avg."&chl=".$b1_month."&chds=a&chtt=Desempenho+no+mês' width='33%' height='30%'>";

		echo "<img src='http://chart.apis.google.com/chart?chs=300x150&cht=lc&chxt=x,y&chm=N,000000,0,-1,11&chd=".$c1_access."&chl=".$c1_month."&chds=a&chtt=Acessos+no+sistema' width='33%' height='30%'>"; 
	?>
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
	<table class="table is-bordered pricing__table is-fullwidth borda">
		<tr class="grey"><td colspan="4"><b><center>Desempenho</center></b></td></tr>	
		<tr>
			<td><b>Mínimo</b></td>
			<td><b>Média</b></td>
			<td><b>Máximo</b></td>
			<td><b>Posição</b></td>
		</tr>
		<tr>
			<td><?php echo $data["MINIMO"]; ?></td>
			<td><?php echo $data["MEDIA"]; ?></td>
			<td><?php echo $data["MAXIMO"]; ?></td>
			<td><?php echo $position."/".$positions; ?></td>
		</tr>
		
	</table>
	<img src="http://chart.apis.google.com/chart?chs=700x150&cht=ls&chxt=x,y&chd=<?php echo $a2_avg?>&chl=&chds=a&chtt=Performance+da+equipe+liderada+nos+últimos+12+meses+-+média+diaria+de+<?php echo $a2_activitys?>+dias" width="100%" height="30%">
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
		<tr class="grey"><td colspan="4"><b><center>Pilares Feedback</center></b></td></tr>	
		<tr>
			<td><b>Comportamental</b></td>
			<td><b>Profissional</b></td>
			<td><b>Desempenho</b></td>
			<td><b>Geral</b></td>
		</tr>
		<tr>
			<td><?php echo $data["F_COM"]; ?></td>
			<td><?php echo $data["F_PRO"]; ?></td>
			<td><?php echo $data["F_DES"]; ?></td>
			<td><?php echo $avgFeed; ?></td>
		</tr>
	</table>	
	<br>	
	<table class="table is-bordered pricing__table is-fullwidth borda">	
		<tr class="grey" >
			<td><b>Avaliação</b></td>
			<td><b>Avaliação Técnica</b></td>
			<td><b>Avaliação Comportamental</b></td>
			<td><b>Avaliação Geral</b></td>
		</tr>
		<tr class="center">
			<td><b>Líder</b></td>
			<td><?php echo $data["LIDER_AVAL_TEC"]; ?></td>
			<td><?php echo $data["LIDER_AVAL_COM"]; ?></td>
			<td><?php echo round($leaderGeneral,2); ?></td>
		</tr>
		<tr>
			<td><b>Auto</b></td>
			<td><?php echo $data["AUTO_AVAL_TEC"]; ?></td>
			<td><?php echo $data["AUTO_AVAL_COM"]; ?></td>
			<td><?php echo round($autoGeneral,2); ?></td>
		</tr>	
	</table>
	<?php 
	$cnx4 = mysqli_query($phpmyadmin, "SELECT AP.PERGUNTA, AR2.RESPOSTA, AR2.NOTA, (SELECT AR2.RESPOSTA FROM AVAL_INDICE AII 
INNER JOIN AVAL_REALIZADA AR ON AR.AVAL_INDICE_ID = AII.ID
INNER JOIN AVAL_RESPOSTA AR2 ON AR2.ID = AR.AVAL_RESPOSTA_ID
INNER JOIN AVAL_PERGUNTA APP ON APP.ID = AR.AVAL_PERGUNTA_ID 
WHERE AII.USUARIO_ID =AI.USUARIO_ID AND AII.AVALIACAO_POR <>AI.USUARIO_ID AND APP.ID= AP.ID) AS RESPOSTA_LIDER,
(SELECT AR2.NOTA FROM AVAL_INDICE AII 
INNER JOIN AVAL_REALIZADA AR ON AR.AVAL_INDICE_ID = AII.ID
INNER JOIN AVAL_RESPOSTA AR2 ON AR2.ID = AR.AVAL_RESPOSTA_ID
INNER JOIN AVAL_PERGUNTA APP ON APP.ID = AR.AVAL_PERGUNTA_ID 
WHERE AII.USUARIO_ID =AI.USUARIO_ID AND AII.AVALIACAO_POR <>AI.USUARIO_ID AND APP.ID= AP.ID) AS NOTA_LIDER
FROM AVAL_REALIZADA AR
INNER JOIN AVAL_PERGUNTA AP ON AP.ID=AR.AVAL_PERGUNTA_ID
INNER JOIN AVAL_RESPOSTA AR2 ON AR2.ID=AR.AVAL_RESPOSTA_ID
INNER JOIN AVAL_INDICE AI ON AI.ID=AR.AVAL_INDICE_ID
WHERE AI.USUARIO_ID = " . $data["USUARIO_ID"].  " AND AI.AVALIACAO_POR = " . $data["USUARIO_ID"].  " AND ANO_MES='".$yearMonth."' AND  AP.AVAL_TIPO_PERGUNTA_ID IN(1,2) ORDER BY AI.USUARIO_ID;");
	
	$p = 0;
	$count = 1;
	while ($question = $cnx4->fetch_array()) {
		$a3_question[$p] = $question["PERGUNTA"];
		$a3_answer[$p] = $question["RESPOSTA"];
		$a3_answer_leader[$p] = $question["RESPOSTA_LIDER"];
		
		if ($p == 0 ) { 
			$a3_note_leader = "t:".$question["NOTA_LIDER"];
			$a3_note = "|".$question["NOTA"];
			$a3_num = "1"; 
		} else {
			$a3_note_leader .= ",".$question["NOTA_LIDER"];
			$a3_note .= ",".$question["NOTA"];
			$a3_num .= "|".$count; 
		}
		$p++;
		$count++;
	}

	if ($a3_answer_leader[0] == "" || $a3_answer_leader[0] == null) {
		$a3_note_leader = "t:0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
	}

	echo "<img src='http://chart.apis.google.com/chart?chs=700x127&cht=ls&chxt=x,x,y,y&chd=".$a3_note_leader.$a3_note."&chco=0000FF,00FF00&chl=$a3_num&chxl=1:|Primeira+Pergunta|Última+Pergunta|3:|Desenvolver|Excelente&chdl=Líder|Auto&chds=a&chtt=Visão+geral+da+avaliação' width='100%' height='25%'>
	<div>
	<table class='table is-bordered pricing__table is-fullwidth borda'>";
	
		$y = 0;
		$count = 1;
		while ($y < sizeof($a3_question)) {
			echo "<tr class='blue'><td class='white-td' colspan='2'><b>" .$count.") ".$a3_question[$y]."</b></td></tr><br>";
			echo "<tr><td><b>" . $data["LIDER"] . "</b></td><td>" . $a3_answer_leader[$y] . "</td></tr><br>";
			echo "<tr><td><b>" . $data["NOME"] . "</b></td><td>" . $a3_answer[$y] . "</td></tr><br>";
			$y++;
			$count++;
		}
	
	echo "</table>";	

?>	
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
	</div>
    </page>
</body>	
</html>
<?php
	
	if ($x < $reports) {
		echo "<div></div>";
	}

	$x++;
}