<?
include "sessao.php";
include ('./config/connect.php');
include ('./config/config.php');
include ('./config/funcoes.php');

$query="select * from fatura2";
$result=pg_query($query)or die("Erro na consulta".pg_last_error($connect));

while ($linha=pg_fetch_array($result)){

	echo $linha['cliend_id']."<br/>";

}

//Exemplos de query (consultas ao banco de dados)
//$query="select * from cliente";
//$query="update cliente set razao_social=$_POST['razao_social'] where cliente_id=$_POST[cod_cliente]";
//$query="delete from cliente where cliente_id=$_POST['cod_cliente']";

?>