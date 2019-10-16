<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];

$sql = "SELECT * FROM cliente WHERE cliente_id = '{$cod_cliente}'";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);

$msg = "";
$msg.= "<p>";
$msg.= "<center><input type=button onclick=\"add_comment({$cod_cliente});\" value='Adicionar comentário'></center>";
$msg.= "<p>";

$sql = "SELECT * FROM erp_cliente_message WHERE cliente_id = '{$cod_cliente}'";
$result = pg_query($sql);
$dados = pg_fetch_all($result);

for($x=0;$x<pg_num_rows($result);$x++){
   $msg .= date("d/m/Y", strtotime($dados[$x]['data_criacao']))." <input type=button onclick='delete_message({$dados[$x][id]});' value='Excluir'> - <b><span style='cursor:pointer;' onclick=\"edit_message({$dados[$x][id]});\">{$dados[$x][titulo]}</span></b>";
   $msg .= "<br>";
}
echo $msg;
?>
