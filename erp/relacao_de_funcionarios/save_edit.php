<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
function anti_injection($sql)
{
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
    //$sql = trim($sql);//limpa espaços vazio
    //$sql = strip_tags($sql);//tira tags html e php
    $sql = addslashes($sql);//Adiciona barras invertidas a uma string
    return $sql;
}
$os = $_GET['os'];
$id = $_GET['mid'];
$text = anti_injection(nl2br($_GET['txt']));

$sql = "UPDATE os_msg SET msg = '{$text}' WHERE id='{$id}'";
$result = pg_query($sql);
if($result){
    //$buffer = pg_fetch_array($result);
    //echo $buffer[msg];
    echo $os;
}else{
    echo "0";
}
?>
