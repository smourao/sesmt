<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($brigadista_id); $i++){

$query_delete="delete from brigadistas where brigadista_id=".$brigadista_id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Classe Excluida com Sucesso!');</script>";
header("location: brigada_adm.php");
?>