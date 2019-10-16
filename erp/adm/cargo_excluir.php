<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($cargo_id); $i++){

$query_delete="delete from cargo where cargo_id=".$cargo_id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Cargo Excluido com Suecesso!');</script>";
header("location: cargo_adm.php");
?>