

<?PHP

/***************************************************************************************************/


/***************************************************************************************************/


if($_POST[enviar]){

	$cnae = $_POST['cnae'];

	$pegarmaxsql = "SELECT max(cod_aso) as maximo FROM aso_avulso";
	$pegarmaxquery = pg_query($pegarmaxsql);
	$pegarmax = pg_fetch_array($pegarmaxquery);
	$cod_aso = $pegarmax[maximo] +1;

	$query_cnae="SELECT grau_risco FROM cnae WHERE cnae='".$cnae."' LIMIT 1";
	$result_cnae=pg_query($query_cnae);
	$row_cnae=pg_fetch_array($result_cnae);
	$cnaenum = pg_num_rows($result_cnae);

	if($cnaenum >= 1)
	$grau_risco = $row_cnae['grau_risco'];
	else
	$grau_risco = '0';

	$razao_social = $_POST['razao_social_cliente'];
	$endereco = $_POST['endereco_cliente'];
	$cep = $_POST['cep_cliente'];
	$cnpj_cliente = $_POST['cnpj_cliente'];

	$tipo_exame = $_POST['tipo_exame'];
	$nome_func = $_POST['nome_func'];
	$num_ctps_func = $_POST['ctps'];
	$serie_ctps_func = $_POST['serie'];
	$cbo = $_POST['cbo'];
	$nome_funcao = $_POST['funcao'];
	$dinamica_funcao = $_POST['atv_lab'];
	$data = date("d")."/".date("m")."/".date("Y");
	$datafatura = date("Y-m-d");
	$dia = date("d");
	$mes = date("m");
	$ano = date("Y");
	$semana = idate('W');
	$anointeiro = idate('Y');


	$tipo_aso = $_POST['tipo_aso'];


	if($tipo_aso == 2){
		$descricao_aso = 'Pagamento aso retroativo do mesmo ano';
		$preco_aso = 50.00;
		$preco_aso2 = 50;


	}
	else if($tipo_aso == 3){
		$descricao_aso = 'Pagamento aso retroativo de 1 ano';
		$preco_aso = 120.00;
		$preco_aso2 = 120;

	}
	else if($tipo_aso == 4){
		$descricao_aso = 'Pagamento aso retroativo de 2 ano';
		$preco_aso = 150.00;
		$preco_aso2 = 150;

	}
	else if($tipo_aso == 5){
		$descricao_aso = 'Pagamento aso retroativo de 3 ano';
		$preco_aso = 190.00;
		$preco_aso2 = 190;

	}
	else if($tipo_aso == 6){
		$descricao_aso = 'Pagamento aso retroativo de 4 ano';
		$preco_aso = 260.00;
		$preco_aso2 = 260;

	}
	else if($tipo_aso == 7){
		$descricao_aso = 'Pagamento aso retroativo de 5 ano';
		$preco_aso = 300.00;
		$preco_aso2 = 300;

	}
	else{
		$descricao_aso = 'Pagamento aso avulso';
		$preco_aso = 35.00;
		$preco_aso2 = 35;


		$precoespecifico_sql = "SELECT preco_aso FROM preco_aso_cnpj WHERE cnpj_cliente = '{$cnpj_cliente}' AND status = 0";
		$precoespecifico_query = pg_query($precoespecifico_sql);
		$precoespecifico = pg_fetch_array($precoespecifico_query);
		$precoespecificonum = pg_num_rows($precoespecifico_query);

		if($precoespecificonum >= 1){

			$preco_aso = $precoespecifico[preco_aso];
			$preco_aso2 = $precoespecifico[preco_aso];

		}


	}



	$insertindosql = "INSERT INTO aso_avulso (cod_aso, razao_social_cliente, endereco_cliente, cep_cliente, cnpj_cliente, cnae, grau_risco, tipo_exame, nome_func, num_ctps_func, serie_ctps_func, cbo, nome_funcao, dinamica_funcao, data)
VALUES ($cod_aso,'$razao_social','$endereco','$cep','$cnpj_cliente','$cnae',$grau_risco,'$tipo_exame','$nome_func','$num_ctps_func','$serie_ctps_func','$cbo','$nome_funcao','$dinamica_funcao','$data')";

	if(pg_query($insertindosql)){



		$query_fatura_max = "SELECT max(id) as cod_fatura FROM financeiro_info";
		$result_fatura_max = pg_query($query_fatura_max);
		$row_fatura_max = pg_fetch_array($result_fatura_max);

		$query_fatura2_max = "SELECT max(id) as cod_fatura FROM financeiro_fatura";
		$result_fatura2_max = pg_query($query_fatura2_max);
		$row_fatura2_max = pg_fetch_array($result_fatura2_max);

		$query_relatorio_max = "SELECT max(id) as cod_relatorio FROM financeiro_relatorio";
		$result_relatorio_max = pg_query($query_relatorio_max);
		$row_relatorio_max = pg_fetch_array($result_relatorio_max);

		$cod_fatura = $row_fatura_max[cod_fatura] + 1;
		$cod_fatura2 = $row_fatura2_max[cod_fatura] + 1;
		$cod_relatorio = $row_relatorio_max[cod_relatorio] + 1;






		//Inserindo na Tabela financeiro_info

	$receita1sql = "INSERT INTO financeiro_info (titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes ,ano, data_lancamento, data_entrada_saida, tipo_lancamento, historico, funcionario_id, pc) VALUES ('$razao_social', $preco_aso, 1, 'Dinheiro', 0, '$datafatura', '$dia', '$mes', '$ano', '$datafatura', '$datafatura', 24, '$descricao_aso', 0, 0)";

	$receita1query = pg_query($receita1sql);



	//Inserindo na Tabela financeiro_fatura

	$receita2sql = "INSERT INTO financeiro_fatura (cod_fatura, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento, numero_doc, numero_cheque) VALUES ($cod_fatura, '$razao_social', $preco_aso2, 1, '$datafatura', 0, 1, '$datafatura', '', '')";

	$receita2query = pg_query($receita2sql);



	//Inserindo na Tabela financeiro_relatorio

	$relatoriosql = "INSERT INTO financeiro_relatorio (cod_fatura, titulo, valor, status, pago, historico, data_lancamento, semana, ano) VALUES ($cod_fatura, '$razao_social', $preco_aso, 0, 1, '$descricao_aso', '$datafatura', $semana, $anointeiro)";

	$fatura_relatorio = pg_query($relatoriosql);



















		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
		$maill = "suporte@ti-seg.com";

		$msgg = "
<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE>Comunicado sobre o vencimento da Fatura</TITLE>
            <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
            <META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
            <style type=\"text/css\">
            td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
            .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
            .style13 {font-size: 14px}
            .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
            .style16 {font-size: 9px}
            .style17 {font-family: Arial, Helvetica, sans-serif}
            .style18 {font-size: 12px}
            </style>
               </HEAD>
               <BODY>
			   
			   
			   <table width=100% border=0>
        <tr>
        <td align='left'>
            <p><strong>
            <font size='7' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=3>�</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
			 <td width=40% align='right'>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='4'>
            <b>&nbsp;</b>
            </td>
       
        </tr>
        </table>
		<br>
		<br>
		<br>
		<br>
		<br>";

		$msgg .= "Foi feito um ASO avulso, os dados abaixo:<br>";
		$msgg .= "Nome: ".$nome_func."<br>";
		$msgg .= "Empresa: ".$razao_social."<br>";
		$msgg .= "CNPJ: ".$cnpj_cliente."<br>";
		$msgg .= "CNAE: ".$cnae."<br>";
		$msgg .= "Grau de Risco: ".$grau_risco."<br>";
		$msgg .= "Endereço: ".$endereco."<br>";
		$msgg .= "Tipo exame: ".$tipo_exame."<br>";
		$msgg .= "Data: ".$data."<br>";

		$msgg .= "
		<br>
		<br>
		<br>
		<br>
		<br>


		<table width=100% border=0>
        <tr>
        <td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / medicotrab@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
       </tr>
        </table>





               </body></html>";


		mail($maill, "Aso Avulso", $msgg, $headers);

		echo "<script>alert('Código do ASO: ".$cod_aso."');</script>";
		echo "<script>window.location.href = '?dir=triagem_medica&p=index';</script>";

	}else{

		echo "<script>alert('Erro: Falar com Suporte');</script>";
		echo "<script>window.location.href = '?dir=triagem_medica&p=index';</script>";

	}

}








echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

	echo "<tr>";

    	echo "<td align=center class='text roundborderselected'>";

        	echo "<b>Cadastro da Triagem</b> ";

		echo "</td>";

    echo "</tr>";

echo "</table>";

    

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

	echo "<tr>";

    	echo "<td align=left class='text'>";
						
		
		?>
				<form action="" id="frm" method="post">
		<?php
		
			
		
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=50% align=center class='text'>";
	
					echo "<b>Razão Social</b>";
	
					echo "</td>";
	
					echo "<td width=50% align=center class='text'>";
	
					echo "<b>Endereço</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
	
						<input type='text' name='razao_social_cliente' id='razao_social_cliente' size='40' onkeyup="maiuscula('razao_social_cliente')" required>
                        
                    <?php
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
					
						<input type='text' name='endereco_cliente' id='endereco_cliente' size='40' onkeyup="maiuscula('endereco_cliente')" required>
						
					 <?php
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			 
				echo "<tr>";
	
					echo "<td width=45% align=center class='text'>";
	
						echo "<b>CEP</b>";
	
					echo "</td>";
	
					echo "<td width=55% align=center class='text'>";
	
						echo "<b>CNPJ</b>";
	
					echo "</td>";
	
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
					   echo "<input type='text' name='cep_cliente' id='cep_cliente' size='8' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" required>";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='text' size=20 name='cnpj_cliente' id='cnpj_cliente' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\">";
	
					echo "</td>";
					
				echo "</tr>";
				
			echo "</table>";
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=20% align=center class='text'>";
	
					echo "<b>CNAE</b>";
	
					echo "</td>";
					
					echo "<td width=40% align=center class='text'>";
	
					echo "<b>Tipo de Exame</b>";
	
					echo "</td>";
	
					echo "<td width=40% align=center class='text'>";
	
					echo "<b>Tipo do ASO</b>";
	
					echo "</td>";
					
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='text' size=5 name='cnae' id='cnae' maxlength='7' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.##-#');\" onBlur=\"check_cnae(this);\" required>&nbsp;<span id='verify_cnae'></span><input type='button' value='Pesquisar' title='Click aqui para consultar com o CNPJ o número do CNAE' onClick='irReceita()'>";
	
					echo "</td>";
	
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<select name='tipo_exame' required>";
							
							echo "<option></option>";
							echo "<option value='Admissional'>Admissional</option>";
							echo "<option value='Periódico'>Periódico</option>";
							echo "<option value='Demissional'>Demissional</option>";
							echo "<option value='Retorno ao Trabalho'>Retorno ao Trabalho</option>";
							echo "<option value='Mudança de Função'>Mudança de Função</option>";
						
						echo "</select>";
	
					echo "</td>";
					
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo '<select name="tipo_aso" required>
								<option value="1">Comercial</option>
								<option value="2">Retroativo mesmo ano</option>
								<option value="3">Retroativo 1 ano</option>
								<option value="4">Retroativo 2 ano</option>
								<option value="5">Retroativo 3 ano</option>
								<option value="6">Retroativo 4 ano</option>
								<option value="7">Retroativo 5 ano</option>
							</select>';
	
					echo "</td>";
					
					
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=60% align=center class='text'>";
	
					echo "<b>Nome do Funcionário</b>";
	
					echo "</td>";
	
					echo "<td width=20% align=center class='text'>";
	
					echo "<b>CTPS</b>";
	
					echo "</td>";
					
					echo "<td width=20% align=center class='text'>";
	
					echo "<b>Série</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
					?>
	
						<input type='text' name='nome_func' id='nome_func' size='30' onkeyup="maiuscula('nome_func')" required>
                        
                    <?php 
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<input type='text' name='ctps' size='8' required>";
	
					echo "</td>";
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<input type='text' name='serie' size='5' required>";
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=20% align=center class='text'>";
	
					echo "<b>CBO</b>";
	
					echo "</td>";
	
					echo "<td width=40% align=center class='text'>";
	
					echo "<b>Função</b>";
	
					echo "</td>";
					
					echo "<td width=40% align=center class='text'>";
	
					echo "<b>Atividade Laborativa</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='text' name='cbo' size='5' required>";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
					
						<input type='text' name='funcao' id='funcao' size='20' onkeyup="maiuscula('funcao')" required>
	
					</td>
					
					<td align=center class='text roundbordermix curhand'>
					
						<input type='text' name='atv_lab' id='atv_lab' size='30' onkeyup="maiuscula('atv_lab')" required>
                        
                       <?php
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			
		echo "</td>";
					
	echo "</tr>";
			
echo "</table>";
			
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			
		echo "<tr>";
			
			echo "<td align=center class='text roundbordermix curhand'>";
			
				echo "<input type='submit' name='enviar'>";
			
			echo "</td>";
			
		echo "</tr>";
			
	echo "</table>";
			
echo "</form>";

echo "</table>";
		 

?>