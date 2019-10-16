<?PHP
    $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $result = pg_query($sql);
    $cinfo = pg_fetch_array($result);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
    echo "<b>$cinfo[razao_social]</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<p>";
?>
