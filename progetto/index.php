<?php // ATTENZIONE, IL CODICE QUA SOTTO POTREBBE URTARE LA VOSTRA SENSIBILITA'

############################################################################
###
### CMS DATABASE - ROCCO MUSOLINO - http://www.hackerstribe.com
###
############################################################################

//avviamo una sessione
if (!isset($_SESSION)) { session_start(); }
if (@$_SESSION['login'] != "ok") { // se non è stato effettuato il login.
   //viene mostrato il pulsante di login
  //alert in caso di errore nel login
  if (isset($_GET['errore-login'])) {echo "<script>alert('Errore, inserire email e password corretta.');</script><META HTTP-EQUIV='REFRESH' CONTENT='0; URL=index.php'>"; }
}

//logout
if (isset($_GET['logout'])) {
  $_SESSION=array(); // Desetta tutte le variabili di sessione. 
  session_destroy(); //DISTRUGGE la sessione.
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0; URL=index.php'>";  
  }
//ci connettiamo al database
require_once("config.php");		# Dati connessione database Mysql
//pedisponiamo la pagina alla stampa a schermo degli articoli
$art_x_pagina = mysql_fetch_array(mysql_query("SELECT articoli_per_pagina FROM `info_sito`"));  // QUERY per prelevare il numero di articoli per pagina da visualizzare
$art_x_pagina = $art_x_pagina['articoli_per_pagina']; //gli articoli in evidenza non sono inclusi, vengono stampati a parte.
$nome_sito = mysql_fetch_array(mysql_query("SELECT nome_sito FROM `info_sito`")); //QUERY per prelevare il nome del sito dal db.
$nome_sito = $nome_sito['nome_sito'];
$footer = mysql_fetch_array(mysql_query("SELECT footer FROM `info_sito`")); //QUERY per prelevare il testo del footer.
$footer = $footer['footer'];

if (@$_GET['id_articolo']){ //preleva l'articolo e i suoi vari attributi (titolo, testo, id_autore etc.)
$id_articolo = mysql_escape_string($_GET['id_articolo']);
$art = mysql_fetch_array(mysql_query("SELECT * FROM `articoli` WHERE `id_articolo` = '$id_articolo' AND `pubblicato` = 1")); //non c'è bisogno di ciclare con un while, poichè siamo sicuri che verrà prelevato una sola istanza dal database (id_articolo è chiave primaria)
//$art è un array che conterrà l'articolo da stampare a schermo.
if ($art){ //controlliamo se è stato trovato l'articolo nel DB
$nome_sito = $nome_sito." - ".$art['titolo'];
$desc = $art['meta_description'];
$keys = $art['tags'];
} else header("Location: index.php");
}else{
//Altrimenti visualizziamo gli ultimi $art_x_pagina articoli.
//Associamo alcuni valori META di default alla pagina. Per correttezza nei confronti del W3C :P
$descrizione = mysql_fetch_array(mysql_query("SELECT descrizione_sito FROM `info_sito`")); //QUERY per prelevare la meta_description del sito (questa quando si apre un articolo, viene sostituita dalla meta_description dell'articolo)
$keywords = mysql_fetch_array(mysql_query("SELECT keywords_sito FROM `info_sito`")); // QUERY per prelevare le meta_keywords del sito (vale lo stesso discorso fatto sopra per la meta_description)
$desc = $descrizione['descrizione_sito'];
$keys = $keywords['keywords_sito']; 
}

