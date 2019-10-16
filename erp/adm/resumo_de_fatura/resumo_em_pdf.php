<?php
require_once("../../2.0/common/dompdf/dompdf_config.inc.php");
require_once("../../2.0/common/database/conn.php");

/*
<script type="text/php">
if ( isset($pdf) ) {
// Configurações para ajustar o tamanho do texto, cores, e dimensões da area do arquivo
$font = Font_Metrics::get_font("Helvetica");
$size = 9;
$color = array(0,0,0);
$text_height = Font_Metrics::get_font_height($font,$size);
$foot = $pdf->open_object();
$w = $pdf->get_width();
$h = $pdf->get_height();
$pdf->close_object();
$pdf->add_object($font, "all");
// Cria uma linha no rodapé
$y = $h - $text_height - 45;
$pdf->line(12, $y, $w - 16, $y, $color, 0.5);
// Insere um texto um pouco acima da linha do rodapé
$_texto = utf8_encode("Texto Texto);
$w1 = Font_Metrics::get_text_width($_texto , $font, 7);
$y = $h - $text_height - 23;
$pdf->page_text($w / 2 - $w1 / 2, $y, $_texto , $font, 7, $color);
// Numero da pagina
$text = utf8_encode("Página {PAGE_NUM} de {PAGE_COUNT} ") ;
$width = Font_Metrics::get_text_width("Pagina 1 de 2", $font, 6);
$y = $h - $text_height - 2;
$w = $w - 14;
$pdf->page_text($w - $width, $y, $text, $font, 6, $color);
}
</script>
<!--$pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));-->
*/



//***********************************************************************************************
//                                 ***  MAIL  ***
//***********************************************************************************************

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

    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html;charset=iso-8859-1\n";//"Content-type: multipart/mixed;";
    $headers .= 'From: SESMT - Comercial <comercial@sesmt-rio.com>' . "\n" .
    'Reply-To: comercial@sesmt-rio.com' . "\n" .
    'X-Mailer: PHP/' . phpversion();

$msg = "";

$cabecalho = '<table width=100% border=0>
		<tr>
			<td align="left">
            <p><strong>
            SESMT<sup><font size=2>®</font></sup>&nbsp;&nbsp;
			SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</strong>
            </td>
            <td width=40% valign=top>
            <b>Resumo de Fatura de Serviço</b>
            </td>
	  </tr>
	</table>';

$msg .= '
<html>
<head>
<title>Fatura de Serviços</title>
</head>
<body bgcolor="#FFFFFF" text="#000000">

<script type="text/php">
if ( isset($pdf) ) {
$font = Font_Metrics::get_font("verdana", "bold");
$pdf->page_text(72, 18, "<table width=100% border=0><tr><td>aff</td></tr></table>", $font, 6, array(0,0,0));
}
</script>



  <table width="100%" border="1">
    <tr>
      <td width="50%" height="16">
      <strong>Resumo de Fatura de Servi&ccedil;o</strong></td>
	  <td width="50%" align="right"><strong>
      Nº: ';
      $msg .= STR_PAD($_GET['fatura'], 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao']));
      $msg .= '</strong></td>
	</tr>
  </table>
  
    <table width="63%" border="0">
      <tr>
        <td>
        <strong>Cliente: </strong>'.$cliente_info['razao_social'].'</td>
      </tr>
      <tr>
        <td>';
        if($cliente_info[cnae_id]){
            $msg .= "CNPJ";
        }else{
            $msg .= "CPF";
        }
        $msg .= ':'.$cliente_info['cnpj'].'</td>
      </tr>
      <tr>
        <td>
        <strong>Contrato de Cliente: </strong> '.$cliente_info['ano_contrato'].'</td>
      </tr>
      <tr>
        <td><strong>
        Tipo de Contrato: </strong> '.$fatura_info['tipo_contrato'].'</td>
      </tr>
      <tr>
        <td height="23">
        <strong>C&oacute;digo do Cliente: </strong>'.str_pad($cliente_info['cliente_id'], 3,"0", STR_PAD_LEFT).'</td>
      </tr>
      <tr>
        <td><strong>Data da Emiss&atilde;o:</strong> '.date("d/m/Y", strtotime($fatura_info['data_emissao'])).'</td>
      </tr>
      ';
      if(!$fatura_info[tipo_fatura]){
      $msg .= '<tr>
        <td><strong>Per&iacute;odo de Cobran&ccedil;a:</strong> ';
        $emifor = explode("/", date("d/m/Y", strtotime($fatura_info['data_emissao'])));

        if($fatura_info['data_emissao'])
        $msg.= date("d/m/Y", mktime(0,0,0,$emifor[1]-1, $emifor[0], $emifor[2]))." à ".date("d/m/Y", strtotime($fatura_info['data_emissao']));

        $msg .= "</td></tr>";
      }

      $msg .= '
      <tr>
        <td><strong>Vencimento:</strong> '.date("d/m/Y", strtotime($fatura_info['data_vencimento'])).'</td>
      </tr>
    </table>

  <table width="100%" border="1">
    <tr>
      <td width="52%">Natureza dos Servi&ccedil;os</td>
      <td width="8%">N&ordm; da<br> Parcela</td>
      <td width="8%">Qtd</td>
      <td width="17%">Valor Unit&aacute;rio<br> (R$)</td>
      <td width="15%">Valor Total<br> (R$)</td>
    </tr>
    ';

    $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$_GET['fatura']}'";
    $result = pg_query($sql);
    $prod = pg_fetch_all($result);
    $total = 0;
    for($x=0;$x<pg_num_rows($result);$x++){
    $msg .= '
    <tr>
      <td>'.$prod[$x]['descricao'].'</td>
      <td align=center>'.$prod[$x]['parcelas'].'</font></td>
      <td align=center>'.STR_PAD($prod[$x]['quantidade'], 2, "0",STR_PAD_LEFT).'</td>
      <td align=right>'.number_format($prod[$x]['valor'], 2, ",",".").'</td>
      <td align=right>'.number_format(($prod[$x]['valor']*$prod[$x]['quantidade']), 2, ",",".").'</td>
    </tr>
    ';
    $total+= $prod[$x]['valor']*$prod[$x]['quantidade'];
    }

    $msg .= '
    <tr>
      <td height="23">
      <strong>
      Total a Pagar**</strong></td>
      <td colspan=3>&nbsp;</td>
      <td align=right>
      <strong>
      R$&nbsp;'.number_format($total, 2, ",",".").'
      </strong>
      </td>
    </tr>
  </table>

