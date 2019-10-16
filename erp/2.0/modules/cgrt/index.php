<?PHP
/***************************************************************************************************/
// --> STEP LIST
//
// 0. Pesquisa de relatórios gerados
// 1. Pesquisa de empresas para gerar um novo relatório
// 2. Configuração de setores, jornada de trabalho, etc...
// 3. Relação de funcionários
// 4. Dados complementares sobre a empresa, pavimentos, etc...
// 5. Seleção de setores para a edição de dados específicos
// 6. Dados sobre edificação como: ventilação, piso, iluminação, parede e cobertura.
// 7. Configuração de posto de trabalho
// 8. Adicionar setores
// 9. Remover setores
// 10. Informações sobre o relatório
// 11. Exclusão do relatório
// 12. Confirmação do relatório
// 13. Gráficos do Histograma (APGRE)
/***************************************************************************************************/
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$step = $_GET[step];
//if(empty($step)) $step = 1; //inutilizado, já que se step = 0, será iniciada pesquisa por registros

//GET CLIENTE DATA
if(is_numeric($_GET[cod_cliente])){
    $sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)($_GET[cod_cliente]);
    $result = pg_query($sql);
    $cinfo = pg_fetch_array($result);
}

if($step > 2){
    if(is_numeric($_GET[cod_cgrt])){
        $sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = $_GET[cod_cgrt]";
        $rci = pg_query($sql);
        $cgrt_info = pg_fetch_array($rci);
    }
    echo "<table width=100% border=0 cellspacing=3 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";

        echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
        echo "<tr>";
            echo "<td alt='Informações gerais sobre os relatórios.' title='Informações gerais sobre os relatórios.' width=175 align=left class='text curhand "; if($_GET[step] == 10 || $_GET[step] == 11) echo "roundborderselected"; else echo "roundbordermix"; echo "' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=10&cod_cliente={$_GET[cod_cliente]}&cod_cgrt={$_GET[cod_cgrt]}';\">";
            echo "Informações dos relatórios";
            echo "</td>";
            echo "<td alt='Informações complementares sobre a empresa.' title='Informações complementares sobre a empresa.' width=175 align=left class='text curhand "; print $_GET[step] == 4 ? "roundborderselected": "roundbordermix"; echo "' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=4&cod_cliente={$_GET[cod_cliente]}&cod_cgrt={$_GET[cod_cgrt]}';\">";
            echo "Dados complementares";
            echo "</td>";
            echo "<td alt='Informações relacionadas ao funcionário, permitindo cadastro, edição e alocação de funcionários.' title='Informações relacionadas ao funcionário, permitindo cadastro, edição e alocação de funcionários' width=175 align=left class='text curhand "; print $_GET[step] == 3 ? "roundborderselected": "roundbordermix"; echo "' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=3&cod_cliente={$_GET[cod_cliente]}&cod_cgrt={$_GET[cod_cgrt]}';\">";// onmouseover=\"showtip('tipbox', '- Selecione um dos setores abaixo para preenchê-lo.');\" onmouseout=\"hidetip('tipbox');\">";
            echo "Lista de funcionários";
            echo "</td>";
            if($cgrt_info[have_posto_trabalho]){
                echo "<td alt='Informações relacionadas ao posto de trabalho.' title='Informações relacionadas ao posto de trabalho.' width=175 align=left class='text curhand "; print $_GET[step] == 7 ? "roundborderselected": "roundbordermix"; echo "' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=7&cod_cliente={$_GET[cod_cliente]}&cod_cgrt={$_GET[cod_cgrt]}';\">";// onmouseover=\"showtip('tipbox', '- Selecione um dos setores abaixo para preenchê-lo.');\" onmouseout=\"hidetip('tipbox');\">";
                echo "Posto de trabalho";
                echo "</td>";
            }
            echo "<td alt='Informações relacionadas aos setores da empresa, permitindo inclusão e exclusão de setores, além do preenchimento dos dados referênte a cada setor cadastrado.' title='Informações relacionadas aos setores da empresa, permitindo inclusão e exclusão de setores, além do preenchimento dos dados referênte a cada setor cadastrado.' width=175 align=left class='text curhand "; print $_GET[step] == 5 || $_GET[step] == 6 || $_GET[step] == 8 || $_GET[step] == 9 || $_GET[step] == 12 ? "roundborderselected": "roundbordermix"; echo "' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=5&cod_cliente={$_GET[cod_cliente]}&cod_cgrt={$_GET[cod_cgrt]}';\">";// onmouseover=\"showtip('tipbox', '- Selecione um dos setores abaixo para preenchê-lo.');\" onmouseout=\"hidetip('tipbox');\">";
            echo "Lista de setores";
            echo "</td>";

            echo "<td align=center class='text'>";
            echo "&nbsp;";
            echo "</td>";

            echo "<td width=40 align=center class='text roundborderselected curhand' alt='Código do cadastro do relatório.' title='Código do cadastro do relatório.'>";
            echo "<b>".str_pad($_GET[cod_cgrt], 4, "0", 0)."</b>";
            echo "</td>";
        echo "</tr>";
        echo "</table>";

    echo "</td>";
    echo "</tr>";
    echo "</table>";
}
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE STEP OF PPRA!!!
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
        switch($step){
/* --> [ STEP 0 ] *********************************************************************************/
            default:
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Busca</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=cgrt&p=index'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca para visualizar os relatórios gerados.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca' onclick=\"if(document.getElementById('search').value==''){return false;}\">";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                
                $sMonth = $_GET[sMonth] > 0 && $_GET[sMonth] < 13 ? $_GET[sMonth] : date("m");
                $sYear  = is_numeric($_GET[sYear]) ? $_GET[sYear] : date("Y");
                
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Busca por data</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Selecione o mês, informe o ano de referência e clique em Busca para visualizar os relatórios gerados.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table border=0 width=100% align=center>";
                        echo "<tr>";
                        echo "<td width=35 class='text'><b>Mês</b></td>";
                        echo "<td class='text'>";
                        echo "<select name='sMonth' id='sMonth'>";
                            echo "<option value='01'"; print $sMonth == 1 ? " selected ":""; echo ">Janeiro</option>";
                            echo "<option value='02'"; print $sMonth == 2 ? " selected ":""; echo ">Fevereiro</option>";
                            echo "<option value='03'"; print $sMonth == 3 ? " selected ":""; echo ">Março</option>";
                            echo "<option value='04'"; print $sMonth == 4 ? " selected ":""; echo ">Abril</option>";
                            echo "<option value='05'"; print $sMonth == 5 ? " selected ":""; echo ">Maio</option>";
                            echo "<option value='06'"; print $sMonth == 6 ? " selected ":""; echo ">Junho</option>";
                            echo "<option value='07'"; print $sMonth == 7 ? " selected ":""; echo ">Julho</option>";
                            echo "<option value='08'"; print $sMonth == 8 ? " selected ":""; echo ">Agosto</option>";
                            echo "<option value='09'"; print $sMonth == 9 ? " selected ":""; echo ">Setembro</option>";
                            echo "<option value='10'"; print $sMonth == 10 ? " selected ":""; echo ">Outubro</option>";
                            echo "<option value='11'"; print $sMonth == 11 ? " selected ":""; echo ">Novembro</option>";
                            echo "<option value='12'"; print $sMonth == 12 ? " selected ":""; echo ">Dezembro</option>";
                        echo "</select>";
                        echo "</td>";
                        
                        echo "<td rowspan=2 align=center class='text'>";
                        echo "<input type='button' class='btn' name='btnSearch2' value='Busca' onclick=\"if(document.getElementById('sYear').value==''){return false;}else{location.href='?dir=$_GET[dir]&p=$_GET[p]&sYear=' + document.getElementById('sYear').value + '&sMonth=' + document.getElementById('sMonth').options[document.getElementById('sMonth').selectedIndex].value;}\">";
                        echo "</td>";
                        
                        echo "</tr><tr>";
                        echo "<td class='text'><b>Ano</b></td>";
                        echo "<td class='text'>";
                        echo "<input type='text' class='inputText' name='sYear' id='sYear' value='{$sYear}' size=5 maxlength=4>";
                        echo "</td>";
                        echo "</tr>";

                        echo "</table>";
                        
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Opções</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=1';\"  onmouseover=\"showtip('tipbox', '- Novo, gera um novo relatório.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
/* --> [ STEP 1 ] *********************************************************************************/
            //BUSCA PELA EMPRESA PARA GERAR O CGRT E LISTA DE CGRT's
            case 1:
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Busca para cadastro</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=cgrt&p=index&step=1'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca para selecionar a empresa e iniciar o cadastro.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca' onclick=\"if(document.getElementById('search').value==''){return false;}\">";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";

                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
/* --> [ STEP 2 ] ********************************************************************************/
            case 2:
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected' onmouseover=\"showtip('tipbox', '- Selecione os setores e tipo de setores a direita.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "<b>Selecione os setores</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<P>";

                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
/* --> [ STEP 3 ] **********************************************************************************/
            case 3:
                //ENVIO DE DADOS - POST
                if($_POST[btnSaveCadFunc] && $_POST){
                
                    $seta = $_POST['setoradicional'];
		            $num =  count($seta);
		            for($x=0;$x<$num;$x++){
		                if($seta[$x]!=$_POST[setorbase]) //se igual ao setor base, não precisa adicionar
        		            $sa .= $seta[$x]."|";
        		    }

                    $cod_cliente             = intval($_GET[cod_cliente]);
                    $cod_setor               = intval($_POST[setorbase]);
                    $nome                    = addslashes($_POST[nome]);
                    $estado                  = addslashes($_POST[estado]);
                    $endereco                = addslashes($_POST[endereco]);
                    $bairro                  = addslashes($_POST[bairro]);
                    $rg                      = addslashes($_POST[rg]);
                    $cep                     = addslashes($_POST[cep]);
                    $num_ctps_func           = addslashes($_POST[ctps]);
                    $serie_ctps_func         = addslashes($_POST[serie]);
                    $cbo                     = addslashes($_POST[cbo]);
                    $cidade                  = addslashes($_POST[cidade]);
                    $cod_status              = addslashes($_POST[status]);
                    $cod_funcao              = addslashes($_POST[cod_funcao]);
                    $cpf                     = addslashes($_POST[cpf]);
                    $sexo_func               = addslashes($_POST[sexo]);
                    $data_nasc_func          = addslashes($_POST[nascimento]);
                    $data_admissao_func      = addslashes($_POST[admissao]);
                    $data_desligamento_func  = addslashes($_POST[demissao]);
                    $dinamica_funcao         = addslashes($_POST[dinamica_funcao]);
                    $naturalidade            = addslashes($_POST[natural]);
                    $nacionalidade           = addslashes($_POST[nacionalidade]);
                    $civil                   = addslashes($_POST[civil]);
                    $cor                     = addslashes($_POST[cor]);
                    $sa                      = $sa;
                    $pis                     = $_POST[pis];
                    $pdh                     = addslashes($_POST[pdh]);
					$revezamento             = addslashes($_POST[revezamento]);
                    $data_ultimo_exame       = $data_ultimo_exame;
					$habilidade				 = addslashes($_POST[habilidade]);
                    
                    //ACCERT DATES
                    if(!empty($_POST[nascimento])){
                        $tmp          = explode("/", addslashes($_POST[nascimento]));
                        if(strlen($tmp[2]) > 2)
                            $data_nasc_func = "'".$tmp[2]."-".$tmp[1]."-".$tmp[0]."'";
                        else
                            $data_nasc_func = "'".addslashes($_POST[nascimento])."'";
                    }else{
                        $data_nasc_func = "null";
                    }

                    if(!empty($_POST[admissao])){
                        $tmp      = explode("/", addslashes($_POST[admissao]));
                        if(strlen($tmp[2]) > 2)
                            $data_admissao_func = "'".$tmp[2]."-".$tmp[1]."-".$tmp[0]."'";
                        else
                            $data_admissao_func = "'".addslashes($_POST[admissao])."'";
                    }else{
                        $data_admissao_func = "null";
                    }

                    if(!empty($_POST[demissao])){
                        $tmp  = explode("/", addslashes($_POST[demissao]));
                        if(strlen($tmp[2]) > 2)
                            $data_desligamento_func = "'".$tmp[2]."-".$tmp[1]."-".$tmp[0]."'";
                        else
                            $data_desligamento_func = "'".addslashes($_POST[demissao])."'";
                    }else{
                        $data_desligamento_func = "null";
                    }

/********************************************************************************************/
//SE FOR PASSADO FID, ATUALIZA CADASTRO DO FUNCIONÁRIO
                    if(is_numeric($_GET[fid])){
                        $cod_func = intval($_GET[fid]);
                    //CHECK IF EXIST IN CGRT_FUNC_LIST AND UPDATE OR INSERT
                        $sql = "SELECT * FROM cgrt_func_list
                        WHERE
                        cod_func = $_GET[fid]
                        AND
                        cod_cliente = $_GET[cod_cliente]
                        AND
                        cod_cgrt = $_GET[cod_cgrt]";
                        $r = pg_query($sql);
                        $buffer = pg_fetch_array($r);
                        
                        if(pg_num_rows($r)>0){
                            $sql = "UPDATE cgrt_func_list
                                    SET cbo='$cbo', cod_funcao='$cod_funcao', cod_setor='$cod_setor', data_admissao=$data_admissao_func,
									dinamica_funcao='$dinamica_funcao', setor_adicional='$sa', status = '$cod_status'
                                    WHERE
                                    cod_func = $_GET[fid]
                                    AND
                                    cod_cliente = $_GET[cod_cliente]
                                    AND
                                    cod_cgrt = $_GET[cod_cgrt]";
                        }else{
                            $sql = "INSERT INTO cgrt_func_list
                                   (cod_func, cod_cliente, cbo, cod_funcao, cod_setor, data_admissao, dinamica_funcao, setor_adicional, cod_cgrt, status)
                                   VALUES
                                   ('{$_GET[fid]}', '{$_GET[cod_cliente]}', '$cbo', $cod_funcao, $cod_setor, $data_admissao_func, '$dinamica_funcao', '$sa', $_GET[cod_cgrt], $cod_status)";
                        }
                        pg_query($sql);
                        
                    /*****************************************************************/

                        $sql = "UPDATE funcionarios
				        SET nome_func			= '$nome'
				        , cod_setor             = '$cod_setor'
					    , estado				= '$estado'
					    , endereco_func			= '$endereco'
					    , bairro_func			= '$bairro'
					    , rg					= '$rg'
					    , cep					= '$cep'
					    , num_ctps_func			= '$num_ctps_func'
					    , serie_ctps_func		= '$serie_ctps_func'
					    , cbo					= '$cbo'
					    , cidade				= '$cidade'
					    , cod_status			= $cod_status
					    , cod_funcao			= $cod_funcao
					    , cpf					= '$cpf'
					    , sexo_func				= '$sexo_func'
					    , data_nasc_func		= $data_nasc_func
					    , data_admissao_func	= $data_admissao_func
					    , data_desligamento_func= $data_desligamento_func
					    , dinamica_funcao		= '$dinamica_funcao'
					    , naturalidade			= '$naturalidade'
					    , nacionalidade			= '$nacionalidade'
					    , civil					= '$civil'
					    , cor					= '$cor'
					    , setor_adicional		= '$sa'
					    , pis					= '$pis'
					    , pdh					= '$pdh'
					    , revezamento			= '$revezamento'
						, habilidade			= '$habilidade'
					    --, data_ultimo_exame		= '$data_ultimo_exame'
                        WHERE cod_cliente = $cod_cliente and cod_func = {$cod_func}";

					    if(@pg_query($sql)){
                            showMessage('Cadastro atualizado com sucesso!', 0);
                            makelog($_SESSION[usuario_id], "[CGRT] Atualização de dados do funcionário: $nome - cód. cliente: $cod_cliente.", 100);
                        }else{
                            showMessage('Houve um erro ao atualizar o cadastro do funcionário!', 1);
                        }
/********************************************************************************************/
//SE NÃO TIVER FID, FAZ UM NOVO CADASTRO COM OS DADOS ENVIADOS
                    }else{
                        $sql = "SELECT max(cod_func) as max
                        FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente]";
                    	$r = pg_query($sql);
                    	$max = pg_fetch_array($r);
                    	$max = $max[max] + 1;
                    	$cod_func = intval($max);
                    	
                        $sql = "INSERT INTO funcionarios(cod_cliente, cod_setor, cod_func, nome_func, estado, endereco_func, bairro_func, rg, cep,
					    num_ctps_func, serie_ctps_func, cbo, cidade, cod_status, cod_funcao, cpf, sexo_func, data_nasc_func, data_admissao_func,
					    data_desligamento_func, dinamica_funcao, naturalidade, nacionalidade, civil, cor, setor_adicional, pis, pdh, revezamento,
						habilidade)
					    VALUES
					    ($cod_cliente, $cod_setor, $cod_func, '$nome', '$estado', '$endereco', '$bairro', '$rg', '$cep', '$num_ctps_func',
					    '$serie_ctps_func', '$cbo', '$cidade', $cod_status, $cod_funcao, '$cpf', '$sexo_func', $data_nasc_func, $data_admissao_func,
					    $data_desligamento_func, '$dinamica_funcao', '$naturalidade', '$nacionalidade', '$civil', '$cor', '$sa', '$pis', '$pdh',
					    '$revezamento', '$habilidade')";

                        if(@pg_query($sql)){
                            //insert into cgrt_func_list a new reg
                            $sql = "INSERT INTO cgrt_func_list
                                   (cod_func, cod_cliente, cbo, cod_funcao, cod_setor, data_admissao, dinamica_funcao, setor_adicional, ano, cod_cgrt)
                                   VALUES
                                   ('{$cod_func}', '{$_GET[cod_cliente]}', '$cbo', $cod_funcao, $cod_setor, '$data_admissao_func', '$dinamica_funcao', '$sa', ".date("Y").", $_GET[cod_cgrt])";
                           @pg_query($sql);
                            showMessage('Cadastro efetuado com sucesso!', 0);
                            makelog($_SESSION[usuario_id], "[CGRT] Inclusão do funcionário: $nome - cód. cliente: $cod_cliente.", 101);
                        }else{
                            showMessage('Houve um erro ao efetuar o cadastro do funcionário!', 1);
                        }
                    }
                }
                
                //EXIBE LISTA DE FUNCIONÁRIOS CADASTRADOS
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Lista de funcionários</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                $sql = "
                   SELECT
                       cg.cod_func, 1 as t, f.nome_func, cg.cod_funcao, cg.cod_setor
                    FROM
                       cgrt_func_list cg, funcionarios f
                    WHERE
                       cg.cod_cliente = $_GET[cod_cliente] AND
                       cg.cod_cgrt = $_GET[cod_cgrt] AND
                       cg.cod_cliente = f.cod_cliente AND
                       f.cod_func = cg.cod_func AND
					   f.cod_status = 1
                    UNION
                    SELECT
                       cod_func, 0 as t, nome_func, CAST(cod_funcao as integer), 0 as cod_setor
                    FROM
                       funcionarios
                    WHERE
                       cod_cliente = $_GET[cod_cliente] AND
					   cod_status = 1 AND
                       cod_func
                    NOT IN
                       (SELECT cod_func FROM cgrt_func_list WHERE cod_cliente = $_GET[cod_cliente] AND cod_cgrt = $_GET[cod_cgrt])
                    ORDER BY nome_func";

                $res = pg_query($sql);
                $flist = pg_fetch_all($res);
   			   
                // --> FUNC LIST
				
				
				$cod_cgrt = $_GET[cod_cgrt];
				
				
				$sql = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun
		WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func
		AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1 AND f.cod_status = 1 ORDER BY f.nome_func";
				$rfl = pg_query($sql);
				$funclist = pg_fetch_all($rfl);
				
				
				
				echo "Efetivo:".str_pad(pg_num_rows($rfl), 2, "0", 0);
				
				
				
				
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                    echo "<select name=funcid size=20 style=\"width: 240px;\" onchange=\"location.href='?dir=cgrt&p=index&step=3&cod_cliente={$_GET[cod_cliente]}&cod_cgrt={$_GET[cod_cgrt]}&fid='+this.value;\">";
                        for($x=0;$x<pg_num_rows($res);$x++){
                            echo "<option value='{$flist[$x][cod_func]}' ";
                            print $flist[$x][cod_func] == $_GET[fid] ? " selected " : "";
                            echo ">";
                            print empty($flist[$x][cod_setor]) ? "*" : " ";
                            echo "{$flist[$x][nome_func]}</option>";
                        }
                    echo "</select>";

                    echo "</td>";
                    echo "<table width=250 border=0 cellspacing=0 cellpadding=0>";
                        echo "<tr>";
                        echo "<td align=left class='text'>";
                            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                            echo "<tr>";
                                echo "<td align=center class='text roundbordermix'>";
                                echo "<input type='button' class='btn' name='btnNew' value='Novo' onmouseover=\"showtip('tipbox', '- Novo, permite o cadastro de um novo fucionário.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=index&step=3&cod_cliente={$_GET[cod_cliente]}&cod_cgrt={$_GET[cod_cgrt]}&fid=new';\">";
                            echo "</td>";
                        echo "</tr>";
                    echo "</table>";
                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "</tr>";
                echo "</table>";
            break;
            
