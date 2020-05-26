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

get("/signin",function(){
   force_to_http("/?signin");
   $messages["title"] = "Sign in";
   render($messages,"standard","signin");
});

get("/signup",function(){
   force_to_http("/?signup");
   $messages["title"] = "Sign up";
   render($messages,LAYOUT,"signup");
});

get("/change",function(){
   force_to_http("/?change");
   $messages["title"] = "Change password";
   render($messages,LAYOUT,"change_password");
});


get("/signout",function(){
   force_to_http("/signout");
   // set a session message
   set_flash("You are now signed out.");
   
   //Now we destroy the session. Should this go here in the controller or in the model?
   signout();
   //we don't render anything here because we are about to redirect to the home page
   redirect_to("/user_page");
});


post("/signup",function(){
  set_flash("Lovely, you are now signed up,".form('name'));
  redirect_to("/");
});



put("/?change",function(){
  set_flash("Password is changed");
  redirect_to("/");
});

/* ......Editor Section or Admin Section ..........*/
get("/user_page/editor",function(){
	
	if(!empty($_SESSION['user_id'])&& $_SESSION['admin']==="admin") {
   force_to_http("/user_page");
   $messages["message"]="Welcome";
   $messages["title"] = "User-Home";
   render_user($messages,"admin","editor","editor_page");
	}else{
		redirect_to("/user_page/login");
	}
	
});
get("/editor",function(){
	
	if(!empty($_SESSION['user_id'])&& $_SESSION['admin']==="admin"){
   force_to_http("/editor");
  
   $messages["title"] = "Editor-Home";
	$messages["data"] = get_all_post();
   render_user($messages,"admin","editor","editor_page");
	}else{
		redirect_to("/?user_page/login");
	}
	
});

get("/editor/post",function(){
	
	if(!empty($_SESSION['user_id']) && $_SESSION['admin']=="admin"){
		force_to_http("/editor/post");
		$messages["title"] = "User-post";
		$messages["published"] = get_all_post_by_status("published");
		$messages["unpublished"] = get_all_post_by_status("unpublished");
		
		render_user($messages,"admin","post","editor_page");
	}else{
		redirect_to("/user_page/login");
	}
});
// get id 
$get_id = get_url_id();
get("/editor/post/edit/?id={$get_id}",function(){
	if(!empty($_SESSION['user_id']) && $_SESSION['admin']=="admin"){
		
			$article_id = get_url_id();
			if(get_data_by_article_id($article_id)){
				force_to_http("/editor/edit");
				$messages["title"] = "Edit Page";
				$messages["data"] = get_data_by_article_id($article_id);
				render_user($messages,"admin","edit_post","editor_page");
			}else{
				error_404();
			}
	}
});


/* ......User Section ..........*/
get("/user_page/login",function(){
	if(!empty($_SESSION['user_id']) && $_SESSION['admin']=="admin"){
		redirect_to("/editor");
	}elseif(!empty($_SESSION['user_id']) && $_SESSION['admin']!=="admin"){
		redirect_to("/user_page");
	}else{
		force_to_http("/user_page/login");
		$messages["message"]="Welcome";
		$messages["title"] = "Login";
		render_user($messages,LAYOUT,"login", "user_page");
	}
});


get("/user_page",function(){
	
	if(!empty($_SESSION['user_id']) && $_SESSION['admin']!=="admin" ){
   force_to_http("/user_page");
   $messages["message"]="Welcome";
   $messages["title"] = "User-Home";
   render_user($messages,LAYOUT,"home", "user_page");
	}else{
		redirect_to("/user_page/login");
	}
	
});

get("/user_page/post",function(){
	
	if(!empty($_SESSION['user_id']) && $_SESSION['admin']!=="admin"){
   force_to_http("/user_page");
   $messages["title"] = "User-post";
	$messages["data"] = get_data_by_user_id();
   render_user($messages,LAYOUT,"post", "user_page");
	}else{
		redirect_to("/user_page/login");
	}
});

//login.
post("/login",function(){
	if(!empty(form('email')) && !empty(form('password'))){
		
		$username = form('email');
		$password = form('password');
		if(logged_in($username, $password)){
			if($_SESSION['admin']==="admin"){
				set_flash("You are now signed in as an Editor!");
				redirect_to("/editor");
			}else{
			set_flash("Lovely, you are now signed in!");
			redirect_to("/user_page");
			}
		}else{
			set_flash("Username/Passoword is did not match");
			redirect_to("/user_page/login");
		}
		
	}else{
		set_flash("Username/Passoword is required");
		redirect_to("/user_page/login");
	}
  
});
//add article
post("/user_page/post/add",function(){
	if(!empty(form('post-title')) && !empty(form('post-description') && !empty(form('post-date')))){
		
		$title = form('post-title');
		$description = form('post-description');
		$date = form('post-date');
		$result=insert_post_data($title, $description, $date, $_SESSION['user_id']);
		
		if($result>1){
			set_flash("Post Added");
			redirect_to("/user_page/post");
			
		}else{
			set_flash("Post did not add!");
			redirect_to("/user_page/post");
		}
		
	}else{
		
		redirect_to("/user_page/post");
	}
  
});

//delete article
post("/delete",function(){
	if(!empty(form('delete'))){
		
		$article_id = form('delete');
		
		if(delete_article_by_id($article_id)){
			set_flash("Article has been deleted");
			redirect_to("/editor/post");
			
		}
	}
  
});

put("/edit/update",function(){
  if(!empty(form('post-title')) && !empty(form('post-description'))){
		
		$title = form('post-title');
		$description = form('post-description');
	  	if(!empty(form('status'))){
	  		$status = form('status');
		}else{
			$status = form('default_value');
		}
	  	$article_id = form('id');
		$data =array($title,$description,$status, $article_id);
		if(update_article_by_id($data)==1){
			set_flash("Changes has been saved");			
			redirect_to("/editor/post");
			
		}else{
			set_flash("Post did not save.");
			redirect_to("/editor/post");
		}
		
	}else{
		
		redirect_to("/editor/post");
	}
});



error_404();
session_write_close();
?>

