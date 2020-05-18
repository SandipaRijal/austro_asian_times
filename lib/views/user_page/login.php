<h1>Sign In</h1>

<div>
<form action='?login' method='POST'>
 <input type='hidden' name='_method' value='post' />
 <?php
    require PARTIALS."/form.name.php";
	require PARTIALS."/form.password.php";
 ?>
 <input type='submit' value='Login' />
</form>
	
</div>