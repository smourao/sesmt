<?PHP
//DUPLICAÇÃO DO CGRT DO CLIENTE
if($_GET[y]){
	$sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = $_GET[cod_cgrt] ";
	$consult = pg_query($sql);
	$cons  = pg_fetch_array($consult);
	
	$sql = "SELECT MAX(cod_ppra) as maxppra FROM cgrt_info";
	$r = pg_query($sql);
	$cod_ppra = pg_fetch_array($r);
	$cod_ppra = $cod_ppra[maxppra] + 1;
	
	$sql = "SELECT MAX(cod_cgrt) as maxid FROM cgrt_info";
	$ra = pg_query($sql);
	$cod_cgrt = pg_fetch_array($ra);
	$cod_cgrt = $cod_cgrt[maxid] + 1;
	
	//echo "CGRT_INFO<BR>";
	$sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = $_GET[cod_cgrt]";
	$info = pg_query($sql);
	$if  = pg_fetch_all($info);
	for($x=0;$x<pg_num_rows($info);$x++){
		$sql = "INSERT INTO cgrt_info
		(cod_cgrt, cod_cliente, jornada, ano, data_criacao, id_resp_ppra, id_resp_pcmso, cod_ppra, have_posto_trabalho, cod_posto_trabalho, pe_direito, aparelho_medicao_metragem, frente, comprimento, n_pavimentos, cgrt_finished, pcmso_enabled, ppra_enabled, id_tec_ppra, temperatura, p_medicao, temp_elevada, ceu_aberto, terceirizado, apgre_enabled, quimico, biologico, ltcat_conclusao, fisico, ergonomico, acidente)
		values
		({$cod_cgrt}, {$if[$x][cod_cliente]}, {$if[$x][jornada]}, {$_GET[y]}, '$_GET[y]/".date("m/d")."', {$if[$x][id_resp_ppra]}, {$if[$x][id_resp_pcmso]}, {$cod_ppra}, {$if[$x][have_posto_trabalho]}, {$if[$x][cod_posto_trabalho]}, '{$if[$x][pe_direito]}', {$if[$x][aparelho_medicao_metragem]}, '{$if[$x][frente]}', '{$if[$x][comprimento]}', {$if[$x][n_pavimentos]}, 0, 0, '0', {$if[$x][id_tec_ppra]}, '', '', '', '', '', '0', '{$if[$x][quimico]}', '{$if[$x][biologico]}', '{$if[$x][ltcat_conclusao]}', '{$if[$x][fisico]}', '{$if[$x][ergonomico]}', '{$if[$x][acidente]}')";
		pg_query($sql);
	}
	
	//echo "CLIENTE_SETOR<BR>";
	$sql = "SELECT * FROM cliente_setor WHERE cod_cliente = $_GET[cod_cliente] AND id_ppra = {$cons[cod_cgrt]}";
	$res = pg_query($sql);
	$cs  = pg_fetch_all($res);
	for($x=0;$x<pg_num_rows($res);$x++){
		$sql = "INSERT INTO cliente_setor
		(cod_cliente, cod_setor, cod_luz_nat, cod_luz_art, cod_vent_nat, cod_vent_art, cod_edificacao, cod_piso, cod_parede, cod_cobertura, observacao_setor, umidade, temperatura, pavimentos, altura, frente, comprimento, tipo_setor, ruido_fundo_setor, data_avaliacao, hora_avaliacao, ruido_operacao_setor, cod_filial, tipo_hidrante_id, diametro_mangueira_id, quantidade_mangueira, esguicho, chave_stors, pl_ident, demarcacao, porta_cont_fogo, tipo_sistema_fixo_contra_incendio_id, tipo_para_raio_id, alarme_contra_incendio_id, qtd_esquicho, qtd_raio, sprinkler, detector, registro, repor, mang_reposta, bulbos, qtd_porta, cod_ppra, epc_existente, epc_sugerido, termico, metragem, ruido, data_criacao, estado_abrigo, estado_mang, dt_ventilacao, degraus, largura, fita, rabica, gripal, tanica, vistoria, higiene, jornada, num_aparelhos, proxima_limpeza_mecanica, marca, ultima_limpeza_duto, proxima_limpeza_duto, modelo, capacidade, empresa_servico, epc_eficaz, ca, data_limpeza_filtros, cod_orcamento, funcionario_id, id_ppra,
		func_terc, elaborador_pcmso, is_posto_trabalho, ar_port_area_circulacao, id_pt, c_mental, h_melhoria, h_acidente, foto, equip_util, fer_util, carga_manu, ativ_rotina, verba, caracterizacao, sintoma, m_ctr_existente, fonte_geradora, m_ctr_trabalhador, m_carga, desloc, turno)
		values
		('{$cs[$x][cod_cliente]}', '{$cs[$x][cod_setor]}', '{$cs[$x][cod_luz_nat]}', '{$cs[$x][cod_luz_art]}', '{$cs[$x][cod_vent_nat]}', '{$cs[$x][cod_vent_art]}', '{$cs[$x][cod_edificacao]}', '{$cs[$x][cod_piso]}', '{$cs[$x][cod_parede]}', '{$cs[$x][cod_cobertura]}', '{$cs[$x][observacao_setor]}', '{$cs[$x][umidade]}', '{$cs[$x][temperatura]}', 0, '{$cs[$x][altura]}', '{$cs[$x][frente]}', '{$cs[$x][comprimento]}', '{$cs[$x][tipo_setor]}', '{$cs[$x][ruido_fundo_setor]}', '{$cs[$x][data_avaliacao]}', '{$cs[$x][hora_avaliacao]}', '{$cs[$x][ruido_operacao_setor]}', 1, 0, 0, '{$cs[$x][quantidade_mangueira]}', '{$cs[$x][esguicho]}', '{$cs[$x][chave_stors]}', '{$cs[$x][pl_ident]}', '{$cs[$x][demarcacao]}', '{$cs[$x][porta_cont_fogo]}', 0, 0, 0, '{$cs[$x][qtd_esquicho]}', '{$cs[$x][qtd_raio]}', '{$cs[$x][sprinkler]}', '{$cs[$x][detector]}', '{$cs[$x][registro]}', '{$cs[$x][repor]}', '{$cs[$x][mang_reposta]}', '{$cs[$x][bulbos]}', '{$cs[$x][qtd_porta]}', {$cod_ppra}, '{$cs[$x][epc_existente]}', '{$cs[$x][epc_sugerido]}'		, 0, 0, 0, '$_GET[y]/".date("m/d")."', '{$cs[$x][estado_abrigo]}', '{$cs[$x][estado_mang]}', null, '{$cs[$x][degraus]}', '{$cs[$x][largura]}', '{$cs[$x][fita]}', '{$cs[$x][rabica]}', '{$cs[$x][gripal]}', '{$cs[$x][tanica]}', null, '{$cs[$x][higiene]}', '{$cs[$x][jornada]}', '{$cs[$x][num_aparelhos]}', null, '{$cs[$x][marca]}', null, null, '{$cs[$x][modelo]}', '{$cs[$x][capacidade]}', '{$cs[$x][empresa_servico]}', '{$cs[$x][epc_eficaz]}', '{$cs[$x][ca]}', null, null, {$cs[$x][funcionario_id]}, '{$cod_cgrt}', {$cs[$x][func_terc]}, {$cs[$x][elaborador_pcmso]}, {$cs[$x][is_posto_trabalho]}, {$cs[$x][ar_port_area_circulacao]}, {$cs[$x][id_pt]}, '{$cs[$x][c_mental]}', '{$cs[$x][h_melhoria]}', '{$cs[$x][h_acidente]}', '{$cs[$x][foto]}', '{$cs[$x][equip_util]}', '{$cs[$x][fer_util]}', '{$cs[$x][carga_manu]}', '{$cs[$x][ativ_rotina]}', '{$cs[$x][verba]}', '{$cs[$x][caracterizacao]}', '{$cs[$x][sintoma]}', '{$cs[$x][m_ctr_existente]}', '{$cs[$x][fonte_geradora]}', '{$cs[$x][m_ctr_trabalhador]}', '{$cs[$x][m_carga]}		', '{$cs[$x][desloc]}', '{$cs[$x][turno]}')";
		pg_query($sql);
	}
	
	echo "RISCO_SETOR<BR>";
	$sql = "SELECT * FROM risco_setor WHERE cod_cliente = $_GET[cod_cliente] AND id_ppra = {$cons[cod_cgrt]}";
	$res = pg_query($sql);
	$rs  = pg_fetch_all($res);
	
	for($x=0;$x<pg_num_rows($res);$x++){
		$sql = "INSERT INTO risco_setor
		(cod_cliente, cod_setor, cod_agente_risco, fonte_geradora, cod_tipo_contato, cod_agente_contato, nivel, itensidade, danos_saude, escala_acao, acao_necessaria, diagnostico, preventiva, acidente, corretiva, data, id_ppra, dsc_agente)
		VALUES
		('{$rs[$x][cod_cliente]}', '{$rs[$x][cod_setor]}', '{$rs[$x][cod_agente_risco]}', '{$rs[$x][fonte_geradora]}', '{$rs[$x][cod_tipo_contato]}', '{$rs[$x][cod_agente_contato]}', '{$rs[$x][nivel]}', '{$rs[$x][itensidade]}', '{$rs[$x][danos_saude]}', '{$rs[$x][escala_acao]}', '{$rs[$x][acao_necessaria]}', '{$rs[$x][diagnostico]}', '{$rs[$x][preventiva]}', '{$rs[$x][acidente]}', '{$rs[$x][corretiva]}', '$_GET[y]/".date("m/d")."', {$cod_cgrt}, '$rs[$x][dsc_agente]')";
		pg_query($sql);
	}
	
	//echo "SUGESTAO<BR>";
	$sql = "SELECT * FROM sugestao WHERE cod_cliente = $_GET[cod_cliente] AND id_ppra = {$cons[cod_cgrt]}";
	$res = pg_query($sql);
	$sug = pg_fetch_all($res);
	for($x=0;$x<pg_num_rows($res);$x++){
		if(empty($sug[$x][cod_produto]))
			$sug[$x][cod_produto] = 0;
		if(empty($sug[$x][quantidade]))
			$sug[$x][quantidade] = 0;
		$sql = "INSERT INTO sugestao
		(cod_setor, cod_cliente, cod_funcao, med_prev, plano_acao, data, cod_produto, quantidade, id_ppra)
		VALUES
		('{$sug[$x][cod_setor]}', '{$sug[$x][cod_cliente]}', '0', '{$sug[$x][med_prev]}', '{$sug[$x][plano_acao]}', '$_GET[y]/".date("m/d")."', '{$sug[$x][cod_produto]}', '{$sug[$x][quantidade]}', '{$cod_cgrt}')";
		pg_query($sql);
	}
	
	//echo "EXTINTOR<BR>";
	$sql = "SELECT * FROM extintor WHERE cod_cliente = $_GET[cod_cliente] AND id_ppra = {$cons[cod_cgrt]}";
	$res = pg_query($sql);
	$ext = pg_fetch_all($res);
	for($x=0;$x<pg_num_rows($res);$x++){
		$sql = "INSERT INTO extintor
		(extintor, tipo_extintor, qtd_extintor, data_recarga, numero_cilindro, vencimento_abnt, proxima_carga, placa_sinalizacao_id, demarcacao_solo_id, tipo_instalacao_id, empresa_prestadora, cod_setor, cod_cliente, f_inspecao, cod_produto, data, id_ppra)
		VALUES
		('{$ext[$x][extintor]}', '{$ext[$x][tipo_extintor]}', '{$ext[$x][qtd_extintor]}', '{$ext[$x][data_recarga]}', '{$ext[$x][numero_cilindro]}', '{$ext[$x][vencimento_abnt]}', '{$ext[$x][proxima_carga]}', '{$ext[$x][placa_sinalizacao_id]}', '{$ext[$x][demarcacao_solo_id]}', '{$ext[$x][tipo_instalacao_id]}', '{$ext[$x][empresa_prestadora]}', '{$ext[$x][cod_setor]}', '{$ext[$x][cod_cliente]}', '{$ext[$x][f_inspecao]}', '{$ext[$x][cod_produto]}', '$_GET[y]/".date("m/d")."', '{$cod_cgrt}')";
		pg_query($sql);
	}
	
	//echo "PPRA_PLACAS<BR>";
	$sql = "SELECT * FROM ppra_placas WHERE cod_cliente = $_GET[cod_cliente] AND id_ppra = {$cons[cod_cgrt]}";
	$res = pg_query($sql);
	$pla = pg_fetch_all($res);
	for($x=0;$x<pg_num_rows($res);$x++){
		$sql = "INSERT INTO ppra_placas
		(descricao, quantidade, cod_prod, legenda, cod_cliente, cod_setor, data, id_ppra)
		VALUES
		('{$pla[$x][descricao]}', '{$pla[$x][quantidade]}', '{$pla[$x][cod_prod]}', '{$pla[$x][legenda]}', '{$pla[$x][cod_cliente]}', '{$pla[$x][cod_setor]}', '$_GET[y]/".date("m/d")."', '{$cod_cgrt}')";
		pg_query($sql);
	}
	
echo "<script>location.href='?dir=cgrt&p=index';</script>";

}

