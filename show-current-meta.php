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

<table>
<caption></caption>
<tbody>
	<tr>
		<th>Class</th>
		<th>Faced</th>
	</tr>
<?php
$numberOfDecks = count($decks);
for($i = 0; $i < $numberOfDecks; $i++){
	echo"<tr><th>".$decks[$i]."</th>";
	$query = "SELECT against FROM result WHERE against = ?";
	$stmt = $connection->prepare($query);
	$stmt->bind_param('s', $decks[$i]);
	$stmt->execute();
	$stmt->store_result();
	$count = $stmt->num_rows;
	echo "<td>$count</td>";
	echo "</tr>";
	$stmt->close();
} 

$connection->close();
?>
</tbody>
</table>