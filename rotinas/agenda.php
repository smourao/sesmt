<?php

include('../common/includes/database.php');

$data = date('Y-m-d');

$sql = "SELECT * FROM agenda_comp WHERE data = '$data'";
$query = pg_query($sql);
$array = pg_fetch_all($query);

for($x=0;$x<pg_num_rows($query);$x++){
	
	if($array[$x][tipo] == "comemorativa"){
		$add = "Aniversário";
	}elseif($array[$x][tipo] == "evento"){
		$add = "Evento";
	}elseif($array[$x][empresa] == "sesmt"){
		$add = "SESMT";
	}elseif($array[$x][empresa] == "tiseg"){
		$add = "TI-SEG";
	}
	
	$titulo = $add." - ".$array[$x][evento];
	$email	= $array[$x][email];
	$msg	= "<center>".$array[$x][evento]."</center><p>".$array[$x][texto];
	
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: Agenda SESMT. <suporte@ti-seg.com> \n";

	if(mail($email, $titulo, $msg, $headers)){
		echo "ok";
	}
}

?>