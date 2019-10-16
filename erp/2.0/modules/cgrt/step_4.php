<?PHP
/**********************************************************************************************/
// --> SAVE DATA - SUBMITED FORM!
/**********************************************************************************************/
if($_POST && $_POST[btnSaveDadosCompl]){
    $data_aval = explode("/", $_POST[data_avaliacao]);
    $hora_aval = explode(":", $_POST[hora_avaliacao]);
    //não utilizado no novo cgrt
    $sql = "UPDATE
        cliente_setor
    SET
          altura               = $_POST[pe_direito]
        , metragem			   = ".(int)($_POST[aparelho_medicao])."
        , frente               = $_POST[frente]
        , comprimento          = $_POST[comprimento]
        , data_avaliacao	   = '$data_aval'
        , hora_avaliacao       = '$hora_aval'
    WHERE
        id_ppra                = ".(int)($_GET[cod_cgrt])."
    AND
        cod_setor              = ".(int)($_GET[cod_setor]);

    //---------------------------------
	
	
	/**********************************************************************************************/
    //CURSO
    /**********************************************************************************************/
        for($x=0;$x<count($_POST[cur_plano_acao]);$x++){
            if($_POST[cur_pa_data][$x]){
                $data = explode("/", $_POST[cur_pa_data][$x]);
                $data = "'$data[1]-$data[0]-01'";
            }else{
                $data = 'null';
            }
            $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND tipo_med_prev = 2 and med_prev = {$_POST[cur_cod_prod][$x]}";
            $res = @pg_query($sql);
            if(@pg_num_rows($res)){
                $sql = "UPDATE sugestao SET plano_acao = '".(int)($_POST[cur_plano_acao][$x])."', data = $data WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND med_prev = {$_POST[cur_cod_prod][$x]} AND tipo_med_prev = 2";
				if(@pg_query($sql)){
                    //nothing to do!
                }else{
                    $error++;
                }
            }else{
                $sql = "INSERT INTO sugestao
                (cod_setor, cod_cliente, med_prev, plano_acao, data, cod_produto, id_ppra, tipo_med_prev)
                VALUES
                (0, ".(int)($_GET[cod_cliente]).", ".(int)($_POST[cur_cod_prod][$x]).", ".(int)($_POST[cur_plano_acao][$x]).", $data, ".(int)($_POST[cur_cod_prod][$x]).", ".(int)($_GET[cod_cgrt]).", 2)";
                if(@pg_query($sql)){
                    //nothing todo
                }else{
                    $error++;
                }
            }
        }

    $sql = "UPDATE
        cgrt_info
    SET
          pe_direito                   = $_POST[pe_direito]
        , aparelho_medicao_metragem    = ".(int)($_POST[aparelho_medicao])."
        , frente                       = $_POST[frente]
        , comprimento                  = $_POST[comprimento]
        , data_avaliacao	           = '".date("Y-m-d H:i:s", mktime((int)($hora_aval[0]), (int)($hora_aval[1]), 0, (int)($data_aval[1]), (int)($data_aval[0]), (int)($data_aval[2])))."'
        , n_pavimentos                 = ".(int)($_POST[n_pavimentos])."
		, temperatura				   = '$_POST[temperatura]'
		, p_medicao					   = '$_POST[p_medicao]'
		, temp_elevada				   = '$_POST[temp_elevada]'
		, ceu_aberto				   = '$_POST[ceu_aberto]'
		, ltcat_conclusao			   = '".addslashes($_POST[conclusao])."'
		, fisico						= '".addslashes($_POST[fisico])."'
		, quimico			   			= '".addslashes($_POST[quimico])."'
		, biologico					   = '".addslashes($_POST[biologico])."'
		, ergonomico				   = '".addslashes($_POST[ergonomico])."'
		, acidente					   = '".addslashes($_POST[acidente])."'
    WHERE
        cod_cgrt                	   = ".(int)($_GET[cod_cgrt]);
        
    if(@pg_query($sql)){
        showMessage('Dados complementares atualizados com sucesso!');
        makelog($_SESSION[usuario_id], "[CGRT] Atualização de dados complementares do relatório: $_GET[cod_cgrt].", 110);
    }else{
        showMessage('Houve um erro ao tentar atualizar os dados complementares. Por favor, entre em contato com o setor de suporte.',1);
        makelog($_SESSION[usuario_id], "[CGRT] Houve um erro ao tentar atualizar os dados complementares do relatório: $_GET[cod_cgrt].", 111);
    }
}
/**********************************************************************************************/
// --> CLIENTE INFO [only to show razao_social in the bar]
/**********************************************************************************************/
$sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
$dadoscompl = pg_fetch_array(pg_query($sql));

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
echo "<b>$cinfo[razao_social]</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<p>";

