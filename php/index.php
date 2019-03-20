<?php
require_once 'upload.php';
require_once 'write.php';

if(isset($_GET['up']))
{
    upload();
}


if(isset($_GET['write']))
{
    write();
}

?>

<html>
<head>
    <title>File test</title>
</head>
<body>
<script>
    function niceDownload() {
        window.location.href = "index.php?link=1"
    }

    function forceDownload() {
        window.location.href = "download.php"
    }

    function readFile() {
        window.location.href = "index.php?read=1"
    }
    function writeFile() {
        window.location.href = "index.php?write=1&stuff=1,2,3,4,5&more=stuff"
    }

</script>

<form action="index.php?up=1" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload" name="submit">
</form>

<button onClick="niceDownload()">Nice Download</button>
<p id="fileLink">
    <?php
    if(isset($_GET['link']))
    {
        echo '<a href="../uploads/test.txt">Download file if it exists</a>';
    }
    ?>
</p>

<button onClick="forceDownload()">Force Download</button>
<br>
<button onClick="writeFile()">Write File by appending 1,2,3,4,5 and stuff</button>
<br>
<button onClick="readFile()">Read File</button>
<p>
    <?php
    if(isset($_GET['read']))
    {
        echo 'Contents of File';
        echo '<hr>';
        $file = fopen("../uploads/test.txt", 'r');
        while( !feof($file) )  //feof equivalent to C++ fin.eof()
        {
            $line = fgets($file);
            echo $line;
            echo '<br>';
        }
        fclose($file);
        echo '<hr>';
    }
    ?>
</p>

<p>Current files:
    <?php
        $myFiles = scandir ( "../uploads/" );
        echo "<ul>";
        foreach( $myFiles as $f )
        {
            echo "<li>". $f . "</li>";
        }
        echo "</ul>";

    ?>
</p>


</body>
</html>



