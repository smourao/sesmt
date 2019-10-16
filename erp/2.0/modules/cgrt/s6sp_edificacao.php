<?PHP
//print_r($_POST);
/**********************************************************************************************/
// --> QUERY - ARMAZENA DADOS NO CLIENTE_SETOR
/**********************************************************************************************/
$ris = $_POST['c_mental'];
$num = count($ris);

for($x=0;$x<$num;$x++){
	$mental .= $ris[$x]."|";
}

if($_POST && $_POST[btnSaveEdif]){
    if(is_numeric($_GET[cod_cgrt]) && is_numeric($_GET[cod_setor])){
        $sql = "UPDATE cliente_setor
    				SET
                    cod_luz_nat            = ".(int)($_POST[luz_natural])."
    				,cod_luz_art           = ".(int)($_POST[luz_artificial])."
    				, cod_vent_nat         = ".(int)($_POST[vent_natural])."
    				, cod_vent_art         = ".(int)($_POST[vent_artificial])."
    				, cod_edificacao       = ".(int)($_POST[tipo_edificacao])."
    				, cod_piso             = ".(int)($_POST[tipo_piso])."
    				, cod_parede           = ".(int)($_POST[tipo_parede])."
    				, cod_cobertura        = ".(int)($_POST[tipo_cobertura])."
    				, turno            	   = ".$_POST[turno]."
    				, ruido_fundo_setor    = ".$_POST[ruido_fundo]."
    				, ruido_operacao_setor = ".$_POST[ruido_operacao]."
    				, ruido                = ".(int)($_POST[aparelho_ruido])."
    				, temperatura          = ".(int)($_POST[calor])."
    				, umidade              = ".(int)($_POST[umidade])."
    				, termico              = ".(int)($_POST[aparelho_temperatura])."
    				, id_pt                = ".(int)($_POST[id_pt])."
    				, ibtug_t        	    = ".(int)($_POST[ibtug_t])."
    				, ibtug_d          		= ".(int)($_POST[ibtug_d])."
    				, tempo_t				= ".(int)($_POST[tempo_t])."
    				, tempo_d          		= ".(int)($_POST[tempo_d])."
					, c_mental			   = '$mental'
					, caracterizacao	   = '$caracterizacao'
					, sintoma			   = '$sintoma'
					, m_ctr_existente	   = '$m_ctr_existente'
					, fonte_geradora	   = '$fonte_geradora'
					, m_ctr_trabalhador	   = '$m_ctr_trabalhador'
					, m_carga			   = '$m_carga'
					, desloc			   = '$desloc'
    				WHERE id_ppra          = $_GET[cod_cgrt]
                    AND cod_setor          = $_GET[cod_setor]";
        if(pg_query($sql)){
            showMessage('Dados atualizados com sucesso!');
        }else{
            showMessage('Houve um problema ao armazenar as informações. Por favor, entre em contato com o setor de suporte!',1);
        }
    }else{
        showMessage('Houve um problema ao armazenar as informações por inconsistência dos dados [cod_cgrt/cod_setor]. Por favor, entre em contato com o setor de suporte!',1);
    }
    //print_r($_POST);
}
/**********************************************************************************************/
// --> QUERY - BUSCA DADOS GRAVADOS NO CLIENTE_SETOR
/**********************************************************************************************/
if(is_numeric($_GET[cod_cgrt]) && is_numeric($_GET[cod_setor])){
    $sql = "SELECT * FROM cliente_setor WHERE id_ppra = $_GET[cod_cgrt] AND cod_setor = $_GET[cod_setor]";
    $edifdata = pg_fetch_array(pg_query($sql));
}else{
    showMessage('Houve um problema ao obter as informações por inconsistência dos dados [cod_cgrt/cod_setor]. Por favor, entre em contato com o setor de suporte!',2);
}
/**********************************************************************************************/
// --> DIV's EXIBIÇÃO DE VENT ARTIFICIAL
/**********************************************************************************************/
echo "<div id='ar' class=\"cgrt_edif_popup roundborderselected\">";

