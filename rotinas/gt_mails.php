<?php

include('../common/includes/database.php');

$data = date('Y-m-d');

$sql = "SELECT * FROM gm_dt WHERE data = '$data'";
$query = pg_query($sql);
$array = pg_fetch_all($query);









for($x=0;$x<pg_num_rows($query);$x++){
	if($array[$x][enviar] == 0){
		
	}else{
	
	
	
	
	
	$cod_mensagem = $array[$x][cod_mensagem];
	
	
	
	$c_comercial = $array[$x][c_comercial];
	$c_ativo = $array[$x][c_ativo];
	$c_parceria = $array[$x][c_parceria];
	$c_cortesia = $array[$x][c_cortesia];
	
	
	
	
	
	
	
	
	
	
	
	//PEGAR AS MENSAGEMS
	$sql2 = "SELECT * FROM gm_txt WHERE cod_mensagem = $cod_mensagem";
	$query2 = pg_query($sql2);
	$array2 = pg_fetch_all($query2);
	
	
	$tipomensagem = $array2[$x][tipo];
	$usuario = $array2[$x][usuario];
	$remete = $array2[$x]['setor'];
	
	
	if($remete == "sac"){
	$emailremete = "adm@sesmt-rio.com";
	
	}else if($remete == "comercial"){
	$emailremete = "comercial@sesmt-rio.com";
	
	
	}else if($remete == "financeiro"){
	$emailremete = "financeiro@sesmt-rio.com";
	
	
	}else if($remete == "juridico"){
	$emailremete = "juridico@sesmt-rio.com";
	
	
	}else if($remete == "parceria"){
	$emailremete = "parceria@sesmt-rio.com";
	
	
	
	}else if($remete == "marketing"){
	$emailremete = "";
	
	
	
	}else if($remete == "suporte"){
	$emailremete = "suporte@ti-seg.com";
	
	
	
	}else if($remete == "medico"){
	$emailremete = "medicotrab@sesmt-rio.com";
	
	
	}else if($remete == "tecnico"){
	$emailremete = "segtrab@sesmt-rio.com";
	
	
	}else if($remete == "compras"){
	$emailremete = "compras@sesmt-rio.com";
	
	}else{
	$emailremete = "webmaster@sesmt-rio.com";
	}
	
	
	
	if($tipomensagem == 1){
		
		$emailusuariosql = "SELECT email FROM funcionario WHERE funcionario_id = $usuario";
		$emailusuarioquery = pg_query($emailusuariosql);
		$emailusuarioarray = pg_fetch_array($emailusuarioquery);
		$emailusuario = $emailusuarioarray['email'];
		
		
		
		
		$titulo = "SESMT: ".$array2[$x]['titulo'];
			$email	= $emailusuario;
			$msg	= "<font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><font face='verdana,arial,sans-serif' size='3'><center>".$array2[$x]['titulo']."</center></font><p><p><font face='verdana,arial,sans-serif' size='3'>".$array2[$x]['mensagem']."</font>";
	
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= 'From: SESMT - Seguran??a do Trabalho e Higiene Ocupacional. <'.$emailremete.'> ' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
					

			if(mail($email, $titulo, $msg, $headers)){
				echo "ok";
			}
		
		
		
		
		
		
		
		
		
		
		
		
	}else{
	
	
	
	
	
	
	//PEGAR OS EMAILS
		
	if($c_comercial == 1){
		
		$comercialsql = "SELECT email FROM cliente WHERE cliente_ativo = 0";
		$comercialquery = pg_query($comercialsql);
		$comercialarray = pg_fetch_all($comercialquery);
		$comercialnum = pg_num_rows($comercialquery);
		
		
		for($y=0;$y<$comercialnum;$y++){
		
			$titulo = "SESMT: ".$array2[$x]['titulo'];
			$email	= $comercialarray[$y]['email'];
			$msg	= "<font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><font face='verdana,arial,sans-serif' size='3'><center>".$array2[$x]['titulo']."</center></font><p><p><font face='verdana,arial,sans-serif' size='3'>".$array2[$x]['mensagem']."</font>";
	
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			if($y == 1){
    					$headers .= 'From: SESMT - Seguran??a do Trabalho e Higiene Ocupacional. <'.$emailremete.'> ' . "\n" .
    					'Bcc: piccolo.dbz89@hotmail.com; comercial@sesmt-rio.com; suporte@sesmt-rio.com' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
					}else{
						$headers .= 'From: SESMT - Seguran??a do Trabalho e Higiene Ocupacional. <'.$emailremete.'> ' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
					}

			if(mail($email, $titulo, $msg, $headers)){
				echo "ok";
			}
		
		
		
		}
	
	}
	
	
	if($c_ativo == 1){
		
		$ativosql = "SELECT email FROM cliente WHERE cliente_ativo = 1";
		$ativoquery = pg_query($ativosql);
		$ativoarray = pg_fetch_all($ativoquery);
		$ativonum = pg_num_rows($ativoquery);
		
		
		for($y=0;$y<$ativonum;$y++){
		
			$titulo = "SESMT: ".$array2[$x]['titulo'];
			$email	= $ativoarray[$y]['email'];
			$msg	= "<font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><font face='verdana,arial,sans-serif' size='3'><center>".$array2[$x]['titulo']."</center></font><p><p><font face='verdana,arial,sans-serif' size='3'>".$array2[$x]['mensagem']."</font>";
	
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			if($y == 1){
    					$headers .= 'From: SESMT - Seguran??a do Trabalho e Higiene Ocupacional. <'.$emailremete.'> ' . "\n" .
    					'Bcc: piccolo.dbz89@hotmail.com; comercial@sesmt-rio.com; suporte@sesmt-rio.com' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
					}else{
						$headers .= 'From: SESMT - Seguran??a do Trabalho e Higiene Ocupacional. <'.$emailremete.'> ' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
					}

			if(mail($email, $titulo, $msg, $headers)){
				echo "ok";
			}
		
		
		
		}
	
	}
	
	
	
	if($c_cortesia == 1 || $c_parceria == 1){
		
		$parceriasql = "SELECT email FROM cliente WHERE cliente_ativo = 2";
		$parceriaquery = pg_query($parceriasql);
		$parceriaarray = pg_fetch_all($parceriaquery);
		$parcerianum = pg_num_rows($parceriaquery);
		
		
		for($y=0;$y<$parcerianum;$y++){
		
			$titulo = "SESMT: ".$array2[$x]['titulo'];
			$email	= $parceriaarray[$y]['email'];
			$msg	= "<font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><font face='verdana,arial,sans-serif' size='3'><center>".$array2[$x]['titulo']."</center></font><p><p><font face='verdana,arial,sans-serif' size='3'>".$array2[$x]['mensagem']."</font>";
	
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			if($y == 1){
    					$headers .= 'From: SESMT - Seguran??a do Trabalho e Higiene Ocupacional. <'.$emailremete.'> ' . "\n" .
    					'Bcc: piccolo.dbz89@hotmail.com; comercial@sesmt-rio.com; suporte@sesmt-rio.com' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
					}else{
						$headers .= 'From: SESMT - Seguran??a do Trabalho e Higiene Ocupacional. <'.$emailremete.'> ' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
					}

			if(mail($email, $titulo, $msg, $headers)){
				echo "ok";
			}
		
		
		
		}
	
	}
	
	
	
	}
	
	
	
	}
}

?>