<p align=left>
  ** Os pagamentos desta fatura não isentam o pagamento de ventuais saldos devedores. <b>Venc. '.date("d/m/y", strtotime($fatura_info['data_vencimento'])).'</b>.<br>
  Informamos que sua utilização está demonstrada por cada serviço utilizado e oferecido pela SESMT,
  para maiores esclarecimentos, ligue para nossa <b>central de atendimento: </b> +55 (21) 3014 4304,
  ou entre em contato com nosso balcão de atendimento virtual, e-mail: <b>faleprimeirocomagente@sesmt-rio.com.</b>
  <p>
  <p align=left>
  <div style="page-break-before: always;"></div>
  ';

if($fatura_info[tipo_fatura]){
    //LISTA DE FUNCIONÁRIOS
    $msg .= "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    $msg .= "<tr>";
    $msg .= "<td colspan=4 align=center><b>DETALHAMENTO</b></td>";
    $msg .= "</tr>";
    $msg .= "<tr>";
    $msg .= "<td align=center width=10><b>Nº</b></td>";
    $msg .= "<td align=center width=250><b>Nome</b></td>";
    $msg .= "<td align=center><b>Função</b></td>";
    $msg .= "<td align=center><b>Exames Complementares</b></td>";
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
            $msg .= "<td align=center bgcolor='$bg'>".($i+1)."</td>";
            $msg .= "<td align=left bgcolor='$bg' >&nbsp;$funcionario[nome_func]</td>";
            $msg .= "<td align=left bgcolor='$bg' >$funcionario[nome_funcao]</td>";
            $msg .= "<td align=left bgcolor='$bg' >$exl</td>";
            $msg .= "</tr>";
        }
   }
   $msg .= "</table>";
}

 $sql = "SELECT * FROM site_fatura_propaganda";
 $buffer = pg_fetch_array(pg_query($sql));

  $msg.= $buffer['texto'];

  $msg .= '</b>
   <p>
  <table width=100%>
  <tr>
     <td align=center>
     <b> Telefone: +55 (21) 3014 4304 &nbsp; Fax: Ramal 7
     <br>
     Nextel: +55 (21) 7844 9394 - Id 55*23*31368
     <P>
     faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com
     <br>
     www.sesmt-rio.com / www.shoppingsesmt.com</b>
     </td>
     <td width=130><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>coma gente!</b>
     </td>
  </tr>
  </table>
</body>
</html>   ';



$dompdf = new DOMPDF();
$dompdf->load_html($msg);
$dompdf->render();
$dompdf->stream("sample.pdf", array("Attachment" => 0));

?>

