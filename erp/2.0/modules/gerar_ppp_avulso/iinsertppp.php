<?php

include("../../common/database/conn.php");


	
	
	if($_POST['nome_func'] && $_POST['razao_social'] ){
		
		$pegarprodutosql = "SELECT preco_prod FROM produto WHERE cod_prod = 70523";
		$pegarprodutoquery = pg_query($pegarprodutosql);
		$pegarproduto = pg_fetch_array($pegarprodutoquery);
		$valorppp = $pegarproduto[preco_prod];
		$historicoppp = 'Pagamento ppp avulso';
		
		
		$razao_social = $_POST['razao_social'];
		$nome_func = $_POST['nome_func'];
		$data_lancamento = date('Y-m-d');
		$dia = idate('j');
		$mes = idate('n');
		$semana = idate('W');
		$ano = idate('Y');
		
		
		$receita1sql = "INSERT INTO financeiro_info (titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes ,ano, data_lancamento, data_entrada_saida, tipo_lancamento, historico, funcionario_id, pc) VALUES ('$razao_social', $valorppp, 1, 'Dinheiro', 0, '$data_lancamento', '$dia', '$mes', '$ano', '$data_lancamento', '$data_lancamento', 24, '$descricao_ppp', 0, 0)";
		
		$receita1 = pg_query($receita1sql);
		
		
		//Pegando o id da tabela financeiro_info
	
	$cod_faturasql = "SELECT id FROM financeiro_info WHERE titulo = '$razao_social' ORDER BY id DESC ";
	$cod_faturaquery = pg_query($cod_faturasql);
	$cod_faturaall = pg_fetch_array($cod_faturaquery);
	
	$cod_fatura = $cod_faturaall[id];
	
	
		//Inserindo na Tabela financeiro_fatura
	
	$receita2sql = "INSERT INTO financeiro_fatura (cod_fatura, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento, numero_doc, numero_cheque) VALUES ($cod_fatura, '$razao_social', $valorppp, 1, '$data_lancamento', 0, 1, '$data_lancamento', '', '')";
		
		$receita2 = pg_query($receita2sql);
		
		
		
		$pppinsertsql = "INSERT INTO ppp_avulso (razao_social,nome_func,data_lancamento)
						VALUES ('$razao_social','$nome_func','$data_lancamento')";
						
		$pppinsert = pg_query($pppinsertsql);
							
							
		$pppinsert2sql = "INSERT INTO financeiro_relatorio 
						(cod_fatura, titulo, valor, status, pago, historico, data_lancamento, semana, ano)
						VALUES ($cod_fatura, '$razao_social', $valorppp, 0, 1, '$historicoppp', '$data_lancamento', $semana, $ano)";
						
		$pppinsert2 = pg_query($pppinsert2sql);
						
						
		echo("<script type='text/javascript'> alert('Dado inserido com sucesso !!!'
				); window.history.go(-2);</script>");
		
		
	}else{

	echo("<script type='text/javascript'> alert('Erro ao inserir os dados !!!'
				); window.history.go(-2);</script>");
	}
?>