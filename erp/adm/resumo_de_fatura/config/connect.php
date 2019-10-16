<?php
	$host="postgresql04.sesmt-rio.com";//"postgres345.locaweb.com.br";//"postgresql01.sesmt-rio.com";
	$user="sesmt_rio3";
	$pass="Sesmt507311";
	$db="sesmt_rio3";
	$connect = pg_connect("host=$host dbname=$db user=$user password=$pass");
	if(!$connect)
		die("Erro na conexão a base.");
		
/*
host para conexão via script: pg.dominal.com
banco: sesmt-rio
login: sesmt-rio
senha: t6r4e5w9
*/
?>
