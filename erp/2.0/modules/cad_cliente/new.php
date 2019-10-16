<?PHP
/************************************************************************************************/
/*                  ACTION: SAVE DATA!                                                          */
/************************************************************************************************/
	if($_POST){
        $sql = "SELECT max(cod_func) as max
    	FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente]";
    	$r = pg_query($sql);
    	$max = pg_fetch_array($r);
    	$max = $max[max] + 1;

$naorepetirsql = "SELECT num_ctps_func FROM funcionarios WHERE cod_cliente = ".$_GET[cod_cliente]." AND num_ctps_func = '".$_POST[ctps]."'";
$naorepetirquery = pg_query($naorepetirsql);
$naorepetir = pg_num_rows($naorepetirquery);

if($naorepetir >= 1){
	
	echo "Cliente com mesmo CTPS ja cadastrado!";
	
}else{
		
        $sql = "INSERT INTO funcionarios (cod_func, cod_cliente, nome_func, endereco_func, bairro_func, num_ctps_func, serie_ctps_func,
        cbo, cod_status, cod_funcao, sexo_func, data_nasc_func, data_admissao_func, data_desligamento_func, dinamica_funcao, cidade,
		naturalidade, nacionalidade, civil, cor, cpf, rg, cep, estado, pis, pdh, data_ultimo_exame)
        VALUES
        ('$max', '$_GET[cod_cliente]', '".ucwords(strtolower($_POST[nome]))."','".ucwords(strtolower($_POST[endereco]))."', '".ucwords(strtolower($_POST[bairro]))."',
        '".addslashes($_POST[ctps])."', '".addslashes($_POST[serie])."', '".addslashes($_POST[cbo])."', '".addslashes($_POST[status])."',
		'".addslashes($_POST[cod_funcao])."', '".addslashes($_POST[sexo])."', '$_POST[nascimento]', '$_POST[admissao]', '$_POST[demissao]',
		'".addslashes($_POST[dinamica_funcao])."', '".ucwords(strtolower($_POST[cidade]))."', '".ucwords(strtolower($_POST[natural]))."', '".ucwords(strtolower($_POST[nacionalidade]))."',
		'".addslashes($_POST[civil])."', '".addslashes($_POST[cor])."', '".addslashes($_POST[cpf])."', '".addslashes($_POST[rg])."', '".addslashes($_POST[cep])."',
		'".addslashes($_POST[estado])."', '".addslashes($_POST[pis])."', '".addslashes($_POST[pdh])."', '".addslashes($_POST[data_ultimo_exame])."')";
		if(@pg_query($sql)){
            showMessage('<p align=justify>Dados do funcionário cadastrado com sucesso!</p>', 0);
        }else{
            showMessage('<p align=justify>Erro ao cadastrar dados do funcionário!</p>', 2);
        }
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
        echo "<b>Cadastro de Funcionários</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

/************************************************************************************************/
/*                  ACTION: MAIN FORM!                                                          */
/************************************************************************************************/
    echo "<form name=form1 method=post>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 >";
    echo "<tr>";
    echo "<td class='text'><b>Dados Pessoais:</b></td>";
    echo "</tr>";
	echo "</table>";
	
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
    echo "<tr>";
    echo "<td align=left class='text' width=100><b>Nome:</b></td>";
    echo "<td align=left class='text' width=220><input type='text' class='inputText' size=35 name=nome id=nome ></td>";
    echo "<td align=left class='text' width=100><b>Sexo:</b></td>";
    echo "<td align=left class='text' width=100><select id=sexo name=sexo class='inputText' style=\"width: 100px\">
		  <option value='Masculino'>Masculino</option>
		  <option value='Feminino'>Feminino</option>
		  </select></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>RG:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=rg id=rg OnKeyPress=\"formatar(this, '########-#');\"></td>";
    echo "<td align=left class='text' width='100'><b>CPF:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=cpf id=cpf maxlength='14' OnKeyPress=\"formatar(this, '###.###.###-##');\"></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>PIS:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=pis id=pis ></td>";
    echo "<td align=left class='text' width='100'><b>BR/PDH:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=pdh id=pdh ></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>CEP:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=cep id=cep maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" onblur=\"check_cep(this);\">&nbsp;<span id='verify_cep'></span></td>";
    echo "<td align=left class='text' width='100'><b>Endereço:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=endereco id=endereco ></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Bairro:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=bairro id=bairro ></td>";
    echo "<td align=left class='text' width='100'><b>Município:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=municipio id=municipio ></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Estado:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=estado id=estado ></td>";
    echo "<td align=left class='text' width='100'><b>Natural:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=natural id=natural ></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Nacionalidade:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=nacionalidade id=nacionalidade ></td>";
    echo "<td align=left class='text' width='100'><b>Estado Civil:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=civil id=civil ></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Nascimento:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=nascimento id=nascimento maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "<td align=left class='text' width='100'><b>Cor:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=cor id=cor ></td>";
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
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=admissao id=admissao maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "<td align=left class='text' width='100'><b>CBO:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=cbo id=cbo ></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>CTPS:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=ctps id=ctps required></td>";
    echo "<td align=left class='text' width='100'><b>Série:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20  name=serie id=serie ></td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Regime de Revezamento:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=revezamento id=revezamento ></td>";
    echo "<td align=left class='text' width='100'><b>Status:</b></td>";
    echo "<td align=left class='text' width='220'>";
    echo "<select name=status id=status class='inputText'>";
    echo "<option value='1'>Ativo</option>";
    echo "<option value='0'>Inativo</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
	
    echo "<tr>";
    echo "<td align=left class='text' width='100'><b>Demissão:</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=demissao id=demissao maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "<td align=left class='text' width='100'><b>Último exame</b></td>";
    echo "<td align=left class='text' width='220'><input type='text' class='inputText' size=20 name=data_ultimo_exame id=data_ultimo_exame maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
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
            echo "<input type='submit' class='btn' name='btnSave' value='Gravar' onmouseover=\"showtip('tipbox', '- Gravar, armazenará todos os dados do funcionário.');\" onmouseout=\"hidetip('tipbox');\" >";
            //echo "<input type='submit' class='btn' name='btnSave' value='TESTE' onclick=\"return showAlert('Mensagem de teste!');\" onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
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