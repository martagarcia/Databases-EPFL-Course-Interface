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
if($_GET['action'] == "Insert"){
	$sqlfields=array();
	$sqlvalues=array();

	foreach($COLS as $c){
		array_push($sqlfields, "`".$c->getFieldName()."`");
		if(@$_GET[$c->getFieldName()] == "NULL"){			
			array_push($sqlvalues, "NULL");
		}
		else
			array_push($sqlvalues, "'".mysql_escape_string($_GET[$c->getFieldName()])."'");
	}
	
	$formvalues = $_GET;
	
		$sql = "INSERT INTO $tablename (".join($sqlfields, ",").") VALUES(".join($sqlvalues, ",").");";
	$starttime=microtime(true);
		mysql_query($sql);
	echo "<div id='info'>Query: $sql</div>";
	if(mysqlCheck()) die("<div id='ok'>Successfully added in ".(microtime(true)-$starttime)." seconds</div>");
	else die();
	
	
}
?>


<br>
<br>
<form>
<input type="hidden" name="page" value="insert">
<select name="tablename">
<option value="-1">Select a table for insertion:</option>
<?php
	$r = mysql_query("SHOW TABLES");
	while($a = mysql_fetch_array($r)){
		$c = ($a[0] == @$_GET['tablename']) ? " selected": "";
		echo "<option value=\"".$a[0]."\"$c>".$a[0]."</option>";
	}
?>
</select><input type="submit" value="go">
</form>
<?php mysqlCheck(); ?>


<form>
<input type="hidden" name="page" value="insert">
<input type="hidden" name="tablename" value="<?php echo $tablename; ?>">
<?php
if(isset($_GET['tablename']) && $_GET['tablename'] != -1){
	
	echo "<h2>Insert data in <u>$tablename</u></h2>";
	echo "<table>";
	foreach($COLS as $c){
	
	if(!isset($formvalues[$c->getFieldName()]))
		$formvalues[$c->getFieldName()] = $c->getDefaultValue();
	?>
		<tr>
			<td class='text'><?php echo $c->getLabel(); ?></td>
			<td><input type="text" name="<?php echo $c->getFieldName(); ?>" value="<?php echo $formvalues[$c->getFieldName()]; ?>"></td>
			<td class='text'><?php echo $c->getFormatInfo(); ?></td>
		</tr>
	<?php
	}
	echo "<tr><td colspan=2><input type='submit' name='action' value='Insert'></td></tr>";
	echo "</table>";
	

}
?></form>