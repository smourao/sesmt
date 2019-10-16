<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];

if(is_numeric($cod_cliente)){
    $sql = "SELECT * FROM cliente WHERE cliente_id=$cod_cliente";
}else{
    $sql = "SELECT * FROM cliente WHERE lower(razao_social) like '%".strtolower($cod_cliente)."%' ORDER BY cliente_id";
}


    $result = pg_query($sql);
    $buffer = pg_fetch_all($result);
    $tmp = "";
    
    for($x=0;$x<pg_num_rows($result);$x++){
       $tmp .= $buffer[$x]['cliente_id']."|".$buffer[$x]['razao_social']."|".$buffer[$x]['filial_id'];
       $tmp .= "§";
    }
    
echo $tmp;

