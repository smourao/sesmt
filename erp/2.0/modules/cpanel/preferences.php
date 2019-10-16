<?PHP
/**************************************************************************************************/
// --> SALVA OPÇÕES
/**************************************************************************************************/
if($_POST[btnSavePref] && $_POST){
    $sql = "UPDATE funcionario SET showinfobar = $_POST[showinfobar] WHERE funcionario_id = $_SESSION[usuario_id]";
    if(pg_query($sql)){
        showMessage('Dados atualizados com sucesso.');
        $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$_SESSION[usuario_id]}";
        $result = pg_query($sql);
        $userdata = pg_fetch_array($result);
    }else{
        showMessage('Houve um erro ao tentar armazenar os dados na database. Por favor, entre em contato com o setor de suporte!',1);
    }
}

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=left class='text'><b>Configurações Básicas:</b></td>";
echo "</tr>";
echo "</table>";

echo "<table height=200 width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected' valign=top>";

//FORM - SAVE DATA
echo "<form method=post id='frmpreferencias' name='frmpreferencias'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=left class='text' width='240'>";
        echo "<span class='curhelp' title='Exibe uma barra na parte superior da tela, com informações aleatórias sobre o sistema.' alt='Exibe uma barra na parte superior da tela, com informações aleatórias sobre o sistema.'>";
        echo "Exibir barra de informações:";
        echo "</span>";
    echo "</td>";
    echo "<td align=left class=text width='400'>";
        echo "<select id='showinfobar' name='showinfobar'>";
        echo "<option value='1'"; print $userdata[showinfobar] ? " selected ":""; echo ">Sim</option>";
        echo "<option value='0'"; print $userdata[showinfobar] ? "":" selected "; echo ">Não</option>";
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
            echo "<input type='submit' class='btn' name='btnSavePref' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";
?>
