<?php //Questa pagina viene inclusa da altri script

if (!isset($_SESSION)) { session_start(); }
if ($_SESSION['login'] != "ok") { //controlliamo che sia avviata una sessione, se non c'è, si viene rimandati in homepage
	header("Location: ../index.php");
}

 if (!$permessi['pubblicazione']) header("Location: ../admin.php"); //controlliamo che la pagina venga richiesta solo da utenti autorizzati.

if (isset($_GET['delete'])) { //se è stata richesta la cancellazione di un articolo:
$id_del = mysql_escape_string($_GET['delete']);
mysql_query("DELETE FROM articoli WHERE `id_articolo` = $id_del") or die("Errore nell'esecuzione della query di cancellazione!".mysql_error());
echo "<script>alert('Articolo $id_del cancellato!');</script>";
header("Location: admin.php?pag=gestisci-articoli");
}

if (isset($_GET['edit_art'])){ //edita un singolo articolo
$id_art = mysql_escape_string($_GET['edit_art']);
$article = mysql_fetch_array(mysql_query("SELECT * FROM articoli WHERE `id_articolo` = $id_art"));

  if (@$_POST['form_inviato']){ //articolo inviato, lo aggiorniamo nel DB.
	$titolo = mysql_escape_string($_POST['titolo']);
	$testo = mysql_escape_string($_POST['testo']);
	$meta_desc = mysql_escape_string($_POST['meta_description']);
	$categoria = mysql_escape_string($_POST['categoria']);
	$tags = mysql_escape_string($_POST['tags']);
	$evid = mysql_escape_string($_POST['evidenza']);
	$azione = mysql_escape_string($_POST['azione']);
	mysql_query("UPDATE  `articoli` SET  `titolo` =  '$titolo',
`testo` =  '$testo',
`meta_description` =  '$meta_desc',
`id_categoria` =  '$categoria',
`tags` =  '$tags',
`id_autore` =  '1',
`in_evidenza` =  '$evid',
`pubblicato` =  '$azione' WHERE `id_articolo` = $id_art;") or die("Errore nella modifica dell'articolo.".mysql_error());

	$ok = "<font color='green' size='5'>Aggiornamento articolo in corso...</font><br/><img src='images/loading.gif' /><br/><br/><META HTTP-EQUIV='REFRESH' CONTENT='3; URL=$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]'>";
    }

?>

<center><h2>MODIFICA ARTICOLO [id: <?php echo $id_art; ?>]</h2></center><br/><p>
<center> <?php echo @$ok; ?>
<form action='' method='POST'>
<input type='hidden' value='1' name='form_inviato'>
Titolo: <input type='text' name='titolo' value='<?php echo $article['titolo']; ?>' size='35'><br/><br/>
<textarea rows='10' cols='50' name='testo'><?php echo $article['testo']; ?></textarea><br/><br/>
Descr. breve:<input type='text' name='meta_description' value='<?php echo $article['meta_description']; ?>' size='50'><br/><br/>
Tags: <input type='text' name='tags' value='<?php echo $article['tags']; ?>' size='50'><br/><br/>
Categoria:
<select name='categoria'>
<?php
$qry_categ = mysql_query("SELECT id_categoria, nome_categoria FROM categorie");
while($categoria = mysql_fetch_array($qry_categ)){
$selected = ($article['id_categoria'] == $categoria['id_categoria']) ? "selected": "";
echo "<option value='$categoria[id_categoria]' ".$selected.">$categoria[nome_categoria]</option>";
}
?>
</select>
<br/><br/>
Metti in Evidenza:
<select name='evidenza'>
<?php 
if ($article['in_evidenza']) 
echo "<option value='0'>No</option>
<option value='1' selected>Si</option>";
else 
echo "<option value='0' selected>No</option>
<option value='1'>Si</option>";
?>
</select>
<br/><br/>
Azione:
<select name='azione'>
<?php
if ($article['pubblicato'])
echo "<option value='1' selected>Pubblica</option>
<option value='0'>Salva in bozze</option>";
else
echo "<option value='1'>Pubblica</option>
<option value='0' selected>Salva in bozze</option>"; 
?>
</select>
<br/><br/>
<input type='submit' value='Aggiorna Articolo'>
<br/>
</form>
</center>
</p>

<?php

}else{ //stampa la lista degli articoli

echo "<center><h2>GESTISCI ARTICOLI</h2></center><br/><p><table border='1' style='font-size: 12px'>";
echo "<tr><td>ID Articolo</td><td>Titolo</td><td>Categoria</td><td>Autore</td><td>Data</td><td>In evidenza</td><td>Pubblicato</td><td>Modifica</td><td>Elimina</td></tr>";
$qry_lart = mysql_query("SELECT id_utente, username, id_articolo, titolo, articoli.id_categoria, categorie.id_categoria, id_autore, data, in_evidenza, pubblicato, nome_categoria FROM articoli JOIN categorie ON (articoli.id_categoria = categorie.id_categoria) JOIN utenti ON (id_utente = id_autore) ORDER BY data DESC");
while($art = mysql_fetch_array($qry_lart)){
echo "<tr><td>$art[id_articolo]</td><td><a href='index.php?id_articolo=$art[id_articolo]' target='_new'>$art[titolo]</a></td><td>$art[nome_categoria]</td><td>$art[username]</td><td>$art[data]</td><td>$art[in_evidenza]</td><td>$art[pubblicato]</td><td><a href='$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]&edit_art=$art[id_articolo]'>Modifica</a></td><td><a href='$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]&delete=$art[id_articolo]' onClick=\"return confirm('Sei sicuro di voler cancellare questo articolo?');\">Elimina</a></td></tr>";
}
echo "</table></p>";

} ?>