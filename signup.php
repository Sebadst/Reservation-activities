<?php 
include('functions.php');
session_start(); //se non lo facessi non potrei avere redirect

check_cookie();

check_https();



if(userLoggedIn())
myRedirect("Sei gia' registrato");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MyWebsite | Sign up</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/arial.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
<script>
function validateForm(){
	var n=document.forms["signup"]["utente"].value;
	var x=document.forms["signup"]["password"].value;
	var y=document.forms["signup"]["repassword"].value;
	if(x==null || x=="" || y==null || y=="" || n==null || n==""){
		alert("tutti i campi devono essere compilati");
		return false;
		}
	if(n.length>25){
		alert("username troppo lungo. max 25 caratteri");
		return false;
		}
	if(x!=y){
		alert("I campi password e ripeti password sono diversi!");
		return false;
		}
	else if(x.length>25){
		alert("password troppo lunga. Max 25 caratteri");
		return false;
		}
}
	function checkpwd(){

		var bott = document.getElementById('registra');
	    var pass1 = document.getElementById('pwd');
	    var pass2 = document.getElementById('pwd2');
	    var message = document.getElementById('confirmMessage');
	    var verde = "#66cc66";
	    var rosso = "#ff6666";
	    if(pass1.value == pass2.value){
	        pass2.style.backgroundColor = verde;
	        message.style.color = verde;
	        message.innerHTML = "Passwords ok!"
	    }else{
	        pass2.style.backgroundColor = rosso;
	        message.style.color = rosso;
	        message.innerHTML = "Passwords Diverse!"
	    }
	
}
</script>
</head>
<body>
<div class="main">
  <div class="header">
    <div class="header_resize">
      <div class="logo">
     <h1><a href="#"><span>My</span> Website <small>Prenotazione attivita'</small></a></h1> </div>
      <div class="menu_nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li class="active"><a href="signup.php">Sign up</a></li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="hbg">&nbsp;</div>
  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
        <h2><noscript>Javascript disabilitato. Il sito potrebbe non funzionare bene</noscript></h2>         
   
          <h2>Sign up</h2>
          <div class="clr"></div>
          <form action="index.php" method="post" name="signup" onsubmit="return validateForm()">
            <ol>
              <li>
                <label for="name">Username</label>
                <input name="utente" class="text" maxlength="25" placeholder="Username, max 25"/>
              </li>
              <li>
                <label for="email">Password</label>
                <input type="password" name="password" class="text" id="pwd" onkeyup="checkpwd()" maxlength="25" placeholder="password, max 25"/>
              </li>
              <li>
                <label for="email">Repeat Password</label>
                <input type="password" name="repassword" class="text" id="pwd2" onkeyup="checkpwd()" maxlength="25" placeholder="Ripeti password, max 25"/>
              </li>
              <li>
              <span id="confirmMessage" class="confirmMessage"></span>
              </li>
              <li>
              <input type="submit" value="registrati" id="registra"/>
              </li>
            </ol>
          </form>
        </div>
      </div>
      <div class="sidebar">
        <div class="gadget">
          <h2 class="star">Menu</h2>
          <div class="clr"></div>
          <ul class="sb_menu">
            <li><a href="index.php">Home</a></li>
           
          </ul>
        </div>
       </div>
      
      <div class="clr"></div>
    </div>
  </div>
  
  </div>
</body>
</html>