//ATUALIZAÇÃO DAS INFORMAÇÕES DE RELATÓRIO
if($_POST && $_POST[btnSaveIR]){
    $sql = "UPDATE cgrt_Info SET
    jornada 	   = ".(int)($_POST[jornada]).",
    ano 		   = ".(int)($_POST[ano]).",
    id_resp_ppra   = ".(int)($_POST[ppra_resp]).",
    id_resp_pcmso  = ".(int)($_POST[pcmso_resp]).",
    id_tec_ppra    = ".(int)($_POST[ppra_tec_resp]).",
	terceirizado   = '$_POST[terc]',
	have_posto_trabalho = '$_POST[pt_existente]'
    WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
    if(pg_query($sql)){
        showMessage('Dados atualizados com sucesso.');
        makelog($_SESSION[usuario_id], "[CGRT] Atualização de dados do relatório: $_GET[cod_cgrt].", 108);
        if(is_numeric($_GET[cod_cgrt])){
            $sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = $_GET[cod_cgrt]";
            $rci = pg_query($sql);
            $cgrt_info = pg_fetch_array($rci);
        }
    }else{
        showMessage('Houve um erro ao atualizar os dados. Por favor, entre em contato com o setor de suporte.', 1);
        makelog($_SESSION[usuario_id], "[CGRT] Erro ao atualizar dados do relatório: $_GET[cod_cgrt].", 109);
    }
}
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
echo "<b>$cinfo[razao_social]</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

