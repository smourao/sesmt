<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "ppra_functions.php";

$cod_prod = $_GET['cod_prod'];
$quantidade = $_GET['quantidade'];
$cod_cliente = $_GET['cod_cliente'];
$cod_setor = $_GET['cod_setor'];
$id_ppra = $_GET['id_ppra'];
$legenda = urldecode($_GET['legenda']);


if(is_numeric($cod_cliente) && is_numeric($cod_setor) && is_numeric($cod_prod) && is_numeric($quantidade) && $quantidade > 0){
   $sql = "SELECT * FROM produto WHERE cod_prod='$cod_prod'";
   $res = pg_query($sql);
   $data = pg_fetch_array($res);

   $sql = "INSERT INTO ppra_placas
   (descricao, quantidade, cod_prod, legenda, cod_cliente, cod_setor, data, id_ppra)
   VALUES
   ('{$data[desc_detalhada_prod]}', '{$quantidade}', '{$cod_prod}', '".addslashes($legenda)."',
   '{$cod_cliente}', '{$cod_setor}', '".date("Y-m-d")."', $id_ppra)";
   $result = pg_query($sql);
   $buffer = pg_fetch_all($result);
}


if($result){
   echo "$cod_cliente|$cod_setor|$id_ppra";
}else{
   echo "";
}

?>
