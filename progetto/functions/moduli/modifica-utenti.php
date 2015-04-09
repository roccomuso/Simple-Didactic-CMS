<?php //Questa pagina viene inclusa da altri script

if (!isset($_SESSION)) { session_start(); }
if ($_SESSION['login'] != "ok") {
	header("Location: ../index.php");
}

 if (!$permessi['mod_utenti']) header("Location: ../admin.php");
 
 if (isset($_GET['delete'])) { //se è stata richiesta la cancellazione dell'utente:
 $id_del = mysql_escape_string($_GET['delete']);
mysql_query("DELETE FROM utenti WHERE `id_utente` = $id_del") or die("Errore nell'esecuzione della query di cancellazione!".mysql_error());
echo "<script>alert('Utente $id_del cancellato!');</script>";
header("Location: admin.php?pag=modifica-utenti");
 }
 
 if (isset($_GET['edit_user'])){ //edita un singolo articolo
$id_usr = mysql_escape_string($_GET['edit_user']);
$user = mysql_fetch_array(mysql_query("SELECT * FROM utenti WHERE `id_utente` = $id_usr"));

  if (@$_POST['form_inviato']){ //esegue le modifiche sul DB
  $username = mysql_escape_string($_POST['username']);
  $nome = mysql_escape_string($_POST['nome']);
  $cognome = mysql_escape_string($_POST['cognome']);
  $email = mysql_escape_string($_POST['email']);
  $ruolo = mysql_escape_string($_POST['ruolo']);
  //controlla se l'username modificato o l'email modificata è già presente nel db
  //nota bene che se questi valori non sono stati modificati verranno comunque passati e saranno già nel db, quindi i controlli se l'username è già presente vengono falsati.

//... CONTINUARE DA QUA  
  
  
 }else{ //stampa il form per la modifica
 $usr = mysql_fetch_array(mysql_query("SELECT * FROM utenti WHERE id_utente = $id_usr"));
  echo "<center><h2>MODIFICA UTENTE: $id_usr</h2><br/>";
 echo "<p>
 <form action='' method='POST'>
 <input type='hidden' value='1' name='form_inviato'>
 ID utente: <input type='text' name='id_utente' value='$id_usr' disabled='disabled'><br/>
 Username: <input type='text' name='username' value='$usr[username]'><br/>
 Nome: <input type='text' name='nome' value='$usr[nome]'><br/>
 Cognome: <input type='text' name='cognome' value='$usr[cognome]'><br/>
 Email: <input type='text' name='email' value='$usr[email]'><br/>";
 ?>
 Cambia password: <input type='password' name='password' value=''><br/>
 Ruolo: <select name='ruolo'>
 <?php
 $qry_ruolo = mysql_query("SELECT ruolo FROM permessi");
if ($_SESSION['ruolo'] != "amministratore") $ok = 0; else $ok = 1;
 while($ruolo = mysql_fetch_array($qry_ruolo)){
if ($ruolo['ruolo'] != "amministratore" || $ok){ //agli utenti che non siano amministratori non è permesso modificare un utente per farlo diventare amministratore
$selected = ($ruolo['ruolo'] == $usr['ruolo']) ? "selected": "";
echo "<option value='$ruolo[ruolo]' ".$selected.">$ruolo[ruolo]</option>";
  }
} ?>
 </select>
 <br/><br/>
 <input type='submit' name='invia' value='Invia Modifiche'>
 </form>
 <?php
 
 echo "</p></center>";
 }
 
 }
 
?>
<center><h2>MODIFICA UTENTI</h2></center><br/><br/>
<p>
<center>
<table border='1' style='font-size: 12px'>
<tr><td><b>ID</b></td><td><b>Username</b></td><td><b>Nome</b></td><td><b>Cognome</b></td><td><b>email</b></td><td><b>Ruolo</b></td><td><b>Modifica</b></td><td><b>Elimina</b></td></tr>
<?php 
$qry_users = mysql_query("SELECT * FROM utenti");
while ($utente = mysql_fetch_array($qry_users)){
echo "<tr><td>$utente[id_utente]</td><td>$utente[username]</td><td>$utente[nome]</td><td>$utente[cognome]</td><td>$utente[email]</td><td>$utente[ruolo]</td><td><a href='$_SERVER[PHP_SELF]?pag=modifica-utenti&edit_user=$utente[id_utente]'>Modifica</a></td><td><a href='$_SERVER[PHP_SELF]?pag=modifica-utenti&delete=$utente[id_utente]' onClick=\"return confirm('Sei sicuro di voler cancellare questo utente?');\">Elimina</a></td></tr>";
}
?>
</table>
</center>
</p>