<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($cod_associada); $i++){

$query_delete="delete from unidade where cod_associada=".$cod_associada[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Risco Excluido com Suecesso!');</script>";
header("location: associada_adm_teste.php");
?>