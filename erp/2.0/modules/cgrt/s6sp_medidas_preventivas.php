<?PHP
/**********************************************************************************************/
// --> MEDIDAS PREVENTIVAS
// - Tabela para armazenamento: sugestao
// - Cód de campo tipo:
// .0 EPI
// .1 Medi
// .2 Curso
// .3 Ambiental
// .4 Programas
//OBS.:
//Esta tela é preenchida com os dados do setor e funcionários cadastrados no setor, se houver alguma alteração nos
//funcionarios do setor, esta tela pode sofrer alterações e não será atualizado na tabela sugestão... (verificar)
/**********************************************************************************************/
/**********************************************************************************************/
// --> POST -> SQL -> sugestao -> INSERT / UPDATE
/**********************************************************************************************/
if($_POST && $_POST[btnSaveMedPrev]){
    $error = 0;
    
    /**********************************************************************************************/
    //EPI
    /**********************************************************************************************/
    if(count($_POST[epi_id]) > 0){
        for($x=0;$x<count($_POST[epi_plano_acao]);$x++){
            //echo $_POST[epi_id][$x]." - ".$_POST[epi_plano_acao][$x]." - ".$_POST[epi_pa_data][$x]."<BR>";
            if($_POST[epi_pa_data][$x]){
                $data = explode("/", $_POST[epi_pa_data][$x]);
                $data = "'$data[1]-$data[0]-01'";
            }else{
                $data = 'null';
            }
            $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." AND med_prev = ".$_POST[epi_id][$x]." AND tipo_med_prev = 0";
            $res = @pg_query($sql);
            if(@pg_num_rows($res)){
                $sql = "UPDATE sugestao SET plano_acao = '".(int)($_POST[epi_plano_acao][$x])."', data = $data WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." AND med_prev = ".(int)($_POST[epi_id][$x])." AND tipo_med_prev = 0";
                if(@pg_query($sql)){
                    //nothing to do!
                }else{
                    $error++;
                }
            }else{
                $sql = "INSERT INTO sugestao
                (cod_setor, cod_cliente, med_prev, plano_acao, data, cod_produto, id_ppra, tipo_med_prev)
                VALUES
                (".(int)($_GET[cod_setor]).", ".(int)($_GET[cod_cliente]).", ".(int)($_POST[epi_id][$x]).", ".(int)($_POST[epi_plano_acao][$x]).", $data, ".(int)($_POST[epi_cod_prod][$x]).", ".(int)($_GET[cod_cgrt]).", 0)";
                if(@pg_query($sql)){
                    //nothing todo
                }else{
                    $error++;
                }
            }
        }
    }
    
    /**********************************************************************************************/
    //CURSO
    /**********************************************************************************************/
    if(count($_POST[cur_id]) > 0){
        for($x=0;$x<count($_POST[cur_plano_acao]);$x++){
            if($_POST[cur_pa_data][$x]){
                $data = explode("/", $_POST[cur_pa_data][$x]);
                $data = "'$data[1]-$data[0]-01'";
            }else{
                $data = 'null';
            }
            $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." AND tipo_med_prev = 2 and med_prev = {$_POST[cur_id][$x]}";
            $res = @pg_query($sql);
            if(@pg_num_rows($res)){
                $sql = "UPDATE sugestao SET plano_acao = '".(int)($_POST[cur_plano_acao][$x])."', data = $data WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." AND med_prev = {$_POST[cur_id][$x]} AND tipo_med_prev = 2";
				if(@pg_query($sql)){
                    //nothing to do!
                }else{
                    $error++;
                }
            }else{
                $sql = "INSERT INTO sugestao
                (cod_setor, cod_cliente, med_prev, plano_acao, data, cod_produto, id_ppra, tipo_med_prev)
                VALUES
                (".(int)($_GET[cod_setor]).", ".(int)($_GET[cod_cliente]).", ".(int)($_POST[cur_id][$x]).", ".(int)($_POST[cur_plano_acao][$x]).", $data, ".(int)($_POST[cur_cod_prod][$x]).", ".(int)($_GET[cod_cgrt]).", 2)";
                if(@pg_query($sql)){
                    //nothing todo
                }else{
                    $error++;
                }
            }
        }
    }
    
    /**********************************************************************************************/
    //AMBIENTAL
    /**********************************************************************************************/
    if(count($_POST[amb_id]) > 0){
        for($x=0;$x<count($_POST[amb_plano_acao]);$x++){
            if($_POST[amb_pa_data][$x]){
                $data = explode("/", $_POST[amb_pa_data][$x]);
                $data = "'$data[1]-$data[0]-01'";
            }else{
                $data = 'null';
            }
            $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." AND med_prev = ".$_POST[amb_id][$x]." AND tipo_med_prev = 3";
            $res = @pg_query($sql);
            if(@pg_num_rows($res)){
                $sql = "UPDATE sugestao SET plano_acao = '".(int)($_POST[amb_plano_acao][$x])."', data = $data WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." AND med_prev = ".(int)($_POST[amb_id][$x])." AND tipo_med_prev = 3";
                if(@pg_query($sql)){
                    //nothing to do!
                }else{
                    $error++;
                }
            }else{
                $sql = "INSERT INTO sugestao
                (cod_setor, cod_cliente, med_prev, plano_acao, data, cod_produto, id_ppra, tipo_med_prev)
                VALUES
                (".(int)($_GET[cod_setor]).", ".(int)($_GET[cod_cliente]).", ".(int)($_POST[amb_id][$x]).", ".(int)($_POST[amb_plano_acao][$x]).", $data, ".(int)($_POST[amb_cod_prod][$x]).", ".(int)($_GET[cod_cgrt]).", 3)";
                if(@pg_query($sql)){
                    //nothing todo
                }else{
                    $error++;
                }
            }
        }
    }
    
    /**********************************************************************************************/
    //PROGRAMAS
    /**********************************************************************************************/
    if(count($_POST[pro_id]) > 0){
        for($x=0;$x<count($_POST[pro_plano_acao]);$x++){
            if($_POST[pro_pa_data][$x]){
                $data = explode("/", $_POST[pro_pa_data][$x]);
                $data = "'$data[1]-$data[0]-01'";
            }else{
                $data = 'null';
            }
            $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." AND med_prev = ".$_POST[pro_id][$x]." AND tipo_med_prev = 4";
            $res = @pg_query($sql);
            if(@pg_num_rows($res)){
                $sql = "UPDATE sugestao SET plano_acao = '".(int)($_POST[pro_plano_acao][$x])."', data = $data WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." AND med_prev = ".(int)($_POST[pro_id][$x])." AND tipo_med_prev = 4";
                if(@pg_query($sql)){
                    //nothing to do!
                }else{
                    $error++;
                }
            }else{
                $sql = "INSERT INTO sugestao
                (cod_setor, cod_cliente, med_prev, plano_acao, data, cod_produto, id_ppra, tipo_med_prev)
                VALUES
                (".(int)($_GET[cod_setor]).", ".(int)($_GET[cod_cliente]).", ".(int)($_POST[pro_id][$x]).", ".(int)($_POST[pro_plano_acao][$x]).", $data, ".(int)($_POST[pro_cod_prod][$x]).", ".(int)($_GET[cod_cgrt]).", 4)";
                if(@pg_query($sql)){
                    //nothing todo
                }else{
                    $error++;
                }
            }
        }
    }
    
    /**********************************************************************************************/
    //SHOW RESULT
    /**********************************************************************************************/
    if($error){
        showMessage("Houve um problema ao atualizar os dados selecionados, <b>$error</b> campo(s) não foi(ram) armazenado(s). Por favor, entre em contato com o setor de suporte!", 2);
    }else{
        showMessage("Dados atualizados com sucesso!");
    }
}

