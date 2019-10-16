<?php
include "../sessao.php";
include "../config/connect.php";
ob_start();
for($i=0; $i<count($cod_cobertura); $i++){

$query_delete="delete from cobertura where cod_cobertura=".$cod_cobertura[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Característica de Cobertura Excluida com Sucesso!');</script>";
header("location: caracteristica_cobertura_adm.php");
?>