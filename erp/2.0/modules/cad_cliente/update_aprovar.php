<?php


if($_GET[cod_cliente] && $_GET[cod_orc])
{
	$sqlup = "UPDATE site_orc_info SET aprovado = 1 WHERE cod_orcamento = ".$_GET[cod_orc]." AND cod_cliente = ".$_GET[cod_cliente];
						
	$queryup = pg_query($sqlup);
}

$urlwww = $_SERVER['SERVER_NAME'];

if($urlwww == 'www.sesmt-rio.com'){
	
	echo"<script>
	location.href='http://www.sesmt-rio.com/erp/2.0/index.php?dir=cad_cliente&p=list_orc&cod_cliente=$_GET[cod_cliente]';
	</script>";
	
	


}else{
	
	echo"<script>
	location.href='http://sesmt-rio.com/erp/2.0/index.php?dir=cad_cliente&p=list_orc&cod_cliente=$_GET[cod_cliente]';
	</script>";

}

?>

