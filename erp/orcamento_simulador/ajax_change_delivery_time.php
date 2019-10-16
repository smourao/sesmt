<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("../config/connect.php");

$orcamento = $_GET['orc'];
$valor = $_GET['valor'];

    $sql = "UPDATE orcamento SET prazo_entrega = '{$valor}' WHERE cod_orcamento = '{$orcamento}'";
    $result = pg_query($sql);

if($result){
   echo "Prazo de entrega alterado!";
}else{
   echo "Erro ao alterar prazo de entrega!";
}

