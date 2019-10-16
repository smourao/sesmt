<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
$erro = "";

$sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade
FROM orcamento_produto op, produto p
WHERE op.cod_orcamento={$_GET['orcamento']}
AND (p.cod_prod = op.cod_produto)
";
$res = pg_query($sql);
$buffer = pg_fetch_all($res);

$sql = "SELECT * FROM orcamento WHERE cod_cliente = {$_GET['cod_cliente']} AND cod_orcamento={$_GET['orcamento']}";
$result = pg_query($sql);
$data = pg_fetch_array($result);

$text = "";

for($x=0;$x<pg_num_rows($res);$x++){
    $text .= $buffer[$x]['id']."|";
    $text .= $buffer[$x]['cod_produto']."|";
    $text .= $buffer[$x]['quantidade']."|";
    if(!empty($buffer[$x]['preco_unitario'])){
        $text .= $buffer[$x]['preco_unitario']."|";
        $editado = 1;
    }else{
        $text .= $buffer[$x]['preco_prod']."|";
        $editado = 0;
    }
    $text .= $buffer[$x]['desc_detalhada_prod']."|";//$buffer[$x]['desc_resumida_prod']."|";
    $text .= $buffer[$x]['desc_detalhada_prod']."|";
    $text .= $buffer[$x]['cod_atividade']."|";
    $text .= $buffer[$x]['aprovado']."|";
    $text .= $data['orc_request_time_sended']."|";
    $text .= $data['aprovado']."|";
    $text .= $_GET['cod_cliente']."|"; //10
    $text .= $_GET['cod_filial']."|";
    $text .= $_GET['orcamento']."|";
    $text .= $editado."£";
/*
    $text .= $buffer[$x]['id']."|";
    $text .= $buffer[$x]['cod_produto']."|";
    $text .= $buffer[$x]['quantidade']."|";
    if(!empty($buffer[$x]['preco_unitario'])){
        $text .= $buffer[$x]['preco_unitario']."|";
    }else{
        $text .= $buffer[$x]['preco_prod']."|";
    }
    //$text .= $buffer[$x]['preco_prod']."|";
    $text .= $buffer[$x]['desc_resumida_prod']."|";
    $text .= $buffer[$x]['desc_detalhada_prod']."|";
    $text .= $buffer[$x]['cod_atividade']."|";
    $text .= $buffer[$x]['aprovado']."|";
    $text .= $data['orc_request_time_sended']."|";
    $text .= $data['aprovado']."£";
*/
}


echo urlencode($_GET['orcamento']."¢".$text);
?>
