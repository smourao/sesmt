<?php

include("../../common/database/conn.php");


	
	
	if($_POST['nome_func'] && $_POST['razao_social'] ){
		
		
		
		
		$razao_social = $_POST['razao_social'];
		$nome_func = $_POST['nome_func'];
		$data_lancamento = date('Y-m-d');
		
		
		
		
		$numpppsql = "SELECT MAX(id_ppp) as id_ppp FROM ppp_avulso";
            $numpppmax = pg_fetch_array(pg_query($numpppsql));
            $numpppmax = $numpppmax[id_ppp] + 1;
		
		
	
	
		
		
		
		$pppinsertsql = "INSERT INTO ppp_avulso (razao_social,nome_func,data_lancamento,id_ppp)
						VALUES ('$razao_social','$nome_func','$data_lancamento','$numpppmax')";
						
		$pppinsert = pg_query($pppinsertsql);
							
							
		
						
						
		echo("<script type='text/javascript'> alert('Dado inserido com sucesso !!!'
				); window.history.go(-2);</script>");
		
		
	}else{

	echo("<script type='text/javascript'> alert('Erro ao inserir os dados !!!'
				); window.history.go(-2);</script>");
	}
?>