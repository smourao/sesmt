<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";




?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema SESMT - Lista de e-mails Enviados</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?

if($_POST['enviar']>0){

	for($i=0; $i<count($arr); $i++){
	
		$arr[$i]."<br/>";
	}

}

?>
<form action="listagem_emails_enviar.php" method="post" enctype="multipart/form-data" name="form_emails" target="_self" id="form_emails">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="52" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
          <div align="center">
            <table width="136" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="center"><a href="tela_principal.php"><img src="img/icone_listagem_r2_c4.jpg" alt="s" width="32" height="42" border="0"></a></div></td>
              </tr>
            </table>
          </div>
      </div></td>
    </tr>
    <tr>
      <td class="linhatopodiresq"><div align="center" class="fontebranca22bold">
          <div align="center">Mensagem a ser enviada </div>
      </div></td>
    </tr>
    <tr>
      <td class="linhatopodiresq"><div align="left" class="fontebranca12">
        <label>
        <textarea name="conteudo" cols="80" rows="30" id="conteudo"></textarea>
        </label>
      </div>        </td>
    </tr>

    <tr>
      <td align="center" bgcolor="#009966" class="linhatopodiresqbase"><input name="brn_enviar" type="submit" id="brn_enviar" value="Enviar Mensagem">
      <input name="arr[]" type="hidden" id="arr[]" value="<?=$_POST['email']?><?=$_POST['arr']?>"></td>
    </tr>
  </table>
</form>
</body>
</html>
