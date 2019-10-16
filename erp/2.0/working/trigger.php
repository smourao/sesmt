<script>
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
</script>
<?PHP
	$host="postgresql02.sesmt-rio.com";
	$user="sesmt_rio";
	$pass="diggio3001";
	$db="sesmt_rio";
	$connect = pg_connect("host=$host dbname=$db user=$user password=$pass");

$var = explode("\n", $_POST[lista]);
$nvar = "";
for($x=1;$x<count($var);$x++){
    if(!empty($var[$x]))
        $nvar .= (int)($var[$x])."\n";
}
//print_r($_POST[lista]);
//print_r($var);
?>
<form method="post" name="frmMain">
<table border=0>
<tr>
<td>Código dos produtos:</td><td><textarea name="lista" rows=10><?PHP echo $nvar;?></textarea></td>
</tr><tr>
<td>Código chave:</td><td><input type=text value="<?PHP echo $_POST[cod_chave];?>" name="cod_chave"></td>
</tr>
</table>
<input type=submit value="Alterar">
</form>

<?PHP
if(count($var) > 1){
    echo '<b>Status:</b> <font color=red>Updating... ['.$var[0].'] </font><script>setTimeout("document.forms[\'frmMain\'].submit()",1000);</script>';
    $sql = "UPDATE produto SET cod_chave = '{$_POST[cod_chave]}' WHERE cod_prod = ".(int)($var[0]);
    if(pg_query($sql)){
        if((int)($var[0]) > 0)
            echo $sql;
    }else{
        echo "Houve um erro ao executar a query: ".$sql;
        echo "<BR>O script foi paralisado para evitar danos ao cadastro!";
        die('FAIL.');
    }
}else{
    echo '<b>Status:</b> <font color=green>Done!</font>';
}
?>
