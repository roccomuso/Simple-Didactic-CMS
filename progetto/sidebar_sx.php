<?php  //questo file viene incluso da altri script
	 
	 
	 //WIDGET CATEGORIE:
	 
	 $qry_categorie = mysql_query("SELECT categorie.id_categoria, nome_categoria, COUNT(*) as n_articoli FROM articoli JOIN categorie on (categorie.id_categoria = articoli.id_categoria) WHERE visibile = 1 AND pubblicato = 1 GROUP BY categorie.id_categoria ORDER BY n_articoli DESC");
	 
	 	echo "<h3>Categorie:</h3>";
		while($cat_art = mysql_fetch_array($qry_categorie)){
		echo "<li><a href='categorie.php?id_cat=$cat_art[id_categoria]'>$cat_art[nome_categoria]</a> ($cat_art[n_articoli])</li>";
		}

	
	//WIDGET TOP ARTICOLISTI:
		$nmax_articolisti = 5; //numero massimo di utenti da visualizzare
		$qry_articolisti = mysql_query("SELECT id_autore, username, COUNT(*) as n_articoli FROM articoli JOIN utenti ON (id_utente = id_autore) GROUP BY id_autore ORDER BY n_articoli DESC LIMIT 0, $nmax_articolisti");  //più essenziale: SELECT id_autore, COUNT(*) FROM articoli GROUP BY id_autore [questa query restituisce il numero di articoli associati ad ogni utente]
		
		echo "<h3>Top Articolisti:</h3>";
		while($articolisti = mysql_fetch_array($qry_articolisti)){
		echo "<li>$articolisti[username] ($articolisti[n_articoli])</li>";
		}
	
	//WIDGET TOP CONTRIBUTORI (chi commenta di più):
	
		$nmax_contributori = 5; //numero massimo di utenti da visualizzare
		$qry_contributori = mysql_query("SELECT utente, COUNT(*) as n_commenti FROM commenti GROUP BY utente ORDER BY n_commenti DESC LIMIT 0, $nmax_contributori");
		
		echo "<h3>Top contributori:</h3>";
		while($contributori = mysql_fetch_array($qry_contributori)){
		echo "<li>$contributori[utente] ($contributori[n_commenti])</li>";
		}
	
?>