/**********************************************************************************************/
// --> INFORMAÇÕES DOS RELATÓRIOS
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<form method='POST' name='frmRelInfo' onsubmit=\"return cgrt_relinfo_cf(this);\">";
echo "<td class='text'>";
echo "<b>Informações dos relatórios:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";

    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Código do cliente:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='cod_cliente' id='cod_cliente' value='".str_pad($cinfo[cliente_id], 4, "0", 0)."' size=5 readonly=readonly disabled>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Código CGRT:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='cod_cgrt' id='cod_cgrt' value='".str_pad($cgrt_info[cod_cgrt], 4, "0", 0)."' size=5 readonly=readonly disabled>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Data de criação:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='data_criacao' id='data_criacao' value='".date("d/m/Y", strtotime($cgrt_info[data_criacao]))."' size=10 readonly=readonly disabled>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Jornada de trabalho:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='jornada' id='jornada' value='$cgrt_info[jornada]' size=5 onkeydown=\"return only_number(event);\">";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Ano de referência:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='ano' id='ano' value='$cgrt_info[ano]' size=5 onkeydown=\"return only_number(event);\">";
        echo "</td>";
    echo "</tr>";
	echo "<tr>";
		echo "<td align=left class='text' width=150>";
        echo "Funcionário terceirizado:";
        echo "</td>";
        echo "<td class='text' width=490>";
            echo "<select name='terc' id='terc' style=\"width: 60px;\" class='inputTextobr'>";
			echo "<option value=''></option>";
            echo "<option value='nao'"; print $cgrt_info[terceirizado] == 'nao' ? "selected":""; echo ">Não</option>";
			echo "<option value='sim'"; print $cgrt_info[terceirizado] == 'sim' ? "selected":""; echo ">Sim</option>";
            echo "</select>";
        echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td align=left class='text' width=150>";
			echo "Posto de trabalho existente:&nbsp;";
		echo "</td>";
        	echo "<td class='text' width=490>";
            	echo "<select class='inputTextobr' name='pt_existente' id='pt_existente'>";
                	echo "<option value='0'"; print $cgrt_info[have_posto_trabalho] == '0' ? "selected":""; echo ">Não</option>";
                    echo "<option value='1'"; print $cgrt_info[have_posto_trabalho] == '1' ? "selected":""; echo ">Sim</option>";
                echo "</select>";
         echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**********************************************************************************************/
