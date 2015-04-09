<?php
############################################################################
###
### CMS DATABASE - ROCCO MUSOLINO - http://www.hackerstribe.com
###
############################################################################
$db_hostname = "localhost";
$db_database = "sito_news";
$db_username = "root";
$db_password = "root";
mysql_connect($db_hostname, $db_username, $db_password) or die ("Impossibile connettersi al database.");
mysql_select_db("$db_database") or die ("Impossibile selezionare il database");
?>
