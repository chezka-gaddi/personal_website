<?php
session_start();

require_once 'php/write.php';
require_once 'php/load.php';

$treble = '<div class="staff-header">
  </div>';
$song = '';
$title = "My Song";

if(isset($_COOKIE['songToSave'])) {
  $_SESSION["songToSave"] = $_COOKIE["songToSave"];
  setcookie("songToSave", '');
  $_SESSION["songTitle"] = $_COOKIE["songTitle"];
  setcookie("songTitle", '');
  
  saveSong();
  $song = $_SESSION["songToSave"];
  $title = $_SESSION["songTitle"];
}

if(isset($_GET["load"])) {
  $title = $_SESSION["title"];
  $song = $_SESSION["song"];
}

if(isset($_GET["action"])) {
  $song = loadMusic();
  $title = loadTitle();
}
?>

<!DOCTYPE html>
<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond|Cardo" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/styles.css">
  <link rel="stylesheet" href="styles/piano.css">
  <link rel="stylesheet" href="styles/header.css">
  <script type="text/javascript" src="js/sounds.js"></script>
</head>

<body>
  <header>
    <div class="banner">
      <h1>Song Creation</h1>
      <video autoplay loop muted class="banner__video" poster="https://pawelgrzybek.com/photos/2015-12-06-codepen.jpg">
      <source src="res/musicSheet.mov" type="video/webm">
      <source src="https://pawelgrzybek.com/photos/2015-12-06-codepen.mp4" type="video/mp4">
      </video>
    </div>
    <ul class="navigation">
      <li><a class="active" href=#home>Home</a></li>
      <li><a href="files.php">File Management</a></li>
      <li><a href="help.html">Help</a></li>
    </ul>
  </header>

  <div class="row">
  <div class="sheet column left">
  <div>

  <form action="index.php?action=1" method="post" enctype="multipart/form-data" id="songTitleForm">
    <input type="text" onchange=activateButton() id="songTitle" list="songsOnFile" name="fileToDownload">
      <datalist id="songsOnFile">
      <?php 
        $myFiles = scandir ("uploads/");
        foreach ($myFiles as $f) {
          $songName = str_replace(".xml", "", $file);
          if ($f != "." && $f != "..") {
            echo '<option>' . $f . '</option>';
          }
        }
      ?>
    </datalist>
    <input type="submit" value="Load Song" name="submit" class="button disabled" id="loadSongButton">
  </form>

  <?php
    echo '<script>
      document.getElementById("songTitle").value = "' . $title . '";
    </script>';
  ?>
  </div>

  <div id="sheet-music" class="sheet-music">
    <?php echo $treble ?>  
  </div>
</div>

    <div class="column right">
      <div class="piano">
      <ul class="piano">
        <input type="radio" name="notes" id="C4"/>
        <label for="C4">
          <li class="note">C</li>
        </label>
        <input type="radio" id="t1" />
        <label for="t1">
          <li class="tut"></li>
        </label>
        <input type="radio" name="notes" id="D4"/>
        <label for="D4">
          <li class="note">D</li>
        </label>
        <input type="radio" id="t1" />
        <label for="t1">
          <li class="tut"></li>
        </label>
        <input type="radio" name="notes" id="E4"/>
        <label for="E4">
          <li class="note">E</li>
        </label>
        <input type="radio" name="notes" id="F4"/>
        <label for="F4">
          <li class="note">F</li>
        </label>
        <input type="radio" id="t1" />
        <label for="t1">
          <li class="tut"></li>
        </label>
        <input type="radio" name="notes" id="G4"/>
        <label for="G4">
          <li class="note">G</li>
        </label>
        <input type="radio" id="t1" />
        <label for="t1">
          <li class="tut"></li>
        </label>
        <input type="radio" name="notes" id="A4"/>
        <label for="A4">
          <li class="note">A</li>
        </label>
        <input type="radio" id="t1" />
        <label for="t1">
          <li class="tut"></li>
        </label>
        <input type="radio" name="notes" id="B4"/>
        <label for="B4">
          <li class="note">B</li>
        </label>
        <input type="radio" name="notes" id="C5"/>
        <label for="C5">
          <li class="note">C</li>
        </label>
      </ul>
    </div>

  <div class="playback">
    <select id="duration">
      <option>Eighth</option>
      <option>Quarter</option>
      <option selected="selected">Half</option>
      <option>Whole</option>
    </select>
    <button id="update">Edit Last Note</button>
    <br />
    <button id="confirm"><i class="fas fa-check green"></i> Confirm Note</button>
    <button id="undo"><i class="fas fa-undo"></i></button>
    <button id="redo"><i class="fas fa-redo"></i></button>
    <br />

    <form id="songToSave" method="post" enctype="multipart/form-data">
      <input type="submit" value="&#128190; Save" name="submit" onclick=save() id="button">
    </form>

    <button id="play"><i class="fas fa-play"></i></button>
    <label class="switch tooltip">
      <span class="tooltiptext">Double Speed</span>
      <input type="checkbox" id="tempo">
      <span class="slider"></span>
    </label>    
    <br />
    <br />
    <p id="change"></p>
  </div>  
</div>
</div>

<?php
echo '<script>
var music = "' . $song . '";
music = music.split(" ");
var x = 0;
while (x < music.length - 1) {
  var classes = [music[x], music[x+1]];
  drawNote(classes); 
  x += 2;
      }
  </script>';
?>

</body>

</html>
