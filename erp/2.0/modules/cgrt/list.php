<?PHP
/***************************************************************************************************/
// --> BUSCA PELA EMPRESA PARA GERAR O CGRT E LISTA DE CGRT's
/***************************************************************************************************/
if($_POST || $_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){
    $searchtxt = anti_injection($_POST[search]);
    if($_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){
    //Busca por Mês e Ano
        $sql = "SELECT
                    i.*, c.*
                FROM
                    cgrt_info i, cliente c
                WHERE
                    i.cod_cliente = c.cliente_id
                AND
                    i.ano = {$_GET[sYear]}
                AND
                    EXTRACT(month FROM data_criacao) = '{$_GET[sMonth]}'
                ";
    }else{
    //Busca por texto ou cód cliente
        if(is_numeric($searchtxt)){
            $sql = "SELECT
                        i.*, c.*
                    FROM
                        cgrt_info i, cliente c
                    WHERE
                        i.cod_cliente = c.cliente_id
                    AND(
                        c.cliente_id = $searchtxt
                    OR
                        lower(c.razao_social) LIKE '%".strtolower($searchtxt)."%'
                    )
					ORDER BY i.ano desc";
        }else{
            $sql = "SELECT
                        i.*, c.*
                    FROM
                        cgrt_info i, cliente c
                    WHERE
                        i.cod_cliente = c.cliente_id
                    AND
                        lower(c.razao_social) LIKE '%".strtolower($searchtxt)."%'
					ORDER BY i.ano desc";
        }
    }
    $result = pg_query($sql);
    $clist = pg_fetch_all($result);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
        if($_POST[search]){
            echo "<b>Resultado de busca por</b> $searchtxt";
        }elseif($_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){
            echo "<b>Resultado de busca por data</b> ".$_GET[sMonth]."/".$_GET[sYear];
        }

    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
    if(pg_num_rows($result)>0){
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
				echo "<td width=40 align=left class='text'>";
				echo "<b>CGRT</b>";
				echo "</td>";
                echo "<td align=left class='text'>";
                echo "<b>Empresa</b>";
                echo "</td>";
                echo "<td width=40 align=left class='text'>";
                echo "<b>Ano</b>";
                echo "</td>";
                echo "<td width=240 colspan=5 align=left class='text'>";
                echo "<b>Relatórios</b>";
                echo "</td>";
            echo "</tr>";
        for($x=0;$x<pg_num_rows($result);$x++){
                echo "<tr>";
                echo "<td align=left class='text roundbordermix curhand' alt='{$clist[$x][cod_cgrt]}' title='{$clist[$x][cod_cgrt]}' onmouseover=\"showtip('tipbox', '- Clique na razão social da empresa para acessar os dados cadastrados para os relatórios técnicos.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=index&step=10&cod_cliente={$clist[$x][cliente_id]}&cod_cgrt={$clist[$x][cod_cgrt]}';\">";
                    echo str_pad($clist[$x][cod_cgrt], 3, '0', 0);
                echo "</td>";
				echo "<td align=left class='text roundbordermix curhand' alt='{$clist[$x][razao_social]}' title='{$clist[$x][razao_social]}' onmouseover=\"showtip('tipbox', '- Clique na razão social da empresa para acessar os dados cadastrados para os relatórios técnicos.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=index&step=10&cod_cliente={$clist[$x][cliente_id]}&cod_cgrt={$clist[$x][cod_cgrt]}';\">";
                    echo substr($clist[$x][razao_social], 0, 45);
                echo "</td>";
                echo "<td align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', '- Clique na razão social da empresa para acessar os dados cadastrados para os relatórios técnicos.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=index&step=10&cod_cliente={$clist[$x][cliente_id]}&cod_cgrt={$clist[$x][cod_cgrt]}';\">";
                    echo $clist[$x][ano];
                echo "</td>";
                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'PPRA - Exibe o relatório do Programa de Prevenção de Riscos Ambientais.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorios/ppra/?cod_cgrt=".base64_encode((int)($clist[$x][cod_cgrt]))."');\">";
                    echo "PPRA";
                echo "</td>";
                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=list_ppp&cod_cliente={$clist[$x][cliente_id]}&cod_cgrt={$clist[$x][cod_cgrt]}';\">";
                    echo "PPP";
                echo "</td>";
                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'PCMSO - Exibe o relatório do Programa de Controle Médico de Saúde Ocupacional.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorios/pcmso/?cod_cgrt=".base64_encode((int)($clist[$x][cod_cgrt]))."');\">";
                    echo "PCMSO";
                echo "</td>";
                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'APGRE - Exibe o relatório da Avaliação Preliminar e Gerenciamento de Riscos Ergonômicos.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorios/apgre/?cod_cgrt=".base64_encode((int)($clist[$x][cod_cgrt]))."')\">";
                    echo "APGRE";
                echo "</td>";
                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'LTCAT.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorios/ltcat/?cod_cgrt=".base64_encode((int)($clist[$x][cod_cgrt]))."')\">";
                    echo "LTCAT";
                echo "</td>";
                echo "<td width=40 align=center class='text roundbordermix'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">";
                    echo "PCMAT";
                echo "</td>";
                echo "</tr>";
        }
        echo "</table>";
    }else{
    //caso não seja encontrado nenhum registro
        if($_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){
            echo "Não foram encontrados registros para a data informada.";
        }else{
            echo "Não foram encontrados relatórios para o termo informado.";
        }
    }
    echo "<td>";
    echo "</tr>";
    echo "</table>";
}else{

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
        echo "<b>Busca por relatórios</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
}
?>
