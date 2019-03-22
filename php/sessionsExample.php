<?php
// Start the session
session_start();

//check if w1 or w2 were sent in, and store them in the seesion if so
if(isset($_GET["w1"]))
{
    $_SESSION["w1"] = $_GET["w1"];
}
if(isset($_GET["w2"]))
{
    $_SESSION["w2"] = $_GET["w2"];
}


//this page was reach with the reset button, clear the session
if(isset($_GET["reset"]))
{
    session_unset();
}

//dump the results
print_r( $_SESSION);


?>