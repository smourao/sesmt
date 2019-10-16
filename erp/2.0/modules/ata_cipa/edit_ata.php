<?PHP
if($_POST && $_POST[btnSaveEditAta]){
    $ano = explode("/", $_POST[gestao]);
    $data = explode("/", $_POST[data]);
    $hora = explode(":", $_POST[hora]);

    $sql = "UPDATE site_ata_cipa SET
    d_atan = '".$_POST[n_ata]."',
    d_ord = '".$_POST[tipo_reuniao]."',
    d_anoi = '{$ano[0]}',
    d_anof='{$ano[1]}',
    d_empresa='{$cdata[razao_social]}',
    d_end='{$cdata[endereco]}',
    d_num='{$cdata[num_end]}',
    d_cidade='{$cdata[municipio]}',
    d_municipio='{$cdata[municipio]}',
    d_estado='{$cdata[estado]}',
    d_dias='{$data[0]}',
    d_mes='{$data[1]}',
    d_ano='{$data[2]}',
    d_hora='{$hora[0]}',
    d_min='{$hora[1]}',
    d_sala='{$_POST[local]}',
    d_pres='{$_POST[presidente_cipa]}',
    d_vice='{$_POST[vice_presidente]}',
    d_suplente_cipa='{$_POST[suplente_cipa]}',
    d_svp='{$_POST[suplente_vice]}',
    d_sec='{$_POST[secretaria]}'
    WHERE id = {$_GET[id]}";
    
    if(pg_query($sql)){
        $sql = "SELECT * FROM site_ata_cipa WHERE id = $_GET[id]";
        $res = pg_query($sql);
        $atainfo = pg_fetch_array($res);
        showMessage('Dados atualizados com sucesso.');
        makelog($_SESSION[usuario_id], "Atualização de ata da CIPA número $_POST[n_ata].", 407);
    }else{
        showMessage('Não foi possivel criar esta ata da cipa. Por favor, entre em contato com o setor de suporte!');
        makelog($_SESSION[usuario_id], "Erro ao atualizar ata da CIPA número $_POST[n_ata].", 408);
    }
}

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
    echo "<option value='Ordinária'"; print $atainfo[d_ord] == 'Ordinária' ? " selected ":""; echo ">Ordinária</option>";
    echo "<option value='Extraordinária'"; print $atainfo[d_ord] == 'Extraordinária' ? " selected ":""; echo ">Extraordinária</option>";
    echo "</select>";
    echo "</td>";
    echo "<td align=left class=text width='100'>Gestão:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=9 maxlength=9 name=gestao id=gestao value='$atainfo[d_anoi]/$atainfo[d_anof]' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '####/####');\"></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='100'>Local:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=local id=local value='$atainfo[d_sala]'></td>";
    echo "<td align=left class=text width='100'>Nº Ata:</td>";
    echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=n_ata id=n_ata value='$atainfo[d_atan]' onkeydown=\"return only_number(event);\"></td>";
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
    echo "<td align=left class=text width='270'><input type='text' class='inputTextobr' size=9 maxlength=10 name=data id=data value='$atainfo[d_dias]/$atainfo[d_mes]/$atainfo[d_ano]' onkeydown=\"return only_number(event);\"  OnKeyPress=\"formatar(this, '##/##/####');\"></td>";
    echo "<td align=left class=text width='50'>Hora:</td>";
    echo "<td align=left class=text width='270'><input type='text' class='inputTextobr' size=5 maxlength=5 name=hora id=hora value='$atainfo[d_hora]:$atainfo[d_min]' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##:##');\"></td>";
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
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=presidente_cipa id=presidente_cipa value='$atainfo[d_pres]'></td>";
    echo "</tr><tr>";
    echo "<td align=left class=text width='160'>Suplente da CIPA:</td>";
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=suplente_cipa id=suplente_cipa value='$atainfo[d_suplente_cipa]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='160'>Vice Presidente:</td>";
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=vice_presidente id=vice_presidente value='$atainfo[d_vice]'></td>";
    echo "</tr><tr>";
    echo "<td align=left class=text width='160'>Suplente Vice Presidente:</td>";
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=suplente_vice id=suplente_vice value='$atainfo[d_svp]'></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=left class=text width='160'>Secretária da CIPA:</td>";
    echo "<td align=left class=text width='320'><input type='text' class='inputTextobr' size=35 name=secretaria id=secretaria value='$atainfo[d_sec]'></td>";
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
            echo "<input type='submit' class='btn' name='btnSaveEditAta' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";


?>
