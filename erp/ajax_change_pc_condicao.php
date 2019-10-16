<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$orcamento = $_GET['id'];
$valor = $_GET['valor'];

    $sql = "UPDATE site_orc_pc_info SET condicao_de_pagamento = '{$valor}' WHERE cod_orcamento = '{$orcamento}'";
    $result = pg_query($sql);

if($result){
   echo "Condiчуo de pagamento alterada!";
}else{
   echo "Erro ao alterar condiчуo de pagamento!";
}

