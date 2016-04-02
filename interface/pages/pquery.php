<br>
<br>
<?php
@include "storedsql.php";
if(@$_GET['action'] == "Execute")
	$_GET['sqlquery'] = $_GET['storedsql'];
	
?>
<form>
	<input type="hidden" name="page" value="query">
	<textarea name="sqlquery" class="mytextarea"><?php echo (isset($_GET['sqlquery']))? $_GET['sqlquery'] : "SELECT COUNT(*), * FROM person LIMIT 0,100;"; ?></textarea>
	<input type="submit" name="action" value="Submit">

	<select size="10" name="storedsql">
	<?php
	foreach($storedSQL as $s){
	?>
		<option value="<?php echo $s[1]; ?>"><?php echo $s[0]; ?></option>
	<?php
	}
	?>
	</select>
	<input type="submit" name="action" value="Execute">

	<div id="resultsheader"></div>
	<!--<div id="process"><?php echo $LOG_PROC; ?></div>-->
	

	<?php
	$COLS = array();
		if(isset($_GET['sqlquery'])){
			$sql = $_GET['sqlquery'];
		
			$starttime=microtime(true);
			$r = mysql_query($sql);
			echo "<div id='info'>Query: $sql</div>";
			if(mysqlCheck()) echo ("<div id='ok'>Successfully executed in ".(microtime(true)-$starttime)." seconds<br>".mysql_num_rows($r)." results</div>");
			else die();
				
			
			while($f = mysql_fetch_field($r)){
				array_push($COLS, new Col($f));
			}
		}
		
	?>
	
	
	<table class="dataTable" cellpadding=0 cellspacing=0>
		<tr>
		<?php
		foreach($COLS as $c){
		?>
			<td class="dataHeader"><?php echo $c->getLabel(); ?></td>
		<?php
		}
		?>
		</tr>
		<?php
		while($a = mysql_fetch_array($r)){
		echo "<tr>";
		foreach($COLS as $c){
		$class = "dataTextCol";
		
		echo "	<td class='$class'>".$a[$c->f['name']]."</td>";

		
		}
		echo "</tr>";
		}
		?>
	</table>
</form>