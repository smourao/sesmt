<?php

include('../common/includes/database.php');

$data_hoje = date('Y-m-d');

$pegarcodclientesql = "SELECT c.cliente_id FROM cgrt_info ci, cliente c WHERE c.cliente_id = ci.cod_cliente AND c.status = 'ativo' GROUP BY cliente_id ORDER BY c.cliente_id ";


$pegarcodclientequery = pg_query($pegarcodclientesql);

$pegarcodcliente = pg_fetch_all($pegarcodclientequery);

$pegarcodclientenum = pg_num_rows($pegarcodclientequery);

$titulo = "SESMT: Sobre o vencimento dos Programas.";

$email = "segtrab@sesmt-rio.com;tecnica1@sesmt-rio.com;financeiro@sesmt-rio.com;suporte@ti-seg.com";


for($i=0;$i<$pegarcodclientenum;$i++){
	
	$cod_cliente = $pegarcodcliente[$i][cliente_id];
	
	
		
	$cgrtsql = "SELECT ci.cod_cgrt, c.razao_social, ci.data_criacao FROM cgrt_info ci, cliente c WHERE c.cliente_id = ci.cod_cliente AND ci.cod_cliente = ".$cod_cliente." ORDER BY ano DESC, data_criacao ASC";
	$cgrtquery = pg_query($cgrtsql);
	$cgrtall = pg_fetch_array($cgrtquery);
	$cod_cgrt = $cgrtall[cod_cgrt];
	$razao_social = $cgrtall['razao_social'];
	$data_criacao = $cgrtall['data_criacao'];
	$data_mais_10_meses = date('Y-m-d', strtotime("+10 month",strtotime($data_criacao)));
	$data_mais_11_meses = date('Y-m-d', strtotime("+11 month",strtotime($data_criacao))); 
	
	
	
	
	
	
	
	
	if($data_hoje == $data_mais_10_meses){
	
	$msg = "<font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><p><font face='verdana,arial,sans-serif' size='3'>O Cliente <b>".$razao_social."</b> esta com programa a vencer em 2 meses</font>";
	
	
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();
					

	if(mail($email, $titulo, $msg, $headers)){
		
		echo "ok";
	}
	
	
	
}elseif($data_hoje == $data_mais_11_meses){
	
	$msg = "<font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><p><font face='verdana,arial,sans-serif' size='3'>O Cliente <b>".$razao_social."</b> esta com programa a vencer em 1 mes</font>";
	
	
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();
					

	if(mail($email, $titulo, $msg, $headers)){
		
		echo "ok";
	}
	
}
	
	
	
	
	
	
	
	
	
	
	



}

?>