<?php
include "../sessao.php";
include "../config/connect.php";
ob_start();
for($i=0; $i<count($cod_luz_nat); $i++){

$query_delete="delete from luz_natural where cod_luz_nat=".$cod_luz_nat[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));
}
echo"<script>alert('Tipo de ventilação Artificial Excluido com Sucesso!');</script>";
header("location: tipo_iluminacao_natural_adm.php");
?>