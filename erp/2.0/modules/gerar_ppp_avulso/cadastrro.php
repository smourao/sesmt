<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
<?PHP
	
	$id = $_GET[id];
	

	$sql = "SELECT * FROM ppp_avulso WHERE id = $id";
	$result = pg_query($sql);
	$buffer = pg_fetch_array($result);
	$numerototal = pg_num_rows($result);
	

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
    echo "<form method=post id='frmcadcliente' name='frmcadcliente' action='?dir={$_GET[dir]}&p={$_GET[p]}&id={$_GET[id]}' >";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

   
	echo "<tr>";
    echo "<td align=left class=text width='100'><span id='txtRazao'>Razão Social:</span></td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=razao_social id=razao_social value='$buffer[razao_social]'></td>";
    echo "<td align=left class=text width='100'><span id='txtCnpj'>CNPJ:</span></td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=18 name=cnpj id=cnpj value='$buffer[cnpj]' maxlength='18'></td>";
    echo "</tr>";

    echo "<tr>";
    
    echo "<td align=left class=text width='100'>CNAE:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=cnae id=cnae value='$buffer[cnae]'  maxlength='7'></td>";
	
	 echo "<td align=left class=text width='100'>Grau de Risco:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=3 name=grau_risco id=grau_risco value='$buffer[grau_de_risco]'  maxlength='1'></td>";
	
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Nome Representante:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=nome_contato_dir id=nome_contato_dir value='$buffer[nome_contato_dir]'></td>";
    echo "<td align=left class=text width='100'>PIS Empresa:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=nit_empresa id=nit_empresa value='$buffer[nit_empresa]'></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> DADOS DE LOCALIZAÇÃO
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados do Funcionário:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Nome:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=nome_func id=nome_func value='$buffer[nome_func]'></td>";
    echo "<td align=left class=text width='100'>Data de Nascimento:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=data_nascimento id=data_nascimento value='$buffer[data_nascimento]' maxlength='10'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>PIS:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=nit id=nit value='$buffer[nit]'></td>";
    echo "<td align=left class=text width='100'>BR/PDH:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=pdh id=pdh value='$buffer[pdh]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Sexo:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=sexo id=sexo value='$buffer[sexo]'></td>";
    echo "<td align=left class=text width='100'>CTPS:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=ctps id=ctps value='$buffer[ctps]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Série:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=15 name=ctps_serie id=ctps_serie value='$buffer[ctps_serie]'></td>";
    echo "<td align=left class=text width='100'>UF:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=5 name=ctps_uf id=ctps_uf value='$buffer[ctps_uf]' maxlength='2'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Data da Admissão:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=data_admissao id=data_admissao value='$buffer[data_admissao]' maxlength='10'></td>";
    echo "<td align=left class=text width='100'>Data do Desligamento:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=data_desligamento id=data_desligamento value='$buffer[data_desligamento]' maxlength='10'></td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td align=left class=text width='100'>Revezamento:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=revezamento id=revezamento value='$buffer[revezamento]'></td>";
    echo "<td align=left class=text width='100'>Setor:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=setor id=setor value='$buffer[setor]'></td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td align=left class=text width='100'>Cargo:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=cargo id=cargo value='$buffer[cargo]'></td>";
    echo "<td align=left class=text width='100'>Função:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=funcao id=funcao value='$buffer[funcao]'></td>";
    echo "</tr>";
	
	
	echo "<tr>";
    echo "<td align=left class=text width='100'>CBO:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=cbo id=cbo value='$buffer[cbo]'></td>";
    echo "</tr>";
	
	
	echo "<tr>";
    echo "<td align=left class=text width='100'>Descrição da Atividade:</td>";
    echo "<td align=left class=text colspan=3><textarea name=dsc_funcao id=dsc_funcao style=\"width:100%;\">$buffer[dsc_funcao]</textarea></td>";
    echo "</tr>";

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
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=data_registro_cat id=data_registro_cat value='$buffer[data_registro_cat]'></td>";
    echo "<td align=left class=text width='100'>Numero do CAT:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=num_cat id=num_cat value='$buffer[num_cat]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Data do Registro do CAT:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=data_registro_cat2 id=data_registro_cat2 value='$buffer[data_registro_cat2]'></td>";
    echo "<td align=left class=text width='100'>Numero do CAT:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=num_cat2 id=num_cat2 value='$buffer[num_cat2]'></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**************************************************************************************************/
// --> EXPOSIÇÃO A FATORES DE RISCO
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Exposição a Fatores de Riscos:</b>";
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
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=tipo_exame id=tipo_exame value='$buffer[tipo_exame]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Exames:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=15 name=nome_exame id=nome_exame value='$buffer[nome_exame]''></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<P>";

echo "&nbsp;<span class='inputTextobr'>&nbsp;&nbsp;&nbsp;&nbsp;</span><font size=1><i> - Campos com esta coloração são de preenchimento obrigatório!</i></font>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";


?>
