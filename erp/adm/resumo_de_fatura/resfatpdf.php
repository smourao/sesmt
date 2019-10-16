<?php
//require_once("../../2.0/common/dompdf/dompdf_config.inc.php");
require_once("../../2.0/common/database/conn.php");

ob_start();  //inicia o buffer

   if($_GET[pc]){
   $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$_GET['cod_cliente']} AND filial_id={$_GET['cod_filial']} AND contratante = 1";
   }else{
   $sql = "SELECT * FROM cliente WHERE cliente_id = {$_GET['cod_cliente']} AND filial_id={$_GET['cod_filial']}";
   }
   $rz = pg_query($sql);
   $cliente_info = pg_fetch_array($rz);

   $sql = "SELECT * FROM site_fatura_info WHERE cod_fatura = '{$_GET['fatura']}'";
   $reza = pg_query($sql);
   $fatura_info = pg_fetch_array($reza);

   $flist = $fatura_info[tipo_fatura_list];
   $flist = explode("|", $flist);
   $flist = array_flip($flist);
   $flist = array_flip($flist);
   $fl = array();
   foreach($flist as $key => $value){
   if(!empty($value))
       $fl[] = $value;
   }


$cabecalho = '
<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left">
            <p><b>
            <span id=sesmt><font size="6" face="Verdana">SESMT</span><span style="position: relative;top:-15px;"><sup><font size=2>®</font></sup></font></span>&nbsp;&nbsp;
			<font size="1" face="Verdana">SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></b>
            </td>
            <td width=40% valign=top>
            <font face="Verdana, Arial, Helvetica, sans-serif" size="3">
            <b>Resumo de Fatura de Serviço</b>
            </td>
	  </tr>
</table>';

$rodape = '
  <table width=100% border=0>
  <tr>
     <td align=center style="font-family: verdana; font-size: 12px;">
     <p style="font-family: verdana; font-size: 14px;">
     <b>Telefone: +55 (21) 3014 4304 &nbsp; Fax: Ramal 7
     <br>
     Nextel: +55 (21) 7844 9394 - Id 55*23*31368
     <P style="font-family: verdana; font-size: 12px;">
     faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com
     <br>
     www.sesmt-rio.com / www.shoppingsesmt.com</b>
     </td>
     <td width=100 style="font-family: verdana; font-size: 12px;">
     <b>Pensando em<br>
     renovar seus<br>
     programas?<br>
     Fale primeiro<br>
     com a gente!</b>
     </td>
  </tr>
  </table>
  <center><div style="font-family: verdana; font-size: 8px;" align=center>{PAGENO}/{nb}</div></center>
';

/*
<htmlpageheaderzzzzzzzzz name="MyHeader1zzzzzzzzz">
<table width=100% height=300 border=0>
		<tr>
			<td>
            <b>SESMT&reg;&nbsp;&nbsp;SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br>
            E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></b>
            </td>
            <td width=40% valign=top>
            <b>Resumo de Fatura de Serviço</b>
            </td>
	  </tr>
</table>
</htmlpageheader>
<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"  />
*/

$msg = "";

