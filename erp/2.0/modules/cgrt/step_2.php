<?PHP
/***************************************************************************************************/
// --> CONFIGURAÇÃO DOS SETORES, JORNADA DE TRABALHO E ANO DE REFERÊNCIA
/***************************************************************************************************/
    $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $result = pg_query($sql);
    $cinfo = pg_fetch_array($result);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
        echo "<b>$cinfo[razao_social]</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<p>";

// SAVE DATA
if($_POST[btnSaveSetores] && $_POST){
    //GET ID FOR PPRA BY YEAR
    $cod = "SELECT max(cod_ppra) as cod_ppra FROM cliente_setor WHERE EXTRACT(year from data_criacao) = ".date('Y')."";
    $res = pg_query($cod);
	$row = pg_fetch_array($res);
	$cod_ppra = $row[cod_ppra] + 1;

    //GET THE MAX ID FOR ID_PPRA
    $sql = "SELECT MAX(id_ppra) as max FROM cliente_setor";
    $rz =  pg_query($sql);
    $max = pg_fetch_array($rz);
    $id_ppra = $max[max]+1;
    
    $sql = "INSERT INTO cgrt_info (cod_cgrt, cod_cliente, jornada, ano, data_criacao, id_resp_ppra, id_resp_pcmso, cod_ppra, have_posto_trabalho, terceirizado)
    VALUES ($id_ppra, '{$_GET[cod_cliente]}', '{$_POST[jornada]}', '{$_POST[anoreferencia]}', '".date("Y-m-d")."', $_POST[ppra_resp], $_POST[pcmso_resp], $cod_ppra, $_POST[pt_existente], '{$_POST[terc]}')";
    if(@pg_query($sql)){
        /*
        $sql = "SELECT MAX(cod_cgrt) as max FROM cgrt_info";
        $res = pg_query($sql);
        $max = pg_fetch_array($res);
        $max = $max[max];
        */
        for($x=0;$x<count($_POST[cod_setor]);$x++){
            $sql = "INSERT INTO cliente_setor
            (cod_cliente, cod_setor, tipo_setor, cod_ppra, data_criacao, jornada, funcionario_id, id_ppra, elaborador_pcmso, is_posto_trabalho)
            values
            ($_GET[cod_cliente], {$_POST[cod_setor][$x]}, '{$_POST[tipo_setor][$x]}', $cod_ppra,'".$_POST[anoreferencia].date("-m-d")."', '{$_POST[jornada]}', $_POST[ppra_resp], $id_ppra, $_POST[pcmso_resp], {$_POST[posto_trabalho][$x]})";
            @pg_query($sql);
        }
        if($_POST[pt_existente]){
            redirectme("?dir=cgrt&p=index&step=7&cod_cliente={$_GET[cod_cliente]}&cod_cgrt=$id_ppra");
        }else{
            redirectme("?dir=cgrt&p=index&step=3&cod_cliente={$_GET[cod_cliente]}&cod_cgrt=$id_ppra");
        }
    }else{
        showMessage('Não foi possível gerar este relatório. Por favor, entre em contato com o setor de suporte!',1);
    }
}else{
    echo "<form method=POST name='form2'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        //Seleciona todos os setores cadastrados
        $sql = "SELECT cod_setor, desc_setor, nome_setor FROM setor where cod_setor <> 0 ORDER BY nome_setor";
        $res = pg_query($sql);
        $set = pg_fetch_all($res);

        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td class='text'><b>Configuração de setores:</b></td>";
        echo "<td class='text' width=155><b>Posto de trabalho:</b></td>";
        echo "<td class='text' width=120><b>Tipo:</b></td>";
        echo "</tr>";
        for($y=0;$y<$_GET[setores];$y++){
            echo "<tr class='text roundbordermix'>";
                echo "<td align=left class='text roundborder'  onmouseover=\"showtip('tipbox', '- Selecione um dos setores listados, informe se este setor está localizado na empresa ou em um posto de trabalho fora da empresa e seu respectivo tipo.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "Setor ".str_pad(($y+1), 2, "0", 0).":&nbsp;";
                    echo "<select name='cod_setor[]' style=\"width: 300px;\" class='inputTextobr'>";
                        for($z=0;$z<pg_num_rows($res);$z++){
                            echo "<option value='{$set[$z][cod_setor]}'>".substr($set[$z][nome_setor], 0, 71)."</option>";
                        }
                    echo "</select>";
                echo "</td>";
                echo "<td align=left class='text roundborder' width=120  onmouseover=\"showtip('tipbox', '- Selecione um dos setores listados e seu respectivo tipo.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "<select name='posto_trabalho[]' id='posto_trabalho[]' class='inputTextobr' onchange=\"checkSetorConfig();\">";
                        echo "<option value=0>Dentro da empresa</option>";
                        echo "<option value=1>Fora da empresa</option>";
                    echo "</select>";
                echo "</td>";
                echo "<td align=center class='text roundborder' width=120  onmouseover=\"showtip('tipbox', '- Selecione um dos setores listados e seu respectivo tipo.');\" onmouseout=\"hidetip('tipbox');\">";
                    //echo "Tipo:&nbsp;";
                    echo "<select name='tipo_setor[]' class='inputTextobr'> ";
                    echo "<option value='Administrativo'>Administrativo</option>";
                    echo "<option value='Operacional'>Operacional</option>";
                    echo "</select>";
                echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<p>";
        
        echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
        echo "<tr>";
        echo "<td align=left class='text'>";
            echo "<b>Configuração de posto de trabalho:</b>";
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
                echo "<td align=left class='text roundbordermix' onmouseover=\"showtip('tipbox', '- Informe se existe um posto de trabalho fora da empresa contratada. Caso sim, será solicitado o cadastramento ou seleção de um posto de trabalho posteriormente.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "Posto de trabalho existente:&nbsp;";
                    echo "<select class='inputTextobr' name='pt_existente' id='pt_existente'>";
                        echo "<option value='0'>Não</option>";
                        echo "<option value='1'>Sim</option>";
                    echo "</select>";
                echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";

        echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
        echo "<tr>";
        echo "<td align=left class='text'>";
            echo "<b>Configuração de funcionário terceirizado:</b>";
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
                echo "<td align=left class='text roundbordermix' onmouseover=\"showtip('tipbox', '- Informe se existe um funcionário terceirizado na empresa.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "Funcionário terceirizado existente:&nbsp;";
                    echo "<select class='inputTextobr' name='terc' id='terc'>";
						echo "<option value=''></option>";
                        echo "<option value='nao'>Não</option>";
                        echo "<option value='sim'>Sim</option>";
                    echo "</select>";
                echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";

        echo "<p>";

        echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
        echo "<tr>";
        echo "<td align=left class='text'>";
            echo "<b>Configuração de jornada de trabalho:</b>";
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
                echo "<td align=left class='text roundbordermix'  onmouseover=\"showtip('tipbox', '- Informe o número de horas trabalhadas por dia.');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "Número de horas diárias:&nbsp;";
                    echo "<input type='text' class='inputTextobr' name='jornada' id='jornada' value='8' size=5>";
                echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";

        echo "<p>";


        echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
        echo "<tr>";
        echo "<td align=left class='text'>";
            echo "<b>Elaborador(a) Responsável:</b>";
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            
            $sql = "SELECT * FROM funcionario WHERE cargo_id = 15 OR cargo_id = 17 ORDER BY nome";
            $res_ppra = pg_query($sql);
            $ppra_f = pg_fetch_all($res_ppra);
            echo "<tr class='text roundbordermix' onmouseover=\"showtip('tipbox', '- Selecione o responsável pela elaboração do PPRA.');\" onmouseout=\"hidetip('tipbox');\">";
                echo "<td width=60 align=left class='text roundborder'>";
                    echo "PPRA:&nbsp;";
                echo "</td>";
                echo "<td align=left class='text roundborder'>";
                    echo "<select name='ppra_resp' style=\"width: 300px;\" class='inputTextobr'>";
                        for($x=0;$x<pg_num_rows($res_ppra);$x++){
                            echo "<option value='{$ppra_f[$x][funcionario_id]}'>{$ppra_f[$x][nome]}</option>";
                        }
                    echo "</select>";
                echo "</td>";
            echo "</tr>";
            
            $sql = "SELECT * FROM funcionario WHERE cargo_id = 1001 ORDER BY nome";
            $res_pcmso = pg_query($sql);
            $pcmso_f = pg_fetch_all($res_pcmso);
            
            echo "<tr class='text roundbordermix' onmouseover=\"showtip('tipbox', '- Selecione o responsável pela elaboração do PCMSO.');\" onmouseout=\"hidetip('tipbox');\">";
                echo "<td width=60 align=left class='text roundborder'>";
                    echo "PCMSO:&nbsp;";
                echo "</td>";
                echo "<td align=left class='text roundborder'>";
                    echo "<select name='pcmso_resp' style=\"width: 300px;\" class='inputTextobr'>";
                        for($y=0;$y<pg_num_rows($res_pcmso);$y++){
                            echo "<option value='{$pcmso_f[$y][funcionario_id]}'>{$pcmso_f[$y][nome]}</option>";
                        }
                    echo "</select>";
                echo "</td>";
            echo "</tr>";
            
            echo "</table>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";

        echo "<p>";

        echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
        echo "<tr>";
        echo "<td align=left class='text'>";
            echo "<b>Configuração de ano de referência:</b>";
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
                echo "<td align=left class='text roundbordermix' onmouseover=\"showtip('tipbox', '- Informe o ano de referência para o cadastro das informações. <BR>Esta informação tem como objetivo, permitir que relatórios de anos anteriores sejam cadastrados. ');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "Ano:&nbsp;";
                    echo "<input type='text' class='inputTextobr' name='anoreferencia' id='anoreferencia' value='".date("Y")."' size=5>";
                echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";

        echo "<p>";

        echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
        echo "<tr>";
        echo "<td align=left class='text'>";
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
                echo "<td align=center class='text roundbordermix'>";
                    echo "<input type='submit' class='btn' name='btnSaveSetores' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\">";
                echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";

    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
}
?>
