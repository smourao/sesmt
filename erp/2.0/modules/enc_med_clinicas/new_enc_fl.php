<?PHP
if($_GET[type]==1){
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>Busca pelo funcionário:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";

        echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
        echo "<form method=POST name='frmSearchType2'>";
        echo "<tr>";
        //echo "<td align=left class=text width='160'>Busca:</td>";
        echo "<td align=left class=text width='480'>";
        //echo "<input type='text' class='inputTextobr' size=30 name=search id=search value='$_POST[search]'>";
                        echo "<input type='text' class='inputTextobr' name='search' id='search' value='{$_POST[search]}' size=45 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearchType2' value='Busca'>";
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
    if($_POST && $_POST[btnSearchType2] && !empty($_POST[search])){
        if(is_numeric($_POST[search])){
            $sql = "SELECT * FROM funcionarios WHERE funcionario_id = $_POST[search] AND cod_cliente = $_GET[cod_cliente]";
        }else{
            $sql = "SELECT * FROM funcionarios WHERE lower(nome_func) LIKE '%".strtolower($_POST[search])."%' AND cod_cliente = $_GET[cod_cliente]";
        }
        $res = pg_query($sql);
        $buf = pg_fetch_all($res);
        if(pg_num_rows($res)>0){
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td width=35 class='text' ><b>Cód.</b></td><td class='text'><b>Nome</b></td>";
            echo "</tr>";
            for($x=0;$x<pg_num_rows($res);$x++){
                echo "<tr class='text roundbordermix'>";
                echo "<td class='text roundborder' align=center>".str_pad($buf[$x][cod_func], 4, "0", 0)."</td><td class='text roundborder curhand' onclick=\"if(confirm('Tem certeza que deseja gerar encaminhamento para este funcionário? \\n\\n{$buf[$x][nome_func]}\\n\\n','Confirmação de Encaminhamento')){location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=new_enc_form&type={$_GET[type]}&cod_cliente={$_GET[cod_cliente]}&fid={$buf[$x][cod_func]}';}\">{$buf[$x][nome_func]}</td>";
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
}
echo "<table width=100% border=0 cellspacing=0 cellpadding=0 valign=bottom>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='button' class='btn' name='btnBackProd' value='Voltar' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=new_enc_med&type={$_GET[type]}';\" onmouseover=\"showtip('tipbox', '- Voltar, retorna à lista de produtos.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

?>
