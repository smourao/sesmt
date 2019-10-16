<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($risco_id); $i++){

$query_delete="delete from risco_cliente where risco_id=".$risco_id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Risco Excluido com Suecesso!');</script>";
header("location: riscos_adm.php");
?>