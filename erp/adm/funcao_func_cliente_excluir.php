<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($cargo_id); $i++){

$query_delete="delete from funcao_func_cliente where cargo_id=".$cargo_id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('funcao_func_cliente Excluido com Suecesso!');</script>";
header("location:funcao_func_cliente_adm.php");
?>