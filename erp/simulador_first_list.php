<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];

$sql = "SELECT * FROM erp_relatorio_simulador WHERE simulador_id = '{$cod_cliente}'";
$r = pg_query($sql);
$data = pg_fetch_array($r);

$sql = "SELECT * FROM cliente_comercial WHERE cliente_id = '{$cod_cliente}'";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);

$msg = "<p>";
$msg.= date("d/m/Y", strtotime($data['data_criacao']))." - <b><span style='cursor:pointer;' onclick=\"simulador_first_edit({$cod_cliente});\">Relatório de primeiro contato.</span></b>";
$msg.= "<p>";
//$msg.= "<center><span style='cursor:pointer;' onclick=\"add_comment({$cod_cliente});\"><b>Adicionar comentário</b></span></center>";
$msg.= "<center><input type=button onclick=\"add_comment({$cod_cliente});\" value='Adicionar comentário'></center>";
$msg.= "<p>";

$sql = "SELECT * FROM erp_simulador_message WHERE simulador_id = '{$cod_cliente}'";
$result = pg_query($sql);
$dados = pg_fetch_all($result);

for($x=0;$x<pg_num_rows($result);$x++){
   $msg .= date("d/m/Y", strtotime($dados[$x]['data_criacao']))." <input type=button onclick='delete_message({$dados[$x][id]});' value='Excluir'> - <b><span style='cursor:pointer;' onclick=\"edit_message({$dados[$x][id]});\">{$dados[$x][titulo]}</span></b>";
   $msg .= "<br>";
}

echo $msg;

?>
