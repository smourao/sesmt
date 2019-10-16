<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($id); $i++){

$query_delete="delete from diametro_mangueira where diametro_mangueira_id=".$id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Diâmetro Mangueira Excluido com Sucesso!');</script>";
header("location: diametro_mangueira_adm.php");
?>