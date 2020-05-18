<h1>Welcome to your posts.</h1>
<?php
if(!empty($messages['data'])){
	
		while($rows= mysqli_fetch_assoc($messages['data'])){
			echo $rows['articleTitle']." ". $rows['articleDate']."<br />";
		}
	
}else{
	echo "no data found";
}
?>