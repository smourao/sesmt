<?PHP
/************************************************************************************************/
/*                  ACTION: UPDATE DATA!                                                          */
/************************************************************************************************/
if($_POST){
	$sql = "UPDATE funcionarios SET
	nome_func = '".addslashes($_POST[nome])."',	endereco_func = '".addslashes($_POST[endereco])."', bairro_func = '".addslashes($_POST[bairro])."',
	num_ctps_func = '".addslashes($_POST[ctps])."', serie_ctps_func = '".addslashes($_POST[serie])."', cbo = '".addslashes($_POST[cbo])."',
	cod_status = '".addslashes($_POST[status])."', cod_funcao = '".addslashes($_POST[cod_funcao])."', sexo_func = '".addslashes($_POST[sexo])."',
	data_nasc_func = '$dtn', data_admissao_func = '$dtad', data_desligamento_func = '$dtdm', dinamica_funcao = '".addslashes($_POST[dinamica_funcao])."',
	cidade = '".addslashes($_POST[cidade])."', naturalidade = '".addslashes($_POST[natural])."', nacionalidade = '".addslashes($_POST[nacionalidade])."',
	civil = '".addslashes($_POST[civil])."', cor = '".addslashes($_POST[cor])."', cpf = '".addslashes($_POST[cpf])."', rg = '".addslashes($_POST[rg])."',
	cep = '".addslashes($_POST[cep])."', estado = '".addslashes($_POST[estado])."', pis = '".addslashes($_POST[pis])."',
	pdh = '".addslashes($_POST[pdh])."', data_ultimo_exame = '".addslashes($_POST[data_ultimo_exame])."'
	WHERE cod_cliente = '$_GET[cod_cliente]' AND cod_func = '$_GET[cod_func]'";
	if(@pg_query($sql)){
		showMessage('<p align=justify>Dados do funcionário atualizado com sucesso!</p>', 0);
	}else{
		showMessage('<p align=justify>Erro ao alterar dados do funcionário!</p>', 2);
	}
}
	
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
	 	echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>&nbsp;</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborder'>";			
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Relação Func.' onclick=\"location.href='?dir=cad_cliente&p=cadastro_func&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Volta para tela de relação de funcionários.');\" onmouseout=\"hidetip('tipbox');\"></td>";
        echo "</tr>";
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
        echo "</td>";
		
/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>Alteração de Funcionários</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

