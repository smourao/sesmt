<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($caracteristica_piso_id); $i++){

$query_delete="delete from caracteristica_piso where caracteristica_piso_id=".$caracteristica_piso_id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Tipo de Caracter�stica do Piso Excluida com Sucesso!');</script>";
header("location: caracteristica_piso_adm.php");
?>