/* --> [ STEP 4 ] **********************************************************************************/
            case 4:
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Dados complementares</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                
                echo "<P>";

                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
            
/* --> [ STEP 5/6/9 ] *********************************************************************************/
// MULTIPLOS
            case 5://seleção de setores
            case 6://edificação
            case 9://del setor
            case 12: //liberar cgrt
            
                //deleção de setor
                if($_POST && $_POST[btnDelSetor] && $_GET[step] == 9){
                    $sql = "DELETE FROM cliente_setor WHERE
                        id_ppra = ".(int)($_GET[cod_cgrt])."
                    AND
                        cod_setor = ".(int)($_GET[cod_setor])."
                    AND
                        cod_cliente = ".(int)($_GET[cod_cliente]);
                    $rds = pg_query($sql);
                }

                $sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = {$_GET[cod_cgrt]}"; //SELECT i.*, c.* FROM cgrt_info i, cliente c WHERE cod_cgrt = 5 AND i.cod_cliente = c.cliente_id
                $res = pg_query($sql);
                $info = pg_fetch_array($res);

                $sql = "SELECT s.cod_setor, s.nome_setor FROM cliente_setor c, setor s WHERE c.id_ppra = {$_GET[cod_cgrt]} AND s.cod_setor = c.cod_setor ORDER BY s.nome_setor";
                $r = pg_query($sql);
                $setores = pg_fetch_all($r);
                
                // OPÇÕES DO CLIENTE
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Opções</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Adicionar Setor' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=8&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]';\" onmouseover=\"showtip('tipbox', '- Adicionar Setor, permite a inserção de um novo setor ao relatório.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        if(empty($cgrt_info[cgrt_finished]))
                            echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Finalizar CGRT'  onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=12&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]';\"  onmouseover=\"showtip('tipbox', '- Finalizar CGRT, Finaliza os relatórios, permitindo acesso no site.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        else
                            echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Liberar relatório'  onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=12&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]';\"  onmouseover=\"showtip('tipbox', '- Liberar relatório, altera relatórios exibidos no site para um cadastro já finalizado.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";

                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                
                
                //LISTA DE SETORES CADASTRADOS - LEFT SIDE
                
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected' onmouseover=\"showtip('tipbox', '- Selecione um dos setores abaixo para preenchê-lo.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "<b>Setores cadastrados</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                for($x=0;$x<pg_num_rows($r);$x++){
                    echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                    echo "<tr>";
                    if($_GET[cod_setor] == $setores[$x][cod_setor]){
                        echo "<td class='roundborderselected text' height=30 valign=top>";
                    }else{
                        echo "<td class='roundbordermix text' height=30 valign=top>";
                    }
                        echo "<table border=0 width=100% align=center cellspacing=2 cellpadding=0>";
                        echo "<tr>";
                        echo "<td class='text curhand' width=210 onclick=\"location.href='?dir=cgrt&p=index&step=6&cod_cliente={$info[cod_cliente]}&cod_cgrt={$info[cod_cgrt]}&cod_setor={$setores[$x][cod_setor]}"; print $_GET[sp] ? "&sp=$_GET[sp]":""; echo "';\">";
                        echo "<span title='{$setores[$x][nome_setor]}' alt='{$setores[$x][nome_setor]}'>".substr($setores[$x][nome_setor], 0, 25); print strlen($setores[$x][nome_setor]) > 25 ? "..." : ""; echo "</span>";
                        echo "</td>";
                        echo "<td class='text roundborderselectedred curhand' width=15 align=center alt='Excluir este setor' title='Excluir este setor'onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=9&cod_cliente={$info[cod_cliente]}&cod_cgrt={$info[cod_cgrt]}&cod_setor={$setores[$x][cod_setor]}"; print $_GET[sp] ? "&sp=$_GET[sp]":""; echo "';\">";
                        echo "<span style=\"font-size: 8px;\">X</span>";
                        echo "</td>";
                        echo "</tr>";
                        echo "</table>";

                        echo "<table border=0 width=100% align=center cellspacing=0 cellpadding=0 style=\"height: 5px;\">";
                        echo "<tr>";
                        //rnd apenas para efeito de teste, cálculo está ok para exibição de %
                        $fatmult = cgrt_setor_progress((int)($_GET[cod_cgrt]), (int)($setores[$x][cod_setor]));//rand(0, 100);
                        $concluido = ($fatmult * 236)/100;
                        echo "<td style=\"border: 1px #000000 solid; height: 5px;\" height=5 alt='{$fatmult}% concluído' title='{$fatmult}% concluído'><img src=\"images/bar.png\" width='{$concluido}' height=5 border=0></td>"; //width=236
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                    echo "<BR>";
                }

            break;
