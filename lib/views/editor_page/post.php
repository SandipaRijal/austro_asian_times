<h1>Welcome to your posts.</h1>
<form action="/user_page/post/add" method="post">
	<input type='hidden' name='_method' value='post' />
	<label for='name'>Title</label>
	<input type='text' id='post-title' name='post-title' required/>
	<label for='name'>Description</label>
	<input type='text' id='post-description' name='post-description' required/>
	<label for='name'>Date</label>
	<input type='date' id='post-date' name='post-date' required/>
	<input type='submit' value='Add' />	
</form>
<h2>Published</h2>
<table class="user-post-table">
<?php
if(!empty($messages['published'])){
	
		while($rows= mysqli_fetch_assoc($messages['published'])){
?>
		
		<tr>
			<td><?php echo $rows['articleTitle']; ?></td>
			
			<td><?php echo $rows['articleDate']; ?></td>
			<td>
			<form action='/delete' method='POST'>
 					<input type='hidden' name='_method' value='post' />
					<input type='hidden' name='delete' value="<?php echo $rows['articleId']; ?>" />
					<button>Delete</button>
			</form>
			</td>
			<td>
				<a href="/editor/post/edit/?id=<?php echo $rows['articleId']; ?>">Edit</a>
					
			</td>
			
		</tr>
		
		
<?php
		}
}else{
	echo "no data found";
}

?>
</table>
<h2>Unpublished </h2>
<table class="user-post-table">
<?php
if(!empty($messages['unpublished'])){
	
		while($rows= mysqli_fetch_assoc($messages['unpublished'])){
?>
		
		<tr>
			<td><?php echo $rows['articleTitle']; ?></td>
			
			<td><?php echo $rows['articleDate']; ?></td>
			<td>
				<form action='/delete' method='POST'>
 					<input type='hidden' name='_method' value='post' />
					<input type='hidden' name='delete' value="<?php echo $rows['articleId']; ?>" />
					<button>Delete</button>
				</form>
				
			</td>
			<td>
			<a href="/editor/post/edit/?id=<?php echo $rows['articleId']; ?>">Edit</a>
			</td>
			
		</tr>
		
		
<?php
		}
}else{
	echo "No posts found";
}

?>
</table>

