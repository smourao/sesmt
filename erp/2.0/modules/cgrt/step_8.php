<?PHP
$sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
$result = pg_query($sql);
$cinfo = pg_fetch_array($result);

//Seleciona todos os setores cadastrados
$sql = "SELECT cod_setor, desc_setor, nome_setor FROM setor where cod_setor <> 0 ORDER BY nome_setor";
$res = pg_query($sql);
$set = pg_fetch_all($res);

/***************************************************************************************************/
// --> ADD NEW SETOR
/***************************************************************************************************/
if($_POST && $_POST[btnSaveNewSetores]){
    //
    $sql = "
    SELECT
        *
    FROM
        cliente_setor
    WHERE
        id_ppra = ".(int)($_GET[cod_cgrt])."
    AND
        cod_setor = ".(int)($_POST[cod_setor])."
    ";
    
    if(pg_num_rows(pg_query($sql))>0){
        showMessage('Não foi possível cadastrar o setor selecionado. Este setor já está cadastrado!',1);
        makelog($_SESSION[usuario_id], "[CGRT] Erro ao adicionar novo setor, setor já cadastrado, código do setor $_POST[cod_setor], código do relatório {$csdata[cod_cgrt]} e código do cliente ".addslashes($cinfo[cliente_id]), 104);
    }else{
        $sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
        $rcs = pg_query($sql);
        $csdata = pg_fetch_array($rcs);
        
        $sql = "INSERT INTO cliente_setor
            (cod_cliente, cod_setor, tipo_setor, cod_ppra, data_criacao, jornada, funcionario_id, id_ppra, elaborador_pcmso, is_posto_trabalho)
            values
            (".(int)($_GET[cod_cliente]).",
            ".(int)($_POST[cod_setor]).",
            '{$_POST[tipo_setor]}',
            {$csdata[cod_ppra]},'".$csdata[ano].date("-m-d")."', '{$csdata[jornada]}', {$csdata[id_resp_ppra]}, {$csdata[cod_cgrt]}, {$csdata[id_resp_pcmso]}, {$_POST[posto_trabalho]})";
            if(@pg_query($sql)){
                showMessage('Setor adicionado com sucesso!');
                makelog($_SESSION[usuario_id], "[CGRT] Adição de novo setor código $_POST[cod_setor] ao relatório código {$csdata[cod_cgrt]} do cliente ".addslashes($cinfo[cliente_id]), 102);
            }else{
                showMessage('Não foi possível cadastrar o setor selecionado. Por favor, entre em contato com o setor de suporte!',1);
                makelog($_SESSION[usuario_id], "[CGRT] Erro ao adicionar novo setor código $_POST[cod_setor] ao relatório código {$csdata[cod_cgrt]} do cliente ".addslashes($cinfo[cliente_id]), 103);
            }
    }
}

/***************************************************************************************************/
// --> FORM - CONFIGURAÇÃO DOS SETORES
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

    echo "<form method='POST' name='frmAddNewSetor'>";
    
    echo "<td class='text'><b>Configuração de setores:</b></td>";
    echo "<td class='text' width=155><b>Posto de trabalho:</b></td>";
    echo "<td class='text' width=120><b>Tipo:</b></td>";
    echo "</tr>";
    
    echo "<tr class='text roundbordermix'>";
    echo "<td align=left class='text roundborder'  onmouseover=\"showtip('tipbox', '- Selecione um dos setores listados, informe se este setor está localizado na empresa ou em um posto de trabalho fora da empresa e seu respectivo tipo.');\" onmouseout=\"hidetip('tipbox');\">";
        echo "Setor :&nbsp;";
        echo "<select name='cod_setor' style=\"width: 300px;\" class='inputTextobr'>";
            for($z=0;$z<pg_num_rows($res);$z++){
                echo "<option value='{$set[$z][cod_setor]}'"; print $_POST[cod_setor] == $set[$z][cod_setor] ? " selected " : ""; echo ">".substr($set[$z][nome_setor], 0, 71)."</option>";
            }
        echo "</select>";
    echo "</td>";
    echo "<td align=left class='text roundborder' width=120  onmouseover=\"showtip('tipbox', '- Selecione um dos setores listados e seu respectivo tipo.');\" onmouseout=\"hidetip('tipbox');\">";
        echo "<select name='posto_trabalho' id='posto_trabalho' class='inputTextobr' onchange=\"checkSetorConfig();\">";
            echo "<option value=0"; print $_POST[posto_trabalho] == 0 ? " selected ":""; echo ">Dentro da empresa</option>";
            echo "<option value=1"; print $_POST[posto_trabalho] == 1 ? " selected ":""; echo ">Fora da empresa</option>";
        echo "</select>";
    echo "</td>";
    echo "<td align=center class='text roundborder' width=120  onmouseover=\"showtip('tipbox', '- Selecione um dos setores listados e seu respectivo tipo.');\" onmouseout=\"hidetip('tipbox');\">";
        echo "<select name='tipo_setor' class='inputTextobr'> ";
        echo "<option value='Administrativo'"; print $_POST[tipo_setor] == 'Administrativo' ? " selected ":""; echo ">Administrativo</option>";
        echo "<option value='Operacional'"; print $_POST[tipo_setor] == 'Operacional' ? " selected ":""; echo ">Operacional</option>";
        echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<p>";
    
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 height=200>";
    echo "<tr>";
    echo "<td align=center class='text'>";
    echo "<b>&nbsp;</b>";
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
                echo "<input type='submit' class='btn' name='btnSaveNewSetores' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\">";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "<td>";
    echo "</tr>";
    echo "</table>";
    
    echo "</form>";

?>
