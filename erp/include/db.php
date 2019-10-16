<?PHP

$host = 'postgresql02.sesmt-rio.com';//'postgres345.locaweb.com.br';//'postgresql01.sesmt-rio.com';//'s4d.servegame.com'; //postgresql01.sesmt-rio.com
$port = '5432';
$dbname = 'sesmt_rio';//'loja';//sesmt_rio
$user = 'sesmt_rio';//'postgres';//sesmt_rio
$pass = 'diggio3001';//'xxxxxx';//diggio3001


/*$host = 'marketingii';//'s4d.servegame.com'; //postgresql01.sesmt-rio.com
$port = '5432';
$dbname = 'postgres';//'loja';//sesmt_rio
$user = 'postgres';//'postgres';//sesmt_rio
$pass = 'diggio3001';//'xxxxxx';//diggio3001
 */
$str = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$conn = pg_connect($str) or die('Erro ao conectar a base de dados!');
//$conn = pg_connect("host=".$CFG['host']." port=".$CFG['port']." dbname=".$CFG['loja']." user=".$CFG['user']." password=".$CFG['pass']."") or die("Erro ao conectar!");


?>
