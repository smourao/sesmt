<?PHP
$sql = "SELECT c.razao_social, ti.*, cur.* FROM site_treinamento_info ti, cliente c, bt_cursos cur WHERE ti.cod_cliente = c.cliente_id AND ti.cod_curso = cur.id AND ti.cod_certificado = ".(int)($_GET[cod_certificado]);
$res = pg_query($sql);
$buffer = pg_fetch_array($res);

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<b>Detalhe de Treinamentos</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    //FORM - SAVE DATA
    echo "<form method=post id='frmdetailtreinamento' name='frmdetailtreinamento'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Certificado:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_certificado id=cod_certificado value='".str_pad($buffer[cod_certificado], 3, "0",0)."' readonly></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='140'>Cliente:</td>";
    echo "<td align=left class=text width='500'><b>$buffer[razao_social]</b></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='140'>$buffer[tipo_treinamento]:</td>";
    echo "<td align=left class=text width='500'>";
        $sql = "SELECT * FROM bt_cursos";
        $rcu = pg_query($sql);
        $cursos = pg_fetch_all($rcu);
        echo "<select name=cod_curso id=cod_curso class='inputTextobr'>";
        for($y=0;$y<pg_num_rows($rcu);$y++){
            echo "<option value='{$cursos[$y][cod_curso]}' "; print $cursos[$y][id]==$buffer[cod_curso] ? " selected ":""; echo " >{$cursos[$y][curso]}</option>";
        }
        echo "</select>";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='140'>Data de Início:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=10 name=data_inicio id=data_inicio value='".date("d/m/Y", strtotime($buffer[data_inicio]))."'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='140'>Data de Término:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=10 name=data_termino id=data_termino value='".date("d/m/Y", strtotime($buffer[data_termino]))."'></td>";
    echo "</tr>";


    echo "<tr>";
    echo "<td align=left class=text width='140'>Instrutor:</td>";
    echo "<td align=left class=text width='500'>{$buffer[nome_instrutor]}</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Status:</td>";
    echo "<td align=left class=text width='500'>";
        echo "<select name=status id=status>";
            echo "<option value='0' "; print $buffer[status] == 0 ? " selected ":""; echo "></option>";
            echo "<option value='1' "; print $buffer[status] == 1 ? " selected ":""; echo ">Impresso</option>";
            echo "<option value='2' "; print $buffer[status] == 2 ? " selected ":""; echo ">Enviado</option>";
        echo "</select>";
    echo "</td>";
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
            echo "<input type='button' class='btn' name='btnBackProd' value='Voltar' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]';\" onmouseover=\"showtip('tipbox', '- Voltar, retorna à lista de produtos.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='submit' class='btn' name='btnSaveProd' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='button' class='btn' name='btnDelProd' value='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir este produto?','')) location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]&cod_prod=$_GET[cod_prod]&del=1';\" onmouseover=\"showtip('tipbox', '- Excluir, remove este produto do cadastro.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";
?>
