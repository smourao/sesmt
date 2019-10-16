<?php
include "../sessao.php";
include "../config/connect.php";
ob_start();
for($i=0; $i<count($cod_vent_art); $i++){

$query_delete="delete from ventilacao_artificial where cod_vent_art=".$cod_vent_art[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Tipo de ventilação Artificial Excluido com Sucesso!');</script>";
header("location: tipo_ventilacao_artificial_adm.php");
?>