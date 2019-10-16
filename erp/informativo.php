<?PHP
session_start();
include("include/db.php");


 
    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html;charset=iso-8859-1\n";//"Content-type: multipart/mixed;";
    $headers .= 'From: SESMT <webmaster@sesmt-rio.com>' . "\n" .
    'Reply-To: webmaster@sesmt-rio.com' . "\n" .
    'X-Mailer: PHP/' . phpversion();

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
<p>
<br><p>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"70%\" align=\"center\" class=\"fontepreta12\"><br />
		  <span class=\"style2 fontepreta12\" style=\"font-size:14px;\">
Informamos através deste que a empresa SESMT, não terá expediente na próxima sexta-feira dia
12/06/2009.<p>
<br>
Atenciosamente,<p>

<b>Pedro Henrique</b><br>
<i>Diretor Executivo de Franchising</i>
          </span>
           </td>
	</tr>
</table></div>
<p>
<br><p>
<br><p>
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

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";


if($_GET['enviar']){
   $sql = "SELECT * FROM email_informativo WHERE enviado = '0'";
   $result = pg_query($sql);
   $buffer = pg_fetch_all($result);

   if(mail($buffer[0]['email'], "Informativo SESMT", $msg, $headers)){
      $sql = "UPDATE email_informativo SET enviado = '1' WHERE id = '{$buffer[0]['id']}'";
   }else{
      $sql = "UPDATE email_informativo SET enviado = '2' WHERE id = '{$buffer[0]['id']}'";
   }
   pg_query($sql);
   echo "E-mail enviado para: ".$buffer[0]['email'];
   echo "<meta http-equiv=\"refresh\" content=\"2;url=informativo.php?enviar=1\">";
}


if($_GET['insert']){
   $sql = "SELECT * FROM cliente_comercial";
   $result = pg_query($sql);
   $data = pg_fetch_all($result);
   
   for($x=0;$x<pg_num_rows($result);$x++){
      $sql = "SELECT * FROM email_informativo WHERE lower(email) = '".strtolower($data[$x]['email'])."'";
      $r = pg_query($sql);
      if(!empty($data[$x]['email'])){
         if(pg_num_rows($r)<=0){
            $sql = "INSERT INTO email_informativo
            (cod_cliente, email)
            VALUES
            ('{$data[$x]['cliente_id']}','{$data[$x]['email']}')";
            pg_query($sql);
            $a++;
         }
      }
   }
echo "<script>alert('Adicionados $a emails!');</script>";
}

echo $msg;
?>
