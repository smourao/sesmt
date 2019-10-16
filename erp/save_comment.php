<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];
$titulo = addslashes($_GET['titulo']);
$mensagem = addslashes($_GET['mensagem']);

$sql = "SELECT * FROM cliente_comercial WHERE cliente_id = '{$cod_cliente}'";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);

$sql = "SELECT * FROM erp_simulador_message WHERE simulador_id = '{$cod_cliente}' AND mensagem = '{$mensagem}'";
$result = pg_query($sql);

   $sql = "INSERT INTO erp_simulador_message (razao_social, simulador_id, titulo, mensagem,
   data_criacao, data_modificacao) VALUES
   ('{$buffer[razao_social]}', '{$cod_cliente}', '{$titulo}', '{$mensagem}', '".date("Y-m-d")."', '".date("Y-m-d")."')";
   if(pg_query($sql)){
      echo $cod_cliente."|1";
   }
   
   
   	   $headers = "MIME-Version: 1.0\n";
       $headers .= "Content-type: text/html; charset=iso-8859-1\n";
       $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";

       $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
   <HTML>
   <HEAD>
      <TITLE>Informativo</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
<META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
<style type=\"text/css\">
td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style13 {font-size: 14px}
.style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.style16 {font-size: 9px}
.style17 {font-family: Arial, Helvetica, sans-serif}
.style18 {font-size: 12px}
</style>
   </HEAD>
   <BODY>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=0 cellspacing=0>
	<tr>
		<td align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=\"333\" height=\"180\" /></td>
		<td align=\"left\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style18>Serviços Especializados de Segurança e <br>
		  Monitoramento de Atividades no Trabalho ltda.</span>
		  </font><br><br>
		  <p class=\"style18\">
		  <p class=\"style18\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br>
		  <p>
</td>
	</tr>
</table></div>
<p>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"70%\" align=\"left\" class=\"fontepreta12\"><br />
		  <div class=\"style2 fontepreta12\" style=\"font-size:14px;\">
<center><u><strong>Atualização de Relatório de Atendimento</strong></u></center>
<p>
<br>
<table border=0 width=100%>
<tr>
<td width=100><b>Cód. Cliente:</b> </td><td>".$buffer[cliente_id]."</td>
</tr>
<tr>
<td><b>Razão Social:</b> </td><td>".$buffer[razao_social]."</td>
</tr>
<!--
<tr>
<td><b>Vendedor:</b> </td><td>".$quem."</td>
</tr>
-->
<tr>
<td><b>Atualizado:</b> </td><td>".date("d/m/Y H:i:s")."</td>
</tr>
</table>
<p>

<table border=0 width=100%>
<tr><td><b>Informações do atendimento:</b></td></tr>
<tr>
<td bgcolor='#d5d5d5'>".addslashes(nl2br($mensagem))."</td>
</tr>
</table>
          </div>
           </td>
	</tr>
</table></div>
<p>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
	<p>
		<tr>
		<td width=\"65%\" align=\"center\" class=\"fontepreta12 style2\">
		<br /><br /><br /><br /><br /><br />
		  <span class=\"style17\">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
          <p class=\"style17\">
		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
          www.sesmt-rio.com / www.shoppingsesmt.com<br />

	    </td>
		<td width=\"35%\" align=\"right\">
        <img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=\"280\" height=\"200\" /></td>
	</tr>
</table></div>
   </BODY>
</HTML>  ";
  mail("comercial@sesmt-rio.com", "SESMT - Relatório de atendimento - {$buffer[razao_social]}", $msg, $headers);


?>
