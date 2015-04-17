            <?php
                include_once "constants.php";
                ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
            ?>
        <form id="capture-data" name="set-result" method="post" action="index.php" onsubmit="validateForm()">
            <table>
                <caption></caption>
                <tbody>
                    <tr>
                        <td>
                            Played with: 
                        </td>
                        <td>
                            <select name="played" id="select-played">
                                <option value="empty">Choose Class...</option>
                                <?php
                                    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
                                        if ($connection->connect_error) {
                                            die("Connection failed: " . $connection->connect_error);
                                            exit();
                                        }
                                        
                                    $query = "SELECT * FROM deck";

                                    if($stmt = $connection->prepare($query)){
                                        $stmt->execute();
                                        $stmt->bind_result($name, $id);
                                        while($stmt->fetch()){
                                            echo"<option value='" . $name . "'>".$name."</option>"; 
                                        }

                                        $stmt->close(); 
                                        $connection->close();
                                    }
                                ?>                      
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Played against:
                        </td>
                        <td>
                            <select name="against" id="select-against">
                                <option value="empty">Choose Class...</option>
                            <?php
                                    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
                                        if ($connection->connect_error) {
                                            die("Connection failed: " . $connection->connect_error);
                                            exit();
                                        }
                                        
                                    $query = "SELECT * FROM deck";

                                    if($stmt = $connection->prepare($query)){
                                        $stmt->execute();
                                        $stmt->bind_result($name, $id);
                                        while($stmt->fetch()){
                                            echo"<option value='" . $name . "'>".$name."</option>"; 
                                        }

                                        $stmt->close(); 
                                        $connection->close();
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Won / Lost:
                        </td>
                        <td>
                            <input checked="checked" type="radio" name="result" value="1">Won
                            <input type="radio" name="result" value="0">Lost
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="submit" value="Save"></td>
                    </tr>
                </tbody>
            </table>
        </form>

        <?php
        if(isset($_POST["submit"])){
            if((!($_POST["played"] == "empty")) || (!($_POST["against"] == "empty"))){
                echo "hi";
                    $date = date('Y-m-d H:i:s'); 
                    echo $date;
                    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    
                    if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                        exit();
                    }
    
                $stmt = $connection->prepare("INSERT INTO result (played, against, wonlost, date) VALUES (?, ?, ?, ?)");
                print_r($stmt);
                $stmt->bind_param("ssis", $played, $against, $wonlost, $date);
                $played = $_POST["played"];
                $against = $_POST["against"];
                $wonlost = $_POST["result"];
                $date = date('Y-m-d H:i:s'); 
                $stmt->execute();
                $stmt->close();
                $connection->close(); 
        }

        }

        ?>