//funzione per prelevare i primi $max_char da un testo.
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
	<!-- inizio script per validazione form registrazione -->
	
	<script type="text/javascript">
	
	function check_form(){
	var nome = document.registrazione.nome.value;
	var cognome = document.registrazione.cognome.value;
	var email = document.registrazione.email.value;
	var username = document.registrazione.username.value;
	var password = document.registrazione.password.value;
	var password2 = document.registrazione.password2.value;
	
	if ((nome == "") || (nome == "undefined")){
	alert("Il campo nome è obbligatorio!");
	document.registrazione.nome.focus();
	return false;
	}

	if ((cognome == "") || (cognome == "undefined")){
	alert("Il campo cognome è obbligatorio!");
	document.registrazione.cognome.focus();
	return false;
	}

    var email_reg_exp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;
	if (!email_reg_exp.test(email) || (email == "") || (email == "undefined") ){
	alert("Inserire un indirizzo email corretto!");
	document.registrazione.email.select();
	return false;
	}
	
	if ((username == "") || (username == "undefined")){
	alert("Il campo username è obbligatorio!");
	document.registrazione.username.focus();
	return false;
	}
	
    if ((password != password2) || (password == "") || (password == "undefined")){
	alert("La password confermata è diversa da quella scelta, controllare.");
	document.registrazione.password2.value = "";
	document.registrazione.password2.focus();
	return false;
		}
	
//controlliamo che l'username non sia già presente nel DB.
   /*
   $.post("./functions/updateDB.php", function(data){
   document.write("data: " + data);
   alert("Username già presente nel database!"); 
   document.registrazione.username.focus();
   
   });
   */

	}
	</script>
	<!-- fine script validazione form registrazione -->
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
			 echo "<span style='font-size:23px'>Benvenuto <b>$_SESSION[nome]</b> [<a href='admin.php'>Pannello di controllo</a>] - [<a href='index.php?logout=1'>Logout</a>]</span>";
			  }else{
			  ?>
			  

                <a href="#" id="loginButton"><span>Login</span><em></em></a>
                <div style="clear:both"></div>
                <div id="loginBox">                
                    <form id="loginForm" action="controlla.php" method="POST">
                        <fieldset id="body">
                            <fieldset>
                                <label for="email">Indirizzo Email</label>
                                <input type="text" name="email" id="email" />
                            </fieldset>
                            <fieldset>
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" />
                            </fieldset>
                            <input type="submit" id="login" value="Accedi" />
                            <label for="checkbox"><input type="checkbox" id="checkbox" />Ricordamela</label>
                        </fieldset>
                        <span><a href="index.php?id_pagina=4">Password dimenticata?</a></span>
                    </form>
                </div>
				
				<?php } ?>
            </div>

				<?php if (@$_SESSION['login'] != "ok"){ ?>
				
			<div id="loginContainer">
			  <a href="#" id="regButton"><span>Registrati</span><em></em></a>
                <div style="clear:both"></div>
			</div>
				<?php } ?>

	  </div>
	</div>
   <!-- Login Ends Here -->
<div id="container">

