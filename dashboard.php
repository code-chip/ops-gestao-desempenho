<?php 
$menuAtivo = 'dashboard';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
  echo "<script>alert('Usuário sem permissão'); window.location.href='dashboard-private.php'; </script>";
}

//SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
$cnx = mysqli_query($phpmyadmin, "SELECT DATE_FORMAT(MAX(REGISTRO),'%d') AS REGISTRO FROM DESEMPENHO;");
$ultimoRegistro=$cnx->fetch_array();
  
$yearMonth = date('Y-m');
$mes = date('m');

//DASH MEDIA GERAL	
$cnx = mysqli_query($phpmyadmin, "SELECT ROUND(AVG(DESEMPENHO),2) AS MEDIA, REGISTRO FROM DESEMPENHO GROUP BY REGISTRO ORDER BY REGISTRO DESC;");
$x = 0;

while ($mediaGeral = $cnx->fetch_array()) {
	$vtmediaGeral[$x] = $mediaGeral["MEDIA"];
	$x++;				
}

$x3 = 0;
$idsAtiv = "";
$cnx = mysqli_query($phpmyadmin, "SELECT ATIVIDADE_ID, A.NOME, COUNT(ATIVIDADE_ID) AS VEZES FROM DESEMPENHO D INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID WHERE ANO_MES='" . $yearMonth . "' GROUP BY ATIVIDADE_ID");
	
while ($G4 = $cnx->fetch_array()) {
	$vtG4nome[$x3] = $G4["NOME"];
	$vtG4vezes[$x3] = $G4["VEZES"];
  if ($x3 == 0) {
    $idsAtiv = $idsAtiv."".$G4["ATIVIDADE_ID"];
  } else {
    $idsAtiv=$idsAtiv.",".$G4["ATIVIDADE_ID"];
  }    
  
  $x3++;				
}

$cnx = mysqli_query($phpmyadmin, "SELECT NOME, 0 AS VEZES FROM ATIVIDADE WHERE ID NOT IN(".$idsAtiv.");");

if (mysqli_error($phpmyadmin) == null) {
  while($G41 = $cnx->fetch_array()) {
    $vtG4nome[$x3] = $G41["NOME"];
    $vtG4vezes[$x3] = $G41["VEZES"];
    $x3++;        
  }
}

$cnx = mysqli_query($phpmyadmin, "SELECT SUM(ACESSO) AS ACESSOS, SUBSTRING(ANO_MES,-2, 5) AS MES FROM ACESSO GROUP BY ANO_MES ORDER BY ANO_MES DESC LIMIT 6;");
$x = 0;

while ($G6 = $cnx->fetch_array()) {
	$vtG6Acesso[$x] = $G6["ACESSOS"];
  $vtG6Mes[$x] = $G6["MES"];
	$x++;
}

/*DASH RELAÇÃO FOLGAS E FALTAS P03*/
$queryFolgasFaltas = "SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-3 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-3 month'))."'
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-2 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-2 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-1 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-1 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND DATE_FORMAT(REGISTRO,'%m')='".date('m')."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND DATE_FORMAT(REGISTRO,'%m')='".date('m')."' ";

$cnx = mysqli_query($phpmyadmin, $queryFolgasFaltas);
$x = 0;

while ($folgasFaltas = $cnx->fetch_array()) {
  $vtFolgasFaltas[$x] = $folgasFaltas["COUNT(*)"];
  $x++;
}

/*DASH SEXO*/
$cnx = mysqli_query($phpmyadmin, "SELECT COUNT(*) AS QTD FROM USUARIO WHERE SITUACAO='Ativo' GROUP BY SEXO ORDER BY SEXO DESC;");
$x = 0;
while ($sexo = $cnx->fetch_array()) {
  $vtQtd[$x] = $sexo["QTD"];
  $x++;
}

/*DASH SEXO POR TURNO P04*/
$cnx = mysqli_query($phpmyadmin, "SELECT T.NOME, SEXO, COUNT(*) AS QTD FROM USUARIO INNER JOIN TURNO T ON T.ID=USUARIO.TURNO_ID WHERE TURNO_ID IN(1,2) AND USUARIO.SITUACAO='Ativo' GROUP BY TURNO_ID, SEXO ORDER BY TURNO_ID, SEXO DESC;");
$x = 0;

while ($sexoTurno = $cnx->fetch_array()) {
  $vtTurno[$x] = $sexoTurno["NOME"];
  $vtTurno[$x] = $vtTurno[$x]." ".$sexoTurno["SEXO"];
  $vtQtdTurno[$x] = $sexoTurno["QTD"];
  $x++;
}

//DASH COMPARATIVO ENTRE TURNOS - dash-turnos. P05
$cnx= mysqli_query($phpmyadmin, "SELECT AVG(DESEMPENHO) MEDIA, REGISTRO, DATE_FORMAT(REGISTRO, '%d/%m') AS MESDIA FROM DESEMPENHO WHERE USUARIO_TURNO_ID IN(1,2) AND PRESENCA_ID NOT IN (3,5) GROUP BY USUARIO_TURNO_ID, REGISTRO ORDER BY REGISTRO DESC, USUARIO_TURNO_ID LIMIT 44;");
$x = 0;

while ($compTurno = $cnx->fetch_array()) {
  $vtcompTurMed[$x] = $compTurno["MEDIA"];
  $vtcompTurReg[$x] = $compTurno["REGISTRO"];
  $vtcompTurDia[$x] = $compTurno["MESDIA"];
  $x++;
}

$x = 0;
$y = 0;
$countDay;
while ($x < sizeof($vtcompTurMed)) {//VERIFICA SE HÁ REGISTROS NOS DOIS TURNOS NO MESMO DIA P/ F.
  if ($vtcompTurReg[$x] == $vtcompTurReg[$x+1]) {
    $turMat[$y] = $vtcompTurMed[$x];
    $turVes[$y] = $vtcompTurMed[$x+1];
    $turDia[$y] = $vtcompTurDia[$x];
    $x++; 
    $y++;
  }
  else {
    $x++;
  }
}

