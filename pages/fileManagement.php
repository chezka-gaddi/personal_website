<?php
require_once 'upload.php';

if(isset($_GET['up'])) {
  upload();
}
?>

<!DOCTYPE html>
<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Allura|Cinzel" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="../styles/musicstyles.css">
  <script type="text/javascript" src="../js/sounds.js"></script>
</head>

<body>
  <div>
    <ul class="navigation">
      <li><a href="songindex.html">Home</a></li>
      <li><a class="active" href=#fileManagement>File Management</a></li>
      <li><a href="help.html">Help</a></li>
    </ul>
  </div>

<form action="fileManagement.php?up=1" method="post" enctype="multipart/form-data">
  Select file to upload:
  <input type="file" name="fileToUpload" id="fileToUpload" class="button">
  <input type="submit" value="Upload" name="submit" class="button">
</form>

<p>Current files:
    <?php
        $myFiles = scandir ( "../uploads/" );
        echo '<table border-collapse:"separate" border-spacing="10px 20px"><tr>';
        foreach( $myFiles as $f )
        {
            if ($f != "." && $f != "..") {
                echo '<td>' . $f . '</td>';
                echo '<td>';
                echo '<a href="download.php?file=' . urlencode($f) . '"><button>Download</button></a>';
                echo '</td>';
            }
        }
        echo '</tr>';
        echo '</table>';
    ?>
</p>



</body>

</html>