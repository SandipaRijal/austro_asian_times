<h1>Admin</h1>

<form action="/?user_page/post/add" method="post">
	<input type='hidden' name='_method' value='post' />
	<label for='name'>Title</label>
	<input type='text' id='post-title' name='post-title' required/>
	<label for='name'>Description</label>
	<input type='text' id='post-description' name='post-description' required/>
	<label for='name'>Date</label>
	<input type='date' id='post-date' name='post-date' required/>
	<input type='submit' value='Add' />	
</form>

<table class="user-post-table">
<?php
if(!empty($messages['data'])){
	
		while($rows= mysqli_fetch_assoc($messages['data'])){
?>
		
		<tr>
			<td><?php echo $rows['articleTitle']; ?></td>
			
			<td><?php echo $rows['articleDate']; ?></td>
			
		</tr>
		
		
<?php
		}
}else{
	echo "no data found";
}

?>
</table>