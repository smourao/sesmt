<?php
session_start();
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../../sessao.php";
include "config/connect.php";

$meumes = date("m");

if($meumes<=1){
    $meumes = 12;
}else{
    $meumes -= 1;
}


if(!isset($_SESSION[mp])){
    $_SESSION[mp] = $meumes;//date("m");
}

if(!isset($_SESSION[yp])){
    if($meumes != 12){
       $_SESSION[yp] = date("Y");
    }else{
       $_SESSION[yp] = date("Y")-1;
    }
}

if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[mp] = $mes;
}else{
    if(isset($_SESSION[mp])){
        $mes = $_SESSION[mp];
    }else{
        $mes = $meumes;//date("m");
    }
}

if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[yp] = $ano;
}else{
    if(isset($_SESSION[yp])){
        $ano = $_SESSION[yp];
    }else{
        $ano = date("Y");
    }
}
$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

    $query_cli = "SELECT fi.*, c.razao_social FROM site_fatura_info fi, cliente c
    WHERE fi.cod_cliente = c.cliente_id
    AND
    fi.cod_filial = c.filial_id
    AND
    EXTRACT(month FROM fi.data_emissao) = {$mes}
    AND
    EXTRACT(year FROM fi.data_emissao) = {$ano}
    AND
    fi.data_vencimento is not null
	ORDER BY fi.data_vencimento ASC";
    $result_cli = pg_query($query_cli);
	
function dateDiff($sDataInicial, $sDataFinal)
{
 $sDataI = explode("-", $sDataInicial);
 $sDataF = explode("-", $sDataFinal);

 $nDataInicial = mktime(0, 0, 0, $sDataI[1], $sDataI[0], $sDataI[2]);
 $nDataFinal = mktime(0, 0, 0, $sDataF[1], $sDataF[0], $sDataF[2]);

 return ($nDataInicial > $nDataFinal) ?
    floor(($nDataFinal - $nDataInicial)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
   //floor(($nDataInicial - $nDataFinal)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
}
?>
<html>
<head>
<title>Planilha Fatura de Serviço</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="res_fat.js"></script>
<script language="javascript" src="scripts.js"></script>
<script language="javascript" src="js.js"></script>
<script language="javascript" src="../../screen.js"></script>
<style>
#loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

#loading_done{
position: relative;
display: none;
}
.trans{
filter:alpha(opacity=95);
-moz-opacity:0.95;
-khtml-opacity: 0.95;
opacity: 0.95;
}
.relatorio {
position: absolute;
border: 3px solid black;
background: #097b42;
color: #FFFFFF;
width: 300px;
height: 400px;
}
</style>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<div id="test" class="relatorio trans" style="display:none;">
   <!-- ### DIV - TITULO DA JANELA -->
   <div id=titulo name=titulo style="background: #000000;">
      <table width=100%>
      <tr>
         <td class=fontebranca><b>Simulador de Juros</b></td>
         <td align=right width=40 valign=center>
         <img src="../../images/fechar.jpg" style="cursor:pointer;" onClick="document.getElementById('test').style.display='none';">
         </td>
      </tr>
      </table>
   </div>
   <p>
   <center><span id=mname name=mname></span></center>
   <p>
   <table width=100% bordrt=1 cellspacing=0 cellpadding=0>
   <tr>
      <td align=right><font size=1><b>Data de Pagamento:</b></font></td><td><input type=text id=dtv name=dtv length=10 maxlength=10></td>
   </tr>
      <tr>
      <td align=right><font size=1><b>Data de Vencimento:</b></font></td><td><input type=text id=dto name=dto length=10 maxlength=10 disabled></td>
   </tr>
   <tr>
      <td align=right><font size=1><b>Valor:</b></font></td><td><input type=text length=10 name=valb id=valb disabled></td>
   </tr>
   </table>
   <p>
   <center><input type='button' value='Calcular' onclick='SimJuros();'></center>
   <input type=hidden name=tmpd id=tmpd>
   <input type=hidden name=tmpv id=tmpv>
   <p>
   <div id='cmr'></div>
