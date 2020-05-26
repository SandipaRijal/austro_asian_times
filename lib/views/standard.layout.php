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
  <li><a href='/'>Home</a></li>
  <li><a href='/user_page'>Sign in</a></li>
  
</ul>
</nav>


<div id='content'>
<?php
  if(!empty($flash)){
    echo "<p id='flash'>{$flash}</p>";
  }
  require VIEWS."/{$content}.php";
?>
</div> <!-- end content -->

</div> <!-- end main -->

</body>
</html>