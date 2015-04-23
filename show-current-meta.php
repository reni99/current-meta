<?php
include_once "constants.php";

$decks = array();

$connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if ($connection->connect_error) {
	die("Connection failed: " . $connection->connect_error);
	exit();
}

$query = "SELECT name FROM deck";

if($stmt = $connection->prepare($query)){
	$stmt->execute();
	$stmt->bind_result($name);
    while($stmt->fetch()){
    	$decks[] = $name;
    }
    $stmt->close();
}
?>

<table class="overview">
<caption>Quick Overview</caption>
<tbody>
	<tr>
		<th>Class</th>
		<th>Faced</th>
		<th>Won</th>
		<th>Lost</th>
		<th>Won in %</th>
	</tr>
<?php
$numberOfDecks = count($decks);
for($i = 0; $i < $numberOfDecks; $i++){
	echo"<tr><td>".$decks[$i]."</td>";
	$query = "SELECT against FROM result WHERE against = ?";
	$stmt = $connection->prepare($query);
	$stmt->bind_param('s', $decks[$i]);
	$stmt->execute();
	$stmt->store_result();
	$count = $stmt->num_rows;
	$stmt->close();
	echo "<td>$count</td>";

	$query = "SELECT COUNT(*) FROM result WHERE wonlost = 1 AND against = '". $decks[$i] . "'";
	$result = $connection->query($query);
	$won = $result->fetch_row();
	echo "<td>".$won[0]."</td>";


	$query = "SELECT COUNT(*) FROM result WHERE wonlost = 0 AND against = '". $decks[$i] . "'";
	$result = $connection->query($query);
	$lost = $result->fetch_row();
	echo "<td>".$lost[0]."</td>";
	echo "<td>". (($won[0] / ($won[0] + $lost[0])) * 100)."</td>";
	echo "</tr>";
} 
$connection->close();
?>
</tbody>
</table>

<h1>Custom Querying</h1>
<form name="demoform" action="index.php?page=show-current-meta.php" method="post">
<table id="query-options">
<caption></caption>
<tbody>
	<tr>
				<th class="query-option-label">
			Choose mode 
		</th>
	<td class="query-option-view" colspan="10">
<select id="typeOfData">
	<option value="vs">VS</option>
	<option value="faceing-percentage">% Faceing</option>
</select>
</td>
	</tr>
	<tr>
	<th class="query-option-label">Select your Deck</th>
	<td class="query-option-view">
		<select name="player-class">
		<?php
          $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
              if ($connection->connect_error) {
                  die("Connection failed: " . $connection->connect_error);
                  exit();
              }
          $query = "SELECT name FROM deck";
          if($stmt = $connection->prepare($query)){
              $stmt->execute();
              $stmt->bind_result($name);
              while($stmt->fetch()){
                  echo"<option value='" . $name . "'>".$name."</option>"; 
              }
              $stmt->close(); 
              $connection->close();
          }
		?>
		</select>
	</td>
	<th class="query-option-label">Opponent Deck</th>
	<td class="query-option-view">
		<select name="opponent-class">
			<?php
          $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
              if ($connection->connect_error) {
                  die("Connection failed: " . $connection->connect_error);
                  exit();
              }
          $query = "SELECT name FROM deck";
          if($stmt = $connection->prepare($query)){
              $stmt->execute();
              $stmt->bind_result($name);
              while($stmt->fetch()){
                  echo"<option value='" . $name . "'>".$name."</option>";
              }
              $stmt->close(); 
              $connection->close();
          }
			?>
		</select>
	</tr>
<tr>
	</td>
	<th class="query-option-label">Select From</th>
	<td class="query-option-view">
		<input type="button" id="calendarButtonFrom" value="Pick Date" />
	</td>
	<td class="query-option-view">
	<input type="text" name="datefrom" id="date-from" value="<?php if(isset($_POST['create-result'])){echo $_POST['datefrom'];}?>"/>
	</td>
</tr>
<tr>
	<th class="query-option-label">Select To</th>
	<td class="query-option-view">
		<input type="button" id="calendarButtonTo" value="Pick Date" />
	</td>
	<td class="query-option-view">
	<input type="text" name="dateto" id="date-to" value="<?php if(isset($_POST['create-result'])){echo $_POST['dateto'];}?>"/>
	</td>
</tr>
<tr>
	<td colspan="10" class="query-option-view">
	<input type="submit" name="create-result" value="Create Result"> 
	</td>
</tr>
</tbody>
</table>
</form>

<?php
if(isset($_POST['create-result'])){
	if(isset($_POST['dateto']) && isset($_POST['datefrom'])){
?>
<table class="overview">
<caption><?php echo "Results for: ".$_POST['player-class']." vs. ".$_POST['opponent-class']. " from ".$_POST['datefrom']. " until ". $_POST['dateto'].""?></caption>
<tbody></tbody>
<tr>
<th>
	Won
</th>
<th>
	Lost
</th>
</tr>
<tr>
<?php
          $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
              if ($connection->connect_error) {
                  die("Connection failed: " . $connection->connect_error);
                  exit();
              }

           $query = "SELECT COUNT(*) FROM result WHERE '".$_POST['dateto']."' >= date AND '".$_POST['datefrom']."' <= date AND '".$_POST['player-class']."' = played AND '".$_POST['opponent-class']."' = against AND wonlost = 1";
		   $result = $connection->query($query);
		   $won = $result->fetch_row();
		   echo "<td>".$won[0]."</td>";

		   $query = "SELECT COUNT(*) FROM result WHERE '".$_POST['dateto']."' >= date AND '".$_POST['datefrom']."' <= date AND '".$_POST['player-class']."' = played AND '".$_POST['opponent-class']."' = against AND wonlost = 0";
		   $result = $connection->query($query);
		   $lost = $result->fetch_row();
		   echo "<td>".$lost[0]."</td>";


	}
}
?>
</tr>
</table>

