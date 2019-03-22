<?php
function load() {
    $file = $_REQUEST["fileToDownload"];
    $filepath = "uploads/" . $file;
    
    $songXML = simplexml_load_file($filepath);

    $songName = $songXML->title;

    $html[] = $songName;
    $musicSheet = '';
    foreach($songXML->note as $note) {
        $notes[] = $note;
        $duration[] = $note['duration'];

        $musicSheet .= '<div class="bar"><div class="' . $note . ' ' . $note['duration'] . '"></div></div>';
    }
    $html[] = $musicSheet;

    return $html;
}
?>