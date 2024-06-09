<?php

// require composer autoload
require_once APPPATH . 'third_party/mpdf/vendor/autoload.php';
// $url = base_url() . 'staff/finance/kuitansi_html?id=' . $id;
// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_HEADER, 0);
// curl_setopt($ch, CURLOPT_VERBOSE, 1);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// // forward current cookies to curl
// $cookies = array();
// foreach ($_COOKIE as $key => $value) {
//     if ($key != 'Array') {
//         $cookies[] = $key . '=' . $value;
//     }
// }


// curl_setopt($ch, CURLOPT_COOKIE, implode(';', $cookies));
// // Stop session so curl can use the same session without conflicts
// session_write_close();
// $html = curl_exec($ch);
// curl_close($ch);
// // Session restart
// session_start();
// $mpdf->setBasePath($url);
$mpdf = new \mPDF();

$mpdf->useSubstitutions = true; // optional - just as an example
$mpdf->CSSselectMedia = 'mpdf'; // assuming you used this in the document header
$mpdf->WriteHTML($html);
$filename = 'INVOICE - ' . $name . '.pdf';
// $mpdf->Output($filename, 'D');

// $html = 'SOME TEXT HERE FOR THE CURRENT PDF';
// include ("PDF/mpdf60/mpdf.php");
// $mpdf = new mPDF($filename, 'D'); 
// $mpdf->WriteHTML(utf8_encode($html));
// $mpdf->AddPage();
// $mpdf->SetImportUse();
// $file = $jenisPaket == TRUE ? "asset/docs/terms_lcu.pdf" : "asset/docs/terms.pdf";
// $pagecount = $mpdf->SetSourceFile($file);
//     for ($i=1; $i<=$pagecount; $i++) {
//         $import_page = $mpdf->ImportPage($i);
//         $mpdf->UseTemplate($import_page);

//         if ($i < $pagecount)
//             $mpdf->AddPage();
//     }
ob_end_clean();
$mpdf->Output($filename, 'D');

