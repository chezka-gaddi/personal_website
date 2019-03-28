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
  if ($_POST['submit'] == 'Load') {
    $_SESSION["song"] = loadMusic();
    $_SESSION["title"] = loadTitle();
    header("Location: index.php?load=1");
  } else {
    download();
  }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond|Cardo" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/header.css">
</head>

<body>
    <header>
        <div class="banner">
            <h1>Song Creation</h1>
            <video autoplay loop muted class="banner__video"
                poster="res/music-sheet.jpg">
                <source src="res/musicSheet.mov" type="video/webm">
                <source src="res/music-sheet.jpg" type="video/mp4">
            </video>
        </div>
        <ul class="navigation">
            <li><a href="index.php">Home</a></li>
            <li><a class="active" href="#files">File Management</a></li>
            <li><a href="help.html">Help</a></li>
        </ul>
    </header>

    <div class="row content">
        <h2>Upload XML files</h2>
        <form action="files.php?up=1" method="post" enctype="multipart/form-data">
            Select file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="&#10514; Upload" name="submit" id="uploadBtn" class="button">
        </form>
        <br />
    </div>

    <div class="row content">
        <h2>Current Files in the system</h2>
        <form action="files.php?action=1" method="post" enctype="multipart/form-data">
            <select id="filesCombo" name="fileToDownload">
                <?php
                    $myFiles = scandir ( "uploads/" );
                    foreach ($myFiles as $f) {
                        if ($f != "." && $f != "..") {
                            echo '<option>' . $f . '</option>';
                        }
                    }
                ?>
                <input type="submit" value="Load" name="submit" class="button">
                <input type="submit" value="&#10515; Download" name="submit" class="button">
        </form>
    </div>
</body>

</html>