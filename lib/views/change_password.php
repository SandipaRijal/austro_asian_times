<h1>Change password</h1>
<div>
<form action='?change' method='POST'>
 <input type='hidden' name='_method' value='put' />
 <?php
    require PARTIALS."/form.name.php";
	require PARTIALS."/form.old-password.php";
	require PARTIALS."/form.password.php";
	require PARTIALS."/form.password-confirm.php";
 ?>
 <input type='submit' value='Update' />
</form>
</div>


