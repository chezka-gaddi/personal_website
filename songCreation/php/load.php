<!--
 @file
 @brief Contains functions to aid in reading an XML file to load into the song
 area.
-->
<?php
function loadMusic() {
    $file = $_REQUEST["fileToDownload"];
    echo $file;
    $filepath = "uploads/" . $file;
    
    $songXML = simplexml_load_file($filepath);

    $musicSheet = '';
    foreach($songXML->note as $note) {
        $musicSheet .= $note . ' ' . $note['duration'] . ' ';
    }

    return $musicSheet;
}

function loadTitle() {
    $file = $_REQUEST["fileToDownload"];
    $filepath = "uploads/" . $file;
    
    $songXML = simplexml_load_file($filepath);

    $songName = $songXML[0]->title;

    return (string)$songName;
}
?>