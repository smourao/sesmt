<?PHP
if($_GET[id] && is_numeric($_GET[id])){
    if($_POST[btnSaveNewAtaTopic] && $_POST){
        $sql = "INSERT INTO site_ata_topic
        (cod_ata, title, msg)
        VALUES
        ($_GET[id], '".addslashes($_POST[title])."', '".addslashes($_POST[msg])."')";
        if(pg_query($sql)){
            showMessage('T�pico adicionado com sucesso!');
            makelog($_SESSION[usuario_id], "Novo t�pico adicionado � ata da CIPA n�mero $_GET[id].", 411);
            redirectme("?dir=$_GET[dir]&p=$_GET[p]&sp=edit_ata_topic&id=$_GET[id]");
        }else{
            showMessage('Houve um erro ao adicionar um novo t�pico. Por favor, entre em contato com o setor de suporte!', 1);
            makelog($_SESSION[usuario_id], "Erro ao adicionar novo t�pico � ata da CIPA n�mero $_GET[id].", 412);
        }
    }

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
        echo "<b>Novo T�pico</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";

        echo "<table width=100% border=0 align=center cellspacing=2 cellpadding=2>";

        echo "<form method=post id='frmcadatatopic' name='frmcadatatopic'>";

        echo "<tr>";
        echo "<td align=left class=text width='100'>C�d. T�pico:</td>";
        echo "<td align=left class=text width='220'><input type='text' value='' readonly disabled class='inputTextobr' size=5 name='atan' id='atan'></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class=text width='100'>T�tulo:</td>";
        echo "<td align=left class=text width='220'><input type='text' value='' class='inputTextobr' size=66 name='title' id='title'></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class=text width='100'>Mensagem:</td>";
        echo "<td align=left class=text width='220'>";
        echo "<textarea class='inputTextobr' name='msg' id='msg' cols=50 rows=10></textarea>";
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
                echo "<input type='submit' class='btn' name='btnSaveNewAtaTopic' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenar� todos os dados selecionados at� o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados ser�o salvos, tem certeza que deseja continuar?','');\"
                echo "</td>";

                echo "</form>";

            echo "</tr>";
            echo "</table>";
        echo "</tr>";
    echo "</table>";
}else{
    showMessage('N�o foi poss�vel iniciar um novo t�pico para a CIPA selecionada!',1);
    makelog($_SESSION[usuario_id], "Erro ao adicionar novo t�pico � ata da CIPA n�mero $_GET[id]. N�mero da ata inv�lido!", 412);
}
?>
