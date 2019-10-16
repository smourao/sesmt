<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
include "../config/funcoes.php";

$id = $_GET['id'];
$val = $_GET['value'];

$sql = "UPDATE site_newsletter_info SET grupo='$value' WHERE id = $id ";
if(pg_query($sql)){
    echo $id;
}else{
    echo "";
}

?>
