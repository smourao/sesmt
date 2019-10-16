<?php
include "../sessao.php";
include "../config/connect.php";
ob_start();
for($i=0; $i<count($cod_parede); $i++){

$query_delete="delete from parede where cod_parede=".$cod_parede[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Característica de Parede Excluida com Sucesso!');</script>";
header("location: caracteristica_parede_adm.php");
?>