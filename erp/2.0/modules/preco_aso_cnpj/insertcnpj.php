<?php

include("../../common/database/conn.php");


	
	
	if($_POST['cnpj'] && $_POST['preco'] ){
		
		
		
		
		$cnpj = $_POST['cnpj'];
		$preco = $_POST['preco'];
		
		
		$versetem_sql = "SELECT id, cnpj_cliente FROM preco_aso_cnpj WHERE cnpj_cliente = '{$cnpj}' ";
		$versetem_query = pg_query($versetem_sql);
		$versetemarray = pg_fetch_array($versetem_query);
		$versetem = pg_num_rows($versetem_query);
		
		$maxi_sql = "SELECT max(id) as maxi FROM preco_aso_cnpj";
		$maxi_query = pg_query($maxi_sql);
		$maxi = pg_fetch_array($maxi_query);
		
		$max = $maxi[maxi] + 1;
		
		if($versetem >= 1){
			
			$max = $versetemarray[id];
			
			$deletarsql = "DELETE FROM preco_aso_cnpj WHERE cnpj_cliente='{$cnpj}'";
			$deletar = pg_query($deletarsql);
			
		}
		
		
		$price = str_replace('.', '', $preco);
        $price = str_replace(',', '.', $price);
		
		
		$pacnpjinsertsql = "INSERT INTO preco_aso_cnpj (id,cnpj_cliente,preco_aso,status)
						VALUES ($max,'$cnpj','$price',0)";
						
		$pacnpjinsert = pg_query($pacnpjinsertsql);
							
							
		
						
						
		echo("<script type='text/javascript'> alert('Dado inserido com sucesso !!!'
				); window.history.go(-1);</script>");
		
		
	}else{

	echo("<script type='text/javascript'> alert('Erro ao inserir os dados !!!'
				); window.history.go(-1);</script>");
	}
?>