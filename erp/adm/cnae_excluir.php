<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($cnae_id); $i++){

$query_delete="delete from cnae where cnae_id=".$cnae_id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Risco Excluido com Suecesso!');</script>";
header("location: cnae_adm.php");
?>