<script language="javascript">
function check_name(name){
    var url = "check_name.php?name="+name;
    url = url + "&cod_cliente=<?PHP echo $_GET[cod_cliente];?>";
    url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
    http.open("GET", url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
    http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
    http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
    http.setRequestHeader("Pragma", "no-cache");
    http.onreadystatechange = find_cliente_result;
    http.send(null);
}

function find_cliente_result(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    document.getElementById('sgt').innerHTML = msg;
}else{
    if (http.readyState==1){
       document.getElementById('sgt').style.display = 'block';
    }
 }
}
</script>
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

        $sql = "INSERT INTO funcionarios (cod_func, cod_cliente, nome_func, endereco_func, bairro_func, num_ctps_func, serie_ctps_func,
        cbo, cod_status, cod_funcao, sexo_func, data_nasc_func, data_admissao_func, data_desligamento_func,
        dinamica_funcao, cidade, naturalidade, nacionalidade, civil, cor, cpf, rg, cep, estado, pis, pdh, data_ultimo_exame)
        VALUES
        ('$max', '$_GET[cod_cliente]', '".addslashes($_POST[nome])."','".addslashes($_POST[endereco])."', '".addslashes($_POST[bairro])."',
        '".addslashes($_POST[ctps])."', '".addslashes($_POST[serie])."', '".addslashes($_POST[cbo])."',
        '".addslashes($_POST[status])."', '".addslashes($_POST[cod_funcao])."', '".addslashes($_POST[sexo])."',
        '".addslashes($_POST[nascimento])."', '".addslashes($_POST[admissao])."',
        '".addslashes($_POST[demissao])."', '".addslashes($_POST[dinamica_funcao])."', '".addslashes($_POST[cidade])."',
        '".addslashes($_POST[natural])."', '".addslashes($_POST[nacionalidade])."',
        '".addslashes($_POST[civil])."', '".addslashes($_POST[cor])."',
        '".addslashes($_POST[cpf])."', '".addslashes($_POST[rg])."',
        '".addslashes($_POST[cep])."', '".addslashes($_POST[estado])."', '".addslashes($_POST[pis])."',
        '".addslashes($_POST[pdh])."', '".addslashes($_POST[data_ultimo_exame])."')";
        $res = pg_query($sql);
        if($res){
            echo "
            <script>
            alert('Funcionário cadastrado!');
            location.href='?cod_cliente=$_GET[cod_cliente]&cod_filial=$_GET[cod_filial]';
            </script>
            ";
        }else{
            echo "<script>alert('Erro ao cadastrar funcionário!');</script>";
        }
    }
/************************************************************************************************/
/*                  ACTION: MAIN FORM!                                                          */
/************************************************************************************************/

    echo "<form name=form1 method=post>";
    echo "<input type='hidden' name=cod_max value='$max'>";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class=fontebranca12 colspan=4><b>DADOS PESSOAIS</b></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Nome:</b></td>";
    echo "<td align=left class=fontebranca12 width='220'>
    <input type='text' size=35 name=nome id=nome value='$func[nome_func]' onkeyup=\"check_name(this.value);\">";
    echo '
    <div id=sgt name=sgt style="display: none;position: absolute; border: 0px solid; width: 300px;background-color: #009966;">
    <center><font size=1 color=white><i>Atualizando...</i></font></center>
    </div>';
    echo "</td>";
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
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=cep id=cep value='$func[cep]' onChange=\"show_cep();\" onkeyup=\"if(this.value.length == 5){this.value = this.value + '-';}else if(this.value.length >= 9){document.getElementById('natural').focus();}\"></td>";
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
    echo "<td align=left class=fontebranca12 width='220'><input type='text' size=20 name=nascimento id=nascimento value='$func[data_nasc_func]' maxlength=10 onkeypress=\"formataDataDigitada(this);\"></td>";
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
    echo "<option value='0' "; print $func[cod_status] ? "" : ""; echo " >Inativo</option>";
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
	echo "&nbsp;";
    echo "<input type=button value='Nova Função' style=\"width:100px; height:23px;\" onclick=\"javascript:window.open('../producao/cad_funcao.php','_blank');\">";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100'><b>Dinâmica da Função:</b></td>";
    echo "<td align=left class=fontebranca12 colspan=3>";
    echo "<textarea id='dinamica_funcao' name='dinamica_funcao' rows=2 cols=50 class='fonte'>$din</textarea>";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=right class=fontebranca12 width='100' colspan=2>";
    echo "<input type=submit value='Gravar' name='gravar'>";
    echo "</td>";
    echo "</tr>";

    echo "</table>";
    echo "</form>";

?>
