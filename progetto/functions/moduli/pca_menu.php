<?php
//viene inclusa da altre pagine [connessione al db già stabilità]

if (!isset($_SESSION)) { session_start(); }
if (@$_SESSION['login'] != "ok") header("Location: ../index.php"); //se non si è loggati (quindi se viene richiamata questa pagina direttamente):

/*controlliamo i permessi e stampiamo le relative voci del menu:
Se lettura = 1 mostra in menu: Home
Se scrittura = 1 mostra in menu: Scrivi Articolo
Se pubblicazione = 1 mostra in menu: Gestisci articoli
Se mod_utenti = 1 mostra in menu: Modifica utenti
Se mod_sito = 1 mostra in menu: Opzioni Sito
*/
$stringa = "- ";
if ($permessi['lettura']) $stringa .= "<a href='admin.php'>Home</a> - ";
if ($permessi['scrittura']) $stringa .= "<a href='admin.php?pag=scrivi-articolo'>Scrivi Articolo</a> - ";
if ($permessi['pubblicazione']) $stringa .= "<a href='admin.php?pag=gestisci-articoli'>Gestisci Articoli</a> - <a href='admin.php?pag=gestisci-categorie'>Gestisci Categorie</a> - ";
if ($permessi['mod_utenti']) $stringa .= "<a href='admin.php?pag=modifica-utenti'>Modifica Utenti</a> - ";
if ($permessi['mod_sito']) $stringa .= "<a href='admin.php?pag=opzioni-sito'>Opzioni sito</a> - ";

echo $stringa;

?>