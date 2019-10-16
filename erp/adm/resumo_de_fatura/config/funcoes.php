<?php
		
session_start();
/*
function auth($log_id){
		
	if($log_id!=""){

		$query_log="select * from log where log_id=".$log_id."";
		$result_log=pg_query($query_log) or die("Erro na query".pg_last_error($connect));
		$row_log=pg_fetch_array($result_log);
	
		if (pg_num_rows($result_log)>=1){
	
		$query_usuario="select login, grupo_id from usuario where usuario_id='".$row_log[usuario_id]."'";
		$result_usuario=pg_query($query_usuario) or die ("Erro na query: $query_usuario".pg_last_error($connect));
		$row_usuario=pg_fetch_array($result_usuario);
		
		return $row_usuario[login]."-".nome_grupo($row_usuario[grupo_id]);
		} else {
		header("location: ./index.php?erro=1");	
		}
	
	}else{
	header("location: ./index.php?erro=1");
	}
}

function nome_grupo($grupo_id){
		$query_grupo="select nome from grupo where grupo_id='".$grupo_id."'";
		$result_grupo=pg_query($query_grupo) or die ("Erro na query: $query_grupo".pg_last_error($connect));
		$row_grupo=pg_fetch_array($result_grupo);
		
		return $row_grupo[nome];
	
}*/

?>
