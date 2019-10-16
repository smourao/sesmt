<?php 
$destinatario = "suporte@sesmt-rio.com";
$assunto = $_POST['assunto'];

$msg = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<title>ASO</title>
<link href=\"../css_js/css.css\" rel=\"stylesheet\" type=\"text/css\">
<style type=\"text/css\">

td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style1 {font-size: 14px}
.style2 {font-size: 12px}
.style3 {font-family: Arial, Helvetica, sans-serif}
.style4 {font-size: 12}
.style5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #006633;
}
</style>
</head>
<body text=\"#000000\">";
$msg.="<center><h2><b>CORREIO ON-LINE</b></h2></center><p><p>";

$msg.='<center><img src="http://sesmt-rio.com/erp/2.0/images/natal_sesmt.jpg"></center>';

$msg.="</body></html>";

//para o envio em formato HTML
    $headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";

//endereço do remitente
$headers .= "From: Suporte <suporte@sesmt-rio.com>\n";
$dest="raylan@raylansoares.com";

//endereços que receberão uma copia oculta
$c = count($_POST['sel_email']);
$headers .= "Bcc: ";

for($i = 0; $i < $c; $i++) {
				 $headers .= "Contato <";
                 $headers .= $_POST['sel_email'][$i];
				 $headers .= ">, ";
				 }
$headers .= "$dest\n";
				 
	if(mail($destinatario, $assunto, $msg, $headers)){
        echo "<script>alert('Emails enviados com sucesso!');</script>";
		echo "<script>location.href=\"?dir=lista_contatos&p=index\";</script>";

    }else{
        echo "<script>alert('Erro ao enviar solicitação!');</script>";
		echo "<script>location.href=\"?dir=lista_contatos&p=index\";</script>";
    }
	             

?>


</head>
</html>