<?php 
session_start();
include('functions.php');
check_cookie();

check_https();

check_timeout();




if(!userLoggedIn())
myRedirect("Non sei registrato");
disdici();

include('header.php');

?>


  <div class="hbg">&nbsp;</div>
  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
      <h2><noscript>Javascript disabilitato. Il sito potrebbe non funzionare bene</noscript></h2>       
   
         <?php 
         	$conn=dbConnect();
         	$ris=mysqli_query($conn,"select * from prenotazioni p,attivita a where p.attivita=a.nome and  username='".$_SESSION['utentesds']."'");
         
         	
         	while($riga=mysqli_fetch_array($ris)){
         		
         		echo("<div class='article'>");
          		echo("<h2>".$riga['attivita']."</h2>");
          		echo("<div class='clr'></div>");
          		echo("<p>Luogo:".$riga['luogo']." </p>");
          		echo('<img src="images/'.$riga['immagine'].'" width="263" height="146" alt="" class="fl" />');
         		echo("<p>".$riga['descrizione']."</p>");
          	 	echo('<p class="spec"> Posti prenotati: '.$riga['numero_posti'].'</p>');
        		
          	 	echo('<form action="prenotazione.php" name="disdici'.$riga['attivita'].'" method="post">');
          	 	echo('<input type="submit" value="disdici" name="disdici'.$riga['attivita'].'"  />');
          	 	
          	 	echo('</form>');
          	 	echo('</div>');
         	 }
         	mysqli_free_result($ris);
         	mysqli_close($conn);
         
         ?>
         
         
         
          </div>
      <div class="sidebar">
        <div class="gadget">
          <h2 class="star">Menu</h2>
          <div class="clr"></div>
           <form action="" name="login">
          <ul class="sb_menu">
         
            <li><a href="index.php">Home</a></li>
            <li><a href="prenotazione.php">Visualizza prenotazioni</a></li> 
            <li><h2 class="star">Hello <?php echo(htmlentities($_SESSION['utentesds'])); ?></h2></li>
            <li><h2 class="star">Ecco le tue prenotazioni</h2></li>
           
          </ul>
           </form>
        </div>
        </div>
      
      <div class="clr"></div>
    </div>
  </div>
  
</div>
</body>
</html>
