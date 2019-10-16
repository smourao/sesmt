<?php
session_start();

	//if($grupo!="funcionario" and $grupo!="administrador" and $grupo!="vendedor" and $grupo!="autonomo" and $grupo!="clinica")
    if(!$_SESSION[usuario_id]){
		echo '<script> alert("Faça o LOGIN!");</script>';
		header("location: index.php?sessao=0");
	}
//$dominio = "localhost";
?>
