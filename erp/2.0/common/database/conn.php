<?php
ini_set("session.gc_maxlifetime", "18000");
	$host="postgresql04.sesmt-rio.com";//"postgres345.locaweb.com.br";
	$user="sesmt_rio3";
	$pass="Sesmt507311";
	$db="sesmt_rio3";
	$connect = pg_connect("host=$host dbname=$db user=$user password=$pass");
	if(!$connect)
		die("Erro na conexão à database.");

/*ini_set("session.gc_maxlifetime", "18000");
	$host="postgresql02.sesmt-rio.com";//"postgres345.locaweb.com.br";
	$user="sesmt_rio";
	$pass="diggio3001";
	$db="sesmt_rio";
	$connect = @pg_connect("host=$host dbname=$db user=$user password=$pass");
	if(!$connect)
		die("Erro na conexão à database.");*/
?>
