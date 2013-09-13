<?php
function connexion_DB($name_DB) {
// Déclaration des paramètres de connexion
	$host = "localhost";  
	$user = "poly";
	//$user = "root";
	$bdd = $name_DB;
	$passwd  = "halifax";
	//$passwd  = "";
// Connexion au serveur
	mysql_connect($host, $user,$passwd) or die("erreur de connexion au serveur");
	mysql_select_db($bdd) or die("erreur de connexion a la base de donnees");
}

// --------------------------------------------------------------------------------------------------------------------------
// Deconnection de la DB
function deconnexion_DB() {
	mysql_close();
}

// --------------------------------------------------------------------------------------------------------------------------
// Exécute une requète SQL. Si la requête ne passe pas, renvoir le message d'erreur MySQL
// Paramètres : chaine SQL -> $strSQL
// Renvoie : enregistrements correspondants -> $result
function requete_SQL($strSQL) {
	$result = mysql_query($strSQL);
	if (!$result) {
		$message  = 'Erreur SQL : ' . mysql_error() . "<br>\n";
		$message .= 'SQL string : ' . $strSQL . "<br>\n";
		$message .= "Merci d'envoyer ce message au webmaster - targoo@gmail.com";
		die($message);
	}
	return $result;
}
?>
