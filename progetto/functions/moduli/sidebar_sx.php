<?php
//viene inclusa da altre pagine [connessione al db già stabilità]

if (!isset($_SESSION)) { session_start(); }
if (@$_SESSION['login'] != "ok") header("Location: ../index.php"); //se non si è loggati (quindi se viene richiamata questa pagina direttamente):

/*
si controlla il ruolo. si vede quali permessi sono associati. E ci si regola.
Permessi(Ruolo, lettura, scrittura, pubblicazione, mod_utenti, mod_sito)
*/

//controlliamo i permessi attivi su quel determinato utente e stampiamo nelle sidebar degli appositi widget: (Ps. alcuni permessi sono deprecati=inutilizzati nelle sidebar).

//if ($permessi['mod_sito']) echo "<h3>DEPRECATO</h3>";

if ($permessi['mod_utenti']){ //INIZIO WIDGET DA MOSTRARE PER CHI HA IL PERMESSO mod_utenti

	 //WIDGET ULTIMI COMMENTI:
	 
	 $num_commenti = 5; //quanti commenti vogliamo visualizzare.
	 $lung_commento = 70; //quanti caratteri verranno stampati prima di tagliare la stringa.
	 
	 $qry_lcomment = mysql_query("SELECT * FROM `commenti` ORDER BY data DESC LIMIT 0, $num_commenti");
	 
	 echo "<h3>Ultimi $num_commenti Commenti:</h3>";
	 while($last_comment = mysql_fetch_array($qry_lcomment)){
?>
	<p>
	
	<span style="font-size: 12px;">[<?php echo $last_comment['data']; ?>] <span style="color: green"><?php echo $last_comment['utente']; ?></span>:</span><br/>
	<span style="font-size: 10px; font-weight: bold"><?php echo TagliaStringa($last_comment['testo_commento'], $lung_commento); ?></span><br/>
	 	
	</p>
	 
	 
	 <?php
	 } //FINE WIDGET ULTIMI COMMENTI.
} //FINE permessi mod_utenti

if ($permessi['pubblicazione']){ // INIZIO WIDGET DA MOSTRARE PER CHI HA I PERMESSI DI pubblicazione

 //WIDGET ARTICOLI IN BOZZE
echo "<h3>Articoli in bozze:</h3>"; 
$qry_art_bozze = mysql_query("SELECT username, titolo, data, id_articolo, id_autore FROM articoli JOIN utenti ON (id_autore = id_utente) WHERE pubblicato = 0") or die("Errore nell'eseguire la query".mysql_error());
if (!mysql_num_rows($qry_art_bozze)) echo "<p>Nessun articolo in bozze!</p>";
while ($bozza = mysql_fetch_array($qry_art_bozze)){
?>
<p>
<span style="font-size: 12px;">[<?php echo $bozza['data']; ?>] <span style="color: brown"><?php echo $bozza['username']; ?></span>:</span><br/>
<span style="font-size: 10px; font-weight: bold"><a href='<?php echo "$_SERVER[PHP_SELF]?pag=gestisci-articoli&edit_art=$bozza[id_articolo]";?>'><?php echo $bozza['titolo'];?></a></span>
</p>
<?php
} //FINE WIDGET ARTICOLI IN BOZZE
} //FINE permessi pubblicazione

if ($permessi['scrittura']){ //INIZIO WIDGET DA MOSTRARE PER CHI HA I PERMESSI DI scrittura

   //WIDGET PERMESSI DISPONIBILI
 $user_permessi = mysql_fetch_array(mysql_query("SELECT * FROM `permessi` WHERE `ruolo` = '$_SESSION[ruolo]'"));
   echo "<h3>Permessi disponibili:</h3> 
<p>
[<em>$_SESSION[ruolo]</em>]<br/>
Lettura: $user_permessi[lettura]<br/>
Scrittura: $user_permessi[scrittura]<br/>
Pubblicazione: $user_permessi[pubblicazione]<br/>
mod_utenti: $user_permessi[mod_utenti]<br/>
mod_sito: $user_permessi[mod_sito]
</p>";
//FINE WIDGET PERMESSI DISPONIBILI

} //FINE permessi scrittura



if ($permessi['lettura']) { //INIZIO WIDGET DA MOSTRARE A CHI HA I PERMESSI DI lettura
echo "<h3>Articoli commentati:</h3><p>";
$n_art_comm = 5; //numero di articoli commentati da mostrare
$art_comm_qry = mysql_query("SELECT titolo, id_articolo, art_commentato FROM `commenti` JOIN articoli ON (id_articolo = art_commentato) WHERE utente = '$_SESSION[username]' GROUP BY id_articolo LIMIT 0, $n_art_comm") or die("Errore esecuzione query articoli commentati.".mysql_error());
if (!mysql_num_rows($art_comm_qry)) echo "Nessun articolo commentato";
while($art_comm = mysql_fetch_array($art_comm_qry)){
echo "- <a href='index.php?id_articolo=$art_comm[id_articolo]' target='_new'>$art_comm[titolo]</a><br/>";

}
echo "...</p>";
//FINE WIDGET ARTICOLI COMMENTATI

} //FINE WIDGET PERMESSI lettura

?>

