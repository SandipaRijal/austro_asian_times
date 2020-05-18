<?php session_start(); ?>
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
		 echo "<li><a href='/?user_page'>Home</a></li>";
		 echo "<li><a href='/?user_page/post'>post</a></li>";
		 echo "<li><a href='/?signout'>logout</a></li>";
	 }
  	?>
</ul>
</nav>


<div id='content'>
<?php
  if(!empty($flash)){
    echo "<p id='flash'>{$flash}</p>";
  }
	
if(!empty($_SESSION['user_id'])){
    echo $_SESSION['user_id'];
  }
	
  require VIEWS."/user_page/{$content}.php";
?>
</div> <!-- end content -->

</div> <!-- end main -->

</body>
</html>