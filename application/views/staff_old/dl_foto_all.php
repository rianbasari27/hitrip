<?php

// Require composer autoload
require_once APPPATH . 'third_party/mpdf/vendor/autoload.php';
// Create an instance of the class:
$mpdf = new \mPDF();
$colCtr = 1;
$rowCtr = 1;
$html = "<center>";
foreach ($member as $key => $m) {
    if ($colCtr == 1) {
        $html = $html . "<table border=1 style='border-collapse: collapse;margin-bottom:30px;'><tr>";
    }
    $html = $html . "<td><table border=1 style='border-collapse: collapse;margin:10px;'>";
    $foto = base_url() . $m->foto_scan;
    $html = $html . "<tr><td style='width:150px;height:180px;'><center><img src='$foto'"
            . "style='max-width:150px;"
            . "max-height:180px;"
            . "width:auto;"
            . "height:auto;'>"
            . "</center></td></tr>";
    $name = $m->paspor_name;
    if (empty($m->paspor_name)) {
        $name = $jamaah[$key]->first_name . ' ' . $jamaah[$key]->second_name . ' ' . $jamaah[$key]->last_name;
    }
    $jmh = $jamaah[$key];
    $html = $html . "<tr><td style='width:150px;height:60px;'><center>$name</center></td></tr>";
    $html = $html . "<tr><td style='width:150px;height:30px;'><center>$m->paspor_no</center></td></tr>";
    $html = $html . "</table></td>";

    if ($colCtr >= 4) {
        $html = $html . "</tr></table>";
        $colCtr = 0;
    }
    $colCtr = $colCtr + 1;
}
if ($colCtr <= 4) {
    $html = $html . "</tr></table>";
}
$html = $html . "</center>";
//echo $html;
//echo '<br>'.$colCtr;
$mpdf->WriteHTML($html);

$mpdf->Output('Scan Foto VISA.pdf','D');

