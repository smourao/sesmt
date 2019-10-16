<?PHP
$host = 'postgresql04.sesmt-rio.com';//'postgresql01.sesmt-rio.com';//'s4d.servegame.com'; //postgresql01.sesmt-rio.com
$port = '5432';
$dbname = 'sesmt_rio3';//'loja';//sesmt_rio
$user = 'sesmt_rio3';//'postgres';//sesmt_rio
$pass = 'Sesmt507311';//'xxxxxx';//diggio3001
$str = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$conn = @pg_connect($str) or die('Houve um problema ao tentar se conectar à database. Por favor, tente novamente mais tarde!');
?>






<?php



$dia = date("j");
$mes_atual = date("m");
$ano = date("Y");

if($mes_atual == "01"){
$mes_atual = "Janeiro";
}

if($mes_atual == "02"){
$mes_atual = "Fevereiro";
}

if($mes_atual == "03"){
$mes_atual = "Março";
}

if($mes_atual == "04"){
$mes_atual = "Abril";
}

if($mes_atual == "05"){
$mes_atual = "Maio";
}

if($mes_atual == "06"){
$mes_atual = "Junho";
}

if($mes_atual == "07"){
$mes_atual = "Julho";
}

if($mes_atual == "08"){
$mes_atual = "Agosto";
}

if($mes_atual == "09"){
$mes_atual = "Setembro";
}

if($mes_atual == "10"){
$mes_atual = "Outubro";
}

if($mes_atual == "11"){
$mes_atual = "Novembro";
}

if($mes_atual == "12"){
$mes_atual = "Dezembro";
}







function valorPorExtenso($valor=0) {
	$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
	$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");
	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis",
"sete", "oito", "nove");

	$z=0;

	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
	for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];

	// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
	for ($i=0;$i<count($inteiro);$i++) {
		$valor = $inteiro[$i];
		$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
		$t = count($inteiro)-1-$i;
		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if ($valor == "000")$z++; elseif ($z > 0) $z--;
		if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
	}

	return($rt ? $rt : "zero");
}













$funcsql = "SELECT nome, cpf FROM funcionario WHERE funcionario_id = {$_GET[funcionario_id]}";
$funcquery = pg_query($funcsql);
$func = pg_fetch_array($funcquery);



$query_func = "SELECT data, salario FROM alt_sal WHERE funcionario_id = {$_GET[funcionario_id]} ORDER BY id DESC";
$result_func = pg_query($query_func);
$salarioarray = pg_fetch_array($result_func);


$salariobruto =  $salarioarray[salario];

$desconto = $salariobruto * 0.09;

$salarioliquido = $salariobruto - $desconto;


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>

<style type="text/css">

#tudo{
	
	width:700px;
	
}

#recibotodo{
	
	width:650px;
	margin:auto;
	
}

#escritarecibo1{
	
	margin-left:120px;
	
}


#escritarecibo2{
	
	margin-left:120px;
	
}

#valores{
	
	float:right;
	
}

#assinatura{
	
	float:right;
	margin-right:10%;
	
}


#assinatura2{
	
	float:right;
	margin-right:25%;
	
}

#data{
	float:left;
	
	margin-left:5%;
	
}


</style>

</head>

<body>

<div id="tudo">


<div id="recibotodo">


<table>
<tr>
<td>

<table border="1">
<tr>
<td>
<div id="escritarecibo1">
RECIBO DE PROLABORE
</div>
</td>
<td>

Valor Bruto <div id="valores"><?php echo number_format($salariobruto, 2, ",",".") ?></div><br>
Pensão Alimentícia <div id="valores">0,00</div><br>
INSS <div id="valores">0,00</div><br>
IRRF <div id="valores">0,00</div><br>
Outros Proventos <div id="valores">0,00</div><br>
Outros Descontos <div id="valores">0,00</div><br>
Líquido Recebido <div id="valores"><?php echo number_format($salarioliquido, 2, ",",".") ?></div><br>

</td>
</tr>
<tr>
<td colspan="2">
<br>
Recebi da SESMT  Serv. Esp. de Seg.e Monit. de Ativ. no Trab. Ltda a importância de R$<b> <?php echo  number_format($salarioliquido, 2, ",","."). " (".(valorPorExtenso($salarioliquido)).")" ; ?></b> , referente ao meu pró-labore do mês de <?php echo $mes_atual." de ".$ano ?> com descontos exigidos em lei.
<br>
<br>
</td>
</tr>
<tr>
<td colspan="2">
<br>

<div id="data">Rio de Janeiro,___/___/___</div> <div id="assinatura">________________________________</div><br>
<div id="assinatura2">Assinatura </div>
<br>
<br>
</td>
</tr>
<tr>
<td colspan="2">
<br>
Empresa:  SESMT  Serv. Esp. de Seg.e Monit. de Ativ. no Trab. Ltda<br>
CNPJ: 04.722.248/0001-17<br>
Nome: <?php echo $func['nome'] ?><br>
CPF: <?php echo $func['cpf'] ?><br>
Endereço: Rua Georges Bizet, 92, sala 101<br>
Bairro: Jardim América  &nbsp;&nbsp; CEP: 21240.460<br>
UF: RJ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	Cidade: Rio de Janeiro<br>
<br>
</td>
</tr>
</table>

<br>
<br>

























</td>
</tr>
</table>



</div>
</div>

</body>
</html>
