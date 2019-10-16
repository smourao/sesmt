<?PHP
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<b>Logs do Sistema gerados em ".date("d/m/Y")."</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

$sql = "SELECT * FROM funcionario";
$r = pg_query($sql);
$funcl = array();
$funcl[0] = "Log do Sistema";

while($data = pg_fetch_array($r)){
    $tmp = explode(" ", $data[nome]);
    if(strlen($tmp[1])>=3){
        $abrv = $tmp[0]." ".$tmp[1];
    }else{
        $abrv = $tmp[0]." ".$tmp[1]." ".$tmp[2];
    }
    
    $funcl[$data[funcionario_id]][nome] = $data[nome];
    $funcl[$data[funcionario_id]][abreviado] = $abrv;
}

$sql = "
SELECT * FROM log
WHERE
    EXTRACT(day FROM data) = '".date("d")."'
AND
    EXTRACT(month FROM data) = '".date("m")."'
AND
    EXTRACT(year FROM data) = '".date("Y")."'
ORDER BY data DESC
";
$red = pg_query($sql);
$loginfo = pg_fetch_all($red);

echo "<table border=0 width=100% cellspacing=2 cellpadding=2>";
echo "<tr class='roundborderselecteda'>";
echo "<!--<td class='text' align=center><b>LogId</b></td>--><td class='text' align=center><b>Usuário</b></td><td class='text' align=center><b>Ação</b></td><td class='text' align=center><b>Data</b></td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($red);$x++){
    if($x % 2)
        $bgc = "#0e7843";
    else
        $bgc = "#2b8a30";
    
    echo "<tr class='roundbordermix'>";
    //echo "<td class='text' bgcolor='$bgc' align=center>{$loginfo[$x][log_id]}</td>";
    echo "<td class='text' bgcolor='$bgc' align=left width=120><b>".$funcl[$loginfo[$x][usuario_id]][abreviado]."</b></td>";
    echo "<td class='text' bgcolor='$bgc' align=left>{$loginfo[$x][detalhe]}</td>";
    echo "<td class='text' bgcolor='$bgc' align=center width=170>".date("d/m/Y à\s H:i:s", strtotime($loginfo[$x][data]))."</td>";
    echo "</tr>";
}
echo "</table>";

?>
