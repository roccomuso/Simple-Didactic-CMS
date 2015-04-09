<?php 
require("../config.php");

$action 				= @mysql_real_escape_string($_POST['action']); 
$updateRecordsArray 	= @$_POST['recordsArray'];

if ($action == "updateRecordsListings"){
	
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
		$query = "UPDATE `pagine` SET `ordine` = " . $listingCounter . " WHERE `id_pagina` = " . $recordIDValue;
		mysql_query($query) or die('Error, insert query failed'.mysql_error());
		$listingCounter = $listingCounter + 1;	
	}
	
	echo '<pre>';
	print_r($updateRecordsArray);
	echo '</pre>';
	echo 'If you refresh the page, you will see that records will stay just as you modified.';
	echo '<br/>Questa non è altro che la risposta ricevuta dallo script a cui è stata inoltrata la richiesta.';
}

// Controllo username già present nel DB per form di registrazione:
/*
$username = @mysql_real_escape_string($_POST['user']);

$var = mysql_num_rows(mysql_query("SELECT id_utente FROM utenti WHERE username = '$username'"));
if ($var) echo "1";
*/
?>