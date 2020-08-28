<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
 $mpdf->SetDisplayMode('fullpage');
$bulma = file_get_contents('../css/bulma.min.css');
$evaluation = file_get_contents('../css/evaluation.css');
$yearMonth = $_GET['yearMonth'];
// Set a simple Footer including the page number
$mpdf->setFooter('{PAGENO}');

//$html = file_get_contents ('http://www.localizecargas.com.br/');
$html = file_get_contents ('http://localhost/ops-gestao-desempenho/report/layout-evaluation.php?yearMonth='.$yearMonth);
$mpdf->WriteHTML($bulma,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($evaluation,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
//$mpdf->WritePHP
// JAVASCRIPT FOR WHOLE DOCUMENT
//$mpdf->SetJS('window.print()');
$mpdf->Output();
//$mpdf->Addpage();
//$mpdf->PDF_resume_page(pdfdoc, optlist);