<?php

include('../common/includes/database.php');
//teste de github

if(date("m")>10){
	$mes = (date("m")-1);
}else{
	$mes = "0".(date("m")-1);
}
$ano = date("Y");

$sql = "SELECT * FROM clinicas ORDER BY cod_clinica";
$res = pg_query($sql);
$buffer = pg_fetch_all($res);

echo $mes;

for($x=1;$x<pg_num_rows($res);$x++){
	
	if(file_exists("../erp/2.0/modules/repasse/relatorio/repasse_pdf/".$buffer[$x][cod_clinica]."/REP_".$mes."_".$ano.".pdf")){
		$link  = "<center><b><h2>CORREIO SESMT</h2></b></center>";
		$link .= "<center><p>Bom dia! Já encontra-se disponível o relatório de repasse deste mês! Clique ";
		$link .= "<a href='http://sesmt-rio.com/erp/2.0/modules/repasse/relatorio/repasse_pdf/".$buffer[$x][cod_clinica]."/REP_".$mes."_".$ano.".pdf'>AQUI</a>";
		$link .= " para visualizar!</center>";
		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
	
		$email = $buffer[$x][email_clinica].";suporte@ti-seg.com; webmaster@sesmt-rio.com; financeiro@sesmt-rio.com";
		//$email = $buffer[$x][email_clinica].";suporte@ti-seg.com;";
		//$email = "suporte@ti-seg.com; rafael_rocha15hf@hotmail.com;";
		
		if(mail($email, "SESMT - FATURA DE REPASSE", $link, $headers)){
			echo "ok";
		}else{
			echo "fail";
		}
	}

}


?>