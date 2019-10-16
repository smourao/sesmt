<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "config/connect.php";
$erro = "";

$sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura='{$_GET['fatura']}'";
$res = pg_query($sql);
$buffer = pg_fetch_all($res);

$sql = "SELECT * FROM site_fatura_info WHERE cod_fatura = {$_GET['fatura']}";
$result = pg_query($sql);
$data = pg_fetch_array($result);

$text = "";

for($x=0;$x<pg_num_rows($res);$x++){
    $text .= $buffer[$x]['id']."|";
    $text .= $buffer[$x]['cod_fatura']."|";
    $text .= $buffer[$x]['cod_cliente']."|";
    $text .= $buffer[$x]['cod_filial']."|";
    $text .= $buffer[$x]['descricao']."|";
    $text .= $buffer[$x]['quantidade']."|";
    $text .= $buffer[$x]['parcelas']."|";
    $text .= $buffer[$x]['valor']."|";
    $text .= $data['data_emissao']."|";
    $text .= $data['data_vencimento']."|";
    $text .= $data['pc']."£";
}
echo urlencode($_GET['orcamento']."¢".$text);
?>