//Média de desempenho por atividade --b2//
$x = 0;
$queryB2;

function query($date) {
  global $queryB2;
  $queryB2 = "SELECT 'Checkout', IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA FROM DESEMPENHO WHERE ATIVIDADE_ID=1 AND ANO_MES='".$date."' UNION
  SELECT 'Separação', IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA FROM DESEMPENHO WHERE ATIVIDADE_ID=2 AND ANO_MES='".$date."' UNION
  SELECT 'Embalagem', IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA FROM DESEMPENHO WHERE ATIVIDADE_ID=3 AND ANO_MES='".$date."' UNION
  SELECT 'PBL', IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA FROM DESEMPENHO WHERE ATIVIDADE_ID=4 AND ANO_MES='".$date."' UNION
  SELECT 'Recebimento', IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA FROM DESEMPENHO WHERE ATIVIDADE_ID=5 AND ANO_MES='".$date."' UNION
  SELECT 'Devolução', IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA FROM DESEMPENHO WHERE ATIVIDADE_ID=6 AND ANO_MES='".$date."' UNION
  SELECT 'Avarias', IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA FROM DESEMPENHO WHERE ATIVIDADE_ID=7 AND ANO_MES='".$date."' UNION 
  SELECT 'Expedição', IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA FROM DESEMPENHO WHERE ATIVIDADE_ID=8 AND ANO_MES='".$date."'";
} 

query($yearMonth);

$cnx = mysqli_query($phpmyadmin, $queryB2);
while ($b2 = $cnx->fetch_array()) {
  $activityB2[$x] = $b2["Checkout"];
  $avgB2[$x] = $b2["MEDIA"];
  $x++;
}

query(date('Y-m', strtotime('-1 month')));

$cnx = mysqli_query($phpmyadmin, $queryB2);
while ($b2 = $cnx->fetch_array()) {
  $activityB2[$x] = $b2["Checkout"];
  $avgB2[$x] = $b2["MEDIA"];
  $x++;
}

//DASH RANKING MELHORES DO MÊS - top8//
$x = 0;
  $cnx = mysqli_query($phpmyadmin, "SELECT U.NOME, ROUND(AVG(DESEMPENHO),2) MEDIA FROM DESEMPENHO INNER JOIN USUARIO U ON U.ID=USUARIO_ID WHERE PRESENCA_ID NOT IN(3,5) AND ANO_MES = '" . $yearMonth . "' GROUP BY USUARIO_ID ORDER BY MEDIA DESC LIMIT 8;");
  while ($top8 = $cnx->fetch_array()) {
    $vtNomeTop8[$x] = $top8["NOME"];
    $vtMediaTop8[$x] = $top8["MEDIA"];
    $x++;
  }
  
  $x = 0;//DASH RANKING BAIXO DESEMPENHO MÊS - top10-piores
  $cnx = mysqli_query($phpmyadmin, "SELECT U.NOME, ROUND(AVG(DESEMPENHO),2) MEDIA FROM DESEMPENHO INNER JOIN USUARIO U ON U.ID = USUARIO_ID WHERE PRESENCA_ID NOT IN(3,5) AND ANO_MES = '" . $yearMonth . "' GROUP BY USUARIO_ID ORDER BY MEDIA LIMIT 10;");
  while ($top10 = $cnx->fetch_array()) {
    $vtNomeTop10[$x] = $top10["NOME"];
    $vtMediaTop10[$x] = $top10["MEDIA"];
    $x++;
  }
  //DASH FAIXA ETÁRIA POR IDADE
  $queryFaixaEtaria = "SELECT COUNT(ID) FROM USUARIO WHERE TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())>=18 AND TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())<=21 AND SITUACAO<>'Desligado' UNION ALL
SELECT COUNT(ID) FROM USUARIO WHERE TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())>=22 AND TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())<=22 AND SITUACAO<>'Desligado' UNION ALL
SELECT COUNT(ID) FROM USUARIO WHERE TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())>=26 AND TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())<=28 AND SITUACAO<>'Desligado' UNION ALL
SELECT COUNT(ID) FROM USUARIO WHERE TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())>=29 AND TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())<=31 AND SITUACAO<>'Desligado' UNION ALL
SELECT COUNT(ID) FROM USUARIO WHERE TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())>=32 AND TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())<=35 AND SITUACAO<>'Desligado' UNION ALL
SELECT COUNT(ID) FROM USUARIO WHERE TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())>=36 AND TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())<=40 AND SITUACAO<>'Desligado' UNION ALL
SELECT COUNT(ID) FROM USUARIO WHERE TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())>=41 AND TIMESTAMPDIFF(YEAR,NASCIMENTO,CURDATE())<=44 AND SITUACAO<>'Desligado';";
  $x = 0;
  $cnx = mysqli_query($phpmyadmin, $queryFaixaEtaria);
  while ($faiEta = $cnx->fetch_array()) {
    $vtFaixaEtaria[$x] = $faiEta["COUNT(ID)"];
    $x++;
  }
  //DASH META ATINGIDA PERDIDA - meta-pacman
  $querypacman="SELECT COUNT(*) DESEMPENHO, DATE_FORMAT(REGISTRO, '%d/%m') AS REGISTRO FROM DESEMPENHO WHERE DESEMPENHO>=100 AND REGISTRO=(SELECT MAX(REGISTRO) FROM DESEMPENHO) UNION ALL SELECT COUNT(*) DESEMPENHO, DATE_FORMAT(REGISTRO, '%d/%m') AS REGISTRO FROM DESEMPENHO WHERE DESEMPENHO<100 AND REGISTRO=(SELECT MAX(REGISTRO) FROM DESEMPENHO);";
  $x=0;
  $cnx= mysqli_query($phpmyadmin, $querypacman);
  if(mysqli_error($phpmyadmin)==null){
    while ($pacman= $cnx->fetch_array()) {
      $vtPacMan[$x]=$pacman["DESEMPENHO"];
      $vtPacManData[$x]=$pacman["REGISTRO"];     
      $x++;
    }
  }
  //DASH EXPEDIÇÃO DE CAIXAS E VINHOS.
  $queryCaixas="SELECT IFNULL(SUM(A.ALCANCADO),0) AS CAIXAS FROM (
