<?php 
require('../connection.php');

$query = "SELECT AI.USUARIO_ID, U.NOME, UG.NOME AS LIDER, C.NOME AS CARGO,
TIMESTAMPDIFF(MONTH,U.EFETIVACAO,AI.REGISTRO ) AS MESES, TIMESTAMPDIFF(YEAR,U.NASCIMENTO,AI.REGISTRO ) 
AS IDADE, AI.REGISTRO, 
(SELECT COUNT(1) FROM DESEMPENHO WHERE PRESENCA_ID = 3 AND USUARIO_ID =U.ID) AS FOLGA,
(SELECT COUNT(1) FROM DESEMPENHO WHERE PRESENCA_ID = 4 AND USUARIO_ID =U.ID) AS ATESTADO,
(SELECT COUNT(1) FROM DESEMPENHO WHERE PRESENCA_ID = 2 AND USUARIO_ID =U.ID) AS FALTA,
(SELECT COUNT(1) FROM PENALIDADE WHERE USUARIO_ID =U.ID) AS PENALIDADE,
(SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE USUARIO_ID=AI.USUARIO_ID ) AS MINIMO,
(SELECT AVG(DESEMPENHO) FROM DESEMPENHO WHERE USUARIO_ID=AI.USUARIO_ID ) AS MEDIA,
(SELECT MAX(DESEMPENHO) FROM DESEMPENHO WHERE USUARIO_ID=AI.USUARIO_ID ) AS MAXIMO
FROM AVAL_INDICE AI
INNER JOIN USUARIO U ON U.ID = AI.USUARIO_ID
INNER JOIN USUARIO UG ON UG.ID = U.GESTOR_ID
INNER JOIN CARGO C ON C.ID = U.CARGO_ID 
WHERE AI.SITUACAO = 'Finalizado';";

$cnx = mysqli_query($phpmyadmin, $query);
$x = 1;
while ($data = $cnx->fetch_array()) {

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
			<td class="white-td" colspan="2"><h1><b><center>( evino )</center></b></h1></td>
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
			<td><?php echo $data["IDADE"]; ?></td>
		</tr>
		
	</table>
		<br>
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
		<tr class="grey"><td colspan="3"><b><center>Pilares Feedback</center></b></td></tr>	
		<tr>
			<td><b>Comportamental</b></td>
			<td><b>Profissional</b></td>
			<td><b>Desempenho</b></td>
		</tr>
		<tr>
			<td>30</td>
			<td>97</td>
			<td>120</td>
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
			<td>94,44</td>
			<td>103,12</td>
			<td rowspan="2">89,79</td>
			<td>95,78</td>
		</tr>
		<tr>
			<td><b>Auto</b></td>
			<td>88,88</td>
			<td>106,25</td>
			<td>94,97</td>
		</tr>	
	</table>
	<br>
	<table class="table is-bordered pricing__table is-fullwidth borda">	
		<tr class="red">
			<td class="white-td"><b>Comentário do Colaborador</b></td>
		</tr>
		<tr>
			<td>Busco sempre fazer o melhor para o meu desenvolvimento profissional e de meus
colegas de trabalho.</td>
		</tr>
		<tr class="red">
			<td class="white-td"><b>Comentário do Líder</b></td>
		</tr>
		<tr>
			<td>PONTOS POSITIVOS: Funcionário executa um bom trabalho nas áreas em que atua, é
atencioso, tem boa comunicação com todos da equipe, tem mostrado interesse pela
empresa e motivação, tem mostrado um grande espirito de liderança. Esta batendo as
metas exigidas pela empresa vem em um processo de evolução e crescimento.</td>
		</tr>	
	</table>
	
	<?php echo "<iframe src='frame.html' width='100%'' height='1080px;'' allowfullscreen ></iframe>"; ?>
</page>

</body>	
</html><?php
	if($x < sizeof($data)){
		echo "<div>test</div>";
	}
$x++;
}