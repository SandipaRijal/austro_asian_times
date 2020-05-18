<?php
//session_start();
function get_db(){
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName ="austro_asian_times";


$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword, $dbName);

return $conn;
}

function get_data(){
	$db= get_db();
	$sql = "SELECT * FROM article WHERE userId={$_SESSION['user_id']}";
	$data = mysqli_query($db, $sql);
	
	
/* close connection */
mysqli_close($db);
return $data;

}

 
?>