SELECT ALCANCADO, REGISTRO FROM DESEMPENHO WHERE DATE_FORMAT(REGISTRO,'%Y-%m')='".date('Y-m')."' AND ATIVIDADE_ID=3 GROUP BY REGISTRO, ALCANCADO) A
UNION ALL
SELECT SUM(B.ALCANCADO) FROM (
SELECT ALCANCADO, REGISTRO FROM DESEMPENHO WHERE DATE_FORMAT(REGISTRO,'%Y-%m')= '".date('Y-m', strtotime('-1 month'))."' AND ATIVIDADE_ID=3 GROUP BY REGISTRO, ALCANCADO) B
UNION ALL
SELECT SUM(C.ALCANCADO) FROM (
SELECT ALCANCADO, REGISTRO FROM DESEMPENHO WHERE DATE_FORMAT(REGISTRO,'%Y-%m')='".date('Y-m', strtotime('-2 month'))."' AND ATIVIDADE_ID=3 GROUP BY REGISTRO, ALCANCADO) C
UNION ALL
SELECT SUM(D.ALCANCADO) FROM (
SELECT ALCANCADO, REGISTRO FROM DESEMPENHO WHERE DATE_FORMAT(REGISTRO,'%Y-%m')='".date('Y-m', strtotime('-3 month'))."' AND ATIVIDADE_ID=3 GROUP BY REGISTRO, ALCANCADO) D
";
  $queryVinhosC="SELECT IFNULL(ROUND(SUM(ALCANCADO)/3,0),0) AS CHECKOUT FROM DESEMPENHO WHERE ATIVIDADE_ID=1 AND DATE_FORMAT(REGISTRO, '%Y-%m')='".date('Y-m')."'
UNION ALL
SELECT IFNULL(ROUND(SUM(ALCANCADO)/3,0),0) AS CHECKOUT FROM DESEMPENHO WHERE ATIVIDADE_ID=1 AND DATE_FORMAT(REGISTRO, '%Y-%m')='".date('Y-m', strtotime('-1 month'))."'
UNION ALL
SELECT IFNULL(ROUND(SUM(ALCANCADO)/3,0),0) AS CHECKOUT FROM DESEMPENHO WHERE ATIVIDADE_ID=1 AND DATE_FORMAT(REGISTRO, '%Y-%m')='".date('Y-m', strtotime('-2 month'))."'
UNION ALL
SELECT IFNULL(ROUND(SUM(ALCANCADO)/3,0),0) AS CHECKOUT FROM DESEMPENHO WHERE ATIVIDADE_ID=1 AND DATE_FORMAT(REGISTRO, '%Y-%m')='".date('Y-m', strtotime('-3 month'))."'
";
  $queryVinhosP="SELECT IFNULL(SUM(PBL.PBL),0) AS PBL FROM (SELECT ALCANCADO AS PBL FROM DESEMPENHO WHERE ATIVIDADE_ID=4 and DATE_FORMAT(REGISTRO, '%Y-%m')='".date('Y-m')."' GROUP BY REGISTRO) as PBL
UNION ALL
SELECT IFNULL(SUM(PBL.PBL),0) AS PBL FROM (SELECT ALCANCADO AS PBL FROM DESEMPENHO WHERE ATIVIDADE_ID=4 and DATE_FORMAT(REGISTRO, '%Y-%m')='".date('Y-m', strtotime('-1 month'))."' GROUP BY REGISTRO) as PBL
UNION ALL
SELECT IFNULL(SUM(PBL.PBL),0) AS PBL FROM (SELECT ALCANCADO AS PBL FROM DESEMPENHO WHERE ATIVIDADE_ID=4 and DATE_FORMAT(REGISTRO, '%Y-%m')='".date('Y-m', strtotime('-2 month'))."' GROUP BY REGISTRO) as PBL
UNION ALL
SELECT IFNULL(SUM(PBL.PBL),0) AS PBL FROM (SELECT ALCANCADO AS PBL FROM DESEMPENHO WHERE ATIVIDADE_ID=4 and DATE_FORMAT(REGISTRO, '%Y-%m')='".date('Y-m', strtotime('-3 month'))."' GROUP BY REGISTRO) as PBL";  
  $x=0;
  $cnx= mysqli_query($phpmyadmin, $queryCaixas);
  while ($caixasVinhos= $cnx->fetch_array()) {
    $vtCaiVin[0][$x]=$caixasVinhos["CAIXAS"];
    $x++;    
  }
  $x=0;  
  $cnx= mysqli_query($phpmyadmin, $queryVinhosC);
  while ($caixasVinhosC= $cnx->fetch_array()) {
    $vtCaiVin[1][$x]=$caixasVinhosC["CHECKOUT"];
    $x++;
  }
  $x=0;  
  $cnx= mysqli_query($phpmyadmin, $queryVinhosP);
  while ($caixasVinhosP= $cnx->fetch_array()) {
    $vtCaiVin[1][$x]=$vtCaiVin[1][$x]+$caixasVinhosP["PBL"];
    $x++;
  }
  //DASH MÉDIA DE DESEMPENHO 3 PRINCIPAIS ATIVIDADES - 3atividades-principais
  for($i=0 ;$i <3;$i++){
    $idAtividade=1+$i;
    $querypriAtivi="SELECT ATIVIDADE_ID, DATE_FORMAT(REGISTRO,'%d/%m') REGISTRO, ROUND(AVG(DESEMPENHO),2) MEDIA FROM DESEMPENHO WHERE ATIVIDADE_ID=".$idAtividade." AND REGISTRO<=(SELECT MAX(REGISTRO) FROM DESEMPENHO) AND PRESENCA_ID NOT IN (3,5) GROUP BY REGISTRO DESC LIMIT 6;
";
    $x=0;
    $cnx= mysqli_query($phpmyadmin, $querypriAtivi);
    while ($priAtiv= $cnx->fetch_array()) {
      $vtMedia3PrincAtiv[$i][$x]=$priAtiv["MEDIA"];
      $vtData3PrincAtiv[$i][$x]=$priAtiv["REGISTRO"];  
      $x++;
    }
    $idAtividade++;
  }
  //DASH NÚMERO DE REGISTROS
  $queryNumRegi="SELECT COUNT(DESEMPENHO) AS OCORRENCIAS, DATE_FORMAT(REGISTRO,'%d-%m')AS DIA, COUNT(DISTINCT USUARIO_ID) AS USUARIOS FROM DESEMPENHO GROUP BY REGISTRO DESC LIMIT 5;";
  $cnx=mysqli_query($phpmyadmin, $queryNumRegi);
  $x=0;
  while($numRegi= $cnx->fetch_array()){
    $vtNumRegi[$x]=$numRegi["OCORRENCIAS"];
    $vtNumUsuarios[$x]=$numRegi["USUARIOS"];
    $vtNumData[$x]=$numRegi["DIA"];
    $x++;
  }
  //DASH DESEMPENHO POR TEMPO DE CASA dash-tempo-de-casa
  $queryTempoCasa="SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 6 AS TEMPO, (SELECT COUNT(ID) FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)<183 AND SITUACAO<>'Desligado') AS QTD FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)<183 AND SITUACAO<>'Desligado')
