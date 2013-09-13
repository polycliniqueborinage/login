<?php

	// Demarre une session
	session_start();

	if(isset($_SESSION['nom'])) {
		unset($_SERVER['application']);
		session_destroy();
	}

	// Inclus le fichier contenant les fonctions personalisées
	include_once './lib/fonctions.php';
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "index.php";
	
	$erreur = 'Veuillez entre votre login et mot de passe';
	// secure
	//$supersecret_hash_padding = "Je suis une phrase secrète et biensur que je suis le seul à la connaitre enfin je l'espère... ;-)";
	
	// VERIF DATE EXPIRATION
	$sql = "SELECT date_format(now(), '%Y-%m-%d') as date_jour, valeur as date_expiration, DATE_FORMAT(valeur, GET_FORMAT(DATE, 'EUR')) as date_expiration_eur FROM dates WHERE champs='expiration'"; 
	
	//echo $sql;
	
	//$result = mysql_query($sql);
	$nbrResult = 1;
	
	if ($nbrResult == 1 ) {
		
		//$data = mysql_fetch_assoc($result);
		//$dateJour = $data['date_jour'];
		//$dateExpiration = $data['date_expiration'];
		//$dateExpirationEur = $data['date_expiration_eur'];
		
		if (true) {
			
			// Variables du formulaire
			$action = isset($_POST['action']) ? $_POST['action'] : '';  
			$login = isset($_POST['login']) ? $_POST['login'] : '';
			$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
			$application = isset($_POST['application']) ? $_POST['application'] : '';
	
			//securitsation des données
			if (strlen($login) <= 25 && strlen($pass) <= 25 && strlen($application) <= 25) {

				// Allow them to register
				// Si le login et pass on été au préalable cryptés en md5 dans l'exemple) dans votre base
				$login  = trim($login);
				$pass   = (trim($pass));
	
				if ($action == 1) {
		
					$sql = "SELECT nom, prenom, role, login, inami, application, droit FROM users WHERE login='$login' AND password=md5('$pass') AND application like '%$application%'";


					
					$result = mysql_query($sql);
					$n = mysql_num_rows($result);
		
		    		if ($n == 1 AND $login != "" AND $pass != "" and $application != "") {
			
						$data = mysql_fetch_assoc($result);
		
						// store session data
						$_SESSION['nom']=$data['nom'];
						$_SESSION['prenom']=$data['prenom'];
						$_SESSION['role']=$data['role'];
						$_SESSION['login']=$data['login'];
						$_SESSION['inami']=$data['inami'];
						$_SESSION['application']=$application;
						$_SESSION['droit']=$data['droit'];
						
						// Deconnection DB
						deconnexion_DB();
						
						
						// redirection suivant application
						switch($application) {
							case "|poly|":
								header('Location: ../poly/menu/menu.php');
								break;
							case "|protocole|":
								header('Location: ../protocole/menu/menu.php');
								break;
							case "|agenda|":
								header('Location: ../agenda/agendas/day.php');
								break;
							default:
								header('Location: ./index.php');
						}
				
	       			} 	else {
						$erreur = "<div class='alert'>Informations incorrectes! - Veuillez entrer un login et un mot de passe corrects</div>";
        			}
				}
			}
		} else {
			
			$erreur = 'La p&eacute;riode d\'utilisation est d&eacute;pass&eacute;e - Contactez votre fournisseur';
			
		}
	}
	



?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<link href="../poly/style/basic.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../poly/style/tabs.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../poly/style/sidebar.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../poly/style/login.css" media="all" rel="Stylesheet" type="text/css">
</head>
<body>
	
	<div id="ribbon">
  		<p>
			<a>Plateforme applicative de la polyclinique : Poly / Protocole</a>
		</p>
	</div>
	
    <div id="topcalendrier">
		
		<h1>Authentification des utilisateurs</h1>
		
	</div>
    
	<div id="middle">
    	
		<div id="header">
		</div>        
      
	  	<div class="dojoTabPanelContainer" id="main">
        
			<div id="ctr" align="center">

				<div class="login">
				
					<div class="login-form">
					
						<img alt="Login" src="./images/login.gif"/>
						<form id="loginForm" name="loginForm" method="post" action="<?=$nom_fichier?>">
							
							<input type='hidden' name='action' value='1'>
							<div class="form-block">
								<div class="inputlabel">Login de l'utilisateur :</div>
								<div>
									<input class="inputbox" type="text" size="15" name="login"  autocomplete='off'/>
								</div>
								<div class="inputlabel">Mot de passe :</div>
								<div>
									<input class="inputbox" type="password" size="15" name="pass"  autocomplete='off'/>
								</div>
								<div class="inputlabel">Application :</div>
								<div>
									<select id='application' name='application' title='Choisir son application'>
										<option value="|poly|">Poly</option>
										<!-- option value="|protocole|">Protocoles</option-->
										<option value="|agenda|">Agenda</option>
									</select>
								</div>
								<br/>
								<div align="left">
									<input class="button" type="submit" value="Login" name="submit"/>
								</div>
							</div>
						</form>
					
					</div>
					
					<div class="login-text">
						<div class="ctr">
							<img width="64" height="64" alt="security" src="./images/security.png"/>
						</div>
						<p><b>Bienvenu sur la plateforme applicative de la Nouvelle Polyclinique du Borinage</b></p>
						<p><?=$erreur?></p>
					</div>
					<div class="clr"/>
				</div>
				
			</div>
			<div id="space"/>
		
		</div>
	
	</div>

</body>
</html>

									


