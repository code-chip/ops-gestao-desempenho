<style>
.transparencia {
     filter:alpha(opacity=80);
     opacity: 0.8;
     -moz-opacity:0.8;
     -webkit-opacity:0.8;
}
.bloco{ 
    -webkit-box-shadow: 20px -14px 5px rgba(50, 50, 50, 0.77);
    -moz-box-shadow:    20px -14px 5px rgba(50, 50, 50, 0.77);
    box-shadow:         20px -14px 5px rgba(50, 50, 50, 0.77);
}
</style>
<?php 
$menuDashboard="is-active";
include('menu.php');
require("query.php");
  if(date('d')>22){
    $anoMes=date('Y-m', strtotime('+1 month'));
    $mes=date('m', strtotime('+1 month'));
    $inicioAnoMesDia=date('Y-m-21');
    $finalAnoMesDia=date('Y-m-20', strtotime('+1 month'));
  }
  else{
    $anoMes=date('Y-m');
    $mes=date('m');
    $inicioAnoMesDia=date('Y-m-21', strtotime('-1 month'));
    $finalAnoMesDia=date('Y-m-20');
  }
  //DASH MEDIA GERAL
  $queryMediaGeral="SELECT ROUND(AVG(DESEMPENHO),2) AS MEDIA, REGISTRO FROM DESEMPENHO GROUP BY REGISTRO ORDER BY REGISTRO DESC;";
	$x=0;
	$cnx= mysqli_query($phpmyadmin, $queryMediaGeral);
	//echo mysqli_error($phpmyadmin);
	while($mediaGeral = $cnx->fetch_array()){
		$vtmediaGeral[$x]= $mediaGeral["MEDIA"];
		$x++;				
	}
	$g4="SELECT ATIVIDADE_ID, A.NOME, COUNT(ATIVIDADE_ID) AS VEZES FROM DESEMPENHO D
INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID
WHERE REGISTRO>='".$inicioAnoMesDia."' AND REGISTRO<='".$finalAnoMesDia."'
GROUP BY ATIVIDADE_ID";
	$x3=0;
  $idsAtiv="";
	$cnx= mysqli_query($phpmyadmin, $g4);
	echo mysqli_error($phpmyadmin);
	while($G4 = $cnx->fetch_array()){
		$vtG4nome[$x3]= $G4["NOME"];
		$vtG4vezes[$x3]= $G4["VEZES"];
    if($x3==0){
      $idsAtiv=$idsAtiv."".$G4["ATIVIDADE_ID"];
    }
    else{
      $idsAtiv=$idsAtiv.",".$G4["ATIVIDADE_ID"];
    }    
		$x3++;				
	}
  $g41="SELECT NOME, 0 AS VEZES FROM ATIVIDADE WHERE ID NOT IN(".$idsAtiv.");";
  $cnx= mysqli_query($phpmyadmin, $g41);
  while($G41 = $cnx->fetch_array()){
    $vtG4nome[$x3]= $G41["NOME"];
    $vtG4vezes[$x3]= $G41["VEZES"];
    $x3++;        
  }
	$g6="SELECT SUM(ACESSO) AS ACESSOS, SUBSTRING(ANO_MES,-2, 5) AS MES FROM ACESSO GROUP BY ANO_MES ORDER BY ANO_MES DESC LIMIT 4;";
	$cnx=mysqli_query($phpmyadmin, $g6);
	$x=0;
	while ($G6= $cnx->fetch_array()) {
		$vtG6Acesso[$x]=$G6["ACESSOS"];
    $vtG6Mes[$x]=$G6["MES"];
		$x++;
	}
  /*DASH RELAÇÃO FOLGAS E FALTAS P03*/
  $queryFolgasFaltas="SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-3 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-3 month'))."'
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-2 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-2 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-1 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-1 month'))."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND DATE_FORMAT(REGISTRO,'%m')='".date('m')."' 
UNION ALL SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND DATE_FORMAT(REGISTRO,'%m')='".date('m')."' ";
  $cnx= mysqli_query($phpmyadmin, $queryFolgasFaltas);
  $x=0;
  while($folgasFaltas= $cnx->fetch_array()) {
    $vtFolgasFaltas[$x]=$folgasFaltas["COUNT(*)"];
    $x++;
  }
  /*DASH SEXO*/
  $querySexo="SELECT COUNT(*) AS QTD FROM USUARIO GROUP BY SEXO ORDER BY SEXO DESC;";
  $cnx= mysqli_query($phpmyadmin, $querySexo);
  $x=0;
  while ($sexo= $cnx->fetch_array()) {
    $vtQtd[$x]=$sexo["QTD"];
    $x++;
  }
  /*DASH SEXO POR TURNO P04*/
  $querySexoTurno="SELECT T.NOME, SEXO, COUNT(*) AS QTD FROM USUARIO INNER JOIN TURNO T ON T.ID=USUARIO.TURNO_ID