$msg .= '
<html>
<head>
</head>
<body bgcolor="#FFFFFF" text="#000000">
  <table width=100% border=0 cellspacing=0 cellpadding=0>
    <tr>
      <td width="50%" height="16" style="border: 1px solid black; border-right: 0px;border-color: #000000;border-collapse:collapse;"><font size="3" face="verdana"><b>Resumo de Fatura de Servi&ccedil;o</b></font></td>
	  <td width="50%" align="right" style="border: 1px solid black; border-left: 0px;border-color: #000000;border-collapse:collapse;"><b>
      <font face="verdana">Nº: ';

      $msg .= STR_PAD($_GET['fatura'], 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao']));

      $msg .= '</b></td>
	</tr>
  </table>

    <table width="80%" border="0" align=right>
      <tr>
        <td style="font-family: verdana; font-size: 12px;" width=150>
        <b>Cliente:</b></td>
        <td style="font-family: verdana; font-size: 12px;">'.$cliente_info['razao_social'].'</td>
      </tr>
      <tr>
        <td style="font-family: verdana; font-size: 12px;">';
        if($cliente_info[cnae_id]){
            $msg .= "<b>CNPJ";
        }else{
            $msg .= "<b>CPF";
        }
        $msg .= ':</b> </td>
        <td style="font-family: verdana; font-size: 12px;">'.$cliente_info['cnpj'].'</td>
      </tr>
      <tr>
        <td style="font-family: verdana; font-size: 12px;">
        <b>Contrato de Cliente: </b> </td>
        <td style="font-family: verdana; font-size: 12px;">'.$cliente_info['ano_contrato'].'</td>
      </tr>
      <tr>
        <td style="font-family: verdana; font-size: 12px;"><b>
        Tipo de Contrato: </b> </td>
        <td style="font-family: verdana; font-size: 12px;">'.$fatura_info['tipo_contrato'].'</td>
      </tr>
      <tr>
        <td style="font-family: verdana; font-size: 12px;">
        <b>C&oacute;digo do Cliente: </b></td>
        <td style="font-family: verdana; font-size: 12px;">'.str_pad($cliente_info['cliente_id'], 3,"0", STR_PAD_LEFT).'</td>
      </tr>
      <tr>
        <td style="font-family: verdana; font-size: 12px;"><b>Data da Emiss&atilde;o:</b> </td>
        <td style="font-family: verdana; font-size: 12px;">'.date("d/m/Y", strtotime($fatura_info['data_emissao'])).'</td>
      </tr>
      ';
      if(!$fatura_info[tipo_fatura]){
      $msg .= '<tr>
        <td style="font-family: verdana; font-size: 12px;"><b>Per&iacute;odo de Cobran&ccedil;a:</b> </td>
        <td style="font-family: verdana; font-size: 12px;">';
        $emifor = explode("/", date("d/m/Y", strtotime($fatura_info['data_emissao'])));

        if($fatura_info['data_emissao'])
        $msg.= date("d/m/Y", mktime(0,0,0,$emifor[1]-1, $emifor[0], $emifor[2]))." à ".date("d/m/Y", strtotime($fatura_info['data_emissao']));

        $msg .= "</td></tr>";
      }

      $msg .= '
      <tr>
        <td style="font-family: verdana; font-size: 12px;"><b>Vencimento:</b> </td>
        <td style="font-family: verdana; font-size: 12px;">'.date("d/m/Y", strtotime($fatura_info['data_vencimento'])).'</td>
      </tr>
    </table>

  <table width="100%" border="0" cellspacing=0 cellpadding=0>
    <tr>
      <td width="52%" style="font-family: verdana; font-size: 12px;border: 1px solid black; border-right: 0px;" align=center><b>Natureza dos Servi&ccedil;os</b></td>
      <td width="8%" style="font-family: verdana; font-size: 12px;border: 1px solid black; border-right: 0px;" align=center><b>Parcela</b></td>
      <td width="8%" style="font-family: verdana; font-size: 12px;border: 1px solid black; border-right: 0px;" align=center><b>Qtd</b></td>
      <td width="15%" style="font-family: verdana; font-size: 12px;border: 1px solid black; border-right: 0px;" align=center><b>Valor Unit.(R$)</b></td>
      <td width="15%" style="font-family: verdana; font-size: 12px;border: 1px solid black;" align=center><b>Valor Total(R$)</b></td>
    </tr>
    ';

    $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$_GET['fatura']}' ORDER BY valor DESC";
    $result = pg_query($sql);
    $prod = pg_fetch_all($result);
    $total = 0;
    for($x=0;$x<pg_num_rows($result);$x++){
    $tpm = $prod[$x]['parcelas'];
    $tpm = explode('/', $tpm);
    $tpm = ltrim($tpm[0], "0") . "/" . str_pad($tpm[1], 2, "0", 0);

    if(($x % 2) != 0){
       $bg = '#FFFFFF';
    }else{
       $bg = '#EEEEEE';
    }
    
    $msg .= '
    <tr>
      <td bgcolor="'.$bg.'" style="font-family: verdana; font-size: 12px;border: 1px solid black; border-top: 0px; border-right: 0px;border-bottom: 0px; ">'.$prod[$x]['descricao'].'</td>
      <td bgcolor="'.$bg.'" align=center style="font-family: verdana; font-size: 12px;border: 1px solid black; border-top: 0px; border-bottom: 0px; border-right: 0px; ">'.$tpm.'</font></td>
      <td bgcolor="'.$bg.'" align=center style="font-family: verdana; font-size: 12px;border: 1px solid black; border-top: 0px; border-bottom: 0px; border-right: 0px;">'.STR_PAD($prod[$x]['quantidade'], 2, "0",STR_PAD_LEFT).'</td>
      <td bgcolor="'.$bg.'" align=right style="font-family: verdana; font-size: 12px;border: 1px solid black; border-top: 0px; border-bottom: 0px; border-right: 0px;">'.number_format($prod[$x]['valor'], 2, ",",".").'</td>
      <td bgcolor="'.$bg.'" align=right style="font-family: verdana; font-size: 12px;border: 1px solid black; border-top: 0px; border-bottom: 0px; ">'.number_format(($prod[$x]['valor']*$prod[$x]['quantidade']), 2, ",",".").'</td>
    </tr>';
    
    $total+= $prod[$x]['valor']*$prod[$x]['quantidade'];
    }

    $msg .= '
    <tr>
      <td height="23" style="font-family: verdana; font-size: 12px;border: 1px solid black; 0px; border-right: 0px;">
      <b>
      Total a Pagar**</b></td>
      <td colspan=3 style="font-family: verdana; font-size: 12px;border: 1px solid black; border-right: 0px; border-left: 0px;">&nbsp;</td>
      <td align=right style="font-family: verdana; font-size: 12px;border: 1px solid black; border-left: 0px;">
      <b>
      R$&nbsp;'.number_format($total, 2, ",",".").'
      </b>
      </td>
    </tr>
  </table>

