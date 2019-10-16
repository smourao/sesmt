<?PHP
if(!$_GET[topic] || !is_numeric($_GET[topic])){
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
        echo "<b>Editar Tópicos</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>Tópicos Existêntes:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";


    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
        echo "<td class='text' width=35 align=center><b>Nº</b></td>";
        echo "<td class='text'><b>Título</b></td>";
        echo "<td class='text' width=70><b>Data</b></td>";
        echo "<td width=70></td>";
    echo "</tr>";
    for($x=0;$x<pg_num_rows($restop);$x++){
        echo "<tr class='roundbordermix'>";
            echo "<td class='text roundborder' width=35 align=center onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_ata_topic&id={$_GET[id]}&topic={$topicos[$x][id]}';\">".str_pad(($x+1), 2, "0", 0)."</td>";
            echo "<td class='text roundborder curhand' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_ata_topic&id={$_GET[id]}&topic={$topicos[$x][id]}';\">{$topicos[$x][title]}</td>";
            echo "<td width=70 align=center class='text roundborder curhand' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_ata_topic&id={$_GET[id]}&topic={$topicos[$x][id]}';\">".date("d/m/Y",strtotime($topicos[$x][post_date]))."</td>";
            echo "<td width=70 align=center class='text roundborder curhand' onclick=\"if(confirm('Tem certeza que deseja excluir este tópico?',''))location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_ata_topic&id={$_GET[id]}&deltopic={$topicos[$x][id]}';\"><b>Excluir</b></td>";
        echo "</tr>";
    }
    echo "</table>";
    
}else{

    if($_POST[btnSaveAtaTopic] && $_POST){
        $sql = "UPDATE site_ata_topic SET title='".addslashes($_POST[title])."', msg='".addslashes($_POST[msg])."' WHERE id = $_GET[topic]";
        if(pg_query($sql)){
            showMessage('Tópico atualizado com sucesso!');
            makelog($_SESSION[usuario_id], "Atualização de tópico número $_GET[topic] da ata da CIPA número $_GET[id].", 409);
        }else{
            showMessage('Houve um erro ao atualizar os dados do tópico. Por favor, entre em contato com o setor de suporte!', 1);
            makelog($_SESSION[usuario_id], "Erro ao atualizar de tópico número $_GET[topic] da ata da CIPA número $_GET[id].", 410);
        }
    }
    $sql = "SELECT * FROM site_ata_topic WHERE id = {$_GET[topic]}";
    $rat = pg_query($sql);
    $topinfo = pg_fetch_array($rat);
    
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
        echo "<b>Editar Tópicos</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";

        echo "<table width=100% border=0 align=center cellspacing=2 cellpadding=2>";

        echo "<form method=post id='frmcadatatopic' name='frmcadatatopic'>";
        
        echo "<tr>";
        echo "<td align=left class=text width='100'>Cód. Tópico:</td>";
        echo "<td align=left class=text width='220'><input type='text' value='$topinfo[id]' readonly disabled class='inputTextobr' size=5 name='atan' id='atan'></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class=text width='100'>Título:</td>";
        echo "<td align=left class=text width='220'><input type='text' value='$topinfo[title]' class='inputTextobr' size=66 name='title' id='title'></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class=text width='100'>Mensagem:</td>";
        echo "<td align=left class=text width='220'>";
        echo "<textarea class='inputTextobr' name='msg' id='msg' cols=50 rows=10>$topinfo[msg]</textarea>";
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
                echo "<input type='submit' class='btn' name='btnSaveAtaTopic' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
                echo "</td>";
                
                echo "</form>";
                
            echo "</tr>";
            echo "</table>";
        echo "</tr>";
    echo "</table>";
    }
?>
