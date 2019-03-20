<?php
function write()
{
    $target_dir = "../uploads/";
    $target_file = $target_dir . "test.txt";

    $file = fopen( $target_file, 'a');
    $array = explode(",", $_GET['stuff']);
    fwrite($file, implode("...", $array));
    fwrite($file, "\n");
    fwrite($file, $_GET['more']);
    fwrite($file, "\n");
    fclose($file);
}
?>