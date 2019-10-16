<?PHP
if($_POST && $_POST[search]){
    $searchtxt = anti_injection($_POST[search]);
    if(is_numeric($searchtxt))
        $sql = "SELECT * FROM cliente WHERE cliente_id = '$searchtxt' OR LOWER(razao_social) LIKE '%".strtolower($searchtxt)."%'";
    else
        $sql = "SELECT * FROM cliente WHERE LOWER(razao_social) LIKE '%".strtolower($searchtxt)."%'";
    $result = pg_query($sql);
    $clist = pg_fetch_all($result);
    
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
                echo "<td class='text roundborder' width=35 align=center>".str_pad($clist[$x][cliente_id], 4, "0", 0)."</td>";
                echo "<td class='text roundborder curhand' onclick=\"if(confirm('Deseja criar uma nova ata para esta empresa?','')){location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=new_ata_done&cod_cliente={$clist[$x][cliente_id]}';}\">{$clist[$x][razao_social]}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }else{
        echo "Não foram encontrados resultados para o termo \"<b>$_POST[search]</b>\".";
    }

}else{
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
            echo "<b>Nova ata da CIPA</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "- Pesquise uma empresa no campo ao lado para iniciar uma nova ata da CIPA.";
}


?>
