<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "ppra_functions.php";
$sql = "DELETE FROM ppra_placas WHERE id={$_GET['id']}";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);
echo $_GET['cliente']."|".$_GET['setor']."|".$_GET[id_ppra];
?>