echo "<table width=500 align=center cellspacing=2 cellpadding=2 class='roundborderselectedinv'>";
echo "<tr>";
echo "<td class='text' align=center colspan=2><b>Informações adicionais sobre a qualidade do ar</b></td>";
echo "</tr>";
echo "</table>";
echo "<table width=500 height=300 align=center cellspacing=2 cellpadding=2 class='text'>";
echo "<tr>";
echo "<td class='text' width=230>Nº de aparelhos:</td>";
echo "<td class='text'><input size=5 name='n_aparelhos' id='n_aparelhos' value='$edifdata[num_aparelhos]' class='inputTextobr' onkeydown=\"return only_number(event);\" onkeypress=\"document.getElementById('notif_n_aparelhos').style.display = 'none';\">&nbsp;<span id='notif_n_aparelhos' style=\"display: none;\" class='text10 roundborderselectedred'>Obrigatório!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Marca:</td>";
echo "<td class='text'><input name='marca_aparelho' id='marca_aparelho' value='$edifdata[marca]' class='inputTextobr' onkeypress=\"document.getElementById('notif_marca_aparelho').style.display = 'none';\">&nbsp;<span id='notif_marca_aparelho' style=\"display: none;\" class='text10 roundborderselectedred'>Obrigatório!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Modelo:</td>";
echo "<td class='text'><input name='modelo_aparelho' id='modelo_aparelho' value='$edifdata[modelo]' class='inputTextobr' onkeypress=\"document.getElementById('notif_modelo_aparelho').style.display = 'none';\">&nbsp;<span id='notif_modelo_aparelho' style=\"display: none;\" class='text10 roundborderselectedred'>Obrigatório!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Capacidade:</td>";
echo "<td class='text'><input name='capacidade_aparelho' id='capacidade_aparelho' value='$edifdata[capacidade]' class='inputTextobr' onkeypress=\"document.getElementById('notif_capacidade_aparelho').style.display = 'none';\">&nbsp;<span id='notif_capacidade_aparelho' style=\"display: none;\" class='text10 roundborderselectedred'>Obrigatório!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Última limpeza dos filtros:</td>";
echo "<td class='text'><input size=9 name='ult_limpeza_filtros' id='ult_limpeza_filtros' value='"; print $edifdata[dt_ventilacao] ? date("d/m/Y", strtotime($edifdata[dt_ventilacao])) : ""; echo "' class='inputTextobr' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##/##/####');document.getElementById('notif_ult_limpeza_filtros').style.display = 'none';\" maxlength=10>&nbsp;<span id='notif_ult_limpeza_filtros' style=\"display: none;\" class='text10 roundborderselectedred'>Formato inválido!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Última limpeza dos dutos:</td>";
echo "<td class='text'><input size=9 name='ult_limpeza_dutos' id='ult_limpeza_dutos' value='"; print $edifdata[ultima_limpeza_duto] ? date("d/m/Y", strtotime($edifdata[ultima_limpeza_duto])) : ""; echo "' class='inputTextobr' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##/##/####');document.getElementById('notif_ult_limpeza_dutos').style.display = 'none';\" maxlength=10>&nbsp;<span id='notif_ult_limpeza_dutos' style=\"display: none;\" class='text10 roundborderselectedred'>Formato inválido!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Próxima limpeza dos filtros:</td>";
echo "<td class='text'><input size=9 name='prox_limpeza_filtros' id='prox_limpeza_filtros' value='"; print $edifdata[proxima_limpeza_mecanica] ? date("d/m/Y", strtotime($edifdata[proxima_limpeza_mecanica])) : "";  echo "' class='inputTextobr' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##/##/####');document.getElementById('notif_prox_limpeza_filtros').style.display = 'none';\" maxlength=10>&nbsp;<span id='notif_prox_limpeza_filtros' style=\"display: none;\" class='text10 roundborderselectedred'>Formato inválido!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Próxima limpeza dos dutos:</td>";
echo "<td class='text'><input size=9 name='prox_limpeza_dutos' id='prox_limpeza_dutos' value='"; print $edifdata[proxima_limpeza_duto] ? date("d/m/Y", strtotime($edifdata[proxima_limpeza_duto])) : ""; echo "' class='inputTextobr' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##/##/####');document.getElementById('notif_prox_limpeza_dutos').style.display = 'none';\" maxlength=10>&nbsp;<span id='notif_prox_limpeza_dutos' style=\"display: none;\" class='text10 roundborderselectedred'>Formato inválido!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Empresa prestadore do serviço:</td>";
echo "<td class='text'><input size=30 name='empresa_prestadora_servico' id='empresa_prestadora_servico' value='{$edifdata[empresa_servico]}' class='inputTextobr'></td>";
echo "</tr>";
echo "</table>";

