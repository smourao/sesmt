<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$cod_cgrt        = (int)($_GET[cod_cgrt]);
$cod_cliente     = (int)($_GET[cod_cliente]);
$cod_setor       = (int)($_GET[cod_setor]);
$cod_prod        = (int)($_GET[cod_prod]);
$quantidade      = (int)($_GET[qnt]);
$legenda         = addslashes($_GET[legenda]);

$sql = "SELECT * FROM produto WHERE cod_prod='$cod_prod'";
$res = pg_query($sql);
$data = pg_fetch_array($res);

$sql = "INSERT INTO ppra_placas
    (descricao, quantidade, cod_prod, legenda, cod_cliente, cod_setor, data, id_ppra)
    VALUES
    ('{$data[desc_detalhada_prod]}', '{$quantidade}', '{$cod_prod}', '".addslashes($legenda)."',
    '{$cod_cliente}', '{$cod_setor}', '".date("Y-m-d")."', $cod_cgrt)";

$ret = $cod_cgrt."|".$cod_setor."|";

if(pg_query($sql)){
    $ret .= "1";
}else{
    $ret .= "0";
}
echo $ret;
?>