// --> ELABORADORES RESPONSÁVEIS
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";

echo "<form method='POST' name='frmRelInfo'>";

echo "<td class='text'>";
echo "<b>Elaborador(a) Responsável:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";

    echo "<tr>";
        $sql = "SELECT * FROM funcionario WHERE cargo_id = 15 OR cargo_id = 17 OR cargo_id = 7 ORDER BY nome";
        $res_ppra = pg_query($sql);
        $ppra_f = pg_fetch_all($res_ppra);
        echo "<td align=left class='text' width=150>";
        echo "PPRA:";
        echo "</td>";
        echo "<td class='text' width=490>";
            echo "<select name='ppra_resp' style=\"width: 300px;\" class='inputTextobr'>";
			echo "<option value='18'></option>";
            for($x=0;$x<pg_num_rows($res_ppra);$x++){
                echo "<option value='{$ppra_f[$x][funcionario_id]}'"; print $ppra_f[$x][funcionario_id] == $cgrt_info[id_resp_ppra] ? "selected":""; echo ">{$ppra_f[$x][nome]}</option>";
            }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        $sql = "SELECT * FROM funcionario WHERE cargo_id = 1001 ORDER BY nome";
        $res_pcmso = pg_query($sql);
        $pcmso_f = pg_fetch_all($res_pcmso);
        echo "<td align=left class='text' width=150>";
        echo "PCMSO:";
        echo "</td>";
        echo "<td class='text' width=490>";
            echo "<select name='pcmso_resp' style=\"width: 300px;\" class='inputTextobr'>";
            for($y=0;$y<pg_num_rows($res_pcmso);$y++){
                echo "<option value='{$pcmso_f[$y][funcionario_id]}'"; print $pcmso_f[$y][funcionario_id] == $cgrt_info[id_resp_pcmso] ? "selected":""; echo ">{$pcmso_f[$y][nome]}</option>";
            }
            echo "</select>";
        echo "</td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";


/**********************************************************************************************/
// --> TÉCNICOS RESPONSÁVEIS
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";

echo "<td class='text'>";
echo "<b>Técnico(a) Responsável:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";

    echo "<tr>";
        $sql = "SELECT * FROM funcionario WHERE cargo_id = 15 OR cargo_id = 17 OR cargo_id = 7 ORDER BY nome";
        $res_ppra = pg_query($sql);
        $ppra_f = pg_fetch_all($res_ppra);
        echo "<td align=left class='text' width=150>";
        echo "PPRA:";
        echo "</td>";
        echo "<td class='text' width=490>";
            echo "<select name='ppra_tec_resp' style=\"width: 300px;\" class='inputTextobr'>";
			echo "<option value='18'></option>";
            for($x=0;$x<pg_num_rows($res_ppra);$x++){
                echo "<option value='{$ppra_f[$x][funcionario_id]}'"; print $ppra_f[$x][funcionario_id] == $cgrt_info[id_tec_ppra] ? "selected":""; echo ">{$ppra_f[$x][nome]}</option>";
            }
            echo "</select>";
        echo "</td>";
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
            echo "<input type='submit' class='btn' name='btnSaveIR' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\">";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";
echo "</form>";
?>
