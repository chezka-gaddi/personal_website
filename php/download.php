<?php

$target_dir = "../uploads/";
$target_file = $target_dir . "test.txt";

if (file_exists($target_file)) {
    header('Content-disposition: attachment; filename=' . $target_file );
    readfile("downloadName.txt");
}

