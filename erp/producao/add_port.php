<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
include "../config/funcoes.php";

$cliente  	   = $_GET['cliente'];
$setor 	  	   = $_GET['setor'];
$dt_ventilacao = $_GET['dt_ventilacao'];
$higiene  	   = $_GET['higiene'];

if($_GET[dt_ventilacao] == ""){
	$data = "null";	
}else{
	$dt = explode("/", $_GET[dt_ventilacao]);
	if(count($dt)>2){
	   $data = "'".$dt[2]."-".$dt[1]."-".$dt[0]."'";//se for informado com 3 valores
	}
}

$sql = "UPDATE cliente_setor
				SET dt_ventilacao 	  = {$data}
				, higiene 		  	  = '$higiene'
				WHERE cod_cliente 	  = $cliente and cod_setor = $setor";

$result = pg_query($connect, $sql)
	or die ("Erro na query: $sql ==> " . pg_last_error($connect) );

?>