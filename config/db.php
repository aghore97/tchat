<?php
$link = @mysql_connect(_DB_CON_HOST,_DB_CON_USER,_DB_CON_PASS);
if (!$link) {
     die('Impossible de se connecter à la base de donnée: ' . mysql_errno());
}

mysql_select_db(_DB_CON_DB);
?>