<?PHP
//get func data
$sql = "
    SELECT
        f.*, c.*
    FROM
        funcionarios f, cliente c
    WHERE
        f.cod_cliente = {$_GET[cod_cliente]}
    AND
        f.cod_func = {$_GET[fid]}
    AND
        f.cod_cliente = c.cliente_id
";
$res = pg_query($sql);
$buffer = pg_fetch_array($res);


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
    echo "<form method=post>";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Razão Social:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=razao_social id=razao_social value='$buffer[razao_social]'></td>";
    echo "<td align=left class=text width='100'>CNPJ:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=18 name=cnpj id=cnpj value='$buffer[cnpj]' maxlength='18'></td>";
    echo "</tr>";

    /*
    echo "<tr>";
    echo "<td align=left class=text width='100'>Insc. Estadual:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=insc_estadual id=insc_estadual value='$buffer[insc_estadual]' maxlength='10' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###');\"></td>";
    echo "<td align=left class=text width='100'>Insc. Municipal:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=insc_municipal id=insc_municipal value='$buffer[insc_municipal]' maxlength='10' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '###.###-##');\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Grupo:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=grupo_cipa id=grupo_cipa value='$buffer[grupo_cipa]'></td>";
    echo "<td align=left class=text width='100'>Grau Risco:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=grau_risco id=grau_risco value='$buffer[grau_risco]' maxlength='2' onkeydown=\"return only_number(event);\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Atividade:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=descricao_atividade id=descricao_atividade value='$buffer[descricao_atividade]'></td>";
    echo "<td align=left class=text width='100'>Nº Funcionário:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=numero_funcionarios id=numero_funcionarios value='$buffer[numero_funcionarios]' onkeydown=\"return only_number(event);\" onBlur=\"check_brigada(this);\">&nbsp;<span id='verify_brigada'></span></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Memb. Brigada:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=membros_brigada id=membros_brigada value='$membros' onkeydown=\"return only_number(event);\"></td>";
    echo "<td align=left class=text width='100'>CIPA:</td>";
    echo "<td align=left class=text width='220'><input style=\"text-align:center;\"  type='text' class='inputTextobr' size=5 name=membros_cipa id=membros_cipa value='$membros_cipa'></td>";
    echo "</tr>";
    */
    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<BR>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados do funcionário:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Nome:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=nome id=nome value='$buffer[nome]'></td>";
    echo "<td align=left class=text width='100'>CBO:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=5 name=cbo id=cbo value='$buffer[cbo]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Função:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=18 name=cnpj id=cnpj value='$buffer[cnpj]' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\" "; if(!is_numeric($_GET[cod_cliente])) echo " onBlur=\"check_cnpj_cliente(this);\" "; echo ">&nbsp;<span id='verify_cnpj' class=''></span></td>";
    echo "<td align=left class=text width='100'>Dinâmica da Função:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=cnae id=cnae value='$buffer[cnae]'  maxlength='7' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.##-#');\" onBlur=\"check_cnae(this);\">&nbsp;<span id='verify_cnae'></span></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>CTPS:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=insc_estadual id=insc_estadual value='$buffer[insc_estadual]' maxlength='10' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###');\"></td>";
    echo "<td align=left class=text width='100'>Série:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputText' size=18 name=insc_municipal id=insc_municipal value='$buffer[insc_municipal]' maxlength='10' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '###.###-##');\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Classificação Atividade:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=grupo_cipa id=grupo_cipa value='$buffer[grupo_cipa]'></td>";
    echo "<td align=left class=text width='100'>Nível Tolerância:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=grau_risco id=grau_risco value='$buffer[grau_risco]' maxlength='2' onkeydown=\"return only_number(event);\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Tipo Exame:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=descricao_atividade id=descricao_atividade value='$buffer[descricao_atividade]'></td>";
    echo "<td align=left class=text width='100'>Resultado:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=numero_funcionarios id=numero_funcionarios value='$buffer[numero_funcionarios]' onkeydown=\"return only_number(event);\" onBlur=\"check_brigada(this);\">&nbsp;<span id='verify_brigada'></span></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";



?>
