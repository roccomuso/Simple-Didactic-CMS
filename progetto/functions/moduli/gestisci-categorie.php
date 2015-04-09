<?php //Questa pagina viene inclusa da altri script

if (!isset($_SESSION)) { session_start(); }
if ($_SESSION['login'] != "ok") {
	header("Location: ../index.php");
}

 if (!$permessi['pubblicazione']) header("Location: ../admin.php");
 
 if (isset($_GET['delete'])) { //se è stata richesta la cancellazione della categoria
$id_del = mysql_escape_string($_GET['delete']);
mysql_query("DELETE FROM categorie WHERE `id_categoria` = $id_del") or die("Errore nell'esecuzione della query di cancellazione!".mysql_error());
echo "<script>alert('Categoria $id_del cancellata!');</script>";
header("Location: admin.php?pag=gestisci-categorie");
}


?>
<center><h2>GESTIONE CATEGORIE</h2></center><br/>
<p><center>

<?php 
if (isset($_GET['edit_cat'])){ //mostriamo il form per la modifica della categoria
$id_cat = mysql_escape_string($_GET['edit_cat']); 
 if (isset($_POST['aggiorna'])){
     $nome_cat = mysql_escape_string($_POST['nome_categoria']);
	 $descr_breve = mysql_escape_string($_POST['descr_breve']);
	 $visibile = mysql_escape_string($_POST['visibile']);
	 mysql_query("UPDATE `categorie` SET  `nome_categoria` =  '$nome_cat',
`descr_breve` =  '$descr_breve',
`visibile` =  '$visibile' WHERE `id_categoria` = $id_cat;") or die("Errore nell'aggiornamento della categoria.".mysql_error());
	 echo "<font color='green' size='5'>Categoria aggiornata!</font><br/>";
	 }
 
$categoria = mysql_fetch_array(mysql_query("SELECT * FROM categorie WHERE `id_categoria` = $id_cat"));
 
 ?>
 <h3>Modifica Categoria:</h3>
 <form action='' method='POST'>
<input type='hidden' value='1' name='aggiorna'>
ID Categoria: <input type='text' name='id_categoria' value='<?php echo $categoria['id_categoria']; ?>' disabled='disabled'><br/>
Nome Categoria: <input type='text' name='nome_categoria' value='<?php echo $categoria['nome_categoria']; ?>'><br/>
Descrizione breve: <input type='text' name='descr_breve' value='<?php echo $categoria['descr_breve']; ?>' size='45'><br/>
Visibile:
<select name='visibile'>
<?php 
if ($categoria['visibile'])
echo "<option value='1' selected>Si</option>
<option value='0'>No</option>";
else
echo "<option value='1'>Si</option>
<option value='0' selected>No</option>";
?>
</select>
<br/>
<input type='submit' value='Aggiorna Categoria'>
</form>

 <?php

}else{ //mostriamo il form per l'inserimento di una nuova categoria

if (@$_POST['form_inviato']){ //salviamo nel DB la categoria e mostriamo il mex di conferma
$nome_cat = mysql_escape_string($_POST['nome_categoria']);
$descrizione_breve  = mysql_escape_string($_POST['descr_breve']);
$visibile  = mysql_escape_string($_POST['visibile']);
mysql_query("INSERT INTO `categorie` (
`id_categoria` ,
`nome_categoria` ,
`descr_breve` ,
`visibile`
)
VALUES (
NULL ,  '$nome_cat',  '$descrizione_breve',  '$visibile'
);
") OR die("Errore nell'inserimento di una nuova categoria!".mysql_error());
echo "<font color='green' size='5'>Categoria inserita!</font><br/>";
}else{ //mostriamo il form per l'inserimento di una nuova categoria
 ?>
<h3>INSERISCI CATEGORIA</h3>
<form action='' method='POST'>
<input type='hidden' value='1' name='form_inviato'>
<input type='text' name='nome_categoria' value='Nome Categoria'><br/>
<input type='text' name='descr_breve' value='Breve descrizione' size='45'><br/>
Visibile:
<select name='visibile'>
<option value='1'>Si</option>
<option value='0'>No</option>
</select>
<br/>
<input type='submit' value='Inserisci'>
</form><br/>
<?php } } ?>

<hr/>
<br/>
<h3>Categorie presenti:</h3>
<table border='1'>
<tr><td>ID Categoria</td><td>Nome categoria</td><td>Descrizione breve</td><td>Visibile</td><td>Modifica</td><td>Elimina</td></tr>
<?php
$qry_cat = mysql_query("SELECT * FROM categorie");
while($cat = mysql_fetch_array($qry_cat)){
echo "<tr><td>$cat[id_categoria]</td><td>$cat[nome_categoria]</td><td>$cat[descr_breve]</td><td>$cat[visibile]</td><td><a href='$_SERVER[PHP_SELF]?pag=gestisci-categorie&edit_cat=$cat[id_categoria]'>Modifica</a></td><td><a href='$_SERVER[PHP_SELF]?pag=gestisci-categorie&delete=$cat[id_categoria]' onClick=\"return confirm('Sei sicuro di voler cancellare questa categoria?');\">Elimina</a></td></tr>";
}
?>
</table>
</center>
</p>