<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";
$sql = "SELECT * FROM produtos WHERE LOWER(categoria) LIKE '%".strtolower($_GET[cate])."%'";
$res = pg_query($sql);
$buffer = pg_fetch_all($res);
$ret = "";
$tmp = "";
for($i=0;$i<pg_num_rows($res);$i++)
    $tmp .= $buffer[$i][material];
$tmp = explode("|", $tmp);
$tmp = array_unique($tmp);

for($o=0;$o<count($tmp);$o++){
    if($tmp[$o]) $ret .= $tmp[$o]."|";
}

//$ret = $buffer[][material];

$ret .= "£";

$sql = "SELECT * FROM loja_medidas WHERE lower(categoria) LIKE '%".strtolower($_GET[cate])."%'";
$rrr = pg_query($sql);
$buf = pg_fetch_all($rrr);

$tmptam = "";
for($x=0;$x<pg_num_rows($rrr);$x++){
    //$ret .= $buf[$x][altura]."x".$buf[$x][largura]."|";
    $tmptam .= $buf[$x][altura]."x".$buf[$x][largura]."|";
}
$tmptam = explode("|", $tmptam);
$tmptam = array_unique($tmptam);
$tam = "";
for($a=0;$a<count($tmptam);$a++){
    if($tmptam[$a]) $tam .= $tmptam[$a]."|";
}

$ret .= $tam;

$ret .= "£";

$sql = "SELECT * FROM loja_legendas WHERE lower(categoria) LIKE '%".strtolower($_GET[cate])."%'";
$rle = pg_query($sql);
$buceta = pg_fetch_all($rle);

for($y=0;$y<pg_num_rows($rle);$y++){
    //$ret .= $buceta[$y][legenda]."§".$buceta[$y][id]."|";
    $ret .= $buceta[$y][legenda]."|";
}

$ret .= "£";

$sql = "SELECT * FROM produtos WHERE lower(categoria) LIKE '%".strtolower($_GET[cate])."%'";
$rim = pg_query($sql);
$images = pg_fetch_all($rim);

for($z=0;$z<pg_num_rows($rim);$z++){
    $ret .= $images[$z][img1]."|";
}

echo $ret;
?>
