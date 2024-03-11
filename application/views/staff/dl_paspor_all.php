<?php

$zipName = $member[0]->paket_info->nama_paket . '_' . $member[0]->paket_info->tanggal_berangkat . '_paspor.zip';
$zipName = str_replace(' ', '_', $zipName);
$path = "/uploads/zip/";
$zip_file_real_path = SITE_ROOT . $path . $zipName;

touch($zip_file_real_path);
$zip = new ZipArchive();
if (!is_writable($zip_file_real_path)) {
    $this->alert->set('danger', 'not writable');
    redirect($_SERVER['HTTP_REFERER']);
    return 0;
}
if ($zip->open($zip_file_real_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    $this->alert->set('danger', 'Zip Fail');
    redirect($_SERVER['HTTP_REFERER']);
    return 0;
}
$isEmpty = true;
foreach ($member as $m) {
    $fileName = SITE_ROOT . $m->paspor_scan;

    if (empty($m->paspor_scan)) {
        continue;
    }
    if (!file_exists($fileName)) {
        continue;
    }
    $isEmpty = false;
    $path_parts = pathinfo($fileName);
    $baseName = $path_parts['basename'];
    $zip->addFile($fileName, $baseName);
}
foreach ($member as $m) {
    $fileName = SITE_ROOT . $m->paspor_scan2;

    if (empty($m->paspor_scan2)) {
        continue;
    }
    if (!file_exists($fileName)) {
        continue;
    }
    $isEmpty = false;
    $path_parts = pathinfo($fileName);
    $baseName = $path_parts['basename'];
    $zip->addFile($fileName, $baseName);
}
if ($isEmpty) {
    $this->alert->set('danger', 'Paspor Belum Ada yang diupload');
    redirect($_SERVER['HTTP_REFERER']);
    return 0;
}
if (!$zip->close()) {
    $this->alert->set('danger', 'Zip Not Created');
    redirect($_SERVER['HTTP_REFERER']);
    return 0;
}

header('Content-type: application/zip');
header('Content-Disposition: attachment; filename="' . basename($zip_file_real_path) . '"');
header("Content-length: " . filesize($zip_file_real_path));
header("Pragma: no-cache");
header("Expires: 0");

ob_clean();
flush();

readfile($zip_file_real_path);
unlink($zip_file_real_path);
exit;
