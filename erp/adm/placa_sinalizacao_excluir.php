<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($id); $i++){

$query_delete="delete from placa_sinalizacao where placa_sinalizacao_id=".$id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Placa de Sinaliza��o Excluida com Sucesso!');</script>";
header("location: placa_sinalizacao_adm.php");
?>