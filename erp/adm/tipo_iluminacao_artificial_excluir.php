<?php
include "../sessao.php";
include "../config/connect.php";
ob_start();
for($i=0; $i<count($cod_luz_art); $i++){

$query_delete="delete from luz_artificial where cod_luz_art=".$cod_luz_art[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Tipo de Iluminação Artificial Excluido com Sucesso!');</script>";
header("location: tipo_iluminacao_artificial_adm.php");
?>