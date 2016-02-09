<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MyWebsite</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="main">
  <div class="header">
    <div class="header_resize">
      <div class="logo">
        <h1><a href="#"><span>My</span> Website <small>Prenotazione attivit&agrave;</small></a></h1>
      </div>
      <div class="menu_nav">
        <ul>
          <li class="active"><a href="index.php">Home</a></li>
          <?php if(!userLoggedIn())
          echo('<li><a href="signup.php">Sign up</a></li>');
           else
          echo('<li><a href="logout.php">Logout</a></li>');
          ?>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>