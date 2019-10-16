<?PHP
/**************************************************************************************************/
// -->
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Mapa:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class=text width='100%'>";
    echo '<div id="map" style="width: 700px; height: 300px"></div>';
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    //echo "<input type=hidden name='q' id='q' value=''>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<form action='#' onsubmit=\"showLocation(); return false;\">";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Informação de Pesquisa: </b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=left class=text width='100%'>";
    echo "<input type='text' name='q' value='$buffer[endereco], $buffer[num_end], $buffer[bairro]' class='inputText' size='40' style=\"width: 100%;\">";
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
            echo "<input type='button' class='btn' name='back' value='Voltar' onmouseover=\"showtip('tipbox', '- Retorna ao cadastro do cliente.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]&sp=cadastro';\">";
            echo "&nbsp;";
            echo "<input type='submit' class='btn' name='find' value='Localizar' onmouseover=\"showtip('tipbox', '- Localizar, atualizará a pesquisa no mapa com base nas informações digitadas na caixa de texto acima.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";
?>
<script>
window.onload=load();
window.onunload=GUnload();
</script>
