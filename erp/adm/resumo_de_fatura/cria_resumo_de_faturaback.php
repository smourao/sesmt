<?php
session_start();
include "config/connect.php";
$orc = $_GET['orcamento'];

function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", //Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);

  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>3){
        $at[$x] = ucwords($at[$x]);
    }

    $temp .= $at[$x]." ";
}
return $temp;
}

if($_GET['del']){
   if($_GET['fatura'] && $_GET['cod_cliente']){
      $sql = "DELETE FROM site_fatura_produto WHERE cod_fatura = {$_GET['fatura']}
      AND cod_cliente = {$_GET['cod_cliente']}";

      if(pg_query($sql)){
          //none
      }else{
          echo "<script>alert('Erro ao excluir os items.');</script>";
      }

      $sql = "DELETE FROM site_fatura_info WHERE cod_fatura = {$_GET['fatura']}
      AND cod_cliente = {$_GET['cod_cliente']}";

      if(pg_query($sql)){
          header("Location: resumo_de_fatura_index.php");
      }else{
          echo "<script>alert('Erro ao excluir Resumo de Fatura.');</script>";
      }
   }
}


if($_GET['act']=="preview"){
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


echo '
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
            <span id=sesmt><font size="6" face="Verdana, Arial, Helvetica, sans-serif">SESMT</span><span style="position: relative;top:-15px;"><sup><font size=2>®</font></sup></font></span>&nbsp;&nbsp;
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
      
      echo STR_PAD($_GET['fatura'], 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao']));

      echo'</font>&nbsp;</strong></td>
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
            echo "CNPJ";
        }else{
            echo "CPF";
        }
        echo ': </font></strong>'.$cliente_info['cnpj'].'</font></div></td>
      </tr>
      ';
      if($cliente_info[telefone]){
          echo '<tr>
            <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="2"><strong>
            <font face="Verdana, Arial, Helvetica, sans-serif">
            Telefone: </font></strong>'.$cliente_info['telefone'].'</font></div></td>
          </tr>
          ';
      }
      if($cliente_info[nextel_id_contato_dir]){
          echo '<tr>
            <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="2"><strong>
            <font face="Verdana, Arial, Helvetica, sans-serif">
            Nextel Id: </font></strong>'.$cliente_info['nextel_id_contato_dir'];
           /* if($cliente_info[nextel_id_contato_dir]){
                echo ' Id:'.$cliente_info['nextel_id_contato_dir'];
            }*/
            echo '</font></div></td>
          </tr>
          ';
      }
      echo '
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
      echo '<tr>
        <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong>
        Per&iacute;odo de Cobran&ccedil;a:</strong> ';
        $emifor = explode("/", date("d/m/Y", strtotime($fatura_info['data_emissao'])));
        if($fatura_info['data_emissao'])echo date("d/m/Y", mktime(0,0,0,$emifor[1]-1, $emifor[0], $emifor[2]))." à ".date("d/m/Y", strtotime($fatura_info['data_emissao']));
        echo '</font></div></td>
      </tr>
      ';
      }
      echo '<tr>
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

    $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$_GET['fatura']}' ORDER BY valor DESC";
    $result = pg_query($sql);
    $prod = pg_fetch_all($result);

    for($x=0;$x<pg_num_rows($result);$x++){
    echo'
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

    echo'
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
            $msg .= "<td align=center bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">".($i+1)."</td>";
            $msg .= "<td align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:12px;\">&nbsp;$funcionario[nome_func]</td>";
            $msg .= "<td align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:10px;\">$funcionario[nome_funcao]</td>";
            $msg .= "<td align=left bgcolor='$bg' class='fontepreta12 style2'  style=\"font-size:10px;\">$exl</td>";
            $msg .= "</tr>";
        }
   }
   $msg .= "</table>";
}
  
  echo $msg;
  
// PROPAGANDA AQUI
$sql = "SELECT * FROM site_fatura_propaganda";
$buffer = pg_fetch_array(pg_query($sql));

echo $buffer['texto'];

  echo '</b>
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
}

