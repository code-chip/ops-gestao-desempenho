<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
 $mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('../css/bulma.min.css');
$stylesheet2 = file_get_contents('style.css');

//$html = file_get_contents ('http://www.localizecargas.com.br/');
$html = file_get_contents ('frame.html');
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($stylesheet2,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();