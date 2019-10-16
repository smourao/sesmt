<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
include "../config/funcoes.php";

$cliente = $_GET['cliente'];
$setor = $_GET['setor'];
$degraus = $_GET['degraus'];
$largura = $_GET['largura'];
$fita = $_GET['fita'];

$sql = "UPDATE cliente_setor
				SET degraus	=	'$degraus'
				, largura	=	'$largura'
				, fita		=	'$fita'
				WHERE cod_cliente   =	$cliente and cod_setor = $setor";

$result = pg_query($connect, $sql)
	or die ("Erro na query: $sql ==> " . pg_last_error($connect) );

//echo "".$sql;
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
