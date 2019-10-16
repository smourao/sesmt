<?PHP
/************************************************************************************************/
/*                  ACTION: UPDATE DATA!                                                          */
/************************************************************************************************/
    if($_POST){
        $sql = "UPDATE funcionarios SET
        nome_func = '".addslashes($_POST[nome])."',
        endereco_func = '".addslashes($_POST[endereco])."', bairro_func = '".addslashes($_POST[bairro])."',
        num_ctps_func = '".addslashes($_POST[ctps])."', serie_ctps_func = '".addslashes($_POST[serie])."',
        cbo = '".addslashes($_POST[cbo])."', cod_status = '".addslashes($_POST[status])."',
        cod_funcao = '".addslashes($_POST[cod_funcao])."', sexo_func = '".addslashes($_POST[sexo])."',
        data_nasc_func = '".addslashes($_POST[nascimento])."', data_admissao_func = '".addslashes($_POST[admissao])."',
        data_desligamento_func = '".addslashes($_POST[demissao])."',
        dinamica_funcao = '".addslashes($_POST[dinamica_funcao])."', cidade = '".addslashes($_POST[cidade])."',
        naturalidade = '".addslashes($_POST[natural])."', nacionalidade = '".addslashes($_POST[nacionalidade])."',
        civil = '".addslashes($_POST[civil])."', cor = '".addslashes($_POST[cor])."',
        cpf = '".addslashes($_POST[cpf])."', rg = '".addslashes($_POST[rg])."',
        cep = '".addslashes($_POST[cep])."', estado = '".addslashes($_POST[estado])."', pis = '".addslashes($_POST[pis])."',
        pdh = '".addslashes($_POST[pdh])."', data_ultimo_exame = '".addslashes($_POST[data_ultimo_exame])."'
        WHERE cod_cliente = '$_GET[cod_cliente]' AND cod_func = '$_GET[cod_func]'";
        $res = pg_query($sql);
        if($res){
            echo "<script>alert('Dados atualizados!');</script>";
        }else{
            echo "<script>alert('Erro ao atualizar dados!');</script>";
        }
    }
/************************************************************************************************/
/*                  ACTION: MAIN FORM!                                                          */
/************************************************************************************************/
    $sql = "SELECT *
	FROM funcionarios
	WHERE cod_cliente = $_GET[cod_cliente]
	AND cod_func = $_GET[cod_func]";
	$result = pg_query($sql);
	$func = pg_fetch_array($result);
    echo "<form name=form1 method=post>";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class=fontebranca12 colspan=4><b>DADOS PESSOAIS</b></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Nome:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=35 name=nome id=nome value='$func[nome_func]'></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>Sexo:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><select id=sexo name=sexo><option value='Masculino' ";
    print $func[sexo_func] == "Masculino" ? "selected" : "";
    echo " >Masculino</option><option value='Feminino' ";
    print $func[sexo_func] == "Feminino" ? "selected" : "";
    echo " >Feminino</option></select></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>RG:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=rg id=rg value='$func[rg]'></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>CPF:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=cpf id=cpf value='$func[cpf]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>PIS:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=pis id=pis value='$func[pis]'></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>BR/PDH:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=pdh id=pdh value='$func[pdh]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>CEP:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=cep id=cep value='$func[cep]'  onChange=\"show_cep();\" onkeyup=\"if(this.value.length == 5){this.value = this.value + '-';}else if(this.value.length >= 9){document.getElementById('natural').focus();}\"></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>Endereço:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=endereco id=endereco value='$func[endereco_func]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Bairro:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=bairro id=bairro value='$func[bairro_func]'></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>Cidade:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=cidade id=cidade value='$func[cidade]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Estado:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=estado id=estado value='$func[estado]'></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>Natural:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=natural id=natural value='$func[natural]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Nacionalidade:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=nacionalidade id=nacionalidade value='$func[nacionalidade]'></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>Estado Civil:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=civil id=civil value='$func[civil]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Nascimento:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=nascimento id=nascimento value='$func[data_nasc_func]'  maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>Cor:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=cor id=cor value='$func[cor]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=center class=fontebranca12 colspan=4><b>&nbsp;</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=center class=fontebranca12 colspan=4><b>DADOS PROFISSIONAIS</b></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Admissão:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=admissao id=admissao value='$func[data_admissao_func]' maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>CBO:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=cbo id=cbo value='$func[cbo]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>CTPS:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=ctps id=ctps value='$func[num_ctps_func]'></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>Série:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20  name=serie id=serie value='$func[serie_ctps_func]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Regime de Revezamento:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=revezamento id=revezamento value='$func[revezamento]'></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>Status:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'>";
    echo "<select name=status id=status>";
    echo "<option value='1' "; print $func[cod_status] ? "selected" : ""; echo " >Ativo</option>";
    echo "<option value='0' "; print $func[cod_status] ? "" : "selected"; echo " >Inativo</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Demissão:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=demissao id=demissao value='$func[data_desligamento_func]' maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";
    echo "<td align=right class=fontebranca12 width='100'><b>Último exame</b></td>";
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=data_ultimo_exame id=data_ultimo_exame value='$func[data_ultimo_exame]' maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Função:</b></td>";
    echo "<td align=left class=fontebranca12 colspan=3>";
    $sql_funcao = "SELECT * FROM funcao order by nome_funcao";
	$result_funcao = pg_query($sql_funcao);
	$rr = pg_fetch_all($result_funcao);
	for($x=0;$x<count($rr);$x++){
	   $txt .= urlencode($rr[$x][dsc_funcao])."|";
    }
	echo "<select name=\"cod_funcao\" id=\"cod_funcao\" onChange=\"func_cod('{$txt}');\">";
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
    echo "<td align=right class=fontebranca12 width='100'><b>Dinâmica da Função:</b></td>";
    echo "<td align=left class=fontebranca12 colspan=3>";
    echo "<textarea id='dinamica_funcao' name='dinamica_funcao' rows=2 cols=50 class='fonte'>$din</textarea>";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=center class=fontebranca12 colspan=4>";
    echo "<input type=submit value='Gravar' name='gravar' style=\" width: 100px;\">";
    echo "&nbsp;";
    echo "<input type=button value='Gerar ASO' name='aso' style=\" width: 100px;\" onclick=\"location.href='../medico/gerar_aso.php?funcionario={$func[cod_func]}&cliente={$func[cod_cliente]}&setor={$func[cod_setor]}';\">";
    echo "</td>";
    echo "</tr>";

    echo "</table>";
    echo "</form>";

?>
