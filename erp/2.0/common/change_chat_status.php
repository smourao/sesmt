<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";
$id = $_GET[id];
$newstatus = 0;

$sql = "SELECT * FROM funcionario WHERE funcionario_id = $id";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);

if($buffer[sist_sci_chat])
    $newstatus = 0;
else
    $newstatus = 1;
    
$sql = "UPDATE funcionario SET sist_sci_chat = $newstatus WHERE funcionario_id = $id";
if(pg_query($sql)){
    if($newstatus){
        echo "1";
    }else{
        echo "2";
    }
}else{
    echo "0";
}
?>