/************************************************************************************************/
/*                  ACTION: MAIN FORM!                                                          */
/************************************************************************************************/
    $sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente] AND cod_func = $_GET[cod_func]";
	$result = pg_query($sql);
	$func = pg_fetch_array($result);
        
    echo "<form name=form1 method=post>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 >";
    echo "<tr>";
    echo "<td class='text'><b>Dados Pessoais:</b></td>";
    echo "</tr>";
	echo "</table>";
	
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
    echo "<tr>";
    echo "<td align=left class='text' width=100><b>Nome:</b></td>";
    echo "<td align=left class='text' width=220><input type='text' class='inputText' size=35 name=nome id=nome value='".addslashes($func[nome_func])."'></td>";
    echo "<td align=left class='text' width=100><b>Sexo:</b></td>";
    echo "<td align=left class='text' width=100><select id=sexo name=sexo class='inputText' style=\"width: 100px\">
		  <option value='Masculino'"; if($func[sexo_func] == "Masculino"){ echo "selected";} echo">Masculino</option>
		  <option value='Feminino'"; if($func[sexo_func] == "Feminino"){ echo "selected";} echo ">Feminino</option>
		  </select></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>RG:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=rg id=rg value='$func[rg]' OnKeyPress=\"formatar(this, '########-#');\"></td>";
    echo "<td align=left class='text' width='100'><b>CPF:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=cpf id=cpf value='$func[cpf]' maxlength='15' OnKeyPress=\"formatar(this, '###.###.###-##');\"></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>PIS:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=pis id=pis value='$func[pis]'></td>";
   /* echo "<td align=left class='text' width='100'><b>BR/PDH:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=pdh id=pdh value='$func[pdh]'></td>";
    echo "</tr>"; */
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>CEP:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=cep id=cep value='$func[cep]' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" onblur=\"check_cep(this);\">&nbsp;<span id='verify_cep'></span></td>";
    echo "<td align=left class='text' width='100'><b>Endereço:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=endereco id=endereco value='$func[endereco_func]'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Bairro:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=bairro id=bairro value='$func[bairro_func]'></td>";
    echo "<td align=left class='text' width='100'><b>Município:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=municipio id=municipio value='$func[cidade]'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Estado:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=estado id=estado value='$func[estado]'></td>";
    echo "<td align=left class='text' width='100'><b>Natural:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=natural id=natural value='$func[natural]'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Nacionalidade:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=nacionalidade id=nacionalidade value='$func[nacionalidade]'></td>";
    echo "<td align=left class='text' width='100'><b>Estado Civil:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=civil id=civil value='$func[civil]'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Nascimento:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=dtn id=dtn";
		echo " value='$func[data_nasc_func]'";
		echo " maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "<td align=left class='text' width='100'><b>Cor:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=cor id=cor value='$func[cor]'></td>";
    echo "</tr>";
	
	echo "</table>";
	
	echo "<p>";

	/*******************************************************************************************************/
	// DADOS PROFISSIONAIS
	/*******************************************************************************************************/
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'><b>Dados Profissionais</b></td>";
    echo "</tr>";
	echo "</table>";
	
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Admissão:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=dtad id=dtad";
		echo " value='$func[data_admissao_func]'";
		echo " maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "<td align=left class='text' width='100'><b>CBO:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=cbo id=cbo value='$func[cbo]'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>CTPS:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=ctps id=ctps value='$func[num_ctps_func]'></td>";
    echo "<td align=left class='text' width='100'><b>Série:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20  name=serie id=serie value='$func[serie_ctps_func]'></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Regime de Revezamento:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=revezamento id=revezamento value='$func[revezamento]'></td>";
    echo "<td align=left class='text' width='100'><b>Status:</b></td>";
    echo "<td align=left class='text' width='220'>";
    echo "<select name=status id=status class='inputText'>";
    echo "<option value='1' "; print $func[cod_status] ? "selected" : ""; echo " >Ativo</option>";
    echo "<option value='0' "; print $func[cod_status] ? "" : "selected"; echo " >Inativo</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Demissão:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=dtdm id=dtdm";
		echo " value='$func[data_desligamento_func]'";
		echo " maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "<td align=left class='text' width='100'><b>Último exame</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=data_ultimo_exame id=data_ultimo_exame value='$func[data_ultimo_exame]' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Função:</b></td>";
    echo "<td align=left class='text' colspan=3 class='inputText'>";
    $sql_funcao = "SELECT * FROM funcao order by nome_funcao";
	$result_funcao = pg_query($sql_funcao);
	$rr = pg_fetch_all($result_funcao);
	for($x=0;$x<count($rr);$x++){
	   $txt .= urlencode($rr[$x][dsc_funcao])."|";
    }
	echo "<select name=\"cod_funcao\" id=\"cod_funcao\" onChange=\"funcao('{$txt}');\">";
	while($row_funcao = pg_fetch_array($result_funcao)){
		$tmp.= $row_funcao[cod_funcao]." - ";
		echo"<option ";
        print $func[cod_funcao]==$row_funcao[cod_funcao] ? " selected " : " " ;
        echo " value='$row_funcao[cod_funcao]'>  ".ucwords(strtolower($row_funcao[nome_funcao]))."</option>";
        if($func[cod_funcao]==$row_funcao[cod_funcao]){
            $din = $row_funcao[dsc_funcao];
        }
    }
	echo "</select>";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Dinâmica da Função:</b></td>";
    echo "<td align=left class='text' colspan=3>";
    echo "<textarea id='dinamica_funcao' name='dinamica_funcao' class='inputText' rows=2 cols=50 class='fonte'>$din</textarea>";
    echo "</td>";
    echo "</tr>";

    echo "</table>";
   
echo "<p>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSave' value='Alterar' onmouseover=\"showtip('tipbox', '- Alterar, armazenará todos os dados alterados do funcionário.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;&nbsp;&nbsp;";
   			echo "<input type='button' class='btn' name='aso' value='Gerar ASO' onclick=\"location.href='?dir=gerar_aso&p=gera_aso&cod_cliente=$_GET[cod_cliente]&setor={$func[cod_setor]}&funcionario={$func[cod_func]}';\" onmouseover=\"showtip('tipbox', '- Gerar ASO, irá gerar um novo ASO para o funcionário.');\" onmouseout=\"hidetip('tipbox');\" >";
			echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";
   
    echo "</form>";

    echo "<p>";
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>