<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">


<?PHP

	
	$id = $_GET[id];
	

	$sql = "SELECT * FROM ppp_avulso WHERE id = $id";
	$result = pg_query($sql);
	$buffer = pg_fetch_array($result);
	$numerototal = pg_num_rows($result);
	
if(isset($buffer[data_nascimento]))
$buffer[data_nascimento] = date('d/m/Y', strtotime($buffer[data_nascimento]));

if(isset($buffer[data_admissao]))
$buffer[data_admissao] = date('d/m/Y', strtotime($buffer[data_admissao]));

if(isset($buffer[data_desligamento]))
$buffer[data_desligamento] = date('d/m/Y', strtotime($buffer[data_desligamento]));

if(isset($buffer[data_registro_cat]))
$buffer[data_registro_cat] = date('d/m/Y', strtotime($buffer[data_registro_cat]));

if(isset($buffer[data_registro_cat2]))
$buffer[data_registro_cat2] = date('d/m/Y', strtotime($buffer[data_registro_cat2]));
	
	
if($_GET['update'] == 'true'){
		
	$exa = $_POST['exame'];
	$number = count($exa);
	
	for($z=0;$z<$number;$z++){
	$texto_exa .= $exa[$z]."|";
	}
		
		
$razao_social = $_POST['razao_social'];
$cnpj = $_POST['cnpj'];
$cnae = $_POST['cnae'];

	$query_cnae="SELECT grau_risco FROM cnae WHERE cnae='".$cnae."'";
	$result_cnae=pg_query($query_cnae);
	$row_cnae=pg_fetch_array($result_cnae);
	$cnaenum = pg_num_rows($result_cnae);
	
	if($cnaenum >= 1)
	$grau_risco = $row_cnae[grau_risco];
	else
	$grau_risco = '0';
	
$nome_contato_dir = $_POST['nome_contato_dir'];
$nit_empresa = $_POST['nit_empresa'];
$nome_func = $_POST['nome_func'];
$data_nascimento = $_POST['data_nascimento'];
$nit = $_POST['nit'];
$pdh = $_POST['pdh'];
$sexo = $_POST['sexo'];
$ctps = $_POST['ctps'];
$ctps_serie = $_POST['ctps_serie'];
$ctps_uf = $_POST['ctps_uf'];
$data_admissao = $_POST['data_admissao'];
$data_desligamento = $_POST['data_desligamento'];
$revezamento = $_POST['revezamento'];
$setor = $_POST['setor'];
$cargo = $_POST['funcao'];
$funcao = $_POST['funcao'];
$cbo = $_POST['cbo'];
$dsc_funcao = $dinamica;
$data_registro_cat = $_POST['data_registro_cat'];
$num_cat = $_POST['num_cat'];
$data_registro_cat2 = $_POST['data_registro_cat2'];
$num_cat2 = $_POST['num_cat2'];
$tipo_fator_risco = $_POST['tipo_fator_risco'];
$nome_fator_risco = $_POST['nome_fator_risco'];
$itensidade = $_POST['itensidade'];
$epc_eficaz = $_POST['epc_eficaz'];
$epi_eficaz = $_POST['epi_eficaz'];
$ca_epi = $_POST['ca_epi'];
$data_exame = $_POST['data_exame'];
$tipo_exame = $_POST['tipo_exame'];
$exame = $texto_exa;


$data_nascimento = date('Y-m-d', strtotime($data_nascimento));
$data_admissao = date('Y-m-d', strtotime($data_admissao));
$data_desligamento = date('Y-m-d', strtotime($data_desligamento));
$data_registro_cat = date('Y-m-d', strtotime($data_registro_cat));
$data_registro_cat2 = date('Y-m-d', strtotime($data_registro_cat2));
		
		
		
$updanteinfosql = "UPDATE ppp_avulso SET razao_social = '$razao_social', cnpj = '$cnpj', cnae = '$cnae', grau_de_risco = '$grau_risco', nome_contato_dir = '$nome_contato_dir', nit_empresa = '$nit_empresa', nome_func = '$nome_func', data_nascimento = '$data_nascimento', nit = '$nit', pdh = '$pdh', sexo = '$sexo', ctps = '$ctps', ctps_serie = '$ctps_serie', ctps_uf = '$ctps_uf', data_admissao = '$data_admissao', data_desligamento = '$data_desligamento', revezamento = '$revezamento', setor = '$setor', cargo = '$cargo', funcao = '$funcao', cbo = '$cbo', dsc_funcao = '$dsc_funcao', data_registro_cat = '$data_registro_cat', num_cat = '$num_cat', data_registro_cat2 = '$data_registro_cat2', num_cat2 = '$num_cat2', tipo_fator_risco = '$tipo_fator_risco', nome_fator_risco = '$nome_fator_risco', itensidade = '$itensidade', epc_eficaz = '$epc_eficaz', epi_eficaz = '$epi_eficaz', ca_epi = '$ca_epi', data_exame = '$data_exame', tipo_exame = '$tipo_exame', nome_exame = '$exame', status_ppp = '1' WHERE id = $id";

if($updanteinfo = pg_query($updanteinfosql)){
	
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
		
		
		
	$query_fatura_max = "SELECT max(id) as cod_fatura FROM financeiro_info";
	$result_fatura_max = pg_query($query_fatura_max);
	$row_fatura_max = pg_fetch_array($result_fatura_max);
	
	$query_faturas_max = "SELECT max(id) as cod_fatura FROM financeiro_fatura";
	$result_faturas_max = pg_query($query_faturas_max);
	$row_faturas_max = pg_fetch_array($result_faturas_max);
	
	$query_relatorio_max = "SELECT max(id) as cod_relatorio FROM financeiro_relatorio";
	$result_relatorio_max = pg_query($query_relatorio_max);
	$row_relatorio_max = pg_fetch_array($result_relatorio_max);
	
	$cod_faturamax = $row_fatura_max[cod_fatura] + 1;
	$cod_faturasmax = $row_faturas_max[cod_fatura] + 1;
	$cod_relatoriomax = $row_relatorio_max[cod_relatorio] + 1;
		
		
		
		
		$receita1sql = "INSERT INTO financeiro_info (id, titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes ,ano, data_lancamento, data_entrada_saida, tipo_lancamento, historico, funcionario_id, pc) VALUES ($cod_faturamax, '$razao_social', $valorppp, 1, 'Dinheiro', 0, '$data_lancamento', '$dia', '$mes', '$ano', '$data_lancamento', '$data_lancamento', 24, '$historicoppp', 0, 0)";
		
		$receita1 = pg_query($receita1sql);
		
		
	
		//Inserindo na Tabela financeiro_fatura
	
	$receita2sql = "INSERT INTO financeiro_fatura (id, cod_fatura, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento, numero_doc, numero_cheque) VALUES ($cod_faturasmax, $cod_faturamax, '$razao_social', $valorppp, 1, '$data_lancamento', 0, 1, '$data_lancamento', '', '')";
		
		$receita2 = pg_query($receita2sql);
		
		
		
		$pppinsert2sql = "INSERT INTO financeiro_relatorio 
						(id, cod_fatura, titulo, valor, status, pago, historico, data_lancamento, semana, ano)
						VALUES ($cod_relatoriomax, $cod_faturamax, '$razao_social', $valorppp, 0, 1, '$historicoppp', '$data_lancamento', $semana, $ano)";
						
		$pppinsert2 = pg_query($pppinsert2sql);
		
		if($buffer[cod_cliente] >= 1){
			
		$pegaremailsql = "SELECT * FROM reg_pessoa_juridica WHERE cod_cliente = ".$buffer[cod_cliente]."";
		$pegaremailquery = pg_query($pegaremailsql);
		$pegaremail = pg_fetch_array($pegaremailquery);
		$email = $pegaremail['email'];
		
		
		
		$msg = "Venho informar que o PPP do funcion?rio <b>".$nome_func."</b> j? esta dispon?vel no ambiente PPP Avulso!";
					 
					 
					 
					 
					$headers = "MIME-Version: 1.0\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\n";
					$headers .= "From: SESMT - Seguran?a do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> \n";
					 
					 
					if(mail($email, "PPP AVULSO Dispon?vel", $msg, $headers)){
    					
	  					$m = 1;
	  
	  
   					}else{
      					$m = 0;
   					}
		
		
			
		}
	
	
	
	 echo "<script>location.href='?dir={$_GET[dir]}&p=index&ppplist=true';</script>";
	
}

	}
		
	

