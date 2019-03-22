<?php
function loadMusic() {
    $file = $_REQUEST["fileToDownload"];
    $filepath = "uploads/" . $file;
    
    $songXML = simplexml_load_file($filepath);

    $musicSheet = '';
    foreach($songXML->note as $note) {
        $notes[] = $note;
        $duration[] = $note['duration'];

        $musicSheet .= '<div class="bar"><div class="' . $note . ' ' . $note['duration'] . '"></div></div>';
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
