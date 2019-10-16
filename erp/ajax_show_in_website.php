<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];

$sql = "SELECT * FROM cliente WHERE cliente_id = $cod_cliente";
$result = pg_query($sql);
$data = pg_fetch_array($result);

if($data[showsite]){
    $sql = "UPDATE cliente SET showsite = 0 WHERE cliente_id = $cod_cliente";
    $changeto = 0;
}else{
    $sql = "UPDATE cliente SET showsite = 1 WHERE cliente_id = $cod_cliente";
    $changeto = 1;
}

if(pg_query($sql)){
    echo "1|$changeto|$cod_cliente";
}else{
    echo "0|$changeto|$cod_cliente";
}
?>
