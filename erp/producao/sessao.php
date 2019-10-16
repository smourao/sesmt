<?php
session_start();

	if($grupo!="funcionario" and $grupo!="administrador")
	{
		echo '<script> alert("Faça o LOGIN!");</script>';

		header("location: ../index.php?sessao=0");
	}
//$dominio = "www.sesmt-rio.com";
?>