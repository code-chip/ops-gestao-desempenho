<?php
require('../login-check.php');
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetHeader($header);
$mpdf->SetDisplayMode('fullpage');
$bulma = file_get_contents('../css/bulma.min.css');
$evaluation = file_get_contents('../css/evaluation.css');
// Set a simple Footer including the page number
$mpdf->setFooter('{PAGENO}');
$mpdf->setTitle('Relatório Avaliação de Desempenho');
$mpdf->SetAuthor($_SESSION['nameUser']);
$html = file_get_contents("http://localhost/ops-gestao-desempenho/report/evaluation-".$_SESSION['file'].".php?filter=".$_SESSION['filter']);
$mpdf->WriteHTML($bulma,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($evaluation,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();