<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$fatura = $_GET['fatura'];

if(is_numeric($fatura)){
$sql= "SELECT * FROM site_fatura_info WHERE cod_fatura = '{$fatura}'";
$result = pg_query($sql);
$data = pg_fetch_array($result);
if($data['planilha_checked']){
   $sql = "UPDATE site_fatura_info SET planilha_checked = 0 WHERE cod_fatura = '{$fatura}'";
   $cod = 0;
}else{
   $sql = "UPDATE site_fatura_info SET planilha_checked = 1 WHERE cod_fatura = '{$fatura}'";
   $cod = 1;
}

if(pg_query($sql)){
   echo $cod;
}else{
   echo "";
}
}else{
   echo "";
}

/**************************************************************************************************************/
// -> ENVIO DE RESUMO POR EMAIL AO SELECIONAR
/**************************************************************************************************************/
if(!$data['planilha_checked']){
    if($data[pc]){
        $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$data['cod_cliente']} AND filial_id={$data['cod_filial']} AND contratante = 1";
    }else{
        $sql = "SELECT * FROM cliente WHERE cliente_id = {$data['cod_cliente']} AND filial_id={$data['cod_filial']}";
    }
    $rz = pg_query($sql);
    $cliente_info = pg_fetch_array($rz);

    $sql = "SELECT * FROM site_fatura_info WHERE cod_fatura = '{$fatura}'";
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

    $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>";

    $msg .= '
    <html>
    <head>
    <title>Fatura de Serviços</title>
    </head>

    <body bgcolor="#FFFFFF" text="#000000"> <center>
    <div align="center" style="width: 730px;">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0">
    		<tr>
    			<td align="left">
                <p><strong>
                <font size="6" face="Verdana, Arial, Helvetica, sans-serif">SESMT<sup><font size=2>®</font></sup></font>&nbsp;&nbsp;
    			<font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
    			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
                </td>
                <td width=40% valign=top>
                <font face="Verdana, Arial, Helvetica, sans-serif" size="3">
                <b>Resumo de Fatura de Serviço</b>
                </td>
    	  </tr>
    	</table>
    <div align="center">
    	<br>
      <table width="100%" border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
        <tr>
          <td width="50%" height="16"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Resumo de Fatura de Servi&ccedil;o</strong></font></td>
    	  <td width="50%" align="right"><strong>
          <font face="Verdana, Arial, Helvetica, sans-serif">Nº: ';

          $msg .= STR_PAD($_GET['fatura'], 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao']));

          $msg .= '</font>&nbsp;</strong></td>
    	</tr>
      </table>
      <div align="right">
        <table width="63%" border="0"cellspacing="0" bordercolor="#000000">
          <tr>
            <td><div align="left">
            <font face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <strong>Cliente: </strong>'.$cliente_info['razao_social'].'</font></div></td>
          </tr>
          <tr>
            <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="2"><strong>
            <font face="Verdana, Arial, Helvetica, sans-serif">
            ';
            if($cliente_info[cnae_id]){
                $msg .= "CNPJ";
            }else{
                $msg .= "CPF";
            }
            $msg .= ': </font></strong>'.$cliente_info['cnpj'].'</font></div></td>
          </tr>
          <tr>
            <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <strong>Contrato de Cliente: </strong> '.$cliente_info['ano_contrato'].'</font></div></td>
          </tr>
          <tr>
            <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong>
            Tipo de Contrato: </strong> '.$fatura_info['tipo_contrato'].'</font></div></td>
          </tr>
          <tr>
            <td height="23"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <strong>C&oacute;digo do Cliente: </strong>'.str_pad($cliente_info['cliente_id'], 3,"0", STR_PAD_LEFT).'</font></div></td>
          </tr>
          <tr>
            <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong>
            Data da Emiss&atilde;o:</strong> '.date("d/m/Y", strtotime($fatura_info['data_emissao'])).'</font></div></td>
          </tr>
          ';
          if(!$fatura_info[tipo_fatura]){
          $msg .= '<tr>
            <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong>
            Per&iacute;odo de Cobran&ccedil;a:</strong> ';
            $emifor = explode("/", date("d/m/Y", strtotime($fatura_info['data_emissao'])));

            if($fatura_info['data_emissao'])
            $msg.= date("d/m/Y", mktime(0,0,0,$emifor[1]-1, $emifor[0], $emifor[2]))." à ".date("d/m/Y", strtotime($fatura_info['data_emissao']));

            $msg .= "
            </font></div></td>
          </tr>";
          }

          $msg .= '
          <tr>
            <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <strong>Vencimento:</strong> '.date("d/m/Y", strtotime($fatura_info['data_vencimento'])).'</font></div></td>
          </tr>
        </table>
      </div>
      <table width="100%" height="263"  border="0" style="border: 1px solid black;" cellspacing="0" bordercolor="#000000">
        <tr>
          <td width="52%" height="42" style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"> Natureza dos Servi&ccedil;os</font></div></td>
          <td width="8%" style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif">N&ordm; da<br> Parcela</font></div></td>
          <td width="8%" style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Qtd</font></div></td>
          <td width="17%" style="border-right: 1px solid black;border-bottom: 1px solid black;"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Valor Unit&aacute;rio<br> (R$)</font></div></td>
          <td width="15%" style="border-bottom: 1px solid black;"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Valor Total<br> (R$)</font></div></td>
        </tr>
        ';

        $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$fatura}'";
        $result = pg_query($sql);
        $prod = pg_fetch_all($result);
        $total = 0;
        for($x=0;$x<pg_num_rows($result);$x++){
            $msg .= '
            <tr>
              <td valign=top style="border-right: 1px solid black;"><font size="2" face="Arial, Helvetica, sans-serif">'.$prod[$x]['descricao'].'</font></td>
              <td valign=top style="border-right: 1px solid black;" align=center><font size="2" face="Arial, Helvetica, sans-serif">'.$prod[$x]['parcelas'].'</font></td>
              <td valign=top style="border-right: 1px solid black;" align=center><font size="2" face="Arial, Helvetica, sans-serif">'.STR_PAD($prod[$x]['quantidade'], 2, "0",STR_PAD_LEFT).'</font></td>
              <td valign=top style="border-right: 1px solid black;" align=right><font size="2" face="Arial, Helvetica, sans-serif">'.number_format($prod[$x]['valor'], 2, ",",".").'</font></td>
              <td valign=top align=right><font size="2" face="Arial, Helvetica, sans-serif">'.number_format(($prod[$x]['valor']*$prod[$x]['quantidade']), 2, ",",".").'</font></td>
            </tr>

            <tr>
              <td style="border-right: 1px solid black;">&nbsp;</td>
              <td style="border-right: 1px solid black;">&nbsp;</td>
              <td style="border-right: 1px solid black;">&nbsp;</td>
              <td style="border-right: 1px solid black;">&nbsp;</td>
              <td >&nbsp;</td>
            </tr>
            ';
            $total+= $prod[$x]['valor']*$prod[$x]['quantidade'];
        }

        $msg .= '
        <tr>
          <td height="23"  style="border-top: 1px solid black;">
          <strong>
          <font face="Verdana, Arial, Helvetica, sans-serif">Total a Pagar**</font></strong></td>
          <td colspan=3  style="border-top: 1px solid black;">&nbsp;</td>
          <td align=right  style="border-top: 1px solid black;">
          <strong>
          <font face="Verdana, Arial, Helvetica, sans-serif">
          R$&nbsp;'.number_format($total, 2, ",",".").'
          </font></strong>
          </td>
        </tr>
      </table>
    </div>
    <p align=left>
    <font face="Verdana, Arial, Helvetica, sans-serif" size=2>
      ** Os pagamentos desta fatura não isentam o pagamento de ventuais saldos devedores. <b>Venc. '.date("d/m/y", strtotime($fatura_info['data_vencimento'])).'</b>.<br>
      Informamos que sua utilização está demonstrada por cada serviço utilizado e oferecido pela SESMT,
      para maiores esclarecimentos, ligue para nossa <b>central de atendimento: </b> +55 (21) 3014 4304,
      ou entre em contato com nosso balcão de atendimento virtual, e-mail: <b>faleprimeirocomagente@sesmt-rio.com.</b>
      <p>
      <p align=left>
      <b>';

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
           f.cod_cliente = $data[cod_cliente] AND
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
                $msg .= "<td align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">".($i+1)."</td>";
                $msg .= "<td align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">&nbsp;$funcionario[nome_func]</td>";
                $msg .= "<td align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:10px;\">$funcionario[nome_funcao]</td>";
                $msg .= "<td align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:10px;\">$exl</td>";
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
         <font face="Verdana, Arial, Helvetica, sans-serif">
        <b> Telefone: +55 (21) 3014 4304 &nbsp; Fax: Ramal 7<br>
         Nextel: +55 (21) 7844 9394 - Id 55*23*31368<P>
         <font face="Verdana, Arial, Helvetica, sans-serif" size=2>
         faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com<br>
         www.sesmt-rio.com / www.shoppingsesmt.com</b>
         </td>
         <td width=130><font face="Verdana, Arial, Helvetica, sans-serif"><b>
         Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>coma gente!</b>
         </td>
      </tr>
      </table>

    </body>
    </html>   ';

    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> \n";

    $mail_list = explode(";", $cliente_info['email']);
    $ok = "";
    $er = "";

    for($x=0;$x<count($mail_list);$x++){
        if($mail_list[$x] != ""){
           mail($mail_list[$x], "Resumo de Fatura Nº: ".STR_PAD($fatura, 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao'])), $msg, $headers);
           //mail("celso.leo@gmail.com", "Resumo de Fatura Nº: ".STR_PAD($fatura, 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao'])), $msg, $headers);
                 $sql = "UPDATE site_fatura_info SET email_enviado = 1, data_envio_email = '".date("Y-m-d")."' WHERE cod_fatura = '{$fatura}'";
                 pg_query($sql);
        }
    }
    //$sql = "UPDATE site_fatura_info SET planilha_checked = 1 WHERE cod_fatura = '{$_GET['fatura']}'";
    //pg_query($sql);
}
?>