/* --> [ STEP 7 ] **********************************************************************************/
// --> POSTO DE TABALHO
            case 7:
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Opções</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]'>";
                    echo "<td class='roundbordermix text' height=30 align=center>";
                        echo "<input type='button' class='btn' name='btnNewPT' value='Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&a=n';\">";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";

                echo "<P>";

                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
/* --> [ STEP 8 ] **********************************************************************************/
// --> ADICIONAR NOVO SETOR
            case 8:
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Adicionar setor</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<P>";

                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
/* --> [ STEP 10 ] **********************************************************************************/
// --> INFORMAçÕES GERAIS SOBRE O RELATÓRIO
            case 10:
            case 11:
                
				$sql = "SELECT * FROM cgrt_info WHERE cod_cliente = {$_GET[cod_cliente]} and cod_cgrt='$_GET[cod_cgrt]'";
				$res = pg_query($sql);
				$buffer = pg_fetch_array($res);
				
				$ano = $buffer[ano] + 1;

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Opções</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
				
				echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
					
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<form method=POST name='form1' action='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]'>";
                    echo "<tr>";
					echo "<td class='text' align=center>";
                        echo "<input type='button' class='btn' name='btnDelCGRT' value='Excluir cadastro' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=11&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]';\" onmouseover=\"showtip('tipbox', '- Excluir Cadastro, irá deletar todos os dados do CGRT.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "</td>";
					echo "<td>";
						echo "<input type='button' class='btn' name='btnAddGraf' value='ADD Gráficos' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=13&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]';\" onmouseover=\"showtip('tipbox', '- Adicionar Gráfico, permite a inserção de dados para gerar um gráfico no relatório do APGRE.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td class='text' align=center>";
						echo "<input type='button' class='btn' name='btnDP' value='Duplicar' onClick=\"if(prompt('Informe o ano de referência para duplicação:','$ano')) {location.href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&y={$ano}';}\">";
					echo "</td>";
					echo "<td>";
						echo "&nbsp;";
					echo "</td>";
					echo "</tr>";
                echo "</form>";
                echo "</table>";
				
					echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<P>";

                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
