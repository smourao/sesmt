<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";

$query="select * from cipa";
/*
switch($grupo){

	case "administrador":
	break;

	default:
	header("location: index.php");
	break;
}

*/
$result=pg_query($query) or die("Erro na query: $query".pg_last_error($connect));

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista de Cipeiros</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script>
<!--
function enviar(opcao) {
	  if(opcao == 'E') {
	     document.forms[0].action = "cipa_excluir.php";
		 document.forms[0].target = "_self";
		 document.forms[0].submit();
      }
	  if(opcao == 'I') {
	     document.forms[0].action = "cipa_incluir.php";
		 document.forms[0].target = "_self";
		 document.forms[0].submit();
      }
	  }

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<form action="" method="post" name="riscos" id="riscos">
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>      <div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">CIPA</font></div></td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12"><br>
      <table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12"><input name="btn_incluir" type="submit" id="btn_incluir" value="Incluir" onClick="enviar('I')"></td>
        <td class="fontebranca12"><input name="btn_excluir" type="submit" id="btn_excluir" value="Excluir" onClick="enviar('E')"></td>
        <td class="fontebranca12"><input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="&lt;&lt; Voltar"></td>
      </tr>
      
    </table>
      <br></td>
  </tr>
  <tr>
    <td width="173" class="linhatopodiresq"><div align="center" class="fontebranca12">N?mero representante do Empregador</div></td>
    <td width="142" class="linhatopodir"><div align="center" class="fontebranca12">Grupo</div></td>
    <td width="154" class="linhatopodir"><div align="center" class="fontebranca12">numero de membro da cipa</div></td>
    <td width="31" class="linhatopodir">&nbsp;</td>
  </tr>
  <?php
  while($row=pg_fetch_array($result)){
  ?>
  <tr>
    <td class="linhatopodiresq"><div align="center" class="fontebranca10"><?=$row[numero_representante_empregador]?></div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca10">
      <?=$row[grupo]?>
    </div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca10">
      <?=$row[numero_membros_cipa]?>
    </div></td>
    <td class="linhatopodir"><input name="cipa_id[]" type="checkbox" id="cipa_id[]" value="<?=$row[cipa_id]?>"></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td class="linhatopodiresqbase">&nbsp;</td>
    <td class="linhatopodirbase">&nbsp;</td>
    <td class="linhatopodirbase">&nbsp;</td>
    <td class="linhatopodirbase">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
