<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
include "../config/funcoes.php";

$cliente 				  = $_GET['cliente'];
$setor 					  = $_GET['setor'];
$num_aparelhos 			  = $_GET['num_aparelhos'];
$dt_venti	    		  = $_GET['dt_venti'];
$proxima_limpeza_mecanica = $_GET['proxima_limpeza_mecanica'];
$marca 					  = $_GET['marca'];
$ultima_limpeza_duto 	  = $_GET['ultima_limpeza_duto'];
$proxima_limpeza_duto 	  = $_GET['proxima_limpeza_duto'];
$modelo 				  = $_GET['modelo'];
$capacidade 			  = $_GET['capacidade'];
$empresa_servico 		  = $_GET['empresa_servico'];

if($_GET[dt_venti] == ""){
	$data = "null";	
}else{
	$dt = explode("/", $_GET[dt_venti]);
	if(count($dt)>2){
	   $data = "'".$dt[2]."-".$dt[1]."-".$dt[0]."'";//se for informado com 3 valores
	}
}

if($_GET[proxima_limpeza_mecanica] == ""){
	    $data1 = "null";	
	}else{
	    $dt1 = explode("/", $_GET[proxima_limpeza_mecanica]);
		if(count($dt1)>2){
		   $data1 = "'".$dt1[2]."-".$dt1[1]."-".$dt1[0]."'";//se for informado com 3 valores
		}
	}

if($_GET[ultima_limpeza_duto] == ""){
	    $data2 = "null";	
	}else{
	    $dt2 = explode("/", $_GET[ultima_limpeza_duto]);
		if(count($dt2)>2){
		   $data2 = "'".$dt2[2]."-".$dt2[1]."-".$dt2[0]."'";//se for informado com 3 valores
		}
	}

if($_GET[proxima_limpeza_duto] == ""){
	    $data3 = "null";	
	}else{
	    $dt3 = explode("/", $_GET[proxima_limpeza_duto]);
		if(count($dt3)>2){
		   $data3 = "'".$dt3[2]."-".$dt3[1]."-".$dt3[0]."'";//se for informado com 3 valores
		}
	}

$sql = "UPDATE cliente_setor
				SET num_aparelhos 		   = '$num_aparelhos'
				, dt_ventilacao		   	   = {$data}
				, proxima_limpeza_mecanica = {$data1}
				, marca					   = '$marca'
				, ultima_limpeza_duto	   = {$data2}
				, proxima_limpeza_duto	   = {$data3}
				, modelo				   = '$modelo'
				, capacidade			   = '$capacidade'
				, empresa_servico		   = '$empresa_servico'
				WHERE cod_cliente   	   = $cliente and cod_setor = $setor";

$result = pg_query($connect, $sql)
	or die ("Erro na query: $sql ==> " . pg_last_error($connect) );

?>