</div>

<script>
window.onscroll = function(){adjust()};
adjust();
function adjust(){
var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 standards compliant mode
    scrOfY = document.documentElement.scrollTop;
    scrOfX = document.documentElement.scrollLeft;
  }

   div = document.getElementById('test');
   //document.getElementById("conteudo").style.display = "block";
   //alert(window.pageXOffset);
   if(navigator.appName == 'Microsoft Internet Explorer')
   {
      div.style.left = ((getWidth()/2) - 150)+"px";
      div.style.top = scrOfY+"px";
   }else{
      div.style.left = ((getWidth()/2) - 150)+"px";
      div.style.top = scrOfY+"px";
      
   }
}

function number_format( number, decimals, dec_point, thousands_sep ) {
    // %        nota 1: Para 1000.55 retorna com precisão 1 no FF/Opera é 1,000.5, mas no IE é 1,000.6
    // *     exemplo 1: number_format(1234.56);
    // *     retorno 1: '1,235'
    // *     exemplo 2: number_format(1234.56, 2, ',', ' ');
    // *     retorno 2: '1 234,56'
    // *     exemplo 3: number_format(1234.5678, 2, '.', '');
    // *     retorno 3: '1234.57'
    // *     exemplo 4: number_format(67, 2, ',', '.');
    // *     retorno 4: '67,00'
    // *     exemplo 5: number_format(1000);
    // *     retorno 5: '1,000'
    // *     exemplo 6: number_format(67.311, 2);
    // *     retorno 6: '67.31'

    var n = number, prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? '.' : dec_point;

    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = Math.abs(n).toFixed(prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');

        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    return s;
}

function calcme(val, dt, name){
   document.getElementById('dtv').value = dt;
   document.getElementById('dto').value = dt;
   document.getElementById('valb').value = number_format(val, 2, ',', '.');
      document.getElementById('tmpd').value = dt;
   document.getElementById('tmpv').value = number_format(val, 2, ',', '.');
   document.getElementById('mname').innerHTML = "<b>"+name+"</b>";
   document.getElementById('cmr').innerHTML = "";
   document.getElementById('test').style.display = 'block';
   
}

function SimJuros(){
   var url = "sim_juros.php?valor="+document.getElementById('valb').value;
   url = url + "&data="+document.getElementById('dtv').value;
   url = url + "&data_o="+document.getElementById('tmpd').value;
   url = url + "&valor_o="+document.getElementById('tmpv').value;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = SimJuros_reply;
   http.send(null);
}

function SimJuros_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    if(data[0] <0){
       document.getElementById('cmr').innerHTML = "<center>Data de vencimento inválida!</center>";
    }else{
       document.getElementById('cmr').innerHTML = "<b>&nbsp;Dias após o vencimento:</b> "+data[0]+"<p>&nbsp;<b>Valor Ajustado:</b> R$ "+data[1];
    }
}else{
 if (http.readyState==1){
        document.getElementById('cmr').innerHTML = "<center>Atualizando...</center>";
    }
 }
}
</script>

<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="730" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="12" class="linhatopodiresq" bgcolor="#009966"><br>PLANILHA FATURA DE SERVIÇO<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="12">
			<br>&nbsp;
               <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='../index.php#financeiro';" value="Sair" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="12" class="linhatopodiresq">
	  <br>
     <!-- CONTEÚDO -->
     <table width="730" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
	 </td>
    </tr>
  <tr>
    <th colspan="12" class="linhatopodiresq" bgcolor="#009966">
      <h3>Faturas Geradas</h3>
