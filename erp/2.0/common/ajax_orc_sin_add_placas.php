<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$cod_orcamento   = (int)($_GET[cod_orcamento]);
$cod_cliente     = (int)($_GET[cod_cliente]);
$cod_produto     = (int)($_GET[cod_produto]);
$quantidade      = (int)($_GET[qnt]);
$legenda         = addslashes($_GET[legenda]);
//$preco_produto	 = '$_GET[preco_produto]';

$sql = "SELECT * FROM produto WHERE cod_prod='$cod_produto'";
$res = pg_query($sql);
$data = pg_fetch_array($res);

$sql = "INSERT INTO site_orc_produto
    (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda,  preco_aprovado)
    VALUES
    ('{$cod_orcamento}', '{$cod_cliente}', '1', '{$cod_produto}', '{$quantidade}', '0', '".addslashes($legenda)."', '$data[preco_prod]')";

$ret = $cod_orcamento."|".$cod_cliente."|";

if(pg_query($sql)){
    $ret .= "1";
}else{
    $ret .= "0";
}
echo $ret;
?>
