<?PHP
    header("Content-Type: text/html; charset=ISO-8859-1",true);
    include("database/conn.php");
    include("functions.php");
    include("globals.php");

$pp = "SELECT * FROM amostragem WHERE id = '$_GET[valor]'";
$ppp = pg_query($connect, $pp);
$p = pg_fetch_all($ppp);
$er = '';

for($x=0;$x<pg_num_rows($ppp);$x++){
	$er .= $p[$x][id].'|'.$p[$x][vazao_min].'|'.$p[$x][vazao_max].'|'.$p[$x][volume_min].'|'.$p[$x][volume_max];
}

echo $er;
?>