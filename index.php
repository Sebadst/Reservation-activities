<?php 
session_start();
include('functions.php');
// controllo cookie
check_cookie();


check_https();

check_timeout();


signup();

if(!empty($_GET['msg']))
	echo(htmlentities($_GET['msg']));

if(!empty($_POST['utente']) && !empty($_POST['password']))
	login($_POST['utente'],$_POST['password']);

if(userLoggedIn())
	prenota();

$conn=dbConnect();
$ris=mysqli_query($conn,"select * from attivita order by posti_totali-posti_prenotati desc");




include('header.php');
?>


  <div class="hbg">&nbsp;</div>
  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
		<h2><noscript>Javascript disabilitato. Il sito potrebbe non funzionare bene</noscript></h2>         
         <?php 
  		//mostro le attivita       
         while($riga=mysqli_fetch_array($ris)){
         	echo("<div class='article'>");
        	echo("<h2>".$riga['nome']."</h2>");
         	echo("<div class='clr'></div>");
         	echo("<p>Luogo:".$riga['luogo']." </p>");
         	echo('<img src="images/'.$riga['immagine'].'" width="263" height="146" alt="" class="fl" />');
         	echo("<p>".$riga['descrizione']."</p>");
         	echo('<p class="spec"> Posti totali: '.$riga['posti_totali'].'</p>');
          	echo('<p class="spec"> Posti prenotati: '.$riga['posti_prenotati'].'</p>');
          	//do la possibilita di prenotare
          	if(userLoggedIn()){
         		echo('<form action="index.php" method="post" name="prenotazione'.$riga['nome'].'">');
          		echo('N. Adulti (1)<input type="text" value="1"  readonly name="adulto'.$riga['nome'].'" />');
          		echo('N. Bambini (0-3)<select name="bambini'.$riga['nome'].'" >');
          		echo('<option value="0" selected>0</option>
          			<option value="1">1</option>
  					<option value="2">2</option>
  					<option value="3">3</option>
  					</select>');
           		echo('<input type="submit" value="prenota"  />');
     
         		echo('</form>');
				
          
        	}
          
         
         	echo("</div>");
         }
         mysqli_free_result($ris);
         mysqli_close($conn);
        
          ?>
         
         
         
         
         
          </div>
      <div class="sidebar">
        <div class="gadget">
          <h2 class="star">Menu</h2>
          <div class="clr"></div>
           <form action="index.php" name="login" method="post">
          <ul class="sb_menu">
         
            <li><a href="index.php">Home</a></li>
            <li><a href="prenotazione.php">Visualizza prenotazioni</a></li> 
            
            <?php 
            if(!userLoggedIn()){
            
            	echo('<li><p> Login</p></li>');
            	echo('<li>Username<input type="text" name="utente" maxlength="25" placeholder="Username, max 25"/></li>');
            	echo('<li>Password<input type="password" name="password" maxlength="25" placeholder="Password, max 25"/></li>');
            	echo('<li><input type="submit" value="Login"/></li>');
            }
            ?>
          </ul>
           </form>
           <?php 
           if(!userLoggedIn())
           		echo('<a href="signup.php">Sign up</a>');
          ?>
        </div>
       
      </div>
      
      <div class="clr"></div>
    </div>
  </div>
 </div>
</body>
</html>
  