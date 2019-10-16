<?PHP
include("include/db.php");
$id = $_GET['cod'];

if(is_numeric($id)){
$sql = "SELECT * FROM financeiro_identificacao WHERE es='{$id}' ORDER BY sigla";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);
$tmp = "";
   for($x=0;$x<pg_num_rows($result);$x++){
      //$tmp .= "<option value='{$buffer[$x]['id']}'>{$buffer[$x]['sigla']}</option>";
      $tmp .= $buffer[$x]['id']."§".$buffer[$x]['sigla'];
      if($x < pg_num_rows($result) -1){ $tmp .= "|";};
   }
}

if($result){
   echo urlencode($tmp);
}else{
   echo '0';
}

?>
