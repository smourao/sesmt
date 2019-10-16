<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
for($i=0; $i<count($tipo_contato_id); $i++){

$query_delete="delete from tipo_contato where tipo_contato_id=".$tipo_contato_id[$i]."";
pg_query($query_delete) or die ("Erro na query:$query_delete".pg_last_error($connect));

}
echo"<script>alert('Tipo de Contato Excluido com Sucesso!');</script>";
header("location: tipo_contato_adm.php");
?>