WHERE TURNO_ID IN(1,2) GROUP BY TURNO_ID, SEXO ORDER BY TURNO_ID, SEXO DESC;";
  $cnx= mysqli_query($phpmyadmin, $querySexoTurno);
  $x=0;
  while ($sexoTurno= $cnx->fetch_array()) {
    $vtTurno[$x]=$sexoTurno["NOME"];
    $vtTurno[$x]=$vtTurno[$x]." ".$sexoTurno["SEXO"];
    $vtQtdTurno[$x]=$sexoTurno["QTD"];
    $x++;
  }
  //DASH COMPARATIVO ENTRE TURNOS - dash-turnos. P05
  $queryDifTurnos="SELECT AVG(DESEMPENHO) MEDIA, REGISTRO, DATE_FORMAT(REGISTRO, '%d') AS DIA FROM DESEMPENHO WHERE USUARIO_TURNO_ID IN(1,2) AND PRESENCA_ID NOT IN (3,5) GROUP BY USUARIO_TURNO_ID, REGISTRO ORDER BY REGISTRO DESC, USUARIO_TURNO_ID;";
  $cnx= mysqli_query($phpmyadmin, $queryDifTurnos);
  $x=0;
  while ($compTurno= $cnx->fetch_array()) {
    $vtcompTurMed[$x]=$compTurno["MEDIA"];
    $vtcompTurReg[$x]=$compTurno["REGISTRO"];
    $vtcompTurDia[$x]=$compTurno["DIA"];
    $x++;
  }
  $x=0;
  $y=0;
  while($x<sizeof($vtcompTurMed)) {//VERIFICA SE HÁ REGISTROS NOS DOIS TURNOS NO MESMO DIA P/ F.
    if($vtcompTurReg[$x]==$vtcompTurReg[$x+1]){
      $turMat[$y]=$vtcompTurMed[$x];
      $turVes[$y]=$vtcompTurMed[$x+1];
      $turDia[$y]=$vtcompTurDia[$x];
      $x++; $y++;
    }
    else{
      $x++;
    }
  }
  //DASH MEDIA POR ATIVIDADES NO MÊS P06//
  $queryMedAtiv="SELECT ATIVIDADES.MEDIA, ATIVIDADES.Checkout, ATIVIDADES.ATIVIDADE_ID AS ID, ATIVIDADES.REGISTRO FROM (SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 'Checkout', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE USUARIO_ID=50 AND ATIVIDADE_ID=1 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Separação', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE ATIVIDADE_ID=2 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Embalagem', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE ATIVIDADE_ID=3 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'PBL', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE ATIVIDADE_ID=4 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Recebimento', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE ATIVIDADE_ID=5 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Devolução', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE ATIVIDADE_ID=6 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Avarias', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE ATIVIDADE_ID=7 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Expedição', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE ATIVIDADE_ID=8 GROUP BY 2) ATIVIDADES ORDER BY REGISTRO DESC, ID ";
  $x=0;
  $cnx=mysqli_query($phpmyadmin, $queryMedAtiv);
  while ($medAtiv=$cnx->fetch_array()) {
    $vtmedAtivMedia[$x]=$medAtiv["MEDIA"];
    $vtmedAtivAtividade[$x]=$medAtiv["Chechout"];
    $vtmedAtivId[$x]=$medAtiv["ID"];
    $vtmedAtivData[$x]=$medAtiv["REGISTRO"];
    $x++;
  }
  $yz=0;
  for($y=0;$y< 2; $y++){//LAÇO P/ PREENCHER INFORMAÇÕES DE 2 MESES.
    for($z=0;$z<8;$z++){//LAÇO P/ PREENCHER ATÉ 8 ATIVIDADES.
      $md[$y][$z]=0;//INICIA MATRIZ COM ZERO.
      if($vtmedAtivId[$z]==$z+1){//VERIFICA SE O ID DA ATIVIDADE É O MESMO DA POSIÇÃO A SER ARMAZENADA.
        $md[$y][$z]=$vtmedAtivMedia[$yz];
        $mdData[$y][$z]=$vtmedAtivData[$yz];
        $yz++;  
      }
    }
  }
  //DASH RANKING MELHORES DO MÊS - top8
  $querytop8="SELECT U.NOME, ROUND(AVG(DESEMPENHO),2) MEDIA FROM DESEMPENHO 
  INNER JOIN USUARIO U ON U.ID=USUARIO_ID
  WHERE PRESENCA_ID NOT IN(3,5) AND REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$anoMes."-20'
  GROUP BY USUARIO_ID ORDER BY MEDIA DESC LIMIT 9;";
  $x=0;
  $cnx= mysqli_query($phpmyadmin, $querytop8);
  while ($top8= $cnx->fetch_array()) {
    $vtNomeTop8[$x]=$top8["NOME"];
    $vtMediaTop8[$x]=$top8["MEDIA"];
    $x++;
  }
  //DASH RANKING BAIXO DESEMPENHO MÊS - top10-piores
  $querytop10="SELECT U.NOME, ROUND(AVG(DESEMPENHO),2) MEDIA FROM DESEMPENHO 
  INNER JOIN USUARIO U ON U.ID=USUARIO_ID
  WHERE PRESENCA_ID NOT IN(3,5) AND REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$anoMes."-20'
  GROUP BY USUARIO_ID ORDER BY MEDIA LIMIT 11;";
  $x=0;
  $cnx= mysqli_query($phpmyadmin, $querytop10);
  while ($top10= $cnx->fetch_array()) {
    $vtNomeTop10[$x]=$top10["NOME"];
    $vtMediaTop10[$x]=$top10["MEDIA"];
    $x++;
  }
  //DASH META ATINGIDA PERDIDA - meta-pacman
  $querypacman="SELECT COUNT(*) DESEMPENHO, DATE_FORMAT(REGISTRO, '%d/%m') AS REGISTRO FROM DESEMPENHO WHERE DESEMPENHO>=100 AND REGISTRO=(SELECT MAX(REGISTRO) FROM DESEMPENHO) UNION ALL SELECT COUNT(*) DESEMPENHO, DATE_FORMAT(REGISTRO, '%d/%m') AS REGISTRO FROM DESEMPENHO WHERE DESEMPENHO<100 AND REGISTRO=(SELECT MAX(REGISTRO) FROM DESEMPENHO);";
  $x=0;
  $cnx= mysqli_query($phpmyadmin, $querypacman);
  while ($pacman= $cnx->fetch_array()) {
    $vtPacMan[$x]=$pacman["DESEMPENHO"];
    $vtPacManData[$x]=$pacman["REGISTRO"];     
    $x++;
  }
  //DASH EXPEDIÇÃO DE CAIXAS E VINHOS.
  $queryCaixas="select ROUND(SUM(ALCANCADO)/3,0) as CAIXAS from DESEMPENHO where ATIVIDADE_ID=3 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 4 MONTH) and REGISTRO<=DATE_SUB('".$anoMes."-20', INTERVAL 3 MONTH) union select ROUND(SUM(ALCANCADO)/3,0) as CAIXAS from DESEMPENHO  where ATIVIDADE_ID=3 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 3 MONTH) and REGISTRO<=DATE_SUB('".$anoMes."-20', INTERVAL 2 MONTH) union select ROUND(SUM(ALCANCADO)/3,0) as CAIXAS from DESEMPENHO  where ATIVIDADE_ID=3 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 2 MONTH) and REGISTRO<=DATE_SUB('".$anoMes."-20', INTERVAL 1 MONTH) union select ROUND(SUM(ALCANCADO)/3,0) as CAIXAS from DESEMPENHO  where ATIVIDADE_ID=3 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 1 MONTH) and REGISTRO<='".$anoMes."-20'";
  $queryVinhos="select ROUND(SUM(ALCANCADO)/3+(select SUM(ALCANCADO)/10 as PBL from DESEMPENHO  where ATIVIDADE_ID=4 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 4 MONTH) and REGISTRO<=DATE_SUB('".$anoMes."-21', INTERVAL 3 MONTH)),0) as GARRAFAS from DESEMPENHO  where ATIVIDADE_ID=1 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 4 MONTH) and REGISTRO<=DATE_SUB('".$anoMes."-21', INTERVAL 3 MONTH)
