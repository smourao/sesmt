<?PHP

if($_GET[del] && is_numeric($_GET[del]) && $_GET[id] && is_numeric($_GET[id])){
    $sql = "DELETE FROM site_ata_topic WHERE cod_ata = $_GET[id]";
    if(pg_query($sql)){
        $sql = "DELETE FROM site_ata_cipa WHERE id = $_GET[id]";
        if(pg_query($sql)){
            showMessage('Ata da CIPA excluída com sucesso!');
            makelog($_SESSION[usuario_id], "Ata número $_GET[id] excluída.", 403);
        }else{
            showMessage('Houve um erro ao excluir a ata da CIPA selecionada. Por favor, entre em contato com o setor de suporte!',1);
            makelog($_SESSION[usuario_id], "Erro ao excluir ata número $_GET[id].", 404);
        }
    }else{
        showMessage('Houve um erro ao excluir tópicos relacionados a esta ata da CIPA. Por favor, entre em contato com o setor de suporte!',1);
        makelog($_SESSION[usuario_id], "Erro ao excluir ata número $_GET[id].", 404);
    }
}

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    if($_POST && $_POST[search]){
        echo "<b>Busca por</b> ".$_POST[search];
    }else{
        echo "<b>Ata da CIPA</b>";
    }
echo "</td>";
echo "</tr>";
echo "</table>";

if($_POST && $_POST[search] || $_GET[st]){
    if($_GET[st]){
        $sql = "SELECT * FROM site_ata_cipa ORDER BY d_ano, d_mes, d_dias";
    }else{
        if(is_numeric($_POST[search])){
            $sql = "SELECT * FROM site_ata_cipa WHERE cod_cliente = ".anti_injection($_POST[search])." OR d_atan = ".anti_injection($_POST[search])." ORDER BY d_ano, d_mes, d_dias";
        }else{
            $sql = "SELECT * FROM site_ata_cipa WHERE LOWER(d_empresa) LIKE '%".anti_injection($_POST[search])."%' ORDER BY d_ano, d_mes, d_dias";
        }
    }
    $result = pg_query($sql);
    $buffer = pg_fetch_all($result);
    
    if(pg_num_rows($result)){
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=35><b>Nº</b></td>";
        echo "<td align=left class='text'><b>Empresa</b></td>";
        echo "<td align=left class='text' width=100><b>Data criação</b></td>";
        echo "<td align=left class='text' width=70><b></b></td>";
        echo "<td align=left class='text' width=70><b></b></td>";
        echo "</tr>";
        for($x=0;$x<@pg_num_rows($result);$x++){
            echo "<tr class='text roundbordermix'>";
            echo "<td align=center class='text roundborder curhand' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_ata&id={$buffer[$x][id]}';\">".str_pad($buffer[$x]['d_atan'], 3, "0",0)."</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_ata&id={$buffer[$x][id]}';\">{$buffer[$x]['d_empresa']}</td>";
            echo "<td align=center class='text roundborder curhand' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_ata&id={$buffer[$x][id]}';\">".date("d/m/Y", strtotime($buffer[$x]['criacao']))."</td>";
            echo "<td align=center class='text roundborder'>";
                echo "<span onclick=\"if(confirm('Tem certeza que deseja excluir esta ata da CIPA?','')) location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]&id={$buffer[$x][id]}&del=1';\"><a href='javascript:;'>Excluir</a></span>";
            echo "</td>";
            echo "<td align=center class='text roundborder'>";
                echo "<a href='#' onclick=\"window.open('".current_module_path."view_ata.php?id={$buffer[$x][id]}');\">Visualizar</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }else{
        echo "Não foram encontrados resultados para o termo \"<b>$_POST[search]</b>\".";
    }

}

?>
