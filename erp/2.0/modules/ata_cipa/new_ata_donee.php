<?PHP

if(is_numeric($_GET[cod_cliente])){
    $sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)($_GET[cod_cliente]);
    $cdata = pg_fetch_array(pg_query($sql));
    
    $sql = "SELECT MAX(d_atan) as an FROM site_ata_cipa WHERe cod_cliente = ".(int)($_GET[cod_cliente]);
    $maxatan = pg_fetch_array(pg_query($sql));
    $maxatan = (int)($maxatan[an]) + 1;
    
    $sql = "SELECT * FROM site_ata_cipa WHERE cod_cliente = ".(int)($_GET[cod_cliente])." ORDER BY id DESC";
    $lastata = pg_fetch_array(pg_query($sql));
}
/********************************************************************************************/
//
/********************************************************************************************/
if($_POST && $_POST[btnSaveNewAta]){
    $ano = explode("/", $_POST[gestao]);
    $data = explode("/", $_POST[data]);
    $hora = explode(":", $_POST[hora]);
    
    echo $_POST[n_ata];

    $sql = "INSERT INTO site_ata_cipa (d_atan, d_ord, d_anoi, d_anof, d_empresa, d_end, d_num,
    d_cidade, d_municipio, d_estado, d_dias, d_mes, d_ano, d_hora, d_min, d_sala, d_pres, d_vice,
    d_suplente_cipa, d_svp, d_sec, cod_cliente, criacao) VALUES
    ('".$_POST[n_ata]."', '".$_POST[tipo_reuniao]."', '$ano[0]', '$ano[1]', '$cdata[razao_social]',
    '$cdata[endereco]', $cdata[num_end], '$cdata[municipio]', '$cdata[municipio]', '$cdata[estado]',
    '$data[0]', '$data[1]', '$data[2]', '$hora[0]', '$hora[1]', '$_POST[local]',
    '$_POST[presidente_cipa]', '$_POST[vice_presidente]', '$_POST[suplente_cipa]',
    '$_POST[suplente_vice]', '$_POST[secretaria]', '$cdata[cliente_id]', '".date("Y/m/d")."')";
    if(pg_query($sql)){
        $ret = pg_fetch_row($res);
        $sql = "SELECT max(id) as id FROM site_ata_cipa";
        $rmax = pg_fetch_array(pg_query($sql));
        makelog($_SESSION[usuario_id], "Nova ata da CIPA número $rmax[id] criada para $cdata[razao_social].", 405);
        redirectme("?dir=$_GET[dir]&p=$_GET[p]&sp=edit_ata&id=$rmax[id]");
    }else{
        showMessage('Não foi possivel criar esta ata da cipa. Por favor, entre em contato com o setor de suporte!');
        makelog($_SESSION[usuario_id], "Erro ao criar nova ata da CIPA.", 406);
    }
}
/********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<b>{$cdata[razao_social]}</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados da ata:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<form method=post id='frmcadata' name='frmcadata' onsubmit=\"return new_ata_check_fields(this);\">";

    echo "<table width=100% border=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Reunião:</td>";
    echo "<td align=left class=text width='220'>";
    echo "<select name='tipo_reuniao' id='tipo_reuniao' class='inputTextobr'>";
    echo "<option value='Ordinária'>Ordinária</option>";
    echo "<option value='Extraordinária'>Extraordinária</option>";
    echo "</select>";
    echo "</td>";
    echo "<td align=left class=text width='100'>Gestão:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=9 maxlength=9 name=gestao id=gestao value='' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '####/####');\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Local:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=local id=local value='$cdata[nome_fantasia]'></td>";
    echo "<td align=left class=text width='100'>Nº Ata:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name='n_ata' id='n_ata' value='$maxatan' onkeydown=\"return only_number(event);\"></td>";
    echo "</tr>";


    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Data da reunião:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='50'>Data:</td>";
    echo "<td align=left class=text width='270'><input type='text' class='inputTextobr' size=9 maxlength=10 name=data id=data value='".date("d/m/Y")."' onkeydown=\"return only_number(event);\"  OnKeyPress=\"formatar(this, '##/##/####');\"></td>";
    echo "<td align=left class=text width='50'>Hora:</td>";
    echo "<td align=left class=text width='270'><input type='text' class='inputTextobr' size=5 maxlength=5 name=hora id=hora value='' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##:##');\"></td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Participantes:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% border=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class=text width='160'>Presidente da CIPA:</td>";
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=presidente_cipa id=presidente_cipa value='$lastata[d_pres]'></td>";
    echo "</tr><tr>";
    echo "<td align=left class=text width='160'>Suplente da CIPA:</td>";
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=suplente_cipa id=suplente_cipa value='$lastata[d_suplente_cipa]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='160'>Vice Presidente:</td>";
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=vice_presidente id=vice_presidente value='$lastata[d_vice]'></td>";
    echo "</tr><tr>";
    echo "<td align=left class=text width='160'>Suplente Vice Presidente:</td>";
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=suplente_vice id=suplente_vice value='$lastata[d_svp]'></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='160'>Secretária da CIPA:</td>";
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=secretaria id=secretaria value='$lastata[d_sec]'></td>";
    echo "</tr>";

    echo "</table>";
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
            echo "<input type='submit' class='btn' name='btnSaveNewAta' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";

?>
