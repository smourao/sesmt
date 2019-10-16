<?php


//##########################################################################



$host = 'postgresql04.sesmt-rio.com';//'postgresql01.sesmt-rio.com';//'s4d.servegame.com'; //postgresql01.sesmt-rio.com
$port = '5432';
$dbname = 'sesmt_rio3';//'loja';//sesmt_rio
$user = 'sesmt_rio3';//'postgres';//sesmt_rio
$pass = 'Sesmt507311';//'xxxxxx';//diggio3001
$str = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$conn = @pg_connect($str) or die('Houve um problema ao tentar se conectar à database. Por favor, tente novamente mais tarde!');


//##########################################################################



$cnpj_cliente = $_POST['cnpj_cliente'];

$pegardadossql = "SELECT * FROM aso_avulso WHERE cnpj_cliente = '".$cnpj_cliente."' ORDER BY cod_aso DESC LIMIT 1";
$pegardadosquery = pg_query($pegardadossql);
$pegardados = pg_fetch_array($pegardadosquery);
$pegardadosnum = pg_num_rows($pegardadosquery);
 
if($pegardadosnum >= 1){
	
	$dados['sucesso'] = '1';
	
}else{

	$dados['sucesso'] = '0';
	
}




$dados['razao_social_cliente']     = $pegardados['razao_social_cliente'];
$dados['endereco_cliente']  	   = $pegardados['endereco_cliente'];
$dados['cep_cliente']  			   = $pegardados['cep_cliente'];
$dados['cnae']  				   = $pegardados['cnae'];
$dados['grau_risco']  			   = $pegardados['grau_risco'];
 
echo json_encode($dados);
 
?>