<?php
function check_cookie(){
	setcookie('testsds', '1', time()+3600);
	if(!isset($_COOKIE['testsds']) || $_COOKIE['testsds']!='1'){
		header("location: check_cookie.php");
		exit();
	}
}

function check_https(){
	if($_SERVER["HTTPS"] != "on")
	{
    	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    	exit();
	}
}

function check_timeout(){
	if(isset($_SESSION['last_activitysds'])){
		if( $_SESSION['last_activitysds'] < time()-$_SESSION['expire_timesds'] ) { //passati due minuti
 	   //redirect to logout.php
    	header('Location: logout.php'); 
    	exit();
	} 
		else{ 
    		$_SESSION['last_activitysds'] = time(); //momento di ultima attivita
		}
	}
}

function myDestroySession() {
	$_SESSION=array();
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		
		setcookie(session_name(), '', time()-3600*24,
		$params["path"],$params["domain"],
		$params["secure"], $params["httponly"]);
	}
	session_destroy(); // destroy session
	header('location: index.php?msg=Logout'); // redirct to certain page now
	exit();
}

function userLoggedIn(){
	if(isset($_SESSION['utentesds'])){
		return($_SESSION['utentesds']);
	}
	else{
		return false;
	}
}

function myRedirect($msg="") {
	header('HTTP/1.1 307 temporary redirect');
	// L’URL relativo è accettato solo da HTTP/1.1
	header("Location: index.php?msg=".urlencode($msg));
	exit; // Necessario per evitare ulteriore
	// processamento della pagina
}	




function dbConnect(){
	$conn = mysqli_connect("localhost","s218219","erivouth","s218219");
	if(mysqli_connect_error())
	{ echo("Errore di collegamento al DB"); }
	else return $conn;
}



function login($utente,$password){
	//se gia loggato
	if(isset($_SESSION['utentesds']))
		echo("sei loggato");
		
	else if(!empty($_POST['utente']) && !empty($_POST['password']))
	//controllo lunghezza
		if(strlen($_POST['utente'])<=25 && strlen($_POST['password'])){
			$conn=dbConnect();	
			//escape delle stringhe immesse
			$utente = mysqli_real_escape_string($conn,$utente);
			$password= mysqli_real_escape_string($conn,$password);
			//controllo se presente nel db
			
			
			$sql = "SELECT username,password FROM utenti WHERE username = '" . $utente . "' and password=md5('".$password."')";
			if(!$risposta = mysqli_query($conn,$sql)){
				echo("errore");
			}	//myRedirect("Errore di collegamento al DB"); }
			if (mysqli_num_rows($risposta) == 0) {
				echo("utente o passw errata");	
				mysqli_free_result($risposta);
			}
				//myDestroySession(); // logout
				//myRedirect("Utente o password errata"); }
			else{
				$_SESSION['utentesds']=$utente;
				//per il timeout
				$_SESSION['last_activitysds'] = time(); //your last activity was now, having logged in.
				$_SESSION['expire_timesds'] = 2*60;
			
				$riga = mysqli_fetch_array($risposta);
				
				echo("Welcome ".htmlentities($riga['username']));		
				mysqli_free_result($risposta);
			}
			mysqli_close($conn);
	}
	
}



function signup(){
	if(!userLoggedIn()){
		if(!empty($_POST['utente'])&& !empty($_POST['password']) && !empty($_POST['repassword'])){
			$conn=dbConnect();
			//escape delle stringe
			$_POST['utente'] = mysqli_real_escape_string($conn,$_POST['utente']);
			$_POST['password'] = mysqli_real_escape_string($conn,$_POST['password']);
			$_POST['repassword'] = mysqli_real_escape_string($conn,$_POST['repassword']);
			//controllo se l'username e' gia' presente
			if($_POST['password']!=$_POST['repassword']){
				echo("Campi password e ripeti password diversi ");
			}
			
			else if(strlen($_POST['utente'])<=25 && strlen($_POST['password']<=25)){
				if(!$ris=mysqli_query($conn,"select username from utenti where username='".$_POST['utente']."' for update"))
					echo("errore connessione 1");
				else{
					if (mysqli_num_rows($ris) != 0){
						echo("nome utente gia' presente ");
						$_POST['utente']="";	//fatto per evitare di rientrare a provare il login
						mysqli_free_result($ris);			
					}
					else{
						mysqli_free_result($ris); //controllare
						if(!$res=mysqli_query($conn,"insert into utenti(username,password) values('".$_POST['utente']."',md5('".$_POST['password']."')) "))
						{
							echo("errore di connessione 2");}
							else{ 
								echo("Registrazione avvenuta con successo!");
								$_SESSION['utentesds']=$_POST['utente'];
								$_SESSION['last_activitysds'] = time(); //your last activity was now, having logged in.
								$_SESSION['expire_timesds'] = 2*60;
								}
						}
					
				}
		
			mysqli_close($conn);
			}
		}
	}
}

