<?PHP
/***************************************************************************************************/
// --> BUSCA PELA EMPRESA PARA GERAR O CGRT E LISTA DE CGRT's
/***************************************************************************************************/
if($_POST){
    $searchtxt = anti_injection($_POST[search]);
    if(is_numeric($searchtxt))
        $sql = "SELECT * FROM cliente WHERE cliente_id = '$searchtxt' OR LOWER(razao_social) LIKE '%".strtolower($searchtxt)."%'";
    else
        $sql = "SELECT * FROM cliente WHERE LOWER(razao_social) LIKE '%".strtolower($searchtxt)."%'";
    $result = pg_query($sql);
    $clist = pg_fetch_all($result);

    /*
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>Busca pelo cliente:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";

        echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
        echo "<form method=POST name='frmSearchType1'>";
        echo "<tr>";
        echo "<td align=left class=text width='480'>";
            echo "<input type='text' class='inputTextobr' name='search' id='search' value='{$_POST[search]}' size=45 maxlength=500>";
            echo "&nbsp;";
            echo "<input type='submit' class='btn' name='btnSearchType1' value='Busca'>";
        echo "</td>";
        echo "</tr>";
        echo "</form>";
        echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<p>";

    echo "<table width=100% border=0 height=200>";
    echo "<tr>";
    echo "<td valign=top>";
    if($_POST && $_POST[btnSearchType1] && !empty($_POST[search])){
        if(is_numeric($_POST[search])){
            $sql = "SELECT * FROM cliente WHERE cliente_id = $_POST[search] OR lower(razao_social) LIKE '%".strtolower($_POST[search])."%'";
        }else{
            $sql = "SELECT * FROM cliente WHERE lower(razao_social) LIKE '%".strtolower($_POST[search])."%'";
        }
        $res = pg_query($sql);
        $buf = pg_fetch_all($res);
        if(pg_num_rows($res)>0){
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td width=35 class='text' ><b>Cód.</b></td><td class='text'><b>Razão Social</b></td>";
            echo "</tr>";
            for($x=0;$x<pg_num_rows($res);$x++){
                echo "<tr class='text roundbordermix'>";
                echo "<td class='text roundborder' align=center>".str_pad($buf[$x][cliente_id], 4, "0", 0)."</td><td class='text roundborder curhand' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=new_enc_fl&type={$_GET[type]}&cod_cliente={$buf[$x][cliente_id]}';\">{$buf[$x][razao_social]}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            showMessage("A pesquisa por <b>{$_POST[search]}</b> não retornou resultados.",2);
        }
    }
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    */
    


    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
        echo "<b>Resultado de busca para:</b> $_POST[search]";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<p>";
    if(pg_num_rows($result)>0){
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td class='text'>";
            echo "<b>Resultados:</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        for($x=0;$x<pg_num_rows($result);$x++){
            echo "<tr class='roundbordermix'>";
            //echo "<td class='text'>";
                //echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                //echo "<tr class='text'>";
                echo "<td class='text roundborder' width=35 align=center>".str_pad($clist[$x][cliente_id], 4, "0", 0)."</td>";
                echo "<td class='text roundborder curhand' onclick=\"var setores = prompt('Informe o número de setores para a empresa: ".addslashes($clist[$x][razao_social]).":','1'); if(setores > 0){location.href='?dir=cgrt&p=index&step=2&cod_cliente={$clist[$x][cliente_id]}&setores='+setores;}\">{$clist[$x][razao_social]}</td>";
                //echo "</tr>";
                //echo "</table>";
            //echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }else{
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td class='text roundborder'>";
            echo "A busca por <b>$_POST[search]</b> não retornou resultados!";
            echo "<BR>";
            echo "Verifique o excesso/falta de acentuação ou tente novamente com outro termo.";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    }
}else{
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
        echo "<b>Gerar novo relatório</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
    echo "- Para iniciar o cadastro, faça uma busca pela empresa no campo ao lado e selecione a empresa desejada.";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

/*
    $sql = "SELECT i.*, c.* FROM cgrt_info i, cliente c WHERE i.cod_cliente = c.cliente_id";
    $result = pg_query($sql);
    $clist = pg_fetch_all($result);
    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=left class='text'>";
            echo "<b>Empresa:</b>";
            echo "</td>";
            echo "<td width=300 colspan=6 align=left class='text'>";
            echo "<b>Relatórios</b>";
            echo "</td>";
        echo "</tr>";
    for($x=0;$x<pg_num_rows($result);$x++){
            echo "<tr>";
            echo "<td align=left class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', '- Clique na razão social da empresa para acessar os dados cadastrados para os relatórios técnicos.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cgrt&p=index&step=3&cod_cliente={$clist[$x][cliente_id]}&cod_cgrt={$clist[$x][cod_cgrt]}';\">";
                echo $clist[$x][razao_social];
            echo "</td>";
            echo "<td width=50 align=center class='text roundbordermix'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">";
                echo "PPRA";
            echo "</td>";
            echo "<td width=50 align=center class='text roundbordermix'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">";
                echo "PPP";
            echo "</td>";
            echo "<td width=50 align=center class='text roundbordermix'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">";
                echo "PCMSO";
            echo "</td>";
            echo "<td width=50 align=center class='text roundbordermix'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">";
                echo "APGRE";
            echo "</td>";
            echo "<td width=50 align=center class='text roundbordermix'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">";
                echo "LTCAT";
            echo "</td>";
            echo "<td width=50 align=center class='text roundbordermix'  onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">";
                echo "PCMAT";
            echo "</td>";
            echo "</tr>";
    }
    echo "</table>";
    echo "<td>";
    echo "</tr>";
    echo "</table>";
*/
}
?>
