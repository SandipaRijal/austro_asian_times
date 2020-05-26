
<?php

if($messages['data'] !==false){
	while($rows= mysqli_fetch_assoc($messages['data'])){
		
?>
		<form action="/edit/update" method="post">
			<input type='hidden' name='_method' value='put' />
			<input type='hidden' name='id' value="<?php echo $rows['articleId']; ?>" />
			<input type='hidden' name='default_value' value="<?php echo $rows['articleStatus']; ?>" />
			<label for='name'>Title</label>
			<input type='text' id='post-title' name='post-title' value="<?php echo $rows['articleTitle']; ?>" required/>
			
			<label for='name'>Description</label>
			<textarea id='post-description' name='post-description' required><?php echo $rows['articleDescription']; ?> </textarea>
			<p><?php echo $rows['articleStatus']?></p>
			<?php if($rows['articleStatus']=="published"):?>
			<input type="checkbox" id="publish" name="status" value="unpublished">
			<label for="unpublish">Unpublish</label><br>
			<?php else: ?>
			<input type="checkbox" id="publish" name="status" value="published">
			<label for="publish">Publish</label><br>
			<?php endif; ?>
			<input type='submit' value='Save'/>
		</form>
		
<?php
		
	}
}else{
	echo "No data found";
}

?>


