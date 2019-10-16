<?php
include "../sessao.php";
include "../config/connect.php";

if($_GET) {
$cod_fatura = $_GET['cod_fatura'];
$cod_cliente = $_GET['cod_cliente'];
}else{
$cod_fatura = $_POST['cod_fatura'];
$cod_cliente = $_POST['cod_cliente'];
}

if(!empty($cod_fatura) and !empty($cod_cliente)) {
	$query_busca = "SELECT c.cod_cliente, c.cod_filial, c.razao_social_cliente, c.cnpj_cliente, f.data_compra,
					f.data_vencimento 
					FROM clientes c, fatura f
					WHERE c.cod_cliente = f.cod_cliente
					AND f.cod_fatura = $cod_fatura";
					
	$result_busca = pg_query($connect, $query_busca) 
			or die ("Erro na query: $query_busca ==> ".pg_last_error($connect));

	$row_busca = pg_fetch_array($result_busca);
}

?>
<html>
<head>
<title>Fatura de Serviços</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css" />

</head>

<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left"><p><strong><font size="6" face="Verdana, Arial, Helvetica, sans-serif">SESMT</font>&nbsp;&nbsp;
			<font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong></td>
	  </tr>
	</table>
<div align="center">
	<br>
  <table width="100%" border="1"cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="30%" height="16"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Fatura de Serviço</strong></font></td>
	  <td width="70%" align="right"><strong><font face="Verdana, Arial, Helvetica, sans-serif">Nº:</font>&nbsp;</strong></td>	    
	</tr>
  </table>
  <div align="right">
    <table width="65%" border="0"cellspacing="0" bordercolor="#000000">
      <tr>
        <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Cliente:&nbsp;</strong><?php echo $row_busca[razao_social_cliente]; ?></font></div></td>
      </tr>
      <tr>
        <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>CNPJ:&nbsp;</strong><?php echo $row_busca[cnpj_cliente]; ?></font></div></td>
      </tr>
      <tr>
        <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Contrato de Cliente:&nbsp;</strong></font></div></td>
      </tr>
      <tr>
        <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Tipo de Contrato:&nbsp;</strong></font></div></td>
      </tr>
      <tr>
        <td height="23"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Código do Cliente:&nbsp;</strong><?php echo $row_busca[cod_cliente]; ?></font></div></td>
      </tr>
      <tr>
        <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Código da Filial:&nbsp;</strong><?php echo $row_busca[cod_filial]; ?></font></div></td>
      </tr>
      <tr>
        <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Data da Emissão:&nbsp;</strong></font></div></td>
      </tr>
      <tr>
        <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Período de Cobrança:&nbsp;</strong></font></div></td>
      </tr>
      <tr>
        <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Vencimento:&nbsp;</strong></font></div></td>
      </tr>
    </table>
  </div>
  <table width="100%" height="263"  border="1"cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="50%" height="42"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"> Natureza dos Serviços</font></div></td>
      <td width="10%"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif">Nº da<br> Parcela</font></div></td>
      <td width="7%"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Qtde</font></div></td>
      <td width="18%"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Valor Unitário<br>(R$)</font></div></td>
      <td width="15%"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Valor Total<br>(R$)</font></div></td>
    </tr>
<?php
	if(!empty($cod_fatura)){
		$sql = "SELECT p.desc_detalhada_prod, p.preco_prod
				FROM fatura f, produto p
				WHERE p.cod_prod = f.cod_prod
				AND f.cod_fatura = $cod_fatura";
		$result=pg_query($connect, $sql) or die
			("Erro na consulta!".pg_last_error($connect));
	}
	while($row=pg_fetch_array($result)){
?>
    <tr>
      <td class="fontepreta12" align="left"><?php echo $row[desc_detalhada_prod]; ?></td>
      <td class="fontepreta12" align="center">&nbsp;</td>
      <td class="fontepreta12" align="center">&nbsp;</td>
      <td class="fontepreta12" align="right">R$&nbsp;<?php echo number_format($row[preco_prod],2,",",".")?></td>
      <td class="fontepreta12" align="right">R$&nbsp;<?php echo number_format($row[preco_prod],2,",",".")?></td>
    </tr>
<?php
$total = $row[preco_prod];

}
?>
    <tr>
      <td height="23" colspan="4"><strong><font face="Verdana, Arial, Helvetica, sans-serif">Total a Pagar**</font></strong></td>
      <td class="fontepreta12" align="right">R$&nbsp;<?php echo number_format($total,2,",",".")?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
</body>
</html>
