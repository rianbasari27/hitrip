<?php

// Require composer autoload
require_once APPPATH . 'third_party/mpdf/vendor/autoload.php';
// Create an instance of the class:
$mpdf = new \mPDF();
$imgHeader = base_url() . 'asset\images\header_document.png';
$imgFooter = base_url() . 'asset\images\footer_document.png';
$mpdf->SetHTMLHeader(""
        . "<div>"
        . "<img src='$imgHeader'>"
        . "</div>"
);
$mpdf->SetHTMLFooter(""
        . "<div>"
        . "<img src='$imgFooter'>"
        . "</div>");
$mpdf->AddPageByArray(array(
    'margin-top' => 40
));
$html = "<div style='text-align:center;'><h1>FORMULIR PENDAFTARAN JAMAAH</h1></div>";
$mpdf->WriteHTML($html);
$html = "<table style='border-collapse:separate;border-spacing:5px;'>";
$html .= "<tr><th>Program Umroh</th><th>:</th><td style='border:1px groove; padding-left:5px;'>";
if (!empty($infoPaket->paket_info)) {
    $html .= $infoPaket->paket_info->nama_paket . " (" . date_format(date_create($infoPaket->paket_info->tanggal_berangkat), "d F Y") . ")";
} else {
    $html .= " - ";
}
$html .= "</td></tr>";
$html .= "<tr><th>Pilihan Kamar</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $infoPaket->pilihan_kamar . "</td></tr>";
$html .= "<tr><th>Nama Lengkap</th><th>:</th><td style='border:1px groove; padding-left:5px;' > " . implode(' ', array($identitas->first_name, $identitas->second_name, $identitas->last_name)) . "</td></tr>";
$html .= "<tr><th>No.Identitas (KTP / KK)</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->ktp_no . "</td></tr>";
$html .= "<tr><th>Nama Ayah Kandung</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->nama_ayah . "</td></tr>";
$html .= "<tr><th>Tempat Lahir</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->tempat_lahir . "</td></tr>";
$html .= "<tr><th>Tanggal Lahir</th><th>:</th><td style='border:1px groove; padding-left:5px;'> ";
if ($identitas->tanggal_lahir == "0000-00-00" || $identitas->tanggal_lahir == NULL) {
    $html .= "</td></tr>";
}else{
    $html .=  date_format(date_create($identitas->tanggal_lahir), "d F Y") . "</td></tr>";
    // $html .= " - </td></tr>";
}
$html .= "<tr><th>Jenis Kelamin</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->jenis_kelamin . "</td></tr>";
$html .= "<tr><th>Status Perkawinan</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->status_perkawinan . "</td></tr>";
$html .= "<tr><th>Alamat Lengkap</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->alamat_tinggal . " " . $identitas->kecamatan . " " . $identitas->kabupaten_kota . " " . $identitas->provinsi . "</td></tr>";
$html .= "<tr><th>Alamat Email</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->email . "</td></tr>";
$html .= "<tr><th>No. Telp Rumah / Kantor</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->no_rumah . "</td></tr>";
$html .= "<tr><th>No. Telp Seluler</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->no_wa . "</td></tr>";
$html .= "<tr><th>Pekerjaan</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->pekerjaan . "</td></tr>";
$html .= "<tr><th>Keluarga Yang Ikut Umroh</th><th>:</th><td style='border:1px groove; padding-left:5px;'> ";

if (!empty($family)) {
    foreach ($family as $f) {
        $html .= " - ".implode(" ", array($f->jamaahData->first_name, $f->jamaahData->second_name, $f->jamaahData->last_name)) . " (" . $f->jamaahData->no_wa . ")<br>";
    }
}
$html .= "</td></tr>";
$html .= "<tr><th>Penyakit Kronis Yang Diderita</th><th>:</th><td style='border:1px groove; padding-left:5px;'> " . $identitas->penyakit . "</td></tr></table>";

$html .= "<table style='width:100%;padding:15px;'><tr><td align='left' style='width:60%;'><img src='" . base_url() . $infoPaket->foto_scan . "' style='height:220px;'></td>";
$html .= "<td><table><tr><td align='center' style='padding-bottom:100px;'>".date("d F Y")."</td></tr><tr><td align='center'>(".implode(' ', array($identitas->first_name, $identitas->second_name, $identitas->last_name)).")</td></tr></table></td>";
$html .= "</tr></table>";
$mpdf->WriteHTML($html);
$filename = implode('_', array($identitas->first_name, $identitas->second_name, $identitas->last_name)) . '.pdf';

$mpdf->Output($filename, 'D');