echo "<form method=post name=frmMedidaSugerida id=frmMedidaSugerida onsubmit=\"return cgrt_mp_check_all(this);\">";

/**********************************************************************************************/
// --> EPI - FUNÇÃO UNION SETOR
/**********************************************************************************************/
$sql = "
SELECT id, descricao, cod_produto, 1 as t FROM funcao_epi WHERE cod_epi IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." GROUP BY cod_funcao ORDER BY cod_funcao)
UNION
SELECT id, descricao, cod_produto, 2 as t FROM setor_epi WHERE cod_setor = ".(int)($_GET[cod_setor]);
$repi = pg_query($sql);
if(pg_num_rows($repi) > 0 ){
    $epil = pg_fetch_all($repi);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>EPI:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    for($x=0;$x<pg_num_rows($repi);$x++){
        if($epil[$x][t] == 1)
            $tb = "[Função]";
        else
            $tb = "[Setor]";
        //faz uma pesquisa a cada item exibido buscando dados armazenados (caso haja)
        $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND tipo_med_prev = 0 AND med_prev = {$epil[$x][id]}";
        $rsu = pg_query($sql);
        $dmp = pg_fetch_array($rsu);
        echo "<input type=hidden name='epi_id[]' id='epi_id_{$epil[$x][id]}' value='{$epil[$x][id]}'>";
        echo "<input type=hidden name='epi_cod_prod[]' id='epi_cod_prod_{$epil[$x][id]}' value='{$epil[$x][cod_produto]}'>";
        echo "<tr class='roundbordermix'>";
        echo "<td align=left class='text roundborder curhand' alt='$tb ".addslashes($epil[$x][descricao])."' title='$tb ".addslashes($epil[$x][descricao])."'>".substr(addslashes($epil[$x][descricao]), 0, 70); if(strlen(addslashes($epil[$x][descricao])) > 70) echo "..."; echo "</td>";
        echo "<td align=center class='text roundborder' width=85>";
        echo "<select name='epi_plano_acao[]' id='epi_pa_{$epil[$x][id]}' onchange=\"cgrt_mp_chg_t(this, 'epi_data_{$epil[$x][id]}');\" class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "'>";
        echo "<option "; if(pg_num_rows($rsu)<=0) echo "selected"; echo " ></option>";
        echo "<option value='0' "; if($dmp[plano_acao] == 0 && pg_num_rows($rsu)>0) echo "selected"; echo " >Existente</option>";
        echo "<option value='1' "; if($dmp[plano_acao] == 1 && pg_num_rows($rsu)>0) echo "selected"; echo " >Sugerido</option>";
        echo "</select>";
        echo "</td>";
        echo "<td align=center class='text roundborder' width=70><input name='epi_pa_data[]' id='epi_data_{$epil[$x][id]}' onkeydown=\"return only_number(event);\" maxlength='7' OnKeyPress=\"formatar(this, '##/####');\" onkeyup=\"cgrt_mp_sugestao(this, 'epi_pa_{$epil[$x][id]}');\" class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "' type=text size=7 value='"; if($dmp[data]) echo date("m/Y", strtotime($dmp[data])); echo "' alt='mm/yyyy' title='mm/yyyy'></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p>";
}

/**********************************************************************************************/
// --> MEDI
/**********************************************************************************************/
/*
$sql = "
SELECT id, descricao, 1 as t FROM funcao_medi WHERE cod_medi IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." GROUP BY cod_funcao ORDER BY cod_funcao)
UNION
SELECT id, descricao, 2 as t FROM setor_medi WHERE cod_setor = ".(int)($_GET[cod_setor]);
$rmed = pg_query($sql);
if(pg_num_rows($rmed) > 0 ){
    $medl = pg_fetch_all($rmed);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>Medicamentos:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    for($x=0;$x<pg_num_rows($rmed);$x++){
        echo "<tr class='roundbordermix'>";
        echo "<td align=left class='text roundborder curhand' alt='".addslashes($medl[$x][descricao])."' title='".addslashes($medl[$x][descricao])."'>".substr(addslashes($medl[$x][descricao]), 0, 70)."</td>";
        echo "<td align=center class='text roundborder' width=85><select><option>Sugerido</option><option>Existente</option></select></td>";
        echo "<td align=center class='text roundborder' width=70><input type=text size=7></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p>";
}
*/

/**********************************************************************************************/
// --> CURSO
/**********************************************************************************************/
$sql = "
SELECT DISTINCT(descricao), 1 as t FROM funcao_curso WHERE cod_curso IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." GROUP BY cod_funcao ORDER BY cod_funcao)
UNION
SELECT DISTINCT(descricao), 2 as t FROM setor_curso WHERE cod_setor = ".(int)($_GET[cod_setor]);
$rcur = pg_query($sql);
if(pg_num_rows($rcur) > 0 ){
    $curl = pg_fetch_all($rcur);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>Curso:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    for($x=0;$x<pg_num_rows($rcur);$x++){
		$desc = "select id from funcao_curso where descricao like '%{$curl[$x][descricao]}%'";
		$dsc = pg_query($desc);
		$qry = pg_fetch_array($dsc);

        if($curl[$x][t] == 1)
            $tb = "[Função]";
        else
            $tb = "[Setor]";
        //faz uma pesquisa a cada item exibido buscando dados armazenados (caso haja)
        $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND tipo_med_prev = 2 AND med_prev = {$qry[id]} AND cod_setor = ".(int)($_GET[cod_setor]);
        $rsu = pg_query($sql);
        $dmp = pg_fetch_array($rsu);
        echo "<input type=hidden name='cur_id[]' id='cur_id_{$qry[id]}' value='{$qry[id]}'>";
        echo "<input type=hidden name='cur_cod_prod[]' id='cur_cod_prod_{$curl[$x][id]}' value='{$curl[$x][cod_produto]}'>";
        echo "<tr class='roundbordermix'>";
        echo "<td align=left class='text roundborder curhand' alt='$tb ".addslashes($curl[$x][descricao])."' title='$tb ".addslashes($curl[$x][descricao])."'>".substr(addslashes($curl[$x][descricao]), 0, 70); if(strlen(addslashes($curl[$x][descricao])) > 70) echo "..."; echo "</td>";
        echo "<td align=center class='text roundborder' width=85>";
        echo "<select name='cur_plano_acao[]' id='cur_pa_{$curl[$x][descricao]}' onchange=\"cgrt_mp_chg_t(this, 'cur_data_{$curl[$x][descricao]}');\" class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "'>";
        echo "<option "; if(pg_num_rows($rsu)<=0) echo "selected"; echo " ></option>";
        echo "<option value='0' "; if($dmp[plano_acao] == 0 && pg_num_rows($rsu)>0) echo "selected"; echo " >Existente</option>";
        echo "<option value='1' "; if($dmp[plano_acao] == 1 && pg_num_rows($rsu)>0) echo "selected"; echo " >Sugerido</option>";
        echo "</select>";
        echo "</td>";
        echo "<td align=center class='text roundborder' width=70><input name='cur_pa_data[]' id='cur_data_{$curl[$x][descricao]}' onkeydown=\"return only_number(event);\" maxlength='7' OnKeyPress=\"formatar(this, '##/####');\" onkeyup=\"cgrt_mp_sugestao(this, 'cur_pa_{$curl[$x][descricao]}');\" class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "' type=text size=7 value='"; if($dmp[data]) echo date("m/Y", strtotime($dmp[data])); echo "'></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p>";
}

/**********************************************************************************************/
// --> AMBIENTAL
/**********************************************************************************************/
$sql = "
SELECT id, descricao, 1 as t FROM funcao_ambiental WHERE cod_funcao IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." GROUP BY cod_funcao ORDER BY cod_funcao)
UNION
SELECT id, descricao, 2 as t FROM setor_ambiental WHERE cod_setor = ".(int)($_GET[cod_setor]);
$ramb = pg_query($sql);
if(pg_num_rows($ramb) > 0 ){
    $ambl = pg_fetch_all($ramb);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>Avaliações ambientais:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    for($x=0;$x<pg_num_rows($ramb);$x++){
        if($ambl[$x][t] == 1)
            $tb = "[Função]";
        else
            $tb = "[Setor]";

        //faz uma pesquisa a cada item exibido buscando dados armazenados (caso haja)
        $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND tipo_med_prev = 3 AND med_prev = {$ambl[$x][id]}";
        $rsu = pg_query($sql);
        $dmp = pg_fetch_array($rsu);
        echo "<input type=hidden name='amb_id[]' id='amb_id_{$ambl[$x][id]}' value='{$ambl[$x][id]}'>";
        echo "<input type=hidden name='amb_cod_prod[]' id='amb_cod_prod_{$ambl[$x][id]}' value='{$ambl[$x][cod_produto]}'>";
        echo "<tr class='roundbordermix'>";
        echo "<td align=left class='text roundborder curhand' alt='$tb ".addslashes($ambl[$x][descricao])."' title='$tb ".addslashes($ambl[$x][descricao])."'>".substr(addslashes($ambl[$x][descricao]), 0, 70); if(strlen(addslashes($ambl[$x][descricao])) > 70) echo "..."; echo "</td>";
        echo "<td align=center class='text roundborder' width=85>";
        echo "<select name='amb_plano_acao[]' id='amb_pa_{$ambl[$x][id]}' onchange=\"cgrt_mp_chg_t(this, 'amb_data_{$ambl[$x][id]}');\" class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "'>";
		echo "<option "; if(pg_num_rows($rsu)<=0) echo "selected"; echo " ></option>";
        echo "<option value='0' "; if($dmp[plano_acao] == 0 && pg_num_rows($rsu)>0) echo "selected"; echo " >Existente</option>";
        echo "<option value='1' "; if($dmp[plano_acao] == 1 && pg_num_rows($rsu)>0) echo "selected"; echo " >Sugerido</option>";
        echo "</select>";
        echo "</td>";
		echo "<td align=center class='text roundborder' width=70><input name='amb_pa_data[]' id='amb_data_{$ambl[$x][id]}' onkeydown=\"return only_number(event);\" maxlength='7' OnKeyPress=\"formatar(this, '##/####');\" onkeyup=\"cgrt_mp_sugestao(this, 'amb_pa_{$ambl[$x][id]}');\" class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "' type=text size=7 value='"; if($dmp[data]) echo date("m/Y", strtotime($dmp[data])); echo "'></td>";
		echo "</tr>";
    }
    echo "</table>";
    echo "<p>";
}

/**********************************************************************************************/
// --> PROGRAMAS
/**********************************************************************************************/
$sql = "
SELECT id, descricao, 1 as t FROM funcao_programas WHERE cod_funcao IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor])." GROUP BY cod_funcao ORDER BY cod_funcao)
UNION
SELECT id, descricao, 2 as t FROM setor_programas WHERE cod_setor = ".(int)($_GET[cod_setor]);
$rpro = pg_query($sql);
if(pg_num_rows($rpro) > 0 ){
    $prol = pg_fetch_all($rpro);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>Programas:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    for($x=0;$x<pg_num_rows($rpro);$x++){
        if($prol[$x][t] == 1)
            $tb = "[Função]";
        else
            $tb = "[Setor]";
        //faz uma pesquisa a cada item exibido buscando dados armazenados (caso haja)
        $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND tipo_med_prev = 4 AND med_prev = {$prol[$x][id]}";
        $rsu = pg_query($sql);
        $dmp = pg_fetch_array($rsu);
        echo "<input type=hidden name='pro_id[]' id='pro_id_{$prol[$x][id]}' value='{$prol[$x][id]}'>";
        echo "<input type=hidden name='pro_cod_prod[]' id='pro_cod_prod_{$prol[$x][id]}' value='{$prol[$x][cod_produto]}'>";
        echo "<tr class='roundbordermix'>";
        echo "<td align=left class='text roundborder curhand' alt='$tb ".addslashes($prol[$x][descricao])."' title='$tb ".addslashes($prol[$x][descricao])."'>".substr(addslashes($prol[$x][descricao]), 0, 70); if(strlen(addslashes($prol[$x][descricao])) > 70) echo "..."; echo "</td>";
        echo "<td align=center class='text roundborder' width=85>";
        echo "<select name='pro_plano_acao[]' id='pro_pa_{$prol[$x][id]}'onchange=\"cgrt_mp_chg_t(this, 'pro_data_{$prol[$x][id]}');\"  class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "'>";
        echo "<option "; if(pg_num_rows($rsu)<=0) echo "selected"; echo " ></option>";
        echo "<option value='0' "; if($dmp[plano_acao] == 0 && pg_num_rows($rsu)>0) echo "selected"; echo " >Existente</option>";
        echo "<option value='1' "; if($dmp[plano_acao] == 1 && pg_num_rows($rsu)>0) echo "selected"; echo " >Sugerido</option>";
        echo "</select>";
        echo "</td>";
        echo "<td align=center class='text roundborder' width=70><input name='pro_pa_data[]' id='pro_data_{$prol[$x][id]}' onkeydown=\"return only_number(event);\" maxlength='7' OnKeyPress=\"formatar(this, '##/####');\" onkeyup=\"cgrt_mp_sugestao(this, 'pro_pa_{$prol[$x][id]}');\" class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "' type=text size=7 value='"; if($dmp[data]) echo date("m/Y", strtotime($dmp[data])); echo "'></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p>";
}

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSaveMedPrev' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento.');\" onmouseout=\"hidetip('tipbox');\" >";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</td>";
echo "</form>";
    echo "</tr>";
echo "</table>";

?>
