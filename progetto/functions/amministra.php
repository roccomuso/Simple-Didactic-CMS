<?php //questa pagina viene inclusa da admin.php

if (!isset($_SESSION)) { session_start(); }
if (@$_SESSION['login'] != "ok") { //se non è stato effettuato il login
header("Location: index.php");
}


//logout
if (isset($_GET['logout'])) {   
  $_SESSION=array(); // Desetta tutte le variabili di sessione. 
  session_destroy(); //DISTRUGGE la sessione. 
  }


$nome_sito = mysql_fetch_array(mysql_query("SELECT nome_sito FROM `info_sito`")); //QUERY per prelevare il nome del sito dal db.
$nome_sito = $nome_sito['nome_sito'];
$footer = mysql_fetch_array(mysql_query("SELECT footer FROM `info_sito`")); //QUERY per prelevare il testo del footer.
$footer = $footer['footer'];
//preleviamo i permessi associati all'utente, in base al suo ruolo:
$permessi = mysql_fetch_array(mysql_query("SELECT * FROM `permessi` WHERE `ruolo` = '$_SESSION[ruolo]'"));

//Associamo alcuni valori META di default alla pagina. Per correttezza nei confronti del W3C :P
$descrizione = mysql_fetch_array(mysql_query("SELECT descrizione_sito FROM `info_sito`")); //QUERY per prelevare la meta_description del sito (questa quando si apre un articolo, viene sostituita dalla meta_description dell'articolo)
$keywords = mysql_fetch_array(mysql_query("SELECT keywords_sito FROM `info_sito`")); // QUERY per prelevare le meta_keywords del sito (vale lo stesso discorso fatto sopra per la meta_description)
$desc = $descrizione['descrizione_sito'];
$keys = $keywords['keywords_sito']; 


//funzione per prelevare i primi $mac_char da un testo.
function TagliaStringa($stringa, $max_char){
		if(strlen($stringa)>$max_char){
			$stringa_tagliata=substr($stringa, 0,$max_char);
			$last_space=strrpos($stringa_tagliata," ");
			$stringa_ok=substr($stringa_tagliata, 0,$last_space);
			return $stringa_ok."..."; //aggiunge 3 puntini di sospensione alla fine della stringa tagliata
		}else{
			return $stringa;
		}
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head> <!-- HEADER E SCRIPT JS -->
<title><?php echo "$nome_sito"; ?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<META name="author" content="Rocco Musolino">
<META name="description" content="<?php echo "$desc"; ?>">
<META name="keywords" content="<?php echo "$keys"; ?>">

<link rel="shortcut icon" href="favicon.ico">
<link href="style.css" rel="stylesheet" type="text/css">
    <!-- inizio script e stile per login -->
    <link rel="stylesheet" href="style-login.css" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
	<!-- end script per login -->
	<!-- inizio script e stile per ordine pagine -->
	<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
	<style>
	ul {
	margin: 0;
	}
	
	#contentLeft {
	/*float: left;*/
	width: 400px;
	}
	
	#contentLeft li {
	list-style: none;
	margin: 0 0 4px 0;
	padding: 10px;
	background-color:#00CCCC;
	border: #CCCCCC solid 1px;
	color:#fff;
			}
	</style>
	<script type="text/javascript">
$(document).ready(function(){ 
						   
	$(function() {
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			$.post("./functions/updateDB.php", order, function(theResponse){
				$("#contentRight").html(theResponse); //al momento non viene visualizzata la risposta.
			}); 															 
		}								  
		});
	});

});	
	</script>
	<!-- end script per ordine pagine -->
	
	<!-- inizio script per Pie Chart -->
	
	<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

	  //GRAFICO NUMERO DI ARTICOLI PER UTENTE
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
		<?php 	
		$qry_articolisti = mysql_query("SELECT id_autore, username, COUNT(*) as n_articoli FROM articoli JOIN utenti ON (id_utente = id_autore) GROUP BY id_autore ORDER BY n_articoli DESC");  //più essenziale: SELECT id_autore, COUNT(*) FROM articoli GROUP BY id_autore [questa query restituisce il numero di articoli associati ad ogni utente]
		?>
        data.addRows([
		<?php 
		while($articolisti = mysql_fetch_array($qry_articolisti)){
		echo "['$articolisti[username]', $articolisti[n_articoli]],";
		}
		?>
        ]);

        // Set chart options
        var options = {'title':'Numero di articoli per utente:',
                       'width':430,
                       'height':250};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('art_users_div'));
        chart.draw(data, options);
		
		//GRAFICO NUMERO DI ARTICOLI IN OGNI CATEGORIA
		        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
		<?php 	
	 $qry_categorie = mysql_query("SELECT categorie.id_categoria, nome_categoria, COUNT(*) as n_articoli FROM articoli JOIN categorie on (categorie.id_categoria = articoli.id_categoria) WHERE visibile = 1 AND pubblicato = 1 GROUP BY categorie.id_categoria ORDER BY n_articoli DESC");
		?>
        data.addRows([
		<?php 
		while($cat_art = mysql_fetch_array($qry_categorie)){
		echo "['$cat_art[nome_categoria]', $cat_art[n_articoli]],";
		}
		?>
        ]);

        // Set chart options
        var options = {'title':'Numero di articoli per categoria:',
                       'width':450,
                       'height':250};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('art_cat_div'));
        chart.draw(data, options);
      
	  }
    </script>
	<!-- end script per Pie Chart -->

