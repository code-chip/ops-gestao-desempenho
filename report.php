<?php

$menuAtivo = 'relatorios';
require_once('menu.php');
require_once('model/ReportData.php');

if ($_SESSION["permissao"] == 1) {
    echo "<script>alert('Usuário sem permissão'); window.location.href='report-private.php'; </script>";
}

$charts = new ReportData();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestão de Desempenho - Relatório Gestão</title>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script type="text/javascript">
        $(window).on("load", onPageLoad);
        function onPageLoad() {
            initListeners();
            restoreSavedValues();
        }
        function initListeners() {
            $("#saveDate").on("change", function() {
                var value = $(this).val();
                localStorage.setItem("saveDate", value);
            });
        }
        function restoreSavedValues() {
            var storedValue = localStorage.getItem("saveDate");
            $("#saveDate").val(storedValue);
        }
        $('#submitQuery').button().click(function(){
            $('#form1').submit();
        });
    </script>
    <style type="text/css">
        .joinLines{
            vertical-align:center;
            line-height:500%;
        }
    </style>
</head>
<body>
<span id="topo"></span>
<section class="section">
    <form id="form1" action="report.php" method="POST" >
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label is-size-7-touch" for="month">Período:</label>
            </div>
            <div class="field-body">
                <div class="field is-grouped">
                    <div class="control has-icons-left">
                        <div class="select is-size-7-touch">
                            <select name="month" id="saveDate" style="width: 12em">
                                <?php echo $charts->mountSelect( 'month'); ?>
                            </select>
                            <span class="icon is-small is-left">
							<i class="fas fa-calendar-alt"></i>
						</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field-label is-normal"><!--SELEÇÃO ATIVIDADE-->
                <label class="label is-size-7-touch">Atividade:</label>
            </div>
            <div class="field-body">
                <div class="field is-grouped">
                    <div class="control has-icons-left">
                        <div class="select is-size-7-touch">
                            <select name="activity" style="width: 11.7em">
                                <option selected="selected" value="grouped">Agrupado</option>
                                <option value="separate">Separado</option>
                            </select>
                            <span class="icon is-small is-left">
								<i class="fas fa-diagnoses"></i>
							</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field-label is-normal"><!--SELEÇÃO ORDENAÇÃO-->
                <label for="ordenacao" class="label is-size-7-touch">Ordem:</label>
            </div>
            <div class="field-body">
                <div class="field is-grouped">
                    <div class="control has-icons-left">
                        <div class="select is-size-7-touch">
                            <select name="order" style="width: 11.8em">
                                <option value="NOME">Nome</option>
                                <option value="DESEMPENHO DESC, NOME">Desempenho</option>
                            </select>
                            <span class="icon is-small is-left">
								<i class="fas fa-chart-line"></i>
							</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label is-normal"><!--SELEÇÃO SETOR-->
                <label for="ordenacao" class="label is-size-7-touch">Setor:</label>
            </div>
            <div class="field-body">
                <div class="field is-grouped">
                    <div class="control has-icons-left">
                        <div class="select is-size-7-touch">
                            <select name="sector" style="width: 12em">
                                <option selected="selected" value="">Todos</option>
                                <?php echo $charts->mountSelect( 'sector'); ?>
                            </select>
                            <span class="icon is-small is-left">
								<i class="fas fa-door-open"></i>
							</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field-label is-normal"><!--SELEÇÃO TURNO-->
                <label for="turn" class="label is-size-7-touch">Turno:</label>
            </div>
            <div class="field-body">
                <div class="field is-grouped">
                    <div class="control has-icons-left">
                        <div class="select is-size-7-touch">
                            <select name="turn" id="salvaTurno" style="width: 12em">
                                <option selected="selected"value="">Todos</option>
                                <?php echo $charts->mountSelect( 'turn'); ?>
                            </select>
                            <span class="icon is-small is-left">
								<i class="fas fa-clock"></i>
							</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field-label is-normal"><!--SELEÇÃO META-->
                <label class="label is-size-7-touch" for="goal">Meta:</label>
            </div>
            <div class="field-body">
                <div class="field is-grouped">
                    <div class="control has-icons-left">
                        <div class="select is-size-7-touch">
                            <select name='goal' style="width: 12em">
                                <option selected="selected"value="">Ambos</option>
                                <option value="AND B.DESEMPENHO>=100">Atingida :D</option>
                                <option value="AND B.DESEMPENHO<100">Perdida ;(</option>
                            </select>
                            <span class="icon is-small is-left">
							   		<i class="fas fa-bullseye"></i>
							   	</span>
                        </div>
                    </div>
                    <div class="control">
                        <!--<button type="submit" class="button is-primary">Filtrar</button>-->
                        <input name="filtro" type="submit" class="button is-primary is-size-7-touch" id="submitQuery" value="Filtrar"/>
                    </div>
                </div>
            </div>
        </div>
    </form><!--FINAL DO FORMULÁRIO-->
    <?php
    if (isset($_POST['filtro']) && $_POST['month'] != "") {
        $filter = array(
            'month' => $_REQUEST['month'],
            'date' => date_format(date_create($_REQUEST['month']), 't/m'),
            'activity' => $_REQUEST['activity'],
            'goal' => $_REQUEST['goal'],
            'turn' => $_REQUEST['turn'],
            'sector' => $_REQUEST['sector'],
            'order' => $_REQUEST['order']
        );

        $charts->defineQuery($filter['activity'], $filter);
        $table = $charts->result_array();
        $count = count($table);

        if ($count != 0) {
            $weigth = $charts->result_array($charts->defineQuery('weight', $filter['month']));
            $totalReached = 0;
            $bigger = 0;
            $smaller = 1000;
            $totalAbsences = 0;
            $totalClearances = 0;

            foreach ($table as $key => $item) {
                $totalReached = $totalReached + $item['DESEMPENHO'];
                $a2[$key] = $item['DESEMPENHO'];

                if ($table[$key]['ID'] != $table[$key-1]['ID']) {
                    $totalAbsences = $totalAbsences + $item['FALTA'];
                    $totalClearances = $totalClearances + $item['FOLGA'];
                }

                $bigger = $bigger < $item['DESEMPENHO'] ? $item['DESEMPENHO'] : $bigger;
                $smaller = $smaller > $item['DESEMPENHO'] && $item['DESEMPENHO'] != 0 ? $item['DESEMPENHO'] : $smaller;
            }

            $charts->defineQuery('chart-a1', null);
            $a1 = $charts->result();

            $charts->defineQuery('chart-a3', $filter['month']);
            $a3 = $charts->result();

            $charts->defineQuery('chart-a4', null);
            $a4 = $charts->result();

            $a2 = $charts->converterArrayToString('|', $a2);

            foreach ($a4 as $key => $a4s) {
                $a4[$key][0] = $a4s[4] >= $a4s[2] ? 'true' : 'false';
                $a4[$key][3] = date_format(date_create($a4s[3]), 'd/m');

                list($a4[$key][1], $lastName) = explode(' ', $a4s[1],2);
            }
        }
        else{
            echo "<script>alert('Nenhum resultado encontrao com o filtro aplicado!')</script>";
        }
    }

    if ($count != 0): ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <div class="field is-horizontal" id="graficos">
        <div class="column is-mobile" id="chart-a1"></div>
        <div class="column is-mobile" id="chart-a2"></div>
        <div class="column is-mobile" id="chart-a3"></div>
        <div class="column is-mobile" id="chart-a4"></div>
    </div>
    <hr/>
    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">
        <tr class='is-selected'><?php
            echo "<td>Resultado: " . $count . "</td>	
			<td>Falta's: " . $totalAbsences . "</td>
			<td>Folga's: " . $totalClearances . "</td>
			<td>Menor: " . $smaller."%" . "</td>
			<td>Media: " . round($totalReached / $count, 2)."%" . "</td>
			<td>Maior: " . $bigger."%" . "</td>
			<td>Empresa: " . $weigth[0]["ALCANCADO"]."%" . "</td>";	?>
        </tr>
    </table>
    <table class="table__wrapper table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch scrollWrapper"style="$table-row-active-background-color:hsl(171, 100%, 41%);">
        <tr>
            <th width="1">N°</th>
            <th width="200">Funcionário</th>
            <th>Detalhes</th>
            <th width="4">Falta's</th>
            <th width="4">Folga's</th>
            <th width="4">Pena</th>
            <?php if ($filter['activity'] == 'separate') { echo "<th width='14'>Atividade</th>"; } ?>
            <th width="14">Desempenho</th>
            <th width="4">Final</th>
            <th width="40">Período</th>
        </tr><?php

        for ( $i = 0; $i < $count; $i++ ) {
            $z = $i;
            $registro = 1;

            while ($table[$z]['NOME'] == $table[$z+1]['NOME']) {
                $registro++;
                $repeat = $registro;
                $z++;
            }

            if ($repeat > 0) {
                $repeat--;
            }

            $y = $i + 1;
            echo "<tr>";
            echo "<td>" . $y . "</td>";
            echo "<td>" . $table[$i]['NOME'] . "</td>";

            if ($registro > 1 && $repeat != 0 && $mesclaa == false) {
                echo "<td rowspan='" . $registro . "'><a href='report-detailed.php?periodo=" . $filter['month'] . "&idUsuario=" . $table[$i]['ID'] . "' target='_blank'><button class='button is-primary is-size-7-touch is-fullwidth'>Consultar</button></a></td>";
                $mesclaa = true;
            }

            if ($repeat == 0 && $table[$i-1]['NOME'] != $table[$i]['NOME']) {
                echo "<td width='1'><a href='report-detailed.php?periodo=" . $filter['month'] . "&idUsuario=" . $table[$i]['ID'] . "' target='_blank'><button class='button is-primary is-size-7-touch is-fullwidth'>Consultar</button></a></td>";
                $mesclaa = false;
            }

            if ($registro > 1 && $repeat != 0 && $mescla == false) {
                echo "<td class='joinLines' rowspan=" . $registro . ">" . $table[$i]['FALTA'] . "</td>";
                echo "<td class='joinLines' rowspan=" . $registro . ">" . $table[$i]['FOLGA'] . "</td>";
                echo "<td class='joinLines' rowspan=" . $registro . ">" . $table[$i]['OCORRENCIA'] . "</td>";
                $mescla = true;
            }

            if ( $repeat == 0 && $table[$i-1]['NOME'] != $table[$i]['NOME']) {
                echo "<td>" . $table[$i]['FALTA'] . "</td>";
                $mescla = false;
                echo "<td width='4'>" . $table[$i]['FOLGA'] . "</td>";
                echo "<td>" . $table[$i]['OCORRENCIA'] . "</td>";
            }

            if ($filter['activity'] == "separate") {
                echo "<td>" . $table[$i]['ATIVIDADE'] . "</td>";
            }

            echo "<td>" . $table[$i]['DESEMPENHO'] . "%" . "</td>";
            echo "<td>" . round((($table[$i]['DESEMPENHO'] / 100) * $weigth[0]["OPERADOR"]) + (($weigth[0]["ALCANCADO"] / 100) * $weigth[0]["EMPRESA"])-$table[$i]['TOTAL'], 2)."%" . "</td>";
            echo "<td style='max-width:800px;'>" . $table[$i]['REGISTRO'] . "</td>";

            if ($table[$i]['NOME'] != $table[$i+1]['NOME'] && $repeat == 0 && $mescla == true) {
                $mescla = false;
                $mesclaf = false;
                $mesclaa = false;
            }

            echo "</tr>";
        }

        ?></table>
    <a href="#topo">
        <div class="field is-grouped is-grouped-centered">
            <button class="button is-primary is-fullwidth is-size-7-touch">Ir Ao Topo</button>
        </div>
    </a>
</section>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChartA1);
    function drawChartA1() {
        var data = google.visualization.arrayToDataTable([
            ['Mês', 'avg', 'min'],
            ['<?php echo strftime('%h', strtotime("-3 months"))?>',  parseFloat('<?php echo $a1[0][0]?>'), parseFloat('<?php echo $a1[0][1]?>')],
            ['<?php echo strftime('%h', strtotime("-2 months"))?>',  parseFloat('<?php echo $a1[1][0]?>'), parseFloat('<?php echo $a1[1][1]?>')],
            ['<?php echo strftime('%h', strtotime("-1 months"))?>',  parseFloat('<?php echo $a1[2][0]?>'), parseFloat('<?php echo $a1[2][1]?>')],
            ['<?php echo strftime('%h')?>',  parseFloat('<?php echo $a1[3][0]?>'), parseFloat('<?php echo $a1[3][1]?>')]
        ]);
        var options = {
            title: 'Desempenho da Empresa',
            hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };
        var chartA1 = new google.visualization.AreaChart(document.getElementById('chart-a1'));
        chartA1.draw(data, options);
    }

    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawBasic);
    function drawBasic() {
        var a2 = '<?php echo $a2; ?>'.split('|').map(Number)
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'X');
        data.addColumn('number', 'Desempenho');
        data.addRows([
            [0, a2[0]],   [1, a2[1]],   [2, a2[2]],   [3, a2[3]],   [4, a2[4]],   [5, a2[5]],   [6, a2[6]], [7, a2[7]],
            [8, a2[8]],   [9, a2[9]],   [10, a2[10]], [11, a2[11]], [12, a2[12]], [13, a2[13]], [14, a2[14]], [15, a2[15]],
            [16, a2[16]], [17, a2[17]], [18, a2[18]], [19, a2[19]], [20, a2[19]], [21, a2[21]], [22, a2[22]], [23, a2[23]],
            [24, a2[24]], [25, a2[25]], [26, a2[26]], [27, a2[27]], [28, a2[28]], [29, a2[29]], [30, a2[30]], [31, a2[31]],
            [32, a2[32]], [33, a2[33]], [34, a2[34]], [35, a2[35]], [36, a2[36]], [37, a2[37]], [38, a2[38]], [39, a2[39]],
            [40, a2[40]], [41, a2[41]], [42, a2[42]], [43, a2[43]], [44, a2[44]], [45, a2[45]], [46, a2[46]], [47, a2[47]],
            [48, a2[48]], [49, a2[49]], [50, a2[50]], [51, a2[51]], [52, a2[52]], [53, a2[53]], [54, a2[54]], [55, a2[55]],
            [56, a2[56]], [57, a2[57]], [58, a2[58]], [59, a2[59]], [60, a2[60]], [61, a2[61]], [62, a2[62]], [63, a2[63]],
            [64, a2[64]], [65, a2[65]], [66, a2[66]], [67, a2[67]], [68, a2[68]], [69, a2[69]], [70, a2[70]], [71, a2[71]],
            [72, a2[72]], [73, a2[73]], [74, a2[74]], [75, a2[75]], [76, a2[76]], [77, a2[77]], [78, a2[78]], [79, a2[79]],
            [80, a2[80]], [81, a2[81]], [82, a2[82]], [83, a2[83]], [84, a2[84]], [85, a2[85]], [86, a2[86]], [87, a2[87]],
            [88, a2[88]], [89, a2[89]], [90, a2[90]], [91, a2[91]], [92, a2[92]]
        ]);

        var options = {
            hAxis: {
                title: 'Operadores'
            },
            vAxis: {
                title: 'Variação do desempenho'
            }
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart-a2'));
        chart.draw(data, options);
    }

    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Density", { role: "style" } ],
            ['<?php echo $a3[0][0]?>', parseFloat('<?php echo $a3[0][1]?>'), "gold"],
            ['<?php echo $a3[1][0]?>', parseFloat('<?php echo $a3[1][1]?>'), "silver"],
            ['<?php echo $a3[2][0]?>', parseFloat('<?php echo $a3[2][1]?>'), "#b87333"],
            ['<?php echo $a3[3][0]?>', parseFloat('<?php echo $a3[3][1]?>'), "#b87333"],
            ['<?php echo $a3[4][0]?>', parseFloat('<?php echo $a3[4][1]?>'), "color: #e5e4e2"]
        ]);
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            { calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation" },
            2]);
        var options = {
            title: "Top 5 melhores do mês",
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("chart-a3"));
        chart.draw(view, options);
    }

    google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawTable);
    function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Líder',);
        data.addColumn('number', 'Time');
        data.addColumn('number', 'Reg.');
        data.addColumn('number', 'Data');
        data.addColumn('boolean', 'Ok?');
        data.addRows([
            ['<?php echo $a4[0][1]?>', parseFloat('<?php echo $a4[0][2]?>'), parseFloat('<?php echo $a4[0][4]?>'), {v: parseFloat('<?php echo $a4[0][3]?>'), f: '<?php echo $a4[0][3]?>'}, <?php echo $a4[0][0]?>],
            ['<?php echo $a4[1][1]?>', parseFloat('<?php echo $a4[1][2]?>'), parseFloat('<?php echo $a4[1][4]?>'), {v: parseFloat('<?php echo $a4[1][3]?>'),   f: '<?php echo $a4[1][3]?>'},  <?php echo $a4[1][0]?>],
            ['<?php echo $a4[2][1]?>', parseFloat('<?php echo $a4[2][2]?>'), parseFloat('<?php echo $a4[2][4]?>'), {v: parseFloat('<?php echo $a4[2][3]?>'), f: '<?php echo $a4[2][3]?>'}, <?php echo $a4[2][0]?>],
            ['<?php echo $a4[3][1]?>', parseFloat('<?php echo $a4[3][2]?>'), parseFloat('<?php echo $a4[3][4]?>'),  {v: parseFloat('<?php echo $a4[3][3]?>'),  f: '<?php echo $a4[3][3]?>'},  <?php echo $a4[3][0]?>]
        ]);
        var table = new google.visualization.Table(document.getElementById('chart-a4'));
        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
    }
</script>
<?php endif; ?>
</body>
</html>