//***********************************************************************************************
//                                 ***  MAIL  ***
//***********************************************************************************************
if($_GET['mail']){
include "../../sessao.php";
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
      $parc = explode("/", $fatura_info[parcela]);
      //$msg.= "n_parc - ".$parc[0];
      if(!$fatura_info[tipo_fatura] && $parc[0] > 1){
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

    $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$_GET['fatura']}'";
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

$mail_list = explode(";", $_GET['mail']);
$ok = "";
$er = "";

for($x=0;$x<count($mail_list);$x++){
if($mail_list[$x] != ""){
   if(mail($mail_list[$x], "Resumo de Fatura Nº: ".STR_PAD($_GET['fatura'], 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao'])), $msg, $headers)){
      //echo "<script>alert('E-mail enviado para: ".$_GET[mail]."');</script>";
      $ok .= ", ".$mail_list[$x];
         $sql = "UPDATE site_fatura_info SET email_enviado = 1, data_envio_email = '".date("Y-m-d")."' WHERE cod_fatura = '{$_GET['fatura']}'";
         pg_query($sql);
   }else{
      //echo "<script>alert('Falha ao enviar email para: ".$_GET[mail]."');</script>";
      $er .= ", ".$mail_list[$x];
   }
}
}
echo "<script>alert('E-Mails enviado para".$ok."');</script>";
   $sql = "UPDATE site_fatura_info SET planilha_checked = 1 WHERE cod_fatura = '{$_GET['fatura']}'";
   pg_query($sql);
if($er != ""){
   echo "<script>alert('Erro ao enviar E-mail para".$er."');</script>";
}
   //header("Location: ?act=edit&cod_cliente={$_GET['cod_cliente']}&cod_filial={$_GET['cod_filial']}&orcamento={$_GET['orcamento']}");
   //echo "Enviar email com orçamento para: ".$cd[0]['email'];
}
//***********************************************************************************************
// --> NEW
//***********************************************************************************************
if($_GET['act'] == "new"){
include "../../sessao.php";
   //CHECA MAX ID
   $sql = "SELECT MAX(cod_fatura) as cod_fatura FROM site_fatura_info";
   $r = pg_query($sql);
   $max = pg_fetch_array($r);

		$row_cod[cod_fatura] = $max[cod_fatura]+1;
  //accert - número de fatura inicial
  if($row_cod[cod_fatura] < 2553){$row_cod[cod_fatura] = 2553;}

   $faturas = explode("/", $_GET['parcelas']);
   $z = ($faturas[1] - $faturas[0]);
   
   if(isset($_GET[mes])){
      $mes = $_GET[mes];
   }else{
      $mes = date("m");
   }
   if(isset($_GET[ano])){
      $ano = $_GET[ano];
   }else{
      $ano = date("Y");
   }
   //$mt = date("m", mktime(0,0,0,$mes+$x,date("d"),$ano));
   if(date("d") > 27){
      $dia = 27;
   }else{
      $dia = date("d");
   }
   
   //valida dados como numerico e maior que zero
   if(is_numeric($z) && $z >= 0){
       //verifica se eh parceria ou não para busca de dados
       if($_GET[pc]){
           $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$_GET['cod_cliente']} AND filial_id={$_GET['cod_filial']} AND contratante = 1";
       }else{
           $sql = "SELECT * FROM cliente WHERE cliente_id = {$_GET['cod_cliente']} AND filial_id={$_GET['cod_filial']}";
       }
      $rz = pg_query($sql);
      $dt = pg_fetch_array($rz);

      for($x=0;$x<=$z;$x++){
         $sql = "INSERT INTO site_fatura_info
         (cod_fatura, cod_cliente, cod_filial, data_criacao, parcela, pc)
         VALUES
         ('".($row_cod[cod_fatura]+$x)."','".$_GET['cod_cliente']."','{$_GET['cod_filial']}',
         '".date("Y-m-d", mktime(0,0,0,$mes+$x,$dia,$ano))."',
         '".($faturas[0]+$x)."/{$faturas[1]}', $_GET[pc])";
         $result = pg_query($sql);
         
         //INSERT ENCARGOS BANCÁRIOS NO VALOR DE 4,00 COM N. CONTRATO
         $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
         parcelas, valor) VALUES
         ('".($row_cod[cod_fatura]+$x)."', '{$_GET['cod_cliente']}','{$_GET['cod_filial']}',
         'Taxa de cobrança de encargo bancário conforme, Cláusula: 3 (p) vigente no contrato de numero: ".$dt[ano_contrato].".".STR_PAD($_GET[cod_cliente],3, "0", STR_PAD_LEFT)."',
         1, '1/01', '4.00')";
         //1, '".($faturas[0]+$x)."/".STR_PAD($faturas[1], 2, "0", STR_PAD_LEFT)."', '4.00')";
         pg_query($sql);
         
         //INSERT TAXA DE CORRESPONDÊNCIA NO VALOR DE 6,50 COM N. CONTRATO
         $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
         parcelas, valor) VALUES
         ('".($row_cod[cod_fatura]+$x)."', '{$_GET['cod_cliente']}','{$_GET['cod_filial']}',
         'Taxa correspondente a envio de correspondência, Conforme cláusula 3.1(p) do contrato de número: ".$dt[ano_contrato].".".STR_PAD($_GET[cod_cliente],3, "0", STR_PAD_LEFT)."',
         1, '1/01', '6.50')";
         //1, '".($faturas[0]+$x)."/".STR_PAD($faturas[1], 2, "0", STR_PAD_LEFT)."', '6.50')";
         pg_query($sql);
         
         //SE HOUVER, PARCEIROS CADASTRADOS
         if($_GET[pc]){
             $sql = "SELECT * FROM cliente_pc WHERE cnpj_contratante = '$dt[cnpj]'";
             $result = pg_query($sql);
             $aditivos = pg_fetch_all($result);
             for($i=0;$i<pg_num_rows($result);$i++){
                 $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
                 parcelas, valor) VALUES
                 ('".($row_cod[cod_fatura]+$x)."', '{$_GET['cod_cliente']}','{$_GET['cod_filial']}',
                 'Prestação de serviço em Segurança e Medicina Ocupacional - {$aditivos[$i][razao_social]} (Cobrança Mensal), conforme esta vigente na cláusula 4.1 do contrato de numero: ".$dt[ano_contrato].".".STR_PAD($_GET[cod_cliente],3, "0", STR_PAD_LEFT)."',
                 '{$aditivos[$i][numero_funcionarios]}', '".($faturas[0]+$x)."/".STR_PAD($faturas[1], 2, "0", STR_PAD_LEFT)."', '3.00')";
                 pg_query($sql);
             }
         }
      }
   }else{
         //SE NÃO FOR ADICIONADO VALOR PARA NUMERO DE PARCELAS
         $sql = "INSERT INTO site_fatura_info
         (cod_fatura, cod_cliente, cod_filial, data_criacao, parcela, pc)
         VALUES
         ('".$row_cod[cod_fatura]."','".$_GET['cod_cliente']."','{$_GET['cod_filial']}',
         '".date("Y-m-d", mktime(0,0,0,$mes+$x,$dia,$ano))."', '1/1', $_GET[pc])";
         $result = pg_query($sql);
         
         //INSERT ENCARGOS BANCÁRIOS NO VALOR DE 4,00 COM N. CONTRATO
         $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
         parcelas, valor) VALUES
         ('".($row_cod[cod_fatura]+$x)."', '{$_GET['cod_cliente']}','{$_GET['cod_filial']}',
         'Taxa de cobrança de encargo bancário conforme, Cláusula: 3 (p) vigente no contrato de numero: ".$dt[ano_contrato].".".STR_PAD($_GET[cod_cliente],3, "0", STR_PAD_LEFT)."',
         1, '1/01', '4.00')";
         //1, '".($faturas[0]+$x)."/".STR_PAD($faturas[1], 2, "0", STR_PAD_LEFT)."', '4.00')";
         pg_query($sql);

         //INSERT TAXA DE CORRESPONDÊNCIA NO VALOR DE 6,50 COM N. CONTRATO
         $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
         parcelas, valor) VALUES
         ('".($row_cod[cod_fatura]+$x)."', '{$_GET['cod_cliente']}','{$_GET['cod_filial']}',
         'Taxa correspondente a envio de correspondência, Conforme cláusula 3.1(p) do contrato de número: ".$dt[ano_contrato].".".STR_PAD($_GET[cod_cliente],3, "0", STR_PAD_LEFT)."',
         1, '1/01', '6.50')";
         //1, '".($faturas[0]+$x)."/".STR_PAD($faturas[1], 2, "0", STR_PAD_LEFT)."', '6.50')";
         pg_query($sql);
         
         //SE HOUVER, PARCEIROS CADASTRADOS
         if($_GET[pc]){
             $sql = "SELECT * FROM cliente_pc WHERE cnpj_contratante = '$dt[cnpj]'";
             $result = pg_query($sql);
             $aditivos = pg_fetch_all($result);
             for($i=0;$i<pg_num_rows($result);$i++){
                 $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
                 parcelas, valor) VALUES
                 ('".($row_cod[cod_fatura]+$x)."', '{$_GET['cod_cliente']}','{$_GET['cod_filial']}',
                 'Prestação de serviço em Segurança e Medicina Ocupacional - {$aditivos[$i][razao_social]} (Cobrança Mensal), conforme esta vigente na cláusula 4.1 do contrato de numero: ".$dt[ano_contrato].".".STR_PAD($_GET[cod_cliente],3, "0", STR_PAD_LEFT)."',
                 '{$aditivos[$i][numero_funcionarios]}', '".($faturas[0]+$x)."/".STR_PAD($faturas[1], 2, "0", STR_PAD_LEFT)."', '3.00')";
                 pg_query($sql);
             }
         }
   }
   
      if($result){
         header("Location: ?act=edit&cod_cliente={$_GET['cod_cliente']}&cod_filial={$_GET['cod_filial']}&fatura=".$row_cod[cod_fatura]."&pc=".$_GET[pc]);
      }else{
         echo "<script>alert('Erro ao adicionar novo resumo de fatura! Por favor, tente novamente.');</script>";
      }
}
if($_GET['act'] != "preview"){
?>
<html>
<head>
<title>Resumo de Fatura</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="res_fat.js"></script>
<script language="javascript" src="scripts.js"></script>
<style type="text/css" title="mystyles" media="all">
<!--
loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

loading_done{
position: relative;
display: none;
}

.dia {font-family: helvetica, arial; font-size: 8pt; color: #FFFFFF}
.data {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970}
.data:hover{font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#000000; font-weight:bold;}
.mes {font-family: helvetica, arial; font-size: 8pt}
.Cabecalho_Calendario {font-family: helvetica, arial; font-size: 10pt; color: #000000; text-decoration:none; font-weight:bold}
.Cabecalho_Calendario:hover{font-family: helvetica, arial; font-size: 10pt; color: #000000; text-decoration:none; font-weight:bold}
.mes {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970}
.mes:hover {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970; font-weight:bold}

-->
</style>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
      <input type=hidden name=fatid id=fatid value="<?PHP echo $_GET['fatura'];?>">
      <input type=hidden name=cod_cliente id=cod_cliente value="<?PHP echo $_GET['cod_cliente'];?>">
      <input type=hidden name=cod_filial id=cod_filial value="<?PHP echo $_GET['cod_filial'];?>">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE CRIAÇÃO DE RESUMO DE FATURA<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="location.href='resumo_de_fatura_index.php'" value="Voltar" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="5" class="linhatopodiresq">

<?PHP
if($_GET['act'] == "edit"){
include "../../sessao.php";

if(!isset($_SESSION[mcrf])){
    $_SESSION[mcrf] = date("m");
}
if(!isset($_SESSION[ycrf])){
    $_SESSION[ycrf] = date("Y");
}

if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[mcrf] = $mes;
}else{
    if(isset($_SESSION[mcrf])){
        $mes = $_SESSION[mcrf];
    }else{
        $mes = date("m");
    }
}


if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[ycrf] = $ano;
}else{
    if(isset($_SESSION[ycrf])){
        $ano = $_SESSION[ycrf];
    }else{
        $ano = date("Y");
    }
}

//echo date("d/m/Y", mktime(0,0,0,date("m"), date("d"), date("Y")));

echo "
<script>
//alert('');
//CHAMAR FUNÇÃO PRA ATUALIZAR LISTAS
update_fatura();
</script>
";
   if($_GET[pc]){
       $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$_GET['cod_cliente']} AND filial_id={$_GET['cod_filial']} AND contratante = 1";
   }else{
       $sql = "SELECT * FROM cliente WHERE cliente_id = {$_GET['cod_cliente']} AND filial_id={$_GET['cod_filial']}";
   }
   $rz = pg_query($sql);
   $dt = pg_fetch_array($rz);

   $sql = "SELECT * FROM site_fatura_info WHERE cod_fatura = '{$_GET['fatura']}'";
   $reza = pg_query($sql);
   $fatura_info = pg_fetch_array($reza);
?>
<br>
<center>
<input type=button value="Visualizar" onclick="location.href='cria_resumo_de_fatura.php?act=preview&cod_cliente=<?php echo $_GET['cod_cliente']?>&cod_filial=<?php echo $_GET['cod_filial']?>&fatura=<?php echo $_GET['fatura']?>&pc=<?php echo $_GET['pc'];?>';">
<input type=button value="Enviar E-mail" onclick="if(mail = prompt('Digite o E-Mail que receberá o resumo da fatura:','<?PHP echo $dt['email'];?>')){location.href='cria_resumo_de_fatura.php?act=preview&mail='+mail+'&cod_cliente=<?php echo $_GET['cod_cliente']?>&cod_filial=<?php echo $_GET['cod_filial']?>&fatura=<?php echo $_GET['fatura']?>&pc=<?php echo $_GET['pc'];?>'};">
<input type=button value="Excluir Resumo de Fatura" onclick="if(confirm('Tem certeza que deseja excluir este resumo de fatura?')){location.href='cria_resumo_de_fatura.php?del=yes&cod_cliente=<?PHP echo $_GET['cod_cliente'];?>&fatura=<?PHP echo $_GET['fatura'];?>&pc=<?php echo $_GET['pc'];?>';};">
<input type=button value="Novo Resumo de Fatura" onclick="if(document.getElementById('newone').style.display == 'none'){document.getElementById('newone').style.display='block';}else{document.getElementById('newone').style.display='none';}">
</center>
<br>
<div style="position:relative;display:none;" id=newone align=center>
      <table width="500" border="0" align="center">
        <tr>
         <form action="javascript:select_cliente('<?php echo $mes;?>','<?php echo $ano;?>');">
          <td width="25%" align=right><strong>Razão Social:</strong></td>
          <td width="50%" align=center><input name="cliente" id="cliente" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%" align=left><input type="button" onclick="select_cliente('<?php echo $mes;?>','<?php echo $ano;?>');" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
          </form>
        </tr>
      </table>

     <!-- CONTEÚDO -->
     <table width="500" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
</div>
<br>
<form name=frm id=frm>
<span class=fontebranca12><b>Detalhes do Resumo da Fatura:</b></span><br>
<table border=1 width=100%>
<tr>
   <td width=180 class=fontebranca12><b>Código da Fatura:</b></td>
   <td  class=fontebranca12><?PHP echo STR_PAD($_GET['fatura'], 4, "0", STR_PAD_LEFT);?></td>
</tr>
<tr>
   <td width=180 class=fontebranca12><b>Nº Contrato:</b></td>
   <td  class=fontebranca12><?PHP echo $dt['ano_contrato'];?></td>
</tr>
<tr>
   <td width=180 class=fontebranca12><b>Código do Cliente:</b></td>
   <td  class=fontebranca12><?PHP echo STR_PAD($_GET['cod_cliente'], 4, "0", STR_PAD_LEFT);?></td>
</tr>
<tr>
   <td width=180 class=fontebranca12><b>Cliente:</b></td>
   <td  class=fontebranca12>
   <?PHP
   echo $dt['razao_social'];
   ?></td>
</tr>
<tr>
   <td width=180 class=fontebranca12><b>Tipo de Contrato:</b></td>
   <td  class=fontebranca12>
   <?PHP
       echo "<select name=contrato id=contrato>";
       echo "<option  value='Fechado'"; print $fatura_info['tipo_contrato'] == "Fechado" ? "selected" : ""; echo " >Fechado</option>";
       echo "<option  value='Aberto'"; print $fatura_info['tipo_contrato'] == "Aberto" ? "selected" : ""; echo " >Aberto</option>";
       echo "<option  value='Misto'"; print $fatura_info['tipo_contrato'] == "Misto" ? "selected" : ""; echo " >Misto</option>";
       echo "<option  value='Específico'"; print $fatura_info['tipo_contrato'] == "Específico" ? "selected" : ""; echo " >Específico</option>";
       echo "</select>";
   ?>
   </td>
</tr>

<tr>
   <td width=180 class=fontebranca12><b>Forma de Pagamento:</b></td>
   <td  class=fontebranca12>
   <?PHP
       echo "<select name=forma_pagamento id=forma_pagamento>";
       /*
       echo "<option  value='Fechado'"; print $fatura_info['tipo_contrato'] == "Fechado" ? "selected" : ""; echo " >Fechado</option>";
       echo "<option  value='Aberto'"; print $fatura_info['tipo_contrato'] == "Aberto" ? "selected" : ""; echo " >Aberto</option>";
       echo "<option  value='Misto'"; print $fatura_info['tipo_contrato'] == "Misto" ? "selected" : ""; echo " >Misto</option>";
       echo "<option  value='Específico'"; print $fatura_info['tipo_contrato'] == "Específico" ? "selected" : ""; echo " >Específico</option>";
       */
       echo "<option value=\"Boleto\" ";print $fatura_info['tipo_pagamento'] == "Boleto" ? " selected ": ""; echo" >Boleto</option>";
       echo "<option value=\"Dinheiro\" "; print $fatura_info['tipo_pagamento'] == "Dinheiro" ? " selected ": ""; echo" >Dinheiro</option>";
       echo "<option value=\"Cheque\" ";print $fatura_info['tipo_pagamento'] == "Cheque" ? " selected ": ""; echo" >Cheque</option>";
       echo "<option value=\"Cheque pré-datado\"  ";print $fatura_info['tipo_pagamento'] == "Cheque pré-datado" ? " selected ": ""; echo" >Cheque pré-datado</option>";
       echo "<option value=\"Cartão de crédito\"  ";print $fatura_info['tipo_pagamento'] == "Cartão de crédito" ? " selected ": ""; echo" >Cartão de crédito</option>";
       echo "<option value=\"Débito automático\"  ";print $fatura_info['tipo_pagamento'] == "Débito automático" ? " selected ": ""; echo" >Débito automático</option>";
       echo "<option value=\"Recíbo\"  ";print $fatura_info['tipo_pagamento'] == "Recíbo" ? " selected ": ""; echo" >Recíbo</option>";
       echo "<option value=\"Duplicata\"  ";print $fatura_info['tipo_pagamento'] == "Duplicata" ? " selected ": ""; echo" >Duplicata</option>";
       echo "<option value=\"Nota de Crédito\"  ";print $fatura_info['tipo_pagamento'] == "Nota de Crédito" ? " selected ": ""; echo" >Nota de Crédito</option>";

       echo "</select>";
   ?>
   </td>
</tr>

<tr>
   <td width=180 class=fontebranca12><b>Data de Emissão:</b></td>
   <td  class=fontebranca12>
   <input type=text size=10 maxlength=10 name=emissao id=emissao value="<?PHP if($fatura_info['data_emissao'])echo date("d/m/Y", strtotime($fatura_info['data_emissao']));?>" onkeypress="formataDataDigitada(this);" Onclick="javascript:popdate('document.frm.emissao','pop2','150',document.frm.emissao.value);return false;">
   <input type=image src='calendario.gif' width=15 height=15 Onclick="javascript:popdate('document.frm.emissao','pop2','150',document.frm.emissao.value); return false;">
   <span id="pop2" style="position:absolute"></span>
   </td>
</tr>
<tr>
   <td width=180 class=fontebranca12><b>Data de Vencimento:</b></td>
   <td  class=fontebranca12>
   <input type=text size=10 maxlength=10 name="vencimento" id="vencimento" value="<?PHP if($fatura_info['data_vencimento'])echo date("d/m/Y", strtotime($fatura_info['data_vencimento']));?>" onkeypress="formataDataDigitada(this);" Onclick="javascript:popdate('document.frm.vencimento','pop1','150',document.frm.vencimento.value);return false;">
   <input type=image src='calendario.gif' width=15 height=15 Onclick="javascript:popdate('document.frm.vencimento','pop1','150',document.frm.vencimento.value); return false;">
   <span id="pop1" style="position:absolute"></span>
   </td>
</tr>
<tr>
   <td width=180 class=fontebranca12><b>Período de Cobrança:</b></td>
   <td  class=fontebranca12>
   <span id=periodo_de_cobranca>
   <?PHP
      $emifor = explode("/", date("d/m/Y", strtotime($fatura_info['data_emissao'])));
      if($fatura_info['data_emissao'])echo date("d/m/Y", mktime(0,0,0,$emifor[1]-1, $emifor[0], $emifor[2]))." à ".date("d/m/Y", strtotime($fatura_info['data_emissao']));
   ?>
   </span>&nbsp;
   </td>
</tr>
<tr>
   <td colspan=2 class=fontebranca12 align=center>
   <input type=button value="Atualizar Dados" onclick="update_data('<?PHP echo $_GET['fatura'];?>');">
   </td>
</tr>
</table>

<p>
<span class=fontebranca12><b>Detalhes da descrição do serviço/produto:</b></span><br>
<Table width=100% border=1 cellspacing=5 cellpading=2>
<tr>
   <td width=50  class=fontebranca12><b>Descrição:</b></td>
   <td>
<?PHP
$sql = "SELECT * FROM desc_fatura ORDER BY descricao";
$rdf = pg_query($sql);
$desc = pg_fetch_all($rdf);

echo "<select name=desc id=desc style=\"width:100%;\" onchange=\"document.getElementById('desc_preview').value=this.value;\">";
echo "<option value=''>Selecione uma descrição</option>";
for($x=0;$x<pg_num_rows($rdf);$x++){
   $contract = str_replace("/", ".", $dt['ano_contrato']).".".STR_PAD($_GET['cod_cliente'], 4, "0", STR_PAD_LEFT);
   $des = str_replace("%contract_number%", $contract, $desc[$x][descricao]);
   echo "<option value='{$des}'>{$des}</option>";
}
echo "</select>";
?>
   </td>
</tr>
<tr>
   <td width=50 class=fontebranca12><b>Preview:</b></td>
   <td><textarea id=desc_preview name=desc_preview style="width: 100%;" rows=4></textarea></td>
</tr>
<tr>
   <td  width=50 class=fontebranca12><b>Quantidade:</b></td>
   <td><input type=text name=quantidade id=quantidade></td>
</tr>
<tr>
   <td  width=50 class=fontebranca12><b>Parcelas:</b></td>
   <td><input type=text name=parcelas id=parcelas value="<?php echo $fatura_info[parcela];?>"></td>
</tr>
<tr>
   <td  width=50 class=fontebranca12><b>Valor:</b></td>
   <td  class=fontebranca12><input type=text name=valor id=valor  onkeypress="return FormataReais(this, '.', ',', event);">
   <input type=checkbox name=desconto id=desconto> Desconto <font size=1>(se selecionado, valor inserido será negativo)</font>
   </td>
</tr>
<tr>
<td colspan=2 align=center>
   <input type=button name=send value="Inserir Serviço/Produto" onclick="add_fatura_produto('<?PHP echo $_GET['fatura'];?>');">
</td>
</tr>
</table>
<p>
<center>
<p>
<Table width=100% border=0 cellspacing=2 cellpading=5 id=maint>
<tr>
   <td valign=top id=ls>
   <!-- LEFT -->
      <table border=0 width=100% id=dataz>
         <tr>
            <td align=center style="position:static;">
          <!--  <input type=button value="Atualizar" onclick="update_orcamento();" class="button">-->
               <div id="orc_loading" class="loading" height=0>
                  <center><font size=1>
                  <!-- Atualizando dados, aguarde... -->
                  <img src="loading.gif" width=25 height=25 border=0>
                  </font></center>
               </div>
               <div id="dados">
               </div>
            </td>
         </tr>
      </table>
   </td>

     <!-- CONTEÚDO -->
     <table width="500" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
     <p><center>
        <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='resumo_de_fatura_index.php'" value="Voltar" style="width:100;">
     </center><p>
</form>
<?PHP
}
}
?>
	 </td>
    </tr>
</table>
</body>
</html>
