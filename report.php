<?php

$menuAtivo = 'relatorios';
require_once('menu.php');
require_once('model/ReportData.php');

$periodo = trim($_REQUEST['periodo']);
$atividade = trim($_REQUEST['atividade']);
$ordenacao = trim($_REQUEST['ordenacao']);
$meta = trim($_REQUEST['meta']);
$contador = 0;
$totalAlcancado = 0;

$charts = new ReportData();

if ($_SESSION["permissao"] == 1) {
    echo "<script>alert('Usuário sem permissão'); window.location.href='report-private.php'; </script>";
}

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
                <label class="label is-size-7-touch" for="periodo">Período:</label>
            </div>
            <div class="field-body">
                <div class="field is-grouped">
                    <div class="control has-icons-left">
                        <div class="select is-size-7-touch">
                            <select name="periodo" id="saveDate" style="width: 12em">
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
                            <select name="atividade" style="width: 11.7em">
                                <option selected="selected" value="agrupado">Agrupado</option>
                                <option value="separado">Separado</option>
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
                            <select name="ordenacao" style="width: 11.8em">
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
                            <select name="setor" style="width: 12em">
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
                <label for="turno" class="label is-size-7-touch">Turno:</label>
            </div>
            <div class="field-body">
                <div class="field is-grouped">
                    <div class="control has-icons-left">
                        <div class="select is-size-7-touch">
                            <select name="turno" id="salvaTurno" style="width: 12em">
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
                <label class="label is-size-7-touch" for="meta">Meta:</label>
            </div>
            <div class="field-body">
                <div class="field is-grouped">
                    <div class="control has-icons-left">
                        <div class="select is-size-7-touch">
                            <select name='meta' style="width: 12em">
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

    $turno = trim($_REQUEST['turno']);
    $setor = trim($_REQUEST['setor']);

    if ( $periodo != "") {

        $date = date_create($periodo);
        $date = date_format($date, 't/m');

        if ($atividade == "agrupado") {
            $consulta = "SELECT U.NOME, D.USUARIO_ID AS ID, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FALTA, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FOLGA, (SELECT IFNULL(SUM(OCORRENCIA),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS OCORRENCIA, (SELECT IFNULL(SUM(PENALIDADE_TOTAL),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS TOTAL, TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO, CONCAT(DATE_FORMAT('".$periodo."-01','%d/%m'),' a ".$date."') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) DESEMPENHO FROM DESEMPENHO WHERE ANO_MES='".$periodo."' AND PRESENCA_ID NOT IN (3,5) GROUP BY USUARIO_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID WHERE D.USUARIO_ID=B.USUARIO_ID AND ANO_MES='".$periodo."'".$meta." ".$turno." ".$setor." GROUP BY D.USUARIO_ID ORDER BY ".$ordenacao.";";

            $filter = array(
                'month' => $periodo,
                'date' => $date,
                'goal' => $meta,
                'turn' => $turno,
                'sector' => $setor,
                'order' => $ordenacao
            );

            $charts->defineQuery('grouped', $filter);
            $table = $charts->result_array();

            echo $table[0]['NOME'];

        } else {
            $consulta = "SELECT U.NOME, D.USUARIO_ID AS ID, A.NOME AS ATIVIDADE, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FALTA, 
(SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FOLGA, (SELECT IFNULL(SUM(OCORRENCIA),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS OCORRENCIA, (SELECT IFNULL(SUM(PENALIDADE_TOTAL),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS TOTAL, TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO,  
CONCAT(DATE_FORMAT('".$periodo."-01','%d/%m'),' a ".$date."') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) DESEMPENHO,ATIVIDADE_ID FROM DESEMPENHO WHERE ANO_MES='".$periodo."' AND PRESENCA_ID NOT IN (3,5) GROUP BY USUARIO_ID, ATIVIDADE_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID INNER JOIN ATIVIDADE A ON A.ID=B.ATIVIDADE_ID WHERE D.USUARIO_ID=B.USUARIO_ID AND ANO_MES='".$periodo."'".$meta." " .$turno." AND D.ATIVIDADE_ID=B.ATIVIDADE_ID ".$setor." GROUP BY D.USUARIO_ID, D.ATIVIDADE_ID ORDER BY ".$ordenacao.";";
        }

        $cx = mysqli_query($phpmyadmin, "SELECT OPERADOR, EMPRESA, (SELECT ROUND(DESEMPENHO, 2) FROM META_EMPRESA WHERE ANO_MES='" . $periodo . "') AS ALCANCADO FROM META_PESO WHERE ANO_MES='" . $periodo . "';");

        echo $filter['month'];

        $peso = $cx->fetch_array();
        $con = mysqli_query($phpmyadmin, $consulta);

        if (mysqli_num_rows($con) != 0) {
            $x = 0;
            $maior = 0;
            $menor = 1000;
            $totalFaltas = 0;
            $totalFolgas = 0;

            while ($dado = $con->fetch_array()) {
                $vtIdUsuario[$x] = $dado["ID"];
                $vtNome[$x] = $dado["NOME"];
                $vtDesempenho[$x] = $dado["DESEMPENHO"];
                $a2[$x] = $dado["DESEMPENHO"];
                $vtAtividade[$x] = $dado["ATIVIDADE"];
                $vtFalta[$x] = $dado["FALTA"];
                $vtFolga[$x] = $dado["FOLGA"];
                $ocurrence[$x] = $dado["OCORRENCIA"];
                $penaltyTotal[$x] = $dado["TOTAL"];
                $totalAlcancado = $totalAlcancado + $dado["DESEMPENHO"];
                $vtRegistro[$x] = $dado["REGISTRO"];
                $totalFaltas = $totalFaltas + $vtFalta[$x];
                $totalFolgas = $totalFolgas + $vtFolga[$x];

                if ($maior < $vtDesempenho[$x]) {
                    $maior = $vtDesempenho[$x];
                }

                if ($menor > $vtDesempenho[$x] && $vtDesempenho[$x] != 0) {
                    $menor = $vtDesempenho[$x];
                }

                $contador++;
                $x++;
            }

        }

        $charts->defineQuery('chart-a1', null);
        $a1 = $charts->result();

        $charts->defineQuery('chart-a3', $periodo);
        $a3 = $charts->result();

        $charts->defineQuery('chart-a4', null);
        $a4 = $charts->result();

        //$a1 = $charts->converterMatrixToArray($a1);

        //$a1 = $charts->converterArrayToString('|', $a1);
        $a2 = $charts->converterArrayToString('|', $a2);

        foreach ($a4 as $key => $a4s) {
            $a4[$key][0] = $a4s[4] >= $a4s[2] ? 'true' : 'false';

            list($a4[$key][1], $lastName) = explode(' ', $a4s[1],2);
        }

    }
    if ($contador != 0): ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <div class="field is-horizontal" id="graficos">
        <div class="column is-mobile" id="dash-desempenho"></div>
        <div class="column is-mobile" id="dash-variacao"></div>
        <div class="column is-mobile" id="dash-top5"></div>
        <div class="column is-mobile" id="a5"></div>
    </div>
    <hr/>
    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth is-size-7-touch">
        <tr class='is-selected'><?php
            echo "<td>Resultado: " . sizeof($vtNome) . "</td>	
			<td>Falta's: " . $totalFaltas . "</td>
			<td>Folga's: " . $totalFolgas . "</td>
			<td>Menor: " . $menor."%" . "</td>
			<td>Media: " . round($totalAlcancado / $contador, 2)."%" . "</td>
			<td>Maior: " . $maior."%" . "</td>
			<td>Empresa: " . $peso["ALCANCADO"]."%" . "</td>";	?>
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
            <?php if ($atividade == "separado") { echo "<th width='14'>Atividade</th>"; } ?>
            <th width="14">Desempenho</th>
            <th width="4">Final</th>
            <th width="40">Período</th>
        </tr><?php

        for ( $i = 0; $i < sizeof($vtNome); $i++ ) {
            $z = $i;
            $registro = 1;

            while ($vtNome[$z] == $vtNome[$z+1]) {
                $registro++;
                $repeat=$registro;
                $z++;
            }

            if ($repeat > 0) {
                $repeat--;
            }

            $y = $i+1;
            echo "<tr>";
            echo "<td>" . $y . "</td>";
            echo "<td>" . $vtNome[$i] . "</td>";

            if ($registro > 1 && $repeat != 0 && $mesclaa == false) {
                echo "<td rowspan='" . $registro . "'><a href='report-detailed.php?periodo=" . $periodo . "&idUsuario=" . $vtIdUsuario[$i] . "' target='_blank'><button class='button is-primary is-size-7-touch is-fullwidth'>Consultar</button></a></td>";
                $mesclaa = true;
            }

            if ($repeat == 0 && $vtNome[$i-1] != $vtNome[$i]) {
                echo "<td width='1'><a href='report-detailed.php?periodo=" . $periodo . "&idUsuario=" . $vtIdUsuario[$i] . "' target='_blank'><button class='button is-primary is-size-7-touch is-fullwidth'>Consultar</button></a></td>";
                $mesclaa = false;
            }

            if ($registro > 1 && $repeat != 0 && $mescla == false) {
                echo "<td class='joinLines' rowspan=" . $registro . ">" . $vtFalta[$i] . "</td>";
                echo "<td class='joinLines' rowspan=" . $registro . ">" . $vtFolga[$i] . "</td>";
                echo "<td class='joinLines' rowspan=" . $registro . ">" . $ocurrence[$i] . "</td>";
                $mescla = true;
            }

            if ( $repeat == 0 && $vtNome[$i-1] != $vtNome[$i]) {
                echo "<td>" . $vtFalta[$i] . "</td>";
                $mescla = false;
                echo "<td width='4'>" . $vtFolga[$i] . "</td>";
                echo "<td>" . $ocurrence[$i] . "</td>";
            }

            if ($atividade == "separado"){
                echo "<td>" . $vtAtividade[$i] . "</td>";
            }

            echo "<td>" . $vtDesempenho[$i] . "%" . "</td>";
            echo "<td>" . round((($vtDesempenho[$i] / 100) * $peso["OPERADOR"]) + (($peso["ALCANCADO"] / 100) * $peso["EMPRESA"])-$penaltyTotal[$i], 2)."%" . "</td>";
            echo "<td style='max-width:800px;'>" . $vtRegistro[$i] . "</td>";

            if ($vtNome[$i] != $vtNome[$i+1] && $repeat == 0 && $mescla == true) {
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
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
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
        var chart = new google.visualization.AreaChart(document.getElementById('dash-desempenho'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawBasic);
    function drawBasic() {
        var a2 = '<?php echo $a2; ?>'.split('|').map(Number)
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'X');
        data.addColumn('number', 'Desempenho');
        data.addRows([
            [0, a2[0]],   [1, a2[1]],   [2, a2[2]],   [3, a2[3]],   [4, a2[4]],   [5, a2[5]],   [6, a2[6]],
            [7, a2[7]],   [8, a2[8]],   [9, a2[9]],   [10, a2[10]], [11, a2[11]], [12, a2[12]], [13, a2[13]],
            [14, a2[14]], [15, a2[15]], [16, a2[16]], [17, a2[17]], [18, a2[18]], [19, a2[19]], [20, a2[19]],
            [21, a2[21]], [22, a2[22]], [23, a2[23]], [24, a2[24]], [25, a2[25]], [26, a2[26]], [27, a2[27]],
            [28, a2[28]], [29, a2[29]], [30, a2[30]], [31, a2[31]], [32, a2[32]], [33, a2[33]], [34, a2[34]],
            [35, a2[35]], [36, a2[36]], [37, a2[37]], [38, a2[38]], [39, a2[39]], [40, a2[40]], [41, a2[41]],
            [42, a2[42]], [43, a2[43]], [44, a2[44]], [45, a2[45]], [46, a2[46]], [47, a2[47]], [48, a2[48]],
            [49, a2[49]], [50, a2[50]], [51, a2[51]], [52, a2[52]], [53, a2[53]], [54, a2[54]], [55, a2[55]],
            [56, a2[56]], [57, a2[57]], [58, a2[58]], [59, a2[59]], [60, a2[60]], [61, a2[61]], [62, a2[62]],
            [63, a2[63]], [64, a2[64]], [65, a2[65]], [66, a2[66]], [67, a2[67]], [68, a2[68]], [69, a2[69]],
            [70, a2[70]], [71, a2[71]], [72, a2[72]], [73, a2[73]], [74, a2[74]], [75, a2[75]], [76, a2[76]],
            [77, a2[77]], [78, a2[78]], [79, a2[79]], [80, a2[80]], [81, a2[81]], [82, a2[82]], [83, a2[83]],
            [84, a2[84]], [85, a2[85]], [86, a2[86]], [87, a2[87]], [88, a2[88]], [89, a2[89]], [90, a2[90]],
            [91, a2[91]], [92, a2[92]]
        ]);

        var options = {
            hAxis: {
                title: 'Operadores'
            },
            vAxis: {
                title: 'Variação do desempenho'
            }
        };
        var chart = new google.visualization.LineChart(document.getElementById('dash-variacao'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
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
        var chart = new google.visualization.ColumnChart(document.getElementById("dash-top5"));
        chart.draw(view, options);
    }
</script>
<script type="text/javascript">
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

        var table = new google.visualization.Table(document.getElementById('a5'));


        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
    }
</script>
<?php

endif;

if ($contador == 0 && isset($_GET["filtro"]) != null) {
    echo "<script>alert('Nenhum resultado encontrao com o filtro aplicado!')</script>";
}

?>
</body>
</html>