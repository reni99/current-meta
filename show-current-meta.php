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
<table>
<caption></caption>
<tbody>
<tr>
	<th>Your Class</th>
	<td>
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
	<th>Opponent Class</th>
	<td>
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
	</td>
	<th>From</th>
	<td>
		<input type="button" id="calendarButtonFrom" value="Pick Date" />
	</td>
	<td>
	<input type="text" name="dateFrom" id="dateFrom" />
	</td>
	<th>To</th>
	<td>
		<input type="button" id="calendarButtonTo" value="Pick Date" />
	</td>
	<td>
	<input type="text" name="dateTo" id="dateTo" />
	</td>
</tr>
</tbody>
</table>
</form>