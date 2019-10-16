<?php

include("../../../common/database/conn.php");

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

/***************************************************************************************************/
// --> BUSCA DA TABELA DE FUNCIONARIOS
/***************************************************************************************************/
$busca = "SELECT * FROM funcionario WHERE funcionario_id = ".$_GET[func_id];
$bus = pg_query($connect, $busca);
$row_bus = pg_fetch_array($bus);

/***************************************************************************************************/
// --> BUSCA DA TABELA ALTERAÇÃO DE SALÁRIOS
/***************************************************************************************************/
$busca = "SELECT * FROM alt_sal WHERE funcionario_id = ".$_GET[func_id]." ORDER BY id desc";
$alt = pg_query($busca);
$row_alt = pg_fetch_array($alt);

/***************************************************************************************************/
// --> BUSCA DA TABELA DE REGISTRO DE EMPREGADOS
/***************************************************************************************************/
$busca = "SELECT * FROM comp_reg_emp WHERE funcionario_id = ".$_GET[func_id];
$func = pg_query($connect, $busca);
$row_func = pg_fetch_array($func);


//****************ASSINATURA PEDRO**************\\

$busca = "SELECT * FROM funcionario WHERE funcionario_id = 18";
$assi = pg_query($connect, $busca);
$row_assi = pg_fetch_array($assi);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>		
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title> Agendamento Bancário </title>
<style>
.tudo{
	width:900px;
	height:900px;	
}

.corpo{
	margin-left:20%;
	width:60%;
	
}


</style>

</head>
<div class="tudo">
<body>
<div class="corpo">



<p class="MsoNormal"><b><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal"><b><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">Dê; SESMT Serviços Especializados e
Monitoramento de Atividades no Trabalho Ltda<o:p></o:p></span></b></p>

<p class="MsoNormal"><b><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal"><b><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">PARA: Ag 0576 Banco do Brasil - Penha<o:p></o:p></span></b></p>

<p class="MsoNormal"><b><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal"><b><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal" align="center" style="text-align:center"><b><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">ENCAMINHAMENTO DE
ABERTURA DE CONTA PAGAMENTO<o:p></o:p></span></b></p>

<p class="MsoNormal" align="center" style="text-align:center"><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" align="center" style="text-align:center"><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">Encaminho a
colaborador(a): <b><?php echo $row_bus['nome'];?></b>, Residente
á <b><?php echo $row_bus['endereco'];?></b> nº; <b><?php echo $row_bus['num'];?></b>, 
Município: <b>Rio de Janeiro</b>, CTPS: <b><?php echo $row_bus['ctps'];?></b>, &nbsp;Série: <b><?php echo $row_bus['serie'];?></b>, &nbsp;Função: <b><?php echo $row_func['ocupacao'];?></b>, cujo o
salário é de R$ <b><?php echo $row_alt['salario'];?></b>, Empregador: <b>Empresa SESMT Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho Ltda</b>, Sob CNPJ
<b>04.722.248/0001-17</b>, a</st1:metricconverter>
abrir conta pagamento.<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal"><b><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">DOCUMENTAÇÃO A APRESENTAR<o:p></o:p></span></b></p>

<h1><span style="font-size:12.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;
font-weight:normal;mso-bidi-font-weight:bold">Comprovante de Residência:<o:p></o:p></span></h1>

<h1 style="margin-right:-24.8pt"><span style="font-size:12.0pt;font-family:
&quot;Verdana&quot;,&quot;sans-serif&quot;;font-weight:normal;mso-bidi-font-weight:bold">Declaração
de Renda: A mesma se encontra no próprio encaminhamento<o:p></o:p></span></h1>

<h1><span style="font-size:12.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;
font-weight:normal;mso-bidi-font-weight:bold">RG<o:p></o:p></span></h1>

<h1><span style="font-size:12.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;
font-weight:normal;mso-bidi-font-weight:bold">CPF<o:p></o:p></span></h1>

<h1><span style="font-size:12.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;
font-weight:normal;mso-bidi-font-weight:bold"><o:p>&nbsp;</o:p></span></h1>

<h1 align="center" style="text-align:center"><span style="font-size:12.0pt;
font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">Rio de Janeiro, <?=$dia ?> de <?=$mes_atual ?> de <?=$ano ?><o:p></o:p></span></h1>

<p class="MsoNormal" align="center" style="text-align:center"><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" align="center" style="text-align:center"><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" align="center" style="text-align:center"><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><?php echo "<img src='$row_assi[assinatura]'>"?> <o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><o:p>&nbsp;</o:p></span></p>
</div>
</body>
</div>
</html>
