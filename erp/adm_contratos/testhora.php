<?php
ini_set("session.gc_maxlifetime", "18000");
	$host="postgresql04.sesmt-rio.com";//"postgres345.locaweb.com.br";
	$user="sesmt_rio3";
	$pass="Sesmt507311";
	$db="sesmt_rio3";
	$connect = pg_connect("host=$host dbname=$db user=$user password=$pass");
	if(!$connect)
		die("Erro na conexão à database.");
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

$diaaa = date("d");
		$messs = date("m");
		$anooo = date("Y");
		
		$dia = $diaaa;
		$mes = $messs;
		$ano = $anooo;



		if($dia >= 22){
		$mes = $mes + 1;
		}


		if($mes == 13){
		$ano = $ano+1;
		}

		if($mes == 13){
		$mes = 01;
		}
		
		
		$dataconfirm = $ano."-".$mes."-21";

		//Esse pega o numero da Fatura
		$numfaturasql = "SELECT * FROM site_fatura_info WHERE data_emissao = '$dataconfirm' AND cod_cliente = 59";
		$numfaturaquery = pg_query($numfaturasql);
		$numfatura = pg_fetch_array($numfaturaquery);
		$numfaturanum = pg_num_rows($numfaturaquery);
		
		echo $numfatura[cod_fatura];
		echo "<br> <br> <br>";
		echo $numfaturanum;
		
		$statussql = "SELECT status FROM cliente WHERE cliente_id = 59";
		$statusquery = pg_query($statussql);
		$status = pg_fetch_array($statusquery);
		
		echo "<br> <br> <br>";
		echo $status[status];
		
		$contratosql = "SELECT tipo_contrato FROM site_gerar_contrato WHERE cod_cliente = 1318";
		$contratoquery = pg_query($contratosql);
		$tipo_contrato = pg_fetch_array($contratoquery);
		if($tipo_contrato['tipo_contrato'] == ''){
			$tipo_contrato = 'Fechado' ;
		}else{
			$tipo_contrato = ucfirst($tipo_contrato['tipo_contrato']);
		}
		echo "<br> <br> <br>";
		echo $tipo_contrato;
		
		echo "<br> <br> <br>";
		
		$sqlmax = "SELECT MAX(cod_fatura) as cod_fatura FROM site_fatura_info";
  		$rmax = pg_query($sqlmax);
  		$max = pg_fetch_array($rmax);
		$maxnumfatura = $max[cod_fatura] + 1;
		echo $max[cod_fatura];
		echo "<br>";
		echo $maxnumfatura;
		
		
		$anocontratosql = "SELECT ano_contrato FROM cliente WHERE cliente_id = 1318";
       
        $anocontratoquery = pg_query($anocontratosql);
        $anocontrato = pg_fetch_array($anocontratoquery);
		
		
		$num_contrato = $anocontrato['ano_contrato'].".".STR_PAD(1318,3, "0", STR_PAD_LEFT);
		
		echo "----------------- <br><br>";
		echo $num_contrato;
		
	
echo ucfirst("hello world!");

		
?>


</body>
</html>