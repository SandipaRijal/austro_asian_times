
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8' />
		<title><?php echo $messages['title']; ?></title>
		<link rel="stylesheet" href="/css/standard.css" />
	</head>
	<body>

		<div id="main">
			<nav>
				<ul>

					<?php 
					 if(empty($_SESSION['user_id'])){

						echo "";
					 }else{
						 echo "<li><a href='/editor'>Home</a></li>";
						 echo "<li><a href='/editor/post'>post</a></li>";
						 echo "<li><a href='/signout'>logout</a></li>";
					 }
					?>
				</ul>
				<h3> 
					<?php
					if(!empty($_SESSION['first_name'])){
						echo "Welcome ".$_SESSION['first_name'];
					}
					?>
				</h3>
			</nav>


			<div id='content'>
			<?php
			  if(!empty($flash)){
				echo "<p id='flash'>{$flash}</p>";
			  }

			  require VIEWS."/editor_page/{$content}.php";
			?>
			</div> <!-- end content -->

		</div> <!-- end main -->

	</body>
</html>
