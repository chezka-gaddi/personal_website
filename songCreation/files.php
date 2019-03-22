<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'php/upload.php';
require_once 'php/download.php';
require_once 'php/load.php';

if(isset($_GET['up'])) {
  upload();
}

if(isset($_GET['action'])) {
  if ($_POST['submit'] == 'Download') {
    download();
  } else if ($_POST['submit'] == 'Load') {
    $_SESSION["notes"] = '';
    $_SESSION["durations"] = '';
    $_SESSION["song"] = loadMusic();
    $_SESSION["title"] = loadTitle();
    //print_r($_SESSION);
    header("Location: index.php?load=1");
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Allura|Cinzel" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/styles.css">

  <style>
    #filesCombo {
      margin-right: 10px;
      padding: 6px 10px;
      font-family: 'Cormorant Garamond', sans-serif;
      font-weight: bold;
    }
  </style>
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
        <li><a href="index.php">Home</a></li>
        <li><a class="active" href="#files">File Management</a></li>
        <li><a href="help.html">Help</a></li>
      </ul>
    </header>

  <form action="files.php?up=1" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload" class="button">
    <input type="submit" value="Upload" name="submit" class="button">
  </form>

<p>Current files:
    <?php
      echo '<form action="files.php?action=1" method="post" enctype="multipart/form-data">
        <select id="filesCombo" name="fileToDownload">';

      $myFiles = scandir ( "uploads/" );
      foreach ($myFiles as $f) {
        if ($f != "." && $f != "..") {
          echo '<option>' . $f . '</option>';
        }
      }
      echo '<input type="submit" value="Load" name="submit" class="button">
      <input type="submit" value="Download" name="submit" class="button">
      </form>';
    ?>
</p>

</body>

</html>
