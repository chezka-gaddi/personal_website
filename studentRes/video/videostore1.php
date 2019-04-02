<HTML>
<HEAD>
<TITLE>Test PHP-MySQL-2018</TITLE>
</HEAD>

<BODY bgcolor = wheat>
<H2><CENTER>Display Videos of a selected Status
</CENTER></H2>
<FORM METHOD="post" action="videostore11.php">
<P>
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


/* Execute Query */
$res = $mysqli->query("Select distinct status from VideoForRent");




?>

<TABLE>
<TR><TH><strong> Select Status </strong></TH></TR>
<TR><TD valign = top>
<SELECT size=<?php echo $num;?> id=status name=status>
<?php

/* Get number of rows */
$num = $res->num_rows;


/* Display each distinct STATUS value stored in the database */
for ($i = 0; $i < $num; $i++)
{
	$row=$res->fetch_row();
	if (strcmp($row[0], "Hidden") != 0)
	{
   		echo "<option> $row[0] </option>";
	}

}
$res->close();
$mysqli->close();
?>

</SELECT></TD>
</TR>
</TABLE>


<P>
<INPUT TYPE="SUBMIT" VALUE="Execute SQL statement...">
<INPUT TYPE="RESET"  VALUE="Clear...">
<P>

</FORM>
<a href = videostore.html>Return to Main Web Page</a>
</CENTER>
</BODY>
<HTML>
