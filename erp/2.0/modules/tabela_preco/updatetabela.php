<?php

include("../../common/database/conn.php");


	
	
	if($_POST['nome'] && $_POST['valor1'] && $_POST['valor2'] && $_POST['valor3'] && $_GET['editmat']){
		
		$id_material = $_GET['editmat'];
		
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
		
		
		
		
		
		$updateumsql = "UPDATE material_tabela SET nome = '$nome' WHERE id_material = $id_material";

		$updateum = pg_query($updateumsql);
		
		$updatedoissql = "UPDATE tipo_material_tabela SET valor = $valorum WHERE id_material = $id_material AND nome = 'Fosco'";

		$updatedois = pg_query($updatedoissql);

		$updatetressql = "UPDATE tipo_material_tabela SET valor = $valordois WHERE id_material = $id_material AND nome = 'Brilhante'";

		$updatetres = pg_query($updatetressql);

		$updatequatrosql = "UPDATE tipo_material_tabela SET valor = $valortres WHERE id_material = $id_material AND nome = 'Fosforescente'";
		
		$updatequatro = pg_query($updatequatrosql);
		
		
		
						
						
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