<?php

if(isset($_GET['tablename']) && $_GET['tablename'] != -1){
	$tablename = $_GET['tablename'];
	$r2 = mysql_query("Select * from Information_Schema.Columns where table_name='$tablename' ORDER by ORDINAL_POSITION");
	
	$COLS = array();
	while($a = mysql_fetch_array($r2)){
		
		$c = $a["COLUMN_NAME"];
		array_push($COLS, new Col($a, true));
	}
}
mysqlCheck();
$formvalues=array();

//INSERTION SQL
if($_GET['action'] == "remove"){
	$sqlvalues=array();

	foreach($COLS as $c){
		
		if(@$_GET[$c->getFieldName()] == "NULL"){			
			array_push($sqlvalues,"`".$c->getFieldName()."` = NULL");
		}
		else if(isset($_GET[$c->getFieldName()]) && $_GET[$c->getFieldName()] != "")
			array_push($sqlvalues,"`".$c->getFieldName()."` = '".mysql_escape_string($_GET[$c->getFieldName()])."'");
	}
	
	$formvalues = $_GET;
	
	$sqlwhere = implode(" AND ", $sqlvalues);
		
	$sql = "DELETE FROM $tablename WHERE $sqlwhere;";
	$starttime=microtime(true);
	mysql_query($sql);
	echo "<div id='info'>Query: $sql</div>";
	if(mysqlCheck()) echo ("<div id='ok'>Successfully added in ".(microtime(true)-$starttime)." seconds</div>");
	else die();
	
	
}

?>

<a href="<?php echo $_GET['returnpage']; ?>">go back</a>
