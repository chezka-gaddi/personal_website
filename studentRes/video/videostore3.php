<HTML>
<HEAD>
<TITLE>Update members</TITLE>
</HEAD>

<BODY bgcolor = wheat>
<H2><CENTER>Update Members
</CENTER></H2>
<FORM METHOD="post" action="videostore3.php">
<P>
<HR>
<CENTER>

<?php


$host="services1.mcs.sdsmt.edu"; //hostname URL
$port=3306;						//default port 3306
$user="username";					//DBMS login username
$password="password";				//DBMS login password
$dbname="dbname";		//Select DB 


/* Connect to MySQL */
$mysqli = new mysqli($host, $user, $password, $dbname, $port);


/* Check connection error*/
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}


if (!isset($_POST['id']))
{
   $id=0;
}
else
{
   $id = $_POST['id'];
}

if (isset($_POST['left']))
{

   $query = "SELECT MEMBERID, FNAME, LNAME, ADDRESS, DATEJOINED, PHONENO FROM Member WHERE MEMBERID < $id ORDER BY MEMBERID DESC";
   $result = $mysqli->query($query);
   $row = $result->fetch_row();
   if ($row[0] > 0)
   {
       $id      = $row[0];
       $fname   = $row[1];
	   $lname   = $row[2];
       $address = $row[3];
       $djoined = $row[4];
       $phoneno = $row[5];
    }
}

elseif (isset($_POST['right']))
{
   $query = "SELECT MEMBERID, FNAME, LNAME, ADDRESS, DATEJOINED, PHONENO FROM Member WHERE MEMBERID > $id ORDER BY MEMBERID ASC";
   $result = $mysqli->query($query);
   $row = $result->fetch_row();
   if ($row[0] > 0)
   {
       $id      = $row[0];
       $fname   = $row[1];
	   $lname   = $row[2];
       $address = $row[3];
       $djoined = $row[4];
       $phoneno = $row[5];
    }
}

elseif (isset($_POST['search']))
{
   $id = 0;
   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $query = "SELECT MEMBERID, FNAME, LNAME, ADDRESS, DATEJOINED, PHONENO FROM Member WHERE FNAME LIKE '%$fname%' AND LNAME LIKE '%$lname%' AND MEMBERID > $id";
   $result = $mysqli->query($query);
   $row=$result->fetch_row();
   if ($row[0] > 0)
   {
       $id      = $row[0];
       $fname   = $row[1];
	   $lname   = $row[2];
       $address = $row[3];
       $djoined = $row[4];
       $phoneno = $row[5];
    }
}

elseif (isset($_POST['add']))
{
   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $address = $_POST['address'];
   $djoined = $_POST['djoined'];
   $phoneno = $_POST['phoneno'];
   $query = "INSERT INTO Member (MEMBERID, FNAME, LNAME, ADDRESS, DATEJOINED, PHONENO) VALUES('$id','$fname','$lname','$address','$djoined','$phoneno')";
   $result = $mysqli->query($query);
   $message = "*****Record added*****";
}

elseif (isset($_POST['delete']))
{
   $query = "DELETE FROM Member WHERE MEMBERID = $id";
   $result = $mysqli->query($query);
   $message = "*****Record deleted*****";
}

elseif (isset($_POST['update']))
{
   $fname = $_POST['fname'];
	$lname = $_POST['lname'];
   $address = $_POST['address'];
   $djoined = $_POST['djoined'];
   $phoneno = $_POST['phoneno'];
   $query = "UPDATE Member SET FNAME='$fname', LNAME='$lname', ADDRESS='$address', DATEJOINED='$djoined', PHONENO='$phoneno' WHERE MEMBERID = $id";
   $result = $mysqli->query($query);
   $message = "*****Record updated*****";
}

$id = trim($id);
$fname = trim($fname);
$lname = trim($lname);
$address = trim($address);
$djoined = trim($djoined);
$phoneno = trim($phoneno);


$mysqli->close();

?>

<BR> Member ID:
<BR><INPUT TYPE="TEXT" NAME="id"
    <?php echo "VALUE=\"$id\"" ?>>
<BR>
<BR> First Name:
<BR><INPUT TYPE="TEXT" NAME="fname"
    <?php echo "VALUE=\"$fname\"" ?>>
<BR>
<BR> Last Name:
<BR><INPUT TYPE="TEXT" NAME="lname"
    <?php echo "VALUE=\"$lname\"" ?>>
<BR>
<BR> Address:
<BR><INPUT TYPE="TEXT" NAME="address"
    <?php echo "VALUE=\"$address\"" ?>>
<BR>
<BR> Date Joined (yyyy-mm-dd):
<BR><INPUT TYPE="TEXT" NAME="djoined"
    <?php echo "VALUE=\"$djoined\"" ?>>
<BR>
<BR> Phone Number (xxx-xxx-xxxx):
<BR><INPUT TYPE="TEXT" NAME="phoneno"
    <?php echo "VALUE=\"$phoneno\"" ?>>
<BR>
<BR>

<INPUT TYPE="SUBMIT" NAME="left"     VALUE="<">
<INPUT TYPE="SUBMIT" NAME="right"     VALUE=">">
<INPUT TYPE="SUBMIT" NAME="search"     VALUE="Search">

<BR>
<BR>
<INPUT TYPE="SUBMIT" NAME="add"     VALUE="Add">
<INPUT TYPE="SUBMIT" NAME="update"     VALUE="Update">
<INPUT TYPE="SUBMIT" NAME="delete"     VALUE="Delete">

<?php
if (isset($_POST['message']))
{
   echo "<BR><BR>$message";
}

?>

<BR>
<BR>
<a href = videostore.html>Return to Main Web Page</a>
</CENTER>
</FORM>
</BODY>
</HTML>
