<?php //viene incluso dinamicamente dalle altre pagine

$pagine = mysql_query("SELECT id_pagina, titolo FROM pagine ORDER BY ordine ASC");

echo "- ";
while($menu = mysql_fetch_array($pagine)){
echo "<a href='index.php?id_pagina=$menu[id_pagina]'>".$menu['titolo']."</a> - ";

}
?>