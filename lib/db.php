<?php

function get_db(){
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName ="austro_asian_times";


$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword, $dbName);

return $conn;
}




function query($query, $datatype, $data){
	$db= get_db();
	$sql = $query;
	// initiate a prepared statement
	$stmt = mysqli_stmt_init($db);
	//prepare the prepared statement
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "SQL statement failed";
	}else{
		//Bind the parameters to the placeholder
		mysqli_stmt_bind_param($stmt,$datatype, $data);

		// Run parameters inside database
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
	
		return $result;
	
	}
mysqli_close($db);
}


function get_all_post_by_status($status){
	$db= get_db();
	$sql = "SELECT * FROM article WHERE articleStatus=?";
	$datatype='s';
	$result = query($sql,$datatype,$status);
	return $result;
}
function get_all_post(){
	$db = get_db();
	$sql = "SELECT * FROM article";
	$result = mysqli_query($db,$sql);
	return $result;
}
function get_data_by_user_id(){
	$db= get_db();
	$sql = "SELECT * FROM article WHERE userId=?";
	// initiate a prepared statement
	$stmt = mysqli_stmt_init($db);
	//prepare the prepared statement
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "SQL statement failed";
	}else{
		//Bind the parameters to the placeholder
		mysqli_stmt_bind_param($stmt,"i", $_SESSION['user_id']);

		// Run parameters inside database
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
	}
	
	
	
/* close connection */
mysqli_close($db);
return $result;

}


function insert_post_data($title, $description, $date, $user_id){
	$db= get_db();
	$sql = "INSERT INTO article(articleTitle, articleDescription, articleDate, userId) VALUES(?,?,?,?)";
	// initiate a prepared statement
	$stmt = mysqli_stmt_init($db);
	//prepare the prepared statement
	if(!mysqli_stmt_prepare($stmt, $sql)){
		set_flash("SQL statement failed");
	}else{
		//Bind the parameters to the placeholder
		mysqli_stmt_bind_param($stmt,"sssi", $title, $description, $date, $user_id);

		// Run parameters inside database
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_affected_rows($stmt);
		
	}
	
	
	
/* close connection */
mysqli_close($db);
return $result;

}

//function logged_in($username, $password){
//	$db= get_db();
//	$username = strtolower(trim($username)); //trip will delete any whitespace and strtolower will lower the case
//	$sql = "SELECT * FROM users WHERE email_id='{$username}' LIMIT 1"; // need to prtect from SQL Insection
//	$data = mysqli_query($db, $sql);
//	$data_check = mysqli_num_rows($data);
//	if($data_check>0){
//		$row= mysqli_fetch_assoc($data);
//		if(password_verify($password,$row['password'])){
//			$_SESSION['user_id'] = $row['user_id']; 
//			$_SESSION['first_name']= $row['first_name'];
//			return true;
//		}else{
//			return false;
//		}
//	}
//	
//}

// get article by id
function get_data_by_article_id($id){
	$db = get_db();
	$sql = "SELECT * FROM article WHERE articleId =?;";
	$datatype ="i";
	$result = query($sql,$datatype, $id);
	mysqli_close($db);
	return $result;	
}
// delete article by id

function delete_article_by_id($id){
	$db = get_db();
	$sql = "DELETE FROM article WHERE articleId={$id}";
	$result = mysqli_query($db,$sql);
	mysqli_close($db);
	return $result;
	
}

// update article by id
function update_article_by_id($data){
	$db = get_db();
	$sql = "UPDATE article SET articleTitle=?, articleDescription=?, articleStatus=? WHERE articleId=?";
	// initiate a prepared statement
	$stmt = mysqli_stmt_init($db);
	//prepare the prepared statement
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "SQL statement failed";
	}else{
		//Bind the parameters to the placeholder
		mysqli_stmt_bind_param($stmt,"sssi", ...$data);

		// Run parameters inside database
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_affected_rows($stmt);
		return $result;
	}
mysqli_close($db);
	
}
function logged_in($username, $password){
	$db= get_db();
	$username = strtolower(trim($username)); //trip will delete any whitespace and strtolower will lower the case
	$sql = "SELECT * FROM users WHERE email_id=? LIMIT 1"; // need to prtect from SQL Insection
	// initiate a prepared statement
	$stmt = mysqli_stmt_init($db);
	//prepare the prepared statement
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "SQL statement failed";
	}else{
		//Bind the parameters to the placeholder
		mysqli_stmt_bind_param($stmt,"s", $username);

		// Run parameters inside database
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
	}
		$row= mysqli_fetch_assoc($result);
		if(password_verify($password,$row['password'])){
			
			$_SESSION['user_id'] = $row['user_id']; 
			$_SESSION['first_name']= $row['first_name'];
			$_SESSION['admin'] = $row['authentication'];
			
			return true;
		}else{
			return false;
		}
	
	mysqli_close($db);
}

function create_user(){
	$db = get_db();
	$hashed_password = password_hash("admin",PASSWORD_DEFAULT);
	$sql = "INSERT INTO users(first_name, last_name, email_id, password, position, authentication) VALUES('Sandipa', 'Rijal' , 'sandipa@gmail.com', '{$hashed_password}', 'editor', 'admin')";
	$data = mysqli_query($db, $sql);
	mysqli_close($db);
}
	
?>