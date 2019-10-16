<?PHP
session_start();
/**************************************************************************************************/
// --> IF _POST && COD_CLIENTE = 'new' THEN: DO THE [REGISTER]
/**************************************************************************************************/
if($_POST[btnSave] && $_GET[cod_cliente]=='new'){
    foreach($_POST as $k => $v){
        $_POST[$k] = addslashes($v);//echo $k." -> ".$v."<BR>";
    }
    //get the cnae_id
    $sql = "SELECT cnae_id FROM cnae WHERE cnae = '{$_POST[cnae]}'";
    $res = pg_query($sql);
    $rcn = pg_fetch_array($res);

    //get cod_cliente and contract number
    $sql = "SELECT MAX(c.cliente_id)+1 as cliente_id, MAX(substr(c.ano_contrato, 6)) as ano_contrato FROM cliente c";
    $res = pg_query($sql);
    $data = pg_fetch_array($res);
    $data[ano_contrato] = date("Y")."/".($data[ano_contrato]+1);
	
      $sql = "INSERT INTO cliente
      (razao_social, nome_fantasia, endereco, bairro, cep, municipio, estado, telefone, fax, celular, email, cnpj, insc_estadual,
	  insc_municipal, descricao_atividade, numero_funcionarios, grau_de_risco, vendedor_id, cnae_id, cliente_id, filial_id,
      tel_contato_dir, nome_contato_dir, cargo_contato_dir, email_contato_dir, skype_contato_dir, msn_contato_dir,
	  nextel_contato_dir, nextel_id_contato_dir, escritorio_contador, tel_contador, email_contador, skype_contador, nome_contador,
	  nome_cont_ind, email_cont_ind, cargo_cont_ind, tel_cont_ind, msn_contador, skype_cont_ind, status, classe, ano_contrato,
	  num_end, num_rep, membros_brigada, nextel_contador, nextel_id_contador, data, relatorio_de_atendimento, crc_contador, cnpj_contratante,
	  contratante, nextel_cont_ind, nextel_id_cont_ind)
      VALUES
      ('{$_POST[razao_social]}','{$_POST[nome_fantasia]}','{$_POST[endereco]}','{$_POST[bairro]}','{$_POST[cep]}','{$_POST[municipio]}',
	  '{$_POST[estado]}','{$_POST[telefone]}','{$_POST[fax]}','{$_POST[celular]}','{$_POST[email]}','{$_POST[cnpj]}',
	  '{$_POST[insc_estadual]}','{$_POST[insc_municipal]}','{$_POST[descricao_atividade]}','{$_POST[numero_funcionarios]}',
      '{$_POST[grau_risco]}','{$_POST[vendedor]}','{$rcn[cnae_id]}','{$data[cliente_id]}','1','{$_POST[tel_contato_dir]}',
	  '{$_POST[nome_contato_dir]}','{$_POST[cargo_contato_dir]}','{$_POST[email_contato_dir]}','{$_POST[skype_contato_dir]}',
	  '{$_POST[msn_cont_dir]}','{$_POST[nextel_cont_dir]}', '{$_POST[nextel_id_contato_dir]}','{$_POST[escritorio_contador]}',
      '{$_POST[tel_contador]}','{$_POST[email_contador]}','{$_POST[skype_contador]}','{$_POST[nome_contador]}','{$_POST[nome_cont_ind]}',
	  '{$_POST[email_cont_ind]}','{$_POST[cargo_cont_ind]}','{$_POST[tel_cont_ind]}','{$_POST[msn_contador]}','{$_POST[skype_cont_ind]}',
	  'comercial','{$_POST[classe]}','{$data[ano_contrato]}','{$_POST[num_end]}','{$_POST[membros_cipa]}','{$_POST[membros_brigada]}',
      '{$_POST[nextel_contador]}','{$_POST[nextel_id_contador]}','{$dat}','{$_POST[relatorio]}','{$_POST[crc_contador]}','{$_POST[cnpj_contratante]}','1', '{$_POST[nextel_cont_ind]}', '{$_POST[nextel_id_cont_ind]}')";
	  $regresult = @pg_query($sql);
	  
	  //INSERIR OR�AMENTO
	  	$sql = "SELECT MAX(cod_orcamento) + 1 as cod_orcamento FROM site_orc_info";
		$r = pg_query($sql);
		$max = pg_fetch_array($r);
		
		//INSERE O ORCAMENTO NA TABELA DO SITE
            $sql = "INSERT INTO site_orc_info
            (cod_orcamento, cod_cliente, cod_filial, num_itens, data_criacao, data_aprovacao, aprovado, orc_request_time, orc_request_time_sended,
			vendedor_id)
            VALUES
            ({$max[cod_orcamento]}, {$data[cliente_id]}, 1, '0', '".date("Y/m/d")."', '".date("Y/m/d")."', '0', '".date("h:i:s")."', '1',
            '{$_POST[vendedor]}')";
            $result_in = pg_query($sql);
			
			//Aqui faz o update da quantidade de funcion�rios.
			/*if( $numero_funcionarios <= 10 ){
				$qtd = $numero_funcionarios;
				$sql_prod = 891;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = $numero_funcionarios;
				$sql_prod = 893;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = $numero_funcionarios;
				$sql_prod = 895;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = $numero_funcionarios;
				$sql_prod = 928;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = $numero_funcionarios;
				$sql_prod = 929;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = $numero_funcionarios;
				$sql_prod = 930;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = $numero_funcionarios;
				$sql_prod = 931;
			}elseif( $numero_funcionarios > 350){
				$qtd = $numero_funcionarios;
				$sql_prod = 932;
			}*/
			
			//--> ASO COM VALOR UNICO INDEPEDENDO DO NUMERO DOS FUNCIONARIOS
			
			$qtd = $numero_funcionarios;
			$cod_prod = 70481;

				//seleciona ASO da tebela produto.
				$query_orcamento = "select cod_prod, preco_prod from produto where cod_prod = " .$sql_prod;
				$result_orcamento = pg_query($query_orcamento);

				//insere na tabela orcamento_produto.
				while($row_orcamento = pg_fetch_array($result_orcamento)) {
				$query_orc = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ('$max[cod_orcamento]', $data[cliente_id], 1, $row_orcamento[cod_prod], $qtd, 0, '', $row_orcamento[preco_prod] )";
				$result_orc = pg_query($query_orc);
				}
				
			//Aqui faz o update da quantidade de funcion�rios.
			if( $numero_funcionarios <= 10 ){
				$qtd = 1;
				$sql_ppra = 423;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = 1;
				$sql_ppra = 966;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = 1;
				$sql_ppra = 967;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = 1;
				$sql_ppra = 968;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = 1;
				$sql_ppra = 969;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = 1;
				$sql_ppra = 970;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = 1;
				$sql_ppra = 971;
			}elseif( $numero_funcionarios >= 351 and $numero_funcionarios <= 450){
				$qtd = 1;
				$sql_ppra = 990;
			}elseif( $numero_funcionarios >= 451 and $numero_funcionarios <= 500){
				$qtd = 1;
				$sql_ppra = 991;
			}elseif( $numero_funcionarios >= 501 and $numero_funcionarios <= 600){
				$qtd = 1;
				$sql_ppra = 992;
			}elseif( $numero_funcionarios >= 601 and $numero_funcionarios <= 700){
				$qtd = 1;
				$sql_ppra = 993;
			}elseif( $numero_funcionarios >= 701 and $numero_funcionarios <= 800){
				$qtd = 1;
				$sql_ppra = 994;
			}elseif( $numero_funcionarios >= 801 and $numero_funcionarios <= 900){
				$qtd = 1;
				$sql_ppra = 995;
			}elseif( $numero_funcionarios > 900){
				$qtd = 1;
				$sql_ppra = 996;
			}
				//seleciona PPRA da tebela produto.
				$query_orcamento2 = "select cod_prod, preco_prod from produto where cod_prod = " .$sql_ppra;
				$result_orcamento2 = pg_query($query_orcamento2);

				//insere na tabela orcamento_produto.
				while($row_orcamento2 = pg_fetch_array($result_orcamento2)) {
				$query_orc2 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento2[cod_prod], $qtd, 0, '', $row_orcamento2[preco_prod] )";
				$result_orc2 = pg_query($query_orc2);
				}
				
			//Aqui faz o update da quantidade de funcion�rios.
			if( $numero_funcionarios <= 10 ){
				$qtd = $numero_funcionarios;
				$qtd_prod = 933;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = $numero_funcionarios;
				$qtd_prod = 934;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = $numero_funcionarios;
				$qtd_prod = 935;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = $numero_funcionarios;
				$qtd_prod = 936;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = $numero_funcionarios;
				$qtd_prod = 937;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = $numero_funcionarios;
				$qtd_prod = 938;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = $numero_funcionarios;
				$qtd_prod = 939;
			}elseif( $numero_funcionarios > 350){
				$qtd = $numero_funcionarios;
				$qtd_prod = 940;
			}

				//seleciona PPP da tebela produto.
				$query_orcamento3 = "select cod_prod, preco_prod from produto where cod_prod = " .$qtd_prod;
				$result_orcamento3 = pg_query($query_orcamento3);

				//insere na tabela orcamento_produto.
				while($row_orcamento3 = pg_fetch_array($result_orcamento3)) {
				$query_orc3 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento3[cod_prod], $qtd, 0, '', $row_orcamento3[preco_prod] )";
				$result_orc3 = pg_query($query_orc3);
				}
				
			//Aqui faz o update da quantidade de funcion�rios.
			if( $numero_funcionarios <= 10 ){
				$qtd = 1;
				$qtd_pcmso = 424;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = 1;
				$qtd_pcmso = 952;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = 1;
				$qtd_pcmso = 953;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = 1;
				$qtd_pcmso = 954;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = 1;
				$qtd_pcmso = 955;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = 1;
				$qtd_pcmso = 956;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = 1;
				$qtd_pcmso = 957;
			}elseif( $numero_funcionarios >= 351 and $numero_funcionarios <= 450){
				$qtd = 1;
				$qtd_pcmso = 958;
			}elseif( $numero_funcionarios >= 451 and $numero_funcionarios <= 500){
				$qtd = 1;
				$qtd_pcmso = 997;
			}elseif( $numero_funcionarios >= 501 and $numero_funcionarios <= 600){
				$qtd = 1;
				$qtd_pcmso = 998;
			}elseif( $numero_funcionarios >= 601 and $numero_funcionarios <= 700){
				$qtd = 1;
				$qtd_pcmso = 999;
			}elseif( $numero_funcionarios >= 701 and $numero_funcionarios <= 800){
				$qtd = 1;
				$qtd_pcmso = 1000;
			}elseif( $numero_funcionarios >= 801 and $numero_funcionarios <= 900){
				$qtd = 1;
				$qtd_pcmso = 1001;
			}elseif( $numero_funcionarios > 900){
				$qtd = 1;
				$qtd_pcmso = 1002;
			}

				//seleciona PCMSO da tebela produto.
				$query_orcamento4 = "select cod_prod, preco_prod from produto where cod_prod = " .$qtd_pcmso;
				$result_orcamento4 = pg_query($query_orcamento4);

				//insere na tabela orcamento_produto.
				while($row_orcamento4 = pg_fetch_array($result_orcamento4)) {
				$query_orc4 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento4[cod_prod], $qtd, 0, '', $row_orcamento4[preco_prod] )";
				$result_orc4 = pg_query($query_orc4);
				}
				
				//Aqui faz o update da quantidade de funcion�rios.
			if( $numero_funcionarios <= 10 ){
				$qtd = 1;
				$qtd_apgre = 972;
			}elseif( $numero_funcionarios >= 11 and $numero_funcionarios <= 20){
				$qtd = 1;
				$qtd_apgre = 973;
			}elseif( $numero_funcionarios >= 21 and $numero_funcionarios <= 50){
				$qtd = 1;
				$qtd_apgre = 974;
			}elseif( $numero_funcionarios >= 51 and $numero_funcionarios <= 100){
				$qtd = 1;
				$qtd_apgre = 975;
			}elseif( $numero_funcionarios >= 101 and $numero_funcionarios <= 150){
				$qtd = 1;
				$qtd_apgre = 976;
			}elseif( $numero_funcionarios >= 151 and $numero_funcionarios <= 250){
				$qtd = 1;
				$qtd_apgre = 977;
			}elseif( $numero_funcionarios >= 251 and $numero_funcionarios <= 350){
				$qtd = 1;
				$qtd_apgre = 978;
			}elseif( $numero_funcionarios >= 351 and $numero_funcionarios <= 450){
				$qtd = 1;
				$qtd_apgre = 979;
			}elseif( $numero_funcionarios >= 451 and $numero_funcionarios <= 500){
				$qtd = 1;
				$qtd_apgre = 1003;
			}elseif( $numero_funcionarios >= 501 and $numero_funcionarios <= 600){
				$qtd = 1;
				$qtd_apgre = 1004;
			}elseif( $numero_funcionarios >= 601 and $numero_funcionarios <= 700){
				$qtd = 1;
				$qtd_apgre = 1005;
			}elseif( $numero_funcionarios >= 701 and $numero_funcionarios <= 800){
				$qtd = 1;
				$qtd_apgre = 1006;
			}elseif( $numero_funcionarios >= 801 and $numero_funcionarios <= 900){
				$qtd = 1;
				$qtd_apgre = 1007;
			}elseif( $numero_funcionarios > 900){
				$qtd = 1;
				$qtd_apgre = 1008;
			}

				//seleciona APGRE da tebela produto.
				$query_orcamento5 = "select cod_prod, preco_prod from produto where cod_prod = " .$qtd_apgre;
				$result_orcamento5 = pg_query($query_orcamento5);

				//insere na tabela orcamento_produto.
				while($row_orcamento5 = pg_fetch_array($result_orcamento5)) {
				$query_orc5 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento5[cod_prod], $qtd, 0, '', $row_orcamento5[preco_prod] )";
				$result_orc5 = pg_query($query_orc5);
				}
				
			//Condi��o para inserir curso de EPI
			if($numero_funcionarios != ""){
			$query_orcamento6 = "select cod_prod, preco_prod from produto where cod_prod = 431 ";
			$result_orcamento6 = pg_query($query_orcamento6);
			}
				while($row_orcamento6 = pg_fetch_array($result_orcamento6)){
				$query_orc6 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento6[cod_prod], $qtd, 0, '', $row_orcamento6[preco_prod] )";
				$result_orc6 = pg_query($query_orc6);
				}
				
			//AQUI FAZ O UPDATE NO GRAU DE RISCO
			if($grau_risco == 3){
				if($numero_funcionarios <= 10 ){
				$qtd_ltcat = 1;
				$ltcat = 440;
				}elseif($numero_funcionarios >= 11 && $numero_funcionarios <= 20 ){
				$qtd_ltcat = 1;
				$ltcat = 441;
				}elseif($numero_funcionarios >= 21 && $numero_funcionarios <= 50 ){
				$qtd_ltcat = 1;
				$ltcat = 442;
				}elseif($numero_funcionarios >= 51 && $numero_funcionarios <= 100 ){
				$qtd_ltcat = 1;
				$ltcat = 443;
				}elseif($numero_funcionarios >= 101 && $numero_funcionarios <= 150 ){
				$qtd_ltcat = 1;
				$ltcat = 444;
				}elseif($numero_funcionarios >= 151 && $numero_funcionarios <= 250 ){
				$qtd_ltcat = 1;
				$ltcat = 445;
				}elseif($numero_funcionarios >= 251 && $numero_funcionarios <= 350 ){
				$qtd_ltcat = 1;
				$ltcat = 446;
				}elseif($numero_funcionarios >= 351 && $numero_funcionarios <= 450 ){
				$qtd_ltcat = 1;
				$ltcat = 447;
				}elseif($numero_funcionarios >= 451 && $numero_funcionarios <= 500 ){
				$qtd_ltcat = 1;
				$ltcat = 1009;
				}elseif($numero_funcionarios >= 501 && $numero_funcionarios <= 600 ){
				$qtd_ltcat = 1;
				$ltcat = 1010;
				}elseif($numero_funcionarios >= 601 && $numero_funcionarios <= 700 ){
				$qtd_ltcat = 1;
				$ltcat = 1011;
				}elseif($numero_funcionarios >= 701 && $numero_funcionarios <= 800 ){
				$qtd_ltcat = 1;
				$ltcat = 1012;
				}elseif($numero_funcionarios >= 801 && $numero_funcionarios <= 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1013;
				}elseif($numero_funcionarios > 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1014;
				}
			}elseif($grau_risco == 4){
				if($numero_funcionarios <= 10 ){
				$qtd_ltcat = 1;
				$ltcat = 448;
				}elseif($numero_funcionarios >= 11 && $numero_funcionarios <= 20 ){
				$qtd_ltcat = 1;
				$ltcat = 804;
				}elseif($numero_funcionarios >= 21 && $numero_funcionarios <= 50 ){
				$qtd_ltcat = 1;
				$ltcat = 805;
				}elseif($numero_funcionarios >= 51 && $numero_funcionarios <= 100 ){
				$qtd_ltcat = 1;
				$ltcat = 890;
				}elseif($numero_funcionarios >= 101 && $numero_funcionarios <= 150 ){
				$qtd_ltcat = 1;
				$ltcat = 892;
				}elseif($numero_funcionarios >= 151 && $numero_funcionarios <= 250 ){
				$qtd_ltcat = 1;
				$ltcat = 894;
				}elseif($numero_funcionarios >= 251 && $numero_funcionarios <= 350 ){
				$qtd_ltcat = 1;
				$ltcat = 896;
				}elseif($numero_funcionarios >= 351 && $numero_funcionarios <= 450 ){
				$qtd_ltcat = 1;
				$ltcat = 942;
				}elseif($numero_funcionarios >= 451 && $numero_funcionarios <= 500 ){
				$qtd_ltcat = 1;
				$ltcat = 1015;
				}elseif($numero_funcionarios >= 501 && $numero_funcionarios <= 600 ){
				$qtd_ltcat = 1;
				$ltcat = 1016;
				}elseif($numero_funcionarios >= 601 && $numero_funcionarios <= 700 ){
				$qtd_ltcat = 1;
				$ltcat = 1017;
				}elseif($numero_funcionarios >= 701 && $numero_funcionarios <= 800 ){
				$qtd_ltcat = 1;
				$ltcat = 1018;
				}elseif($numero_funcionarios >= 801 && $numero_funcionarios <= 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1019;
				}elseif($numero_funcionarios > 900 ){
				$qtd_ltcat = 1;
				$ltcat = 1020;
				}
			}

				if($grau_risco > 2){
				//seleciona LTCAT da tebela produto.
					$query_orcamento7 = "select cod_prod, preco_prod from produto where cod_prod = " .$ltcat;
					$result_orcamento7 = pg_query($query_orcamento7);
	
					//insere na tabela orcamento_produto.
					while($row_orcamento7 = pg_fetch_array($result_orcamento7)) {
					$query_orc7 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento7[cod_prod], $qtd, 0, '', $row_orcamento7[preco_prod] )";
					$result_orc7 = pg_query($query_orc7);
					}
				}
				
			//CONDI��O PARA INSERIR MAPA DE RISCO A3 E A4
			if($grau_risco <= 2){
			$query_orcamento8 = "SELECT desc_resumida_prod, preco_prod, cod_prod
							 	 FROM produto
								 WHERE cod_prod in (963, 965) ";
			$result_orcamento8 = pg_query($query_orcamento8);

				while($row_orcamento8 = pg_fetch_array($result_orcamento8)){
				if($row_orcamento8[cod_prod] == 965){
				   $qtd = 2;
				}else{
				   $qtd = 1;
				}

				$query_orc8 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento8[cod_prod], $qtd, 0, '', $row_orcamento8[preco_prod] )";
				$result_orc8 = pg_query($query_orc8);
				}
			}
			//CONDI��O PARA INSERIR MAPA DE RISCO A0 E A3
			elseif($grau_risco >= 3){
				$query_orcamento8 = "SELECT desc_resumida_prod, preco_prod, cod_prod
									FROM produto
									WHERE cod_prod in (422, 964) ";
				$result_orcamento8 = pg_query($query_orcamento8);

			while($row_orcamento8 = pg_fetch_array($result_orcamento8)){
			if($row_orcamento8[cod_prod] == 964){
				   $qtd = 2;
				}else{
				   $qtd = 1;
				}

				$query_orc8 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento8[cod_prod], $qtd, 0, '', $row_orcamento8[preco_prod] )";
				$result_orc8 = pg_query($query_orc8);
				}
			}
			
		//INSERIR MEMBROS DA CIPA
		if($membros_cipa != ""){
		$num = explode("|", $membros_cipa);
		$t = $num[0] + $num[1];

			if($t == 1){
			$query_orcamento9 = "SELECT cod_prod, desc_resumida_prod, preco_prod FROM produto WHERE cod_prod = 897 ";
			$result_orcamento9 = pg_query($query_orcamento9);

				while($row_orcamento9 = pg_fetch_array($result_orcamento9)){
					$query_orc9 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento9[cod_prod], ".$t.", 0, '', $row_orcamento9[preco_prod] )";
					$result_orc9 = pg_query($query_orc9);
				}
			}elseif($t > 1){
			$query_orcamento9 = "SELECT cod_prod, desc_resumida_prod, preco_prod FROM produto WHERE cod_prod = 840 ";
			$result_orcamento9 = pg_query($query_orcamento9);

				while($row_orcamento9 = pg_fetch_array($result_orcamento9)){
					$query_orc9 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento9[cod_prod], ".$t.", 0, '', $row_orcamento9[preco_prod] )";
					$result_orc9 = pg_query($query_orc9);
				}
			}
		}
		
		//INSERIR MEMBROS DA BRIGADA
		if($membros_brigada != "" && $membros_brigada != '0'){
		$query_orcamento10 = "SELECT cod_prod, desc_resumida_prod, preco_prod FROM produto WHERE cod_prod = 982 ";
		$result_orcamento10 = pg_query($query_orcamento10);

			while($row_orcamento10 = pg_fetch_array($result_orcamento10)){
			$query_orc10 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento10[cod_prod], $membros_brigada, 0, '', $row_orcamento10[preco_prod] )";
			$result_orc10 = pg_query($query_orc10);
			}
		}
		
		//INSERIR CURSO DE CIPA
		if($t > 1){
		$query_orcamento11 = "SELECT desc_resumida_prod, preco_prod, cod_prod FROM produto WHERE cod_prod in (980, 981) ";
		$result_orcamento11 = pg_query($query_orcamento11);

		while($row_orcamento11 = pg_fetch_array($result_orcamento11)){
			if($row_orcamento11[cod_prod] == 980){
			   $qtd = 1;
			}else{
			   if($row_orcamento11[cod_prod] == 981){
				  $qtd = 12;
				}
			}

			$query_orc11 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							  values
							  ($max[cod_orcamento], $data[cliente_id], 1, $row_orcamento11[cod_prod], $qtd, 0, '', $row_orcamento11[preco_prod] )";
			$result_orc11 = pg_query($query_orc11);
			}
		}
		
		//CONDI��O PARA INSERIR O PCMAT.
		$query_orcamento12 = "select * from cnae where cnae='{$cnae_digitado}' AND lower(descricao) like '%constru��o%' AND grau_risco > 2";
		$result_orcamento12 = pg_query($query_orcamento12);
		
		if(pg_num_rows($result_orcamento12) > 0){
			$query_orc12 = "select * from produto where desc_resumida_prod like '%Pcmat%'
							and $numero_funcionarios between g_min and g_max";
			$result_orc12 = pg_query($connect, $query_orc12);
			$ro2 = pg_fetch_array($result_orc12);


				$q_orc12 = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
							values
							($max[cod_orcamento], $data[cliente_id], 1, $ro2[cod_prod], 1, 0, '', $ro2[preco_prod])";
				$res_orc12 = pg_query($q_orc12);
		}

	  
	  if($result_orc and $result_orc2 and $result_orc3 and $result_orc4 and $result_orc5 and $result_orc6 and $result_orc7 and $result_orc8 and $result_orc9 and $result_orc10 and $result_orc11){
		  makelog($_SESSION[usuario_id], 'Novo cadastro de cliente, '.$data[cliente_id].' - '.$_POST[razao_social], 201);
	  }else{
		  foreach($_POST as $k => $v){
			  $buffer[$k] = addslashes($v);//echo $k." -> ".$v."<BR>";
		  }
		  makelog($_SESSION[usuario_id], 'Erro ao cadastrar cliente, '.$data[cliente_id].' - '.$_POST[razao_social], 202);
		  showMessage('<p align=justify>N�o foi poss�vel realizar este cadastro. Por favor, verifique se todos os campos obrigat�rios foram preenchidos corretamente.<BR>Em caso de d�vidas, entre em contato com o setor de suporte!</p>', 1);
	  }
}

