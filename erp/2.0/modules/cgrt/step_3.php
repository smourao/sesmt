<?PHP
/***************************************************************************************************/
// --> LISTA / CADASTRO DE FUNCIONÁRIOS
/***************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<b>$cinfo[razao_social]</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados pessoais:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    if(is_numeric($_GET[fid])){
        $sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente]
    	AND cod_func = $_GET[fid]";
    	$result = pg_query($sql);
    	$func = pg_fetch_array($result);
    	$setadlist = explode("|", $func[setor_adicional]);
    	
    	//QUERY TO CHECK IF THE FUNC EXISTS IN THE CGRT_FUNC_TABLE FOR THIS ID_PPRA
        $sql = "SELECT f.nome_func, f.endereco_func, f.bairro_func, f.num_ctps_func, f.serie_ctps_func, f.cbo, f.sexo_func, f.data_nasc_func,
                f.cidade, f.naturalidade, f.nacionalidade, f.civil, f.cor, f.cpf, f.rg, f.cep, f.estado, f.img_url, f.pis, f.pdh, f.revezamento, f.cod_status,
                f.habilidade, cl.*, f.data_admissao_func FROM funcionarios f, cgrt_func_list cl
                WHERE
                f.cod_cliente = $_GET[cod_cliente]
                AND
                f.cod_cliente = cl.cod_cliente
                AND
                cl.cod_cgrt = $_GET[cod_cgrt]
                AND
                f.cod_func = $_GET[fid]
                AND
                f.cod_func = cl.cod_func";
        $rsq = pg_query($sql);
        //IF EXISTS
        if(pg_num_rows($rsq)>0){
            $func = pg_fetch_array($rsq);
        }else{
            $sql = "
            SELECT f.*
            FROM funcionarios f
            WHERE f.cod_cliente = $_GET[cod_cliente]
            AND f.cod_func = '$_GET[fid]'";
        	$result_func = pg_query($sql);
        	$func = pg_fetch_array($result_func);
    	}
	}
	
	
	//$funcdatanasc = date("d/m/Y", strtotime($func['data_nasc_func']));
	
	//$funcdataadmi = date("d/m/Y", strtotime($func['data_admissao_func']));
	
	
	
    echo "<form name=form1 method=post>";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>Nome:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=nome id=nome value=\"{$func[nome_func]}\"></td>";
    echo "<td align=right class=text width='100'>Sexo:</td>";
    echo "<td align=left class=text width='220'><select id=sexo name=sexo class='inputTextobr' ><option value='Masculino' ";
    print $func[sexo_func] == "Masculino" ? "selected" : "";
    echo " >Masculino</option><option value='Feminino' ";
    print $func[sexo_func] == "Feminino" ? "selected" : "";
    echo " >Feminino</option></select></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>RG:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=rg id=rg value='$func[rg]'></td>";
    echo "<td align=right class=text width='100'>CPF:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=cpf id=cpf value='$func[cpf]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>PIS:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=pis id=pis value='$func[pis]'></td>";
    echo "<td align=right class=text width='100'>BR/PDH:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=pdh id=pdh value='$func[pdh]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>CEP:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=cep id=cep value='$func[cep]'  onChange=\"show_cep(this.value);\" onkeyup=\"if(this.value.length == 5){this.value = this.value + '-';}else if(this.value.length >= 9){document.getElementById('natural').focus();}\"></td>";
    echo "<td align=right class=text width='100'>Endereço:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=endereco id=endereco value='$func[endereco_func]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>Bairro:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=bairro id=bairro value='$func[bairro_func]'></td>";
    echo "<td align=right class=text width='100'>Cidade:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=cidade id=cidade value='$func[cidade]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>Estado:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=estado id=estado value='$func[estado]'></td>";
    echo "<td align=right class=text width='100'>Natural:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=natural id=natural value='$func[natural]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>Nacionalidade:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=nacionalidade id=nacionalidade value='$func[nacionalidade]'></td>";
    echo "<td align=right class=text width='100'>Estado Civil:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=civil id=civil value='$func[civil]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>Nascimento:</td>";
	
	if($_GET[fid]){
	
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=nascimento id=nascimento value='$func[data_nasc_func]' maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";
	
	}else{
		
	echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=nascimento id=nascimento maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";
		
	}
	
    echo "<td align=right class=text width='100'>Cor:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=cor id=cor value='$func[cor]'></td>";
    echo "</tr>";
    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados Profissionais:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>Admissão:</td>";
	
	if($_GET[fid]){
	
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=20 name=admissao id=admissao value='$func[data_admissao_func]' maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";
	
	}else{
		
	echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=20 name=admissao id=admissao maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";	
		
	}
	
    echo "<td align=right class=text width='100'>CBO:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=cbo id=cbo value='$func[cbo]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>CTPS:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=20 name=ctps id=ctps value='$func[num_ctps_func]'></td>";
    echo "<td align=right class=text width='100'>Série:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=20  name=serie id=serie value='$func[serie_ctps_func]'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>Regime de Revezamento:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=revezamento id=revezamento value='$func[revezamento]'></td>";
    echo "<td align=right class=text width='100'>Status:</td>";
    echo "<td align=left class=text width='220'>";
    echo "<select name=status id=status class='inputTextobr' >";
    echo "<option value='1' "; print $func[cod_status] ? "selected" : ""; echo " >Ativo</option>";
    echo "<option value='0' "; print $func[cod_status] ? "" : "selected"; echo " >Inativo</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>Demissão:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=20 name=demissao id=demissao value='$func[data_desligamento_func]' maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";
    echo "<td align=right class=text width='100'>&nbsp;</td>";
    echo "<td align=left class=text width='220'>&nbsp;</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=text width='100'>Função:</td>";
    echo "<td align=left class=text colspan=3>";
    
    $sql_funcao = "SELECT * FROM funcao order by nome_funcao";
	$result_funcao = pg_query($sql_funcao);
	$rr = pg_fetch_all($result_funcao);
	$txt = "|";
	for($x=0;$x<count($rr);$x++){
	   $txt .= urlencode($rr[$x][dsc_funcao])."|";
    }
	echo "<select name=\"cod_funcao\" id=\"cod_funcao\" class='inputTextobr' onchange=\"func_cod('{$txt}', this, 'dinamica_funcao');\">";
    echo "<option value=''></option>";
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
    echo "<td align=right class=text width='100'>Dinâmica da Função:</td>";
    echo "<td align=left class=text colspan=3>";
    echo "<textarea id='dinamica_funcao' class='inputTextobr' name='dinamica_funcao' rows=2 cols=50 class='fonte'>$din</textarea>";
    echo "</td>";
    echo "</tr>";

    $sql = "SELECT c.*, s.* FROM cliente_setor c, setor s WHERE c.id_ppra = {$_GET[cod_cgrt]} AND c.cod_setor = s.cod_setor ORDER BY s.nome_setor";
    $res = pg_query($sql);
    $setores = pg_fetch_all($res);

    echo "<tr>";
    echo "<td align=right class=text width='100'>Setor Base:</td>";
    echo "<td align=left class=text colspan=3>";
        echo "<select name='setorbase' id='setorbase' class='inputText' style=\"width: 420px;\">";
            echo "<option value=''></option>";
            for($y=0;$y<pg_num_rows($res);$y++){
                echo "<option value='{$setores[$y][cod_setor]}' ";
                print $func[cod_setor]==$setores[$y][cod_setor] ? " selected " : " " ;
                echo ">{$setores[$y][nome_setor]}</option>";
            }
        echo "</select>";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=right class=text width='100'>Setor Adicional:</td>";
    echo "<td align=left class=text colspan=3>";
        echo "<select name='setoradicional[]' class='inputText' multiple='multiple' size=5 style=\"width: 420px;\">";
            for($y=0;$y<pg_num_rows($res);$y++){
                if($func[cod_setor] != $setores[$y][cod_setor]){
                    echo "<option value='{$setores[$y][cod_setor]}'";
                        if(is_array($setadlist))
                            if(in_array($setores[$y][cod_setor], $setadlist)) echo " selected ";
                    echo ">{$setores[$y][nome_setor]}</option>";
                }
            }
        echo "</select>";
    echo "</td>";
    echo "</tr>";
	
	echo "<tr>";
    echo "<td align=right class=text width='100'>Exigências/Habilidades:</td>";
    echo "<td align=left class=text colspan=3><input type='text' class='inputText' size=60 name=habilidade id=habilidade value='$func[habilidade]'></td>";
    echo "</tr>";
	
    echo "</table>";
            echo "</td>";
    echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSaveCadFunc' value='Salvar' onclick=\"return checkfuncfields();\" onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</td>";
    echo "</tr>";
echo "</table>";
echo "</form>";
?>
