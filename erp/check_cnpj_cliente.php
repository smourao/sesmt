<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "./config/connect.php";
include "./config/funcoes.php";

$cnpj = $_GET['cnpj'];

$sql = "SELECT * FROM cliente WHERE BTRIM(cnpj, ' ') = '{$cnpj}'";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);
if(pg_num_rows($result)>0){
   if(!empty($buffer[vendedor_id])){
      $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$buffer[vendedor_id]}";
      $r = pg_query($sql);
      $vendedor = pg_fetch_array($r);
   }
   echo "CNPJ já cadastrado: $cnpj\nCliente: ".rtrim(ltrim($buffer['razao_social']))."\nCadastrado dia: ".$buffer['data']."\nVendedor: ".$vendedor['nome'];
}else{
   echo "0";
}

?>
