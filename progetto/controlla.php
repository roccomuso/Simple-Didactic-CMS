<?php

require_once("config.php");		# Dati connessione database Mysql

//controllo dei dati d'accesso dal database.
$email = mysql_escape_string($_POST['email']);        //con mysql_escape_string preveniamo eventuali attacchi di sql injection
$pass = md5(mysql_escape_string($_POST['password']));

if ($email && $pass) {
$query_login = mysql_query("SELECT * FROM `utenti` WHERE `email` = '$email' AND `password` = '$pass'");
$utenti = mysql_fetch_array($query_login);
if (mysql_num_rows($query_login)){ //se la query restituisce risultati avrà trovato l'utente nel DB.

	session_start();
	$_SESSION['login'] = "ok"; //facendo il confronto su questa componente sappiamo se è attualmente loggato l'utente.
	$_SESSION['username'] = $utenti['username'];
	$_SESSION['nome'] = $utenti['nome'];
	$_SESSION['cognome'] = $utenti['cognome'];
	$_SESSION['ruolo'] = $utenti['ruolo'];
	$_SESSION['id_utente'] = $utenti['id_utente'];
	
	//login effettuato
	header("Location: $_SERVER[HTTP_REFERER]");
  }else { header("Location: index.php?errore-login"); }
  
} else {

	header("Location: index.php?errore-login");
}

?>