<?PHP
  if($mes >=12){
      $n_mes = 01;
      $n_ano = $ano+1;
      $p_mes = $mes-1;
      $p_ano = $ano;
  }elseif($mes <= 01){
     $n_mes = $mes+1;
     $n_ano = $ano;
     $p_mes = 12;
     $p_ano = $ano-1;
  }else{
      $n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
      $n_ano = $ano;
      $p_mes = STR_PAD($mes-1, 2, "0", STR_PAD_LEFT);
      $p_ano = $ano;
  }

   //echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font></center>";
   echo "<center><font size=2><a href=\"javascript:location.href='?m=$mes&y=".($ano-1)."'\" class=fontebranca12><<</a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>></a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?m=$mes&y=".($ano+1)."'\" class=fontebranca12>>></a></font></center>";
?>
<br>
<input name="btn_send_mail" type="button" id="btn_send_mail" onClick="if(confirm('Tem certeza que deseja enviar a fatura à todos os clientes abaixo?','')){location.href='?send_mail=1';}" value="Enviar fatura à todos">
<p>
    </th>
  </tr>
  <tr>
    <td width="3%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Parc.</strong></div></td>

    <td width="6%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Fatura</strong></div></td>
    
    <td width="3%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Boleto</strong></div></td>

    <td width="28%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Razão Social
	</strong></div></td>

    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Vencimento</strong></div></td>
<!--
    <td width="6%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Parcela</strong></div></td>
-->
    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Valor<BR>Cobrado</strong></div></td>
    
    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>3%<BR> Multa</strong></div></td>

    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>0,29%<br>Juros</strong></div></td>

    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Total</strong></div></td>
    
    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Novo Total</strong></div></td>
    
    <td width="6%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Enviado</strong></div></td>

    <td width="7%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Migrar</strong></div></td>
    
<!--
    <td width="7%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Pago</strong></div></td>
-->
  </tr>
