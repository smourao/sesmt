<?PHP
if(is_numeric($_GET[cod_prod])){
    if($_GET[add])
        showMessage('Produto adicionado com sucesso!');
    if($_POST[btnSaveProd] && $_POST){
        $price = str_replace('.', '', $_POST[preco]);
        $price = str_replace(',', '.', $price);
        $sql = "UPDATE produto3 SET desc_resumida_prod = '".addslashes($_POST[desc_res])."',
        desc_detalhada_prod = '".addslashes($_POST[desc_det])."', preco_prod = '$price',
        cod_chave = '".addslashes($_POST[cod_chave])."', cod_atividade = $_POST[atividade]
        WHERE cod_prod = $_POST[cod_prod]";
        if(pg_query($sql)){
            showMessage('Produto alterado com sucesso!');
            makelog($_SESSION[usuario_id], 'Atualização de produto código: '.$_GET[cod_prod].'.', 303);
        }else{
            showMessage('Não foi possível atualizar este produto. Por favor, entre em contato com o setor de suporte!', 1);
            makelog($_SESSION[usuario_id], 'Erro ao atualizar produto código: '.$_GET[cod_prod].'.', 304);
        }
    }
    $sql = "SELECT * FROM produto3 WHERE cod_prod = $_GET[cod_prod]";
    $res = @pg_query($sql);
    $prod = @pg_fetch_array($res);
}elseif($_GET[cod_prod] == "new"){
    $sql = "SELECT MAX(cod_prod)+1 as cod_prod FROM produto3";
    $res = @pg_query($sql);
    $prod = @pg_fetch_array($res);
    if($_POST[btnSaveProd] && $_POST){
        $price = str_replace('.', '', $_POST[preco]);
        $price = str_replace(',', '.', $price);
        if(empty($_POST[desc_res]) || empty($_POST[desc_det])){
            showMessage('Os campos <b>Descrição Resumida</b> e <b>Descrição Detalhada</b> devem ser preenchidos!',2);
        }elseif(!is_numeric($price)){
            showMessage('O campo <b>Preço</b> não é válido!',2);
        }elseif(!is_numeric($_POST[atividade])){
            showMessage('O campo <b>Cód. Atividade</b> não foi selecionado, ou é inválido.',2);
        }else{
            $sql = "INSERT INTO produto3 (cod_prod, desc_resumida_prod, desc_detalhada_prod,
            preco_prod, cod_chave, cod_atividade) VALUES ($prod[cod_prod], '".addslashes($_POST[desc_res])."',
            '".addslashes($_POST[desc_det])."', '$price', '".addslashes($_POST[cod_chave])."', $_POST[atividade])";
            if(pg_query($sql)){
                makelog($_SESSION[usuario_id], 'Cadastro de novo produto código: '.$prod[cod_prod].'.', 301);
                echo "<script>location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=edit_prod&page=$_GET[p]&cod_prod=$prod[cod_prod]&add=1';</script>";
            }else{
                showMessage('Houve um erro ao cadastrar este produto. Por favor, entre em contato com o setor de suporte.',2);
                makelog($_SESSION[usuario_id], 'Erro no cadastro de novo produto código: '.$prod[cod_prod].'.', 302);
            }
        }
    }
}
/**************************************************************************************************/
// -->
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados do produto:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";

    //FORM - SAVE DATA
    echo "<form method=post id='frmcadprod' name='frmcadprod'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Produto:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_prod id=cod_prod value='{$prod[cod_prod]}' readonly></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descrição Resumida:</td>";
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_res id=desc_res>{$prod[desc_resumida_prod]}</textarea></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Descrição Detalhada:</td>";
    echo "<td align=left class=text width='500'><textarea class='inputTextobr' cols=65 name=desc_det id=desc_det>{$prod[desc_detalhada_prod]}</textarea></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Preço:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=preco id=preco value='".number_format($prod[preco_prod], 2, ",", ".")."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Chave:</td>";
    echo "<td align=left class=text width='500'><input type='text' class='inputTextobr' size=8 name=cod_chave id=cod_chave value='{$prod[cod_chave]}'></td>";
    echo "</tr>";

    $sql = "SELECT cod_atividade, dsc_atividade FROM atividade ORDER BY dsc_atividade";
    $rat = pg_query($sql);
    $ativ = pg_fetch_all($rat);
    echo "<tr>";
    echo "<td align=left class=text width='140'>Cód. Atividade:</td>";
    echo "<td align=left class=text width='500'>";
        echo "<select name='atividade' id='atividade' class='inputTextobr'>";
            for($x=0;$x<pg_num_rows($rat);$x++){
                echo "<option "; print $prod[cod_atividade] == $ativ[$x][cod_atividade] ? " selected ":""; echo " value='{$ativ[$x][cod_atividade]}'>{$ativ[$x][dsc_atividade]}</option>";
            }
        echo "</select>";
    echo "</td>";
    echo "</tr>";

    echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='button' class='btn' name='btnBackProd' value='Voltar' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]';\" onmouseover=\"showtip('tipbox', '- Voltar, retorna à lista de produtos.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='submit' class='btn' name='btnSaveProd' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "&nbsp;";
            echo "<input type='button' class='btn' name='btnDelProd' value='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir este produto?','')) location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]&cod_prod=$_GET[cod_prod]&del=1';\" onmouseover=\"showtip('tipbox', '- Excluir, remove este produto do cadastro.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";
?>
