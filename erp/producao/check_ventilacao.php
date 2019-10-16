<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
include "../config/funcoes.php";

$dt_ventilacao = $_GET['dt_ventilacao'];
$cliente = $_GET['cliente'];
$setor = $_GET['setor'];
$cod_vent_art = $_GET['id'];
$higiene = $_GET['higiene'];

$data = explode("/", $dt_ventilacao);
$dt_ventilacao = $data[1].'-'.$data[0].'-'.$data[2];

$sql = "UPDATE cliente_setor
				SET dt_ventilacao	=	'$dt_ventilacao'
				, higiene			=	'$higiene'
				, cod_vent_art		=	$cod_vent_art
				WHERE cod_cliente   =	$cliente and cod_setor = $setor";

$result = pg_query($connect, $sql)
	or die ("Erro na query: $sql ==> " . pg_last_error($connect) );

/*$sql = "SELECT * FROM cliente_comercial WHERE BTRIM(cnpj, ' ') = '{$cnpj}'";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);
if(pg_num_rows($result)>0){
   $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$buffer[funcionario_id]}";
   $r = pg_query($sql);
   $vendedor = pg_fetch_array($r);
   echo "CNPJ já cadastrado: $cnpj\nCliente: ".rtrim(ltrim($buffer['razao_social']))."\nCadastrado dia: ".$buffer['data']."\nVendedor: ".$vendedor['nome'];
}else{
   echo "0";
}*/

?>
