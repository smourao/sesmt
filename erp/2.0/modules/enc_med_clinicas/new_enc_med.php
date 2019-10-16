<?PHP
/**********************************************************************************************/
// -->  Selecionar o tipo de Encaminhamento
// 1 - Clientes
// 2 - Avulsos
/**********************************************************************************************/
if(empty($_GET[type])){
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>Novo encaminamento:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";

        echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

        echo "<tr>";
        echo "<td align=left class=text width='160'>Tipo de encaminamento:</td>";
        echo "<td align=left class=text width='480'>";
        //<input type='text' class='inputTextobr' size=10 name=cep id=cep value='$buffer[cep]' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" onblur=\"check_cep(this);\">&nbsp;<span id='verify_cep'></span>
        echo "<select name='tipo_encaminamento' class='inputTextobr' onchange=\"if(this.options[this.selectedIndex].value != ''){location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp={$_GET[sp]}&type='+this.options[this.selectedIndex].value;}\">";
        echo "<option></option>";
        echo "<option value=1>Encaminamento automático (Clientes)</option>";
        echo "<option value=2>Encaminamento manual (Avulso)</option>";
        echo "</select>";
        echo "</td>";
        echo "</tr>";

        echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text' height=200>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
}

/**********************************************************************************************/
// -->
// 1 - Clientes
/**********************************************************************************************/
if($_GET[type]==1){
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
        //echo "<td align=left class=text width='160'>Busca:</td>";
        echo "<td align=left class=text width='480'>";
        //echo "<input type='text' class='inputTextobr' size=30 name=search id=search value='$_POST[search]'>";
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
}
/**********************************************************************************************/
// -->
// 2 - Avulsos
/**********************************************************************************************/
if($_GET[type]==2){

}

echo "<table width=100% border=0 cellspacing=0 cellpadding=0 valign=bottom>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='button' class='btn' name='btnBackProd' value='Voltar' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]';\" onmouseover=\"showtip('tipbox', '- Voltar, retorna à tela principal.');\" onmouseout=\"hidetip('tipbox');\" >";
            //echo "&nbsp;";
            //echo "<input type='submit' class='btn' name='btnSaveProd' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            //echo "&nbsp;";
            //echo "<input type='button' class='btn' name='btnDelProd' value='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir este produto?','')) location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]&cod_prod=$_GET[cod_prod]&del=1';\" onmouseover=\"showtip('tipbox', '- Excluir, remove este produto do cadastro.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";
?>
