<?php
session_start();
# Set to noisy error reporting for development. Comment out later for production mode.
ini_set('display_errors','On');
//error_reporting(E_ERROR | E_PARSE);

# Paths
DEFINE("LIB",$_SERVER['DOCUMENT_ROOT']."/lib");

DEFINE("VIEWS",LIB."/views");
DEFINE("PARTIALS",VIEWS."/partials");

# Paths to actual files
DEFINE("DB",LIB."/db.php");
DEFINE("APP",LIB."/application.php");

# Define a layout
DEFINE("LAYOUT","standard");

require DB;
require APP;


//Global, damn it! Oh well we'll take care of this somehow later on ... stay tuned. It is also used in two files: here and Application.php. This makes this approach "brittle" and prone to error if we are not careful.

$messages = array();

get("/",function(){
   force_to_http("/");
   $messages["message"]="Welcome";
   $messages["title"] = "Home";
   render($messages,LAYOUT,"home");
});

get("/?signin",function(){
   force_to_http("/?signin");
   $messages["title"] = "Sign in";
   render($messages,"standard","signin");
});

get("/?signup",function(){
   force_to_http("/?signup");
   $messages["title"] = "Sign up";
   render($messages,LAYOUT,"signup");
});

get("/?change",function(){
   force_to_http("/?change");
   $messages["title"] = "Change password";
   render($messages,LAYOUT,"change_password");
});


get("/?signout",function(){
   force_to_http("/?signout");
   // set a session message
   set_flash("You are now signed out.");
   
   //Now we destroy the session. Should this go here in the controller or in the model?
   signout();
   //we don't render anything here because we are about to redirect to the home page
   redirect_to("/?user_page");
});


post("/?signup",function(){
  set_flash("Lovely, you are now signed up,".form('name'));
  redirect_to("/");
});

post("/?login",function(){
set_session_user();
  set_flash("Lovely, you are now signed in!");
  
  redirect_to("/?user_page");
});

put("/?change",function(){
  set_flash("Password is changed");
  redirect_to("/");
});


//user section 
get("/?user_page/login",function(){
   force_to_http("/?user_page");
   $messages["message"]="Welcome";
   $messages["title"] = "Login";
   render_user($messages,LAYOUT,"login");
});

get("/?user_page",function(){
	if(!empty($_SESSION['user_id'])){
   force_to_http("/?user_page");
   $messages["message"]="Welcome";
   $messages["title"] = "User-Home";
   render_user($messages,LAYOUT,"home");
	}else{
		redirect_to("/?user_page/login");
	}
});

get("/?user_page/post",function(){
	
	if(!empty($_SESSION['user_id'])){
   force_to_http("/?user_page");
   $messages["title"] = "User-post";
	$messages["data"] = get_data();
   render_user($messages,LAYOUT,"post");
	}else{
		redirect_to("/?user_page/login");
	}
});


session_write_close();