/**************************************************************************************************/
// --> IF _POST && COD_CLIENTE IS NUMERIC THEN: DO THE [UPDATE]
/**************************************************************************************************/
if($_POST[btnSave] && is_numeric($_GET[cod_cliente])){
    foreach($_POST as $k => $v){
        $_POST[$k] = addslashes($v);//echo $k." -> ".$v."<BR>";
    }
    //get the cnae_id
    $sql = "SELECT cnae_id FROM cnae WHERE cnae = '{$_POST[cnae]}'";
    $res = pg_query($sql);
    $rcn = pg_fetch_array($res);
	
	
	
	
	$cod_cliente = $_GET[cod_cliente];
	$cadclientesql = "SELECT * FROM cliente WHERE cliente_id = ".$cod_cliente."";
	$cadclientequery = pg_query($cadclientesql);
	$cadcliente = pg_fetch_array($cadclientequery);
			
	
	$numfuncantes = $cadcliente[numero_funcionarios];
	
	
	
	
	
	
	

      $sql = "UPDATE cliente SET
      razao_social 			   = '{$_POST[razao_social]}',
      nome_fantasia 		   = '{$_POST[nome_fantasia]}',
      endereco 				   = '{$_POST[endereco]}',
      bairro 				   = '{$_POST[bairro]}',
      cep 					   = '{$_POST[cep]}',
      municipio 			   = '{$_POST[municipio]}',
      estado 				   = '{$_POST[estado]}',
      telefone 				   = '{$_POST[telefone]}',
      fax 					   = '{$_POST[fax]}',
      celular 				   = '{$_POST[celular]}',
      email 				   = '{$_POST[email]}',
      cnpj 					   = '{$_POST[cnpj]}',
      insc_estadual 		   = '{$_POST[insc_estadual]}',
      insc_municipal 		   = '{$_POST[insc_municipal]}',
      descricao_atividade 	   = '{$_POST[descricao_atividade]}',
      numero_funcionarios 	   = '{$_POST[numero_funcionarios]}',
      grau_de_risco 		   = '{$_POST[grau_risco]}',
      cnae_id 				   = '{$rcn[cnae_id]}',
      tel_contato_dir 		   = '{$_POST[tel_contato_dir]}',
      nome_contato_dir 		   = '{$_POST[nome_contato_dir]}',
      cargo_contato_dir 	   = '{$_POST[cargo_contato_dir]}',
      email_contato_dir 	   = '{$_POST[email_contato_dir]}',
      skype_contato_dir 	   = '{$_POST[skype_contato_dir]}',
      msn_contato_dir 		   = '{$_POST[msn_cont_dir]}',
      nextel_contato_dir 	   = '{$_POST[nextel_cont_dir]}',
      nextel_id_contato_dir    = '{$_POST[nextel_id_contato_dir]}',
      escritorio_contador 	   = '{$_POST[escritorio_contador]}',
      tel_contador 			   = '{$_POST[tel_contador]}',
      email_contador 		   = '{$_POST[email_contador]}',
      skype_contador 		   = '{$_POST[skype_contador]}',
      nome_contador 		   = '{$_POST[nome_contador]}',
      nome_cont_ind 		   = '{$_POST[nome_cont_ind]}',
      email_cont_ind 		   = '{$_POST[email_cont_ind]}',
      cargo_cont_ind 		   = '{$_POST[cargo_cont_ind]}',
      tel_cont_ind 			   = '{$_POST[tel_cont_ind]}',
      msn_contador 			   = '{$_POST[msn_contador]}',
      skype_cont_ind 		   = '{$_POST[skype_cont_ind]}',
      classe 				   = '{$_POST[classe]}',
      num_end 				   = '{$_POST[num_end]}',
      num_rep 				   = '{$_POST[membros_cipa]}',
      membros_brigada 		   = '{$_POST[membros_brigada]}',
      nextel_contador 		   = '{$_POST[nextel_contador]}',
      nextel_id_contador 	   = '{$_POST[nextel_id_contador]}',
	  crc_contador 			   = '{$_POST[crc_contador]}',
	  cnpj_contratante		   = '{$_POST[cnpj_contratante]}',
	  vendedor_id          	   = '{$_POST[vendedor]}',
	  relatorio_de_atendimento = '{$_POST[relatorio]}',
	  
	  nextel_id_cont_ind       = '{$_POST[nextel_id_cont_ind]}',
	  nextel_cont_ind 		   = '{$_POST[nextel_cont_ind]}'
	  
      WHERE cliente_id 		   = {$_GET[cod_cliente]}";
	  
	  $updresult = @pg_query($sql);
	  
	   $upcomplementosql = "UPDATE reg_pessoa_juridica SET complemento = '{$_POST[complemento]}' WHERE cod_cliente = {$_GET[cod_cliente]}";
	  
	  $upcomplemento = pg_query($upcomplementosql);
	  
	  
	  
	  $numfunc = $_POST[numero_funcionarios];
	  $graurisco = $_POST[grau_risco];
	  $razao_social = $_POST['razao_social'];
	  
	  
	  $numfuncdepois = $numfunc;
	  
	  
	  
	  		$gruponumantessql = 'SELECT * FROM grupo_func WHERE g_min<='.$numfuncantes.' AND g_max>='.$numfuncantes.'';
			$gruponumantesquery = pg_query($gruponumantessql);
			$gruponumantes = pg_fetch_array($gruponumantesquery);



			$gruponumdepoissql = 'SELECT * FROM grupo_func WHERE g_min<='.$numfuncdepois.' AND g_max>='.$numfuncdepois.'';
			$gruponumdepoisquery = pg_query($gruponumdepoissql);
			$gruponumdepois = pg_fetch_array($gruponumdepoisquery);
			
			
			$orcacontratosql = "SELECT * FROM site_gerar_contrato WHERE cod_cliente = ".$cod_cliente." AND status = 1";
			$orcacontratoquery = pg_query($orcacontratosql);
			$orcacontrato = pg_fetch_array($orcacontratoquery);
			$orcacontranum = pg_num_rows($orcacontratoquery);
			
			
			
			
			if($orcacontranum >= 1){
			
			
			$versetemaltersql = "SELECT * FROM site_orc_info_alter WHERE cod_cliente = $cod_cliente";
			$versetemalterquery = pg_query($versetemaltersql);
			$versetemalternum = pg_num_rows($versetemalterquery);
			$versetemalter = pg_fetch_array($versetemalterquery);
			
			
			if($versetemalternum >= 1){
			
			$codorcalter = $versetemalter[cod_orcamento] ;
			
			$delprdalt = "DELETE FROM site_orc_produto_alter WHERE cod_cliente = $cod_cliente AND cod_orcamento = $codorcalter ";
	  		$rrprdalt = pg_query($delprdalt);
			
			
			}else{
				
				
		$pegarmaxsql = "SELECT MAX(cod_orcamento) + 1 as cod_orcamento FROM site_orc_info_alter";
        $pegarmaxquery = pg_query($pegarmaxsql);
        $pegarmax = pg_fetch_array($pegarmaxquery);
			
			$sql = "INSERT INTO site_orc_info_alter
		(cod_orcamento, cod_cliente, data_criacao)
		VALUES
		({$pegarmax[cod_orcamento]}, {$cod_cliente}, '".date("Y-m-d")."')";
        if(pg_query($sql))
            $error = 0;//echo "insert ok;<BR>";
        else
            $error = 3;//echo "Error $sql<BR>";
			
			
			$versetemaltersql = "SELECT * FROM site_orc_info_alter WHERE cod_cliente = $cod_cliente";
			$versetemalterquery = pg_query($versetemaltersql);
			$versetemalter = pg_fetch_array($versetemalterquery);
			
			$codorcalter = $versetemalter[cod_orcamento] ;
			
		}
		
			
			
			
			//--> ASO -----------------------------------------------------------
			
			
			
			
      	if($numfuncdepois <= 10 ){
        	$cod_prod = 891;
    	}elseif($numfuncdepois >= 11 && $numfuncdepois <= 20){
        	$cod_prod = 893;
    	}elseif($numfuncdepois >= 21 && $numfuncdepois <= 50){
        	$cod_prod = 895;
    	}elseif($numfuncdepois >= 51 && $numfuncdepois <= 100){
        	$cod_prod = 928;
    	}elseif($numfuncdepois >= 101 && $numfuncdepois <= 150){
        	$cod_prod = 929;
    	}elseif($numfuncdepois >= 151 && $numfuncdepois <= 250){
        	$cod_prod = 930;
    	}elseif($numfuncdepois >= 251 && $numfuncdepois <= 350){
        	$cod_prod = 931;
    	}elseif($numfuncdepois > 350){
        	$cod_prod = 932;
    	}
		
		//--> ASO COM VALOR UNICO INDEPEDENDO DO NUMERO DOS FUNCIONARIOS
		if($orcacontrato['ultima_alteracao'] >= '2015-01-01'){
		$cod_prod = 70481;
		}
		
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$codorcalter', ".$cod_cliente.", 1, $cod_prod, $numfuncdepois, 0, '', $prod[preco_prod] )";
    	if(pg_query($sql))
    	    $error = 0;
        else
            $error = 4;
			
			
			
			
			
			
			
			
			
			
			
			//--> PPRA -----------------------------------------------------------





        if($numfuncdepois <= 10 ){
        	$cod_prod = 423;
    	}elseif($numfuncdepois >= 11 and $numfuncdepois <= 20){
        	$cod_prod = 966;
    	}elseif($numfuncdepois >= 21 and $numfuncdepois <= 50){
        	$cod_prod = 967;
    	}elseif($numfuncdepois >= 51 and $numfuncdepois <= 100){
        	$cod_prod = 968;
    	}elseif($numfuncdepois >= 101 and $numfuncdepois <= 150){
        	$cod_prod = 969;
    	}elseif($numfuncdepois >= 151 and $numfuncdepois <= 250){
        	$cod_prod = 970;
    	}elseif($numfuncdepois >= 251 and $numfuncdepois <= 350){
        	$cod_prod = 971;
    	}elseif($numfuncdepois >= 351 and $numfuncdepois <= 450){
        	$cod_prod = 990;
    	}elseif($numfuncdepois >= 451 and $numfuncdepois <= 500){
        	$cod_prod = 991;
    	}elseif($numfuncdepois >= 501 and $numfuncdepois <= 600){
        	$cod_prod = 992;
    	}elseif($numfuncdepois >= 601 and $numfuncdepois <= 700){
        	$cod_prod = 993;
    	}elseif($numfuncdepois >= 701 and $numfuncdepois <= 800){
        	$cod_prod = 994;
    	}elseif($numfuncdepois >= 801 and $numfuncdepois <= 900){
        	$cod_prod = 995;
    	}elseif($numfuncdepois > 900){
        	$cod_prod = 996;
    	}
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$codorcalter', ".$cod_cliente.", 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 5;
			
			
			
			
			
			
			
			
			
			
			
			
			
			//--> PPP -----------------------------------------------------------
		
		
		
		
		
    	if($numfuncdepois <= 10 ){
        	$cod_prod = 933;
    	}elseif($numfuncdepois >= 11 and $numfuncdepois <= 20){
        	$cod_prod = 934;
    	}elseif($numfuncdepois >= 21 and $numfuncdepois <= 50){
        	$cod_prod = 935;
    	}elseif($numfuncdepois >= 51 and $numfuncdepois <= 100){
        	$cod_prod = 936;
    	}elseif($numfuncdepois >= 101 and $numfuncdepois <= 150){
        	$cod_prod = 937;
    	}elseif($numfuncdepois >= 151 and $numfuncdepois <= 250){
        	$cod_prod = 938;
    	}elseif($numfuncdepois >= 251 and $numfuncdepois <= 350){
        	$cod_prod = 939;
    	}elseif($numfuncdepois > 350){
        	$cod_prod = 940;
    	}
			if($orcacontrato['ultima_alteracao'] >= '2015-01-01'){
			$cod_prod = 70521;
			}
		
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$codorcalter', $cod_cliente, 1, $cod_prod, $numfuncdepois, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 6;
			
			
			
			
			
			
			
			
			
			//--> PCMSO -----------------------------------------------------------
        if($numfuncdepois <= 10 ){
            $cod_prod = 424;
        }elseif($numfuncdepois >= 11 and $numfuncdepois <= 20){
            $cod_prod = 952;
        }elseif($numfuncdepois >= 21 and $numfuncdepois <= 50){
            $cod_prod = 953;
        }elseif($numfuncdepois >= 51 and $numfuncdepois <= 100){
            $cod_prod = 954;
        }elseif($numfuncdepois >= 101 and $numfuncdepois <= 150){
            $cod_prod = 955;
        }elseif($numfuncdepois >= 151 and $numfuncdepois <= 250){
            $cod_prod = 956;
        }elseif($numfuncdepois >= 251 and $numfuncdepois <= 350){
            $cod_prod = 957;
        }elseif($numfuncdepois >= 351 and $numfuncdepois <= 450){
            $cod_prod = 958;
        }elseif($numfuncdepois >= 451 and $numfuncdepois <= 500){
            $cod_prod = 997;
        }elseif($numfuncdepois >= 501 and $numfuncdepois <= 600){
            $cod_prod = 998;
        }elseif($numfuncdepois >= 601 and $numfuncdepois <= 700){
            $cod_prod = 999;
        }elseif($numfuncdepois >= 701 and $numfuncdepois <= 800){
            $cod_prod = 1000;
        }elseif($numfuncdepois >= 801 and $numfuncdepois <= 900){
            $cod_prod = 1001;
        }elseif($numfuncdepois > 900){
            $cod_prod = 1002;
        }
        $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$codorcalter', $cod_cliente, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 7;
			
			
			
			
			
			
			
			
			
			//--> APGRE -----------------------------------------------------------
    	if( $numfuncdepois <= 10 ){
        	$cod_prod = 972;
    	}elseif($numfuncdepois >= 11 and $numfuncdepois <= 20){
        	$cod_prod = 973;
    	}elseif($numfuncdepois >= 21 and $numfuncdepois <= 50){
        	$cod_prod = 974;
    	}elseif($numfuncdepois >= 51 and $numfuncdepois <= 100){
        	$cod_prod = 975;
    	}elseif($numfuncdepois >= 101 and $numfuncdepois <= 150){
        	$cod_prod = 976;
    	}elseif($numfuncdepois >= 151 and $numfuncdepois <= 250){
        	$cod_prod = 977;
    	}elseif($numfuncdepois >= 251 and $numfuncdepois <= 350){
        	$cod_prod = 978;
    	}elseif($numfuncdepois >= 351 and $numfuncdepois <= 450){
        	$cod_prod = 979;
    	}elseif($numfuncdepois >= 451 and $numfuncdepois <= 500){
        	$cod_prod = 1003;
    	}elseif($numfuncdepois >= 501 and $numfuncdepois <= 600){
        	$cod_prod = 1004;
    	}elseif($numfuncdepois >= 601 and $numfuncdepois <= 700){
        	$cod_prod = 1005;
    	}elseif($numfuncdepois >= 701 and $numfuncdepois <= 800){
        	$cod_prod = 1006;
    	}elseif($numfuncdepois >= 801 and $numfuncdepois <= 900){
        	$cod_prod = 1007;
    	}elseif($numfuncdepois > 900){
        	$cod_prod = 1008;
    	}
        $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$codorcalter', $cod_cliente, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 8;
			
			
			
			
			
			
			
			
			
			//--> CURSO EPI -----------------------------------------------------------
		
			

    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 431";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$codorcalter', $cod_cliente, 1, 431, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 9;
			
			
			
			
			
			
			
			
			
			
			//--> LTCAT -----------------------------------------------------------
        // Apenas grau de risco 3 ou 4
        if($graurisco == 3){
            if($numfuncdepois <= 10 ){
                $cod_prod = 440;
            }elseif($numfuncdepois >= 11 && $numfuncdepois <= 20 ){
                $cod_prod = 441;
            }elseif($numfuncdepois >= 21 && $numfuncdepois <= 50 ){
                $cod_prod = 442;
            }elseif($numfuncdepois >= 51 && $numfuncdepois <= 100 ){
                $cod_prod = 443;
            }elseif($numfuncdepois >= 101 && $numfuncdepois <= 150 ){
                $cod_prod = 444;
            }elseif($numfuncdepois >= 151 && $numfuncdepois <= 250 ){
                $cod_prod = 445;
            }elseif($numfuncdepois >= 251 && $numfuncdepois <= 350 ){
                $cod_prod = 446;
            }elseif($numfuncdepois >= 351 && $numfuncdepois <= 450 ){
                $cod_prod = 447;
            }elseif($numfuncdepois >= 451 && $numfuncdepois <= 500 ){
                $cod_prod = 1009;
            }elseif($numfuncdepois >= 501 && $numfuncdepois <= 600 ){
                $cod_prod = 1010;
            }elseif($numfuncdepois >= 601 && $numfuncdepois <= 700 ){
                $cod_prod = 1011;
            }elseif($numfuncdepois >= 701 && $numfuncdepois <= 800 ){
                $cod_prod = 1012;
            }elseif($numfuncdepois >= 801 && $numfuncdepois <= 900 ){
                $cod_prod = 1013;
            }elseif($numfuncdepois > 900 ){
                $cod_prod = 1014;
            }
			
			
			
        }elseif($graurisco == 4){
             if($numfuncdepois <= 10 ){
                $cod_prod = 448;
            }elseif($numfuncdepois >= 11 && $numfuncdepois <= 20 ){
                $cod_prod = 804;
            }elseif($numfuncdepois >= 21 && $numfuncdepois <= 50 ){
                $cod_prod = 805;
            }elseif($numfuncdepois >= 51 && $numfuncdepois <= 100 ){
                $cod_prod = 890;
            }elseif($numfuncdepois >= 101 && $numfuncdepois <= 150 ){
                $cod_prod = 892;
            }elseif($numfuncdepois >= 151 && $numfuncdepois <= 250 ){
                $cod_prod = 894;
            }elseif($numfuncdepois >= 251 && $numfuncdepois <= 350 ){
                $cod_prod = 896;
            }elseif($numfuncdepois >= 351 && $numfuncdepois <= 450 ){
                $cod_prod = 942;
            }elseif($numfuncdepois >= 451 && $numfuncdepois <= 500 ){
                $cod_prod = 1015;
            }elseif($numfuncdepois >= 501 && $numfuncdepois <= 600 ){
                $cod_prod = 1016;
            }elseif($numfuncdepois >= 601 && $numfuncdepois <= 700 ){
                $cod_prod = 1017;
            }elseif($numfuncdepois >= 701 && $numfuncdepois <= 800 ){
                $cod_prod = 1018;
            }elseif($numfuncdepois >= 801 && $numfuncdepois <= 900 ){
                $cod_prod = 1019;
            }elseif($numfuncdepois > 900 ){
                $cod_prod = 1020;
            }
        }
		
		if($graurisco >=3){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
        	    $error = 0;
            else
                $error = 10;
        }
			
			
			
			
		//--> MAPA DE RISCO A3 e A4 -----------------------------------------------------------	
			
		if($graurisco <= 2){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 963";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, 963, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
        	    $error = 0;
            else
                $error = 11;
			
			
			
			$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 965";
    	    $prod = pg_fetch_array(pg_query($sql));
	    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, 965, 2, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 12;
			
			
			}else{
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 422";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, 422, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 13;
				

        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 964";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, 964, 2, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 14;
        }
			
			
			
			
			
			
			
			
			 //--> CURSO DE CIPA -----------------------------------------------------------
		
		$numcipa = $_POST['membros_cipa'];
		
		
        $nums = explode("|", $numcipa);
        $ts   = (int)($nums[0] + $nums[1]);
        if($ts >= 2){
			
			
			
			
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 840";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, 840, $ts, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 15;
			
		
			
			
			//acessoria a cipa - organiza��o de processo eleitoral
				
        	
        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 980";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, 980, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 16;
			
			
			
			
			
			//acessoria a cipa - elabora��o de ata ordin�ria (mensal) 12x
			
			
        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 981";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, 981, 12, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 17;
			
			
			//-----------
			
			
			 }else{
			
			 $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 897";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, 897, $ts, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 18;
			}
			
			
			
			
			
			 //--> CURSO DE PREVEN��O DE INC�NDIO --------------------------------------------
		
		
        if($cadcliente['membros_brigada'] > 0){
			
			
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 982";
    	    $prod = pg_fetch_array(pg_query($sql));
	    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$codorcalter', $cod_cliente, 1, 982, $cadcliente[membros_brigada], 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 19;
				
				
			}
			
			
			
			
			
			
			
			
			
			
			//--> PCMAT ----------------------------------------------------------------------
       
	   
	   
	   
	    $sql = "SELECT * FROM cnae WHERE cnae_id = '$cadcliente[cnae_id]' AND lower(descricao) like '%constru��o civil%' AND grau_risco > 2";
        $rcc = pg_query($sql);
        if(pg_num_rows($rcc)){
			
			
			
			
            $sql = "SELECT * FROM produto WHERE lower(desc_resumida_prod) LIKE '%pcmat%'
            AND $numfuncdepois BETWEEN g_min AND g_max";
    		$rpd = pg_query($sql);
    		$prod = pg_fetch_array($rpd);
    		if(pg_num_rows($rpd)){
		    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
				VALUES
				('$codorcalter', $cod_cliente, 1, $prod[cod_prod], 1, 0, '', $prod[preco_prod] )";
                if(pg_query($sql))
        	        $error = 0;
                else
                    $error = 20;
					
					
			}
					
    		
        }
			
			
			
			
			
			}
			
			
			
			
			
	  
	  /*
	  
	  //--------------------ATUALIZAR QUANTIDADE DO ASO-----------------------
	  
	  
	  
	  $prodasoaltsql = "SELECT sp.* FROM site_orc_produto_alter sp, produto p WHERE sp.cod_cliente = $cod_cliente AND sp.cod_produto = p.cod_prod AND p.desc_resumida_prod LIKE '%Emiss�o de ASO%'";
	  
	  
	  $prodasoaltquery = pg_query($prodasoaltsql);
	  
	  $prodasoaltnum = pg_num_rows($prodasoaltquery);
	  
	  $prodasoalt = pg_fetch_all($prodasoaltquery);
	  
	  if($prodasoaltnum >= 1){
		  
		  for($x=0;$x<$prodasoaltnum;$x++){
			  
			  $codigoaso = $prodasoalt[$x][cod_produto];
			  
			  
			  $updasosql = "UPDATE site_orc_produto_alter SET quantidade = '$numfunc' WHERE cod_cliente = $cod_cliente AND cod_produto = $codigoaso";
			  
			  $updaso = pg_query($updasosql);
			  
		  
		  }
	  
	  }
	  
	  
	  
	  //--------------------ATUALIZAR QUANTIDADE DO PPP-----------------------
	  
	  
	  
	  $prodpppaltsql = "SELECT sp.* FROM site_orc_produto_alter sp, produto p WHERE sp.cod_cliente = $cod_cliente AND sp.cod_produto = p.cod_prod AND p.desc_resumida_prod LIKE '%s�o do PPP%'";
	  
	  
	  $prodpppaltquery = pg_query($prodpppaltsql);
	  
	  $prodpppaltnum = pg_num_rows($prodpppaltquery);
	  
	  $prodpppalt = pg_fetch_all($prodpppaltquery);
	  
	  if($prodpppaltnum >= 1){
		  
		  for($x=0;$x<$prodpppaltnum;$x++){
			  
			  $codigoppp = $prodpppalt[$x][cod_produto];
			  
			  
			  $updpppsql = "UPDATE site_orc_produto_alter SET quantidade = '$numfunc' WHERE cod_cliente = $cod_cliente AND cod_produto = $codigoppp";
			  
			  $updppp = pg_query($updpppsql);
			  
		  
		  }
	  
	  }
	  
	  
	  
	  
	  
	  //--------------------ATUALIZAR QUANTIDADE DA OS-----------------------
	  
	  
	  
	  $prodosaltsql = "SELECT sp.* FROM site_orc_produto_alter sp, produto p WHERE sp.cod_cliente = $cod_cliente AND sp.cod_produto = p.cod_prod AND p.desc_resumida_prod LIKE '%Elabora��o e Implementa��o de O.S%'";
	  
	  
	  $prodosaltquery = pg_query($prodosaltsql);
	  
	  $prodosaltnum = pg_num_rows($prodosaltquery);
	  
	  $prodosalt = pg_fetch_all($prodosaltquery);
	  
	  if($prodosaltnum >= 1){
		  
		  for($x=0;$x<$prodosaltnum;$x++){
			  
			  $codigoos = $prodosalt[$x][cod_produto];
			  
			  
			  $updossql = "UPDATE site_orc_produto_alter SET quantidade = '$numfunc' WHERE cod_cliente = $cod_cliente AND cod_produto = $codigoos";
			  
			  $updos = pg_query($updossql);
			  
		  
		  }
	  
	  }
	  
	  
	  
	  */
	  
	  
	  
	  
	  
	  
	  //SE � EXISTIR OR�AMENTO
	  $orca = "SELECT * FROM site_orc_info WHERE cod_cliente = {$_GET[cod_cliente]}";
	  $r_orca = pg_query($orca);
	  $in_orc = pg_fetch_array($r_orca);
	  
	  if(pg_num_rows($r_orca) == 0){
		//INSERIR OR�AMENTO
	  	$sql = "SELECT MAX(cod_orcamento) + 1 as cod_orcamento FROM site_orc_info";
		$rr = pg_query($sql);
		$maxi = pg_fetch_array($rr);
		
		//INSERE O ORCAMENTO NA TABELA DO SITE
		$sql = "INSERT INTO site_orc_info
		(cod_orcamento, cod_cliente, cod_filial, num_itens, data_criacao, data_aprovacao, aprovado, orc_request_time, orc_request_time_sended,
		vendedor_id)
		VALUES
		({$maxi[cod_orcamento]}, {$_GET[cod_cliente]}, 1, '0', '".date("Y/m/d")."', '".date("Y/m/d")."', '0', '".date("h:i:s")."', '1',
		'{$_POST[vendedor]}')";
		$result_in = pg_query($sql);
		
		$q_orc = "insert into site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
				  values
				  ({$maxi[cod_orcamento]}, {$_GET[cod_cliente]}, 1, 0, 0, 0, '', 0 )";
		$r_orc = pg_query($q_orc);
	  }
  
	  $search = "select sop.*, sof.* from site_orc_produto sop, cliente c, site_orc_info sof
			  where sop.cod_cliente = c.cliente_id
			  and c.cliente_id = {$_GET[cod_cliente]} AND sop.cod_orcamento = sof.cod_orcamento";
	  $resu = pg_query($search);
	  $buff = pg_fetch_all($resu);
	  
	       if($updresult){
          showMessage('<p align=justify>Cadastro atualizado com sucesso.</p>');
          makelog($_SESSION[usuario_id], 'Atualiza��o de cadastro de cliente, '.$_GET[cod_cliente].' - '.$_POST[razao_social], 203);
      }else{
          foreach($_POST as $k => $v){
              $buffer[$k] = addslashes($v);//echo $k." -> ".$v."<BR>";
          }
          makelog($_SESSION[usuario_id], 'Erro ao atualizar cadastro de cliente, '.$data[cliente_id].' - '.$_POST[razao_social], 204);
          showMessage('<p align=justify>N�o foi poss�vel atualizar este cadastro. Por favor, verifique se todos os campos obrigat�rios foram preenchidos corretamente.<BR>Em caso de d�vidas, entre em contato com o setor de suporte!</p>', 1);
      }  
}

