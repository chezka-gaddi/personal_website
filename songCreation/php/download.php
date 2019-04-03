<!--
 @file
 @brief Contains the function to aid with dowload operation.
-->

<?php
function download() {
    $file = $_REQUEST["fileToDownload"];
    $filepath = "uploads/" . $file;

    // Process download
    if(file_exists($filepath)) {
        //header('Content-Description: File Transfer');
        //header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        //header('Expires: 0');
        //header('Cache-Control: must-revalidate');
        //header('Pragma: public');
        //header('Content-Length: ' . filesize($filepath));
        //flush(); // Flush system output buffer
        readfile($filepath);
        exit;
    }
}
?>
