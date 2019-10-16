<?php
$dat = date("Y-m-d");
//${dtaso[$key]}
if($_GET[aso]){
	$sqll = "DELETE FROM aso_exame WHERE cod_aso = '$_GET[aso]'";
	$queryy = pg_query($sqll);
	$chkbox = $_POST[confirma];	
	$_POST[search] = $_GET[aso];
	if(is_array($chkbox)){
		foreach($chkbox as $chkbox => $schkbox){
			$sql = "INSERT INTO aso_exame (cod_aso, cod_exame, confirma, data) VALUES ('$_GET[aso]', '{$_POST[confirma][$chkbox]}', '0', '$dat')";
			if($query = pg_query($sql)){
				showMessage('Exames adicionados com sucesso! O cliente ja receberá um email com os proximos passos.');
				$okk = 1;								
			}else{
				showMessage('Ocorreu um erro no processo, favor falar com o suporte.');
			}
		}
	}else{
		$sql = "INSERT INTO aso_exame (cod_aso, cod_exame, confirma, data) VALUES ('$_GET[aso]', '$_POST[confirma]', '0', '$dat')";
		
		if($query = @pg_query($sql)){
			showMessage('Exame adicionados com sucesso! O cliente ja receberá um email com o encaminhamento.');
			$okk = 1;
		}else{
			showMessage('Ocorreu um erro no processo, favor falar com o suporte.');
		}
	}
	if($okk == 1){
		$sqla = "SELECT * FROM aso a, reg_pessoa_juridica c WHERE a.cod_aso = $_GET[aso] AND a.cod_cliente = c.cod_cliente";
		$querya = pg_query($sqla);
		$arraya = pg_fetch_array($querya);
							
		$msg = "Prezado cliente, o encaminhamento solicitado ja está disponível, basta clicar no link abaixo e escolher a clínica de sua preferência.";
		$msg .= '<p /><a href="http://www.sesmt-rio.com/?do=imp_enc&cod_aso='.$arraya[cod_aso].'&a=3&col='.$arraya[cod_func].'">Selecionar clinica e emprimir encaminhamento</a>';
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
		mail("suporte@ti-seg.com;".$arraya[email]."", "SESMT - Solicitação de encaminhamento para ASO avulso Nº: ".$cod_aso, $msg, $headers);
	}

}


?>