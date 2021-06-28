<?php 

require('../connection.php');
//$yearMonth = $_GET['filter'];
$yearMonth ='2020-09';

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
(SELECT COMENTARIO FROM AVAL_COMENTARIO AC INNER JOIN AVAL_INDICE AII ON AII.ID=AC.AVAL_INDICE_ID 
WHERE AII.USUARIO_ID=AI.USUARIO_ID AND AII.AVALIACAO_POR=U.GESTOR_ID) AS LIDER_COMEN
FROM AVAL_INDICE AI
INNER JOIN USUARIO U ON U.ID = AI.USUARIO_ID
INNER JOIN USUARIO UG ON UG.ID = U.GESTOR_ID
INNER JOIN CARGO C ON C.ID = U.CARGO_ID  
WHERE AI.SITUACAO = 'Finalizado' AND AI.AVALIACAO_POR = U.ID AND AI.ANO_MES='$yearMonth';";

$cnx = mysqli_query($phpmyadmin, $query);
$reports = mysqli_num_rows($cnx);
$x = 1;
$v = 0;

while ($data = $cnx->fetch_array()) {
	$avgFeed[$v] = ($fCom[$v] + $fPro[$v] + $fDes[$v])/3;
	$userId[$v] = $data["USUARIO_ID"];
	$register[$v] = $data["REGISTRO"];
	$name[$v] = $data["NOME"];
	$leader[$v] = $data["LIDER"];
	$role[$v] = $data["CARGO"];
	$months[$v] = $data["MESES"];
	$age[$v] = $data["IDADE"];
	$dayOff[$v] = $data["IDADE"];
	$attestation[$v] = $data["ATESTADO"];
	$lack[$v] = $data["FALTA"];
	$penalty[$v] = $data["PENALIDADE"];
	$min[$v] = $data["MINIMO"];
	$avg[$v] = $data["MEDIA"];
	$max[$v] = $data["MAXIMO"];
	$fSend[$v] = $data["F_ENV"];
	$fRec[$v] = $data["F_REC"];
	$rSend[$v] = $data["S_ENV"];
	$rRec[$v] = $data["S_REC"];
	$fCom[$v] = $data["F_COM"];
	$fPro[$v] = $data["F_PRO"];
	$fDes[$v] = $data["F_DES"];
	$autoEvaTec[$v] = $data["AUTO_AVAL_TEC"];
	$autoEvaCom[$v] = $data["AUTO_AVAL_COM"];
	$leaderEvaTec[$v] = $data["LIDER_AVAL_TEC"];
	$leaderEvaCom[$v] = $data["LIDER_AVAL_COM"];
	$autoCom[$v] = $data["AUTO_COMEN"];
	$leaderCom[$v] = $data["LIDER_COMEN"];

	if ($avgFeed[$v] > 0) {
		$leaderGeneral[$v] = ($leaderEvaTec[$v] + $leaderEvaCom[$v] + $avgFeed) / 3;
		$autoGeneral[$v] = ($autoEvaTec+$autoEvaCom[$v] + $avgFeed) / 3;
	} else {
		$leaderGeneral[$v] = ($leaderEvaTec[$v] + $leaderEvaCom[$v]) / 2;
		$autoGeneral[$v] = ($autoEvaTec[$v] + $autoEvaCom[$v]) / 2;
	}

	$position = $positions;//Percorrer vetor p/ encontrar a posição entre os demais.
	$o = 0;
	
	while ($o < $positions) {
		if ($ranking[$o] == $userId[$v]) {
			$position = $o+1;
			break;
		}
		$o++;
	}

	$cnx2 = mysqli_query($phpmyadmin,"SELECT ATIVIDADE_ID, A.NOME, COUNT(ATIVIDADE_ID) AS VEZES FROM DESEMPENHO D INNER JOIN ATIVIDADE A ON A.ID = D.ATIVIDADE_ID WHERE ANO_MES >= DATE_SUB('".$register[$v]."', INTERVAL 6 MONTH) AND ANO_MES <= '".$register[$v]."' AND USUARIO_ID = ".$userId[$v]." GROUP BY ATIVIDADE_ID" );
	$i = 0;
	
	$occurrence[$v] = "t:100";
	$activity[$v] = "Sem registro";
	
	while ($dash = $cnx2->fetch_array()) {
		if ($i == 0 ) { 
			$occurrence[$v] ="t:".$dash["VEZES"];
			$activity[$v] ="".$dash["NOME"];
		} else {
			$occurrence[$v] .=",".$dash["VEZES"];
			$activity[$v] .="|".$dash["NOME"];
		}
		$i++;
	}

	$b1 = mysqli_query($phpmyadmin,"SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, ANO_MES, DATE_FORMAT(REGISTRO,'%b') AS MES FROM DESEMPENHO WHERE USUARIO_ID = ".$userId[$v]." AND ANO_MES>=DATE_SUB('$yearMonth-01', INTERVAL 6 MONTH) AND ANO_MES<='$yearMonth' GROUP BY 2 ORDER BY 2 LIMIT 6;" );
	$i = 0;

	$b1_avg[$v] = "t:0,0,0,0,0,0";
	$b1_month[$v] = "nul|nul|nul|nul|nul|nul";
	
	while ($b1_dash = $b1->fetch_array()) {
		if ($i == 0 ) { 
			$b1_avg[$v] ="t:".$b1_dash["MEDIA"];
			$b1_month[$v] ="".$b1_dash["MES"];
		} else {
			$b1_avg[$v] .=",".$b1_dash["MEDIA"];
			$b1_month[$v] .="|".$b1_dash["MES"];
		}
		$i++;
	}

	$c1 = mysqli_query($phpmyadmin, "SELECT A.ACESSOS, A.MES, A.ANO_MES FROM (SELECT SUM(ACESSO) AS ACESSOS, DATE_FORMAT(ULTIMO_LOGIN , '%b') AS MES, DATE_FORMAT(ULTIMO_LOGIN , '%Y-%m') AS ANO_MES FROM ACESSO 
WHERE USUARIO_ID = ".$userId[$v]." AND DATE_FORMAT(ULTIMO_LOGIN , '%Y-%m')<='".$yearMonth."'
GROUP BY ANO_MES ORDER BY ANO_MES DESC LIMIT 6) AS A ORDER BY 3;");
	
  	$i = 0;
	while ($c1_dash = $c1->fetch_array()) {
		if ($i == 0 ) { 
			$c1_access[$v] ="t:".$c1_dash["ACESSOS"];
			$c1_month[$v] ="".$c1_dash["MES"];
		} else {
			$c1_access[$v] .=",".$c1_dash["ACESSOS"];
			$c1_month[$v] .="|".$c1_dash["MES"];
		}
		$i++;
	}

	$a2 = mysqli_query($phpmyadmin, "SELECT A.MEDIA, A.REGISTRO FROM (SELECT ROUND(AVG(DESEMPENHO),2) AS MEDIA, REGISTRO FROM DESEMPENHO WHERE USUARIO_ID=".$userId[$v]." AND PRESENCA_ID NOT IN(3,5) GROUP BY REGISTRO ORDER BY REGISTRO DESC LIMIT 264) AS A
ORDER BY A.REGISTRO;");
	$a2_activitys = mysqli_num_rows($a2);
	
  	$i = 0;
	while ($a2_dash = $a2->fetch_array()) {
		if ($i == 0 ) { 
			$a2_avg[$v] ="t:".$a2_dash["MEDIA"];
		} else {
			$a2_avg[$v] .=",".$a2_dash["MEDIA"];
		}
		$i++;
	}
	$v++;

}//final while

$v = 0;

while ($v < sizeof($userId)) {
	
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
			<td ><b>Nome: </b><?php echo $name[$v]; ?></td>
			<td ><b>Líder: </b><?php echo $leader[$v]; ?></td>
			<td ><b>Data: </b><?php echo $register[$v]; ?></td>
		</tr>
	</table>
		<br>
	<table class="table is-bordered pricing__table is-fullwidth borda">	
		<tr class="red" >
			<td class="white-td"><b>Cargo</b></td>
			<td class="white-td"><b>Tempo de casa</b></td>
			<td class="white-td"><b>Idade</b></td>
		<tr>
			<td><?php echo $role[$v];?></td>
			<td><?php echo $months[$v]; ?> meses</td>
			<td><?php echo $age[$v]; ?> anos</td>
		</tr>
		
	</table>
			<?php 
		
	?>
	<table class="table is-bordered pricing__table is-fullwidth borda">	
		<tr>
			<td><b>Folga's</b></td>
			<td><b>Atestado's</b></td>
			<td><b>Falta's</b></td>
			<td><b>Penalidade's</b></td>
		</tr>
		<tr>
			<td><?php echo $dayOff[$v]; ?></td>
			<td><?php echo $attestation[$v]; ?></td>
			<td><?php echo $lack[$v]; ?></td>
			<td><?php echo $penalty[$v]; ?></td>
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
			<td><?php echo $min[$v]; ?></td>
			<td><?php echo $avg[$v]; ?></td>
			<td><?php echo $max[$v]; ?></td>
			<td><?php echo $position."/".$positions; ?></td>
		</tr>
		
	</table>
	<img src="http://chart.apis.google.com/chart?chs=700x150&cht=ls&chxt=x,y&chd=<?php echo $a2_avg[$v]?>&chl=&chds=a&chtt=Variação+performática+nos+últimos+12+meses+-+<?php echo $a2_activitys[$v]?>+atividades+registradas" width="100%" height="30%">
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
			<td><?php echo $fSend[$v]; ?></td>
			<td><?php echo $fRec[$v]; ?></td>
			<td><?php echo $rSend[$v]; ?></td>
			<td><?php echo $rRec[$v]; ?></td>
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
			<td><?php echo $fCom[$v]; ?></td>
			<td><?php echo $fPro[$v]; ?></td>
			<td><?php echo $fDes[$v]; ?></td>
			<td><?php echo round($avgFeed[$v], 2); ?></td>
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
			<td><?php echo $leaderEvaTec[$v]; ?></td>
			<td><?php echo $leaderEvaCom[$v]; ?></td>
			<td><?php echo round($leaderGeneral[$v],2); ?></td>
		</tr>
		<tr>
			<td><b>Auto</b></td>
			<td><?php echo $autoEvaTec[$v]; ?></td>
			<td><?php echo $autoEvaCom[$v]; ?></td>
			<td><?php echo round($autoGeneral[$v],2); ?></td>
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
WHERE AI.USUARIO_ID = " . $userId[$v].  " AND AI.AVALIACAO_POR = " . $userId[$v].  " AND ANO_MES='".$yearMonth."' AND  AP.AVAL_TIPO_PERGUNTA_ID IN(1,2) ORDER BY AI.USUARIO_ID;");
	
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

	echo "
	<div>
	<table class='table is-bordered pricing__table is-fullwidth borda'>";
	
		$y = 0;
		$count = 1;
		while ($y < sizeof($a3_question)) {
			echo "<tr class='blue'><td class='white-td' colspan='2'><b>" .$count.") ".$a3_question[$y]."</b></td></tr><br>";
			echo "<tr><td><b>" . $leader[$v] . "</b></td><td>" . $a3_answer_leader[$y] . "</td></tr><br>";
			echo "<tr><td><b>" . $name[$v] . "</b></td><td>" . $a3_answer[$y] . "</td></tr><br>";
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
			<td><?php echo $autoCom[$v]; ?></td>
		</tr>
		<tr class="red">
			<td class="white-td"><b><center>Comentário do Líder</center></b></td>
		</tr>
		<tr>
			<td><?php echo $leaderCom[$v]; ?></td>
		</tr>	
	</table>
	</div>
    </page>
</body>	
</html>
<?php
	$v++;
	if ($x < $reports) {
		echo "<div></div>";
	}

	$x++;
}