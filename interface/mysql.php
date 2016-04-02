<?php
include "class/col.php";
mysql_connect("localhost", "database", "epfl123") or die("error when connecting");
mysql_select_db("dbepfl") or die("error selecting database");
$LOG_PROC ="mysql connected!";


function mysqlCheck(){
	$err = mysql_error();
	if($err != ""){
		echo "<div id=\"error\">$err</div>";
		return false;
	}
	return true;
}

?>
<html>
<head>
<LINK rel="stylesheet" type="text/css" href="style.css"> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
</head>
<body>

<?php
@include "class/nav.php";
?>

<?php


if(@$_GET['page'] == "query"){
	@include "pages/pquery.php";
}
else if(@$_GET['page'] == "search"){

	include "pages/search.php";
}
else if(@$_GET['page'] == "insert"){
	include "pages/insert.php";
}
else if(@$_GET['page'] == "delete"){
	include "pages/delete.php";
}
else
	echo "Welcome to the DB interface";

?>

</body>
</html>