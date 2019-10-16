<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>

<?PHP

/***************************************************************************************************/


/***************************************************************************************************/

if($_GET[ppplist]){
	
	$pppavulsosql = "SELECT * FROM ppp_avulso";
	
	$pppavulsoquery = pg_query($pppavulsosql);
	
	$pppavulso = pg_fetch_all($pppavulsoquery);
	
	$pppavulsonum = pg_num_rows($pppavulsoquery);
	
	
	if($_GET['razao'] != '' && $_GET['func'] != ''){
		
		$pegarprodutosql = "SELECT preco_prod FROM produto WHERE cod_prod = 70523";
		$pegarprodutoquery = pg_query($pegarprodutosql);
		$pegarproduto = pg_fetch_array($pegarprodutoquery);
		$valorppp = $pegarproduto[preco_prod];
		$descricao_ppp = 'Pagamento ppp avulso';
		
		
		$razao_social = $_GET['razao'];
		$nome_func = $_GET['func'];
		$data_lancamento = date('Y-m-d');
		$dia = idate('j');
		$mes = idate('n');
		$semana = idate('W');
		$ano = idate('Y');
		
		
		$receita1sql = "INSERT INTO financeiro_info (titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes ,ano, data_lancamento, data_entrada_saida, tipo_lancamento, historico, funcionario_id, pc) VALUES ('$razao_social', $valorppp, 1, 'Dinheiro', 0, '$data_lancamento', '$dia', '$mes', '$ano', '$data_lancamento', '$data_lancamento', 24, '$descricao_ppp', 0, 0)";
		
		
		//Pegando o id da tabela financeiro_info
	
	$cod_faturasql = "SELECT id FROM financeiro_info WHERE titulo = '$razao_social_cliente' ORDER BY id DESC ";
	$cod_faturaquery = pg_query($cod_faturasql);
	$cod_faturaall = pg_fetch_array($cod_faturaquery);
	
	$cod_fatura = $cod_faturaall[id];
	
	
		//Inserindo na Tabela financeiro_fatura
	
	$receita2sql = "INSERT INTO financeiro_fatura (cod_fatura, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento, numero_doc, numero_cheque) VALUES ($cod_fatura, '$razao_social', $valorppp, 1, '$data_lancamento', 0, 1, '$data_lancamento', '', '')";
		
		
		
		$pppinsertsql = "INSERT INTO ppp_avulso (razao_social,nome_func,data_lancamento)
						VALUES ('$razao_social','$nome_func','$data_lancamento')";
							
							
		$pppinsertsql = "INSERT INTO financeiro_relatorio 
						(cod_fatura, titulo, valor, status, pago, historico, data_lancamento, semana, ano)
						VALUES ($cod_fatura, '$razao_social', $valorppp, 0, 1, '$historicoppp', '$data_lancamento', $semana, $ano)";
		
		
	}

	
	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Cadastro PPP Avulso</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";

    if($_GET[ppplist]){
		
		
		
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=40% align=center class='text'>";

				echo "<b>Razão Social</b>";

				echo "</td>";

                echo "<td width=40% align=center class='text'>";

                echo "<b>Nome do Funcionário</b>";

                echo "</td>";

                echo "<td width=20% align=center class='text'>";

                echo "<b>Enviar</b>";

                echo "</td>";

            echo "</tr>";
			
			echo "<tr>";
			
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='text' name='razao_social'>";

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='text' name='nome_func'>";

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'>";
?>




                    <input type='submit' class='btn' name='enviar' onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&ppplist=true&razao=' + document.getElementById('razao_social').value + '&func=' + document.getElementById('nome_func').value '" ?>'">
                    
                    

<?php

                echo "</td>";
			
			echo "</tr>";
			
		 echo "</table>";
		 
		 
		 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=20% align=center class='text'>";

				echo "<b>Cod</b>";

				echo "</td>";
				
				echo "<td width=20% align=center class='text'>";

                echo "<b>Razão Social</b>";

                echo "</td>";

                echo "<td width=20% align=center class='text'>";

                echo "<b>Nome do Funcionário</b>";

                echo "</td>";

                echo "<td width=20% align=center class='text'>";

                echo "<b>Data de Lançamento</b>";

                echo "</td>";

            echo "</tr>";
			
			for($x=0;$x<$pppavulsonum;$x++){
			
			$br_data1 = explode('-',($pppavulso[$x][data_lancamento]));
			$br_data2 = $br_data1[2].'/'.$br_data1[1].'/'.$br_data1[0];	
				
				
			
			echo "<tr>";
		
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo $pppavulso[$x][id];

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

                    echo $pppavulso[$x]['razao_social'];

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'>";

                    echo $pppavulso[$x]['nome_func'];

                echo "</td>";
				
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo $br_data2;

                echo "</td>";
			
			echo "</tr>";
			
			}
			
		echo "</table>";

    }else{

    //caso não seja encontrado nenhum registro

       

    }

    echo "<td>";

    echo "</tr>";

    echo "</table>";

}else{



    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        echo "<b>Busca por relatórios</b>";

    echo "</td>";

    echo "</tr>";

    echo "</table>";

}

?>
</body>
</html>
