<?php
$file = 'download/auto-clicker-automatic-tap-2-1-4.apk';

if (file_exists($file)) {
    header('Content-Type: application/vnd.android.package-archive');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Content-Length: ' . filesize($file));
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    readfile($file);
    exit;
} else {
    die('File not found.');
}
?>
