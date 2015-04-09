<?php  //questo file viene incluso da altri script
	 
	 //WIDGET ULTIMI COMMENTI:
	 
	 $num_commenti = 4; //quanti commenti vogliamo visualizzare.
	 $lung_commento = 70; //quanti caratteri verranno stampati prima di tagliare la stringa.
	 
	 $qry_lcomment = mysql_query("SELECT * FROM `commenti` ORDER BY data DESC LIMIT 0, $num_commenti");
	 
	 echo "<h3>Ultimi Commenti:</h3><center><img src='images/pencil.png' /></center>";
	 while($last_comment = mysql_fetch_array($qry_lcomment)){
?>
	<p>
	
	<span style="font-size: 12px;">[<?php echo $last_comment['data']; ?>] <span style="color: green"><?php echo $last_comment['utente']; ?></span>:</span><br/>
	<span style="font-size: 10px; font-weight: bold"><?php echo TagliaStringa($last_comment['testo_commento'], $lung_commento); ?></span><br/>
	 	
	</p>
	 
	 
	 <?php
	 }
	 
	//WIDGET ARTICOLI PIù COMMENTATI:
    $n_articoli_comm = 5;
	
	echo "<h3>I $n_articoli_comm più commentati:</h3>";
	$qry_commentati = mysql_query("SELECT id_articolo, titolo, art_commentato, COUNT(*) as n_commenti FROM commenti JOIN articoli ON (id_articolo = art_commentato) GROUP BY art_commentato ORDER BY n_commenti DESC LIMIT 0, $n_articoli_comm");
	echo "<span style='font-size: 10px'>";
	while($commentati = mysql_fetch_array($qry_commentati)){
	echo "<a href='index.php?id_articolo=$commentati[id_articolo]'>".$commentati['titolo']."</a> (".$commentati['n_commenti'].")<br/>";
	}
	echo "</span>";
	 	 
	 // WIDGET LINK:
	 $qry_link = mysql_query("SELECT * FROM link WHERE visibile = 1");
	 
	 echo "<h3>Link</h3>";
	 while($link = mysql_fetch_array($qry_link))
	 {
	 ?>
        <p> <a href="<?php echo $link['url']; ?>" <?php if ($link['new_page']) echo 'target="_new"'; if($link['nofollow']) echo 'rel="no_follow"'; ?>><?php echo $link['nome_sito_amico']; ?> </a></p>
	<?php
		}
		echo "<br/>";
		
     ?>