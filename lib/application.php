<?php
/* DEFINE THE CALLBACKS HERE */
function get($route,$callback){
	
   if($route === get_request() && get_method() === "GET"){
     echo $callback();
   }
   else{
      return false;
   }
}

function post($route,$callback){
   if($route === get_request() && get_method() === "POST"){
     echo $callback($route);
   }
   else{
      return false;
   }
}

function put($route,$callback){
   if($route === get_request() && get_method() === "PUT"){
     echo $callback($route);
   }
   else{
      return false;
   }
}

# The DELETE callback is left to you to work out

# We need this for when none of the routes match or some other problem i.e. "page not found"
function error_404(){
	header("HTTP/1.0 404 Not Found");
	echo render("404","standard","404");
}


/* Application functions called by the controller code */
function render_user($messages, $layout, $content, $folder){
	
	$flash=get_flash();
	
   
   if(!empty($layout) && !empty($folder)){
      require VIEWS."/{$folder}/{$layout}.layout.php";
   }
   else{
     // we need to think 
	   
   }
   exit();
}

function render($messages, $layout, $content){
	
	$flash=get_flash();
   
   if(!empty($layout)){
      require VIEWS."/{$layout}.layout.php";
   }
   else{
      // What is this part for? When would we not need a layout? Think about it.
	   
   }
   exit();
}

function get_request(){
  return $_SERVER['REQUEST_URI'];
}

function force_to_https($path="/"){
    if(!(isset($_SERVER['HTTPs']) && $_SERVER['HTTPs']==='on')){
       $host = $_SERVER['HTTP_HOST'];
       $redirect_to_path = "https://".$host.$path;
       redirect_to($redirect_to_path);
       exit();
    }
}

function force_to_http($path="/"){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on'){
       $host = $_SERVER['HTTP_HOST'];
       $redirect_to_path = "http://".$host.$request;
       redirect_to($redirect_to_path);
       exit();
    }
}

function get_method(){
   if(strtoupper(form("_method")) === strtoupper("post")){
      return "POST";
   }
   if(strtoupper(form("_method")) === strtoupper("put")){
      return "PUT";
   }
   if(strtoupper(form("_method")) === strtoupper("delete")){
      return "DELETE";
   }
   return "GET";
}

function form($key){
   if(!empty($_POST[$key])){
      return $_POST[$key];
   }
   return false;
}

function redirect_to($path="/"){
   header("Location: {$path}");
   exit();
}

function set_session_message($key,$message){
   if(!empty($key) && !empty($message)){
      session_start();
      $_SESSION[$key] = $message;
      session_write_close();
   }
}

function get_session_message($key){
   $msg = "";
   if(!empty($key) && is_string($key)){
     if(!isset($_SESSION)){session_start();}
      if(!empty($_SESSION[$key])){
         $msg = $_SESSION[$key];
         unset($_SESSION[$key]);
      }
      session_write_close();
   }
   return $msg;
}

function set_flash($msg){
      set_session_message("flash",$msg);
}

function get_flash(){
      return get_session_message("flash");   
}


//logged in 

function signout(){
	session_start();
	$_SESSION['user_id'] = '';
	$_SESSION['first_name'] = '';
	$_SESSION['admin']='';
	unset($_SESSION['user_id']);
	unset($_SESSION['first_name']);
	unset($_SESSION['admin']);
	
	session_write_close();
}


function get_url_id(){
	if(isset($_GET['id'])){
		return $_GET['id'];
	}else{
		return $_GET['id'] ='';
	}
}



