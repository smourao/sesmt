<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";
$id = $_GET[id];
$me = $_GET[im];

$sql = "SELECT * FROM sist_sci_check_message WHERE usuario_id = $me AND msg_from = $id";
$result = pg_query($sql);
if(pg_num_rows($result)){
    $sql = "UPDATE sist_sci_check_message SET last_check_messages = now() WHERE usuario_id = $me AND msg_from = $id";
}else{
    $sql = "INSERT INTO sist_sci_check_message (usuario_id, last_check_messages, msg_from) VALUES($me, now(), $id)";
}
pg_query($sql);

$sql = "SELECT * FROM funcionario WHERE funcionario_id = $id";
$r = pg_query($sql);
$oinfo = pg_fetch_array($r);

$tmp = explode(" ", $oinfo[nome]);
if(strlen($tmp[1]) > 2)
    $onome = $tmp[0]." ".$tmp[1];
else
    $onome = $tmp[0]." ".$tmp[1]." ".$tmp[2];

$sql = "SELECT * FROM funcionario WHERE funcionario_id = $me";
$r = pg_query($sql);
$minfo = pg_fetch_array($r);

$tmp = explode(" ", $minfo[nome]);
if(strlen($tmp[1]) > 2)
    $mnome = $tmp[0]." ".$tmp[1];
else
    $mnome = $tmp[0]." ".$tmp[1]." ".$tmp[2];


$sql = "SELECT * FROM sist_sci_messages WHERE (msg_to = $id AND msg_from = $me) OR (msg_to = $me AND msg_from = $id) ORDER BY time_sended";
$res = pg_query($sql);
$mes = pg_fetch_all($res);

$ret = "";
for($x=0;$x<pg_num_rows($res);$x++){
    if($mes[$x][msg_from] == $id)
        $ret .= "<font size=1 color='#61B72E'>".date("d/m/Y à\s H:i:s", strtotime($mes[$x][time_sended]))."</font> <b>".$onome."</b>: <BR>".$mes[$x][message];
    else
       $ret .= "<font size=1 color='#61B72E'>".date("d/m/Y à\s H:i:s", strtotime($mes[$x][time_sended]))."</font> <b>".$mnome."</b>: <BR>".$mes[$x][message];

    $ret .= "<P>";
}
echo $ret;
?>
