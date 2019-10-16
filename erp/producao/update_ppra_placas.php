<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "ppra_functions.php";

if(empty($_GET[ano]) || !is_numeric($_GET[ano]))$_GET[ano] = date("Y");

$sql = "SELECT * FROM ppra_placas WHERE cod_cliente='{$_GET['cliente_id']}' AND cod_setor='{$_GET['setor']}' AND id_ppra = '{$_GET['id_ppra']}'";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);

$tmp = "";
for($x=0;$x<pg_num_rows($result);$x++){
   $tmp .= $buffer[$x]['id'];
   $tmp .= "|";
   $tmp .= $buffer[$x]['descricao'];
   $tmp .= "|";
   $tmp .= $buffer[$x]['legenda'];
   $tmp .= "|";
   $tmp .= $buffer[$x]['quantidade'];
   $tmp .= "|";
   $tmp .= $buffer[$x]['cod_prod'];
   $tmp .= "|";
   $tmp .= $buffer[$x]['cod_cliente'];
   $tmp .= "|";
   $tmp .= $buffer[$x]['cod_setor'];
   $tmp .= "|";
   $tmp .= date("Y");  //07
   if($x<pg_num_rows($result)-1){
      $tmp .= "§";
   }
}

echo urlencode($tmp);

?>
