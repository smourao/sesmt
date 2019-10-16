<?PHP
include("include/db.php");

$id = $_GET['id'];
$value = $_GET['value'];

if(is_numeric($_GET['id'])){
   $sql = "UPDATE financeiro_fatura SET numero_doc = '{$value}' WHERE id='{$id}'";
}
$result = pg_query($sql);

if($result){
   echo $value."|".$id;
}else{
   echo "";
}

?>
