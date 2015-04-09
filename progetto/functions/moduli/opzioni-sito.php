<?php //Questa pagina viene inclusa da altri script

if (!isset($_SESSION)) { session_start(); }
if ($_SESSION['login'] != "ok") {
	header("Location: ../index.php");
}

 if (!$permessi['mod_sito']) header("Location: ../admin.php");
 

	if (@$_GET['mod_pag']){ //MODIFICHIAMO LA PAGINA ESISTENTE
	
	$id_pagina = mysql_escape_string($_GET['mod_pag']);
	
	if (@$_POST['form_inviato']){ //lo aggiorniamo nel DB
   $titolo = mysql_escape_string($_POST['titolo']);
   $testo = mysql_escape_string($_POST['testo']);
   
   if(mysql_query("UPDATE pagine SET 'testo' = '$testo', 'titolo' = '$titolo' WHERE id_pagina = $id_pagina")){
   echo "<center><font color='green'>Pagina modificata con successo!</font></center>";
   }
   
   }else{ //stampiamo il form per modificare la pagina
	
	 $article = mysql_query("SELECT * FROM pagine WHERE id_pagina = $id_pagina");
     $art = mysql_fetch_array($article);
 echo "<p><center><h2>Modifica pagina: $id_pagina</h2><br/><form action='' method='POST'>
 <input type='hidden' value='1' name='form_inviato'>
 ID Pagina: <input type='text' name='id_pagina' value='$id_pagina' disabled='disabled'>
 <br/>Titolo: <input type='text' name='titolo' value='$art[titolo]' >
 <br/>Testo: <textarea name='testo' cols='35' rows='15'>$art[testo]</textarea>
 <br/>Ordine: <input type='text' name='ordine' value='$art[ordine]' disabled='disabled'> 
 <br/><input type='submit' value='Invia' >
 
 ";
 
 echo "</form>";
 echo "<br/></center></p>";
	  }
	}elseif(@$_GET['ins_pag']){ //INSERIMENTO DI UNA NUOVA PAGINA
	
	
	   	  $ord_max = mysql_fetch_array(mysql_query("SELECT MAX(ordine) as max FROM pagine"));
      $ord_max = $ord_max['max'] + 1; //incrementa l'ordine massimo.
	  
	  
	}
 

 
 //prelevo e stampo le pagine
 $qry_pagin = mysql_query("SELECT * FROM pagine");
 echo "<center><p><h2>OPZIONI SITO</h2><br/>
 <table border='1'><tr>
<td><b>ID Pagina</b></td> <td><b>Titolo</b></td> <td><b>Testo</b></td>
</tr>";
 while($pagin = mysql_fetch_array($qry_pagin)){
 
 $testo = TagliaStringa(strip_tags($pagin['testo']), 60);
echo "<tr>
<td><a href='$_SERVER[PHP_SELF]?pag=opzioni-sito&mod_pag=$pagin[id_pagina]'>$pagin[id_pagina]</a></td> <td><a href='$_SERVER[PHP_SELF]?pag=opzioni-sito&mod_pag=$pagin[id_pagina]'>$pagin[titolo]</a></td> <td>".$testo."</td>
</tr>";

} ?>

</table>
<br/><a href="admin.php">Modifica ordine pagine</a> | <a href='<?php echo "$_SERVER[PHP_SELF]?pag=opzioni-sito&ins_pag=1";?>'>Inserisci nuova pagina</a>
</p>

</center>