<?php
$i = 1;
while($row=pg_fetch_array($result_cli)){
/**************************************************************************************************************/
// --> SEND MAIL TO ALL CUSTOMERS
/**************************************************************************************************************/
if(!$row['email_enviado'] && $_GET[send_mail]){
    if($data[pc]){
        $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']} AND contratante = 1";
    }else{
        $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']}";
    }
    $rz = pg_query($sql);
    $cliente_info = pg_fetch_array($rz);

    $sql = "SELECT * FROM site_fatura_info WHERE cod_fatura = '{$row[cod_fatura]}'";
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
                <td width="40%" valign="top" align="right">
                <font face="Verdana, Arial, Helvetica, sans-serif" size="3">
                <img src="../images/main-logo.png" width="240" height="65">
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

          $msg .= STR_PAD($row['cod_fatura'], 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao']));

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

        $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$row[cod_fatura]}'";
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
           f.cod_cliente = $row[cod_cliente] AND
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
         Nextel: +55 (21) 97003 1385 - Id 55*23*31641<P>
         <font face="Verdana, Arial, Helvetica, sans-serif" size=2>
         faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com<br>
         www.sesmt-rio.com</b>
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

    for($x=0;$x<count($mail_list);$x++){
        if($mail_list[$x] != ""){
           mail($mail_list[$x], "Resumo de Fatura Nº: ".STR_PAD($fatura_info[cod_fatura], 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao'])), $msg, $headers);
           //mail("celso.leo@gmail.com", $mail_list[$x]."Resumo de Fatura Nº: ".STR_PAD($fatura_info[cod_fatura], 5, "0", STR_PAD_LEFT)."/".date("y", strtotime($fatura_info['data_emissao'])), $msg, $headers);
                 $sql = "UPDATE site_fatura_info SET email_enviado = 1, planilha_checked = 1, data_envio_email = '".date("Y-m-d")."' WHERE cod_fatura = '{$fatura_info[cod_fatura]}'";
                 pg_query($sql);
                 $row[planilha_checked] = 1;
                 $row[email_enviado] = 1;
        }
    }
}//END IF -> NOT CHECKED
/**************************************************************************************************************/
  
  
  if($row[pc]){
      if($row['cod_filial']){
         $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']} AND contratante = 1";
      }else{
         $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$row['cod_cliente']} AND contratante = 1";
      }
  }else{
      if($row['cod_filial']){
         $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']}";
      }else{
         $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']}";
      }
  }

  $result = pg_query($sql);
  $cd = pg_fetch_array($result);

  $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$row['cod_fatura']}'";
  $rin = pg_query($sql);
  $items = pg_fetch_all($rin);
  
  $total=0;

  for($x=0;$x<pg_num_rows($rin);$x++){
     $total = $total + ($items[$x]['quantidade']*$items[$x]['valor']);
  }
  
  $multa = ($total * 3)/100;
  $juros = ($total * 0.29)/100;
  if($row['data_pagamento']){
     $data_pag = date("d-m-Y", strtotime($row['data_pagamento']));
  }else{
     $data_pag = date("d-m-Y");
  }
  //echo $data_pag;
  $dias_vencidos = dateDiff(date("d-m-Y", strtotime($row['data_vencimento'])), $data_pag);
  
  $sql = "SELECT * FROM site_fatura_info WHERE
    (
    EXTRACT(month FROM data_vencimento) <= {$mes}
    AND
    EXTRACT(year FROM data_vencimento) = {$ano}
    AND
    cod_cliente = {$row['cod_cliente']}
    AND
    migrado = 0
    )OR(
    EXTRACT(month FROM data_vencimento) >= 1
    AND
    EXTRACT(year FROM data_vencimento) < {$ano}
    AND
    cod_cliente = {$row['cod_cliente']}
    AND
    migrado = 0
    )
   ";
   $rv = pg_query($sql);
   $vencidos = pg_fetch_all($rv);
   $vv  = 0;  // valor vencido - todas as faturas
   $tdv = 0; // total de dias vencidos
   $tvj = 0; // valor total com somatorio de juros e dias
   $mv  = 0;  // Multas de valores vencidos
   $jv  = 0;  // Juros de valores vencidos
   $ad = array();
   
   //LOOP PARA CALCULO DE VALORES DOS PRODUTOS (TOTAL, MULTA E JUROS POR ORÇAMENTO)
   $nfaturasvencidas = 0;
   for($i=0;$i<pg_num_rows($rv);$i++){
      $tdv += dateDiff(date("d-m-Y", strtotime($vencidos[$i]['data_vencimento'])), date("d-m-Y"));
      $ad[] = $tdv;
      $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$vencidos[$i]['cod_fatura']}' ORDER BY valor";
      $pr = pg_query($sql);
      $pt = pg_fetch_all($pr);
      
      //só conta se tiver valor que não seja cobrança bancaria e envio
      if(pg_num_rows($pr)<=0 || (pg_num_rows($pr)==2 && in_array('4.00', $pt[0]) && in_array('6.50', $pt[1]))){
          //none
      }else{
          //soma valores de items na variavel $vv; obtem valor total da fatura.
          for($o=0;$o<pg_num_rows($pr);$o++){
             $vv += $pt[$o][valor] * $pt[$o][quantidade];
          }
          // valores de cada vencimento separados
          $mv   = ($vv * 3)/100;
          $jv   = ($vv * 0.29)/100;
          $mva  += $mv;
          $jva  += $jv;
          //soma valor da fatura + multa da fatura + juros da fatura * dias vencidos até a data atual
          $tvj += $vv + $mv + ($jv * $tdv);
          $nfaturasvencidas++;
      }

  //MARCA LINHA COM COR -- TAGGED
   }
  if($row['tagged'] == 1){
     $bcolor = '#D75757';
  }else{
     $bcolor = '#006633';
  }
  
  $sql = "SELECT valor FROM site_fatura_produto WHERE cod_fatura = '{$row[cod_fatura]}' ORDER BY valor";
  $rprod = pg_query($sql);
  $items = pg_fetch_all($rprod);