//SE FOR PASSADO cod_cliente, SEN�O, NOVO CADASTRO
if(is_numeric($_GET[cod_cliente])){
    //Get client
    $sql = "SELECT * FROM cliente WHERE cliente_id = '{$_GET[cod_cliente]}'";
    $res = pg_query($sql);
    $buffer = pg_fetch_array($res);
	
	//Busca nome de vendedor
	if(is_numeric($buffer[vendedor_id])){
	    $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$buffer[vendedor_id]}";
	    $rf = pg_query($sql);
	    $ff = pg_fetch_array($rf);
	}
	
	//cnae info
	$sql = "SELECT n.cnae, n.grau_risco, n.grupo_cipa, c.* FROM cliente c, cnae n WHERE cliente_id = '{$_GET[cod_cliente]}' AND c.cnae_id = n.cnae_id";
    $res = pg_query($sql);
    $buf = pg_fetch_array($res);
	
	if(!empty($buffer[data])){
	$d = $buffer[data];
	}elseif(!empty($dat)){
	$d = $dat;
	}else{
	$d = date("d/m/Y");
	}

    if($buffer[nome_contato_dir] == '') $buffer[nome_contato_dir] = 'Sr.(�)';
    if($buffer[nome_cont_ind] == '')    $buffer[nome_cont_ind]    = 'Sr.(�)';
    if($buffer[nome_contador] == '')    $buffer[nome_contador]    = 'Sr.(�)';

    //C�lculo para membros de brigada de inc�ndio -> return $membros
    if($buffer[classe]!=""){
        $sql = "SELECT * FROM brigadistas WHERE classe = '$buffer[classe]'";
        $res = pg_query($sql);
        $row_calc = pg_fetch_array($res);
        $menor = $row_calc[ate_10];
        $maior = $row_calc[mais_10];
        if($buffer[numero_funcionarios]<=10)
            $calculo = $buffer[numero_funcionarios]*($menor/100);
        else
            $calculo = 10*($menor/100)+($buffer[numero_funcionarios]-10)*($maior/100);

        if($membros = round($calculo, 0) <= 0){
            $membros = "N�o necess�ria";
        }else{
            $membros = round($calculo, 0);
        }
    }

    //C�lculo para participantes da CIPA
    if($buf[cnae_id] != ""){
    	$sql = "SELECT * FROM cipa WHERE grupo = '{$buf[grupo_cipa]}'";
        $res_cont = pg_query($sql);
        //$row_cont = pg_fetch_array($res_cont);
        while($row_cont=pg_fetch_array($res_cont)){
    	    $numero = explode(" a ", $row_cont[numero_empregados]);
    		if($buffer[numero_funcionarios] > $numero[0] && $numero[1] > $buffer[numero_funcionarios] || $buffer[numero_funcionarios] == $numero[0] || $buffer[numero_funcionarios] == $numero[1]){
                if($row_cont[numero_membros_cipa] >= "19"){
    		 		$menor = true;
    				$efetivo_empregador  = 1;
    				$suplente_empregador = 0;
    				$efetivo_empregado   = 0;
    				$suplente_empregado  = 0;
    			}else{
    		 		$necessidade         = $row_cont[numero_membros_cipa] + $row_cont[numero_representante_empregador] + $row_cont[suplente];
    				$efetivo_empregador  = $row_cont[numero_membros_cipa];
    				$suplente_empregador = $row_cont[suplente];
    				$efetivo_empregado   = $row_cont[numero_membros_cipa];
    				$suplente_empregado  = $row_cont[suplente];
    			}
    	    }
        }
        $total1 = $efetivo_empregador + $suplente_empregador;
        $total2 = $efetivo_empregado + $suplente_empregado;
        $membros_cipa = $total1." | ".$total2;
    }
}else{
    $sql = "SELECT MAX(c.cliente_id)+1 as cliente_id, MAX(substr(c.ano_contrato, 6)) as ano_contrato FROM cliente c";
    $res = pg_query($sql);
    $buffer = pg_fetch_array($res);
    $buffer[ano_contrato] = date("Y")."/".($buffer[ano_contrato]+1);
    if($buffer[nome_contato_dir] == '') $buffer[nome_contato_dir] = 'Sr.(�) ';
    if($buffer[nome_cont_ind] == '')    $buffer[nome_cont_ind]    = 'Sr.(�) ';
    if($buffer[nome_contador] == '')    $buffer[nome_contador]    = 'Sr.(�) ';
}

