<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($cod_vent_nat); $i++){

$query_delete="delete from ventilacao_natural where cod_vent_nat=".$cod_vent_nat[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Tipo de ventilação Artificial Excluido com Sucesso!');</script>";
header("location: tipo_ventilacao_natural_adm.php");
?>