UNION ALL
SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 12, (SELECT COUNT(ID) FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>182 AND DATEDIFF(CURDATE(),EFETIVACAO)<366 AND SITUACAO<>'Desligado') AS QTD FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>182 AND DATEDIFF(CURDATE(),EFETIVACAO)<366 AND SITUACAO<>'Desligado')
UNION ALL
SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 18, (SELECT COUNT(ID) FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>365 AND DATEDIFF(CURDATE(),EFETIVACAO)<548 AND SITUACAO<>'Desligado') AS QTD FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>365 AND DATEDIFF(CURDATE(),EFETIVACAO)<548 AND SITUACAO<>'Desligado')
UNION ALL
SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 24, (SELECT COUNT(ID) FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>547 AND DATEDIFF(CURDATE(),EFETIVACAO)<731 AND SITUACAO<>'Desligado') AS QTD FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>547 AND DATEDIFF(CURDATE(),EFETIVACAO)<731 AND SITUACAO<>'Desligado')
UNION ALL
SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 30, (SELECT COUNT(ID) FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>730 AND DATEDIFF(CURDATE(),EFETIVACAO)<913 AND SITUACAO<>'Desligado') AS QTD FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>730 AND DATEDIFF(CURDATE(),EFETIVACAO)<913 AND SITUACAO<>'Desligado')
UNION ALL
SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 36, (SELECT COUNT(ID) FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>912 AND DATEDIFF(CURDATE(),EFETIVACAO)<1096 AND SITUACAO<>'Desligado') AS QTD FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>912 AND DATEDIFF(CURDATE(),EFETIVACAO)<1096 AND SITUACAO<>'Desligado')
UNION ALL
SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 42, (SELECT COUNT(ID) FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>1094 AND DATEDIFF(CURDATE(),EFETIVACAO)<1277 AND SITUACAO<>'Desligado') AS QTD FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>1094 AND DATEDIFF(CURDATE(),EFETIVACAO)<1277 AND SITUACAO<>'Desligado')
UNION ALL
SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 48, (SELECT COUNT(ID) FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>1276 AND DATEDIFF(CURDATE(),EFETIVACAO)<1461 AND SITUACAO<>'Desligado') AS QTD FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>1276 AND DATEDIFF(CURDATE(),EFETIVACAO)<1461 AND SITUACAO<>'Desligado')
UNION ALL
SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 54, (SELECT COUNT(ID) FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>1460 AND SITUACAO<>'Desligado') AS QTD FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE DATEDIFF(CURDATE(),EFETIVACAO)>1460 AND SITUACAO<>'Desligado');
";
  $x = 0;
  $cnx = mysqli_query($phpmyadmin, $queryTempoCasa);
  while ($tc = $cnx->fetch_array()) {
    $vtTempMed[$x] = $tc["MEDIA"];
    $vtTempo[$x] = $tc["TEMPO"];
    $vtTempQtd[$x] = $tc["QTD"];
    $x++;
  }

$cnx = mysqli_query($phpmyadmin, $queryNumRegi);
$x = 0;

while($numRegi= $cnx->fetch_array()){
  $vtNumRegi[$x]=$numRegi["OCORRENCIAS"];
  $vtNumUsuarios[$x]=$numRegi["USUARIOS"];
  $vtNumData[$x]=$numRegi["DIA"];
  $x++;
}

