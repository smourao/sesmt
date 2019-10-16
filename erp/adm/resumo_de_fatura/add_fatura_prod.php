<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "config/connect.php";
$cod = 0;
$fatura = $_GET['fatura'];
$cod_cliente = $_GET['cod_cliente'];
$cod_filial = $_GET['cod_filial'];
$desc = addslashes($_GET['desc']);
$quantidade = $_GET['qnt'];
$parcelas = $_GET['parcelas'];
$valor = str_replace(".", "", $_GET['valor']);
$valor = str_replace(",", ".", $valor);

$ptmp = explode("/", $parcelas);
$patual = $ptmp[0];
$pfinal = $ptmp[1];

for($x=0;$x<(($pfinal-$patual)+1);$x++){
    $sql = "INSERT INTO site_fatura_produto
    (cod_fatura, cod_cliente, cod_filial, descricao, quantidade, parcelas, valor)
    VALUES
    ('".($fatura+$x)."', '{$cod_cliente}', '{$cod_filial}', '{$desc}', '{$quantidade}',
    '".str_pad($patual+$x, 2, "0", 0)."/$pfinal', '{$valor}')";
    $finish = pg_query($sql);
}

if($finish){
   echo "1";
}else{
   echo "";
}
?>
