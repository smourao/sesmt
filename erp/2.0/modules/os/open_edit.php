<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
$os = $_GET['os'];
$sql = "SELECT * FROM os_msg WHERE id='{$os}'";
$result = pg_query($sql);
if($result){
    $buffer = pg_fetch_array($result);
    echo $buffer[msg];
}else{
    echo "0";
}
?>
