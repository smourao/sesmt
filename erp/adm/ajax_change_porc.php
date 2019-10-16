<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
include "../config/funcoes.php";

$cod_clinica = $_GET['clinica'];
$valor = $_GET['valor'];

$sql = "UPDATE clinicas SET por_exames = '$valor' WHERE cod_clinica = '{$cod_clinica}'";
$result = pg_query($sql);
//$buffer = pg_fetch_array($result);
if($result){
    //
    echo $valor;
}else{
    echo "";
}

?>
