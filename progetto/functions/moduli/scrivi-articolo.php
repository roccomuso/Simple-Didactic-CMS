<?php //Questa pagina viene inclusa da altri script

if (!isset($_SESSION)) { session_start(); }
if ($_SESSION['login'] != "ok") {
	header("Location: ../index.php");
}

 if (!$permessi['scrittura']) header("Location: ../admin.php");
 
 if (@$_POST['form_inviato']){ //articolo inviato, lo salviamo nel DB.
 $titolo = mysql_escape_string($_POST['titolo']);
 $testo = mysql_escape_string($_POST['testo']);
 $meta_desc = mysql_escape_string($_POST['meta_description']);
 $categoria = mysql_escape_string($_POST['categoria']);
 $tags = mysql_escape_string($_POST['tags']);
 $evid = mysql_escape_string($_POST['evidenza']);
 $azione = mysql_escape_string($_POST['azione']);
 
 mysql_query("INSERT INTO `articoli` (`id_articolo`, `titolo`, `testo`, `meta_description`, `id_categoria`, `tags`, `id_autore`, `data`, `in_evidenza`, `pubblicato`) VALUES (NULL, '$titolo', '$testo', '$meta_desc', '$categoria', '$tags', '$_SESSION[id_utente]', NOW(), '$evid', '$azione');") or die("<h3>Errore nell'esecuzione della query</h3>".mysql_error());
 $ok = "<font color='green' size='5'>Articolo inviato con successo!</font><br/>Scrivine un altro:<br/><br/>";
 }
 // Mostra il form per la scrittura di un nuovo articolo.
?>
<center><h2>SCRIVI ARTICOLO</h2></center><br/>
<p>
<center> <?php echo @$ok; ?>
<form action='' method='POST'>
<input type='hidden' value='1' name='form_inviato'>
<input type='text' name='titolo' value='Titolo' size='35'><br/><br/>
<textarea rows='10' cols='50' name='testo'>Testo articolo... [HTML attivo]</textarea><br/><br/>
<input type='text' name='meta_description' value='descrizione breve...' size='50'><br/><br/>
<input type='text' name='tags' value='tags separati da virgola' size='50'><br/><br/>
Categoria:
<select name='categoria'>
<?php
$qry_categ = mysql_query("SELECT id_categoria, nome_categoria FROM categorie");
while($categoria = mysql_fetch_array($qry_categ)){
echo "<option value='$categoria[id_categoria]'>$categoria[nome_categoria]</option>";
}
?>
</select>
<br/><br/>
Metti in Evidenza:
<select name='evidenza'>
<option value='0'>No</option>
<option value='1'>Si</option>
</select>
<br/><br/>
Azione:
<select name='azione'>
<?php if ($permessi['pubblicazione']) echo "<option value='1'>Pubblica</option>"; ?>
<option value='0'>Salva in bozze</option>
</select>
<br/><br/>
<input type='submit' value='Invia Articolo'>

</form>
</center>
</p>
