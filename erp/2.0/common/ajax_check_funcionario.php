<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include("database/conn.php");

if(!empty($_GET['funcionario']) ){
	$sql = "SELECT nome_funcao, num_ctps_func, serie_ctps_func 
			FROM funcionarios f, funcao fu 
			WHERE f.cod_funcao = fu.cod_funcao
			AND nome_func = '$_GET[funcionario]'";
	$res = pg_query($sql);
	$row = pg_fetch_all($res);
}

$text = $row[0]['nome_func']."|".$row[0]['nome_funcao']."|".$row[0]['num_ctps_func']."|".$row[0]['serie_ctps_func'];

if(pg_num_rows($res))
    echo $text;
else
    echo "0";
?>