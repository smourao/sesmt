<?php
include "../sessao.php";
include "../config/connect.php";

$query="select * from ventilacao_artificial order by cod_vent_art";
$result=pg_query($query) or die("Erro na query: $query".pg_last_error($connect));
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista de Tipo de Ventilação Artificial</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script>
<!--
function enviar(opcao) {
	  if(opcao == 'E') {
	     document.forms[0].action = "tipo_ventilacao_artificial_excluir.php";
		 document.forms[0].target = "_self";
		 document.forms[0].submit();
      }
	  if(opcao == 'I') {
	     document.forms[0].action = "tipo_ventilacao_artificial_incluir.php";
		 document.forms[0].target = "_self";
		 document.forms[0].submit();
      }
	  if(opcao == 'A') {
	     document.forms[0].action = "tipo_ventilacao_artificial_alterar.php";
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
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Tipo Ventila&ccedil;&atilde;o Artificial </font></div></td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12"><br>
      <table width="252" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12"><input name="btn_incluir" type="submit" id="btn_incluir" value="Incluir" onClick="enviar('I')"></td>
		<td class="fontebranca12"><input name="btn_alterar" type="submit" id="btn_alterar" value="Alterar" onClick="enviar('A')"></td>
	    <td class="fontebranca12"><input name="btn_excluir" type="submit" id="btn_excluir" value="Excluir" onClick="enviar('E')"></td>
        <td class="fontebranca12"><input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="&lt;&lt; Voltar"></td>
      </tr>
    </table>
      <br></td>
  </tr>
  <tr>
    <td width="90" class="linhatopodiresq"><div align="center" class="fontebranca12">Código</div></td>
    <td width="140" class="linhatopodir"><div align="center" class="fontebranca12">Tipo Ventilação Artificial </div></td>
    <td width="235" class="linhatopodir"><div align="center" class="fontebranca12">Descrição</div></td>
    <td width="31" class="linhatopodir">&nbsp;</td>
  </tr>
  <?php
  while($row=pg_fetch_array($result)){
  ?>
  <tr>
    <td class="linhatopodiresq"><div align="center" class="fontebranca10"><?=$row[cod_vent_art]?></div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca10"><?=$row[nome_vent_art]?></div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca10"><?=$row[decricao_vent_art]?></div></td>
    <td class="linhatopodir" align="center"><input name="cod_vent_art[]" type="checkbox" id="cod_vent_art[]" value="<?=$row[cod_vent_art]?>"></td>
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