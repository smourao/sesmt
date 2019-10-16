<?php

include("../../common/database/conn.php");


	
	
	if($_POST['nome'] && $_POST['valor1'] && $_POST['valor2'] && $_POST['valor3'] ){
		
		$nome = $_POST[nome];
		
		$valorum = $_POST[valor1];
		$valorum = str_replace("." , "" , $valorum);
		$valorum = implode(".", explode(",", $valorum));
		
		$valordois = $_POST[valor2];
		$valordois = str_replace("." , "" , $valordois);
		$valordois = implode(".", explode(",", $valordois));
		
		$valortres = $_POST[valor3];
		$valortres = str_replace("." , "" , $valortres);
		$valortres = implode(".", explode(",", $valortres));
		
		if(!empty($_POST[porcen])){
			$porcen = $_POST[porcen];
			$porcen = $porcen/100;
			
			$valorumsobra = $valorum * $porcen;
			$valorum = $valorum + $valorumsobra;
			
			$valordoissobra = $valordois * $porcen;
			$valordois = $valordois + $valordoissobra;
			
			$valortressobra = $valortres * $porcen;
			$valortres = $valortres + $valortressobra;
			
		}
		
		
		
		
		$insertumsql = "INSERT INTO material_tabela (nome)
VALUES ('$nome')";

		$insertum = pg_query($insertumsql);

		$selectumsql = "SELECT id_material FROM material_tabela ORDER BY id_material DESC";
		$selectumquery = pg_query($selectumsql);
		$selectum = pg_fetch_array($selectumquery);
		
		$idmax = $selectum[id_material];
		
		$insertdoissql = "INSERT INTO tipo_material_tabela (nome,valor,id_material)
VALUES ('Fosco',$valorum,$idmax)";

		$insertdois = pg_query($insertdoissql);

		$inserttressql = "INSERT INTO tipo_material_tabela (nome,valor,id_material)
VALUES ('Brilhante',$valordois,$idmax)";

		$inserttres = pg_query($inserttressql);

		$insertquatrosql = "INSERT INTO tipo_material_tabela (nome,valor,id_material)
VALUES ('Fosforescente',$valortres,$idmax)";
		
		$insertquatro = pg_query($insertquatrosql);
		
		
		$urlwww = $_SERVER['SERVER_NAME'];
						
			if($urlwww == 'www.sesmt-rio.com'){
						
						
		echo("<script type='text/javascript'> location.href = 'http://www.sesmt-rio.com/erp/2.0/index.php?dir=tabela_preco&p=index&lista=true';</script>");
				
			}else{
				echo("<script type='text/javascript'> location.href = 'http://sesmt-rio.com/erp/2.0/index.php?dir=tabela_preco&p=index&lista=true';</script>");
			}
		
	}else{

	echo("<script type='text/javascript'> alert('Erro ao inserir os dados !!!'
				); window.history.go(-2);</script>");
	}
?>