echo "<table width=500 align=center cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text' align=center colspan=2 class='roundbordermix'>";
echo "<input class='btn' type=button value='Salvar' name='btnSaveArInfo' id='btnSaveArInfo' onclick=\"save_cgrt_vent_art($_GET[cod_cgrt], $_GET[cod_setor]);\">";
echo "&nbsp;";
echo "<input class='btn' type=button value='Cancelar' name='btnCancelArInfo' id='btnCancelArInfo' onclick=\"hide_cgrt_edif_vent_art();\">";
echo "</td>";
echo "</tr>";
echo "</table>";
echo '</div>';


//AR PORTÁTIL
echo "<div id='port' class='cgrt_edif_popup roundborderselected'>";
echo "<table width=500 align=center cellspacing=2 cellpadding=2 class='roundborderselectedinv'>";
echo "<tr>";
echo "<td class='text' align=center colspan=2><b>Informações adicionais sobre a qualidade do ar</b></td>";
echo "</tr>";
echo "</table>";

echo "<table width=500 height=300 align=center cellspacing=2 cellpadding=2 class='text'>";
echo "<tr>";
echo "<td class='text' width=230>Última higienização mecânica:</td>";
echo "<td class='text' width=270><input size=9 name='ult_higienizacao_mec' id='ult_higienizacao_mec' value='"; print $edifdata[dt_ventilacao] ? date("d/m/Y", strtotime($edifdata[dt_ventilacao])) : ""; echo"' class='inputTextobr' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##/##/####');document.getElementById('notif_ult_higienizacao_mec').style.display = 'none';\" maxlength=10>&nbsp;<span id='notif_ult_higienizacao_mec' style=\"display: none;\" class='text10 roundborderselectedred'>Formato inválido!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Última limpeza de filtros:</td>";
echo "<td class='text' width=270><input size=9 name='ult_limpeza_filtros_portatil' id='ult_limpeza_filtros_portatil' value='"; print $edifdata[higiene] ? date("d/m/Y", strtotime($edifdata[higiene])) : ""; echo "' class='inputTextobr' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##/##/####');document.getElementById('notif_ult_limpeza_filtros_portatil').style.display = 'none';\" maxlength=10>&nbsp;<span id='notif_ult_limpeza_filtros_portatil' style=\"display: none;\" class='text10 roundborderselectedred'>Formato inválido!</span></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='text' width=230>Aparelho em área de circulação?</td>";
echo "<td class='text' width=270>";
echo "<select name='area_circulacao' id='area_circulacao' class='inputTextobr'>";
echo "<option value='0'"; print !$edifdata[ar_port_area_circulacao] ? " selected ":""; echo ">Não</option>";
echo "<option value='1'"; print  $edifdata[ar_port_area_circulacao] ? " selected ":""; echo ">Sim</option>";
echo "</select>";
echo "</td>";
echo "</tr>";
echo "<tr><td  height=100%></td><td width=270></td></tr>";
echo "</table>";

