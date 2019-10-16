<?php
include "../../sessao.php";
include "config/connect.php";


 	$cod_fatura = $_GET[cod_fatura];
	
	
	if(!$_POST['novo_total'] && $cod_fatura){
	
		
		
		$upnovovalorsql = "UPDATE site_fatura_info SET novo_valor = NULL WHERE cod_fatura=$cod_fatura";
		$upnovovalor = pg_query($upnovovalorsql);
	
	
	
	}
	
 
 
    elseif($_POST['novo_total'] && $cod_fatura){
		
		$novo_valor = $_POST[novo_total];
		$novo_valor = str_replace("." , "" , $novo_valor);
		$novo_valor = implode(".", explode(",", $novo_valor));
		
		$upnovovalorsql = "UPDATE site_fatura_info SET novo_valor=$novo_valor WHERE cod_fatura=$cod_fatura";
		$upnovovalor = pg_query($upnovovalorsql);
		
		}
?>

<script>window.history.go(-1)</script>