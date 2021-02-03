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

if ($_SESSION["permissao"] == 1) {
    echo "<script>alert('Usuário sem permissão'); window.location.href='report-private.php'; </script>";
}

?><!DOCTYPE html>
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
                                <option selected="selected" value="<?php echo date('Y-m')?>"><?php echo date('m/Y', strtotime("+1 months"))?></option>
                                <option value="<?php echo date('Y-m', strtotime("-1 months"))?>"><?php echo date('m/Y')?></option>
                                <option value="<?php echo date('Y-m', strtotime("-2 months"))?>"><?php echo date('m/Y', strtotime("-1 months"))?></option>
                                <option value="<?php echo date('Y-m', strtotime("-3 months"))?>"><?php echo date('m/Y', strtotime("-2 months"))?></option>
                                <option value="<?php echo date('Y-m', strtotime("-4 months"))?>"><?php echo date('m/Y', strtotime("-3 months"))?></option>
                                <option value="<?php echo date('Y-m', strtotime("-5 months"))?>"><?php echo date('m/Y', strtotime("-4 months"))?></option>
                                <option value="<?php echo date('Y-m', strtotime("-6 months"))?>"><?php echo date('m/Y', strtotime("-5 months"))?></option>
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
                                <option selected="selected" value="">Todos</option><?php
                                $con = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM SETOR WHERE SITUACAO = 'Ativo'");
                                while($setor = $con->fetch_array()){
                                    echo "<option value='AND SETOR_ID=" . $setor["ID"] . "'>" . $setor["NOME"] . "</option>";
                                }?>
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
                                <option selected="selected"value="">Todos</option><?php
                                $con = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM TURNO WHERE SITUACAO='Ativo'");
                                while($turno = $con->fetch_array()){
                                    echo "<option value='AND TURNO_ID=" . $turno["ID"] ."'>" . $turno["NOME"] . "</option>";
                                }?>
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
        } else {
            $consulta = "SELECT U.NOME, D.USUARIO_ID AS ID, A.NOME AS ATIVIDADE, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FALTA, 
(SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS FOLGA, (SELECT IFNULL(SUM(OCORRENCIA),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS OCORRENCIA, (SELECT IFNULL(SUM(PENALIDADE_TOTAL),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$periodo."') AS TOTAL, TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO,  
CONCAT(DATE_FORMAT('".$periodo."-01','%d/%m'),' a ".$date."') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) DESEMPENHO,ATIVIDADE_ID FROM DESEMPENHO WHERE ANO_MES='".$periodo."' AND PRESENCA_ID NOT IN (3,5) GROUP BY USUARIO_ID, ATIVIDADE_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID INNER JOIN ATIVIDADE A ON A.ID=B.ATIVIDADE_ID WHERE D.USUARIO_ID=B.USUARIO_ID AND ANO_MES='".$periodo."'".$meta." " .$turno." AND D.ATIVIDADE_ID=B.ATIVIDADE_ID ".$setor." GROUP BY D.USUARIO_ID, D.ATIVIDADE_ID ORDER BY ".$ordenacao.";";
        }

        $cx = mysqli_query($phpmyadmin, "SELECT OPERADOR, EMPRESA, (SELECT ROUND(DESEMPENHO, 2) FROM META_EMPRESA WHERE ANO_MES='" . $periodo . "') AS ALCANCADO FROM META_PESO WHERE ANO_MES='" . $periodo . "';");

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

        $charts = new ReportData();
        $charts->defineQuery('chart-a1', null);
        $a1 = $charts->result();

        $charts->defineQuery('chart-a3', $periodo);
        $a3 = $charts->result();

        $charts->defineQuery('chart-a4', null);
        $a4 = $charts->result();

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
    var t = '<?php echo $teste; ?>';
    var p = parseFloat('<?php echo $fava?>');
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
        var data = new google.visualization.DataTable();''
        var o;
        data.addColumn('number', 'X');
        data.addColumn('number', 'Desempenho');
        data.addRows([
            [0, parseFloat('<?php echo $vtDesempenho[0]?>')],   [1, parseFloat('<?php echo $vtDesempenho[1]?>')],  [2, parseFloat('<?php echo $vtDesempenho[2]?>')],
            [3, parseFloat('<?php echo $vtDesempenho[3]?>')],  [4, parseFloat('<?php echo $vtDesempenho[4]?>')],  [5, parseFloat('<?php echo $vtDesempenho[5]?>')],
            [6, parseFloat('<?php echo $vtDesempenho[6]?>')],  [7, parseFloat('<?php echo $vtDesempenho[7]?>')],  [8, parseFloat('<?php echo $vtDesempenho[8]?>')],
            [9, parseFloat('<?php echo $vtDesempenho[9]?>')],  [10, parseFloat('<?php echo $vtDesempenho[10]?>')], [11, parseFloat('<?php echo $vtDesempenho[11]?>')],
            [12, parseFloat('<?php echo $vtDesempenho[12]?>')], [13, parseFloat('<?php echo $vtDesempenho[13]?>')], [14, parseFloat('<?php echo $vtDesempenho[14]?>')],
            [15, parseFloat('<?php echo $vtDesempenho[15]?>')], [16, parseFloat('<?php echo $vtDesempenho[16]?>')], [17, parseFloat('<?php echo $vtDesempenho[17]?>')],
            [18, parseFloat('<?php echo $vtDesempenho[18]?>')], [19, parseFloat('<?php echo $vtDesempenho[19]?>')], [20, parseFloat('<?php echo $vtDesempenho[19]?>')],
            [21, parseFloat('<?php echo $vtDesempenho[21]?>')], [22, parseFloat('<?php echo $vtDesempenho[22]?>')], [23, parseFloat('<?php echo $vtDesempenho[23]?>')],
            [24, parseFloat('<?php echo $vtDesempenho[24]?>')], [25, parseFloat('<?php echo $vtDesempenho[25]?>')], [26, parseFloat('<?php echo $vtDesempenho[26]?>')],
            [27, parseFloat('<?php echo $vtDesempenho[27]?>')], [28, parseFloat('<?php echo $vtDesempenho[28]?>')], [29, parseFloat('<?php echo $vtDesempenho[29]?>')],
            [30, parseFloat('<?php echo $vtDesempenho[30]?>')], [31, parseFloat('<?php echo $vtDesempenho[31]?>')], [32, parseFloat('<?php echo $vtDesempenho[32]?>')],
            [33, parseFloat('<?php echo $vtDesempenho[33]?>')], [34, parseFloat('<?php echo $vtDesempenho[34]?>')], [35, parseFloat('<?php echo $vtDesempenho[35]?>')],
            [36, parseFloat('<?php echo $vtDesempenho[36]?>')], [37, parseFloat('<?php echo $vtDesempenho[37]?>')], [38, parseFloat('<?php echo $vtDesempenho[38]?>')],
            [39, parseFloat('<?php echo $vtDesempenho[39]?>')], [40, parseFloat('<?php echo $vtDesempenho[40]?>')], [41, parseFloat('<?php echo $vtDesempenho[41]?>')],
            [42, parseFloat('<?php echo $vtDesempenho[42]?>')], [43, parseFloat('<?php echo $vtDesempenho[43]?>')], [44, parseFloat('<?php echo $vtDesempenho[44]?>')],
            [45, parseFloat('<?php echo $vtDesempenho[45]?>')], [46, parseFloat('<?php echo $vtDesempenho[46]?>')], [47, parseFloat('<?php echo $vtDesempenho[47]?>')],
            [48, parseFloat('<?php echo $vtDesempenho[48]?>')], [49, parseFloat('<?php echo $vtDesempenho[49]?>')], [50, parseFloat('<?php echo $vtDesempenho[50]?>')],
            [51, parseFloat('<?php echo $vtDesempenho[51]?>')], [52, parseFloat('<?php echo $vtDesempenho[52]?>')], [53, parseFloat('<?php echo $vtDesempenho[53]?>')],
            [54, parseFloat('<?php echo $vtDesempenho[54]?>')], [55, parseFloat('<?php echo $vtDesempenho[55]?>')], [56, parseFloat('<?php echo $vtDesempenho[56]?>')],
            [57, parseFloat('<?php echo $vtDesempenho[57]?>')], [58, parseFloat('<?php echo $vtDesempenho[58]?>')], [59, parseFloat('<?php echo $vtDesempenho[59]?>')],
            [60, parseFloat('<?php echo $vtDesempenho[60]?>')], [61, parseFloat('<?php echo $vtDesempenho[61]?>')], [62, parseFloat('<?php echo $vtDesempenho[62]?>')],
            [63, parseFloat('<?php echo $vtDesempenho[63]?>')], [64, parseFloat('<?php echo $vtDesempenho[64]?>')], [65, parseFloat('<?php echo $vtDesempenho[65]?>')],
            [66, parseFloat('<?php echo $vtDesempenho[66]?>')], [67, parseFloat('<?php echo $vtDesempenho[67]?>')], [68, parseFloat('<?php echo $vtDesempenho[68]?>')],
            [69, parseFloat('<?php echo $vtDesempenho[69]?>')], [70, parseFloat('<?php echo $vtDesempenho[70]?>')], [71, parseFloat('<?php echo $vtDesempenho[71]?>')],
            [72, parseFloat('<?php echo $vtDesempenho[72]?>')], [73, parseFloat('<?php echo $vtDesempenho[73]?>')], [74, parseFloat('<?php echo $vtDesempenho[74]?>')],
            [75, parseFloat('<?php echo $vtDesempenho[75]?>')], [76, parseFloat('<?php echo $vtDesempenho[76]?>')], [77, parseFloat('<?php echo $vtDesempenho[77]?>')],
            [78, parseFloat('<?php echo $vtDesempenho[78]?>')], [79, parseFloat('<?php echo $vtDesempenho[79]?>')], [80, parseFloat('<?php echo $vtDesempenho[80]?>')],
            [81, parseFloat('<?php echo $vtDesempenho[81]?>')], [82, parseFloat('<?php echo $vtDesempenho[82]?>')], [83, parseFloat('<?php echo $vtDesempenho[83]?>')],
            [84, parseFloat('<?php echo $vtDesempenho[84]?>')], [85, parseFloat('<?php echo $vtDesempenho[85]?>')], [86, parseFloat('<?php echo $vtDesempenho[86]?>')],
            [87, parseFloat('<?php echo $vtDesempenho[87]?>')], [88, parseFloat('<?php echo $vtDesempenho[88]?>')], [89, parseFloat('<?php echo $vtDesempenho[89]?>')],
            [90, parseFloat('<?php echo $vtDesempenho[90]?>')], [91, parseFloat('<?php echo $vtDesempenho[91]?>')], [92, parseFloat('<?php echo $vtDesempenho[92]?>')]
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

?></body>
</html>