</head>

<body>
   <!-- Login Starts Here -->
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/it_IT/all.js#xfbml=1&appId=202296479810763";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

   <div id="bar">
     <div style="width: 1000px; margin: 0 auto">
	<span style="float: left">
	<fb:like send="false" width="450" show_faces="true"></fb:like>
	</span>
            <div id="loginContainer">
			
			<?php
			if (@$_SESSION['login'] == "ok"){
			 echo "<span style='font-size:23px'>Benvenuto <b>$_SESSION[nome]</b> [<a href='index.php'>Visualizza Sito</a>] - [<a href='index.php?logout=1'>Logout</a>]</span>";
			  }
			  ?>
			  

            </div>


	  </div>
	</div>
   <!-- Login Ends Here -->
<div id="container">

<div id="header"><center><img src="images/Logo.png" border="0" /></center></div>
<div id="menu"><center><?php include("moduli/pca_menu.php"); ?></center></div>
<div id="main">

<div id="content">
<?php

switch(@$_GET['pag']){

case "scrivi-articolo": //PAGINA SCRIVI ARTICOLO
include("moduli/scrivi-articolo.php");
break;

case "gestisci-articoli": //PAGINA GESTISCI ARTICOLI
include("moduli/gestisci-articoli.php");
break;

case "gestisci-categorie": //PAGINA GESTISCI CATEGORIE
include("moduli/gestisci-categorie.php");
break;

case "modifica-utenti": //PAGINA MODIFICA UTENTI
include("moduli/modifica-utenti.php");
break;

case "opzioni-sito": //PAGINA OPZIONI SITO
include("moduli/opzioni-sito.php");
break;

default: //PAGINA HOME DI DEFAULT (Visualizzata non appena si accede al Pannello di controllo)

if ($permessi['mod_sito']){
?>
	<p>
	<center><h3>Modifica ordine pagine:</h3>
		<div id="contentLeft">
			<ul>
				<?php
				$query  = "SELECT * FROM pagine ORDER BY ordine ASC";
				$result = mysql_query($query);
				
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				?>
					<li id="recordsArray_<?php echo $row['id_pagina']; ?>"><?php echo $row['id_pagina'] . ". " . $row['titolo']; ?></li>
				<?php } ?>
			</ul>
		</div>
		<!-- Decommentare riga sotto per visualizzare risposta dello script updateDB.php a cui si inoltra la richiesta per la modifica dell'ordine delle pagine nel menu-->
		<!-- <div id="contentRight"></div>-->
	</center>
	</p><hr/>
<?php
}

if ($permessi['mod_utenti']) {
  //Mostra grafico torta (chart) numero di articoli associati ad ogni utente). charts by: https://google-developers.appspot.com/chart/interactive/docs/quick_start

echo '<p><center>
<!--Div that will hold the pie chart-->
    <div id="art_users_div"></div></center></p>';
}

if ($permessi['pubblicazione']){
   //Mostra grafico torta (chart) numero di articoli associati ad ogni categoria
echo '<p><center>
<!--Div that will hold the pie chart-->
    <div id="art_cat_div"></div></center></p>';

}


if ($permessi['scrittura']){
echo "<center><h3>Articoli scritti da te:</h3><p>";
 $qry_yposts = mysql_query("SELECT id_articolo, titolo, data, pubblicato FROM articoli WHERE id_autore = $_SESSION[id_utente]");
 echo "<table border='1'>
 <tr><td>Titolo</td> <td>Data</td> <td>Pubblicato</td></tr>";
 while($y_art = mysql_fetch_array($qry_yposts)){
 echo "<tr><td><a href='admin.php?pag=gestisci-articoli&edit_art=$y_art[id_articolo]'>$y_art[titolo]</a></td> <td>$y_art[data]</td> <td>$y_art[pubblicato]</td></tr>";
 }
 echo "</table> </p> </center>";


 }

if ($permessi['lettura']) echo "<p>Qui di seguito puoi modificare i tuoi dati personali: </p>";
break;
}


?>

</div>
	

    <div id="nav"> <!-- SIDEBAR Sinistra -->
 <?php include("moduli/sidebar_sx.php"); ?>
    </div>
</div>
   <div id="extra"> <!-- SIDEBAR Destra -->
 <?php include("moduli/sidebar_dx.php"); ?>
   </div>
  <div id="footer"> <!-- FOOTER -->
   <center><p><?php echo "$footer"; ?></p></center>
  </div>
  
</div>
<br/><br/>
</body>
</html>