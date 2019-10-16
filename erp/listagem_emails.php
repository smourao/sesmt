<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";

$query_fornecedores="select razao_social, email, cliente_id, status  from cliente order by razao_social";

/*
switch($grupo){

	case "administrador":
	break;

	case "cliente":
	$query_clientes.="where cliente_id=".$cliente_id."";
	break;

	case "funcionario_cliente":
	$query_clientes.="where cliente_id=".$cliente_id."";
	break;

	case "contador":
	$query_clientes.="where contador_id=".$contador_id."";
	break;

	default:
	//header("location: index.php");
	break;
}
*/
$result_fornecedores=pg_query($connect, $query_fornecedores) or die ("Erro na query: $query_fornecedores".pg_last_error($connect));

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema SESMT - Lista de E-mail</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form action="listagem_emails_enviar.php" method="post" enctype="multipart/form-data" name="form" target="_self" id="form">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="52" colspan="4" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
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
      <td colspan="4" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
          <div align="center">Registros no Sistema </div>
      </div></td>
    </tr>
    <tr>
      <td width="96" class="linhatopodiresq"><div align="left" class="fontebranca12">Status</div></td>
      <td class="linhatopodiresq"><span class="fontebranca12">Contato </span></td>
      <td width="179" class="linhatopodir"><div align="left" class="fontebranca12">Email</div></td>
      <td width="77" class="linhatopodir"><div align="left" class="fontebranca12">Selecionar</div></td>
    </tr>
    <?php
  while($row=pg_fetch_array($result_fornecedores)){
  ?>
    <tr>
      <td class="linhatopodiresq"><div align="left" class="linksistema"><?=$row['status']?></div></td>
      <td class="linhatopodiresq"><div align="left" class="linksistema"><?=$row[razao_social]?></div></td>
      <td class="linhatopodir"><div align="left" class="linksistema"><?=$row[email]?></div></td>
      <td class="linhatopodir"><div align="left" class="linksistema"><input name="email[]" type="checkbox" id="email[]" value="<?=$row[razao_social]?>">
      &nbsp;</div></td>
    </tr>
    <?php
  }
  ?>
    <tr>
      <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
      <td width="148" bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
      <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
      <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;
              <label>
              <input name="brn_enviar" type="submit" id="brn_enviar" value="Enviar Mensagem">
              </label>
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