union select ROUND(SUM(ALCANCADO)/3+(select SUM(ALCANCADO)/10 as PBL from DESEMPENHO  where ATIVIDADE_ID=4 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 3 MONTH) and REGISTRO<=DATE_SUB('".$anoMes."-21', INTERVAL 2 MONTH)),0) as GARRAFAS from DESEMPENHO  where ATIVIDADE_ID=1 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 3 MONTH) and REGISTRO<=DATE_SUB('".$anoMes."-21', INTERVAL 2 MONTH)
union select ROUND(SUM(ALCANCADO)/3+(select SUM(ALCANCADO)/10 as PBL from DESEMPENHO  where ATIVIDADE_ID=4 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 2 MONTH) and REGISTRO<=DATE_SUB('".$anoMes."-21', INTERVAL 1 MONTH)),0) as GARRAFAS from DESEMPENHO  where ATIVIDADE_ID=1 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 2 MONTH) and REGISTRO<=DATE_SUB('".$anoMes."-21', INTERVAL 1 MONTH) union select ROUND(SUM(ALCANCADO)/3+(select SUM(ALCANCADO)/10 as PBL from DESEMPENHO  where ATIVIDADE_ID=4 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 1 MONTH) and REGISTRO<='".$anoMes."-20'),0) as GARRAFAS from DESEMPENHO  where ATIVIDADE_ID=1 and REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 1 MONTH) and REGISTRO<='".$anoMes."-20'";
  $x=0;
  $cnx= mysqli_query($phpmyadmin, $queryCaixas);
  while ($caixasVinhos= $cnx->fetch_array()) {
    $vtCaiVin[0][$x]=$caixasVinhos["CAIXAS"];
    $x++;
  }
  $x=0;
  $cnx= mysqli_query($phpmyadmin, $queryVinhos);
  while ($caixasVinhos= $cnx->fetch_array()) {
    $vtCaiVin[1][$x]=$caixasVinhos["GARRAFAS"];
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
  //DASH DESEMPENHO POR TEMPO DE CASA dash-tempo-de-casa
  $queryTempoCasa="SELECT DATEDIFF(DATE_FORMAT(CURDATE(),'%Y-%m-%d'), U.EFETIVACAO)TEMPODECASA, U.NOME, IFNULL((SELECT AVG(DESEMPENHO) FROM DESEMPENHO WHERE USUARIO_ID=U.ID),100) AS MEDIA FROM USUARIO U WHERE CARGO_ID IN(1,2,3,13,14,15) AND SITUACAO<>'Desligado' ORDER BY TEMPODECASA;";
  $x=0; $diasInicio=0; $diasFim=90;
  $cnx=mysqli_query($phpmyadmin, $queryTempoCasa);
  while ($tempoCasa= $cnx->fetch_array()){
    if($tempoCasa["TEMPODECASA"] >= $diasInicio && $tempoCasa["TEMPODECASA"]<=$diasFim){
      $vtMediaTempoCasa[$x]=$vtMediaTempoCasa[$x]+$tempoCasa["TEMPODECASA"];
      $vtQtdTempodeCasa[$x]=$vtQtdTempodeCasa[$x]+1;
    }
    else if($diasFim==720){
      $vtMediaTempoCasa[$x]=$vtMediaTempoCasa[$x]+$tempoCasa["TEMPODECASA"];
      $vtQtdTempodeCasa[$x]=$vtQtdTempodeCasa[$x]+1;
    }
    else{
      $diasInicio=$diasInicio+90;
      $diasFim=$diasFim+90;
      $x++;
      $vtMediaTempoCasa[$x]=$vtMediaTempoCasa[$x]+$tempoCasa["TEMPODECASA"];
      $vtQtdTempodeCasa[$x]=$vtQtdTempodeCasa[$x]+1;
    }
  }
  //echo $vtMediaTempoCasa[0]/$vtQtdTempodeCasa[0];
  //echo sizeof($vtQtdTempodeCasa);
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
          title: 'Distribuição atividades <?php $m=$mes-1; echo "21/".$m." a 20/".$mes;?>',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('dash-atividades'));
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
        var chart = new google.visualization.LineChart(document.getElementById('dash-mediageral'));
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

        var chart = new google.charts.Bar(document.getElementById('dash-faltas'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript">
    	google.charts.load('current', {packages: ['corechart', 'line']});
		google.charts.setOnLoadCallback(drawLineColors);

		function drawLineColors() {
		    var data = new google.visualization.DataTable();
		    data.addColumn('number', 'X');
		    data.addColumn('number', 'Matutino');
		    data.addColumn('number', 'Vespertino');

		    data.addRows([
          [<?php echo $turDia[10]?>, <?php echo $turMat[10]?>, <?php echo $turVes[10]?>],
          [<?php echo $turDia[9]?>, <?php echo $turMat[9]?>, <?php echo $turVes[9]?>], [<?php echo $turDia[8]?> ,<?php echo $turMat[8]?>, <?php echo $turVes[8]?>],
          [<?php echo $turDia[7]?>, <?php echo $turMat[7]?>, <?php echo $turVes[7]?>],   [<?php echo $turDia[6]?>, <?php echo $turMat[6]?>, <?php echo $turVes[6]?>],
          [<?php echo $turDia[5]?>, <?php echo $turMat[5]?>, <?php echo $turVes[5]?>],  [<?php echo $turDia[4]?>, <?php echo $turMat[4]?>, <?php echo $turVes[4]?>],
          [<?php echo $turDia[3]?>, <?php echo $turMat[3]?>, <?php echo $turVes[3]?>],  [<?php echo $turDia[2]?>, <?php echo $turMat[2]?>, <?php echo $turVes[2]?>],
		      [<?php echo $turDia[1]?>, <?php echo $turMat[1]?>, <?php echo $turVes[1]?>], [<?php echo $turDia[0]?>, <?php echo $turMat[0]?>, <?php echo $turVes[0]?>]
		    ]);

		    var options = {
		    	hAxis: {
		        	title: 'Comparativo entre turnos, últimos 11 registros no mesmo dia.'
		        },
		        vAxis: {
		        	title: 'Média de Desempenho'
		        },
		        colors: ['#a52714', '#097138']
		    };
		    	var chart = new google.visualization.LineChart(document.getElementById('dash-turnos'));
		      	chart.draw(data, options);
		    }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Checkout', 'Separação', 'Caixas', 'PBL', 'Recebimento','Devolução'],
          ['<?php echo $mdData[1][0]?>', <?php echo $md[1][0];?>, <?php echo $md[1][1];?>, <?php echo $md[1][2];?>, <?php echo $md[1][3];?>, <?php echo $md[1][4];?>, <?php echo $md[1][5];?>],
          ['<?php echo $mdData[0][0]?>', <?php echo $md[0][0];?>, <?php echo $md[0][1];?>, <?php echo $md[0][2];?>, <?php echo $md[0][3];?>, <?php echo $md[0][4];?>, <?php echo $md[0][5];?>]          
        ]);

        var options = {
          title : 'Média de desempenho por atividade',
          vAxis: {title: 'Desempenho'},
          hAxis: {title: 'Mês'},
          seriesType: 'bars',
          series: {6: {type: 'line'}}
        };
        var chart = new google.visualization.ComboChart(document.getElementById('dash-med-desem-ativ'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Avarias', 'Separação', 'Caixas', 'Checkout', 'PBL', 'Recebimento'],
          ['<?php echo $vtData3PrincAtiv[0][4]?>',  165,      138,         122,             99,           105,      114.6],
          ['<?php echo $vtData3PrincAtiv[0][3]?>',  135,      120,        99,             128,          88,      108],
          ['<?php echo $vtData3PrincAtiv[0][2]?>',  157,      167,        87,             107,           97,      123],
          ['<?php echo $vtData3PrincAtiv[0][1]?>',  139,      110,        115,             128,           115,      109.4],
          ['<?php echo $vtData3PrincAtiv[0][0]?>',  136,      101,         114,             126,          106,      109.6]
        ]);

        var options = {
          title : 'Média de desempenho por atividade',
          vAxis: {title: 'Desempenho'},
          hAxis: {title: 'Mês'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('dash-comp-atividades'));
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

        var chart = new google.visualization.PieChart(document.getElementById('sexo'));
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

        var chart = new google.visualization.PieChart(document.getElementById('sexo-turno'));
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
      var chart = new google.visualization.ColumnChart(document.getElementById("top8"));
      chart.draw(view, options);
	  }
	  </script>
  	<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Desempenho', 'Funcionários'],
          ['Acima de 160', 4], ['95 a 99', 30], ['120 a 130', 5],
          ['100 a 119', 20], ['89 a 70', 5], ['131 a 159', 4],
          ['90 a 94', 38], ['59 a 69', 5.5], ['Abaixo de 58', 3],          
        ]);

        var options = {
          title: 'Divisão de funcionários por desempenho no mês',
          legend: 'none',
          pieSliceText: 'label',
          slices: {  4: {offset: 0.2},
                    12: {offset: 0.3},
                    14: {offset: 0.4},
                    15: {offset: 0.5},
          },
        };

        var chart = new google.visualization.PieChart(document.getElementById('div-desempenho'));
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
        var chart = new google.visualization.PieChart(document.getElementById('meta-pacman'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
    	google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Caixas', 'Vinhos'],
          ['<?php echo $mes-3;?>', <?php echo $vtCaiVin[0][3]?>, <?php echo $vtCaiVin[1][3]?>],
          ['<?php echo $mes-2;?>', <?php echo $vtCaiVin[0][2]?>, <?php echo $vtCaiVin[1][2]?>],
          ['<?php echo $mes-1;?>', <?php echo $vtCaiVin[0][1]?>, <?php echo $vtCaiVin[1][1]?>],
          ['<?php echo $mes;?>', <?php echo $vtCaiVin[0][0]?>, <?php echo $vtCaiVin[1][0]?>]
        ]);
        var options = {
          chart: {
            title: 'Estimativa de expedição Caixas/Vinhos',
            //subtitle: 'Caixas, Garrafas: 09-11',
          },
          bars: 'vertical',
          vAxis: {format: ''},
          bar: {groupWidth: "85%"},
          //height: 400,
          colors: ['#FF0000', '#800000']
        };
        var chart = new google.charts.Bar(document.getElementById('caixas-vinhos'));
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
    

        var chart = new google.visualization.AreaChart(document.getElementById('3atividades-principais'));
        chart.draw(data, options_stacked);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mẽs', 'Registros', 'Atualizações'],
          ['05',  1000,      20],
          ['06',  1170,      60],
          ['07',  660,       28],
          ['08',  1030,      40]
        ]);

        var options = {
          title: 'Registros do período',
          hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('teste'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Meses', '', ''],
          ['3', 114, 2],
          ['6', 125, 7],
          ['9', 119, 9],
          ['12', 103, 5],
          ['15', 99, 20],
          ['18', 105, 43],
          ['21', 103, 30],
          ['24', 98, 27]
        ]);

        var options = {
          chart: {
            title: 'Desempenho por tempo de casa',
            subtitle: 'Desempenho/Funcionários',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('dash-tempo-de-casa'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Acessos'],
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

        var chart = new google.visualization.AreaChart(document.getElementById('dash-acessos-no-mes'));
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
      var chart = new google.visualization.ColumnChart(document.getElementById("top10-piores"));
      chart.draw(view, options);
	  }
	  </script>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent animated bounceInDown" src="img/wallpaper/data-science17-min.jpg" />
	  	<div class="section transparencia has-addons is-centered .scrollWrapper" style="margin-left: 10px;">
	  		<?php if($_SESSION["permissao"]>1):{?>
     		<div class="columns bloco" id="graficos">		
				<div class="column is-mobile hvr-grow-shadow" id="dash-atividades"></div>
				<div class="column is-mobile hvr-grow-shadow" id="dash-mediageral"></div>
				<div class="column is-mobile hvr-grow-shadow" id="dash-faltas"></div>
				<div class="column is-mobile hvr-grow-shadow" id="sexo-turno"></div>				
			</div>
			<div class="field is-horizontal columns" id="graficos">	<!--<div class="field is-horizontal" id="graficos">-->
				<div class="column bloco is-mobile hvr-wobble-skew" id="dash-turnos"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="dash-med-desem-ativ"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="sexo"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="top8"></div>
			</div>
			<div class="field is-horizontal columns" id="graficos">
				<div class="column bloco is-mobile hvr-grow-shadow" id="div-desempenho"></div>
				<div class="column bloco is-mobile hvr-grow-shadow" id="meta-pacman"></div>
				<div class="column bloco is-mobile hvr-grow-shadow" id="caixas-vinhos"></div>
				<div class="column bloco is-mobile hvr-grow-shadow" id="3atividades-principais"></div>
			</div>
			<div class="field is-horizontal columns" id="graficos">
				<div class="column bloco is-mobile hvr-bounce-in" id="teste"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="dash-tempo-de-casa"></div>
				<div class="column bloco is-mobile hvr-wobble-to-top-right" id="dash-acessos-no-mes"></div>
				<div class="column bloco is-mobile hvr-bounce-in" id="top10-piores"></div>
			</div>	
			<?php } endif;?>			
	  	</div>	  		  	
	</div>	
</body>
</html>