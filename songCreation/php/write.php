<!--
 @file
 @brief Contains the function that creates a new XML file from the current song
 music sheet.
-->

<?php
function saveSong() {
  $dom = new DOMDocument();
  $dom->encoding = 'utf-8';
  $dom->xmlVersion = '1.0';
  $dom->formatOutput = true;

  $songStr = $_SESSION['songToSave'];  
  $songArr = explode(' ', $songStr);
  $target_dir = "uploads/";
  $xml_filename = $_SESSION['songTitle'];
  if (strpos($xml_filename, '.xml') === false) {
    $xml_filename .= '.xml';
  }

  $song = $dom->createElement('song');
  $title = $dom->createElement('title', $xml_filename);
  $song->appendChild($title);

  $i = 0;
  while ($i < count($songArr)) {
    $note = $dom->createElement('note', $songArr[$i]);
    $attr_duration = new DOMAttr('duration', $songArr[$i + 1]);
    $note->setAttributeNode($attr_duration);
    $song->appendChild($note);
    $i += 2;
  }
  $dom->appendChild($song);
  $dom->save($target_dir . $xml_filename);

  echo $target_dir . $xml_filename . ' has been successfully created.';
}
?>
