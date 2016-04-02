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


if($_GET['action'] == "Find"){
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
		$sql = "SELECT * FROM $tablename WHERE $sqlwhere";
	$starttime=microtime(true);
		$r2 = mysql_query($sql);
	echo "<div id='info'>Query: <a href=\"mysql.php?page=query&sqlquery=".urlencode($sql)."\">$sql</a></div>";
	
	if(mysqlCheck()){
		echo ("<div id='ok'>Successfully executed in ".(microtime(true)-$starttime)." seconds<br>".mysql_num_rows($r2)." results</div>");
	
	}
	else die();
	
	
}

?>


<br>
<br>
<form>
<input type="hidden" name="page" value="search">
<select name="tablename">
<option value="-1">Select a table:</option>
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
<input type="hidden" name="page" value="search">
<input type="hidden" name="tablename" value="<?php echo $tablename; ?>">
<?php
if(isset($_GET['tablename']) && $_GET['tablename'] != -1){
	
	echo "<h2>Search data in <u>$tablename</u></h2>";
	echo "<table>";
	$i=0;
	foreach($COLS as $c){
	
		if($i%4 == 0) echo "<tr>";
	?>
		
			<td class='text'><?php echo $c->getLabel(); ?></td>
			<td><input type="text" name="<?php echo $c->getFieldName(); ?>" value="<?php echo $formvalues[$c->getFieldName()]; ?>"></td>
			<td class='text'></td>
		
	<?php
		if($i%4 == 3) echo "</tr>";
	$i++;
	}
	echo "<tr><td colspan=2><input type='submit' name='action' value='Find'></td></tr>";
	echo "</table>";
	

}
?></form>

<?php
if(isset($tablename) && mysql_num_rows($r2)>0){

$primary_keys = array();


foreach($COLS as $c){
	if($c->f["COLUMN_KEY"]=="PRI")
		array_push($primary_keys, $c);
}
?>

	<table class="dataTable" cellpadding=0 cellspacing=0>
		<tr>
		<td class="dataHeader">&nbsp;</td>
		<?php
		foreach($COLS as $c){
		
		
		?>
			<td class="dataHeader"><?php echo $c->getLabel(); ?></td>
		<?php
		}
		?>
		</tr>
		<?php
		while($a = mysql_fetch_array($r2)){
		echo "<tr>";
		
		if(count($primary_keys) >0)
		$deletelink = "mysql.php?page=delete&action=remove&tablename=$tablename&returnpage=".urlencode($_SERVER["REQUEST_URI"]);
		foreach($primary_keys as $pk)
			$deletelink .= "&".$pk->getFieldName()."=".urlencode($a[$pk->f['COLUMN_NAME']]);
			
			echo "<td class='dataTextCol'><a href=\"$deletelink\" onClick=\"return confirm('Are sure you want to delete?');\">X</a></td>";
			
			foreach($COLS as $c){
			
			$class = "dataTextCol";
			
			echo "	<td class='$class'>".$a[$c->f['COLUMN_NAME']]."</td>";

			
			
			}
			echo "</tr>";
			/*echo "<tr><td>";
			echo "primaryKeys = ".$deletelink;
			echo "</td></tr>";*/
		}
		?>
	</table>
	
	<?php
	}
	?>