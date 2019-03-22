<?php
function loadMusic() {
    $file = $_REQUEST["fileToDownload"];
    $filepath = "uploads/" . $file;
    
    $songXML = simplexml_load_file($filepath);

    $musicSheet = '';
    foreach($songXML->note as $note) {
        $musicSheet .= $note . ' ' . $note['duration'] . ' ';

        //$musicSheet .= '<div class="bar"><div class="' . $note . ' ' . $note['duration'] . '"></div></div>';
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

function createSongDOM() {
    $sheet = createElement('div');
    $sheet->setAttribute('id', 'sheet');
    // $sheet->setAttribute('class', 'sheet-music');
    
    $file = $_REQUEST["fileToDownload"];
    $filepath = "uploads/" . $file;
    
    $songXML = simplexml_load_file($filepath);

    foreach($songXML->note as $note) {
        $bar = createElement('div');
        $bar->setAttribute('class', 'bar');
        
        $classes = $note . ' ' . $note['duration'];
        $barNote = createElement('div');
        $barNote->setAttribute('class', $classes);

        $bar->appendChild($barNote);
        $sheet->appendChild($bar);
    }
    
    $sheet = createSongDOM();
    $newfile = 'index.php';
    $newfile = realpath($newfile);
    $doc = new DOMDocument('1.0');
    $doc->loadHTML($newfile);
    $doc->formatOutput = True;

    $sheeter = $doc->getElementById('sheet-music');
    $oldSheet = $doc->getElementById('sheet-music');
    $sheeter->replaceChild($sheet, $oldSheet);
    $doc->saveHTMLFile('new.php');
}
?>
