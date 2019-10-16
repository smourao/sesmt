<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($funcionario_id); $i++){

$query_delete="delete from funcionario where funcionario_id=".$funcionario_id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

$query_delete2="delete from usuario where funcionario_id=".$funcionario_id[$i]."";
pg_query($query_delete2) or die ("Erro na query:$query_delete2".pg_last_error($connect));

$query_delete3="delete from cliente where vendedor_id=".$funcionario_id[$i]."";
pg_query($query_delete3) or die ("Erro na query:$query_delete3".pg_last_error($connect));

}
echo"<script>alert('Funcionario Excluido com Suecesso!');</script>";
header("location: funcionario_sesmt_adm.php");
?>