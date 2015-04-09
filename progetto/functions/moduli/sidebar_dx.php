<?php
//viene inclusa da altre pagine [connessione al db già stabilità]

if (!isset($_SESSION)) { session_start(); }
if (@$_SESSION['login'] != "ok") header("Location: ../index.php"); //se non si è loggati (quindi se viene richiamata questa pagina direttamente):

/*
si controlla il ruolo. si vede quali permessi sono associati. E ci si regola.
Permessi(Ruolo, lettura, scrittura, pubblicazione, mod_utenti, mod_sito)
*/

//controlliamo i permessi attivi su quel determinato utente e stampiamo nelle sidebar degli appositi widget:  (Ps. alcuni permessi sono deprecati=inutilizzati nelle sidebar).

if ($permessi['mod_sito']) echo "<h3>Modifica Link:</h3>";

if ($permessi['mod_utenti']){ //Widget da mostrare agli utenti con permesso mod_utenti
   //WIDGET ULTIMI UTENTI REGISTRATI
echo "<h3>Ultimi 5 utenti:</h3><p>";
$n_users = 5; //ultimi n utenti da mostrare
$qry_users = mysql_query("SELECT username, nome, cognome FROM utenti ORDER BY id_utente DESC limit 0, $n_users");
while($_users = mysql_fetch_array($qry_users)){
echo "<li>$_users[username] ($_users[nome] $_users[cognome])</li>";
} echo"</p>";
}

//if ($permessi['pubblicazione']) echo "DEPRECATO";
 
if ($permessi['scrittura']){ 
   //WIDGET ULTIMI ARTICOLI
$art_max = 5;
echo "<h3>Ultimi $art_max articoli:</h3><p>";
$q_articles = mysql_query("SELECT titolo, id_articolo, data FROM articoli ORDER BY id_articolo DESC LIMIT 0, $art_max");
while($l_art = mysql_fetch_array($q_articles)){
echo "<span style='font-size: 10px'>($l_art[data])</span><br/><a href='$_SERVER[PHP_SELF]?pag=gestisci-articoli&edit_art=$l_art[id_articolo]' target='_new'>$l_art[titolo]</a><br/>";
}
echo "</p>";
}


if ($permessi['lettura']){ 
   // WIDGET DATI PROFILO
echo "<h3>Dati profilo:</h3>";
$q_profilo = mysql_query("SELECT * FROM utenti WHERE id_utente = $_SESSION[id_utente]");
$profilo = mysql_fetch_array($q_profilo);
echo "<p>Username: <em>$profilo[username]</em><br/>
Nome: <b>$profilo[nome]</b><br/>
Cognome: <b>$profilo[cognome]</b><br/>
Email: <span style='font-size: 11px'>$profilo[email]</span><br/>
Ruolo: $profilo[ruolo]<br/>
</p>";

}

?>