$x = 0;
$cnx = mysqli_query($phpmyadmin, "SELECT COUNT(1) AS QTD, (SELECT DATE_FORMAT(MAX(REGISTRO),'%d/%m') FROM DESEMPENHO WHERE CADASTRADO_POR = 58) AS REG, (SELECT COUNT(1) FROM USUARIO WHERE GESTOR_ID = 58 AND SITUACAO = 'Ativo') AS TIME FROM DESEMPENHO WHERE CADASTRADO_POR = 58 AND REGISTRO = (SELECT MAX(REGISTRO) FROM DESEMPENHO WHERE CADASTRADO_POR = 58) UNION SELECT COUNT(1) AS QTD, (SELECT DATE_FORMAT(MAX(REGISTRO),'%d/%m') FROM DESEMPENHO WHERE CADASTRADO_POR = 57) AS REG, (SELECT COUNT(1) FROM USUARIO WHERE GESTOR_ID = 57 AND SITUACAO = 'Ativo') AS TIME FROM DESEMPENHO WHERE CADASTRADO_POR = 57 AND REGISTRO = (SELECT MAX(REGISTRO) FROM DESEMPENHO WHERE CADASTRADO_POR = 57) UNION SELECT COUNT(1) AS QTD, (SELECT DATE_FORMAT(MAX(REGISTRO),'%d/%m') FROM DESEMPENHO WHERE CADASTRADO_POR = 3) AS REG, (SELECT COUNT(1) FROM USUARIO WHERE GESTOR_ID = 3 AND SITUACAO = 'Ativo') AS TIME FROM DESEMPENHO WHERE CADASTRADO_POR = 3 AND REGISTRO = (SELECT MAX(REGISTRO) FROM DESEMPENHO WHERE CADASTRADO_POR = 3) UNION SELECT COUNT(1) AS QTD, (SELECT DATE_FORMAT(MAX(REGISTRO),'%d/%m') FROM DESEMPENHO WHERE CADASTRADO_POR = 99) AS REG, (SELECT COUNT(1) FROM USUARIO WHERE GESTOR_ID = 99 AND SITUACAO = 'Ativo') AS TIME FROM DESEMPENHO WHERE CADASTRADO_POR = 99 AND REGISTRO = (SELECT MAX(REGISTRO) FROM DESEMPENHO WHERE CADASTRADO_POR = 99)
");

while ($a5 = $cnx->fetch_array()) {
  $a5date[$x] = $a5["REG"];
  $a5count[$x] = $a5["QTD"];
  $a5time[$x] = $a5["TIME"];
  $a5status[$x] = "✗";
  $a5status[$x] = "false";
  if ($a5["QTD"] >= $a5["TIME"]) {
    $a5status[$x] = "✔";
    $a5status[$x] = "true";
  }

  $x++;
}
$test=true;
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Dashboard</title>
	<link rel="stylesheet" href="css/login.css" />
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">-->
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<link rel="stylesheet" href="css/animate.css" />
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      var vt=<?php print_r(sizeof($vtG4nome))?>;
      var atividade = [<?php echo '"'.implode('","',  $vtG4nome ).'"' ?>];
      var vezes = [<?php echo '"'.implode('","',  $vtG4vezes ).'"' ?>];
      var x=0;
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Atividade', 'Realizada'],
          ['<?php echo $vtG4nome[0];?>', parseInt(vezes[0])],
          ['<?php echo $vtG4nome[1];?>', <?php echo $vtG4vezes[1];?>],
          ['<?php echo $vtG4nome[2];?>', <?php echo $vtG4vezes[2];?>],
          ['<?php echo $vtG4nome[3];?>', <?php echo $vtG4vezes[3];?>],
          ['<?php echo $vtG4nome[4];?>', <?php echo $vtG4vezes[4];?>],
          ['<?php echo $vtG4nome[5];?>', <?php echo $vtG4vezes[5];?>],
          ['<?php echo $vtG4nome[6];?>', <?php echo $vtG4vezes[6];?>]
        ]);

        var options = {
          title: 'Distribuição atividades <?php echo "01/".$mes." a ".date('t/m');?>',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('a1'));
        chart.draw(data, options);
      }
    </script>
  <script type="text/javascript">
  google.charts.load('current', {packages: ['corechart', 'line']});
  google.charts.setOnLoadCallback(drawBasic);
  function drawBasic() {
        var data = new google.visualization.DataTable();''
      var o;     
        data.addColumn('number', 'X');
        data.addColumn('number', 'Avg');
      data.addRows([
          [parseFloat('<?php echo $vtmediaGeraDia[25]?>'), parseFloat('<?php echo $vtmediaGeral[25]?>')],   [1, parseFloat('<?php echo $vtmediaGeral[24]?>')],  [2, parseFloat('<?php echo $vtmediaGeral[23]?>')],
          [3, parseFloat('<?php echo $vtmediaGeral[22]?>')],  [4, parseFloat('<?php echo $vtmediaGeral[21]?>')],  [5, parseFloat('<?php echo $vtmediaGeral[20]?>')],
          [6, parseFloat('<?php echo $vtmediaGeral[19]?>')],  [7, parseFloat('<?php echo $vtmediaGeral[18]?>')],  [8, parseFloat('<?php echo $vtmediaGeral[17]?>')],
          [9, parseFloat('<?php echo $vtmediaGeral[16]?>')],  [10, parseFloat('<?php echo $vtmediaGeral[15]?>')], [11, parseFloat('<?php echo $vtmediaGeral[14]?>')],
          [12, parseFloat('<?php echo $vtmediaGeral[13]?>')], [13, parseFloat('<?php echo $vtmediaGeral[12]?>')], [14, parseFloat('<?php echo $vtmediaGeral[11]?>')], 
          [15, parseFloat('<?php echo $vtmediaGeral[10]?>')], [16, parseFloat('<?php echo $vtmediaGeral[9]?>')], [17, parseFloat('<?php echo $vtmediaGeral[8]?>')],
          [18, parseFloat('<?php echo $vtmediaGeral[7]?>')], [19, parseFloat('<?php echo $vtmediaGeral[6]?>')], [20, parseFloat('<?php echo $vtmediaGeral[5]?>')], 
          [21, parseFloat('<?php echo $vtmediaGeral[4]?>')], [22, parseFloat('<?php echo $vtmediaGeral[3]?>')], [23, parseFloat('<?php echo $vtmediaGeral[2]?>')],
          [24, parseFloat('<?php echo $vtmediaGeral[1]?>')], [25, parseFloat('<?php echo $vtmediaGeral[0]?>')]
      ]);
        var options = {
          hAxis: {
              title: 'Últimos 26 dias'
          },
          vAxis: {
              title: 'Desempenho da empresa'
          }
        };
        var chart = new google.visualization.LineChart(document.getElementById('a2'));
        chart.draw(data, options);
    }