<p align=justify  style="font-family: verdana; font-size: 10px;">
  ** Os pagamentos desta fatura não isentam o pagamento de ventuais saldos devedores. <b>Venc. '.date("d/m/y", strtotime($fatura_info['data_vencimento'])).'</b>.<br>
  Informamos que sua utilização está demonstrada por cada serviço utilizado e oferecido pela SESMT,
  para maiores esclarecimentos, ligue para nossa <b>central de atendimento: </b> +55 (21) 3014 4304,
  ou entre em contato com nosso balcão de atendimento virtual, e-mail: <b>faleprimeirocomagente@sesmt-rio.com.</b>
  <p>';
  
$sql = "SELECT * FROM site_fatura_propaganda";
$buffer = pg_fetch_array(pg_query($sql));

$msg .= '<p align=justify style="font-family: verdana; font-size: 10px;"><b>'.$buffer['texto'].'</b>';



if($fatura_info[tipo_fatura]){
    $msg .= '<div style="page-break-before: always;"></div>';
    //LISTA DE FUNCIONÁRIOS
    $msg .= "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    $msg .= "<tr>";
    $msg .= "<td colspan=4 align=center style=\"font-family: verdana; font-size: 12px;\"><b>DETALHAMENTO DE SERVIÇO</b></td>";
    $msg .= "</tr>";
    $msg .= "<tr>";
    $msg .= "<td align=center width=10 style=\"font-family: verdana; font-size: 12px;\"><b>Nº</b></td>";
    $msg .= "<td align=center width=250 style=\"font-family: verdana; font-size: 12px;\"><b>Nome</b></td>";
    $msg .= "<td align=center width=150 style=\"font-family: verdana; font-size: 12px;\"><b>Função</b></td>";
    $msg .= "<td align=center style=\"font-family: verdana; font-size: 12px;\"><b>Exames Complementares</b></td>";
    $msg .= "</tr>";
    for($i=0;$i<count($fl);$i++){
       $sql = "SELECT f.*, fc.nome_funcao
       FROM funcionarios f, funcao fc
       WHERE
       f.cod_cliente = $_GET[cod_cliente] AND
       f.cod_func = $fl[$i] AND
       fc.cod_funcao = f.cod_funcao";
       $result = pg_query($sql);
       $funcionario = pg_fetch_array($result);

       //lista de exames para a função do cabra acima
       if($funcionario[cod_funcao]){
           $sql = "SELECT * FROM funcao_exame WHERE cod_exame = $funcionario[cod_funcao]";
           $result = pg_query($sql);
           $exames = pg_fetch_all($result);

           if(($i % 2) != 0){
               $bg = '#FFFFFF';
            }else{
               $bg = '#EEEEEE';
            }
            $exl = "";
            for($e=0;$e<count($exames);$e++)
               $exl .= $exames[$e][descricao].";";

            $msg .= "<tr>";
            $msg .= "<td align=center bgcolor='$bg' style=\"font-family: verdana; font-size: 12px;\">".($i+1)."</td>";
            $msg .= "<td align=left bgcolor='$bg' style=\"font-family: verdana; font-size: 12px;\">&nbsp;$funcionario[nome_func]</td>";
            $msg .= "<td align=left bgcolor='$bg' style=\"font-family: verdana; font-size: 12px;\">$funcionario[nome_funcao]</td>";
            $msg .= "<td align=left bgcolor='$bg' style=\"font-family: verdana; font-size: 12px;\" >".str_replace(';', '; ', $exl)."</td>";
            $msg .= "</tr>";
        }
   }
   $msg .= "</table>";
}


  $msg .= '
