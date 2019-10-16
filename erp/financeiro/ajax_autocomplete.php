<?PHP
include("include/db.php");
//$_GET['search'];

if(is_numeric($_GET['search'])){
   $sql = "SELECT * FROM cliente WHERE cliente_id='".strtoupper($_GET['search'])."'";
}else{
   $sql = "SELECT * FROM cliente WHERE UPPER(LTRIM(razao_social,' ')) LIKE '".strtoupper($_GET['search'])."%'";
}
$result = pg_query($sql);
$n = pg_num_rows($result);

if($n>0){
   $buffer = pg_fetch_all($result);
   $tmp = "<table width=100% border=0>";
   $tmp .= '<tr><td align=right><a href="javascript:close_autocomplete();" class=fontebranca12>Fechar [X]</a></td></tr>';
   for($x=0;$x<$n;$x++){
      $tmp .= "<tr><td align=left class=fontebranca12>";
      $tmp .= "<a href=\"javascript:do_autocomplete('".$buffer[$x]['cliente_id']." - ".addslashes($buffer[$x]['razao_social'])."');\" class=fontebranca12>".$buffer[$x]['cliente_id']." - ".$buffer[$x]['razao_social']."</a>";
      $tmp .= "</td></tr>";
   }
   $tmp .= '<tr><td align=right>&nbsp;</td></tr>';
   $tmp .= '</table>';
   echo urlencode($tmp);
}else{
   echo "0";
}

?>