</script>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Folgas', 'Faltas'],
          ['<?php echo strftime('%h', strtotime("-3 months"))?>', <?php echo $vtFolgasFaltas[0]?>, <?php echo $vtFolgasFaltas[1]?>],
          ['<?php echo strftime('%h', strtotime("-2 months"))?>', <?php echo $vtFolgasFaltas[2]?>, <?php echo $vtFolgasFaltas[3]?>],
          ['<?php echo strftime('%h', strtotime("-1 months"))?>', <?php echo $vtFolgasFaltas[4]?>, <?php echo $vtFolgasFaltas[5]?>],
          ['<?php echo strftime('%h')?>', <?php echo $vtFolgasFaltas[6]?>, <?php echo $vtFolgasFaltas[7]?>]          
        ]);

        var options = {
          chart: {
            title: 'Relação ausência',
            subtitle: 'Folgas e faltas do período <?php echo strftime('%h', strtotime("-3 months"))?> a <?php echo strftime('%h')?>',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('a3'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dia', 'Matutino', 'Vespertino'],
          ['<?php echo $turDia[6]?>',  <?php echo $turMat[6]?>, <?php echo $turVes[6]?>],
          ['<?php echo $turDia[5]?>',  <?php echo $turMat[5]?>, <?php echo $turVes[5]?>],
          ['<?php echo $turDia[4]?>',  <?php echo $turMat[4]?>, <?php echo $turVes[4]?>],
          ['<?php echo $turDia[3]?>',  <?php echo $turMat[3]?>, <?php echo $turVes[3]?>],
          ['<?php echo $turDia[2]?>',  <?php echo $turMat[2]?>, <?php echo $turVes[2]?>],
          ['<?php echo $turDia[1]?>',  <?php echo $turMat[1]?>, <?php echo $turVes[1]?>],
          ['<?php echo $turDia[0]?>',  <?php echo $turMat[0]?>, <?php echo $turVes[0]?>]
        ]);

        var options = {
          title: 'Performance entre turnos',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('b1'));

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Checkout', 'Separação', 'Caixas', 'PBL', 'Recebimento','Devolução', 'Avarias'],
          ['<?php echo date('m/y',strtotime('-1 month')); ?>', <?php echo $avgB2[8];?>, <?php echo $avgB2[9];?>, <?php echo $avgB2[10];?>, <?php echo $avgB2[11];?>, <?php echo $avgB2[12];?>, <?php echo $avgB2[13];?>, <?php echo $avgB2[14];?>],
          ['<?php echo date('m/y'); ?>', <?php echo $avgB2[0];?>, <?php echo $avgB2[1];?>, <?php echo $avgB2[2];?>, <?php echo $avgB2[3];?>, <?php echo $avgB2[4];?>, <?php echo $avgB2[5];?>, <?php echo $avgB2[6];?>]        

        ]);

        var options = {
          title : 'Média de desempenho por atividade',
          vAxis: {title: 'Desempenho'},
          hAxis: {title: 'Mês/Ano'},
          seriesType: 'bars',
          series: {6: {type: 'line'}}
        };
        var chart = new google.visualization.ComboChart(document.getElementById('b2'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      	google.charts.load("current", {packages:["corechart"]});
      	google.charts.setOnLoadCallback(drawChart);
      	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Sexo', 'Quantidade'],
          ['Masculino',     parseFloat(<?php echo $vtQtd[0];?>)],
          ['Feminino',     parseFloat(<?php echo $vtQtd[1];?>)]          
        ]);

        var options = {
          title: 'Percentual de funcionários Homens/Mulheres',
          pieHole: 0.8,
        };

        var chart = new google.visualization.PieChart(document.getElementById('b3'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      	google.charts.load("current", {packages:["corechart"]});
      	google.charts.setOnLoadCallback(drawChart);
      	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Sexo', 'Quantidade'],
          ['<?php echo $vtTurno[0]?>', parseFloat(<?php echo $vtQtdTurno[0]?>)],
          ['<?php echo $vtTurno[1]?>', parseFloat(<?php echo $vtQtdTurno[1]?>)],
          ['<?php echo $vtTurno[2]?>', parseFloat(<?php echo $vtQtdTurno[2]?>)],
          ['<?php echo $vtTurno[3]?>', parseFloat(<?php echo $vtQtdTurno[3]?>)]          
        ]);

        var options = {
          title: 'Percentual Masculino/Feminino por turno',
          pieHole: 0.3,
        };

        var chart = new google.visualization.PieChart(document.getElementById('a4'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ['<?php echo $vtNomeTop8[0]?>', <?php echo $vtMediaTop8[0]?>, "color: #e5e4e2"],
        ['<?php echo $vtNomeTop8[1]?>', <?php echo $vtMediaTop8[1]?>, "gold"],
        ['<?php echo $vtNomeTop8[2]?>', <?php echo $vtMediaTop8[2]?>, "silver"],
        ['<?php echo $vtNomeTop8[3]?>', <?php echo $vtMediaTop8[3]?>, "#b87333"],
        ['<?php echo $vtNomeTop8[4]?>', <?php echo $vtMediaTop8[4]?>, "#b87333"],
        ['<?php echo $vtNomeTop8[5]?>', <?php echo $vtMediaTop8[5]?>, "#b87333"],
        ['<?php echo $vtNomeTop8[6]?>', <?php echo $vtMediaTop8[6]?>, "#b87333"],
        ['<?php echo $vtNomeTop8[7]?>', <?php echo $vtMediaTop8[7]?>, "#b87333"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Ranking melhores do mês",
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("b4"));
      chart.draw(view, options);
	  }
	  </script>
  	<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Desempenho', 'Funcionários'],
          ['Acima de 44', 0], ['41 a 44', <?php echo $vtFaixaEtaria[6]?>], ['36 a 40', <?php echo $vtFaixaEtaria[5]?>],
          ['32 a 35', <?php echo $vtFaixaEtaria[4]?>], ['29 a 31', <?php echo $vtFaixaEtaria[3]?>], ['26 a 28', <?php echo $vtFaixaEtaria[2]?>],
          ['22 a 25', <?php echo $vtFaixaEtaria[1]?>], ['18 a 21', <?php echo $vtFaixaEtaria[0]?>],          
        ]);

        var options = {
          title: 'Distribuição por faixa etária',
          legend: 'none',
          pieSliceText: 'label',
          slices: {  4: {offset: 0.2},
                    12: {offset: 0.3},
                    14: {offset: 0.4},
                    15: {offset: 0.5},
          },
        };

        var chart = new google.visualization.PieChart(document.getElementById('c1'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Meta', 'Quantidade'],
          ['Atiginda', <?php echo $vtPacMan[0]?>],
          ['Perdida', <?php echo $vtPacMan[1]?>]
        ]);
        var options = {
        	title: 'Meta atiginda/perdida <?php echo $vtPacManData[0];?>',
          legend: 'none',
          pieSliceText: 'label',
          pieStartAngle: 135,
          tooltip: { trigger: 'none' },
          slices: {
            0: { color: 'yellow' },
            1: { color: 'transparent' }
          }
        };
        var chart = new google.visualization.PieChart(document.getElementById('c2'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
    	google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'C', 'V'],
          ['<?php echo strftime('%h', strtotime("-3 months"))?>', <?php echo $vtCaiVin[0][3]?>, <?php echo $vtCaiVin[1][3]?>],
          ['<?php echo strftime('%h', strtotime("-2 months"))?>', <?php echo $vtCaiVin[0][2]?>, <?php echo $vtCaiVin[1][2]?>],
          ['<?php echo strftime('%h', strtotime("-1 months"))?>', <?php echo $vtCaiVin[0][1]?>, <?php echo $vtCaiVin[1][1]?>],
          ['<?php echo strftime('%h')?>', <?php echo $vtCaiVin[0][0]?>, <?php echo $vtCaiVin[1][0]?>]
        ]);
        var options = {
          chart: {
            title: 'Estimativa de caixas e vinhos expedidas',
            //subtitle: 'Caixas, Garrafas: 09-11',
          },
          bars: 'vertical',
          vAxis: {format: ''},
          bar: {groupWidth: "85%"},
          //height: 400,
          colors: ['#FF0000', '#800000']
        };
        var chart = new google.charts.Bar(document.getElementById('c3'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
        var btns = document.getElementById('btn-group');
        btns.onclick = function (e) {
          if (e.target.tagName === 'BUTTON') {
            options.vAxis.format = e.target.id === 'none' ? '' : e.target.id;
            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        }
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dia', 'Checkout', 'Separação','Caixas',],
          ['<?php echo $vtData3PrincAtiv[0][5]?>',  parseFloat('<?php echo $vtMedia3PrincAtiv[0][5]?>'), parseFloat('<?php echo $vtMedia3PrincAtiv[1][5]?>'),parseFloat('<?php echo $vtMedia3PrincAtiv[2][5]?>')],
          ['<?php echo $vtData3PrincAtiv[0][4]?>',  parseFloat('<?php echo $vtMedia3PrincAtiv[0][4]?>'), parseFloat('<?php echo $vtMedia3PrincAtiv[1][4]?>'),parseFloat('<?php echo $vtMedia3PrincAtiv[2][4]?>')],
          ['<?php echo $vtData3PrincAtiv[0][3]?>',  parseFloat('<?php echo $vtMedia3PrincAtiv[0][3]?>'), parseFloat('<?php echo $vtMedia3PrincAtiv[1][3]?>'),parseFloat('<?php echo $vtMedia3PrincAtiv[2][3]?>')],
          ['<?php echo $vtData3PrincAtiv[0][2]?>',  parseFloat('<?php echo $vtMedia3PrincAtiv[0][2]?>'), parseFloat('<?php echo $vtMedia3PrincAtiv[1][2]?>'),parseFloat('<?php echo $vtMedia3PrincAtiv[2][2]?>')],
          ['<?php echo $vtData3PrincAtiv[0][1]?>',  parseFloat('<?php echo $vtMedia3PrincAtiv[0][1]?>'), parseFloat('<?php echo $vtMedia3PrincAtiv[1][1]?>'),parseFloat('<?php echo $vtMedia3PrincAtiv[2][1]?>')],
          ['<?php echo $vtData3PrincAtiv[0][0]?>',  parseFloat('<?php echo $vtMedia3PrincAtiv[0][0]?>'), parseFloat('<?php echo $vtMedia3PrincAtiv[1][0]?>'), parseFloat('<?php echo $vtMedia3PrincAtiv[2][0]?>')]
        ]);

          var options_stacked = {
          	title: 'Média de desempenho das 3 principais atividades',
          hAxis: {title: 'Dias',  titleTextStyle: {color: '#333'}},
          isStacked: true,
          legend: {position: 'top', maxLines: 3},
          vAxis: {minValue: 0, ticks: [0, .3, .6, .9, 1]}
        };
    

        var chart = new google.visualization.AreaChart(document.getElementById('c4'));
        chart.draw(data, options_stacked);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dia', 'Registros', 'Usuários'],
          ['<?php echo $vtNumData[4]?>', <?php echo $vtNumRegi[4]?>, <?php echo $vtNumUsuarios[4]?>],
          ['<?php echo $vtNumData[3]?>', <?php echo $vtNumRegi[3]?>, <?php echo $vtNumUsuarios[3]?>],
          ['<?php echo $vtNumData[2]?>', <?php echo $vtNumRegi[2]?>, <?php echo $vtNumUsuarios[2]?>],
          ['<?php echo $vtNumData[1]?>', <?php echo $vtNumRegi[1]?>, <?php echo $vtNumUsuarios[1]?>],
          ['<?php echo $vtNumData[0]?>', <?php echo $vtNumRegi[0]?>, <?php echo $vtNumUsuarios[0]?>]
        ]);

        var options = {
          title: 'Número de registros no dia',
          hAxis: {title: 'Dia e mês',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('d1'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Meses', '', ''],
          ['6', <?php echo $vtTempMed[0];?>, <?php echo $vtTempQtd[0];?>],
          ['12', <?php echo $vtTempMed[1];?>, <?php echo $vtTempQtd[1];?>],
          ['18', <?php echo $vtTempMed[2];?>, <?php echo $vtTempQtd[2];?>],
          ['24', <?php echo $vtTempMed[3];?>, <?php echo $vtTempQtd[3];?>],
          ['30', <?php echo $vtTempMed[4];?>, <?php echo $vtTempQtd[4];?>],
          ['36', <?php echo $vtTempMed[5];?>, <?php echo $vtTempQtd[5];?>],
          ['42', <?php echo $vtTempMed[6];?>, <?php echo $vtTempQtd[6];?>],
          ['48', <?php echo $vtTempMed[7];?>, <?php echo $vtTempQtd[7];?>],
          ['54', <?php echo $vtTempMed[8];?>, <?php echo $vtTempQtd[8];?>]
        ]);

        var options = {
          chart: {
            title: 'Desempenho por tempo de casa',
            subtitle: 'Desempenho/N°Funcionários',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('d2'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Acessos'],
          ['<?php echo $vtG6Mes[5]?>',  <?php echo $vtG6Acesso[5]?>],
          ['<?php echo $vtG6Mes[4]?>',  <?php echo $vtG6Acesso[4]?>],
          ['<?php echo $vtG6Mes[3]?>',  <?php echo $vtG6Acesso[3]?>],
          ['<?php echo $vtG6Mes[2]?>',  <?php echo $vtG6Acesso[2]?>],
          ['<?php echo $vtG6Mes[1]?>',  <?php echo $vtG6Acesso[1]?>],
          ['<?php echo $vtG6Mes[0]?>',  <?php echo $vtG6Acesso[0]?>]
        ]);

        var options = {
          title: 'Acessos por mês',
          hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('d3'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ['<?php echo $vtNomeTop10[0]?>', <?php echo $vtMediaTop10[0]?>, "#FF0000"],
        ['<?php echo $vtNomeTop10[1]?>', <?php echo $vtMediaTop10[1]?>, "#FF0000"],
        ['<?php echo $vtNomeTop10[2]?>', <?php echo $vtMediaTop10[2]?>, "#FF6347"],
        ['<?php echo $vtNomeTop10[3]?>', <?php echo $vtMediaTop10[3]?>, "#FF6347"],
        ['<?php echo $vtNomeTop10[4]?>', <?php echo $vtMediaTop10[4]?>, "#FF7F50"],
        ['<?php echo $vtNomeTop10[5]?>', <?php echo $vtMediaTop10[5]?>, "#FFA07A"],
        ['<?php echo $vtNomeTop10[6]?>', <?php echo $vtMediaTop10[6]?>, "#FF8C00"],
        ['<?php echo $vtNomeTop10[7]?>', <?php echo $vtMediaTop10[7]?>, "#FF8C00"],
        ['<?php echo $vtNomeTop10[8]?>', <?php echo $vtMediaTop10[8]?>, "#FFA500"],        
        ['<?php echo $vtNomeTop10[9]?>', <?php echo $vtMediaTop10[9]?>, "color: #F0E68C"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Ranking baixo desempenho no mês",
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("d4"));
      chart.draw(view, options);
	  }
	  </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Líder');
        data.addColumn('number', 'Time');
        data.addColumn('number', 'Registro');
        data.addColumn('number', 'Data');
        data.addColumn('boolean', 'Ok?');
        data.addRows([
          ['Ataíde', parseFloat('<?php echo $a5time[0]?>'), parseFloat('<?php echo $a5count[0]?>'), {v: parseFloat('<?php echo $a5date[0]?>'), f: '<?php echo $a5date[0]?>'}, <?php echo $a5status[0]?>],
          ['Marivalda', parseFloat('<?php echo $a5time[1]?>'), parseFloat('<?php echo $a5count[1]?>'), {v: parseFloat('<?php echo $a5date[1]?>'),   f: '<?php echo $a5date[1]?>'},  <?php echo $a5status[1]?>],
          ['Monara', parseFloat('<?php echo $a5time[2]?>'), parseFloat('<?php echo $a5count[2]?>'), {v: parseFloat('<?php echo $a5date[2]?>'), f: '<?php echo $a5date[2]?>'}, <?php echo $a5status[2]?>],
          ['Thiago', parseFloat('<?php echo $a5time[3]?>'), parseFloat('<?php echo $a5count[3]?>'),  {v: parseFloat('<?php echo $a5date[3]?>'),  f: '<?php echo $a5date[3]?>'},  <?php echo $a5status[3]?>]
        ]);

        var table = new google.visualization.Table(document.getElementById('a5'));

        table.draw(data, {showRowNumber: true, width: '25%', height: '100%'});
      }
    </script>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent animated bounceInDown" src="img/wallpaper/data-science17-min.jpg" />
	  	<div class="section transparencia has-addons is-centered .scrollWrapper" style="margin-left: 10px;">
     		<div class="columns bloco" id="graficos">		
				<div class="column is-mobile hvr-grow-shadow" id="a1"></div>
				<div class="column is-mobile hvr-grow-shadow" id="a2"></div>
				<div class="column is-mobile hvr-grow-shadow" id="a3"></div>
				<div class="column is-mobile hvr-grow-shadow" id="a4"></div>				
			</div>
			<div class="field is-horizontal columns" id="graficos">	<!--<div class="field is-horizontal" id="graficos">-->
				<div class="column bloco is-mobile hvr-wobble-skew" id="b1"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="b2"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="b3"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="b4"></div>
			</div>
			<div class="field is-horizontal columns" id="graficos">
				<div class="column bloco is-mobile hvr-grow-shadow" id="c1"></div>
				<div class="column bloco is-mobile hvr-grow-shadow" id="c2"></div>
				<div class="column bloco is-mobile hvr-float" id="c3"></div>
				<div class="column bloco is-mobile hvr-grow-shadow" id="c4"></div>
			</div>
			<div class="field is-horizontal columns" id="graficos">
				<div class="column bloco is-mobile hvr-bounce-in" id="d1"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="d2"></div>
				<div class="column bloco is-mobile hvr-wobble-to-top-right" id="d3"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="d4"></div>
	  	</div>
      <div class="field is-horizontal columns" id="graficos">
        <div class="column bloco is-mobile" id="a5"></div>
      </div>	  		  	
	</div>	
</body>
</html>