</b>
</body>
</html>';

ob_end_clean(); // Finaliza o fluxo
$html = ob_get_clean();
$html = utf8_encode($html);
//$msg = utf8_encode($msg);
define('_MPDF_PATH', '../../2.0/common/MPDF45/');
include(_MPDF_PATH.'mpdf.php');
//$mpdf = new mPDF('pt','A4',3,'',8,8,5,14,9,9,'P');
$mpdf = new mPDF();
//$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='iso-8859-1';
$mpdf->SetDisplayMode('fullpage');
//$mpdf->SetFooter('{DATE j/m/Y&nbsp; H:i}|{PAGENO}/{nb}|SEDUC / SIGETI');
$mpdf->SetHTMLHeader(/*utf8_encode(*/$cabecalho/*)*/);
$mpdf->SetHTMLFooter($rodape);

//carregar folha de estilos
//$stylesheet = file_get_contents('./stylesheets/estilosPDF.css');
//incorporar folha de estilos ao documento
//$mpdf->WriteHTML($stylesheet,1);

// incorpora o corpo ao PDF na posição 2 e deverá ser interpretado como footage. Todo footage é posicao 2 ou 0(padrão).
$mpdf->WriteHTML($msg);
//void WriteHTML ( string $html [, int $mode [, boolean $initialise  [, boolean $close ]]])
//MODE Values
//0 - Parses a whole html document
//1 - Parses the html as styles and stylesheets only
//2 - Parses the html as output elements only
//3 - (For internal use only - parses the html code without writing to document)
//4 - (For internal use only - writes the html code to a buffer)
//DEFAULT: 0

//nome do arquivo de saida PDF
$arquivo = $fatura_info[cod_fatura].'_'.$cliente_info[cliente_id].'_resumo_fatura_'.date("ymdhis").'.pdf';

//gera o relatorio
if($_GET[out] == 'D'){
    $mpdf->Output($arquivo,'D');
}else{
    $mpdf->Output($arquivo,'I');
}
/*
I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
D: send to the browser and force a file download with the name given by filename.
F: save to a local file with the name given by filename (may include a path).
S: return the document as a string. filename is ignored.
*/
exit();

?>