<div id="header"><center><img src="images/Logo.png" border="0" /></center></div>
<div id="menu"><center><?php include("menu.php"); ?></center></div>
<div id="main">

	<?php // STAMPIAMO LA PAGINA CHE VIENE RICHIESTA
	if(@$_GET['id_pagina']){ $page = mysql_escape_string($_GET['id_pagina']);
	
	  $pagina =mysql_fetch_array(mysql_query("SELECT * FROM pagine WHERE id_pagina = $page")); //siam sicuri verrà prelevata una sola istanza
                                           //titolo - testo
    if (!$pagina) header("Location: index.php"); //se non esiste la pagina rimanda alla home
	?>
	 <div id="content">
	<center><h2><?php echo $pagina['titolo']; ?></h2></center> <span style="float:right; margin-right:20px"><fb:send font="lucida grande"></fb:send></span>
	<br/><br/><p><?php echo $pagina['testo']; ?></p>
	</div>
	<?php
	}elseif (@$_GET['id_articolo']){ // STAMPIAMO IL SINGOLO ARTICOLO (già prelevato dal DB precedentemente)
	$categoria = mysql_fetch_array(mysql_query("SELECT nome_categoria FROM `categorie` WHERE id_categoria = $art[id_categoria]"));
	$categoria = $categoria['nome_categoria'];
	$autore = mysql_fetch_array(mysql_query("SELECT username FROM `utenti` WHERE id_utente = $art[id_autore]"));
	$autore = $autore['username'];
	?>
	<div id="content">
	<center><h2><?php echo $art['titolo']; ?></h2></center> <span><span style="float:left; margin-left:5px; color: grey">Scritto in: <font color="red"><?php echo $categoria; ?></font> il <?php echo $art['data']; ?></span><span style="float:right; margin-right:20px"><fb:send font="lucida grande"></fb:send></span></span>
	<br/><br/><p><?php echo $art['testo']; ?></p>
	<span style="float:right; margin-right: 20px; color: grey"><em><?php echo $autore; ?></em></span><br/>
	<hr size="1" color="#eeeeee">
	<p><b>Tags</b>: <?php echo $art['tags']; ?></p>
	<hr size="1" color="#eeeeee">
	<h3>- Commenti:</h3><br/>
	<?php require_once("commenti.php"); ?>
	<br/><br/>
	</div>
	<?php
	}elseif (@$_GET['registrazione'] AND !(@$_SESSION['login'])){ // STAMPIAMO LA PAGINA DI REGISTRAZIONE
	
	  if (@$_POST['submitted']){
	    $username = mysql_escape_string($_POST['username']);
        $email = mysql_escape_string($_POST['email']);
		
$var = mysql_num_rows(mysql_query("SELECT id_utente FROM utenti WHERE username = '$username' OR email = '$email'"));
if ($var ) { //l'username già esiste nel database.
echo "<script>alert(\"L'username scelto non è disponibile. E' necessario cambiarlo. Oppure Mail già presente nel DB.\");</script>
<META HTTP-EQUIV='REFRESH' CONTENT='3; URL=index.php?registrazione=1'>";
}
		
		$nome = mysql_escape_string($_POST['nome']);
		$cognome = mysql_escape_string($_POST['cognome']);
		$password = md5(mysql_escape_string($_POST['password']));
		
	  if (!$var){ 
	  mysql_query("INSERT INTO `utenti` (`id_utente`, `username`, `nome`, `cognome`, `email`, `password`, `ruolo`) VALUES (NULL, '$username', '$nome', '$cognome', '$email', '$password', 'lettore');") or die("Errore nell'esecuzione della query di registrazione. ".mysql_error());
	   
	  echo '<div id="content">
	  <h2>Registrazione avvenuta con successo!</h2>
	  <p>E\' ora possibile effettuare il login in alto.</p>
	  </div>'; }
	    else echo '<div id="content">
	  <h2>Errore nella registrazione, redirect...</h2>
	  <p>Inserire mail nuova o username diverso.</p>
	  </div>';
	  }else{
	?>
	<div id="content">
	<center><h2>Registrazione</h2>
	<br/>
	<form action='' method='POST' name='registrazione' onsubmit="return check_form()" >
	<input type='hidden' name='submitted' value='1'>
	Nome: <input type='text' name='nome'>*<br/>
	Cognome: <input type='text' name='cognome'>*<br/>
	Email: <input type='text' name='email'>*<br/>
	Username: <input type='text' name='username'>*<br/>
	Password: <input type='password' name='password'>*<br/>
	Ripeti password: <input type='password' name='password2'>*<br/>
		
	<br/>
	<input type='submit' value='Invia'><br/>
	</form>
	
	</center>
	</div>
	<?php
		}
	}else{ // STAMPIAMO LA LISTA DEGLI ARTICOLI (tenendo conto degli ultimi articoli, degli articoli delle pagine precedenti, e degli articoli in evidenza)
	echo '<div id="content">';
	if (@(!$_GET['pag'])){
	//stampiamo semplicemente gli ultimi articoli (con in cima quelli in evidenza)
	
	//prendiamo gli articoli in evidenza.
	$qry_evidenza = mysql_query("SELECT id_articolo, titolo, testo, data, nome_categoria, username FROM articoli, categorie, utenti WHERE `pubblicato` = 1 AND `in_evidenza` = 1 AND articoli.id_categoria = categorie.id_categoria AND articoli.id_autore = utenti.id_utente ORDER BY `data` DESC");
	//li stampiamo
	while ($evidenza = mysql_fetch_array($qry_evidenza)){ //cicliamo per stampare SOLO gli articoli in evidenza cui seguiranno i normali ultimi articoli
	?>
	     <!-- stampiamo i vari articoli in evidenza [hanno la cornice arancione] -->
        <div style="border: 3px coral solid">
		<h3><?php echo $evidenza['titolo'];?></h3> <span style="margin-left:5px; font-size:10px"><?php echo "Scritto in <u>".$evidenza['nome_categoria']."</u> da <em>".$evidenza['username']."</em> il ".$evidenza['data']; ?></span>
		<br/>
		<p><?php echo TagliaStringa(strip_tags($evidenza['testo']), 200); /* Stampa i primi 200 caratteri del testo dell'articolo in evidenza */?>
		<a href="<?php echo "index.php?id_articolo=$evidenza[id_articolo]"; ?>">Continua a leggere</a>
		</p>
		</div>
		<div class="hr"><hr /></div>
	<?php
	}
	
	//prendiamo gli ultimi $art_x_pagina
	$query = mysql_query("SELECT id_articolo, titolo, testo, data, nome_categoria, username FROM articoli, categorie, utenti WHERE `pubblicato` = 1 AND `in_evidenza` = 0 AND articoli.id_categoria = categorie.id_categoria AND articoli.id_autore = utenti.id_utente ORDER BY `data` DESC LIMIT 0,$art_x_pagina");;
	
	}else{ //Altrimenti prendiamo gli articoli delle pagine precedenti.
	
	$b = $art_x_pagina; //articoli per pagina.
    $n_pag = mysql_escape_string($_GET['pag']);
    $qry = ($n_pag * $b) - $b.", $b";

    $query = mysql_query("SELECT id_articolo, titolo, testo, data, nome_categoria, username FROM articoli, categorie, utenti WHERE `pubblicato` = 1 AND `in_evidenza` = 0 AND articoli.id_categoria = categorie.id_categoria AND articoli.id_autore = utenti.id_utente ORDER BY `data` DESC LIMIT $qry");
	
	if(!mysql_num_rows($query)) echo "<h2>Fai poco il furbetto..</h2><br/><p>Tutti gli articoli vengono già mostrati nelle pagine precedenti.</p>"; //se si digita la pagina in URL senza che questa abbia bisogno di esistere (numero di articoli non sufficienti per la visualizzazione di più pagine)

	}
	
	// STAMPIAMO A SCHERMO GLI ARTICOLI RICHIESTI 
	    while ($articolo = mysql_fetch_array($query)){ //cicliamo per stampare gli articoli
		?>
		<!-- stampiamo i vari articoli -->
		<h3><?php echo $articolo['titolo'];?></h3> <span style="margin-left:5px; font-size:10px"><?php echo "Scritto in <u>".$articolo['nome_categoria']."</u> da <em>".$articolo['username']."</em> il ".$articolo['data']; ?></span>
		<br/>
		<p><?php echo TagliaStringa(strip_tags($articolo['testo']), 200); /* Stampa i primi 200 caratteri del testo dell'articolo */?>
		<a href="<?php echo "index.php?id_articolo=$articolo[id_articolo]"; ?>">Continua a leggere</a>
		</p>
		<div class="hr"><hr /></div>
		<?php
	    
	    }
		

	//genera i numeri di pagina finali...
$articoli_totali_db = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM `articoli` WHERE `in_evidenza` = 0 AND `pubblicato` = 1"));  // QUERY che conta il numero totale di articoli. 

$numero_pagine = ($articoli_totali_db['COUNT(*)'] / $art_x_pagina); //numero di pagine. Tipo Float.
$numero_pagine = ceil($numero_pagine); // approssima per eccesso il numero di pagine per avere un num intero.
echo "<br/><br/><center>Pagina: ";
for ($i = 1; $i <= $numero_pagine; $i++){
// URL originale pagina: index.php?pag=$i
if ($i == 1) //pag=1 sarà sostituita dalla index:
echo "<a href='".$_SERVER['PHP_SELF']."'>$i</a>|";
else 
echo "<a href='".$_SERVER['PHP_SELF']."?pag=$i'>$i</a>|";
}
echo "</center><br/>";

echo "</div>";
	}
	?>
  
   
    <div id="nav"> <!-- SIDEBAR Sinistra -->
 <?php include("sidebar_sx.php"); ?>
    </div>
</div>
   <div id="extra"> <!-- SIDEBAR Destra -->
 <?php include("sidebar_dx.php"); ?>
   </div>
  <div id="footer"> <!-- FOOTER -->
   <center><p><?php echo "$footer"; ?></p></center>
  </div>
  
</div>
<br/><br/>
</body>
</html>