<?php
include "./config/connect.php";
include "functions.php";
$cliente_id = $_GET[cliente_id];
$item = 0;

if ($cliente_id!="" ){
	$query_cli = "select
					cliente_id
					, razao_social
					, endereco
					, num_end
					, bairro
					, cep
					, cnpj
					, insc_municipal
					, grau_de_risco
					, nome_contato_dir
					, telefone
					, email
					, cnae_id
					, numero_funcionarios
					, classe
					, o.data
				  FROM cliente_comercial cc, orcamento o, orcamento_produto op
				  WHERE cc.cliente_id = o.cod_cliente
				  AND o.cod_orcamento = op.cod_orcamento
				  AND cc.cliente_id = $cliente_id";
	$result_cli = pg_query($query_cli);
	$row = pg_fetch_array($result_cli);
}

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}

function cz($num){
return str_pad($num, 2, "0", STR_PAD_LEFT);
}

function zero($number){
return str_pad($number, 3, "0", STR_PAD_LEFT);
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Orçamento</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">

td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style13 {font-size: 14px}
.style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.style16 {font-size: 9px}

.style17 {font-family: Arial, Helvetica, sans-serif}
.style18 {font-size: 12px}
</style>
</head>
<body text="#000000">
<form action="enviar_contato_alt.php" method="post" >
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
<?PHP
if(!$_GET['sem_timbre']){
?>
		<td align="left"><img src="img/logo_sesmt.png" width="333" height="180" /></td>
		<td align="left"><font color="#006633" face="Verdana, Arial, Helvetica, sans-serif"><span class="style18">Serviços Especializados de Segurança e <br>
		  Monitoramento de Atividades no Trabalho LTDA.</span>
		  </font><br><br>
		  <p class="style18">
		  <p class="style18">
          <font color="#006633" face="Verdana, Arial, Helvetica, sans-serif">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br>
		  <p>
		  <div align="right"><span class="style13"><strong>Orçamento:</strong>&nbsp; </span><?php if($cod_orcamento!=""){coloca_zeros($cod_orcamento);} echo "/".date("Y", strtotime($row[data]));?></div>
        </td>
<?PHP
}else{
?>
		<td align="left" width=333 height=180>&nbsp;</td>
		<td align="left">
          <p>
          <br><br>
		  <p class="style18">
		  <p class="style18">
          <p>
          <br><br><br><br>
		  <p>
		  <div align="right"><span class="style13"><strong>Orçamento:</strong>&nbsp; </span><?php if($cod_orcamento!=""){coloca_zeros($cod_orcamento);} echo "/".date("Y", strtotime($row[data]));?></div>
        </td>


<?PHP
}
?>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
	<tr>
		<td width="100%" class="fontepreta12"><span class="style15"><strong>Cod. Cliente:</strong>&nbsp;<?php echo"".$row[cliente_id];?> &nbsp;&nbsp;&nbsp;
		    <strong>Nome:</strong>&nbsp;<?php echo"".convertwords($row[razao_social]);?></span></td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
	<tr>
		<td width="100%" class="fontepreta12"><span class="style15"><strong>Endereço:</strong>&nbsp;<?php echo $row[endereco];?> &nbsp;<strong>Nº:</strong>&nbsp;<?php echo $row[num_end];?>&nbsp;&nbsp;
		    <strong>Bairro:</strong>&nbsp;<?php echo $row[bairro];?>&nbsp;&nbsp;
		    <strong>Cep:</strong>&nbsp;<?php echo $row[cep];?></span></td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100%" class="fontepreta12"><span class="style15"><strong>CNPJ:</strong>&nbsp;<?php echo $row[cnpj];?>&nbsp;&nbsp;
		    <strong>I.M:</strong>&nbsp;&nbsp;<?php echo $row[insc_municipal];?>&nbsp;&nbsp;
		    <strong>Grau de Risco:</strong>&nbsp;<?php echo $row[grau_de_risco] . "/" . $row[numero_funcionarios]; ?></span></td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100%" class="fontepreta12"><span class="style15"><strong>ATT:</strong> &nbsp;<?php echo $row[nome_contato_dir];?>&nbsp;&nbsp;
		    <strong>Telefone:</strong>&nbsp;<?php echo $row[telefone];?>&nbsp;&nbsp;
		    <strong>E-mail:</strong>&nbsp;<?php echo $row[email];?></span></td>
	</tr>
</table></div><br>
<div align="center">
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td><span class="style16"><font face="Verdana, Arial, Helvetica, sans-serif">Conforme contato estabelecido com V. Sas., estamos apresentando proposta de prestação de serviços, como segue abaixo:</font></span></td>
	</tr>
</table></div><br>
<div align="center">
<table width="100%" border="0" cellpadding="4" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="4%" align="center" class="fontepreta12 style2">Item</td>
		<td width="56%" align="center" class="fontepreta12 style2">Descrição do(s) Serviço(s):</td>
		<td width="4%" align="right" class="fontepreta12 style2">Qtd</td>
		<td width="18%" align="right" class="fontepreta12 style2">Preço Unitário</td>
		<td width="18%" align="right" class="fontepreta12 style2">Preço Total</td>
	</tr>

<?php
	$query_prod = "SELECT cod_prod, quantidade, desc_resumida_prod, preco_prod, preco_unitario
				   FROM orcamento_produto op, produto p, cliente_comercial cc, orcamento o
				   WHERE op.cod_produto = p.cod_prod
				   and o.cod_orcamento = op.cod_orcamento
				   and o.cod_cliente = cc.cliente_id
				   and cc.cliente_id = $cliente_id ";
	$result_prod = pg_query($query_prod) or die ("Erro na consulta!".pg_last_error($connect));
	$total = 0;
	while($row_prod = pg_fetch_array($result_prod)){
		if(!empty($row_prod['preco_unitario'])){
            $row_prod['preco_prod'] = $row_prod['preco_unitario'];
        }
        $total += ($row_prod[preco_prod]*$row_prod[quantidade]);
?>
	<tr>
		<td width="4%" align="center" valign="top" class="fontepreta12 style2">&nbsp;<?php echo cz($item = $item + 1); ?></td>
		<td width="56%" align="justify" class="fontepreta12 style2"><?php echo convertwords($row_prod[desc_resumida_prod]);?></td>
		<td width="4%" align="right" valign="top" class="fontepreta12 style2">&nbsp;<?php echo zero($row_prod[quantidade]);?></td>
		<td width="18%" align="right" valign="top" class="fontepreta12 style2">R$&nbsp;<?php echo number_format($row_prod[preco_prod],2,",",".")?></td>
		<td width="18%" align="right" valign="top" class="fontepreta12 style2">R$&nbsp;<?php echo number_format($row_prod[preco_prod]*$row_prod[quantidade],2,",",".")?></td>
	</tr>
<?php
	}
	$subtotal = $total;
	$percentual = 18.0 / 100.0;
	$parcelas = $subtotal / 3;
	$tot_porcento = $subtotal + ($percentual * $subtotal);
	$tot_parc = $tot_porcento / 12;
?>
</table></div>
<?php
	if($cliente_id!=""){
	$ass = "SELECT f.nome, f.assinatura
			FROM funcionario f, cliente_comercial cc
			WHERE cc.funcionario_id = f.funcionario_id
			AND cc.cliente_id = $cliente_id";

	$res_ass = pg_query($connect, $ass) or die
		("Erro na query: $ass ==>". pg_last_error($connect));

	$r_ass = pg_fetch_array($res_ass);
	}
?>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<th width="60%" class="fontepreta12"><br><br><?php echo "<img src='".$r_ass[assinatura]."' border=0 width=100 height=50>"; ?><br><strong><span class="style2"><?php echo $r_ass[nome]; ?> <br />
		    Departamento Comercial</span>
			</strong></th>
		<td align="right" width="22%" class="fontepreta12 style2"><strong>TOTAL:&nbsp;&nbsp;</strong></td>
		<td width="18%" align="right" class="fontepreta12 style2"><strong>R$ <?php echo number_format($subtotal,2,",",".");?></strong></td>
	</tr>
</table></div>
<div align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="70%" align="justify" class="fontepreta12"><br />
		  <span class="style2"><b>Prazo de Entrega:</b>&nbsp;15 DIAS.</span>
		  <p class="style2">

<?PHP
if(pg_num_rows($result_prod)<9){
?>
<b>Forma de pagamento:</b>&nbsp;Única parcela no valor de R$ <?php echo number_format($subtotal,2,",",".");?>.<p class="style2">
<?PHP
}else{
?>
<b>Forma de pagamento:</b>&nbsp;R$ <?php echo number_format($subtotal,2,",",".");?>&nbsp;Divididos em 03 parcelas iguais de R$ <?php echo number_format($parcelas,2,",",".");?>&nbsp; e ou &nbsp;R$ <?php echo number_format($subtotal,2,",",".");?>&nbsp; Acrescidos de 18% R$ <?php echo number_format($tot_porcento,2,",",".");?> Dividos em 12 parcelas iguais de R$ <?php echo number_format($tot_parc,2,",","."); pg_close($connect);?>.							 		<p class="style2">
<?PHP
}
?>
		

<b>OBS: Os exames complementares ao ASO serão solicitados automaticamente, no momento do atendimento médico de acordo com a função exercida por cada trabalhador e seu pagamento deverá ser efetuado separadamente.</b></td>
		<td width="30%" class="fontepreta12">&nbsp;</td>
	</tr>
</table></div>
<div align="center">
<?PHP
if(!$_GET['sem_timbre']){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<p>
		<tr>
		<td width="65%" align="center" class="fontepreta12 style2">
		<br /><br /><br /><br /><br /><br />
		  <span class="style17">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>		  <p class="style17">
		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
          www.sesmt-rio.com / www.shoppingsesmt.com<br />

	    </td>
		<td width="35%" align="right"><img src="img/logo_sesmt2.png" width="280" height="200" /></td>
	</tr>
</table>
<?PHP
}else{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<p>
		<tr>
		<td width="100%" height="220" align="right">&nbsp;
        </td>
	</tr>
</table>
<?PHP
}
?>

</div>
</form>
</body>
</html>
