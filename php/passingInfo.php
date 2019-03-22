<?php
// Start the session
session_start();

//this page was reach with the reset button, clear the session
if(isset($_GET["reset"]))
{
    session_unset();
}

//make variable if needed (new session)
if(!isset($_SESSION["xCnt"]))
{
	$_SESSION["xCnt"] = 0;
}

if(!isset($_SESSION["yCnt"]))
{
	$_SESSION["yCnt"] = 0;
}

//grabbing infor---------------------------------------------------------------------------------------
//check if x or y were sent in, and update if so
if(isset($_GET["x"]))
{
    $_SESSION["xCnt"] = $_SESSION["xCnt"] + 1;
}
if(isset($_GET["y"]))
{
   $_SESSION["yCnt"] = $_SESSION["yCnt"] + 1;
}


//-----------------------------------------------------------------------------------

//function to return result of Cnt
function getxCnt(){
    return "X count: " . $_SESSION["xCnt"];
}


//add javascript function to update
function getyCnt(){

    //create the java script to update the proper html
    $html =  '<script>
        window.onload = function(){
           document.getElementById("yLoc").innerHTML = "Y count: ' . $_SESSION["yCnt"] . '";
         }
        </script>';
    
	
    return $html;
}

//made the javascript text, now to add it to the page
echo getyCnt();


//return a result for Ajax, and STOP the page from prcedeing otherwise it will duplicate the page contents
if(isset($_GET["total"]))
{
	$total	= $_SESSION["xCnt"] +  $_SESSION["yCnt"];
    echo "<p>Total: " . $total . "</p>";
	return;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Php Examples</title>
</head>
<body>

<!-- Script is local to make is easy to see -->
<script>
    function incrementX(){
        window.location.href = "passingInfo.php?x=1";

    }
    function incrementY(){
        window.location.href = "passingInfo.php?y=1";

    }

    function reset() {
        var reset = true;
        window.location.href = "passingInfo.php?reset=" + reset;

    }

    function getTotal() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ajax").innerHTML =this.responseText;
            }
        };  
		xhttp.open( "GET", "passingInfo.php?total=1", true);  xhttp.send();

    }

</script>

<h2>Test session variable (world and hello only send that variable)</h2>
<button type="button" onclick='incrementX()'>X</button>
<button type="button" onclick='incrementY()'>Y</button>
<button type="button" onclick='reset()'>reset</button>


<h2>Javascript function appended with Php</h2>
<p id="yLoc">should fill with Y after</p>



<h2>Php function result (X count)</h2>
<?php
echo getxCnt();
?>

<h2>Ajax</h2>
<button type="button" onclick='getTotal()'>Load (total) below</button>
<p id="ajax"></p>

</body>
</html>
