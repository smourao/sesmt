<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
//include("../../include/db.php");
//include "../sessao.php";
//include "../config/connect.php";
//include "../config/config.php";
//include "../config/funcoes.php";
include "config/connect.php";
$cod = 0;

//echo "retorno";

$sql = "SELECT * FROM site_orc_produto WHERE
cod_orcamento={$_GET['orcamento']} AND
cod_cliente = {$_GET['cod_cliente']} AND cod_filial={$_GET['cod_filial']} AND
cod_produto = {$_GET['cod_produto']} AND legenda = {$_GET['legenda']}
";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);

if(pg_num_rows($result)>0){
    $cod = 1;//Item j� existente
    $sql = "UPDATE site_orc_produto SET quantidade=".($buffer[0]['quantidade']+$_GET['qnt'])."
    WHERE cod_produto = {$_GET['cod_produto']} AND
    cod_orcamento={$_GET['orcamento']} AND
    cod_cliente = {$_GET['cod_cliente']} AND
    cod_filial={$_GET['cod_filial']} AND legenda = {$_GET['legenda']}
    ";
    $res = pg_query($sql);
    if($res){
       $cod = 2;//Produto adicionado com sucesso!
    }else{
       $cod = 3;//Erro ao adicionar o produto
    }
    
    $sql = "UPDATE site_orc_info SET orc_request_time_sended=0 WHERE cod_orcamento={$_GET['orcamento']} AND
    cod_cliente = {$_GET['cod_cliente']} AND
    cod_filial={$_GET['cod_filial']}";
    pg_query($sql);
}else{
    $sql = "INSERT INTO site_orc_produto
    (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda)
    values
    ('{$_GET['orcamento']}', '{$_GET['cod_cliente']}', '{$_GET['cod_filial']}',
    '{$_GET['cod_produto']}', '{$_GET['qnt']}', 1, '{$_GET['legenda']}')";
    $res = pg_query($sql);
    
    if($res){
       $cod = 2;//Produto adicionado com sucesso!
    }else{
       $cod = 3;//Erro ao adicionar o produto
    }
}

echo $cod;
/*
$sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade
FROM site_orc_produto op, produto p
WHERE op.cod_orcamento={$_GET['orcamento']} AND
op.cod_cliente = {$_GET['cod_cliente']} AND op.cod_filial={$_GET['cod_filial']}
AND (p.cod_prod = op.cod_produto)
";

$res = pg_query($conn, $sql);
$buffer = pg_fetch_all($res);

$text = "";

for($x=0;$x<pg_num_rows($res);$x++){
    $text .= $buffer[$x]['id']."|";
    $text .= $buffer[$x]['cod_produto']."|";
    $text .= $buffer[$x]['quantidade']."|";
    $text .= $buffer[$x]['preco_prod']."|";
    $text .= $buffer[$x]['desc_resumida_prod']."|";
    $text .= $buffer[$x]['desc_detalhada_prod']."|";
    $text .= $buffer[$x]['cod_atividade']."|";
    $text .= $buffer[$x]['aprovado']."�";
}


echo urlencode($_GET['orcamento']."�".$text);
*/
?>