//Lista de classes de brigada
$sql = "SELECT * FROM brigadistas ORDER BY classe";
$res_brig = pg_query($sql);
$classes_brigada = pg_fetch_all($res_brig);

/**************************************************************************************************/
if(is_numeric($_GET[cod_cliente])){
    $sql = "SELECT fi.cod_fatura, fi.cod_cliente, fi.cod_filial FROM site_fatura_info fi, cliente c
    WHERE
    c.cliente_id = '$_GET[cod_cliente]'
    AND
    fi.cod_cliente = c.cliente_id
    AND
    fi.cod_filial = c.filial_id
    AND
    (
    (
    EXTRACT(year FROM fi.data_vencimento) < '".date("Y")."'
    )OR(
    EXTRACT(day FROM fi.data_vencimento) < '".date("d")."'
    AND
    EXTRACT(month FROM fi.data_vencimento) = '".date("m")."'
    AND
    EXTRACT(year FROM fi.data_vencimento) = '".date("Y")."'
    )OR(
    EXTRACT(month FROM fi.data_vencimento) < '".date("m")."'
    AND
    EXTRACT(year FROM fi.data_vencimento) = '".date("Y")."'
    )
    )
    AND
    fi.migrado = 0
    GROUP BY fi.cod_fatura, fi.cod_cliente, fi.cod_filial
    ORDER BY fi.cod_fatura ASC";
    $rfat = pg_query($sql);
    $fat = pg_fetch_all($rfat);
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                // RESUMO DO CLIENTE
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Resumo</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left onmouseover=\"showtip('tipbox', '- Exibe op��es resumidas relativas ao cliente selecionado.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' width=160>C�d. Cliente:</td><td class='text' width=80 align=right><b>".str_pad($buffer[cliente_id], 4, "0", 0)."</b><input type=hidden name='cod_cliente' value='{$buffer[cliente_id]}'></td>";
                        echo "</tr><tr>";
                        echo "<td class='text' width=160>Ano/Contrato:</td><td class='text' width=80 align=right><b>{$buffer[ano_contrato]}</b><input type=hidden name='ano_contrato' value='{$buffer[ano_contrato]}'></td>";
                        echo "</tr><tr>";
                        //link abrir faturas vencidas (controle de inadimplentes)
                        echo "<td class='text' width=160>Faturas Vencidas:</td><td class='text' width=80 align=right><a href='#' onclick=\"alert('Em desenvolvimento!');\">".@pg_num_rows($rfat)."</a></td>";
                        echo "</tr><tr>";
                        //link abrir pr�xima fatura (pr�xima n�o vencida - Gerar resumo de fatura)
                        echo "<td class='text' width=160>Pr�ximo Vencimento:</td><td class='text' width=80 align=right><a href='#' onclick=\"alert('Em desenvolvimento!');\">".date("d/m/y")."</a></td>";
                        echo "</tr>";
                        if(is_numeric($_GET[cod_cliente])){
                            echo "<tr>";
                            echo "<td class='text' width=160>Status:</td><td class='text' width=80 align=right>";
                            echo "<select id='chstatus' name='chstatus' style=\"width: 90px;\" onblur=\"cad_cliente_change_status('".$_GET[cod_cliente]."');\">";
                            echo "<option value='ativo' "; print $buffer[status]=="ativo" ? " selected " : ""; echo ">Ativo</option>";
                            echo "<option value='comercial' "; print $buffer[status]=="comercial" ? " selected " : ""; echo ">Comercial</option>";
							echo "<option value='parceria' "; print $buffer[status]=="parceria" ? " selected " : ""; echo ">Parceria</option>";
							
							echo "<option value='Inativo' "; print $buffer[status]=="Inativo" ? " selected " : ""; echo ">Inativo</option>";
							
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";

                // OP��ES DO CLIENTE
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Op��es</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Res. Contrato' onclick=\"location.href='?dir=cad_cliente&p=resumo_contrato&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Resumo de Contrato, exibe um resumo das cl�usulas do contrato deste cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Funcionarios' onclick=\"location.href='?dir=cad_cliente&p=cadastro_func&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Funcion�rios, exibe a lista de funcion�rios da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Certificado' onclick=\"newWindow('".current_module_path."certificado/cert/?cod_cliente=$_GET[cod_cliente]');\"  onmouseover=\"showtip('tipbox', '- Certificado, exibe o certificado da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        
						//Pegar a URL
						$urlwww = $_SERVER['SERVER_NAME'];
						
						if($urlwww == 'www.sesmt-rio.com'){
						
						echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Buscar Cliente'  onclick=\"window.open('http://www.sesmt-rio.com/erp/2.0/modules/cad_cliente/search.php', 'search', 'status=no,scrollbars=yes,toolbar=no,height=400,width=500');\" onmouseover=\"showtip('tipbox', '- Localizar, permite que seja executada uma busca por outros clientes.');\" onmouseout=\"hidetip('tipbox');\"></td>";
						
						}else{
							
						echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Buscar Cliente'  onclick=\"window.open('http://sesmt-rio.com/erp/2.0/modules/cad_cliente/search.php', 'search', 'status=no,scrollbars=yes,toolbar=no,height=400,width=500');\" onmouseover=\"showtip('tipbox', '- Localizar, permite que seja executada uma busca por outros clientes.');\" onmouseout=\"hidetip('tipbox');\"></td>";	
							
						}
						
						
                        echo "</tr><tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=new';\"  onmouseover=\"showtip('tipbox', '- Novo, permite o cadastro de um novo cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Guia de Ruas' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]&sp=mapa';\" onmouseover=\"showtip('tipbox', '- Mapa, exibe um mapa com a localiza��o da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Rel. Atend.' onclick=\"location.href='?dir=cad_cliente&p=rel_atendimento&cod_cliente=$_GET[cod_cliente]';\"  onmouseover=\"showtip('tipbox', '- Relat�rio, permite o cadastro de relacionamento com o cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Coment�rio' onclick=\"location.href='?dir=cad_cliente&p=add_coment&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Coment�rio, permite adicionar um coment�rio relevante no cadastro do cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Receita Federal' onclick=\"window.open('http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao.asp');\" onmouseover=\"showtip('tipbox', '- Receita Federal, permite consultar o cliente na receita federal.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Or�amento' onclick=\"location.href='?dir=cad_cliente&p=list_orc&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Or�amento, permite visualizar a lista de or�amentos do cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
						echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Cad. Fun��o' onclick=\"location.href='?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=1';\" onmouseover=\"showtip('tipbox', '- Cadastro de Fun��o, Permite cadastrar uma determinada fun��o para a empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
						
						echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Boleto' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]&sp=cliente_boleto';\" onmouseover=\"showtip('tipbox', '- Boleto, permite mandar o boleto para o cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
						
                        echo "</tr>";
                        if($_SESSION["grupo"] == "administrador"){
                        	echo "<tr>";
	                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Trocar Acesso' onclick=\"location.href='?dir=cad_cliente&p=up_loginsenha&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Alterar, permite alterar o Login e Senha do cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";	                        
	                        echo "</tr>";
                        }
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";


                // --> TIPBOX
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
				
				
				
				
				
				
				
				
				echo "<P>";
				
				
				echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Ordem de Servi�o</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
				
				if($_GET['cod_cliente'] != 'new'){
				
				$servicosmostrasql = "SELECT sp.cod_produto, sp.quantidade FROM site_orc_info si INNER JOIN site_orc_produto sp ON si.cod_orcamento = sp.cod_orcamento INNER JOIN produto pr ON pr.cod_prod = sp.cod_produto WHERE si.aprovado = 1 AND si.cod_cliente = $_GET[cod_cliente] AND pr.cod_atividade = 3 group by sp.cod_produto, sp.quantidade ORDER BY sp.cod_produto";
				$servicosmostraquery = pg_query($servicosmostrasql);
				$servicosmostra = pg_fetch_all($servicosmostraquery);
				$servicosnum = pg_num_rows($servicosmostraquery);
				
				}
			
				
				
				echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
						echo "<td class='text' align=center>";
						
						for($x=0;$x<$servicosnum;$x++){
						
							
						$codiprod = $servicosmostra[$x][cod_produto];
						
						$mostrarservisql = "SELECT desc_resumida_prod FROM produto WHERE cod_prod = $codiprod";
						
						$mostrarserviquery = pg_query($mostrarservisql);	
						
						$mostrarservi = pg_fetch_array($mostrarserviquery);
						
						echo $x." - ";
						echo $mostrarservi['desc_resumida_prod']." - ".$servicosmostra[$x][quantidade];
						echo "<p>";
						
						}
						
						
						
						echo "</td>";
						echo "</tr>";
						echo "</table>";
						echo "</td>";
              			echo "</tr>";
                		echo "</table>";
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
        echo "</td>";
		
		

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
        if($_GET[cod_cliente] == "new"){
            echo "<b>Novo Cadastro</b>";
		}else{
            echo "<b>{$buffer[razao_social]}</b>";
        }
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        $sp = current_module_path.anti_injection($_GET[sp]).".php";
        if(file_exists($sp)){
            include($sp);
        }else{
            include('cadastro.php');
        }
        
        
    echo "</td>";
echo "</tr>";
echo "</table>";
    
?>