if(pg_num_rows($rprod)<=0 || (pg_num_rows($rprod)==2 && in_array('4.00', $items[0]) && in_array('6.50', $items[1]))){
      //break;
}else{
?>
  <tr>

   <td class="linhatopodiresq" bgcolor='<?PHP echo $bcolor;?>' id="col1<?php echo $row['cod_fatura'];?>" onClick="colorir(<?php echo $row['cod_fatura'];?>);">
	  <div align="center" class="fontebranca12" style="cursor:pointer;">
       &nbsp;<b><?php echo $row['parcela'];?></b>
	  </div>
	</td>

    <td class="linhatopodiresq" id="col2<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>">
       &nbsp;<?php echo str_pad($row['cod_fatura'], 3, "0", ST_PAD_LEFT);//"/".substr($row['data_criacao'], 0, 4);?></a>
	  </div>
	</td>
    
    <?php
	
	$codigocliente = $row[cod_cliente];
	$datavencimento = $row['data_vencimento'];
	
	
	$bgboletosql = "SELECT * FROM cliente_boleto WHERE cod_cliente = $codigocliente AND data_vencimento = '$datavencimento'";
	$bgboletoquery = pg_query($bgboletosql);
	$bgboletonum = pg_num_rows($bgboletoquery);
	
	
	
	
	if($bgboletonum >= 1){
		$bgboleto = '#2B8A30';
		
	}else{
		$bgboleto = $bcolor;	
	}
	
	
    $urlwww = $_SERVER['SERVER_NAME'];
						
	if($urlwww == 'www.sesmt-rio.com'){
    
	
	?>
	
    <td class="linhatopodiresq" bgcolor='<?PHP echo $bgboleto;?>' onClick="window.open('http://www.sesmt-rio.com/erp/2.0/modules/cad_cliente/cliente_boleto_search.php?cod_cliente=<?php echo $row['cod_cliente']?>&cod_fatura=<?php echo $row['cod_fatura']?>', 'search', 'status=no,scrollbars=yes,toolbar=no,left=900,height=400,width=500')">
      <div align="center" class="fontebranca12" style="cursor:pointer;">
       Enviar
	  </div>
	</td>
    
    
    <?php
	}else{
    	?>
        
		<td class="linhatopodiresq" bgcolor='<?PHP echo $bgboleto;?>' onClick="window.open('http://sesmt-rio.com/erp/2.0/modules/cad_cliente/cliente_boleto_search.php?cod_cliente=<?php echo $row['cod_cliente']?>&cod_fatura=<?php echo $row['cod_fatura']?>', 'search', 'status=no,scrollbars=yes,toolbar=no,left=900,height=400,width=500')">
      <div align="center" class="fontebranca12" style="cursor:pointer;">
       &nbsp;Enviar
	  </div>
	</td>
    
	<?php	
	
	}
	
	?>
	
	
    <?PHP

      $fetch = "<center><b>".addslashes($cd['razao_social']);
      if($row[cod_cliente] == "147"){
          $fetch .=  " UPV";
       }elseif($row[cod_cliente] == "148"){
          $fetch .= " UQMI";
       }elseif($row[cod_cliente] == "149"){
          $fetch .= " UQMII";
       }
      $fetch .= "</b></center>";
      $fetch .= "<p>";
      $fetch .= "<b>Endereço:</b> ".$cd[endereco]." Nº".$cd[num_end];
      $fetch .= "<br>";
      $fetch .= "<b>Telefone:</b> ".$cd[telefone];
      $fetch .= "<br>";
      $fetch .= "<b>E-mail:</b> ".$cd[email];
      if($cd[nome_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Pessoa de contato:</b> ".$cd[nome_contato_dir];
      }
      if($cd[cargo_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Cargo do contato:</b> ".$cd[cargo_contato_dir];
      }
      if($cd[tel_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Telefone do contato:</b> ".$cd[tel_contato_dir];
      }
      if($cd[email_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>E-mail do contato:</b> ".$cd[email_contato_dir];
      }
      if($cd[nextel_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Nextel do contato:</b> ".$cd[nextel_contato_dir];
      }
      if($cd[nextel_id_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Nextel id:</b> ".$cd[nextel_id_contato_dir];
      }

    ?>
    <td class="linhatopodiresq" id="col3<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="left" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row[pc];?>" onMouseOver="return overlib('<?PHP echo $fetch;?>');" onMouseOut="return nd();">
       &nbsp;<?php echo $cd['razao_social'];
       if($row[cod_cliente] == "147"){
          echo " UPV";
       }elseif($row[cod_cliente] == "148"){
          echo " UQMI";
       }elseif($row[cod_cliente] == "149"){
          echo " UQMII";
       }
       ?>
       </a>
	  </div>
	</td>

    <td class="linhatopodiresq" id="col4<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row[pc];?>">
       &nbsp;<?php if(!empty($row['data_vencimento'])){echo date("d/m/Y", strtotime($row['data_vencimento']));}else{ echo "N/D";} echo"</a><br><font size=1>"; if($dias_vencidos > 0 && !empty($row['data_vencimento'])){ echo "*vencido à ".$dias_vencidos." dia(s)<br>";} if(/*pg_num_rows($rv)*/$nfaturasvencidas>0){ echo ""./*pg_num_rows($rv)*/$nfaturasvencidas." fatura(s) vencida(s)."; /*print_r($ad);*/}echo "</font>";?>
	  </div>
	</td>

<!--
     <td class="linhatopodiresq">
	  <div align="center" class="linksistema">&nbsp;
	  </div>
	</td>
-->

    <!-- valor cobrado -->
	<td class="linhatopodiresq" id="col5<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row[pc];?>">
       &nbsp;<?php echo 'R$ '.number_format($total, 2, ',','.');?></a>
       <br>
       <?PHP if(/*pg_num_rows($rv)*/$nfaturasvencidas>0){echo "<font size=1>(R$".number_format($vv, 2, ',','.').")</font>";}?>
	  </div>
	</td>

    <!-- valor multa -->
	<td class="linhatopodiresq" id="col6<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row[pc];?>">
       &nbsp;<?php echo 'R$ '.number_format($multa, 2, ',','.');?></a><br>
       <?PHP if(/*pg_num_rows($rv)*/$nfaturasvencidas>0){ echo "<font size=1>(R$".number_format($mva, 2, ',','.').")</font>";}?>
	  </div>
	</td>
	
    <!-- valor juros -->
	<td class="linhatopodiresq" id="col7<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row[pc];?>">
       &nbsp;<?php echo 'R$ '.number_format($juros, 2, ',','.');?></a><br>
       <?PHP if(/*pg_num_rows($rv)*/$nfaturasvencidas>0){ echo "<font size=1>(R$".number_format($jva, 2, ',','.').")</font>";}?>
	  </div>
	</td>
    <?PHP
    if($dias_vencidos > 5){
          $color = '#7b0931';
    }elseif($dias_vencidos > 0 && $dias_vencidos <= 5 && empty($row['data_pagamento'])){
          $color = '#a59d1d';//'#7b7409';
    }else{
          $color = '#006633';
    }
    ?>
    <!-- valor total -->
	<td class="linhatopodiresq" bgcolor="<?PHP echo $color;?>" id="coltotal<?php echo $row['cod_fatura'];?>">
	  <div align="center" class="linksistema">
	   <a href="javascript:calcme('<?PHP echo $total;?>','<?PHP echo date("d/m/Y", strtotime($row['data_vencimento']));?>','<?PHP echo $row['razao_social'];?>');">
       &nbsp;<?php
           //
           if($dias_vencidos > 0){
              echo 'R$ '.number_format($total_geral = $total + $multa + ($juros * $dias_vencidos), 2,',','.');
           }else{
              echo 'R$ '.number_format($total, 2, ',','.');
           }
           echo "";

       ?></a> <br>
       <div align="center" class="linksistema" id="notificar<?PHP echo $row['cod_fatura'];?>">
       <?PHP
           if($nfaturasvencidas>0){
               echo "<font size=1>(R$".number_format($tvj, 2, ',','.').")</font>";
           }
           if($dias_vencidos >=20 && !$row[migrado]){
               echo "<BR>";
               if(empty($row[data_3_notificacao])){
       ?>
               <input type=button value="Notificar" name="btnNotificar<?PHP echo $row['cod_fatura'];?>" id="btnNotificar<?PHP echo $row['cod_fatura'];?>" onClick="notificar_protesto('<?PHP echo $row['cod_fatura'];?>');this.disabled=true;">
       <?PHP
               }else{
                   echo "<font size=1 color=white><i><b>[Notificado]</b></i></font>";
               }
           }
       ?>
       </div>
	  </div>
	</td>

    <!-- Enviado -->
    
    
    <td class="linhatopodiresq" bgcolor='<?PHP echo $bcolor;?>'>
    <form id='formulario' method='post' action="update_novototal.php?cod_fatura=<?php echo $row['cod_fatura'] ?>">
    <input type="text" name="novo_total" id="novo_total" size="5" value="<?php if($row['novo_valor']){echo number_format($row['novo_valor'], 2, ',','.');}?>" onKeyPress="return FormataReais(this, '.', ',', event);">
    <input type='submit' style="width:58" value='Gravar'>
    </form>
    </td>
    
   
    
    
	<td class="linhatopodiresq" id="col8<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="center" class="linksistema">
         <input type=checkbox name=enviado id=enviado onClick="check_planilha('<?PHP echo $row['cod_fatura'];?>')" <?PHP print $row['email_enviado'] == 1 ? " checked " : "" ?>>
	  </div>
	</td>

    <!-- Migrar -->
	<td class="linhatopodiresq" id="col9<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="center" class="linksistema" id="migrar<?PHP echo $row['cod_fatura'];?>">
	  <?PHP
	     if($row['migrado'] && $row['data_pagamento'] ){
	     echo "<center><font size=1 color=white><b>Migrado!</b></font></center>";
	     }else{
	  ?>
         <input type=button value="Migrar" name="btnMigrar<?PHP echo $row['cod_fatura'];?>" id="btnMigrar<?PHP echo $row['cod_fatura'];?>" onClick="migrar_planilha('<?PHP echo $row['cod_fatura'];?>', '<?PHP echo $dias_vencidos;?>');this.disabled=true;">
      <?PHP
         }
      ?>
	  </div>
	  <input type=hidden id="col11<?php echo $row['cod_fatura'];?>" value="<?PHP echo $row['tagged'];?>">
	</td>

    <!-- Pago
	<td class="linhatopodiresq">
	  <div align="center" class="linksistema" id="confirma<?PHP echo $row['cod_fatura'];?>">
	  <?PHP
	  /*
	     if($row['data_pagamento']){
	        echo "<center><font size=1 color=white><b>".date("d/m/Y", strtotime($row['data_pagamento']))."</b></font></center>";
	     }else{
      */
	  ?>
         <input type=button value="Pago" name="btnPagar<?PHP //echo $row['cod_fatura'];?>" id="btnPagar<?PHP //echo $row['cod_fatura'];?>" onclick="Pagar_planilha('<?PHP //echo $row['cod_fatura'];?>')">
      <?PHP
         //}
      ?>
	  </div>
	</td>

	-->
  </tr>
<?php
$i++;
  }//IF - REMOVE AS FATURAS VAZIAS
}//WHILE MAIN LOOP
$fecha = pg_close($connect);
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
<P>
<?PHP
   //echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font></center>";
   echo "<center><font size=2><a href=\"javascript:location.href='?m=$mes&y=".($ano-1)."'\" class=fontebranca12><<</a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>></a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?m=$mes&y=".($ano+1)."'\" class=fontebranca12>>></a></font></center>";
?>
<p>
<br>
<pre>








</pre>
<?PHP
    if($_GET[send_mail])
        echo "<script>alert('Foi enviado ao servidor um pedido de envio de e-mail em massa, que deve ser finalizado em breve!');</script>";
?>
</body>
</html>
