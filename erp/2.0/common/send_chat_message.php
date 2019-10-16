<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";
$id = $_GET[id];
$me = $_GET[im];
$msg = addslashes($_GET[msg]);

$sql = "SELECT * FROM sist_sci_check_message WHERE usuario_id = $id AND msg_from = $me";
$result = pg_query($sql);
if(pg_num_rows($result)){

}else{
    $sql = "INSERT INTO sist_sci_check_message (usuario_id, last_check_messages, msg_from) VALUES($id, '2010-01-01 00:00:00', $me)";
    pg_query($sql);
}

$sql = "INSERT INTO sist_sci_messages
       (msg_to, msg_from, message)
        VALUES
        ('$id', '$me', '$msg')";
if(pg_query($sql))
    echo "1";
else
    echo "0";
?>
