<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($tipo!=""){
$query_incluir="INSERT into diametro_mangueira (diametro_mangueira, descricao) values ('$tipo', '$descricao')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('Diâmetro Mangueira Incluído com Sucesso!');</script>";
header("location: diametro_mangueira_adm.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>
<title>Cadastro de Di&acirc;metro de Mangueira</title><body bgcolor="#006633">
<form action="diametro_mangueira_incluir.php" method="post" name="diametro_mangueira" id="diametro_mangueira">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Di&acirc;metro Mangueira </font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="157" class="fontebranca12">Di&acirc;metro Mangueira  </td>
            <td width="342"><input name="tipo" type="text" id="tipo" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Descri&ccedil;&atilde;o</td>
            <td><textarea name="descricao" cols="40" rows="5" class="camposform" id="descricao"></textarea></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Incluir"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

