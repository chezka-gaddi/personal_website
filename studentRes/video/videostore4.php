<HTML>
<HEAD>
<TITLE>Rent Video</TITLE>
</HEAD>

<BODY bgcolor = wheat>
<H2><CENTER>Rent Video
</CENTER></H2>
<FORM METHOD="post" action="videostore4.php">
<P>
<HR>
<CENTER>

<?php
function isValidDate($date, $format= 'Y-m-d'){
    return $date == date($format, strtotime($date));
}

$host="services1.mcs.sdsmt.edu"; //hostname URL
$port=3306;						//default port 3306
$user="username";					//DBMS login username
$password="password";				//DBMS login password
$dbname="dbname";		//Select DB 


/* Connect to MySQL */
$mysqli = new mysqli($host, $user, $password, $dbname, $port);


/* Check connection error*/
if ($mysqli->connect_errno) 
{
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}


if (isset($_POST['rent']))
{
   $id = $_POST['id'];
	$videono = $_POST['videono'];
   $dout = $_POST['dout'];
   $din = $_POST['din'];
   
   	$stmt1 = $mysqli->prepare("Select count(*) from VideoForRent where videoNo = ? and Status = 'Available' ");
	$stmt1->bind_param("i", $videono);
	$stmt1->execute();
	$stmt1->bind_result($res1);
	$stmt1->fetch();
	$flag = 0;
	if($res1 != 1)
	{
		
		echo "<font size=\"3\" color=\"red\"><br>Video #$videono is unavailable.<br></font>";
		$flag = 1;
	}
	$stmt1->close();
   
	$stmt2 = $mysqli->prepare("Select count(*) from Member where memberID = ?  ");
	$stmt2->bind_param("i", $id);
	$stmt2->execute();
	$stmt2->bind_result($res2);
	$stmt2->fetch();
	if($res2 != 1)
	{

		echo "<font size=\"3\" color=\"red\"><br>Member ID $id is invalid.<br></font>";
		$flag = 2;
	}
	$stmt2->close();
	
	if(!isValidDate($dout))
	{

		echo "<font size=\"3\" color=\"red\"><br>Checkout date is invalid.<br></font>";
		$flag = 3;
	}

	if(!isValidDate($din))
	{

		echo "<font size=\"3\" color=\"red\"><br>Return date is invalid.<br></font>";
		$flag = 4;
	}
	
	if($flag == 0)
	{
	$mysqli->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
	$stmt3 = $mysqli->prepare("INSERT INTO VideoRented (videoNo, memberID, dateOut, dateIn) VALUES(?, ?, ?, ?)");
	$stmt3->bind_param("iiss", $videono, $id, $dout, $din);
	
	
	$stmt4 = $mysqli->prepare("UPDATE VideoForRent SET Status = 'Rented' WHERE videoNo = ?");
	$stmt4->bind_param("i", $videono);
	if(!($stmt3->execute()&&$stmt4->execute()))
	{
		// rollback if prep stat execution fails
		$mysqli->rollback();
		// exit or throw an exception
		echo "<font size=\"3\" color=\"red\"><br>Transaction Aborted.<br></font>";
		//exit();
	}
	else
	{
		$mysqli->commit();
		echo "<font size=\"3\" color=\"red\"><br>Transaction Committed.<br></font>";
	}
	$stmt3->close();
	$stmt4->close();

	
	}
}
?>

<BR> Member ID:
<BR><INPUT TYPE="TEXT" NAME="id">
<BR>
<BR> Video#:
<BR><INPUT TYPE="TEXT" NAME="videono">
<BR>
<BR> Checkout Date (yyyy-mm-dd):
<BR><INPUT TYPE="TEXT" NAME="dout">
<BR>
<BR> Return Date (yyyy-mm-dd):
<BR><INPUT TYPE="TEXT" NAME="din">
<BR>
<BR>

<INPUT TYPE="SUBMIT" NAME="rent" VALUE="rent">

<BR>
<BR>
</FORM>


<?php
if (isset($_POST['message']))
{

   echo "<BR><BR>$message";
}

?>


<BR>

<BR>
<BR>
<TABLE Border="1">
<TR>

<?php

/* Access the VIDEOFORRENT table */
$result = $mysqli->query("Select * from VideoForRent"); 
/* Fetch and display the attribute names */
while ($field=$result->fetch_field())
{
   echo "<TH>";
   echo "$field->name";
   echo "</TH>";
}
echo "</TR>";

/* Fetch and displays each row of $result */ 
if($result)
   while($row=$result->fetch_row())
   {
      echo "<TR>";
      for ($i=0; $i < $result->field_count; $i++)
      {
         echo "<TD> $row[$i] </TD>";
      }
      echo "</TR>\n";
   }

$mysqli->close();
?>
</TABLE>
<BR>
<a href = videostore.html>Return to Main Web Page</a>
</CENTER>



</BODY>
</HTML>
