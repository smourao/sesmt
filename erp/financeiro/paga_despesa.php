<?PHP
include("include/db.php");
$id = $_GET['cod'];

if(is_numeric($id)){
$sql = "SELECT * FROM financeiro_fatura WHERE id='{$id}'";
$result = pg_query($sql);

   if(pg_num_rows($result) > 0){
      //
      $sql = "UPDATE financeiro_fatura SET pago=1 WHERE id='{$id}'";
      $res = pg_query($sql);
   }
}

if($res){
   echo "{$id}";
}else{
   echo '0';
}

?>