/**********************************************************************************************/
// --> CONDIÇÕES DA EDIFICAÇÃO
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";

echo "<form method='POST' name='frmCondiEdif' onsubmit=\"return cgrt_dadoscompl_cf(this);\">";

echo "<td class='text'>";
echo "<b>Condições da edificação:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";

    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Pé direito:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='pe_direito' id='pe_direito' value='".number_format($dadoscompl[pe_direito], 1, ".", "")."' size=5 onkeydown=\"return only_number(event);\" onkeypress=\"return lastdot(this, event);\">";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Frente:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='frente' id='frente' value='".number_format($dadoscompl[frente], 1, ".", "")."' size=5 onkeydown=\"return only_number(event);\" onkeypress=\"return lastdot(this, event);\">";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Comprimento:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='comprimento' id='comprimento' value='".number_format($dadoscompl[comprimento], 1, ".", "")."' size=5 onkeydown=\"return only_number(event);\" onkeypress=\"return lastdot(this, event);\">";
        echo "</td>";
    echo "</tr>";
    
    $sql = "SELECT cod_aparelho, nome_aparelho FROM aparelhos where cod_aparelho <> 0 AND tipo_aparelho = 2 order by nome_aparelho";
    $rap = pg_query($sql);
    $aparelhos = pg_fetch_all($rap);
    
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Aparelho de medição:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<select name='aparelho_medicao' id='aparelho_medicao' class='inputTextobr'>";
        for($x=0;$x<pg_num_rows($rap);$x++){
            echo "<option value='{$aparelhos[$x][cod_aparelho]}' "; print $dadoscompl[metragem] == $aparelhos[$x][cod_aparelho] ? " selected ":""; echo " >{$aparelhos[$x][nome_aparelho]}</option>";
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
// --> DADOS SOBRE PAVIMENTOS........???
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Pavimentos:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Número de pavimentos:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='n_pavimentos' id='n_pavimentos' value='{$dadoscompl[n_pavimentos]}' size=10 maxlength=5  onkeydown=\"return only_number(event);\">";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**********************************************************************************************/
// --> DADOS DA MEDIÇÃO
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados da avaliação:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Data da avaliação:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='data_avaliacao' id='data_avaliacao' value='"; print empty($dadoscompl[data_avaliacao]) ? "" : date("d/m/Y", strtotime($dadoscompl[data_avaliacao])); echo "' size=10 maxlength=10  onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##/##/####');\">";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Hora da avaliação:";
        echo "</td>";
        echo "<td class='text' width=490>";
        echo "<input type=text class='inputTextobr' name='hora_avaliacao' id='hora_avaliacao' value='"; print empty($dadoscompl[data_avaliacao]) ? "" : date("H:i", strtotime($dadoscompl[data_avaliacao])); echo "' size=10 maxlength=5  onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##:##');\">";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/**********************************************************************************************/
// --> DADOS DOS CURSOS POR EMPRESA
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Cursos por empresa:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
	$curso = "select distinct(p.desc_resumida_prod), p.cod_prod from site_orc_produto o, produto p
			where o.cod_cliente = $_GET[cod_cliente] and o.cod_produto = p.cod_prod
			and (o.cod_produto = 431 or o.cod_produto = 840 or o.cod_produto = 897 or o.cod_produto = 980 or o.cod_produto = 981
			or o.cod_produto = 429 or o.cod_produto = 430 or o.cod_produto = 70275 or o.cod_produto = 941 or o.cod_produto = 69832 or o.cod_produto = 425 or o.cod_produto = 426 or o.cod_produto = 982 or o.cod_produto = 70413)";
	$cur = pg_query($connect, $curso);
	$cc = pg_fetch_all($cur);
		
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
		for($x=0;$x<pg_num_rows($cur);$x++){
			//faz uma pesquisa a cada item exibido buscando dados armazenados (caso haja)
			$sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." and cod_produto = {$cc[$x][cod_prod]} and tipo_med_prev = 2";
			$rsu = pg_query($sql);
			$dmp = pg_fetch_array($rsu);

        	echo "<input type=hidden name='cur_cod_prod[]' id='cur_cod_prod_{$cc[$x][cod_prod]}' value='{$cc[$x][cod_prod]}'>";
			echo "<tr class='roundbordermix'>";
				echo "<td class='text roundborder '";
				if($dmp[quantidade] == 1){
					echo " bgcolor=red alt='Não aparece no relatório' title='Não aparece no relatório' ";
				}else{
					echo " bgcolor=green alt='Aparece no relatório' title='Aparece no relatório' ";
				} 
					echo " ><a href='?dir=cgrt&p=index&step=4&cod_cliente={$cod_cliente}&cod_cgrt={$cod_cgrt}&alt={$dmp['cod_sugestao']}' >X</a></td>";
				echo "<td class='text roundborder' alt='".addslashes($cc[$x][desc_resumida_prod])."' title='".addslashes($cc[$x][desc_resumida_prod])."'>".substr(addslashes($cc[$x][desc_resumida_prod]), 0, 70); if(strlen(addslashes($cc[$x][desc_resumida_prod])) > 70) echo "..."; echo "</td>";
				echo "<td align=center class='text roundborder' width=85>";
				echo "<select name='cur_plano_acao[]' id='cur_pa_{$cc[$x][cod_prod]}' onchange=\"cgrt_mp_chg_t(this, 'cur_data_{$cc[$x][cod_prod]}');\" class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "'>";
				echo "<option value=''></option>";
				echo "<option value='0' "; if($dmp[plano_acao] == 0) echo "selected"; echo " >Existente</option>";
				echo "<option value='1' "; if($dmp[plano_acao] == 1) echo "selected"; echo " >Sugerido</option>";
				echo "</select>";
				echo "</td>";
				echo "<td align=center class='text roundborder' width=70><input name='cur_pa_data[]' id='cur_data_{$cc[$x][cod_prod]}' onkeydown=\"return only_number(event);\" maxlength='7' OnKeyPress=\"formatar(this, '##/####');\" onkeyup=\"cgrt_mp_sugestao(this, 'cur_pa_{$cc[$x][cod_prod]}');\" class='"; if($dmp[plano_acao]) echo "inputTextobr"; else echo "inputTexto"; echo "' type=text size=7 value='"; if($dmp[data]) echo date("m/Y", strtotime($dmp[data])); echo "' alt='mm/yyyy' title='mm/yyyy'></td>";
			echo "</tr>";
		}
		//faz update na tabela sugestão para ñ exibir cursos repitidos no relatório
		if($_GET[alt]){
		$gx = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." and cod_sugestao = {$_GET[alt]}";
		$xg = pg_query($connect, $gx);
		$gg = pg_fetch_array($xg);
			if($gg[quantidade] == 1){
			$alterar = "update sugestao set quantidade = 0 where id_ppra = ".(int)($_GET[cod_cgrt])." and cod_sugestao = {$_GET[alt]}";
			pg_query($connect, $alterar);
			redirectme("?dir=cgrt&p=index&step=4&cod_cliente={$cod_cliente}&cod_cgrt={$cod_cgrt}");
			}else{
				$alterar = "update sugestao set quantidade = 1 where id_ppra = ".(int)($_GET[cod_cgrt])." and cod_sugestao = {$_GET[alt]}";
				pg_query($connect, $alterar);
				redirectme("?dir=cgrt&p=index&step=4&cod_cliente={$cod_cliente}&cod_cgrt={$cod_cgrt}");
			}
		}
    echo "</table>";

echo "<p>";

/**********************************************************************************************/
// --> DADOS DO APGRE
/**********************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados para o APGRE:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Temperatura:";
        echo "</td>";
        echo "<td class='text' width=490>";
			echo "<select class='text' name='temperatura' id='temperatura' style=\"width: 500px;\">";
			echo "<option value=''></option>";
			echo "<option value='posto de trabalho climatizado e dentro do nível recomendado pela NR 17'"; print $dadoscompl[temperatura] == 'posto de trabalho climatizado e dentro do nível recomendado pela NR 17' ? " selected ":""; echo " alt='posto de trabalho climatizado e dentro do nível recomendado pela NR 17' title='posto de trabalho climatizado e dentro do nível recomendado pela NR 17'>posto de trabalho climatizado e dentro do nível recomendado pela NR 17</option>";
			echo "<option value='posto de trabalho climatizada e acima do nível recomendado pela NR 17'"; print $dadoscompl[temperatura] == 'posto de trabalho climatizada e acima do nível recomendado pela NR 17' ? " selected ":""; echo " alt='posto de trabalho climatizada e acima do nível recomendado pela NR 17' title='posto de trabalho climatizada e acima do nível recomendado pela NR 17'>posto de trabalho climatizada e acima do nível recomendado pela NR 17</option>";
			echo "<option value='posto de trabalho climatizada e abaixo do nível recomendado pela NR 17'"; print $dadoscompl[temperatura] == 'posto de trabalho climatizada e abaixo do nível recomendado pela NR 17' ? " selected ":""; echo " alt='posto de trabalho climatizada e abaixo do nível recomendado pela NR 17' title='posto de trabalho climatizada e abaixo do nível recomendado pela NR 17'>posto de trabalho climatizada e abaixo do nível recomendado pela NR 17</option>";
			echo "<option value='posto de trabalho ausente de climatização e dentro do nível recomendado pela NR 17'"; print $dadoscompl[temperatura] == 'posto de trabalho ausente de climatização e dentro do nível recomendado pela NR 17' ? " selected ":""; echo " alt='posto de trabalho ausente de climatização e dentro do nível recomendado pela NR 17' title='posto de trabalho ausente de climatização e dentro do nível recomendado pela NR 17'>posto de trabalho ausente de climatização e dentro do nível recomendado pela NR 17</option>";
			echo "<option value='posto de trabalho ausente de climatização e abaixo do nível recomendado pela NR 17'"; print $dadoscompl[temperatura] == 'posto de trabalho ausente de climatização e abaixo do nível recomendado pela NR 17' ? " selected ":""; echo " alt='posto de trabalho ausente de climatização e abaixo do nível recomendado pela NR 17' title='posto de trabalho ausente de climatização e abaixo do nível recomendado pela NR 17'>posto de trabalho ausente de climatização e abaixo do nível recomendado pela NR 17</option>";
			echo "<option value='posto de trabalho ventilada naturalmente e dentro do nível recomendado pela NR 17'"; print $dadoscompl[temperatura] == 'posto de trabalho ventilada naturalmente e dentro do nível recomendado pela NR 17' ? " selected ":""; echo " alt='posto de trabalho ventilada naturalmente e dentro do nível recomendado pela NR 17' title='posto de trabalho ventilada naturalmente e dentro do nível recomendado pela NR 17'>posto de trabalho ventilada naturalmente e dentro do nível recomendado pela NR 17</option>";
			echo "<option value='posto de trabalho ventilada naturalmente e abaixo do nível recomendado pela NR 17'"; print $dadoscompl[temperatura] == 'posto de trabalho ventilada naturalmente e abaixo do nível recomendado pela NR 17' ? " selected ":""; echo " alt='posto de trabalho ventilada naturalmente e abaixo do nível recomendado pela NR 17' title='posto de trabalho ventilada naturalmente e abaixo do nível recomendado pela NR 17'>posto de trabalho ventilada naturalmente e abaixo do nível recomendado pela NR 17</option>";
			echo "<option value='posto de trabalho ventilada Mecanicamente e dentro do nível recomendado pela NR 17'"; print $dadoscompl[temperatura] == 'posto de trabalho ventilada Mecanicamente e dentro do nível recomendado pela NR 17' ? " selected ":""; echo " alt='posto de trabalho ventilada Mecanicamente e dentro do nível recomendado pela NR 17' title='posto de trabalho ventilada Mecanicamente e dentro do nível recomendado pela NR 17'>posto de trabalho ventilada Mecanicamente e dentro do nível recomendado pela NR 17</option>";
			echo "<option value='posto de trabalho ventilada Mecanicamente e abaixo do nível recomendado pela NR 17'"; print $dadoscompl[temperatura] == 'posto de trabalho ventilada Mecanicamente e abaixo do nível recomendado pela NR 17' ? " selected ":""; echo " alt='posto de trabalho ventilada Mecanicamente e abaixo do nível recomendado pela NR 17' title='posto de trabalho ventilada Mecanicamente e abaixo do nível recomendado pela NR 17'>posto de trabalho ventilada Mecanicamente e abaixo do nível recomendado pela NR 17</option>";
			echo "</select>&nbsp;";
        echo "</td>";
    echo "</tr>";
	echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Temperatura Elevada:";
        echo "</td>";
        echo "<td class='text' width=490>";
			echo "<select class='text' name='temp_elevada' id='temp_elevada' style=\"width: 500px;\">";
			echo "<option value=''></option>";
			echo "<option value=', existem postos de trabalho com temperatura elevada devido ao enclausuramento e estão dentro dos níveis recomendados pela NR 17'"; print $dadoscompl[temp_elevada] == ', existem postos de trabalho com temperatura elevada devido ao enclausuramento e estão dentro dos níveis recomendados pela NR 17' ? " selected ":""; echo " alt='postos de trabalho com temperatura elevada devido ao enclausuramento e estão dentro dos níveis recomendados pela NR 17' title='postos de trabalho com temperatura elevada devido ao enclausuramento e estão dentro dos níveis recomendados pela NR 17'>postos de trabalho com temperatura elevada devido ao enclausuramento e estão dentro dos níveis recomendados pela NR 17</option>";
			echo "<option value=', existem postos de trabalho com temperatura elevada devido ao enclausuramento e estão abaixo dos níveis recomendados pela NR 17'"; print $dadoscompl[temp_elevada] == ', existem postos de trabalho com temperatura elevada devido ao enclausuramento e estão abaixo dos níveis recomendados pela NR 17' ? " selected ":""; echo " alt='postos de trabalho com temperatura elevada devido ao enclausuramento e estão abaixo dos níveis recomendados pela NR 17' title='postos de trabalho com temperatura elevada devido ao enclausuramento e estão abaixo dos níveis recomendados pela NR 17'>postos de trabalho com temperatura elevada devido ao enclausuramento e estão abaixo dos níveis recomendados pela NR 17</option>";
			echo "</select>&nbsp;";
        echo "</td>";
    echo "</tr>";
	echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Trabalho Céu Aberto:";
        echo "</td>";
        echo "<td class='text' width=490>";
			echo "<select class='text' name='ceu_aberto' id='ceu_aberto' style=\"width: 500px;\">";
			echo "<option value=''></option>";
			echo "<option value='e postos de trabalho com temperatura elevada devido trabalho em céu aberto com insidência solar e estão abaixo dos níveis recomendados pela NR 17'"; print $dadoscompl[ceu_aberto] == 'e postos de trabalho com temperatura elevada devido trabalho em céu aberto com insidência solar e estão abaixo dos níveis recomendados pela NR 17' ? " selected ":""; echo " alt='postos de trabalho com temperatura elevada devido trabalho em céu aberto com insidência solar e estão abaixo dos níveis recomendados pela NR 17' title='postos de trabalho com temperatura elevada devido trabalho em céu aberto com insidência solar e estão abaixo dos níveis recomendados pela NR 17'>postos de trabalho com temperatura elevada devido trabalho em céu aberto com insidência solar e estão abaixo dos níveis recomendados pela NR 17</option>";
			echo "<option value='e postos de trabalho com temperatura baixa devido trabalho em céu aberto com insidência chuvosa e estão abaixo dos níveis recomendados pela NR 17'"; print $dadoscompl[ceu_aberto] == 'e postos de trabalho com temperatura baixa devido trabalho em céu aberto com insidência chuvosa e estão abaixo dos níveis recomendados pela NR 17' ? " selected ":""; echo " alt='postos de trabalho com temperatura baixa devido trabalho em céu aberto com insidência chuvosa e estão abaixo dos níveis recomendados pela NR 17' title='postos de trabalho com temperatura baixa devido trabalho em céu aberto com insidência chuvosa e estão abaixo dos níveis recomendados pela NR 17'>postos de trabalho com temperatura baixa devido trabalho em céu aberto com insidência chuvosa e estão abaixo dos níveis recomendados pela NR 17</option>";
			echo "</select>&nbsp;";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td align=left class='text' width=150>";
        echo "Período da Medição:";
        echo "</td>";
        echo "<td class='text' width=490>";
			echo "<select class='text' name='p_medicao' id='p_medicao' style=\"width: 100px;\">";
			echo "<option value=''></option>";
			echo "<option value='na primavera'"; print $dadoscompl[p_medicao] == 'na primavera' ? " selected ":""; echo ">Primavera</option>";
			echo "<option value='no verão'"; print $dadoscompl[p_medicao] == 'no verão' ? " selected ":""; echo ">Verão</option>";
			echo "<option value='no outono'"; print $dadoscompl[p_medicao] == 'no outono' ? " selected ":""; echo ">Outono</option>";
			echo "<option value='no inverno'"; print $dadoscompl[p_medicao] == 'no inverno' ? " selected ":""; echo ">Inverno</option>";
			echo "</select>&nbsp;";
        echo "</td>";
    echo "</tr>";
    echo "</table>";
echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";


/**********************************************************************************************/
// --> DADOS DO LTCAT
/**********************************************************************************************/
$ltcat_sql = "SELECT c.cod_cgrt, c.cod_cliente, c.ltcat_conclusao, c.quimico, c.fisico, c.biologico, c.ergonomico, c.acidente, 
			r.cod_cliente, r.cod_agente_risco, 
			a.cod_agente_risco, 
			t.cod_tipo_risco, t.nome_tipo_risco 
			FROM cgrt_info c, 
			risco_setor r, 
			agente_risco a, 
			tipo_risco t 
			WHERE c.cod_cgrt = ".$_GET[cod_cgrt]." 
			AND c.cod_cliente = r.cod_cliente 
			AND r.cod_agente_risco = a.cod_agente_risco
			AND a.cod_tipo_risco = t.cod_tipo_risco  
			ORDER BY cod_tipo_risco
			";
			
$ltcat_query = pg_query($ltcat_sql);
$ltcat_array = pg_fetch_all($ltcat_query);

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados para o LTCAT:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
for($x=0;$x<=pg_num_rows($ltcat_query);$x++){
	if($ltcat_array[$x][cod_tipo_risco] != $ltcat_array[$x-1][cod_tipo_risco]){
		if($ltcat_array[$x][cod_tipo_risco] == '1'){
				
			echo '<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold" height=20><b>&nbsp; Parecer de riscos físicos:</b></td>
					</tr>
					<tr>
						<td align="justify" ><textarea name="fisico" cols="82" rows="5">'.$ltcat_array[$x][fisico].'</textarea></td>
					</tr>
					</table><p>';
		}
		if($ltcat_array[$x][cod_tipo_risco] == '2'){
			echo '<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold" height=20><b>&nbsp; Parecer de riscos químicos:</b></td>
					</tr>
					<tr>
						<td align="justify" ><textarea name="quimico" cols="82" rows="5">'.$ltcat_array[$x][quimico].'</textarea></td>
					</tr>
					</table><p>';
		}
		if($ltcat_array[$x][cod_tipo_risco] == '3'){
			echo '<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold" height=20><b>&nbsp; Parecer de riscos biológicos:</b></td>
					</tr>
					<tr>
						<td align="justify" ><textarea name="biologico" cols="82" rows="5">'.$ltcat_array[$x][biologico].'</textarea></td>
					</tr>
					</table><p>';
		}
		if($ltcat_array[$x][cod_tipo_risco] == '4'){
			echo '<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold" height=20><b>&nbsp; Parecer de riscos ergonômicos:</b></td>
					</tr>
					<tr>
						<td align="justify" ><textarea name="ergonomico" cols="82" rows="5">'.$ltcat_array[$x][ergonomico].'</textarea></td>
					</tr>
					</table><p>';
		}
		if($ltcat_array[$x][cod_tipo_risco] == '5'){
			echo'<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold" height=20><b>&nbsp; Parecer de riscos de acidentes:</b></td>
					</tr>
					<tr>
						<td align="justify" ><textarea name="acidente" cols="82" rows="5">'.$ltcat_array[$x][acidente].'</textarea></td>
					</tr>
					</table><p>';
		}
	}
}
			echo'<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold" height=20><b>&nbsp; Conclusão LTCAT:</b></td>
					</tr>
					</table>';
			echo '<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">';
				echo "<tr>";
					echo "<td align=left class='text' width=150>";
					echo '<textarea name="conclusao" cols="82" rows="7">'.$ltcat_array[0][ltcat_conclusao].'</textarea>';
					echo "</td>";
				echo "</tr>";
			echo '</table><p>';

echo "<td>";
echo "</tr>";
echo "</table>";

echo "<p>";

//-------------------------------------------------------------------------------------------------
echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSaveDadosCompl' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</td>";
echo "</form>";
    echo "</tr>";
echo "</table>";
?>