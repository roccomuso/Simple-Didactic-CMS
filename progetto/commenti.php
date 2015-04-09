<?php
//questo script viene incluso dalle altre pagine.

$id_articolo = $art['id_articolo'];
//preleviamo tutti i commenti associati all'articolo attualmente visualizzato:
$commenti_query = mysql_query("SELECT * FROM `commenti` WHERE art_commentato = $id_articolo ORDER BY data ASC");

while($commenti = mysql_fetch_array($commenti_query)){
echo "<p># <b> $commenti[utente]</b> ha scritto in data <b>$commenti[data]</b>:<br/> <span style='margin-left:15px; font-family: Courier'>$commenti[testo_commento] </span></p><br/>";

}

//form per inviarne di nuovi. (bisogna essere registrati per inviarne)
echo "<center><h3>Invia un nuovo commento:</h3></center>";

if (isset($_SESSION['username'])){

?>
<div style="margin-left: 15px">
<form action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>&comment" method="POST">
<input type="text" name="utente" value="<?php echo "$_SESSION[username] ($_SESSION[nome] $_SESSION[cognome])"; ?>" disabled="disabled" /><br/>
<textarea rows="5" cols="35" name="testo_commento"></textarea><br/>
<input type="reset" value="Cancella">
<input type="submit" name="invio" value="Invia" /> 
</form>
</div>
<?php

   if (isset($_GET['comment'])){
    $utente          = $_SESSION['username'];
	$testo_commento  = mysql_escape_string($_POST['testo_commento']);
	
	if(mysql_query("INSERT INTO `commenti` (`art_commentato`, `testo_commento`, `utente`, `data`) VALUES ('$id_articolo', '$testo_commento', '$utente', NOW());"))
	{
	  echo "<center><font color='green' size='4'>Commento inserito! Redirect in corso...</font></center>";
	  echo "<META HTTP-EQUIV='REFRESH' CONTENT='3; URL=index.php?id_articolo=$id_articolo'>";
      
	 }
	 
	}

}else{

echo "<p><center><font color='red'>Per lasciare un commento è necessario effettuare il login.</font></center></p>";
}

?>