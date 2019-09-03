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
session_start();
include('login-check.php');
$menuConfiguracao="is-active";
include('menu.php');
require("query.php");

$x3=0;
			$cnxG3= mysqli_query($phpmyadmin, $g3);
			echo mysqli_error($phpmyadmin);
			while($G3 = $cnxG3->fetch_array()){
				$vtG3nome[$x3]= $G3["NOME"];
				$vtG3desempenho[$x3]= $G3["MAXIMO"];
				$vtG3menor[$x3]= $G3["MINIMO"];		
				$x3++;				
			}
			$g4="SELECT A.NOME, COUNT(ATIVIDADE_ID) AS VEZES FROM DESEMPENHO D
INNER JOIN ATIVIDADE A ON A.ID=D.ATIVIDADE_ID
GROUP BY ATIVIDADE_ID";
			$x3=0;
			$cnx= mysqli_query($phpmyadmin, $g4);
			echo mysqli_error($phpmyadmin);
			while($G4 = $cnx->fetch_array()){
				$vtG4nome[$x3]= $G4["NOME"];
				$vtG4vezes[$x3]= $G4["VEZES"];
				$x3++;				
			}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Dashboard</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/login.css" />
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">-->
	<link rel="stylesheet" href="css/bulma.min.css"/>
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
          title: 'Minhas atividades',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('dash-atividades'));
        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawTitleSubtitle);
	function drawTitleSubtitle() {
    	var data = google.visualization.arrayToDataTable([
        ['Operador', 'avg', 'min'],
        ['<?php echo $vtG3nome[0]?>', parseFloat('<?php echo $vtG3desempenho[0]?>'), parseFloat('<?php echo $vtG3menor[0]?>')],
        ['<?php echo $vtG3nome[1]?>', parseFloat('<?php echo $vtG3desempenho[1]?>'), parseFloat('<?php echo $vtG3menor[1]?>')],
        ['<?php echo $vtG3nome[2]?>', parseFloat('<?php echo $vtG3desempenho[2]?>'), parseFloat('<?php echo $vtG3menor[2]?>')],
        ['<?php echo $vtG3nome[3]?>', parseFloat('<?php echo $vtG3desempenho[3]?>'), parseFloat('<?php echo $vtG3menor[3]?>')]        
      	]);
      	var materialOptions = {
        	chart: {
         		title: 'Ranking mensal dos operadores',
          		subtitle: 'Top 4 desempenho do mês '
        	},
        	hAxis: {
          		title: 'Total Alcançado',
          		minValue: 0,
        	},
        	vAxis: {
          		title: 'Ranking'
        	},
        	bars: 'horizontal'
      	};
      	var materialChart = new google.charts.Bar(document.getElementById('dash-ranking'));
      	materialChart.draw(data, materialOptions);
    }
	</script>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Folgas', 'Faltas'],
          ['<?php echo strftime('%h', strtotime("-2 months"))?>', 7, 5],
          ['<?php echo strftime('%h', strtotime("-1 months"))?>', 2, 10],
          ['<?php echo strftime('%h')?>', 7, 5],
          ['<?php echo strftime('%h', strtotime("+1 months"))?>', 4, 5]
        ]);

        var options = {
          chart: {
            title: 'Relação ausência',
            subtitle: 'Folgas e faltas do período <?php echo strftime('%h', strtotime("-2 months"))?> a <?php echo strftime('%h', strtotime("+1 months"))?>',
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
		    data.addColumn('number', 'Vespetino');

		    data.addRows([
		        [0, 95, 80],    [1, 90, 105],   [2, 123, 115],  [3, 107, 90],   [4, 108, 100],  [5, 90, 50],
		        [6, 100, 103],   [7, 127, 109],  [8, 103, 125],  [9, 99, 92],  [10, 102, 104], [11, 105, 97],
		        [12, 92, 102], [13, 89, 92], [14, 95, 104], [15, 98, 109], [16, 104, 106], [17, 108, 100],
		        [18, 92, 94], [19, 90, 86], [20, 98, 99], [21, 105, 99], [22, 106, 99], [23, 100, 120],
		        [24, 100, 102], [25, 99, 103], [26, 99, 99], [27, 101, 103], [28, 100, 101], [29, 103, 105],
		        [30, 105, 107]
		    ]);

		    var options = {
		    	hAxis: {
		        	title: 'Variação entre turnos em 60 dias'
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
          ['Mês', 'Avarias', 'Separação', 'Caixas', 'Checkout', 'PBL', 'Recebimento'],
          ['<?php echo strftime('%h', strtotime("-4 months"))?>',  165,      938,         522,             998,           450,      614.6],
          ['<?php echo strftime('%h', strtotime("-3 months"))?>',  135,      1120,        599,             1268,          288,      682],
          ['<?php echo strftime('%h', strtotime("-2 months"))?>',  157,      1167,        587,             807,           397,      623],
          ['<?php echo strftime('%h', strtotime("-1 months"))?>',  139,      1110,        615,             968,           215,      609.4],
          ['<?php echo strftime('%h')?>',  136,      691,         629,             1026,          366,      569.6]
        ]);

        var options = {
          title : 'Desempenho por atividade',
          vAxis: {title: 'Cups'},
          hAxis: {title: 'Month'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('dash-comp-atividades'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      	google.charts.load("current", {packages:["corechart"]});
      	google.charts.setOnLoadCallback(drawChart);
      	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Sexo', 'Quantidade'],
          ['Masculino',     11],
          ['Feminino',     2]          
        ]);

        var options = {
          title: 'Porcentual de funcionários Homens/Mulheres',
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
          ['Matutino F',     11],
          ['Matutino M',     2],
          ['Vespetino F',     2],
          ['Vespetino F',     2]          
        ]);

        var options = {
          title: 'Porcentual Masculino/Feminino por turno',
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
        ["Aline Nascimento", 110.99, "#b87333"],
        ["Leo Geison", 111.04, "#b87333"],
        ["Daniela Vieira", 115.90, "#b87333"],
        ["Lwcyano Will", 120.54, "#b87333"],
        ["Lorrayene Costa", 139.94, "#b87333"],
        ["Adriana Marques", 140.49, "silver"],
        ["Gabriel Assis", 157.30, "gold"],
        ["Lucas Souza", 160.45, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Top 8 melhores do mês",
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
          ['Acima de 160', 4], ['90 a 99', 30], ['120 a 130', 5],
          ['100 a 119', 20], ['89 a 70', 5], ['131 a 159', 4],
          ['Kannada', 38], ['Kashmiri', 5.5], ['Abaixo de 69', 3],          
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
          ['Meta atiginda', 75],
          ['Meta perdida', 25]
        ]);

        var options = {
        	title: 'Meta atiginda/perdida',
          legend: 'none',
          pieSliceText: 'label',
          pieStartAngle: 135,
          tooltip: { trigger: 'none' },
          slices: {
            0: { color: 'yellow' },
            1: { color: 'transparent' }
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('meta'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
    	google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
		  var data = google.visualization.arrayToDataTable([
		    ['Generation', 'Descendants'],
		    [1980, 1], [1985, 3], [1990, 5], [1991, 13]
		 ]);

		  var options = {
		    title: 'Descendants by Generation',
		    hAxis: {title: 'Generation', minValue: 0, maxValue: 3},
		    vAxis: {title: 'Descendants', minValue: 0, maxValue: 2010},
		    trendlines: {
		      0: {
		        type: 'exponential',
		        color: 'green',
		        visibleInLegend: true,
		      }
		    }
		  };

		  var chart = new google.visualization.ScatterChart(document.getElementById('idade'));
		  chart.draw(data, options);
		}
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Dia', 'Checkout', 'Separação','Caixas',],
          ['<?php echo date('d',strtotime("-3 day"))?>',  140,      99,103],
          ['<?php echo date('d',strtotime("-2 day"))?>',  110,      103,100],
          ['<?php echo date('d',strtotime("-1 day"))?>',  98,       108,113],
          ['<?php echo date('d')?>',  117,      120,99]
        ]);

          var options_stacked = {
          	title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          isStacked: true,
          legend: {position: 'top', maxLines: 3},
          vAxis: {minValue: 0, ticks: [0, .3, .6, .9, 1]}
        };
    

        var chart = new google.visualization.AreaChart(document.getElementById('atividades-15dias'));
        chart.draw(data, options_stacked);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses','Perdas'],
          ['2016',  1000,      400,100],
          ['2017',  1170,      460,90],
          ['2018',  660,       1120,49],
          ['2019',  1030,      540,90]
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('teste'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2013',  1000,      400],
          ['2014',  1170,      460],
          ['2015',  660,       1120],
          ['2016',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('teste2'));
        chart.draw(data, options);
      }
    </script>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent"src="img/wallpaper/data-science17-min.jpg" />
	  	<div class="section transparencia has-addons is-centered .scrollWrapper" style="margin-left: 10px;">
	  		<?php if($_SESSION["permissao"]>1):{?>
     		<div class="columns bloco" id="graficos">		
				<div class="column is-mobile" id="dash-atividades"></div>
				<div class="column is-mobile" id="dash-ranking"></div>
				<div class="column is-mobile" id="dash-faltas"></div>
				<div class="column is-mobile" id="sexo-turno"></div>				
			</div>
			<div class="field is-horizontal columns" id="graficos">	<!--<div class="field is-horizontal" id="graficos">-->
				<div class="column bloco is-mobile" id="dash-turnos"></div>
				<div class="column bloco is-mobile" id="dash-comp-atividades"></div>
				<div class="column bloco is-mobile" id="sexo"></div>
				<div class="column bloco is-mobile" id="top8"></div>
			</div>
			<div class="field is-horizontal columns" id="graficos">
				<div class="column bloco is-mobile" id="div-desempenho"></div>
				<div class="column bloco is-mobile" id="meta"></div>
				<div class="column bloco is-mobile" id="idade"></div>
				<div class="column bloco is-mobile" id="atividades-15dias"></div>
			</div>
			<div class="field is-horizontal columns" id="graficos">
				<div class="column bloco is-mobile" id="teste"></div>
				<div class="column bloco is-mobile" id="teste2"></div>
				<div class="column bloco is-mobile" id="idade"></div>
				<div class="column bloco is-mobile" id="atividades-15dias"></div>
			</div>	
			<?php } endif;?>			
	  	</div>	  		  	
	</div>	
</body>
</html>