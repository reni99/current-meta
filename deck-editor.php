<?php
	include_once "constants.php";
?>
<form action="index.php?page=deck-editor.php" method="post">
<table>
<caption>
</caption>
<tbody>
<tr>
<td>
	Enter class name:
</td>
<td>
	<input type="text" name="deck">
</td>
</tr>
<tr>
<td colspan="2"><input type="submit" value="Add Deck" name="submit"></td>
</tr>
</tbody>
</table>
</form>


<?php
if(isset($_POST["submit"])){

	if(trim($_POST["deck"]) != ""){
		$connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
   	 
 	  	 if ($connection->connect_error) {
 	  	 	die("Connection failed: " . $connection->connect_error);
 	  	     exit();
 	  	 }

 	  	$foundDeck = false;

        $query = "SELECT name FROM deck";
        if($stmt = $connection->prepare($query)){
            $stmt->execute();
            $stmt->bind_result($deckName);
            while($stmt->fetch()){
            	if($deckName == $_POST["deck"]){
            		$foundDeck = true;
            	}
            }
            $stmt->close();
        }
        
        if(!$foundDeck){
   			$stmt = $connection->prepare("INSERT INTO deck (name, date) VALUES (?, ?)");
   			$stmt->bind_param("ss", $name, $date);
   			$name = $_POST["deck"];
   			$date = date('Y-m-d H:i:s'); 
   			$stmt->execute();
   			$stmt->close();
   			echo "<p>New deck has been added to database at $date</p>";
        } else {
        	echo "<p>This deck already exists.</p>";
        }
		
		$connection->close();
	}
}
?>