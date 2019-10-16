 <?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$fatura = $_GET['fatura'];
$contrato = $_GET['contrato'];
$emissao = $_GET['emissao'];
$vencimento = $_GET['vencimento'];
$forma_pagamento = $_GET['forma_pagamento'];

$emifor = explode("/", $emissao);
$venfor = explode("/", $vencimento);


$sql = "SELECT * FROM site_fatura_info WHERE cod_fatura = $_GET[fatura]";
$result = pg_query($sql);
$fat = pg_fetch_array($result);

$ptmp = explode("/", $fat[parcela]);

$patual = $ptmp[0];
$pfinal = $ptmp[1];










for($x=0;$x<(($pfinal-$patual)+1);$x++){
	
	
	
$testevencimento = date("Y-m-d", mktime(0,0,0,$venfor[1]+$x,$venfor[0],$venfor[2]));


$verdiasemana = date("w", strtotime($testevencimento));

if($verdiasemana == 6){
	
	$testevencimento = date('Y-m-d', strtotime("+2 days",strtotime($testevencimento)));
	
}

else if($verdiasemana == 0){
	
	$testevencimento = date('Y-m-d', strtotime("+1 days",strtotime($testevencimento)));
	
}


$partes = explode("-", $testevencimento);
$feridia = $partes[2];
$ferimes = $partes[1];

$verferiado = 0;




// 01/01 - Confraternização universal
if(($feridia == 01) && $ferimes == 01 ){
	
	$verferiado = 1;
	
}
// 20/01 -  Dia de São Sebastião
else if(($feridia == 20) && $ferimes == 01 ){
	
	
	$verferiado = 1;
	
}
// 21/04 - Tiradentes
else if(($feridia == 21) && $ferimes == 04 ){
	
	
	$verferiado = 1;
	
}// 23/04 - Dia de São Jorge
else if(($feridia == 23) && $ferimes == 04 ){
	
	
	$verferiado = 1;
	
}// 01/05 - Dia do Trabalhador
else if(($feridia == 01) && $ferimes == 05 ){
	
	
	$verferiado = 1;
	
}// 07/09 - Dia da Independência do Brasil
else if(($feridia == 07) && $ferimes == 09 ){
	
	
	$verferiado = 1;
	
}// 12/10 - Dia da Nossa Ser Aparecida
else if(($feridia == 12) && $ferimes == 10 ){
	
	
	$verferiado = 1;
	
}// 02/11 - Dia de Finados
else if(($feridia == 02) && $ferimes == 11 ){
	
	
	$verferiado = 1;
	
}// 15/11 - Ploclamação da Republica
else if(($feridia == 15) && $ferimes == 11 ){
	
	
	$verferiado = 1;
	
}// 20/11 - Dia da Consciência Negra
else if(($feridia == 20) && $ferimes == 11 ){
	
	
	$verferiado = 1;
	
} // 25/12 - Natal
else if(($feridia == 25) && $ferimes == 12 ){
	
	
	$verferiado = 1;
	
}

if($verferiado == 1){
	
	$testevencimento = date('Y-m-d', strtotime("+1 days",strtotime($testevencimento)));



		$verdiasemana = date("w", strtotime($testevencimento));

		if($verdiasemana == 6){
	
			$testevencimento = date('Y-m-d', strtotime("+2 days",strtotime($testevencimento)));
	
		}

		else if($verdiasemana == 0){
	
			$testevencimento = date('Y-m-d', strtotime("+1 days",strtotime($testevencimento)));
	
		}



}





$vencimento = date('d/m/Y', strtotime($testevencimento));
$venforz = explode("/", $vencimento);
	
	
	
	
	
    $sql = "UPDATE site_fatura_info SET
    data_emissao = '".date("Y-m-d", mktime(0,0,0,$emifor[1]+$x,$emifor[0],$emifor[2]))."',
    data_vencimento = '".date("Y-m-d", mktime(0,0,0,$venforz[1],$venforz[0],$venforz[2]))."',
    tipo_contrato = '{$contrato}',
    tipo_pagamento = '{$forma_pagamento}'
    WHERE cod_fatura = '".($fatura+$x)."'";
    $finish = pg_query($sql);
}
/*
$sql = "UPDATE site_fatura_info SET
data_emissao = '{$emifor[2]}/{$emifor[1]}/{$emifor[0]}',
data_vencimento = '{{$venfor[2]}/{$venfor[1]}/{$venfor[0]}}',
tipo_contrato = '{$contrato}',
tipo_pagamento = '{$forma_pagamento}'
WHERE cod_fatura = '{$fatura}'";
*/
if($finish){
   $tmp = date("d/m/Y", mktime(0,0,0,$emifor[1]-1, $emifor[0], $emifor[2]))." à ".$emissao;
   echo $tmp;
}else{
   echo "";
}
?>
