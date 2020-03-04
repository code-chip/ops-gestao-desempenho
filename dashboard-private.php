<?php 
$menuDashboard="is-active";
include('menu.php');
require("query.php");
  $queryReg="SELECT DATE_FORMAT(MAX(REGISTRO),'%d') AS REGISTRO FROM DESEMPENHO WHERE USUARIO_ID=".$_SESSION["userId"];
  $cnx=mysqli_query($phpmyadmin, $queryReg);
  $ultimoRegistro=$cnx->fetch_array();
  if(date('d')>22 && $ultimoRegistro["REGISTRO"]>22){
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
  //DASH DISTRIBUIÇÃO POR ATIVIDADES -- dash-atividades
  $g4="SELECT ATIVIDADE_ID, A.NOME, COUNT(ATIVIDADE_ID) AS VEZES FROM DESEMPENHO D
INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID
WHERE REGISTRO>='".$inicioAnoMesDia."' AND REGISTRO<='".$finalAnoMesDia."' AND USUARIO_ID=".$_SESSION["userId"]."
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
  //DASH DESEMPENHO NA EMPRESA -- dash-mediageral
  $queryMediaGeral="SELECT ROUND(AVG(DESEMPENHO),2) AS MEDIA, REGISTRO FROM DESEMPENHO WHERE USUARIO_ID=".$_SESSION["userId"]." AND PRESENCA_ID NOT IN(3,5) GROUP BY REGISTRO ORDER BY REGISTRO DESC;";
  $x=0;
  $cnx= mysqli_query($phpmyadmin, $queryMediaGeral);
  while($mediaGeral = $cnx->fetch_array()){
    $vtmediaGeral[$x]= $mediaGeral["MEDIA"];
    $x++;       
  }  
  $g41="SELECT NOME, 0 AS VEZES FROM ATIVIDADE WHERE ID NOT IN(".$idsAtiv.");";
  $cnx= mysqli_query($phpmyadmin, $g41);
  if(mysqli_error($phpmyadmin)==null){
    while($G41 = $cnx->fetch_array()){
      $vtG4nome[$x3]= $G41["NOME"];
      $vtG4vezes[$x3]= $G41["VEZES"];
      $x3++;        
    }
  }
  else{
    $vtG4nome[0]= "Nenhuma";
    $vtG4vezes[0]= 20;
  }
  //DASH ACESSOS NO MÊS
  $g6="SELECT SUM(ACESSO) AS ACESSOS, SUBSTRING(ANO_MES,-2, 5) AS MES FROM ACESSO WHERE USUARIO_ID=".$_SESSION["userId"]." GROUP BY ANO_MES ORDER BY ANO_MES DESC LIMIT 4;";
  $cnx=mysqli_query($phpmyadmin, $g6);
  $x=0;
  while ($G6= $cnx->fetch_array()) {
    $vtG6Acesso[$x]=$G6["ACESSOS"];
    $vtG6Mes[$x]=$G6["MES"];
    $x++;
  }
  while($x<5){//PREENCHE OS MESES ANTERIORES COM ZERO P/ GERAR O GRÁFICO.
    $vtG6Acesso[$x]=0;
    $vtG6Mes[$x]=$vtG6Mes[$x-1]-1;
    $x++;
  }
  /*DASH RELAÇÃO FOLGAS E FALTAS*/
  $queryFolgasFaltas="SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-3 month'))."' 
UNION ALL
SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND USUARIO_ID=".$_SESSION["userId"]." AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-3 month'))."'
UNION ALL
SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND USUARIO_ID=".$_SESSION["userId"]." AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-2 month'))."' 
UNION ALL
SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND USUARIO_ID=".$_SESSION["userId"]." AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-2 month'))."' 
UNION ALL
SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND USUARIO_ID=".$_SESSION["userId"]." AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-1 month'))."' 
UNION ALL
SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND USUARIO_ID=".$_SESSION["userId"]." AND DATE_FORMAT(REGISTRO,'%m')='".date('m', strtotime('-1 month'))."' 
UNION ALL
SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND USUARIO_ID=".$_SESSION["userId"]." AND DATE_FORMAT(REGISTRO,'%m')='".date('m')."' 
UNION ALL
SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND USUARIO_ID=".$_SESSION["userId"]." AND DATE_FORMAT(REGISTRO,'%m')='".date('m')."' ";
  $cnx= mysqli_query($phpmyadmin, $queryFolgasFaltas);
  $x=0;
  while($folgasFaltas= $cnx->fetch_array()) {
    $vtFolgasFaltas[$x]=$folgasFaltas["COUNT(*)"];
    $x++;
  }
  /*DASH META ATINGIDA PERDIDA NO MÊS meta-atingida-perdida-mes */
  $queryAtingPerd="SELECT IFNULL(COUNT(*),0) AS ATINGIDA,(SELECT IFNULL(COUNT(*),0) FROM DESEMPENHO WHERE USUARIO_ID=".$_SESSION["userId"]." AND DESEMPENHO<100 AND REGISTRO>='".$inicioAnoMesDia."' AND REGISTRO<='".$finalAnoMesDia."') AS PERDIDA FROM DESEMPENHO WHERE USUARIO_ID=".$_SESSION["userId"]." AND DESEMPENHO>=100 AND REGISTRO>='".$inicioAnoMesDia."' AND REGISTRO<='".$finalAnoMesDia."';";
  $cnx= mysqli_query($phpmyadmin, $queryAtingPerd);
  $x=0;
  $atinPerd= $cnx->fetch_array(); 
  /*DASH DISTRIBUIÇÃO AUSÊNCIA distribuicao-ausencia */
  $queryDistAus="SELECT IFNULL(COUNT(*),0) as QTD, 'Folga' FROM DESEMPENHO WHERE PRESENCA_ID=3 AND USUARIO_ID=".$_SESSION["userId"]."
UNION SELECT IFNULL(COUNT(*),0) AS QTD, 'Falta' FROM DESEMPENHO WHERE PRESENCA_ID=2 AND USUARIO_ID=".$_SESSION["userId"]."
UNION SELECT IFNULL(COUNT(*),0) AS QTD, 'Atestado' FROM DESEMPENHO WHERE PRESENCA_ID=4 AND USUARIO_ID=".$_SESSION["userId"]."
UNION SELECT IFNULL(COUNT(*),0) AS QTD, 'Treinamento' FROM DESEMPENHO WHERE PRESENCA_ID=5 AND USUARIO_ID=".$_SESSION["userId"].";";
  $cnx= mysqli_query($phpmyadmin, $queryDistAus);
  $x=0;
  while ($DistAus= $cnx->fetch_array()) {
    $vtDistAusNome[$x]=$DistAus["Folga"];
    $vtDistAusQtd[$x]=$DistAus["QTD"];
    $x++;
  }
  //DASH RANKING MELHORES DO MÊS - top8
  $querytop8="SELECT USUARIO_ID, AVG(DESEMPENHO) MEDIA FROM DESEMPENHO WHERE REGISTRO>=DATE_SUB('".$anoMes."-21', INTERVAL 1 MONTH) AND REGISTRO<='".$anoMes."-20'
  GROUP BY USUARIO_ID ORDER BY 2 DESC;";
  $x=0;
  $cnx= mysqli_query($phpmyadmin, $querytop8);
  while ($top8= $cnx->fetch_array()) {
    $vtIdTop8[$x]=$top8["USUARIO_ID"];
    $vtMediaTop8[$x]=$top8["MEDIA"];
    $x++;
  }
  $x=0;
  $totalPosicoes= mysqli_num_rows($cnx);
  while ($x<sizeof($vtIdTop8)) {
    if($vtIdTop8[$x]==$_SESSION["userId"] && $x< $totalPosicoes-9){//COMPARA O ID DO USUÁRIO DO VETOR COM USUÁRIO DA SESSÃO.
      $posTop8=$x+1; $z=0;//SALVA A POSIÇÃO DO USUÁRIO.
      while ($z <= 7) {
        $pos=$x+1;
        $vtPosTop8[0]=$_SESSION["nameUser"];
        $vtPosTop8[$z]="Anônimo posição ".$pos;
        $vtMedTop8[$z]=$vtMediaTop8[$x];
        $z++; $x++;
      }
      break;
    }
    else if($x> $totalPosicoes-9){//VERIFICA SE A POSIÇÃO DO USUÁRIO ESTÁ EMTRE AS ÚLTIMAS.
       $z=0;
      while ($z <= 7) {
        if($vtIdTop8[$x]==$_SESSION["userId"]){
            $posTop8=$x+1;//SALVA A POSIÇÃO DO USUÁRIO.
            $vtPosTop8[$z]=$_SESSION["nameUser"];
            $vtMedTop8[$z]=$vtMediaTop8[$x];
            $z++; $x++;
          }
          else{
            $pos=$x+1;          
            $vtPosTop8[$z]="Anônimo posição ".$pos;
            $vtMedTop8[$z]=$vtMediaTop8[$x];
            $z++; $x++;
          }
      }
    }
    else{
      $x++;
    }
  }
  //DASH MEDIA POR ATIVIDADE
  $queryMedAtiv="SELECT ATIVIDADES.MEDIA, ATIVIDADES.Checkout,  ATIVIDADES.ATIVIDADE_ID AS ID, ATIVIDADES.REGISTRO FROM (SELECT IFNULL(ROUND(AVG(DESEMPENHO),2),0) AS MEDIA, 'Checkout', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE USUARIO_ID=50 AND ATIVIDADE_ID=1 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Separação', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE USUARIO_ID=50 AND ATIVIDADE_ID=2 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Embalagem', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE USUARIO_ID=50 AND ATIVIDADE_ID=3 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'PBL', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE USUARIO_ID=50 AND ATIVIDADE_ID=4 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Recebimento', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE USUARIO_ID=50 AND ATIVIDADE_ID=5 GROUP BY 3
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Devolução', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE USUARIO_ID=50 AND ATIVIDADE_ID=6 GROUP BY 3 
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Avarias', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE USUARIO_ID=50 AND ATIVIDADE_ID=7 GROUP BY 3
UNION SELECT ROUND(AVG(DESEMPENHO),0) AS MEDIA, 'Expedição', DATE_FORMAT(REGISTRO,'%m/%y') AS REGISTRO, ATIVIDADE_ID FROM DESEMPENHO WHERE USUARIO_ID=50 AND ATIVIDADE_ID=8 GROUP BY 2) ATIVIDADES ORDER BY REGISTRO DESC, ID";
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
  for($y=0;$y< 2; $y++){
    for($z=0;$z<8;$z++){
      $md[$y][$z]=0;
      if($vtmedAtivId[$z]==$z+1){
        $md[$y][$z]=$vtmedAtivMedia[$yz];
        $mdData[$y][$z]=$vtmedAtivData[$yz];
        $yz++;  
      }
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-widht, initial-scale=1">
  <title>Gestão de Desempenho - Dashboard</title>
  <link rel="stylesheet" href="css/login.css" />
  <link rel="stylesheet" href="css/personal.css" />
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
          title: 'Suas atividades <?php $m=$mes-1; echo "21/".$m." a 20/".$mes;?>',
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
              title: 'Desempenho na empresa'
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
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Sexo', 'Quantidade'],
          ['Atingida',     parseFloat(<?php echo $atinPerd["ATINGIDA"];?>)],
          ['Perdida',     parseFloat(<?php echo $atinPerd["PERDIDA"];?>)]          
        ]);

        var options = {
          title: 'Meta atingida/perdida <?php $m=$mes-1; echo "21/".$m." a 20/".$mes;?>',
          pieHole: 0.7,
        };

        var chart = new google.visualization.PieChart(document.getElementById('meta-atingida-perdida-mes'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Sexo', 'Quantidade'],
          ['<?php echo $vtDistAusNome[0]?>', parseFloat(<?php echo $vtDistAusQtd[0]?>)],
          ['<?php echo $vtDistAusNome[1]?>', parseFloat(<?php echo $vtDistAusQtd[1]?>)],
          ['<?php echo $vtDistAusNome[2]?>', parseFloat(<?php echo $vtDistAusQtd[2]?>)],
          ['<?php echo $vtDistAusNome[3]?>', parseFloat(<?php echo $vtDistAusQtd[3]?>)]          
        ]);

        var options = {
          title: 'Distribuição da Ausência',
          pieHole: 0.3,
        };

        var chart = new google.visualization.PieChart(document.getElementById('distribuicao-ausencia'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ['<?php echo $vtPosTop8[0]?>', <?php echo $vtMedTop8[0]?>, "gold"],
        ['<?php echo $vtPosTop8[1]?>', <?php echo $vtMedTop8[1]?>, "beige"],
        ['<?php echo $vtPosTop8[2]?>', <?php echo $vtMedTop8[2]?>, "silver"],
        ['<?php echo $vtPosTop8[3]?>', <?php echo $vtMedTop8[3]?>, "#b87333"],
        ['<?php echo $vtPosTop8[4]?>', <?php echo $vtMedTop8[4]?>, "#b87333"],
        ['<?php echo $vtPosTop8[5]?>', <?php echo $vtMedTop8[5]?>, "#b87333"],
        ['<?php echo $vtPosTop8[6]?>', <?php echo $vtMedTop8[6]?>, "#b87333"],
        ['<?php echo $vtPosTop8[7]?>', <?php echo $vtMedTop8[7]?>, "#b87333"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Sua posição é <?php echo $posTop8;?> com o desempenho atual",
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("top8"));
      chart.draw(view, options);
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
</head>
<body>
  <div class="hero is-fullheight is-primary has-background">
      <img alt="Fill Murray" class="hero-background is-transparent animated bounceInDown" src="img/wallpaper/data-science17-min.jpg" />
      <div class="section transparencia has-addons is-centered .scrollWrapper" style="margin-left: 10px;">
        <div class="columns bloco" id="graficos">   
        <div class="column is-mobile hvr-grow-shadow" id="dash-atividades"></div>
        <div class="column is-mobile hvr-grow-shadow" id="dash-mediageral"></div>
        <div class="column is-mobile hvr-grow-shadow" id="dash-faltas"></div>
        <div class="column is-mobile hvr-grow-shadow" id="distribuicao-ausencia"></div>        
      </div>
      <div class="field is-horizontal columns" id="graficos">
        <div class="column bloco is-mobile" id="dash-med-desem-ativ"></div>  
      </div>
      <div class="field is-horizontal columns" id="graficos">
        <div class="column bloco is-mobile hvr-bounce-in" id="meta-atingida-perdida-mes"></div>       
        <div class="column bloco is-mobile hvr-bounce-in" id="top8"></div>
        <div class="column bloco is-mobile hvr-wobble-to-top-right" id="dash-acessos-no-mes"></div>        
      </div>      
  </div>  
</body>
</html>