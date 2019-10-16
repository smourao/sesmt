<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "config/connect.php";
$cod = 0;

$sql = "SELECT * FROM site_orc_pc_produto WHERE
cod_orcamento={$_GET['orcamento']} AND
cod_cliente = {$_GET['cod_cliente']} AND cod_filial={$_GET['cod_filial']} AND
cod_produto = {$_GET['cod_produto']} AND legenda = {$_GET['legenda']}
";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);

if(pg_num_rows($result)>0){
    $cod = 1;//Item já existente
    $sql = "UPDATE site_orc_pc_produto SET quantidade=".($buffer[0]['quantidade']+$_GET['qnt'])."
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
    
    $sql = "UPDATE site_orc_pc_info SET orc_request_time_sended=0 WHERE cod_orcamento={$_GET['orcamento']} AND
    cod_cliente = {$_GET['cod_cliente']} AND
    cod_filial={$_GET['cod_filial']}";
    pg_query($sql);
}else{
    $sql = "INSERT INTO site_orc_pc_produto
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
?>
