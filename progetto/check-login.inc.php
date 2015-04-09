<?php
//questo script è incluso in tutte le pagine protette, e controlla che la sessione sia presente e valida.

if (!isset($_SESSION)) { session_start(); }
if ($_SESSION['login'] != "ok") {
	header("Location: index.php");
}

############################################################################
###
### CMS DATABASE - ROCCO MUSOLINO - http://www.hackerstribe.com
###
############################################################################

?>