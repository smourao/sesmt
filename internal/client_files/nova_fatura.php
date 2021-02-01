<?php
/***************************************************************************************************************/
// -> INCLUDES / DEFINES
/***************************************************************************************************************/
define('_MPDF_PATH', '../../common/MPDF45/');
define('_IMG_PATH', '../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../common/includes/database.php");
include("../../common/includes/functions.php");
/********************************************************************************************************/
// -> VARS
/*********************************************************************************************************/

/*****************************************************************************************************/
// -> BEGIN DOCUMENT
/******************************************************************************************************/
ob_start(); /************************************************************************************************************/
    // -> HEADER /************************************************************************************************************/
$cabecalho .= "<tr>";
$cabecalho .= '<td align="left" width=20%>
	<p><strong>
	<font size="7" face="Verdana, Arial, Helvetica, sans-serif">SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;</td><td align=center>
	<font size="3" face="Verdana, Arial, Helvetica, sans-serif">SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> 
																E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
																CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
	</td>';
$cabecalho .= "</tr>";
$cabecalho .= "</table>";
/************************************************************************************************************/
// -> FOOTER
/***********************************************************************************************************/
/*
$rodape .= "<table width=100% border=0>";
$rodape .= "<tr>";
$rodape .= "<td align=left><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 7844 9394 - Id 55*23*31368</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=130><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
</td>";
$rodape .= "</tr>";
$rodape .= "</table>";
*/
$code = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>';

/***************************************************************************************************************/
// -> PAGE [1]
/***************************************************************************************************************/
$code .= '<br/>
<table width="100%" style="border: 1px solid black;" bordercolor="#000000" cellspacing="0">
  <tr>
    <td width="70%" align="left"><b><font size="5">Fatura de Prestação de Serviço		</font></b></td>
    <td width="30%" align="center"><b><font size="5">nº 0000/0000						</font></b></td>
  </tr>
</table>';

$code .= '<br/>
<table width="100%" border="0" cellspacing="0"><tr><td width="20%"></td><td width="80%" style="border: 1px solid black;" bordercolor="#000000">
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td colspan="2"><font size="3">Cliente: ( A Clínica conveniada)</td>
    <td colspan="2"><font size="3">CNPJ: 00.000.000/0000-00</td>
  </tr>
  <tr>
    <td colspan="2"><font size="3">Sr.(ª): X . X . X . X</td>
    <td colspan="2"><font size="3">Endereço: x.x.x.x.x.x.x.x.x.x.x.x.x., 000</td>
  </tr>
  <tr>
    <td><font size="3">Cep.: 00000-000</td>
    <td><font size="3">Bairro: x.x.x.x.x.x.x.</td>
    <td><font size="3">UF: RJ</td>
    <td><font size="3">Cidade:</td>
  </tr>
  <tr>
    <td colspan="2"><font size="3">Contrato do Cliente:0000</td>
    <td colspan="2"><font size="3">Código do Cliente: 0000</td>
  </tr>
  <tr>
    <td colspan="2"><font size="3">Data da Emissão: 00/00/0000</td>
    <td colspan="2"><font size="3">Período: 00/00/0000 á 00/00/0000</td>
  </tr>
  <tr>
    <td><font size="3">Vencimento: 00/00/0000</td>
    <td colspan="2"><font size="3">Data de Postagem: 00/00/0000</td>
    <td><font size="3">Hora: : hs</td>
  </tr>
</table></td></tr></table>';

$code .= '<br/>
<table width="100%" style="border: 1px solid black;" bordercolor="#000000" cellspacing="0">
  <tr>
    <td width="70%" align="left"><b><font size="3">00190.00009 01361.420209 00001.204171 7 56550000010050</font></b></td>
    <td width="30%" align="center"><b><font size="3">Recibo Sacado</font></b></td>
  </tr>
</table>';

$code .= '<br/>
<table width="100%" cellspacing="0" style="border: 1px solid black;" bordercolor="#000000">
  <tr>
    <td width="40%" align=center style="border-bottom: 1px solid black;" bordercolor="#000000"><b><font size="3">Natureza do Serviço</b></td>
    <td width="12%" style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000" align=center><font size="3">Quantidade</td>
    <td width="18%" style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000" align=center><font size="3">Parcela</td>
    <td width="12%" style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000" align=center><font size="3">Valor Unitário</td>
    <td width="18%" style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000" align=center><font size="3">Valor Total</td>
  </tr>
  <tr>
    <td align=left style="border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">Prestação de serviço em Segurança e Medicina
Ocupacional "Cobrança Mensal", conforme esta
vigente na cláusula 4.1 do contrato de numero:
2005.0065.0045</td>
    <td align=center style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">01</td>
    <td align=center style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">5/12</td>
    <td align=center style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">133,90</td>
    <td align=center style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">133,90</td>
  </tr>
  <tr>
    <td align=left style="border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">Prestação de serviço em segurança e medicina
ocupacional,em emissão de ASO Admissional, em
07/03/2013, do(s) funcionario(s): José Ricardo Sales
Macedo. Conforme esta vigente no contrato de
número: 2009.189.0206</td>
    <td align=center style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">02</td>
    <td align=center style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">1/01</td>
    <td align=center style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">13,50</td>
    <td align=center style="border-left: 1px solid black;border-bottom: 1px solid black;" bordercolor="#000000"><font size="2">27,00</td>
  </tr>
  <tr>
    <td align=left ><font size="2">Taxa correspondente a atualização de programa por
movimentação de pessoal"Pro-rata", Conforme
cláusula 2.1 (s) e 3.1(k) e do contrato de
número:2009.189.0206</td>
    <td align=center style="border-left: 1px solid black;" bordercolor="#000000"><font size="2">01</td>
    <td align=center style="border-left: 1px solid black;" bordercolor="#000000"><font size="2">1/01</td>
    <td align=center style="border-left: 1px solid black;" bordercolor="#000000"><font size="2">25,00</td>
    <td align=center style="border-left: 1px solid black;" bordercolor="#000000"><font size="2">25,00</td>
  </tr>
</table>
';

$code .= '<br/>
<table width="100%" style="border: 1px solid black;" bordercolor="#000000" cellspacing="0">
  <tr>
    <td width="82%" align="left" ><b><font size="3">Total a Pagar**</font></b></td>
    <td width="18%" align="center"><b><font size="3">R$ 185,50</font></b></td>
  </tr>
</table>';

$code .= '
<p><b><font size="2">Instruções de responsabilidade do cedente</b>
<p><font size="2">Multa de atrazo.....: R$ 5,56 após 5 dias corridos do vencimento
<br><font size="2">Juros de mora.......: R$ 0,29 ao dia
<p><font size="2">Sr. caixa, caso a fatura esteja em atraso somar o valor da cobrança com o valor da multa e o valor do juros de
acordo com os dias vencidos. Cobrança sujeita a protesto, caso haja atraso com mais de 05 cinco dias do
vencimento.';

$code .= '<br/>
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td colspan="2"><font size="2">Cedente: SESMT Serv Esp de Seg e Monit de Ativ no Trab Ltda</td>
    <td><font size="2">CNPJ: 04.722.248/0001-17</td>
    <td><font size="2">Cód. Cedente: 0576-2 38858- 0</td>
  </tr>
  <tr>
    <td><font size="2">Sacado: Cortex 28 Metalurgica</td>
    <td><font size="2">CNPJ: 01.202.041/0001-23</td>
    <td><font size="2">Vencimento: 00/00/00</td>
    <td><font size="2">Documento: 0000/0000</td>
  </tr>
</table>';

$code .= '<br/>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="70%" align="left"><b><font size="3">00190.00009 01361.420209 00001.204171 7 56550000010050</font></b></td>
    <td width="30%" align="center"><b><font size="3">Recibo de Entrega</font></b></td>
  </tr>
</table>';


ob_end_clean();
/***************************************************************************************************************/
// -> OUTPUT
/***************************************************************************************************************/
$mpdf = new mPDF('pt', 'A4', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'P'); //P: DEFAULT Portrait L: Landscape
$mpdf->charset_in='iso-8859-1';
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetHTMLHeader($cabecalho);
$mpdf->SetHTMLFooter($rodape);
$mpdf->WriteHTML($code);
$arquivo = "fatura.pdf";
$mpdf->Output($arquivo,'I');
exit();

?>