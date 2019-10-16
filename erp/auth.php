<?php
ini_set("session.gc_maxlifetime", "18000");
session_start();
ini_set("session.gc_maxlifetime", "18000");
include "./config/connect.php";
include "./config/config.php";
//session_register(grupo, usuario_id);//*********** não utilizar! ****************
$_POST[login] = addslashes($_POST[login]);
$_POST[senha] = addslashes($_POST[senha]);
$login = $_POST[login];
$senha = $_POST[senha];

$query_usuario="select * from usuario where login='$login' and senha='$senha'";
$result_usuario=pg_query($query_usuario);
$row_usuario = pg_fetch_array($result_usuario);

if($row_usuario[usuario_id]!=""){
	$query_grupo = "select * from grupo where grupo_id='".$row_usuario[grupo_id]."'";
	$result_grupo = pg_query($query_grupo);
	$row_grupo = pg_fetch_array($result_grupo);
	
	$query_alog = "insert into log (usuario_id, data, detalhe) values('".$row_usuario[funcionario_id]."', '".date('m/d/Y H:i:s')."', 'login')";
	$result_alog = pg_query($query_alog);

	$query_log = "select * from log where usuario_id='".$row_usuario[usuario_id]."' order by log_id DESC LIMIT 1";
	$result_log = pg_query($query_log);
	$row_log = pg_fetch_array($result_log);
    $_SESSION['usuario_id'] = $row_usuario[funcionario_id];
    $_SESSION['grupo'] = $row_grupo[nome];
	$grupo      = $row_grupo[nome];
    $usuario_id = $row_usuario[funcionario_id];

	header("location: http://$dominio/tela_principal.php");
}else{
	header("location: http://$dominio/index.php?erro=1");
}
?>