/* --> [ STEP 13 ] **********************************************************************************/
// --> ADICIONAR GRÁFICOS NO APGRE
            case 13:
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Dados do Histograma</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<P>";

                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
        }
        echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE STEP OF PPRA!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        switch($step){
/* --> [ STEP 0 ] *********************************************************************************/
            default:
                //BUSCA DE CADASTROS GERADOS
                include('list.php');
            break;

/* --> [ STEP 1 ] *********************************************************************************/
            case 1:
                //BUSCA PELA EMPRESA PARA GERAR O CGRT E LISTA DE CGRT's
                include('step_1.php');
            break;
/* --> [ STEP 2 ] *********************************************************************************/
            case 2:
                //CONFIGURAÇÃO DOS SETORES, JORNADA DE TRABALHO E ANO DE REFERÊNCIA
                include('step_2.php');
            break;
/* --> [ STEP 3 ] *********************************************************************************/
            case 3:
                //LISTA / CADASTRO DE FUNCIONÁRIOS
                include('step_3.php');
            break;
/* --> [ STEP 4 ] *********************************************************************************/
            case 4:
                //DADOS COMPLEMENTARES
                include('step_4.php');
            break;
/* --> [ STEP 5 ] *********************************************************************************/
            case 5:
                //SELEÇÃO DE SETORES
                include('step_5.php');
            break;
/* --> [ STEP 6 ] *********************************************************************************/
            case 6:
                //Edificação, ventilação, piso, iluminação, parede e cobertura;
                include('step_6.php');
            break;
/* --> [ STEP 7 ] *********************************************************************************/
            case 7:
                //CONFIGURAÇÃO DE POSTO DE TRABALHO
                include('step_7.php');
            break;
/* --> [ STEP 8 ] *********************************************************************************/
            case 8:
                //ADD SETORES
                include('step_8.php');
            break;
/* --> [ STEP 9 ] *********************************************************************************/
            case 9:
                //DEL SETORES
                include('step_9.php');
            break;
/* --> [ STEP 10 ] *********************************************************************************/
            case 10:
                //INFORMAÇÕES DO RELATÓRIO
                include('step_10.php');
            break;
/* --> [ STEP 11 ] *********************************************************************************/
            case 11:
                //EXCLUSÃO DO RELATÓRIO
                include('step_11.php');
            break;
/* --> [ STEP 12 ] *********************************************************************************/
            case 12:
                //CONFIRMAÇÃO DO RELATÓRIO
                include('step_12.php');
            break;
/* --> [ STEP 13 ] *********************************************************************************/
            case 13:
                //ADD GRÁFICOS NO APGRE
                include('step_13.php');
            break;
        }
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>