echo "<table width=500 align=center cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text' align=center colspan=2 class='roundbordermix'>";
echo "<input class='btn' type=button value='Salvar' name='btnSaveArInfo' id='btnSaveArInfo' onclick=\"save_cgrt_vent_port($_GET[cod_cgrt], $_GET[cod_setor]);\">";
echo "&nbsp;";
echo "<input class='btn' type=button value='Cancelar' name='btnCancelArInfo' id='btnCancelArInfo' onclick=\"hide_cgrt_edif_vent_art();\">";
echo "</td>";
echo "</tr>";
echo "</table>";
echo '</div>';

/**********************************************************************************************/
// --> EDIFICAÇÃO
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Edificação:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";

echo "<form method=post name=frmEdificacao id=frmEdificacao onsubmit=\"return cgrt_edif_cf(this);\">";

echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
	echo "<tr>";
		echo "<td align=left class='text' width=150>Turno:&nbsp;</td>";
		echo "<td class='text' width=490><select class='inputTextobr' name='turno' id='turno' >";
			echo "<option value=''></option>";
			echo "<option value='1'"; print $edifdata[turno] == '1' ? " selected ":""; echo ">Diurno</option>";
			echo "<option value='2'"; print $edifdata[turno] == '2' ? " selected ":""; echo ">Noturno</option>";
			echo "<option value='3'"; print $edifdata[turno] == '3' ? " selected ":""; echo ">Diurno e Noturno</option>";
	echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Tipo de edificação:&nbsp;";
        echo "</td>";
        //query
        $sql = "SELECT * FROM tipo_edificacao ORDER BY descricao";
        $reste = pg_query($sql);
        $r_tipo_edif = pg_fetch_all($reste);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='tipo_edificacao' id='tipo_edificacao' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($reste);$x++){
                    echo "<option value='{$r_tipo_edif[$x][tipo_edificacao_id]}'"; print $edifdata[cod_edificacao] == $r_tipo_edif[$x][tipo_edificacao_id] ? " selected ":""; echo ">{$r_tipo_edif[$x][descricao]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Tipo de cobertura:&nbsp;";
        echo "</td>";
        //query
        $sql = "SELECT * FROM cobertura order by decicao_cobertura";
        $rcob = pg_query($sql);
        $r_tipo_cob = pg_fetch_all($rcob);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='tipo_cobertura' id='tipo_cobertura' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rcob);$x++){
                    echo "<option value='{$r_tipo_cob[$x][cod_cobertura]}'"; print $edifdata[cod_cobertura] == $r_tipo_cob[$x][cod_cobertura] ? " selected ":""; echo ">{$r_tipo_cob[$x][decicao_cobertura]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Tipo de parede:&nbsp;";
        echo "</td>";
        //query
        $sql = "SELECT * FROM parede order by decicao_parede";
        $rparede = pg_query($sql);
        $r_tipo_parede = pg_fetch_all($rparede);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='tipo_parede' id='tipo_parede' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rparede);$x++){
                    echo "<option value='{$r_tipo_parede[$x][cod_parede]}'"; print $edifdata[cod_parede] == $r_tipo_parede[$x][cod_parede] ? " selected ":""; echo ">{$r_tipo_parede[$x][decicao_parede]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    

    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Tipo de piso:&nbsp;";
        echo "</td>";
        //query
        $sql = "SELECT * FROM piso ORDER BY descricao_piso";
        $rpiso = pg_query($sql);
        $r_tipo_piso = pg_fetch_all($rpiso);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='tipo_piso' id='tipo_piso' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rpiso);$x++){
                    echo "<option value='{$r_tipo_piso[$x][cod_piso]}'"; print $edifdata[cod_piso] == $r_tipo_piso[$x][cod_piso] ? " selected ":""; echo ">{$r_tipo_piso[$x][descricao_piso]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";

    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";


/**********************************************************************************************/
// --> PISO
/**********************************************************************************************/
/*
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Piso:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Tipo de piso:&nbsp;";
        echo "</td>";
        //query
        $sql = "SELECT * FROM piso ORDER BY descricao_piso";
        $rpiso = pg_query($sql);
        $r_tipo_piso = pg_fetch_all($rpiso);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='tipo_piso' id='tipo_edificacao' style=\"width: 450px;\">";
                for($x=0;$x<pg_num_rows($rpiso);$x++){
                    echo "<option value='{$r_tipo_piso[$x][cod_piso]}'"; print $edifdata[cod_piso] == $r_tipo_piso[$x][cod_piso] ? " selected ":""; echo ">{$r_tipo_piso[$x][descricao_piso]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";
*/
/**********************************************************************************************/
// --> PAREDE
/**********************************************************************************************/
/*
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Parede:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Tipo de parede:&nbsp;";
        echo "</td>";
        //query
        $sql = "SELECT * FROM parede order by decicao_parede";
        $rparede = pg_query($sql);
        $r_tipo_parede = pg_fetch_all($rparede);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='tipo_parede' id='tipo_parede' style=\"width: 450px;\">";
                for($x=0;$x<pg_num_rows($rparede);$x++){
                    echo "<option value='{$r_tipo_parede[$x][cod_parede]}'"; print $edifdata[cod_parede] == $r_tipo_parede[$x][cod_parede] ? " selected ":""; echo ">{$r_tipo_parede[$x][decicao_parede]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";
 */
/**********************************************************************************************/
// --> COBERTURA
/**********************************************************************************************/
/*
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Cobertura:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Tipo de cobertura:&nbsp;";
        echo "</td>";
        //query
        $sql = "SELECT * FROM cobertura order by decicao_cobertura";
        $rcob = pg_query($sql);
        $r_tipo_cob = pg_fetch_all($rcob);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='tipo_cobertura' id='tipo_cobertura' style=\"width: 450px;\">";
                for($x=0;$x<pg_num_rows($rcob);$x++){
                    echo "<option value='{$r_tipo_cob[$x][cod_cobertura]}'"; print $edifdata[cod_cobertura] == $r_tipo_cob[$x][cod_cobertura] ? " selected ":""; echo ">{$r_tipo_cob[$x][decicao_cobertura]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";
*/
/**********************************************************************************************/
// --> VENTILAÇÃO
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Ventilação:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Ventilação natural:";
        echo "</td>";
        echo "<td class='text' width=490>";
            //$sql = "SELECT cod_vent_nat, nome_vent_nat, substr(decricao_vent_nat,1 ,60) as decricao_vent_nat FROM ventilacao_natural ORDER BY decricao_vent_nat";
            $sql = "SELECT * FROM ventilacao_natural ORDER BY decricao_vent_nat";
            $rvn = pg_query($sql);
            $r_vent_nat = pg_fetch_all($rvn);
            echo "<select class='inputTextobr' name='vent_natural' id='vent_natural' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rvn);$x++){
                    echo "<option value='{$r_vent_nat[$x][cod_vent_nat]}'"; print $edifdata[cod_vent_nat] == $r_vent_nat[$x][cod_vent_nat] ? " selected ":""; echo ">{$r_vent_nat[$x][decricao_vent_nat]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Ventilação artificial:";
        echo "</td>";
        echo "<td class='text' width=490>";
            //$sql = "SELECT cod_vent_art, nome_vent_art, substr(decricao_vent_art,1,60) as decricao_vent_art FROM ventilacao_artificial ORDER BY decricao_vent_art";
            $sql = "SELECT * FROM ventilacao_artificial ORDER BY decricao_vent_art";
            $rva = pg_query($sql);
            $r_vent_art = pg_fetch_all($rva);
            echo "<select class='inputTextobr' name='vent_artificial' id='vent_artificial' style=\"width: 450px;\" onchange=\"cgrt_edif_vent_art(this);\" onblur=\"cgrt_edif_vent_art(this);\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rva);$x++){
                    echo "<option value='{$r_vent_art[$x][cod_vent_art]}'"; print $edifdata[cod_vent_art] == $r_vent_art[$x][cod_vent_art] ? " selected ":""; echo ">{$r_vent_art[$x][decricao_vent_art]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "<div id='darcomp' style=\"display: none;\">Dados complementares:</div>";
        echo "</td>";
        echo "<td class='text' width=490>";
            echo "<div id='dtestar' style=\"display: none;\"><input type=text name=testear></div>";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**********************************************************************************************/
// --> ILUMINAÇÃO
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Iluminação:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Iluminação natural:";
        echo "</td>";
        echo "<td class='text' width=490>";
            $sql = "SELECT * FROM luz_natural order by nome_luz_nat";
            $rln = pg_query($sql);
            $r_luz_nat = pg_fetch_all($rln);
            echo "<select class='inputTextobr' name='luz_natural' id='luz_natural' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rln);$x++){
                    echo "<option value='{$r_luz_nat[$x][cod_luz_nat]}'"; print $edifdata[cod_luz_nat] == $r_luz_nat[$x][cod_luz_nat] ? " selected ":""; echo ">{$r_luz_nat[$x][descricao_luz_nat]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Iluminação artificial:";
        echo "</td>";
        echo "<td class='text' width=490>";
            $sql = "SELECT * FROM luz_artificial order by nome_luz_art";
            $rla = pg_query($sql);
            $r_luz_art = pg_fetch_all($rla);
            echo "<select class='inputTextobr' name='luz_artificial' id='luz_artificial' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rla);$x++){
                    echo "<option value='{$r_luz_art[$x][cod_luz_art]}'"; print $edifdata[cod_luz_art] == $r_luz_art[$x][cod_luz_art] ? " selected ":""; echo ">{$r_luz_art[$x][decricao_luz_art]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**********************************************************************************************/
// --> RUÍDOS
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Ruídos(db):</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
    
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Ruído de fundo:";
        echo "</td>";
        echo "<td class='text' width=490>";
            echo "<input type=text class='inputTextobr' name='ruido_fundo' id='ruido_fundo' value='".number_format($edifdata[ruido_fundo_setor], 1, '.', '')."' size=5 onkeypress=\"return lastdot(this, event);\">";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Ruído de operação:";
        echo "</td>";
        echo "<td class='text' width=490>";
            echo "<input type=text class='inputTextobr' name='ruido_operacao' id='ruido_operacao' value='".number_format($edifdata[ruido_operacao_setor], 1, '.', '')."' size=5 onkeypress=\"return lastdot(this, event);\">";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Aparelho:";
        echo "</td>";
        $sql = "SELECT * FROM aparelhos WHERE cod_aparelho <> 0 AND tipo_aparelho = 3 ORDER BY nome_aparelho";
        $rapr = pg_query($sql);
        $r_ap_ruido = pg_fetch_all($rapr);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='aparelho_ruido' id='aparelho_ruido' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rapr);$x++){
                    echo "<option value='{$r_ap_ruido[$x][cod_aparelho]}'"; print $edifdata[ruido] == $r_ap_ruido[$x][cod_aparelho] ? " selected ":""; echo ">{$r_ap_ruido[$x][nome_aparelho]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**********************************************************************************************/
// --> TEMPERATURA
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Temperatura:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";

    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Calor (ºC):";
        echo "</td>";
        echo "<td class='text' width=490>";
            echo "<input type=text class='inputTextobr' name='calor' id='calor' value='".number_format($edifdata[temperatura], 1, '.', '')."' size=5 onkeypress=\"return lastdot(this, event);\">";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Umidade (%):";
        echo "</td>";
        echo "<td class='text' width=490>";
            echo "<input type=text class='inputTextobr' name='umidade' id='umidade' value='".number_format($edifdata[umidade], 1, '.', '')."' size=5 onkeypress=\"return lastdot(this, event);\">";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Aparelho:";
        echo "</td>";
        $sql = "SELECT * FROM aparelhos WHERE cod_aparelho <> 0 AND tipo_aparelho = 1 ORDER BY nome_aparelho";
        $rapt = pg_query($sql);
        $r_ap_temp = pg_fetch_all($rapt);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='aparelho_temperatura' id='aparelho_temperatura' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rapt);$x++){
                    echo "<option value='{$r_ap_temp[$x][cod_aparelho]}'"; print $edifdata[termico] == $r_ap_temp[$x][cod_aparelho] ? " selected ":""; echo ">{$r_ap_temp[$x][nome_aparelho]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
	echo "<tr>";
		echo "<td align=left class='text' width=150>";
			echo "Caracterização:";
		echo "</td>";
		echo "<td class='text' width=490>";
			echo "<input type=text class='text' name='caracterizacao' id='caracterizacao' value='{$edifdata[caracterizacao]}' size=25 >";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td align=left class='text' width=150>";
			echo "Sintomas:";
		echo "</td>";
		echo "<td class='text' width=490>";
			echo "<input type=text class='text' name='sintoma' id='sintoma' value='{$edifdata[sintoma]}' size=25 >";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td align=left class='text' width=150>";
			echo "Meio de Controle Existente:";
		echo "</td>";
		echo "<td class='text' width=490>";
			echo "<input type=text class='text' name='m_ctr_existente' id='m_ctr_existente' value='{$edifdata[m_ctr_existente]}' size=50 >";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td align=left class='text' width=150>";
			echo "Fonte Geradora:";
		echo "</td>";
		echo "<td class='text' width=490>";
			echo "<input type=text class='text' name='fonte_geradora' id='fonte_geradora' value='{$edifdata[fonte_geradora]}' size=50 >";
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td align=left class='text' width=150>";
			echo "Medida de Controle no Trabalhador:";
		echo "</td>";
		echo "<td class='text' width=490>";
			echo "<input type=text class='text' name='m_ctr_trabalhador' id='m_ctr_trabalhador' value='{$edifdata[m_ctr_trabalhador]}' size=50 >";
		echo "</td>";
	echo "</tr>";
	
	$ltcat_sql = "SELECT * 
			FROM cliente_setor  
			WHERE cod_cliente =".$_GET[cod_cliente]." 
			AND cod_setor = ".$_GET[cod_setor]." 
			AND id_ppra = ".$_GET[cod_cgrt];
					
$ltcat_query = pg_query($ltcat_sql);
$ltcat_array = pg_fetch_array($ltcat_query);

	$ibtug = ( ( $ltcat_array[ibtug_t] * $ltcat_array[tempo_t] ) + ( $ltcat_array[ibtug_d] * $ltcat_array[tempo_d] ) ) / 60;
	
			echo '<tr>					
				<td align="left" height=20 width = 40%>Valor IBUTG no local de trabalho:</td>
				<td align="left" height=20> <input onkeypress="return lastdot(this, event);" class="inputTextobr" name="ibtug_t" id="ibtug_t" size ="5" type="text" value="'.number_format($ltcat_array[ibtug_t], 1, '.', '').'" /> </td>
					</tr>
					<tr>
						<td align="left" height=20> Valor IBUTG no local de descanso:</td>
				<td align="left" height=20> <input onkeypress="return lastdot(this, event);" class="inputTextobr" name="ibtug_d" id="ibtug_d" size ="5" type="text" value="'.number_format($ltcat_array[ibtug_d], 1, '.', '').'" /> </td>
					</tr>
					<tr>
						<td align="left" height=20>Tempo total de trabalho em minutos:</td>
				<td align="left" height=20> <input onkeypress="return lastdot(this, event);" class="inputTextobr" name="tempo_t" id="tempo_t" size ="5" type="text" value="'.number_format($ltcat_array[tempo_t], 1, '.', '').'" /> </td>
					</tr>
					<tr>
						<td align="left" height=20> Tempo total de descanso em minutos:</td>
				<td align="left" height=20> <input onkeypress="return lastdot(this, event);" class="inputTextobr" name="tempo_d" id="tempo_d" size ="5" type="text" value="'.number_format($ltcat_array[tempo_d], 1, '.', '').'" /> </td>
					</tr>
					<tr>
						<td align="left" height=20><b> IBUTG calculado:</b></td>
						<td align="left" height=20>&nbsp;<b>'.number_format($ibtug, 2, '.', '').'</b></td>
					</tr>
					<p>';
	
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**********************************************************************************************/
// --> CARGA MENTAL APGRE
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Carga Mental(APGRE):</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
	echo "<tr>";
        echo "<td align=left class='text' colspan=2>";
            echo "Analisando o setor observou-se as seguintes considerações:";
        echo "</td>";
	echo "</tr>";
	echo "<tr>";
    $sql = "SELECT * FROM carga_mental order by nome";
    $ap = pg_query($sql);

        echo "<td class='text' colspan=2>";
            echo "<select class='inputTextobr' name='c_mental[]' id='c_mental' multiple='multiple' style=\"width: 500px;\">";
                $query_l = "select * from cliente_setor where id_ppra = $_GET[cod_cgrt] and cod_setor = $_GET[cod_setor]";
				$result_l = pg_query($query_l);
				$r_l = pg_fetch_all($result_l);
				$ll = explode("|", $r_l[0]['c_mental']);
				
				while($row_ap = pg_fetch_array($ap)){
				for($x=0;$x<count($r_l);$x++){
                if(in_array($row_ap['c_mental'], $ll)){
				$r=1;
                echo "<option value=$row_ap[c_mental] selected>$row_ap[nome]</option>";
  			   }
  			}
  			if($r!=1){
			   echo "<option value=$row_ap[c_mental]>$row_ap[nome]</option>";
            }
            $r=0;
  			}
            echo "</select>";
        echo "</td>";
    echo "</tr>";
	echo "<tr>";
		echo "<td align='left' width=25% class='text'>Manuseio de Carga:</td>";
		echo "<td align='left' class='text'><select name='m_carga' id='m_carga' style=\"width: 50px;\">";
			echo "<option value=''"; if($edifdata[m_carga] == " ") echo "selected"; echo "> </option>";
			echo "<option value='sim'"; if($edifdata[m_carga] == "sim") echo "selected"; echo ">Sim</option>";
			echo "<option value='não'"; if($edifdata[m_carga] == "não") echo "selected"; echo ">Não</option>"; 
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td align='left' width=25% class='text'>Deslocamento:</td>";
		echo "<td align='left' class='text'><select name='desloc' id='desloc' style=\"width: 50px;\">";
			echo "<option value=''"; if($edifdata[desloc] == " ") echo "selected"; echo "> </option>";
			echo "<option value='sim'"; if($edifdata[desloc] == "sim") echo "selected"; echo ">Sim</option>";
			echo "<option value='não'"; if($edifdata[desloc] == "não") echo "selected"; echo ">Não</option>"; 
		echo "</td>";
	echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**********************************************************************************************/
// --> POSTO DE TRABALHO
/**********************************************************************************************/
if($edifdata[is_posto_trabalho]){
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Posto de trabalho:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";

    echo "<tr>";
        echo "<td align=left class='text' width=150>";
            echo "Posto de trabalho:";
        echo "</td>";
        $sql = "SELECT * FROM posto_trabalho WHERE cod_cliente = ".(int)($_GET[cod_cliente])." ORDER BY razao_social";
        $rpt = pg_query($sql);
        $ptl = pg_fetch_all($rpt);
        echo "<td class='text' width=490>";
            echo "<select class='inputTextobr' name='id_pt' id='id_pt' style=\"width: 450px;\">";
                echo "<option value=''></option>";
                for($x=0;$x<pg_num_rows($rpt);$x++){
                    echo "<option value='{$ptl[$x][id]}'";
                    print $edifdata[id_pt] == $ptl[$x][id] ? " selected ":"";
                    echo ">{$ptl[$x][razao_social]}</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";
}

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSaveEdif' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</td>";
echo "</form>";
    echo "</tr>";
echo "</table>";

?>