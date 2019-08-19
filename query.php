<?php
session_start();
include('connection.php');
$gafrico1="SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND REGISTRO >= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 3 MONTH),'%Y-%m'),'-21') 
AND REGISTRO <= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(),INTERVAL 2 MONTH),'%Y-%m'),'-20')),2)MENOR FROM DESEMPENHO 
WHERE REGISTRO >= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 3 MONTH),'%Y-%m'),'-21') 
AND REGISTRO <= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(),INTERVAL 2 MONTH),'%Y-%m'),'-20')
UNION ALL
SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND REGISTRO >= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH),'%Y-%m'),'-21') 
AND REGISTRO <= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(),INTERVAL 1 MONTH),'%Y-%m'),'-20')),2)MENOR FROM DESEMPENHO 
WHERE REGISTRO >= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH),'%Y-%m'),'-21') 
AND REGISTRO <= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(),INTERVAL 1 MONTH),'%Y-%m'),'-20')
UNION ALL
SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND REGISTRO >= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH),'%Y-%m'),'-21') 
AND REGISTRO <= CONCAT(DATE_FORMAT(CURDATE(),'%Y-%m'),'-20')),2)MENOR FROM DESEMPENHO 
WHERE REGISTRO >= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH),'%Y-%m'),'-21') 
AND REGISTRO <= CONCAT(DATE_FORMAT(CURDATE(),'%Y-%m'),'-20')
UNION ALL
SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND REGISTRO >= CONCAT(DATE_FORMAT(CURDATE(),'%Y-%m'),'-21') 
AND REGISTRO <= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(),INTERVAL 1 MONTH),'%Y-%m'),'-20')),2)MENOR FROM DESEMPENHO 
WHERE REGISTRO >= CONCAT(DATE_FORMAT(CURDATE(),'%Y-%m'),'-21') 
AND REGISTRO <= CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(),INTERVAL 1 MONTH),'%Y-%m'),'-20');";

$queryG3="select a.nome nome, max(b.alcancado) alcancado, b.menor
from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado, min(alcancado) menor from gestaodesempenho.desempenho where 
registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20') and presenca <>'Folga' group by nome order by alcancado desc limit 1) as b
where a.nome=b.nome and registro >= concat(date_format(curdate(),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval +1 month),'%Y-%m'),'-20')
union all
select a.nome, max(b.alcancado) alcancado, b.menor
from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado, min(alcancado) menor from gestaodesempenho.desempenho where 
registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20') and presenca <>'Folga' group by nome order by alcancado desc limit 1) as b
where a.nome=b.nome and registro >= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-21') and registro <= concat(date_format(curdate(),'%Y-%m'),'-20')
union all 
select a.nome, max(b.alcancado) alcancado, b.menor
from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado, min(alcancado) menor from gestaodesempenho.desempenho where registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20') and presenca <>'Folga' group by nome order by alcancado desc limit 1) as b
where a.nome=b.nome and registro >= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -1 month),'%Y-%m'),'-20')
union all 
select a.nome, max(b.alcancado) alcancado, b.menor
from gestaodesempenho.desempenho as a, (select nome, avg(alcancado) alcancado, min(alcancado) menor from gestaodesempenho.desempenho where registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') 
and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20') and presenca <>'Folga' group by nome order by alcancado desc limit 1) as b
where a.nome=b.nome and registro >= concat(date_format(date_add(curdate(),interval -3 month),'%Y-%m'),'-21') and registro <= concat(date_format(date_add(curdate(),interval -2 month),'%Y-%m'),'-20')
";
$gdGestor="SELECT ID, NOME FROM GESTOR WHERE SITUACAO='Ativo'";
$gdAtividade="SELECT ID, NOME FROM ATIVIDADE WHERE SITUACAO='Ativo'";
$gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo'";
function atividade(){
	$con = mysqli_query($phpmyadmin, $gdAtividade);
	$x=0; 
	while($atividade = $con->fetch_array()){
		$vtId[$x]=$atividade["ID"]; 
		$vtNome[$x] = utf8_encode($atividade["NOME"]);
		echo $vtNome[$x];
		$x++;
		
	} 
}
	//$ajusteBD="set global sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';";
	//$ajustes= mysqli_query($phpmyadmin, $ajusteBD);

?>								