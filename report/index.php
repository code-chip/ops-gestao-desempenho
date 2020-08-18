<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
 $mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('../css/bulma.min.css');
$stylesheet2 = file_get_contents('../css/evaluation.css');

//$html = file_get_contents ('http://www.localizecargas.com.br/');
$html = file_get_contents ('http://localhost/ops-gestao-desempenho/report/layout-evaluation.php');
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($stylesheet2,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
//$mpdf->WritePHP
$mpdf->Output();
//$mpdf->Addpage();
//$mpdf->PDF_resume_page(pdfdoc, optlist);