/**************************************************************************************************/
// --> DADOS DA EMPRESA
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados da empresa:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    //FORM - SAVE DATA
    echo "<form method=post id='frmcadcliente' name='frmcadcliente' action='?dir={$_GET[dir]}&p={$_GET[p]}&id={$_GET[id]}&update=true' >";
    
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

   
	echo "<tr>";
    echo "<td align=left class=text width='100'><span id='txtRazao'>Raz?o Social:</span></td>";
    echo "<td align=left class=text width='220'><input type='text' size=35 name=razao_social id=razao_social class='inputTextobr' value='$buffer[razao_social]'></td>";
    echo "<td align=left class=text width='100'><span id='txtCnpj'>CNPJ:</span></td>";
    echo "<td align=left class=text width='220'><input type='text' size=18 name=cnpj id=cnpj class='inputTextobr' value='$buffer[cnpj]' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\"></td>";
    echo "</tr>";

    echo "<tr>";
    
    echo "<td align=left class=text width='100'>CNAE:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=5 name=cnae id=cnae  class='inputTextobr'  value='$buffer[cnae]'  maxlength='7' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.##-#');\"></td>";
	
	 //echo "<td align=left class=text width='100'>Grau de Risco:</td>";
   // echo "<td align=left class=text width='220'><input type='text' size=3 name=grau_risco id=grau_risco value='$buffer[grau_de_risco]'  maxlength='1'></td>";
	
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Nome Representante:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=nome_contato_dir id=nome_contato_dir value='$buffer[nome_contato_dir]'></td>";
    echo "<td align=left class=text width='100'>PIS Representante:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=nit_empresa id=nit_empresa value='$buffer[nit_empresa]'></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> DADOS DE LOCALIZA??O
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados do Funcion?rio:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Nome:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=35 name=nome_func class='inputTextobr' id=nome_func value='$buffer[nome_func]'></td>";
    echo "<td align=left class=text width='100'>Data de Nascimento:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=35 name=data_nascimento id=data_nascimento value='$buffer[data_nascimento]' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>PIS:</td>";
    echo "<td align=left class=text width='220'><input type='text'  class='inputTextobr'  size=35 name=nit id=nit value='$buffer[nit]'></td>";
    echo "<td align=left class=text width='100'>BR/PDH:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=5 name=pdh id=pdh value='$buffer[pdh]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Sexo:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=35 name=sexo id=sexo value='$buffer[sexo]' maxlength='1'></td>";
    echo "<td align=left class=text width='100'>CTPS:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=35 name=ctps id=ctps value='$buffer[ctps]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>S?rie:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=15 name=ctps_serie id=ctps_serie value='$buffer[ctps_serie]'></td>";
    echo "<td align=left class=text width='100'>UF:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=5 name=ctps_uf id=ctps_uf value='$buffer[ctps_uf]' maxlength='2'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Data da Admiss?o:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=data_admissao id=data_admissao value='$buffer[data_admissao]' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\"></td>";
    echo "<td align=left class=text width='100'>Data do Desligamento:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=data_desligamento id=data_desligamento value='$buffer[data_desligamento]' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\"></td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td align=left class=text width='100'>Revezamento:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=revezamento id=revezamento value='$buffer[revezamento]'></td>";
    echo "<td align=left class=text width='100'>Setor:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=setor id=setor value='$buffer[setor]'></td>";
    echo "</tr>";
	
	echo "<tr>";
   // echo "<td align=left class=text width='100'>Cargo:</td>";
  //  echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=cargo id=cargo value='$buffer[cargo]'></td>";
    echo "<td align=left class=text width='100'>Fun??o:</td>";
    echo "<td align=left class=text width='220'>";
	
	
	$fu_cl = "SELECT * FROM funcao ORDER BY nome_funcao";
	$fu_cli = pg_query($fu_cl);
	$fun_cli = pg_fetch_all($fu_cli);
	
    $sql = "SELECT cod_funcao, nome_funcao, dsc_funcao FROM funcao ORDER BY nome_funcao";
    $rlf = pg_query($sql);
    $funcoes = pg_fetch_all($rlf);
    
	echo "<select class='required' name='funcao' id='funcao' style=\"width: 308px;\" onchange=\"get_dinamica_funcao(this.value);\" onkeyup=\"change_classname('funcao', 'required');\">";
        echo "<option value=''></option>";
    for($y=0;$y < pg_num_rows($fu_cli);$y++){
		if($fun_cli[$y][cod_funcao] != $fun_cli[$y-1][cod_funcao]){
			echo "<option value='{$fun_cli[$y][cod_funcao]}'";
			if($buffer[funcao] == $fun_cli[$y][cod_funcao]){
			echo " selected ";
			$dinamica = $fun_cli[$y][dsc_funcao];
			}else{
			 "";
			 }
			 echo ">".substr($fun_cli[$y][nome_funcao], 0, 71)."</option>";
			 echo ">{$funcoes[$y][nome_funcao]}</option>";
		}
    }
    echo "</select>&nbsp;<span id='loading_funcao'></span>";
	
	
	
	echo "</td>";
    
    echo "<td align=left class=text width='100'>CBO:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=cbo id=cbo value='$buffer[cbo]'></td>";
    echo "</tr>";
	
	
	//echo "<tr>";
   // echo "<td align=left class=text width='100'>Descri??o da Atividade:</td>";
  //  echo "<td align=left class=text colspan=3><textarea name=dinamica_funcao id=dinamica_funcao style=\"width:100%;\">".$dinamica."</textarea></td>";
   // echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> CONTATO DIRETO
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados do CAT:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Data do Registro do CAT:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=35 name=data_registro_cat id=data_registro_cat value='$buffer[data_registro_cat]' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\"></td>";
    echo "<td align=left class=text width='100'>Numero do CAT:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=35 name=num_cat id=num_cat value='$buffer[num_cat]' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Data do Registro do CAT:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=35 name=data_registro_cat2 id=data_registro_cat2 value='$buffer[data_registro_cat2]' maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\"></td>";
    echo "<td align=left class=text width='100'>Numero do CAT:</td>";
    echo "<td align=left class=text width='220'><input type='text' size=35 name=num_cat2 id=num_cat2 value='$buffer[num_cat2]' OnKeyPress=\"formatar(this, '##/##/####')\"></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> EXPOSI??O A FATORES DE RISCO
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Exposi??o a Fatores de Riscos:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Tipo:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=35 name=tipo_fator_risco id=tipo_fator_risco value='$buffer[tipo_fator_risco]'></td>";
    echo "<td align=left class=text width='100'>Fator de Risco:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=35 name=nome_fator_risco id=nome_fator_risco value='$buffer[nome_fator_risco]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Itensidade:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=itensidade id=itensidade value='$buffer[itensidade]'></td>";
    echo "<td align=left class=text width='100'>EPC Eficaz:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=epc_eficaz id=epc_eficaz value='$buffer[epc_eficaz]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>EPI Eficaz:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=epi_eficaz id=epi_eficaz value='$buffer[epi_eficaz]'></td>";
    echo "<td align=left class=text width='100'>CA EPI:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=ca_epi id=ca_epi value='$buffer[ca_epi]'></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> EXAMES
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Exames:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Data:</td>";
    echo "<td align=left class=text width='220'><textarea name=data_exame id=data_exame >$buffer[data_exame]</textarea></td>";
    echo "<td align=left class=text width='100'>Natureza:</td>";
	echo "<td align=left class=text width='220'><textarea name=tipo_exame id=tipo_exame >$buffer[tipo_exame]</textarea></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Exames:</td>";
	?>
	
	<?php
		// pra buscar os dados dos Exames Realizados
		$query_exame = "select cod_exame, especialidade from exame order by cod_exame";
		$result_exame = pg_query($connect, $query_exame) 
			or die ("Erro na query: $query_exame ==> ".pg_last_error($connect));
		
		?>
		 <td align="left">
		<select name = "exame[]" id="exame[]" multiple="multiple" style="width:210px" size="5" onclick="tExame();">
		<?php
			while($row_exame = pg_fetch_array($result_exame))
  			{
			echo "<option value=$row_exame[cod_exame]>$row_exame[especialidade]</option>";
  			}
			
			
			
		?>
		</select>
	
    
    
    
    
    
    
    
	
	
	<?php
  /*  echo "<td align=left class=text width='220'><input type='text' size=15 name=nome_exame id=nome_exame value='$buffer[nome_exame]' maxlength='15'></td>";
    echo "</tr>"; */

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<P>";

echo "&nbsp;<span class='inputTextobr'>&nbsp;&nbsp;&nbsp;&nbsp;</span><font size=1><i> - Campos com esta colora??o s?o de preenchimento obrigat?rio!</i></font>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            
			if($buffer[status_ppp] == 1){
			
			echo"<input type='button' value='Ja Salvo'>";
			
			
			}else{
				
				echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenar? todos os dados selecionados at? o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";	
				
			}
			
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";

if($regresult){
    echo "<script>location.href='?dir={$_GET[dir]}&p={$_GET[p]}&cod_cliente={$data[cliente_id]}&register_done=1';</script>";
    
}
?>