function disdici(){
	$conn=dbConnect();
	//join su attivita tra prenotazioni di un certo utente e attivita
    $ris=mysqli_query($conn,"select * from prenotazioni p,attivita a where p.attivita=a.nome and  username='".$_SESSION['utentesds']."'");
    	
     while($riga=mysqli_fetch_array($ris)){
         //controllo se uno di questi e' stato settato. (il nome degli input e' disdicinomeattivita	)	
         if(!empty($_POST['disdici'.$riga['attivita']])){
         	//con la transazione elimino la prenotazione e risetto i posti liberi
         	try{
         		$_POST['disdici'.$riga['attivita']]= mysqli_real_escape_string($conn,$_POST['disdici'.$riga['attivita']]);
				mysqli_autocommit($conn,false);
					
				if(!mysqli_query($conn,"delete  from prenotazioni where attivita='".$riga['attivita']."' and username='".$_SESSION['utentesds']."'"))
						throw new Exception("query 1 fallita");
				if(!mysqli_query($conn,"update attivita set posti_prenotati:=posti_prenotati-".$riga['numero_posti']." where nome='".$riga['attivita']."'"))
						throw new Exception("query 2 fallita");
				if (!mysqli_commit($conn)) {
						throw Exception("Commit fallita");
					}
        		echo("cancellazione effettuata con successo");
          		break;
         		}
          	catch(Exception $e) {
					mysqli_rollback($conn);
					echo "Rollback ".$e->getMessage();
          	}
		 }
	}
	mysqli_free_result($ris);
    mysqli_close($conn);
}

function prenota(){
	if(userLoggedIn()){
	
		$conn=dbConnect();
	    $ris=mysqli_query($conn,"select * from attivita order by posti_totali-posti_prenotati desc");
	    while($riga=mysqli_fetch_array($ris)){
	        
			if(!empty($_POST['adulto'.$riga['nome']]) ){
				//se bambini non e' settato assumo sia zero
				if(empty($_POST['bambini'.$riga['nome']]))
					$_POST['bambini'.$riga['nome']]=0;
				
	          	//controllo se c'erano ancora posti
	          	$riga['nome']=mysqli_escape_string($conn,$riga['nome']);
	          	$res=mysqli_query($conn,"select * from attivita where nome='".$riga['nome']."' for update");
	          	$row=mysqli_fetch_array($res);
	          	//non controllo la var adulto perche assumo che sia uno
	          	$_POST['bambini'.$riga['nome']]= mysqli_real_escape_string($conn,$_POST['bambini'.$riga['nome']]);
				
	          	//CONTROLLO CHE SIA UN NUMERO QUELLO DEI BAMBINI
	          	if (ctype_digit($_POST['bambini'.$riga['nome']])) 
	    			if($_POST['bambini'.$riga['nome']]<=3){
				
	          			if(($row['posti_totali']-$row['posti_prenotati'])<($_POST['bambini'.$riga['nome']]+1)){
	          				echo("Non ci sono piu' posti per questa struttura");
	          			}
	          			else{
	          				//uso la transazione per modificare atomicamente le due tabelle
	          		
	          				//VEDERE SE VA BENE DI FARLO COL ROLLBACK IL FATTO CHE E' GIA ISCRITTO O SE CONTROLLARE CON UNA SELECT
	          				try{
	          					mysqli_autocommit($conn,false);
	          					if(!mysqli_query($conn,
	          					"update attivita set posti_prenotati:=posti_prenotati+1+".$_POST['bambini'.$riga['nome']]." where nome='".$riga['nome']."' "))
	          						throw new Exception("query 1 fallita");
	          					$_POST['bambini'.$riga['nome']]++;
	          			        			
	          					if(!mysqli_query($conn,
	          					"insert into prenotazioni(username,attivita,numero_posti) values('".$_SESSION['utentesds']."','".$riga['nome']."','".$_POST['bambini'.$riga['nome']]."')"))
	          						throw new Exception("Sei gi&agrave; iscritto a questa attivit&agrave;!");
	          					$_POST['bambini'.$riga['nome']]--;
	          					if (!mysqli_commit($conn)) {
									throw Exception("Commit fallita");
								}
	        					echo("prenotazione effettuata");
	          				}
	          				catch(Exception $e) {
								mysqli_rollback($conn);
								echo "Impossibile effettuare l'operazione. ".$e->getMessage();
	          				}
	          				mysqli_free_result($res);	 //         		
	          			}
	         		}
			break;
			}
		
	    }
	    mysqli_free_result($ris);
	    mysqli_close($conn);
	}
}
?>