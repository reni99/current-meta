<?php 
// Include database connection and functions here.  See 3.1. 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start(); 
if(login_check($mysqli) == true) {
?>
Text der geschützt werden soll

<?php }

} else { 
        echo 'You are not authorized to access this page, please login.';
}
?>