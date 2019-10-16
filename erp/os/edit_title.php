<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
$os = $_GET['os'];
$title = $_GET['title'];
$sql = "UPDATE os_info SET assunto='{$title}' WHERE id = '{$os}'";
if(pg_query($sql)){
    echo $os;
}else{
    echo "0";
}
?>
